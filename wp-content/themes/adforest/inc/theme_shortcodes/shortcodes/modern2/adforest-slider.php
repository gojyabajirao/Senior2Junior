<?php

/* ------------------------------------------------ */
/* Adforest Banner Slider */
/* ------------------------------------------------ */
add_action('vc_before_init', 'adforest_slider_shortcode');
if (!function_exists('adforest_slider_shortcode')) {

    function adforest_slider_shortcode() {
        vc_map(array(
            'name' => __('Adforest Banner Slider', 'adforest'),
            'description' => '',
            'base' => 'adforest_slider',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('adforesr-slider.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    'group' => __('Slider Settings', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Add Slides', 'adforest'),
                    'param_name' => 'slides',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "attach_image",
                            "class" => "",
                            "heading" => __("Service Image", "adforest"),
                            "param_name" => "slider_image",
                            "value" => '',
                            "description" => __("Add an image of slider", "adforest")
                        ),
                        array(
                            "type" => "textfield",
                            "class" => "",
                            "heading" => __("Slider Title", "adforest"),
                            "param_name" => "slider_title",
                            "value" => '',
                            "description" => '',
                        ),
                        array(
                            "type" => "textarea",
                            "class" => "",
                            "heading" => __("Slider Description", "adforest"),
                            "param_name" => "slider_description",
                            "value" => '',
                            "description" => __("Enter slider description here .", "adforest"),
                        ),
                    ),
                ),
            )
        ));
    }

}

if (!function_exists('adforest_slider_callback')) {

    function adforest_slider_callback($atts, $content = '') {
        extract(
                shortcode_atts(
                        array(
            'slides' => '',
                        ), $atts)
        );

        $slider_arr = array();

        if(isset($atts['slides']) && $atts['slides'] != ''){
             $slider_arr = vc_param_group_parse_atts($atts['slides']);
        }

       
       
        wp_enqueue_script('carousel');
        $slider_html = '';
        if (isset($slider_arr) && !empty($slider_arr) && is_array($slider_arr) && sizeof($slider_arr) > 0 && $slider_arr[0] != '') {
            foreach ($slider_arr as $slider) {
                $slider_image = isset($slider['slider_image']) && $slider['slider_image'] != '' ? $slider['slider_image'] : '';
                if ($slider_image != '') {
                    $slider_image = adforest_returnImgSrc($slider['slider_image']);
                }

                $slider_title =  isset($slider['slider_title']) && $slider['slider_title'] != '' ? esc_html($slider['slider_title']) : "";
         $slider_description = isset($slider['slider_description']) && !empty($slider['slider_description']) ? esc_html($slider['slider_description']) : "";

                $slider_html .= '<div class="item">
                                    <div class="mob-hero-slider-section"> <img src="' . esc_url($slider_image) . '" alt="' .$slider_title. '" class="img-responsive">
                                        <div class="mob-hero-text-section">
                                            <h3>' . $slider_title . '</h3>
                                            <p>' . $slider_description . '</p>
                                        </div>
                                    </div>
                                </div>';
            }
        }
        $html = '';
        $html .= '<section class="mob-hero-section">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12 col-xs-12 col-md-12 col-sm-12">
                                    <div class="mobile-hero owl-carousel owl-theme">
                                    ' . ($slider_html) . '
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>';
        return $html;
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('adforest_slider', 'adforest_slider_callback');
}