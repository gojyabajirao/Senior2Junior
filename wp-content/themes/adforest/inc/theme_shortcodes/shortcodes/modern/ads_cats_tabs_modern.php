<?php

/* ------------------------------------------------ */
/* Ads- Cats based boxes */
/* ------------------------------------------------ */
if (!function_exists('ads_cats_tabs_short')) {

    function ads_cats_tabs_short() {
        $grid_array;
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
                __('List', 'adforest') => 'list',
            );
        } else {
            $grid_array = array(
                __('Select Layout Type', 'adforest') => '',
                __('Grid 1', 'adforest') => 'grid_1',
                __('Grid 2', 'adforest') => 'grid_2',
                __('Grid 3', 'adforest') => 'grid_3',
                __('List', 'adforest') => 'list',
            );
        }

        $cat_array = array();

        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat','no');

        vc_map(array(
            "name" => __("ADs Tabs Modern", 'adforest'),
            "description" => __("Once on a Page.", 'adforest'),
            "base" => "ads_cats_tabs_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('ad_cat_tab.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => __("Background Image", 'adforest'),
                    "param_name" => "bg_img",
                    'dependency' => array(
                        'element' => 'section_bg',
                        'value' => array('img'),
                    ),
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
                    "heading" => __("Layout Type", 'adforest'),
                    "param_name" => "layout_type",
                    "admin_label" => true,
                    "value" => $grid_array,
                ),
                array(
                    "group" => __("Ads Settings", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Number fo Ads for each category", 'adforest'),
                    "param_name" => "no_of_ads",
                    "admin_label" => true,
                    "value" => range(1, 500),
                ),
                //Group For Left Section
                array
                    (
                    'group' => __('Categories', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category', 'adforest'),
                    'param_name' => 'cats',
                    'value' => '',
                    'params' => array
                        ($cat_array)
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'ads_cats_tabs_short');

if (!function_exists('ads_cats_tabs_short_base_func')) {

    function ads_cats_tabs_short_base_func($atts, $content = '') {
        global $adforest_theme;
        $no_title = 'yes';
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        extract(shortcode_atts(array(
            'cats' => '',
            'ad_type' => '',
            'layout_type' => 'grid_1',
            'ad_order' => '',
            'no_of_ads' => '',
                        ), $atts));

        $is_type = '';
        if ($ad_type == 'feature') {
            $is_type = 1;
        } else {
            $is_type = 0;
        }

        $cats = array();
        //$rows = vc_param_group_parse_atts($atts['cats']);
        
        $cats_data = isset($atts['cats']) && $atts['cats'] != '' ? $atts['cats'] : '';
        
        
        $rows = apply_filters('adforest_validate_term_type',$cats_data);
        $categories_html = '';
        $ads_html = '';
        $counnt = 1;
        $ads = new ads();
         if (isset($rows) && is_array($rows) && !empty($rows[0]) && count($rows) > 0) {
            $categories_html .= '';

            $adforest_tab = 'ad-tab-';
            foreach ($rows as $row) {
                $rand_id = rand(1234, 99999);
                if (isset($row['cat'])) {
                    $is_active = '';
                    if ($counnt == 1) {
                        $is_active = 'active';
                        $counnt++;
                    }

                    $cat_obj = get_term($row['cat']);
                    if (count((array) $cat_obj) == 0)
                        continue;

                    $categories_html .= '<li role="presentation" class="' . esc_attr($is_active) . '">
					<a href="#' . $adforest_tab . $rand_id . '" aria-controls="home" role="tab" data-toggle="tab" title="' . $cat_obj->name . '">' . $cat_obj->name . '</a></li>';

                    $ads_html .= '<div role="tabpanel" class="tab-pane fade in ' . esc_attr($is_active) . '" id="' . $adforest_tab . $rand_id . '">';

                    if ($layout_type == 'list')
                        $ads_html .= '<ul>';
                    else
                        $ads_html .= '';

                    $category = array(
                        array(
                            'taxonomy' => 'ad_cats',
                            'field' => 'term_id',
                            'terms' => $row['cat'],
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
                            $ads_html .= $ads->$function(get_the_ID(), 3);
                        }
                    }

                    if ($layout_type == 'list')
                        $ads_html .= '</ul></div>';
                    else
                        $ads_html .= '</div>';

                    $ads_html .= '';
                }
            }
        }

        wp_reset_postdata();

        return '<section class="custom-padding new-shortcode ' . $bg_color . '">
			<div class="container">
			<div class="row clear-custom">
                            ' . $header . '
                            <div class="tab" role="tabpanel">
                                    <ul class="nav nav-tabs" role="tablist" >' . $categories_html . ' </ul>
                                    <div class="tab-content tabs"> ' . $ads_html . ' </div>
                            </div>
			</div>
		</div>
		</section>';
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('ads_cats_tabs_short_base', 'ads_cats_tabs_short_base_func');
}