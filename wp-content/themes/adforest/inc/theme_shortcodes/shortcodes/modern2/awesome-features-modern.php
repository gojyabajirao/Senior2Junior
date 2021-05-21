<?php
/* ------------------------------------------------ */
/* awesome_features_modern */
/* ------------------------------------------------ */
if (!function_exists('awesome_features_modern_shortcodeBase')) {

    function awesome_features_modern_shortcodeBase() {
        vc_map(array(
            'name' => __("Awesome Features - Modern", 'adforest'),
            'base' => 'awesome_features_modern',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('land-awesome-features.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
                        __('Image', 'adforest') => 'img'
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                    "description" => __("Select background color.", 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => __("Background Image", 'adforest'),
                    "param_name" => "bg_img",
                    'dependency' => array('element' => 'section_bg', 'value' => array('img'),),
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
                array
                    (
                    'group' => __("Screenshots", 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select points under description.', 'adforest'),
                    'param_name' => 'screenshots',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'admin_label' => true,
                            'heading' => __('Main Title', 'adforest'),
                            'param_name' => 'title',
                            'edit_field_class' => 'vc_col-sm-12 vc_column',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'admin_label' => true,
                            'heading' => __('Subtitle', 'adforest'),
                            'param_name' => 'subtitle',
                            'edit_field_class' => 'vc_col-sm-12 vc_column',
                        ),
                        array(
                            "group" => __("Basic", "adforest"),
                            'type' => 'attach_image',
                            'holder' => 'div',
                            'class' => '',
                            'admin_label' => true,
                            'heading' => __('Image', 'adforest'),
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
add_action('vc_before_init', 'awesome_features_modern_shortcodeBase');
if (!function_exists('awesome_features_modern_func')) {

    function awesome_features_modern_func($atts, $content = '') {

        extract(shortcode_atts(array('section_bg' => '', 'section_title' => '', 'section_desc' => '', 'screenshots' => ''), $atts));

        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        $section_title_html = adforest_color_text_custom_html($section_title, '<span>', '</span>');
        $section_desc_html = ( $section_desc != "" ) ? '<p>' . $section_desc . '</p>' : '';
        $section_bg_class = ( $section_bg == 'gray' ) ? 'gray' : '';
        $sub_html = '';
        if (isset($atts['screenshots'])) {
            $screenshots_rows = vc_param_group_parse_atts($atts['screenshots']);
            if (count($screenshots_rows) > 0) {
                foreach ($screenshots_rows as $row) {
                    if (isset($row['img'])) {
                        $img_url = ( isset($row['img']) ) ? adforest_returnImgSrc($row['img']) : "";
                        $title = ( isset($row['title']) ) ? esc_html($row['title']) : "";
                        $subtitle = ( isset($row['subtitle']) ) ? esc_html($row['subtitle']) : "";
                        if ($img_url != "") {
                            $sub_html .= '<div class="col-lg-3 col-xs-12 col-md-3 col-sm-2"><div class="land-featured-box"><div class="land-featured-icons"> <img src="' . esc_url($img_url) . '" alt="' . esc_attr($title) . '" class="img-responsive"> </div> <div class="land-featured-text-section"> <span>' . esc_html($title) . '</span><p>' . esc_html($subtitle) . '</p> </div></div> </div>';
                        }
                    }
                }
            }
        }

        $output = '<section class="land-latest-featured ' . $bg_color . '" ' . $style . '><div class="container"> 
			<div class="row"> ' . $header . ' <div class="row clear-custom">' . $sub_html . '</div> </div></div>
		</section>';
        return $output;
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('awesome_features_modern', 'awesome_features_modern_func');
}