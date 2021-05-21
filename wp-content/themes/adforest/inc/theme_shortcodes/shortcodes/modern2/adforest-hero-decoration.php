<?php

/* ------------------------------------------------ */
/* services */
/* ------------------------------------------------ */
add_action('vc_before_init', 'adforest_hero_decoration_shortcode');
if (!function_exists('adforest_hero_decoration_shortcode')) {

    function adforest_hero_decoration_shortcode() {

        $cat_array = array();

        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat','no');

        vc_map(array(
            'name' => __('Hero - Decoration Banner', 'adforest'),
            'description' => '',
            'base' => 'adforest_hero_decoration',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('hero-decoration.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
                    "description" => __("Add an image of  background : Recommended size (1920x700)", "adforest"),
                    'group' => __('Basic', 'adforest'),
                ),
                array
                    (
                    'group' => __('Categories', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category', 'adforest'),
                    'param_name' => 'cats',
                    'value' => '',
                    'params' => array
                        (
                        $cat_array,
                        array(
                            "group" => __("Basic", "adforest"),
                            "type" => "attach_image",
                            "holder" => "img",
                            "heading" => __("Category Image : Recommended size (32 X 32)", 'adforest'),
                            "param_name" => "img",
                            "description" => __('32 X 32', 'adforest'),
                        ),
                    )
                ),
            )
        ));
    }

}

if (!function_exists('adforest_hero_decoration_callback')) {

    function adforest_hero_decoration_callback($atts, $content = '') {
        global $adforest_theme;
        extract(
                shortcode_atts(
                        array(
            'heading_1' => '',
            'heading_2' => '',
            'banner_description' => '',
            'bg_image' => '',
            'cats' => '',
                        ), $atts)
        );
        wp_enqueue_script('carousel');
        $bg_image_id = isset($bg_image) ? $bg_image : '';
        $heading_1 = isset($heading_1) ? $heading_1 : '';
        $heading_2 = isset($heading_2) ? $heading_2 : '';
        $banner_description = isset($banner_description) ? $banner_description : '';
        $banner_image = adforest_returnImgSrc($bg_image_id);
        $bg_style = '';
        if (!empty($bg_image_id)) {
            $bg_style = ' style="background: url(' . esc_url($banner_image) . ') center center no-repeat; background-size:cover;"';
        }


        $categories_html = '';
        if (isset($atts['cats'])) {
            $rows = vc_param_group_parse_atts($atts['cats']);
            $rows = apply_filters('adforest_validate_term_type',$rows);
            if (count($rows) > 0) {
                foreach ($rows as $row) {
                    if (isset($row['cat']) && isset($row['img'])) {
                        $category = get_term($row['cat'],'ad_cats');
                        if (count((array) $category) == 0)
                            continue;
                        $count = $category->count;
                        
                        $bgImageURL = adforest_returnImgSrc($row['img']);
                        $categories_html .= '<div class="item">
                                            <div class="dec-product-box">
                                                <div class="dec-product-categories"> <img src="' . esc_url($bgImageURL) . '" alt="' . $category->name . '" class="img-responsive"> </div>
                                                <div class="dec-products-text">
                                                    <a href="' . get_term_link($category->term_id) . '"><h5>' . esc_html($category->name) . '</h5></a>
                                                </div>
                                                <div class="dec-products-ads"> <a href="javascript:void(0)" class="btn-theme">' . absint($count) . ' ' . __('Ads', 'adforest') . '</a> </div>
                                            </div>
                                        </div>';
                    }
                }
            }
        }
        $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
        $html = '';
        $html .= '<section class="dec-hero-section"' . $bg_style . '>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <div class="dec-hero-content">
                                    <div class="dec-hero-text-section">
                                        <h5>' . esc_html($heading_1) . '</h5>
                                        <h1>' . esc_html($heading_2) . '</h1>
                                        <p>' . esc_html($banner_description) . '</p>
                                    </div>
                                    <div class="dec-hero-search">
                                        <form action="' . get_the_permalink($sb_search_page) . '" onsubmit="adforest_disableEmptyInputs(this)">
                                            <div class="form-group">
                                                <input autocomplete="off" name="ad_title" type="text" placeholder="' . esc_html__('Search Keyword', 'adforest') . '" class="form-control">
                                                <div class="dec-hero-submit"> <button class="btn btn-theme" type="submit"><i class="fa fa-search"></i></button> </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <section class="dec-latest-products">
                        <div class="container">
                            <div class="dec-latest-products-s owl-carousel owl-theme">
                                ' . $categories_html . '
                            </div>
                        </div>
                    </section>
                </section>';




        return $html;
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('adforest_hero_decoration', 'adforest_hero_decoration_callback');
}