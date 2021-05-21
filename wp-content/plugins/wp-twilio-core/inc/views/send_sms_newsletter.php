<?php
	if(isset($_POST["twl_send_to"]))
	{
		$response = twl_send_bulk_newsletter_sms( stripslashes_deep( $_POST ) );

		if( is_wp_error( $response ) ) 
		{
			printf( '<div class="error"> <p> %s </p> </div>', esc_html( $response->get_error_message() ) );
			extract( $_POST );
		} 
		else 
		{
			if(isset($_POST["twl_schedule_message"]) && $_POST["twl_schedule_message"]==1 && !empty($_POST["twl_schedule_date_time"]))
			{
				echo( '<div class="updated settings-error notice is-dismissible"> <p> Successfully Scheduled! </p> </div>');
			}
			else
			{
				printf( '<div class="updated settings-error notice is-dismissible"> <p> Successfully Sent! Message SID: <strong>%s</strong> </p> </div>', esc_html( $response->sid ) );
			}
			
		}
	}
	$options = twl_get_options();
	
	$options = wp_parse_args( $options, twl_get_defaults() );
		
	$account_credits = 0;
	$twl_show_error = false;

	if(!empty($options['account_sid']) && !empty($options['auth_token']))
	{
		if(empty($options['service_id']))
		{
			$twl_show_error = true;
		}
		$client = new Twilio\Rest\Client( $options['account_sid'], $options['auth_token'] );

		
		$account = $client->api->v2010->accounts($options['account_sid'])->fetch();
                              
		if(isset($account))
		{
			$balance = $account->balance->fetch();
			if($balance)
			{
				$account_credits = $balance->balance;
			}
		}
	}
	else
	{
		$twl_show_error = true;
	}


	$groups = get_terms( array(
		'taxonomy' => 'twl_groups',
		'hide_empty' => true,
	));

	$users = get_users(array(
		'meta_key' => 'mobile_number',
		'meta_compare'  =>  '!=',
		'meta_value' => ''
	));

	$count_obj = count_users();
	$roles = $count_obj['avail_roles'];

	$subscribers = get_posts( array(
		'post_type' => 'twl_subscriber',
		'numberposts' => -1
	));

	if($twl_show_error)
	{
		echo '<div class="error settings-error notice"> <span> The main settings aren\'t set properly , In order to use SMS Newsletter, You must fill the Account SID, Auth Token, and Service ID. <a href="'.admin_url('admin.php?page=twilio-options').'">Click here</a> to make the changes</p> </div>';
		
	}
