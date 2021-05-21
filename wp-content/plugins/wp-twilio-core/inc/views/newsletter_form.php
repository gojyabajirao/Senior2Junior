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

$class="class='twl_newsletter_widget'";

if($options["disable_styles_cb"])
{
	$class="";
}
$form_id = rand(1,time());
?>
<div <?php echo $class; ?>>
			<form name="twl_sms_form_<?php echo $form_id; ?>" id="twl_sms_form_<?php echo $form_id; ?>">
				<div>
					<label for="twl_sms_name"><?php echo htmlspecialchars( $options['name_place_holder'] ); ?></label>
					<input type="text" name="twl_sms_name" id="twl_sms_name" required/>
				</div>
				<div>
					<label for="twl_sms_number"><?php echo htmlspecialchars( $options['number_place_holder'] ); ?></label>
					<input type="text" name="twl_sms_number" id="twl_sms_number" required />
				</div>
				<?php
					if($options['show_groups_cb'])
					{
						$groups = get_terms( array(
							'taxonomy' => 'twl_groups',
							'hide_empty' => false,
						));

						
				?>
					<div>
						<label for="twl_sms_groups">Groups</label>
						<select id="twl_groups" name="twl_groups" class="sendToSelect">
						<option value=""><?php _e( 'Select a group', TWL_TD ); ?></option>
						<?php
							if(count($groups))
							{
						?>
							
						<?php
								foreach($groups as $group)
								{
						?>
									<option value="<?php echo $group->name; ?>"><?php echo $group->name; ?></option>
						<?php
								}
							}
						?>
						</select>
					</div>
				<?php
					}			
				?>
				<div>
					<input class="elementFloat" type="radio" name="twl_sms_subscribe" id="twl_sms_subscribe" value="1" checked />
					<label class="elementFloat" for="twl_sms_subscribe"><?php _e( 'Subscribe', TWL_TD ); ?></label>
					<input class="elementFloat" type="radio" name="twl_sms_subscribe" id="twl_sms_unsubscribe" value="0" />
					<label class="elementFloat" for="twl_sms_unsubscribe"><?php _e( 'Unsubscribe', TWL_TD ); ?></label>
				</div>
				<?php
					if($options['enable_gdpr_cb'])
					{
						
				?>
					<div>
						<input class="elementFloat" type="checkbox" name="twl_sms_gdpr" id="twl_sms_gdpr" value="1" required />
						<label class="elementFloat" for="twl_sms_gdpr"><?php echo htmlspecialchars( $options['gdpr_agreement'] ); ?></label>
					</div>
				<?php
					}			
				?>
					<div>
						<input type="submit" name="twl_sms_submit" id="twl_sms_submit" value="Submit" />
					</div>
					<input type="hidden" name="action" value="save_twl_newsletter_data" />
					<?php wp_nonce_field( 'twl_newsletter_nonce' ); ?>
			</form>
			<span id="twl_msg_<?php echo $form_id; ?>" style="display:none;"></span>
			<form name="twl_sms_confirmation_form_<?php echo $form_id; ?>" id="twl_sms_confirmation_form_<?php echo $form_id; ?>" style="display:none;">
				<div>
					<input class="elementFloat" type="text" name="twl_sms_code" id="twl_sms_code" required />
				</div>
				<div>
					<input type="submit" name="twl_sms_submit" id="twl_sms_submit" value="Submit" />
				</div>
					<input type="hidden" name="action" value="save_twl_newsletter_confirmation_data" />
					<input type="hidden" name="twl_post_id" id="twl_post_id_<?php echo $form_id; ?>" value="" />
					<?php wp_nonce_field( 'twl_newsletter_confirmation_nonce' ); ?>
			</form>
			<span id="twl_confirmation_msg_<?php echo $form_id; ?>" style="display:none;"></span>
			<style>
				.twl_newsletter_widget .elementFloat
				{
					float: left;
				}
				.twl_newsletter_widget div
				{
					float: left;
					width: 100%;
					margin: 5px;
				}
			</style>
			<script>
				jQuery(document).ready(function($){
					$("#twl_sms_form_<?php echo $form_id; ?>").on("submit",function(e){
						e.preventDefault();
						var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
	  
					   $.ajax({
						 type : "post",
						 dataType : "json",
						 url : ajaxurl,
						 data : $("#twl_sms_form_<?php echo $form_id; ?>").serialize(),
						 complete: function(response) {
							$("#twl_sms_form_<?php echo $form_id; ?>").slideUp();
							var twl_response = $.parseJSON(response.responseText);
							$("#twl_msg_<?php echo $form_id; ?>").html(twl_response.message).slideDown();
							if (twl_response.status==2)
							{
								$("#twl_post_id_<?php echo $form_id; ?>").val(twl_response.twl_post_id);
								$("#twl_sms_confirmation_form_<?php echo $form_id; ?>").slideDown();
							}
							
							
						 }
					  });   
					});

					$("#twl_sms_confirmation_form_<?php echo $form_id; ?>").on("submit",function(e){
						e.preventDefault();
						var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
	  
					   $.ajax({
						 type : "post",
						 dataType : "json",
						 url : ajaxurl,
						 data : $("#twl_sms_confirmation_form_<?php echo $form_id; ?>").serialize(),
						 complete: function(response) {
							var twl_response = $.parseJSON(response.responseText);
							$("#twl_confirmation_msg_<?php echo $form_id; ?>").html(twl_response.message).slideDown();
							if (twl_response.status==1)
							{
								$("#twl_msg_<?php echo $form_id; ?>").slideUp();
								$("#twl_sms_confirmation_form_<?php echo $form_id; ?>").slideUp();
							}
								
							
						 }
					  });   
					});
				});
			</script>
</div>