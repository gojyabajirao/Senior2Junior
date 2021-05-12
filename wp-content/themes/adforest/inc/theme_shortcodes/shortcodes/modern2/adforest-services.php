<?php
/* ------------------------------------------------ */
/* Adforest Services */
/* ------------------------------------------------ */
add_action('vc_before_init', 'adforest_services_shortcode');
if (!function_exists('adforest_services_shortcode')) {

    function adforest_services_shortcode() {
        vc_map(array(
            'name' => __('Adforest Services', 'adforest'),
            'description' => '',
            'base' => 'adforest_services',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('adforest-services.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Header Style", 'adforest'),
                    "param_name" => "header_style",
                    "admin_label" => true,
                    "value" => array(
                        __('Section Header Style', 'adforest') => '',
                        __('No Header', 'adforest') => '',
                        __('Classic', 'adforest') => 'classic',
                        __('Regular', 'adforest') => 'regular'
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                    "description" => __("Chose header style.", 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Title", 'adforest'),
                    "param_name" => "section_title",
                    "description" => __('For color ', 'adforest') . '<strong>' . esc_html('{color}') . '</strong>' . __('warp text within this tag', 'adforest') . '<strong>' . esc_html('{/color}') . '</strong>',
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'header_style',
                        'value' => array('classic'),
                    ),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Title", 'adforest'),
                    "param_name" => "section_title_regular",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'header_style',
                        'value' => array('regular'),
                    ),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Description", 'adforest'),
                    "param_name" => "section_description",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'header_style',
                        'value' => array('classic'),
                    ),
                ),
                array(
                    'group' => __('Services', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Add Services', 'adforest'),
                    'param_name' => 'services',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "attach_image",
                            "class" => "",
                            "heading" => __("Service Image", "adforest"),
                            "param_name" => "service_image",
                            "value" => '',
                            "description" => __("Add an image of service : Recommended size (64x64)", "adforest")
                        ),
                        array(
                            "type" => "textfield",
                            "class" => "",
                            "heading" => __("Service Title", "adforest"),
                            "param_name" => "service_title",
                            "value" => '',
                            "description" => '',
                        ),
                        array(
                            "type" => "textarea",
                            "class" => "",
                            "heading" => __("Service Description", "adforest"),
                            "param_name" => "service_description",
                            "value" => '',
                            "description" => __("Enter service description here .", "adforest"),
                        ),
                    ),
                ),
            )
        ));
    }

}

if (!function_exists('adforest_services_callback')) {

    function adforest_services_callback($atts, $content = '') {
        extract(
                shortcode_atts(
                        array(
                            'section_title' => '',
                            'section_description' => '',
                            'header_style' => '',
                            'services' => '',
                        ), $atts)
        );
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        $services_arr = vc_param_group_parse_atts($atts['services']);

        $services_html = '';
        if (isset($services_arr) && !empty($services_arr) && is_array($services_arr) && sizeof($services_arr) > 0) {
            foreach ($services_arr as $service) {
                $service_image_id = isset($service['service_image']) ? $service['service_image'] : '';
                $service_image = adforest_returnImgSrc($service_image_id);
                $services_html .= '<div class="col-lg-4 col-xs-12 col-sm-4 col-md-4">
                                <div class="prop-it-work-sell-section">
                                    <div class="prop-it-work-image"> <img src="' . esc_url($service_image) . '" alt="' . esc_attr($service['service_title']) . '" class="img-responsive"> </div>
                                    <div class="prop-it-sell-text-section"> <span>' . esc_html($service['service_title']) . '</span>
                                        <p>' . esc_html($service['service_description']) . '</p>
                                    </div>
                                </div>
                            </div>';
            }
        }

        $html = '';
        $html .= '<section class="custom-padding prop-how-it-work">
                    <div class="container">
                        <div class="row">
                            ' . ($header) . '
                            ' . ($services_html) . '
                        </div>
                    </div>
                </section>';


        return $html;
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('adforest_services', 'adforest_services_callback');
}