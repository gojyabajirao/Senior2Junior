<?php
/* ------------------------------------------------ */
/* Adforest Contact Info */
/* ------------------------------------------------ */
add_action('vc_before_init', 'adforest_contactinfo_shortcode');
if (!function_exists('adforest_contactinfo_shortcode')) {

    function adforest_contactinfo_shortcode() {
        vc_map(array(
            'name' => __('Adforest Contact Info', 'adforest'),
            'description' => '',
            'base' => 'adforest_contactinfo',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('adforest-contact-info.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("Info Title", "adforest"),
                    "param_name" => "info_title",
                    "value" => '',
                    "description" => __("Enter contact information title here .", "adforest"),
                    'group' => __('Basic', 'adforest'),
                ),
                array(
                    "type" => "textarea",
                    "class" => "",
                    "heading" => __("Info Description", "adforest"),
                    "param_name" => "info_description",
                    "value" => '',
                    "description" => __("Enter contact information description here .", "adforest"),
                    'group' => __('Basic', 'adforest'),
                ),
                array(
                    'group' => __('Information', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Add Services', 'adforest'),
                    'param_name' => 'contact_info_deatail',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "attach_image",
                            "class" => "",
                            "heading" => __("Contact Image", "adforest"),
                            "param_name" => "contact_image",
                            "value" => '',
                            "description" => __("Add an image of contact : Recommended size (64x64)", "adforest")
                        ),
                        array(
                            "type" => "textfield",
                            "class" => "",
                            "heading" => __("Contact Title", "adforest"),
                            "param_name" => "contact_title",
                            "value" => '',
                            "description" => '',
                        ),
                        array(
                            "type" => "textfield",
                            "class" => "",
                            "heading" => __("Contact Detail", "adforest"),
                            "param_name" => "contact_detail",
                            "value" => '',
                            "description" => '',
                        ),
                    ),
                ),
            )
        ));
    }

}

if (!function_exists('adforest_contactinfo_callback')) {

    function adforest_contactinfo_callback($atts, $content = '') {
        extract(
                shortcode_atts(
                        array(
            'info_title' => '',
            'info_description' => '',
            'contact_info_deatail' => '',
                        ), $atts)
        );
        $contact_info_arr = vc_param_group_parse_atts($atts['contact_info_deatail']);
        $contact_html = '';
        
        
        if (isset($contact_info_arr) && !empty($contact_info_arr) && is_array($contact_info_arr) && sizeof($contact_info_arr) > 0) {
            foreach ($contact_info_arr as $contact) {
                $contact_image = adforest_returnImgSrc($contact['contact_image']);
                
                
                $contact_html .= '<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                                        <div class="mob-logo-img"> <img src="' . esc_url($contact_image) . '" alt="'.esc_html__('Contact info Image','adforest').'" class="img-responsive"> </div>
                                        <div class="mob-details-section">
                                          <p>' . esc_html($contact['contact_title']) . '</p>
                                          <span>' . esc_html($contact['contact_detail']) . '</span> </div>
                                    </div>';
                
            }
        }
        $html = '';
        $html .= '<section class="mob-call-to-action padding-bottom-30">
                    <div class="container">
                      <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">
                        <div class="row">
                          <div class="col-lg-4 col-sm-12 col-md-4 col-xs-12">
                            <div class="mob-call-text-section">
                              <h4>' . esc_html($info_title) . '</h4>
                              <p>' . esc_html($info_description) . '</p>
                            </div>
                          </div>
                          
                          <div class="col-lg-8 col-sm-12 col-md-8 col-xs-12">
                          <div class="row">
                          ' . ($contact_html) . '
                          </div>
                          </div>
                        </div>
                        </div>
                      </div>
                    </div>
                  </section>';
        return $html;
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('adforest_contactinfo', 'adforest_contactinfo_callback');
}