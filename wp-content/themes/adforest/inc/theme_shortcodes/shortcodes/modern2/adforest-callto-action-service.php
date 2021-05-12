<?php
/* ------------------------------------------------ */
/* call_to_action_service */
/* ------------------------------------------------ */
add_action('vc_before_init', 'adforest_call_to_action_service_shortcode');
if (!function_exists('adforest_call_to_action_service_shortcode')) {

    function adforest_call_to_action_service_shortcode() {
        vc_map(array(
            'name' => __('Call To Action - Service', 'adforest'),
            'description' => '',
            'base' => 'call_to_action_service',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('call-to-action-service.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Background Color", 'adforest'),
                    "param_name" => "section_bg",
                    "admin_label" => true,
                    "value" => array(
                        __('Select Background Color', 'adforest') => '',
                        __('White', 'adforest') => '',
                        __('Gray', 'adforest') => 'gray'
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                    "description" => __("Select background color.", 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "heading" => __("Heading", 'adforest'),
                    "param_name" => "heading_1",
                    "description" => '',
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "heading" => __("Subheading", 'adforest'),
                    "param_name" => "heading_2",
                    "description" => '',
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textarea_html",
                    "class" => "",
                    "heading" => __("Description", 'adforest'),
                    "param_name" => "content",
                    "value" => "",
                    "holder" => "div",
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    'type' => 'vc_link',
                    'holder' => 'div',
                    'class' => '',
                    'admin_label' => true,
                    'heading' => __('Button 1', 'adforest'),
                    'param_name' => 'btn_1',
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    'type' => 'vc_link',
                    'holder' => 'div',
                    'class' => '',
                    'admin_label' => true,
                    'heading' => __('Button 2', 'adforest'),
                    'param_name' => 'btn_2',
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "attach_image",
                    "holder" => "img",
                    "heading" => __("Call to Action Image : : Recommended size (555 X 370)", 'adforest'),
                    "param_name" => "call_img",
                ),
            )
        ));
    }

}

if (!function_exists('adforest_call_to_action_service_func')) {

    function adforest_call_to_action_service_func($atts, $content = '') {
        extract(shortcode_atts(
                        array(
            'heading_1' => '',
            'heading_2' => '',
            'btn_1' => '',
            'btn_2' => '',
            'call_img' => '',
                        ), $atts));

        $call_img = ( isset($call_img) ) ? adforest_returnImgSrc($call_img) : '';
        $btn_1 = adforest_ThemeBtn($btn_1, 'btn btn-theme', false);
        $btn_2 = adforest_ThemeBtn($btn_2, 'btn btn-theme', false);
        $html = '';
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";

        $html .= '<section class="srvs-providers  ' . $bg_color . '">
                    <div class="container">
                      <div class="row">
                        <div class="col-lg-6 col-xs-12 col-sm-6 col-md-6">
                          <div class="srvs-prov-details">
                            <div class="srvs-prov-text">
                              <h3>' . esc_html($heading_1) . '</h3>
                              <h4>' . esc_html($heading_2) . '</h4>
                            </div>
                            <div class="srvs-prov-more">
                              <p>' . adforest_returnEcho($content) . '</p>
                            </div>
                            <ul class="list-inline srvs-prov-contents">
                              <li> ' . ($btn_1) . ' </li>
                              <li> ' . ($btn_2) . ' </li>
                            </ul>
                          </div>
                        </div>
                        <div class="col-lg-6 col-xs-12 col-sm-6 col-md-6">
                          <div class="srvs-providers"> <img src="' . esc_url($call_img) . '" alt="' . esc_html__('Call to Action image', 'adforest') . '" class="img-responsive"> </div>
                        </div>
                      </div>
                    </div>
                  </section>';



        return $html;
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('call_to_action_service', 'adforest_call_to_action_service_func');
}