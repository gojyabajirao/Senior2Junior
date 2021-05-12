<?php
/* ------------------------------------------------ */
/* services */
/* ------------------------------------------------ */
add_action('vc_before_init', 'adforest_hero_sports_shortcode');
if (!function_exists('adforest_hero_sports_shortcode')) {

    function adforest_hero_sports_shortcode() {
        vc_map(array(
            'name' => __('Hero - Sports Banner', 'adforest'),
            'description' => '',
            'base' => 'adforest_hero_sports',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('hero-sport.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("Heading 1", "adforest"),
                    "param_name" => "heading_1",
                    "value" => '',
                    "description" => '',
                    'group' => __('Basic', 'adforest'),
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("Heading 2", "adforest"),
                    "param_name" => "heading_2",
                    "value" => '',
                    "description" => '',
                    'group' => __('Basic', 'adforest'),
                ),
                array(
                    "type" => "textarea",
                    "class" => "",
                    "heading" => __("Description", "adforest"),
                    "param_name" => "banner_description",
                    "value" => '',
                    "description" => __("Enter banner description here .", "adforest"),
                    'group' => __('Basic', 'adforest'),
                ),
                array(
                    "type" => "attach_image",
                    "class" => "",
                    "heading" => __("Background Image", "adforest"),
                    "param_name" => "bg_image",
                    "value" => '',
                    "description" => __("Add an image of  background : Recommended size (1920x946)", "adforest"),
                    'group' => __('Basic', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    'type' => 'vc_link',
                    'holder' => 'div',
                    'class' => '',
                    'admin_label' => true,
                    'heading' => __('Button Link', 'adforest'),
                    'param_name' => 'sport_link',
                ),
            )
        ));
    }

}

if (!function_exists('adforest_hero_sports_callback')) {

    function adforest_hero_sports_callback($atts, $content = '') {
        extract(
                shortcode_atts(
                        array(
            'heading_1' => '',
            'heading_2' => '',
            'banner_description' => '',
            'bg_image' => '',
            'sport_link' => '',
                        ), $atts)
        );

        $bg_image_id = isset($bg_image) ? $bg_image : '';
        $heading_1 = isset($heading_1) ? $heading_1 : '';
        $heading_2 = isset($heading_2) ? $heading_2 : '';
        $banner_description = isset($banner_description) ? $banner_description : '';
        $banner_image = adforest_returnImgSrc($bg_image_id);
        if (!empty($bg_image_id)) {
            $bg_style = ' style="background: url(' . esc_url($banner_image) . ') center center no-repeat;background-size: cover !important;"';
        }
        $sport_link = adforest_ThemeBtn($sport_link, 'btn btn-theme', false);
        $html = '';
        $html .= '<section class="sprt-hero-section"'.$bg_style.'>
                    <div class="container">
                            <div class="row">
                                    <div class="col-lg-8">
                                            <div class="sprt-hero-text">
                                                    <div class="sprt-hero-cric">
                                                            <h3>'.esc_html($heading_1).'</h3>
                                                            <h1>'.esc_html($heading_2).'</h1>
                                                            <p>'.esc_html($banner_description).'</p>
                                                    </div>
                                                    <div class="sprt-hero-st">
                                                        '.$sport_link.'
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
    adforest_add_code('adforest_hero_sports', 'adforest_hero_sports_callback');
}