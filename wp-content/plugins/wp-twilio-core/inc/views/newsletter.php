<?php
	$options = get_option( TWL_CORE_NEWSLETTER_OPTION );
	if($options)
	{
		$options = wp_parse_args($options,twl_get_newsletter_defaults());
	}
	else
	{
		$options = twl_get_newsletter_defaults();
	}
	
?>
<form method="post" action="options.php">
<h3><?php _e( 'Main Settings', TWL_TD ); ?></h3>
<table class="form-table">
		<tr valign="top">
			<th scope="row"><?php _e( 'Show Groups', TWL_TD ); ?></th>
			<td>
				<input type="checkbox" name="<?php echo TWL_CORE_NEWSLETTER_OPTION;?>[show_groups_cb]" value="1" <?php checked( $options['show_groups_cb'], 1, true ); ?> />
				<span><?php _e( 'Display groups option on the Newsletter form', TWL_TD ); ?></p>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e( 'Verify Subscriber', TWL_TD ); ?></th>
			<td>
				<input type="checkbox" name="<?php echo TWL_CORE_NEWSLETTER_OPTION;?>[verify_subscriber_cb]" value="1" <?php checked( $options['verify_subscriber_cb'], 1, true ); ?> />
				<span><?php _e( 'Subscribers recieve codes to verify their subscriptions to the newsletter', TWL_TD ); ?></span>
			</td>
		</tr>
</table>
<hr />
<h3><?php _e( 'Welcome SMS', TWL_TD ); ?></h3>
<table class="form-table">
		<tr valign="top">
			<th scope="row"><?php _e( 'Enable', TWL_TD ); ?></th>
			<td>
				<input type="checkbox" name="<?php echo TWL_CORE_NEWSLETTER_OPTION;?>[welcome_sms_cb]" value="1" <?php checked( $options['welcome_sms_cb'], 1, true ); ?> />
				<span><?php _e( 'Send Welcome SMS to subscribers', TWL_TD ); ?></span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e( 'Welcome Text', TWL_TD ); ?></th>
			<td>
				<textarea name="<?php echo TWL_CORE_NEWSLETTER_OPTION;?>[welcome_sms_message]" class="regular-text" style="display:block;"><?php echo $options['welcome_sms_message']; ?></textarea>
				<p><?php _e( 'Short tags: Name: %subscriber_name%, Mobile Number: %subscriber_number%', TWL_TD ); ?></p>
			</td>
		</tr>
</table>
<hr>
<h3><?php _e( 'Newsletter Form', TWL_TD ); ?></h3>
<table class="form-table">
		<tr valign="top">
				<th scope="row"><?php _e( 'Name Place Holder', TWL_TD ); ?></th>
				<td>
					<input type="text" name="<?php echo TWL_CORE_NEWSLETTER_OPTION; ?>[name_place_holder]" placeholder="<?php _e( 'Enter Name Place Holder', TWL_TD ); ?>" value="<?php echo htmlspecialchars( $options['name_place_holder'] ); ?>" class="regular-text" />
				</td>
		</tr>
		<tr valign="top">
				<th scope="row"><?php _e( 'Number Place Holder', TWL_TD ); ?></th>
				<td>
					<input type="text" name="<?php echo TWL_CORE_NEWSLETTER_OPTION; ?>[number_place_holder]" placeholder="<?php _e( 'Enter Number Place Holder', TWL_TD ); ?>" value="<?php echo htmlspecialchars( $options['number_place_holder'] ); ?>" class="regular-text" />
				</td>
		</tr>
		<tr valign="top">
				<th scope="row"><?php _e( 'Confirmation Text', TWL_TD ); ?></th>
				<td>
					<input type="text" name="<?php echo TWL_CORE_NEWSLETTER_OPTION; ?>[confirmation_text]" placeholder="<?php _e( 'Enter Confirmation Text', TWL_TD ); ?>" value="<?php echo htmlspecialchars( $options['confirmation_text'] ); ?>" class="regular-text" />
				</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e( 'Enable GDPR', TWL_TD ); ?></th>
			<td>
				<input type="checkbox" name="<?php echo TWL_CORE_NEWSLETTER_OPTION;?>[enable_gdpr_cb]" value="1" <?php checked( $options['enable_gdpr_cb'], 1, true ); ?> />
				<span><?php _e( 'Display GDPR checkbox', TWL_TD ); ?></span>
			</td>
		</tr>
		<tr valign="top">
				<th scope="row"><?php _e( 'GDPR Agreement', TWL_TD ); ?></th>
				<td>
					<input type="text" name="<?php echo TWL_CORE_NEWSLETTER_OPTION; ?>[gdpr_agreement]" placeholder="<?php _e( 'Enter GDPR Agreement Text', TWL_TD ); ?>" value="<?php echo htmlspecialchars( $options['gdpr_agreement'] ); ?>" class="regular-text" />
					<p><?php _e( 'Display short text for GDPR option', TWL_TD ); ?></p>
				</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e( 'Disable Style', TWL_TD ); ?></th>
			<td>
				<input type="checkbox" name="<?php echo TWL_CORE_NEWSLETTER_OPTION;?>[disable_styles_cb]" value="1" <?php checked( $options['disable_styles_cb'], 1, true ); ?> />
				<span><?php _e( 'Display plugin\'s css styles of the form', TWL_TD ); ?></span>
			</td>
		</tr>
		
	
		<tr class="notices" valign="top">
				<th scope="row"><?php _e( 'How to use', TWL_TD ); ?></th>
				<td>
				<p><b><?php _e( '1/ PHP CODE:', TWL_TD ); ?></b></p>
				<?php _e( 'Copy/paste this code inside themes file of your wordpress site.', TWL_TD ); ?></p>
				<b><?php _e( 'echo do_shortcode("[TWL_NEWSLETTER title=\'Newsletter\']");', TWL_TD ); ?></b></p>
				<br>
				<p><b><?php _e( '2/ Short Code', TWL_TD ); ?></b></p>
				<?php _e( 'Copy/paste this Shortcode into your blog posts or page;', TWL_TD ); ?>
				<a href="javascript:void(0)" id="twl_copy_shortcode" class="wp-menu-image dashicons-before dashicons-editor-paste-text"><?php _e( 'Click to copy', TWL_TD ); ?></a></p>
				<br>
				
				<p><b><?php _e( '3/ Widget:', TWL_TD ); ?></b></p>
				<p><?php _e( 'Go to Widgets=>Place the newsletter form widget in any sidebar of your website. ', TWL_TD ); ?></p>				
					
				</td>
		</tr>
		
</table>
<?php settings_fields( TWL_CORE_NEWSLETTER_SETTING ); ?>
<input name="submit" type="submit" class="button-primary" value="<?php _e( 'Save Changes', TWL_TD ) ?>" />
</form>


<script type="text/javascript">
	jQuery(document).ready(function($) {
		
		$("#twl_copy_shortcode").on("click",function(){
			 var $temp = $("<input>");
			$("body").append($temp);
			$temp.val('[TWL_NEWSLETTER title=\'Newsletter\']').select();
			document.execCommand("copy");
			$temp.remove();
		});

		
	});
</script>