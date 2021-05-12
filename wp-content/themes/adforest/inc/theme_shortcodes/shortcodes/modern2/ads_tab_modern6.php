<?php

/* ------------------------------------------------ */
/* ADs Tabs Modern 2 */
/* ------------------------------------------------ */
if (!function_exists('ads_tabs_modern6_short')) {

    function ads_tabs_modern6_short() {
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
        $cat_array = array();

        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat', 'no');
        vc_map(array(
            "name" => __("ADs Tabs Modern 2", 'adforest'),
            "description" => __("Once on a Page.", 'adforest'),
            "base" => "ads_tabs_modern6",
            "category" => __("Theme Shortcodes - 2", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('ads_tab_6.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
                    "group" => __("Ads Settings", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Display Tabs", 'adforest'),
                    "param_name" => "ads_tab_switch",
                    "admin_label" => true,
                    "value" => array(
                        __('Select Ads Tabing', 'adforest') => '',
                        __('Categories', 'adforest') => 'categories',
                        __('Ad Type', 'adforest') => 'ad_type',
                        __('Condition', 'adforest') => 'conditions',
                        __('Warranty', 'adforest') => 'warranty',
                    ),
                ),
                array(
                    'group' => __('Tabs', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category', 'adforest'),
                    'param_name' => 'cats',
                    'value' => '',
                    'params' => array
                        ($cat_array),
                    'dependency' => array('element' => 'ads_tab_switch', 'value' => array('categories')),
                ),
                array(
                    'group' => __('Tabs', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Ad Type', 'adforest'),
                    'param_name' => 'ads_types',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => __("Ad Type", 'adforest'),
                            "param_name" => "ads_type",
                            "admin_label" => true,
                            "value" => adforest_cats('ad_type', 'no'),
                        ),
                    ),
                    'dependency' => array('element' => 'ads_tab_switch', 'value' => array('ad_type')),
                ),
                array(
                    'group' => __('Tabs', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Ad Conditions', 'adforest'),
                    'param_name' => 'ad_conditions',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => __("Ad Conditions", 'adforest'),
                            "param_name" => "ad_condition",
                            "admin_label" => true,
                            "value" => adforest_cats('ad_condition', 'no'),
                        ),
                    ),
                    'dependency' => array('element' => 'ads_tab_switch', 'value' => array('conditions')),
                ),
                array(
                    'group' => __('Tabs', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Ad Warranties', 'adforest'),
                    'param_name' => 'ad_warranties',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => __("Ad Warranty", 'adforest'),
                            "param_name" => "ad_warranty",
                            "admin_label" => true,
                            "value" => adforest_cats('ad_warranty', 'no'),
                        ),
                    ),
                    'dependency' => array('element' => 'ads_tab_switch', 'value' => array('warranty')),
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'ads_tabs_modern6_short');

if (!function_exists('ads_tabs_modern6_callback')) {

    function ads_tabs_modern6_callback($atts, $content = '') {
        global $adforest_theme;

        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        $no_title = 'yes';

        extract(shortcode_atts(array(
            'cats' => '',
            'ads_tab_switch' => '',
            'ads_types' => '',
            'ad_conditions' => '',
            'ad_warranties' => '',
            'ad_type' => '',
            'ad_order' => '',
            'no_of_ads' => '',
            'more_ads' => '',
            'element_title' => '',
            'layout_type' => 'grid_8',
                        ), $atts));

        $tab_field_name = 'cat';
        $taxonomy_slug = 'ad_cats';

        $tabs_arr = array();

        if ($ads_tab_switch == 'ad_type' && isset($atts['ads_types']) && $atts['ads_types'] != '') {
            $tabs_arr = vc_param_group_parse_atts($atts['ads_types']);
            $tab_field_name = 'ads_type';
            $taxonomy_slug = 'ad_type';
        } elseif ($ads_tab_switch == 'conditions' && isset($atts['ad_conditions']) && $atts['ad_conditions'] != '') {
            $tabs_arr = vc_param_group_parse_atts($atts['ad_conditions']);
            $tab_field_name = 'ad_condition';
            $taxonomy_slug = 'ad_condition';
        } elseif ($ads_tab_switch == 'warranty' && isset($atts['ad_warranties']) && $atts['ad_warranties'] != '') {
            $tabs_arr = vc_param_group_parse_atts($atts['ad_warranties']);
            $tab_field_name = 'ad_warranty';
            $taxonomy_slug = 'ad_warranty';
        } else {
            if (isset($atts['cats']) && $atts['cats'] != '') {
                $tabs_arr = vc_param_group_parse_atts($atts['cats']);
                $tabs_arr = apply_filters('adforest_validate_term_type', $tabs_arr);
            }
        }

        $categories_html = '';
        $ads_html = '';
        $counnt = 1;

        $ads = new ads();

        if (isset($tabs_arr) && !empty($tabs_arr) && is_array($tabs_arr) && count($tabs_arr) > 0 && $tabs_arr[0] != '') {
            $categories_html .= '';

            foreach ($tabs_arr as $row) {
                $rand_id = rand(2278, 543215);
                if (isset($row[$tab_field_name])) {
                    $is_active = '';
                    if ($counnt == 1) {
                        $is_active = 'active';
                        $counnt++;
                    }
                    $cat_obj = get_term($row[$tab_field_name]);
                    if (count((array) $cat_obj) == 0)
                        continue;
                    $adforest_tab_id = 'adforest-tab-';
                    $categories_html .= '<li class="' . esc_attr($is_active) . '"> <a class="md6-tab" href="#' . $adforest_tab_id . $rand_id . '" data-toggle="tab"> ' . $cat_obj->name . ' </a> </li>';
                    $ads_html .= '<div class="tab-pane ' . esc_attr($is_active) . '" id="' . $adforest_tab_id . $rand_id . '">';
                    $ads_html .= '<div class="row">';
                    $category = array(
                        array(
                            'taxonomy' => $taxonomy_slug,
                            'field' => 'term_id',
                            'terms' => $row[$tab_field_name],
                        ),
                    );
                    $is_feature = '';
                    if ($ad_type == 'feature') {
                        $is_feature = array(
                            'key' => '_adforest_is_feature',
                            'value' => 1,
                            'compare' => '=',
                        );
                    } else if ($ad_type == 'both') {
                        $is_feature = '';
                    } else {
                        $is_feature = array(
                            'key' => '_adforest_is_feature',
                            'value' => 0,
                            'compare' => '=',
                        );
                    }
                    $is_active = array(
                        'key' => '_adforest_ad_status_',
                        'value' => 'active',
                        'compare' => '=',
                    );

                    $ordering = 'DESC';
                    $order_by = 'date';
                    if ($ad_order == 'asc') {
                        $ordering = 'ASC';
                    } else if ($ad_order == 'desc') {
                        $ordering = 'DESC';
                    } else if ($ad_order == 'rand') {
                        $order_by = 'rand';
                    }

                    $countries_location = '';
                    $countries_location = apply_filters('adforest_site_location_ads', $countries_location, 'search');


                    $args = array(
                        'post_type' => 'ad_post',
                        'post_status' => 'publish',
                        'posts_per_page' => $no_of_ads,
                        'meta_query' => array(
                            $is_feature,
                            $is_active,
                        ),
                        'tax_query' => array(
                            $category,
                            $countries_location,
                        ),
                        'orderby' => $order_by,
                        'order' => $ordering,
                    );
                    $args = apply_filters('adforest_wpml_show_all_posts', $args);
                    $results = new WP_Query($args);
                    if ($results->have_posts()) {
                        while ($results->have_posts()) {
                            $results->the_post();
                            $function = "adforest_search_layout_$layout_type";
                            $ads_html .= $ads->$function(get_the_ID(), 4);
                        }
                    }
                    $ads_html .= '</div>';
                    $ads_html .= '</div>';
                    $ads_html .= '';
                }
            }
        }
        $html = '';
        $html .= '<section class="prop-newest-section padding-bottom-40 ' . $bg_color . '">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                                <div class="prop-newset-heading">
                                    <h2>' . adforest_color_text($element_title) . '</h2>
                                </div>
                                <div class="tabbable-panel">
                                    <div class="tabbable-line">
                                        <ul class="nav nav-tabs ">
                                           ' . ($categories_html) . ' 
                                        </ul>
                                        <div class="tab-content">' . ($ads_html) . '</div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12"> <div class="prop-estate-select-categories">' . adforest_ThemeBtn($more_ads, 'btn btn-theme') . '</div> </div>
                            </div>
                        </div>
                    </div>
                </section>';

        return $html;
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('ads_tabs_modern6', 'ads_tabs_modern6_callback');
}



    