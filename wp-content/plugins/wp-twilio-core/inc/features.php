<?php
/**
 * New features can be added under this function
 * 
 */
function twl_new_features_tab( $tabs = array() ) {
    $tabs['newsletter_options'] = __( 'Newsletter Options', TWL_TD );
	$tabs['send_sms_newsletter'] = __( 'Send SMS Newsletter', TWL_TD );
    return $tabs;
}

/**
 * New widgets can be added under this function
 * 
 */
function twl_load_widgets() {
	require_once(TWL_PATH . 'inc/widgets/newsletter.php');
    register_widget( 'twl_newseletter_widget' );
}

function twl_display_tab_newsletter($tab, $page_url) {
	if( $tab != 'newsletter_options' ) {
        return;
    }
	require_once(TWL_PATH . 'inc/views/newsletter.php');
}

function twl_display_tab_send_sms($tab, $page_url) {
	if( $tab != 'send_sms_newsletter' ) {
        return;
    }
	require_once(TWL_PATH . 'inc/views/send_sms_newsletter.php');
}

function twl_create_subscriber() {

	$labels = array(
        'name'                  => __( 'Subscriber', TWL_TD ),
        'singular_name'         => __( 'Subscriber', TWL_TD),
        'menu_name'             => __( 'Subscribers', TWL_TD),
        'name_admin_bar'        => __( 'Subscriber', TWL_TD),
        'add_new'               => __( 'Add New', TWL_TD ),
        'add_new_item'          => __( 'Add New Subscriber', TWL_TD ),
        'new_item'              => __( 'New Subscriber', TWL_TD ),
        'edit_item'             => __( 'Edit Subscriber', TWL_TD ),
        'view_item'             => __( 'View Subscriber', TWL_TD ),
        'all_items'             => __( 'All Subscribers', TWL_TD ),
        'search_items'          => __( 'Search Subscribers', TWL_TD ),
        'not_found'             => __( 'No subscribers found.', TWL_TD ),
        'not_found_in_trash'    => __( 'No subscribers found in Trash.', TWL_TD ),
        'filter_items_list'     => __( 'Filter subscribers list', TWL_TD ),
        'items_list_navigation' => __( 'Subscribers list navigation', TWL_TD ),
        'items_list'            => __( 'Subscribers list', TWL_TD ),
    );

	$args = [
		'public' => true,
		'label'  => 'Subscriber',
		'labels'             => $labels,
		'show_in_menu' => false,
		'view_item'          => __( 'View Subscriber' ),
		'supports' => ['title', 'custom-fields'],
	];
    register_post_type( 'twl_subscriber', $args );
}


function twl_create_subscriber_category() {
	register_taxonomy(
		'twl_groups',
		'twl_subscriber',
		array(
			'label' => __( 'Groups' ),
			'hierarchical' => true,
		)
	);
}

function save_twl_newsletter_data()
{
	$subscribed = twl_check_subscription($_POST["twl_sms_number"]);

	$options = get_option( TWL_CORE_NEWSLETTER_OPTION );
	if($options)
	{
		$options = wp_parse_args($options,twl_get_newsletter_defaults());
	}
	else
	{
		$options = twl_get_newsletter_defaults();
	}

	if($_POST["twl_sms_subscribe"]==1)
	{
		
		if($subscribed)
		{
			$message = __( 'You are already subscribed!', TWL_TD );
			echo json_encode(array("message"=>$message,"status"=>1));
			wp_die();
		}

		if(!$options['verify_subscriber_cb'])
		{
			
			$twl_post = array(
				'post_title'    => wp_strip_all_tags( $_POST['twl_sms_name'] ),
				'post_type'		=> "twl_subscriber",
				'post_status'   => 'publish',
				'meta_input'   => array(
					'twl_sms_number' => $_POST["twl_sms_number"],
				)
			);

		}
		else
		{
			$twl_verification_code = mt_rand(1000,9999);
			$twl_post = array(
				'post_title'    => wp_strip_all_tags( $_POST['twl_sms_name'] ),
				'post_type'		=> "twl_subscriber",
				'meta_input'   => array(
					'twl_sms_number' => $_POST["twl_sms_number"],
					'twl_sms_code' => $twl_verification_code,
				)
			);
		}

		// Insert the post into the database
		$post_id = wp_insert_post( $twl_post );

		if(!empty($_POST["twl_groups"]))
		{
			$taxonomy = 'twl_groups';
			$term_id = array( $_POST["twl_groups"] );
			wp_set_object_terms($post_id, $term_id, $taxonomy);
		}
		if($options['verify_subscriber_cb'])
		{
			$verificatoin_message = "Your confirmation code is: $twl_verification_code";
			twl_send_sms(array("message"=>$verificatoin_message,"number_to"=>$_POST["twl_sms_number"]));
			$message = __( 'A code was sent to your mobile number.<br /> To confirm your subscription paste the code below!', TWL_TD );
			$status = 2;
		}
		else
		{
			if($options['welcome_sms_cb'])
			{
			
				$welcome_message = twl_replace_newsletter_sms_variables($options['welcome_sms_message'],$post_id);
				twl_send_sms(array("message"=>$welcome_message,"number_to"=>$_POST["twl_sms_number"]));
			}
			$message .= __( 'You are now subscribed to our news letter!', TWL_TD );
			$status = 1;
		}
			

		echo json_encode(array("message"=>$message,"twl_post_id"=>$post_id,"status"=>$status));
		wp_die();
		
	}
	else
	{
		if(!$subscribed)
		{
			$message = __( 'You are already un-subscribed!', TWL_TD );
			echo json_encode(array("message"=>$message,"status"=>1));
			wp_die();
		}

		wp_delete_post($subscribed);
		$message = __( 'You are now un-subscribed from our news letter!', TWL_TD );
		echo json_encode(array("message"=>$message,"status"=>1));
		wp_die();
	}

	wp_die();
}

