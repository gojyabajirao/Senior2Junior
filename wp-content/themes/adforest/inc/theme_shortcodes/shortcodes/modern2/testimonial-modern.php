<?php

/* ------------------------------------------------ */
/* adf_testimonial_modern */
/* ------------------------------------------------ */
if (!function_exists('adf_testimonial_modern_shortcodeBase')) {

    function adf_testimonial_modern_shortcodeBase() {
        vc_map(array(
            'name' => __("Testimonials - Modern", 'adforest'),
            'base' => 'adf_testimonial_modern',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('land-one-items-testimonial.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
                        __('Gray', 'adforest') => 'gray',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                    "description" => __("Select background color.", 'adforest'),
                ),
                array
                    (
                    'group' => __("Point's", 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select points under description.', 'adforest'),
                    'param_name' => 'points',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'admin_label' => true,
                            'heading' => __('Title', 'adforest'),
                            'param_name' => 'title',
                        ),
                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'class' => '',
                            'admin_label' => true,
                            'heading' => __('Description', 'adforest'),
                            'param_name' => 'desc',
                        ),
                        array(
                            "type" => "dropdown",
                            "heading" => __("Select Stars", 'adforest'),
                            "param_name" => "stars",
                            "admin_label" => true,
                            "value" => array(
                                __('Select Option', 'adforest') => '',
                                __('1', 'adforest') => '1',
                                __('2', 'adforest') => '2',
                                __('3', 'adforest') => '3',
                                __('4', 'adforest') => '4',
                                __('5', 'adforest') => '5',
                            ),
                            'edit_field_class' => 'vc_col-sm-12 vc_column',
                            "std" => '',
                            "description" => __("Select stars", 'adforest'),
                        ),
                        array(
                            'type' => 'attach_image',
                            'holder' => 'div',
                            'class' => '',
                            'admin_label' => true,
                            'heading' => __('Side Image', 'adforest'),
                            'param_name' => 'img',
                            'description' => __('Section side image', 'adforest'),
                            'edit_field_class' => 'vc_col-sm-12 vc_column',
                        ),
                    )
                ),
            )
        ));
    }

}
add_action('vc_before_init', 'adf_testimonial_modern_shortcodeBase');
if (!function_exists('adf_testimonial_modern_func')) {

    function adf_testimonial_modern_func($atts, $content = '') {
        // Attributes
        extract(shortcode_atts(array('points' => '', 'section_bg' => '',), $atts));
        $section_bg_class = ( $section_bg == 'gray' ) ? 'gray' : '';

        $points = false;
        $points_html = '';
        $inner_html = '';
        if (isset($atts['points'])) {
            $points_rows = vc_param_group_parse_atts($atts['points']);
            if (count($points_rows) > 0) {

                foreach ($points_rows as $row) {
                    if (isset($row['title'])) {
                        $image_url = ( isset($row['img']) ) ? adforest_returnImgSrc($row['img']) : '';
                        $stars = ( isset($row['stars']) && $row['stars'] != "" ) ? (int) $row['stars'] : 0;
                        $title = ( isset($row['title']) ) ? '<div class="land-one-h2"><h5>' . $row['title'] . "</h5></div>" : '';
                        $desc = ( isset($row['desc']) ) ? "<p>" . $row['desc'] . "</p>" : '';
                        $stars_html = '';
                        for ($i = 1; $i <= $stars; $i++) {
                            $stars_html .= '<i class="fa fa-star"></i>';
                        }
                        $image_html = ( $image_url != "" ) ? '<div class="land-item-profile"> <img src="' . esc_url($image_url) . '" class="img-responsive"  alt="' . esc_html__('image', 'adforest') . '"> </div>' : "";
                        $inner_html .= '<div class="item"><div class="col-lg-12 col-xs-12 col-sm-12 col-md-12"><div class="land-one-slider"> ' . $image_html . '' . $title . '<div class="land-one-rating">' . $stars_html . '</div><div class="land-new-text">' . $desc . '</div></div></div></div>';
                    }
                }
            }
        }


        return '<section class="land-one-items ' . $section_bg_class . '"><div class="container"><div class="row"><div class="land-one-slider-2 owl-theme owl-carousel">' . $inner_html . '</div></div></div></section>';
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('adf_testimonial_modern', 'adf_testimonial_modern_func');
}