<div class="row">
    <div class="col-lg-6">
        <div class="seller-public-profile-text-area">
            <h2><?php echo adforest_get_sold_ads($author->ID); ?></h2>
            <span class="text-details"><?php echo __('Ad Sold', 'adforest'); ?></span> </div>
    </div>
    <div class="col-lg-6">
        <div class="seller-public-profile-text-area-left-side">
            <h2><?php echo adforest_get_all_ads($author->ID); ?></h2>
            <span class="text-details"><?php echo __('Total Listings', 'adforest'); ?></span> </div>
    </div>
</div>
<?php
if (isset($adforest_theme['sb_user_profile_sc'])) {

    if ($adforest_theme['sb_user_profile_sc'] == "") {
        return;
    }
}
if (isset($adforest_theme['user_contact_form']) && $adforest_theme['user_contact_form']) {

    $captcha_type = isset($adforest_theme['google-recaptcha-type']) && !empty($adforest_theme['google-recaptcha-type']) ? $adforest_theme['google-recaptcha-type'] : 'v2';
    $site_key = isset($adforest_theme['google_api_key']) && !empty($adforest_theme['google_api_key']) ? $adforest_theme['google_api_key'] : '';
    $contact_form_recaptcha = isset($adforest_theme['contact_form_recaptcha']) && !empty($adforest_theme['contact_form_recaptcha']) ? $adforest_theme['contact_form_recaptcha'] : '';
    ?>

    <div class="heading-panel">
        <h3 class="main-title text-left"><?php echo __('Contact', 'adforest'); ?></h3>
    </div>
    <form id="user_contact_form">
        <div class="seller-form-group">
            <div class="form-group">
                <input type="text" class="form-control" name="name" aria-describedby="emailHelp" placeholder="<?php echo __('Name', 'adforest'); ?>" data-parsley-required="true" data-parsley-error-message="<?php echo __('This field is required.', 'adforest'); ?>">
                <small id="emailHelp" class="form-text text-muted"></small> </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="<?php echo __('Email', 'adforest'); ?>" data-parsley-required="true" data-parsley-error-message="<?php echo __('This field is required.', 'adforest'); ?>">
                <small id="emailHelp" class="form-text text-muted"></small> </div>
            <div class="form-group">
                <input type="text" class="form-control" name="subject" aria-describedby="emailHelp" placeholder="<?php echo __('Subject', 'adforest'); ?>" data-parsley-required="true" data-parsley-error-message="<?php echo __('This field is required.', 'adforest'); ?>">
                <small id="emailHelp" class="form-text text-muted"></small> </div>
            <div class="form-group">
                <textarea class="form-control" name="message" rows="3" placeholder="<?php echo __('Message', 'adforest'); ?>" data-parsley-required="true" data-parsley-error-message="<?php echo __('This field is required.', 'adforest'); ?>"></textarea>
            </div>
            <?php
            $captcha = '<input type="hidden" value="no" name="is_captcha" />';

            if (isset($contact_form_recaptcha) && $contact_form_recaptcha) {
                if ($captcha_type == 'v2') {
                    if ($site_key != "") {
                        $captcha = '<div class="form-group">
			  <div class="g-recaptcha" data-sitekey="' . $site_key . '"></div>
		   </div><input type="hidden" value="yes" name="is_captcha" />
		';
                    }
                } else {
                    $captcha = '<input type="hidden" value="yes" name="is_captcha" />';
                }
            }


            echo adforest_returnEcho($captcha);
            ?>
        </div>
        <div class="sellers-button-group">
            <button class="btn btn-primary btn-theme" type="submit"><?php echo __('Send', 'adforest'); ?></button>
            <input type="hidden" id="receiver_id" value="<?php echo esc_attr($author_id); ?>" />
        </div>
    </form>
    <?php
}
?>