function twl_check_subscription($number)
{
	$twl_args = array(
	'post_type' => 'twl_subscriber',
	'post_status'   => 'publish',
	'meta_query' => array(
			array(
				'key' => 'twl_sms_number',
				'value' => $number
			)
		)
	);

	$twl_query = new WP_Query( $twl_args );

	if($twl_query->have_posts())
	{
		while ( $twl_query->have_posts() ) {
			$twl_query->the_post();
			return get_the_id();
		}
	}
	else
	{
		return false;
	}
}

function save_twl_newsletter_confirmation_data()
{

	$options = get_option( TWL_CORE_NEWSLETTER_OPTION );
	if($options)
	{
		$options = wp_parse_args($options,twl_get_newsletter_defaults());
	}
	else
	{
		$options = twl_get_newsletter_defaults();
	}

	$code = $_POST['twl_sms_code'];
	$post_id = $_POST['twl_post_id'];
	$twl_args = array(
	'post_type' => 'twl_subscriber',
	'p'   => $post_id,
	'meta_query' => array(
			'relation' => 'AND',
			array(
				'key' => 'twl_sms_code',
				'value' => $code
			)
		)
	);

	$twl_query = new WP_Query( $twl_args );

	if($twl_query->have_posts())
	{
		wp_update_post(array(
			'ID'    =>  $post_id,
			'post_status'   =>  'publish'
		));

		if($options['welcome_sms_cb'])
		{
			$twl_sms_number = get_post_meta($post_id,'twl_sms_number');
			$welcome_message = twl_replace_newsletter_sms_variables($options['welcome_sms_message'],$post_id);
			twl_send_sms(array("message"=>$welcome_message,"number_to"=>$twl_sms_number[0]));
		}
		$message = __( 'You are now subscribed to our news letter!', TWL_TD );
		echo json_encode(array("message"=>$message,"status"=>1));
	}
	else
	{
		
		$message = __( 'Invalid confirmation code!', TWL_TD );
		echo json_encode(array("message"=>$message,"status"=>2));
		
	}

	wp_die();
}

function twl_newsletter_shortcode( $atts, $content = null ) {
	ob_start();
	if ( ! empty( $atts['title'] ) )
		echo $atts['title'];
	require(TWL_PATH . 'inc/views/newsletter_form.php');
	return ob_get_clean();
}

function twl_newsletter_cron_schedules($schedules){
    if(!isset($schedules["1min"])){
        $schedules["1min"] = array(
            'interval' => 1*60,
            'display' => __('Once every minute'));
    }
    return $schedules;
}


function twl_schedule_newsletter_cron(){
	
    wp_schedule_event(time(), '1min', 'twl_process_bulk_newsletter_sms_action');
}

function twl_admin_styles() {
  wp_enqueue_style( 'twl-flatpickr-style' , '//cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css');
 
}

function twl_admin_scripts() {
 
  wp_enqueue_script( 'twl-flatpickr-script','//cdn.jsdelivr.net/npm/flatpickr' );
}

// Add filters and actions
add_filter( 'twl_settings_tabs', 'twl_new_features_tab' );
add_action( 'twl_display_tab', 'twl_display_tab_newsletter', 10, 2);
add_action( 'twl_display_tab', 'twl_display_tab_send_sms', 10, 2);
add_action( 'widgets_init', 'twl_load_widgets' );
add_action( 'init', 'twl_create_subscriber_category' );
add_action( 'init', 'twl_create_subscriber' );
add_action("wp_ajax_save_twl_newsletter_data", "save_twl_newsletter_data");
add_action("wp_ajax_nopriv_save_twl_newsletter_data", "save_twl_newsletter_data");
add_action("wp_ajax_save_twl_newsletter_confirmation_data", "save_twl_newsletter_confirmation_data");
add_action("wp_ajax_nopriv_save_twl_newsletter_confirmation_data", "save_twl_newsletter_confirmation_data");
add_shortcode( 'TWL_NEWSLETTER', 'twl_newsletter_shortcode' );
add_filter('cron_schedules','twl_newsletter_cron_schedules');

if(!wp_next_scheduled('twl_process_bulk_newsletter_sms_action')){
    add_action('init', 'twl_schedule_newsletter_cron');
}
add_action( 'twl_process_bulk_newsletter_sms_action', 'twl_process_bulk_newsletter_sms',10);
add_action('admin_print_styles', 'twl_admin_styles');
add_action('admin_enqueue_scripts', 'twl_admin_scripts');
?>