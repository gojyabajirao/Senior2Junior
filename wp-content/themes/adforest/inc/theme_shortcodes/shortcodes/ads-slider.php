<?php

/* ------------------------------------------------ */
/* Ads Slider */
/* ------------------------------------------------ */
if (!function_exists('ads_slider_short')) {

    function ads_slider_short() {
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
                __('Grid 10', 'adforest') => 'grid_10'
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
        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat','no');

        vc_map(array(
            "name" => __("ADs - Slider", 'adforest'),
            "description" => __("Once on a Page.", 'adforest'),
            "base" => "ads_slider_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('ad_slider.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
                    "heading" => __("Number fo Ads", 'adforest'),
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
                        (
                        $cat_array,
                        array(
                            'type' => 'iconpicker',
                            'heading' => __('Icon', 'adforest'),
                            'param_name' => 'icon',
                            'settings' => array(
                                'emptyIcon' => false,
                                'type' => 'classified',
                                'iconsPerPage' => 100, // default 100, how many icons per/page to display
                            ),
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'ads_slider_short');
if (!function_exists('ads_slider_short_base_func')) {

    function ads_slider_short_base_func($atts, $content = '') {
        global $adforest_theme;
        $no_title = 'yes';
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        extract(shortcode_atts(array(
            'cats' => '',
            'ad_type' => '',
            'ad_order' => '',
            'layout_type' => 'grid_1',
            'no_of_ads' => '',
                        ), $atts));

        $is_type = '';
        if ($ad_type == 'feature') {
            $is_type = 1;
        } else if ($ad_type == 'both') {
            $is_type = '';
        } else {
            $is_type = 0;
        }
        $ad_class = '&ad=' . $is_type;
        if ($is_type == "") {
            $ad_class = '';
        }

        $cats = array();
        $rows = vc_param_group_parse_atts($atts['cats']);
        $rows = apply_filters('adforest_validate_term_type',$rows);
        $categories_html = '';
        if (count($rows) > 0) {
            $categories_html .= '<ul class="nav">';
            foreach ($rows as $row) {
                if (isset($row['cat'])) {
                    $cats[] = $row['cat'];
                    $term = get_term($row['cat'], 'ad_cats');
                    if (count((array) $term) == 0)
                        continue;
                    $icon_html = '';
                    if (isset($row['icon']))
                        $icon_html = '<i class="icon fa ' . esc_attr($row['icon']) . '" aria-hidden="true"></i>';

                    $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
                    //$link = get_the_permalink($sb_search_page) . '?cat_id=' . $row['cat'] . $ad_class;
                    $link = adforest_set_url_param(get_the_permalink($sb_search_page), 'cat_id', $row['cat']);
                    $categories_html .= '<li class="dropdown menu-item">
                                 <a href="' . $link . $ad_class . '">' . $icon_html . $term->name . '</a></li>';
                }
            }
            $categories_html .= '</ul>';
        }

        $category = '';
        if (count($cats) > 0) {
            $category = array(
                array(
                    'taxonomy' => 'ad_cats',
                    'field' => 'term_id',
                    'terms' => $cats,
                ),
            );
        }
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
            ),
            'orderby' => $order_by,
            'order' => $ordering,
        );
        $ads_html = '';
        $ads = new ads();
        $args = apply_filters('adforest_wpml_show_all_posts', $args);
        $args = apply_filters('adforest_site_location_ads', $args, 'ads');
        $results = new WP_Query($args);
        if ($results->have_posts()) {

            while ($results->have_posts()) {
                $results->the_post();
                $ads_html .= '<div class="item">';
                $function = "adforest_search_layout_$layout_type";
                $ads_html .= $ads->$function(get_the_ID(), 12, 12, 'slider-');
                $ads_html .= '</div>';
            }

            $col = 4;
            require trailingslashit(get_template_directory()) . "template-parts/layouts/ad_style/search-layout-grid.php";
        }
        wp_reset_postdata();
        $if_white = '';
        if ($bg_color != "gray") {
            $if_white = 'graydark';
        }

        return '<section class="custom-padding ' . $bg_color . '">
            <!-- Main Container -->
            <div class="container">
               <!-- Content Box -->
               <!-- Row -->
               <div class="row">
			   ' . $header . '
                  <div class="col-md-3 col-lg-3 col-xs-12 col-sm-12 sidebar">
					<div class="side-menu ' . $if_white . '">
                        <nav class="yamm megamenu-horizontal">
							' . $categories_html . '
                        </nav>
                     </div>
                  </div>
                  <div class="col-md-9 col-lg-9 col-xs-12 col-sm-12 featured">
                     <div class="row">
                        <div class="featured-slider-5 owl-carousel owl-theme">
							' . $ads_html . '
                        </div>
                     </div>
                  </div>
                  <!-- Middle Content Box End -->
               </div>
            </div>
            <!-- Main Container End -->
         </section>
         <!-- Main Section -->
				  ';
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('ads_slider_short_base', 'ads_slider_short_base_func');
}