?>
<form method="post">
<h3><?php _e( 'Send SMS', TWL_TD ); ?></h3>
<table class="form-table">
		<tr valign="top">
			<th scope="row"><?php _e( 'Send from', TWL_TD ); ?></th>
			<td>
				<input type="text" name="twl_from_number" placeholder="<?php _e( 'Enter Send from number', TWL_TD ); ?>" value="" class="regular-text" />
				<p><?php _e( 'If it\'s empty, the main settings\' number will be used.', TWL_TD ); ?></p>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e( 'Send to', TWL_TD ); ?></th>
			<td>
				<select id="twl_send_to" name="twl_send_to">
					<option value="twl_groups"><?php _e( 'Groups', TWL_TD ); ?></option>
					<option value="twl_users"><?php _e( 'Wordpress Users', TWL_TD ); ?></option>
					<option value="twl_roles"><?php _e( 'Roles', TWL_TD ); ?></option>
					<option value="twl_subscribers"><?php _e( 'Subscribers', TWL_TD ); ?></option>
					<option value="twl_custom_numbers"><?php _e( 'Custom Numbers', TWL_TD ); ?></option>
				</select>

				<select id="twl_groups" name="twl_groups" class="sendToSelect">
					<option value="all"><?php _e( 'Select All', TWL_TD ); ?></option>
				<?php
					if(count($groups))
					{
				?>
					
				<?php
						foreach($groups as $group)
						{
				?>
							<option value="<?php echo $group->slug; ?>"><?php echo $group->name; ?>(<?php echo $group->count; ?>)</option>
				<?php
						}
					}
				?>
				</select>
				
				<select style="display:none;" id="twl_users" name="twl_users" class="sendToSelect">
					<option value="all"><?php _e( 'Select All', TWL_TD ); ?></option>
				<?php
					if(count($users))
					{
				?>
					
				<?php
						foreach($users as $user)
						{
				?>
							<option value="<?php echo $user->ID; ?>"><?php echo $user->user_login; ?></option>
				<?php
						}
					}
				?>
				</select>
					
				<select style="display:none;" id="twl_roles" name="twl_roles" class="sendToSelect">
					<option value="all"><?php _e( 'Select All', TWL_TD ); ?></option>
							
				<?php
					if(count($roles))
					{
						foreach($roles as $slug => $role_count)
						{
				?>
							<option value="<?php echo $slug; ?>"><?php echo ucfirst($slug); ?>(<?php echo $role_count; ?>)</option>
				<?php
						}
					}
				?>
				</select>
				
				<select style="display:none;" id="twl_subscribers" name="twl_subscribers" class="sendToSelect">
					<option value="all"><?php _e( 'Select All', TWL_TD ); ?></option>
							
				<?php
					if(count($subscribers))
					{
						foreach($subscribers as $subscriber)
						{
				?>
							<option value="<?php echo $subscriber->ID; ?>"><?php echo $subscriber->post_title; ?></option>
				<?php
						}
					}
				?>
				</select>
				<input style="display:none;" type="text" id="twl_custom_numbers" name="twl_custom_numbers" class="regular-text sendToSelect" placeholder="<?php _e( 'Enter custom numbers saperated by comas', TWL_TD ); ?>"/>
				<p><?php _e( 'Select the list of subscribers.', TWL_TD ); ?></p>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e( 'Message', TWL_TD ); ?></th>
			<td>
				<textarea name="twl_message_box" id="twl_message_box" class="regular-text" style="display:block;" required></textarea>
				<p><span id="currentLengthSpan">0 </span><?php _e( ' characters', TWL_TD ); ?></p>
			</td>
		</tr>
		<tr valign="top">
				<th scope="row"><?php _e( 'Twilio Account Credit', TWL_TD ); ?></th>
				<td>
					<?php echo $account_credits; ?>
				</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e( 'Schedule Message', TWL_TD ); ?></th>
			<td>
				<input type="checkbox" id="twl_schedule_message" name="twl_schedule_message" value="1" />
			</td>
		</tr>

		<tr valign="top" id="twl_schedule_date_time_tr" style="display:none;">
				<th scope="row"><?php _e( 'Set Date/Time', TWL_TD ); ?></th>
				<td>
					<input type="text" id="twl_schedule_date_time" name="twl_schedule_date_time" placeholder="<?php _e( 'Enter Date/Time', TWL_TD ); ?>" value="<?php echo current_time("mysql"); ?>" class="regular-text" />
					
				</td>
		</tr>
			
		
		
		
		
</table>
<input name="submit" type="submit" class="button-primary" value="<?php _e( 'Send SMS', TWL_TD ) ?>" />
</form>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$("#twl_send_to").on("change",function(){
			$(".sendToSelect").hide();
			$("#"+$(this).val()).fadeIn("slow");
		});

		$('#twl_message_box').on("input", function(){
			var currentLength = $(this).val().length;
			$("#currentLengthSpan").html(currentLength);
		});

		$("#twl_schedule_message").on("change",function(){
			if ($(this).is(":checked"))
			{
				$("#twl_schedule_date_time_tr").fadeIn("slow");
			}
			else
			{
				$("#twl_schedule_date_time_tr").fadeOut("slow");
			}
				
			
			
		});

		$('#twl_schedule_date_time').flatpickr({minDate: "today", enableTime: true, dateFormat: "Y-m-d H:i"});
		
	});

	
</script>