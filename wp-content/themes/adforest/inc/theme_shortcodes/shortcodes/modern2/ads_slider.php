<?php

/* ------------------------------------------------ */
/* ADs Slider */
/* ------------------------------------------------ */
if (!function_exists('ads_slider_short')) {

    function ads_slider_short() {

        $cat_array = array();

        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat','no');


        $grid_array = array();
        if (Redux::getOption('adforest_theme', 'design_type') == 'modern') {
            $grid_array = array(
                __('Select Layout Type', 'adforest') => '',
                __('Grid 1', 'adforest') => 'grid_1',
                __('Grid 2', 'adforest') => 'grid_2',
                __('Grid 3', 'adforest') => 'grid_3',
                __('Grid 4', 'adforest') => 'grid_4',
                __('Grid 5', 'adforest') => 'grid_5',
                __('Grid 6', 'adforest') => 'grid_6',
                __('Grid 7', 'adforest') => 'grid_7',
                __('Grid 8', 'adforest') => 'grid_8',
                __('Grid 9', 'adforest') => 'grid_9',
                __('Grid 10', 'adforest') => 'grid_10',
            );
        } else {
            $grid_array = array(
                __('Select Layout Type', 'adforest') => '',
                __('Grid 1', 'adforest') => 'grid_1',
                __('Grid 2', 'adforest') => 'grid_2',
                __('Grid 3', 'adforest') => 'grid_3',
            );
        }
        vc_map(array(
            "name" => __("ADs Slider", 'adforest'),
            "description" => '',
            "base" => "ads_slider",
            "category" => __("Theme Shortcodes - 2", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('ads-slider.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("Element Title", "adforest"),
                    "param_name" => "element_title",
                    "value" => '',
                    "description" => __('For color ', 'adforest') . '<strong>' . esc_html('{color}') . '</strong>' . __('warp text within this tag', 'adforest') . '<strong>' . esc_html('{/color}') . '</strong>',
                    'group' => __('Basic', 'adforest'),
                ),
                array(
                    "type" => "vc_link",
                    "class" => "",
                    "heading" => __("More ads Button", "adforest"),
                    "param_name" => "more_ads",
                    "value" => '',
                    "description" => '',
                    'group' => __('Basic', 'adforest'),
                ),
                array(
                    "group" => __("Ads Settings", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Layout Type", 'adforest'),
                    "param_name" => "layout_type",
                    "admin_label" => true,
                    "value" => $grid_array,
                ),
                array(
                    "group" => __("Ads Settings", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Ads Type", 'adforest'),
                    "param_name" => "ad_type",
                    "admin_label" => true,
                    "value" => array(
                        __('Select Ads Type', 'adforest') => '',
                        __('Featured Ads', 'adforest') => 'feature',
                        __('Simple Ads', 'adforest') => 'regular',
                        __('Both', 'adforest') => 'both'
                    ),
                ),
                array(
                    "group" => __("Ads Settings", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Order By", 'adforest'),
                    "param_name" => "ad_order",
                    "admin_label" => true,
                    "value" => array(
                        __('Select Ads order', 'adforest') => '',
                        __('Oldest', 'adforest') => 'asc',
                        __('Latest', 'adforest') => 'desc',
                        __('Random', 'adforest') => 'rand'
                    ),
                ),
                array(
                    "group" => __("Ads Settings", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Number fo Ads for each tab type", 'adforest'),
                    "param_name" => "no_of_ads",
                    "admin_label" => true,
                    "value" => range(1, 500),
                ),
                array(
                    'group' => __('Categories', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category', 'adforest'),
                    'param_name' => 'cats',
                    'value' => '',
                    'params' => array
                        ($cat_array),
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'ads_slider_short');

if (!function_exists('ads_slider_callback')) {

    function ads_slider_callback($atts, $content = '') {
        global $adforest_theme;
        $no_title = 'yes';

        extract(shortcode_atts(array(
            'cats' => '',
            'ad_type' => '',
            'ad_order' => '',
            'no_of_ads' => '',
            'more_ads' => '',
            'element_title' => '',
            'layout_type' => 'grid_8',
                        ), $atts));

        wp_enqueue_script('carousel');
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";

        //$tab_field_name = 'cat';
        //$taxonomy_slug = 'ad_cats';
        //$tabs_arr = vc_param_group_parse_atts($atts['cats']);



        $rows = vc_param_group_parse_atts($atts['cats']);
        $rows = apply_filters('adforest_validate_term_type',$rows);
        $cats = array();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                if (isset($row['cat'])) {
                    if ($row['cat'] != 'all') {
                        if (!in_array($row['cat'], $cats)) {
                            $cats[] = $row['cat'];
                        }
                    }
                }
            }
        }

        $category = '';
        if (isset($cats) && !empty($cats) && count($cats) > 0) {
            $category = array(
                'taxonomy' => 'ad_cats',
                'field' => 'term_id',
                'terms' => $cats,
            );
        }



        $ads_html = '';
        $ad_type_sl = $ad_type;
        $ads = new ads();

        $ordering_sl = 'DESC';
        $order_by_sl = 'date';
        if ($ad_order == 'asc') {
            $ordering_sl = 'ASC';
        } else if ($ad_order == 'desc') {
            $ordering_sl = 'DESC';
        } else if ($ad_order == 'rand') {
            $order_by_sl = 'rand';
        }

        $countries_location = '';
        $countries_location = apply_filters('adforest_site_location_ads', $countries_location, 'search');
        $args_sl = array(
            'post_type' => 'ad_post',
            'post_status' => 'publish',
            'posts_per_page' => $no_of_ads,
            'meta_query' => array(
                array(
                    'key' => '_adforest_ad_status_',
                    'value' => 'active',
                    'compare' => '=',
                ),
            ),
            'orderby' => $order_by_sl,
            'order' => $ordering_sl,
        );



        if ($category != '') {
            $args_sl['tax_query'][] = $category;
        }
        if ($countries_location != '') {
            $args_sl['tax_query'][] = $countries_location;
        }

        if ($ad_type == 'feature') {
            $args_sl['meta_query'][] = array(
                'key' => '_adforest_is_feature',
                'value' => 1,
                'compare' => '=',
            );
        } else if ($ad_type == 'both') {
            
        } else {
            $args_sl['meta_query'][] = array(
                'key' => '_adforest_is_feature',
                'value' => 0,
                'compare' => '=',
            );
        }

        $args_sl = apply_filters('adforest_wpml_show_all_posts', $args_sl);
        $results_sl = new WP_Query($args_sl);
        if ($results_sl->have_posts()) {
            while ($results_sl->have_posts()) {
                $results_sl->the_post();
                $function = "adforest_search_layout_$layout_type";
                $ads_html .= $ads->$function(get_the_ID(), 0);
            }
        }


        $html = '';
        $html .= '<section class="mob-newest-ads custom-padding no-extra  ' . $bg_color . '">
                        <div class="container">
                                <div class="prop-newset-heading">
                                    <h2>' . adforest_color_text($element_title) . '</h2>
                                </div>
                                <div class="mob-slider-content">
                                <div class="newest  owl-carousel owl-theme">
                                ' . ($ads_html) . '
                                </div>    
                                 <div class="mob-brand-categories"> ' . adforest_ThemeBtn($more_ads, 'btn-theme') . '</div>    
                                </div>
                                
                        </div>
                    </section>';

        return $html;
        //}
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('ads_slider', 'ads_slider_callback');
}
