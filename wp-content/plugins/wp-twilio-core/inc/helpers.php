<?php

function twl_get_newsletter_defaults() {
	$twl_newsletter_defaults = array(
		'show_groups_cb' 		=> 0,
		'verify_subscriber_cb' 		=> 0,
		'welcome_sms_cb' 		=> 0,
		'welcome_sms_message' 		=> '',
		'name_place_holder' 		=> '',
		'number_place_holder' 		=> '',
		'confirmation_text' 		=> '',
		'enable_gdpr_cb' 		=> 0,
		'gdpr_agreement' 		=> '',
		'disable_styles_cb' 		=> 0,
	);
	return apply_filters( 'twl_get_newsletter_defaults', $twl_newsletter_defaults );	
}

function twl_send_bulk_newsletter_sms( $args ) {
	
	$args = (array)$args;
	if(isset($args["twl_schedule_message"]) && $args["twl_schedule_message"]==1 && !empty($args["twl_schedule_date_time"]))
	{
		return twl_schedule_bulk_newsletter_sms($args);
	}
	$sms_users = array();
	$args['message'] = $message = $args['twl_message_box'];
	
	if(!empty($_POST['twl_from_number']))
	{
		$args['number_from'] = $_POST['twl_from_number'];
	}

	$options = twl_get_options();
	$options = wp_parse_args( $options, twl_get_defaults() );

	$args = wp_parse_args( $args, $options );
	
	switch($args['twl_send_to'])
	{
		case 'twl_groups':
			if($args['twl_groups']=='all')
			{
				$twl_query = new WP_Query( array(
					'post_type' => 'twl_subscriber',
					'post_status'   => 'publish'
				));				
			}
			else
			{
				$twl_query = new WP_Query( array(
					'post_type' => 'twl_subscriber',
					'post_status'   => 'publish',
					'tax_query' => array(
						array (
							'taxonomy' => 'twl_groups',
							'field' => 'slug',
							'terms' => $args['twl_groups'],
						)
					),
				));
			}
			
			if($twl_query->have_posts())
			{
				$binding = array();
				$receipts = array();
				while ( $twl_query->have_posts() ) {
					$twl_query->the_post();
					$mobile_number = get_post_meta(get_the_id(),'twl_sms_number');
					$mobile_number = $mobile_number[0];
					$binding [] = '{"binding_type":"sms", "address":"'.$mobile_number.'"}';
					$receipts[] = $mobile_number;
					
				}
				
			}
			break;
		case 'twl_users':
				if($args['twl_users']=='all')
				{
					$users = get_users(array(
						'meta_key' => 'mobile_number',
						'meta_compare'  =>  '!=',
						'meta_value' => ''
					));

					if(count($users)>0)
					{
						$binding = array();
						$receipts = array();
						foreach ( $users as $userid) {
							$mobile_number = get_the_author_meta("mobile_number", $userid->ID);
							$binding[] = '{"binding_type":"sms", "address":"'.$mobile_number.'"}';
							$receipts[] = $mobile_number;
						}
						$args['number_to']= implode(',',$receipts);
					}
				}
				else
				{
					$binding = array();
					$receipts = array();
					$mobile_number = get_the_author_meta("mobile_number", $args['twl_users']);
					$binding[] = '{"binding_type":"sms", "address":"'.$mobile_number.'"}';
					$receipts[] = $mobile_number;
					
				}
			break;
		case 'twl_roles':
				if($args['twl_roles']=='all')
				{
				
					$users_args = array(
					'meta_query'    => array(
					'relation'  => 'AND',
						array( 
							'key'     => 'mobile_number',
							'value'   => '',
							'compare' => '!='
						)
					)

					);
				}
				else
				{
					$users_args = array(
					'role'          => $args['twl_roles'],
					'fields' => 'ID',
					'meta_query'    => array(
					'relation'  => 'AND',
						array( 
							'key'     => 'mobile_number',
							'value'   => '',
							'compare' => '!='
						)
					)
					);
				}
				
				$blogusers = get_users($users_args);
				
				if(count($blogusers)>0)
				{
					$binding = array();
					$receipts = array();
					foreach ( $blogusers as $userid) {
						$mobile_number = get_the_author_meta("mobile_number", $userid);
						$binding [] = '{"binding_type":"sms", "address":"'.$mobile_number.'"}';
						$receipts [] = $mobile_number;
					}
					
				}
			break;
		case 'twl_subscribers':
			if($args['twl_subscribers']=='all')
			{
				$twl_query = new WP_Query( array(
					'post_type' => 'twl_subscriber',
					'post_status'   => 'publish'
				));				
			}
			else
			{
				$twl_query = new WP_Query( array(
					'post_type' => 'twl_subscriber',
					'post_status'   => 'publish',
					'p'   => $args['twl_subscribers'],
				));
			}

			if($twl_query->have_posts())
			{
				$binding = array();
				$receipts = array();
				while ( $twl_query->have_posts() ) {
					$twl_query->the_post();
					$mobile_number = get_post_meta(get_the_id(),'twl_sms_number');
					$mobile_number = $mobile_number[0];
					$binding[] = '{"binding_type":"sms", "address":"'.$mobile_number.'"}';
					$receipts[] = $mobile_number;
					
				}
				
			}
			break;
		case 'twl_custom_numbers':
				if($args['twl_custom_numbers']!='')
				{
					$blogusers = explode(',',$args['twl_custom_numbers']);

					$binding = array();
					$receipts = array();
					foreach ( $blogusers as $mobile_number) {
						$binding[] = '{"binding_type":"sms", "address":"'.$mobile_number.'"}';
						$receipts[] = $mobile_number;
					}
					
				}
			break;
			
	}

	if(!isset($receipts) || count($receipts)==0)
	{
		return new WP_Error( 'missing-details', __( 'No subscribers found matching the given criteria.', TWL_TD ) );
	}
	$args['number_to']= implode(',',$receipts);
	$log = twl_validate_sms_args( $args );
	
	if( !$args['service_id'] ) {
		$log .= twl_log_entry_format( __( '****** Missing Service ID ******', TWL_TD ), $args );
	}

	if( !$log ) {
		extract( $args );

		

		$client = new Twilio\Rest\Client( $account_sid, $auth_token );

		try {
			$response = $client->notify->services($service_id)->notifications->create(["toBinding" => $binding,"body" => $message]);
			//$response = $client->messages->create( $number_to, array( 'from' => $number_from, 'body' => $message ) );
			$log = twl_log_entry_format( sprintf( __( 'Success! Message SID: %s', TWL_TD ), $response->sid ), $args );
			$return = $response;
		} catch( \Exception $e ) {
			$log = twl_log_entry_format( sprintf( __( '****** API Error: %s ******', TWL_TD ), $e->getMessage() ), $args );
			$return = new WP_Error( 'api-error', $e->getMessage(), $e );
		}

	} else {
		$return = new WP_Error( 'missing-details', __( 'Some details are missing. Please make sure you have added all details in the settings tab.', TWL_TD ) );
	}
	twl_update_logs( $log, $args['logging'] );
	return $return;
}

function twl_schedule_bulk_newsletter_sms($args)
{
	global $wpdb;
	unset($args['twl_schedule_message']);
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	$sql="
		CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."twl_newsletter_logs`
		(
		id bigint(20) NOT NULL auto_increment,
		request_payload text default NULL,
		response_payload text default NULL,
		request_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		request_status int(1) default 0,
		PRIMARY KEY  (`id`)
	);";
	dbDelta($sql);

	$wpdb->insert( 
		$wpdb->prefix."twl_newsletter_logs", 
		array( 
			'request_payload' => json_encode($args), 
			'request_time' => $args['twl_schedule_date_time'] 
		), 
		array( 
			'%s', 
			'%s' 
		) 
	);
}

function twl_process_bulk_newsletter_sms()
{
	global $wpdb;
	$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}twl_newsletter_logs WHERE request_status = 0 and request_time<='".current_time( 'mysql' )."'", ARRAY_A );
	
	if($wpdb->num_rows)
	{
		foreach($results as $result)
		{
			$response = twl_send_bulk_newsletter_sms(json_decode($result['request_payload']));
			
			if( is_wp_error( $response ) ) 
			{
				$response_payload =  esc_html( $response->get_error_message() );
			}
			else
			{
				$response_payload = esc_html( $response->sid );
			}
			$wpdb->update( 
				$wpdb->prefix."twl_newsletter_logs", 
					array( 
					'response_payload' => $response_payload, 
					'request_status' => 1 
					),
					array( 'id' => $result['id'] ), 
					array( 
						'%s', 
						'%d' 
					), 
					array( '%d' ) 
			);
		}
	}
}
?>