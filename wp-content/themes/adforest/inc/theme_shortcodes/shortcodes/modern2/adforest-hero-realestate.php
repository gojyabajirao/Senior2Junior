<?php

/* ------------------------------------------------ */
/* ADs - Google Map 2 */
/* ------------------------------------------------ */
if (!function_exists('adforest_hero_realestate')) {

    function adforest_hero_realestate() {

        $cat_array = array();
        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat', 'no');
        $cat_array1 = array();
        $cat_array1 = apply_filters('adforest_ajax_load_categories', $cat_array1, 'cat');

        vc_map(array(
            "name" => __("Adforest Hero - Realestate", 'adforest'),
            "base" => "adforest_hero_realestate_base",
            "category" => __("Theme Shortcodes - 2", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('adforest-hero-realestate.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Ads Settings", "adforest"),
                    "type" => "textfield",
                    "heading" => __("Ads Title", 'adforest'),
                    "description" => __("Add the title of ads that dispaly at the top of the sidebar ads listings.", 'adforest'),
                    "param_name" => "ads_title",
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
                    "heading" => __("Number fo Ads for each category", 'adforest'),
                    "param_name" => "no_of_ads",
                    "admin_label" => true,
                    "value" => range(1, 500),
                ),
                array(
                    "group" => __("Banner Setting", "adforest"),
                    "type" => "attach_image",
                    "class" => "",
                    "heading" => __("Section Background Image", 'adforest'),
                    "param_name" => "sec_bg_img",
                    "description" => __("2020x899", 'adforest'),
                ),
                array(
                    "group" => __("Banner Setting", "adforest"),
                    "type" => "attach_image",
                    "class" => "",
                    "heading" => __("Section Image", 'adforest'),
                    "param_name" => "sec_img",
                    "description" => __("536x703", 'adforest'),
                ),
                array(
                    "group" => __("Banner Setting", "adforest"),
                    "type" => "textfield",
                    "heading" => __("Heading", 'adforest'),
                    "description" => '',
                    "param_name" => "sec_heading",
                ),
                array(
                    "group" => __("Banner Setting", "adforest"),
                    "type" => "textfield",
                    "heading" => __("Sub Heading", 'adforest'),
                    "param_name" => "sec_subheading",
                ),
                apply_filters('adforest_admin_category_load_field', array(), __("Dropdown Categories", "adforest")),
                array
                    (
                    'group' => __('Dropdown Categories', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category ( All or Selective )', 'adforest'),
                    'param_name' => 'cats_d',
                    'dependency' => array(
                        'element' => 'cat_frontend_switch',
                        'value' => array(''),
                    ),
                    'value' => '',
                    'params' => array
                        ($cat_array1)
                ),
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

add_action('vc_before_init', 'adforest_hero_realestate');
if (!function_exists('adforest_hero_realestate_base_func')) {

    function adforest_hero_realestate_base_func($atts, $content = '') {
        global $adforest_theme;
        extract(shortcode_atts(array(
            'cats' => '',
            'ads_title' => '',
            'ad_type' => '',
            'ad_order' => '',
            'no_of_ads' => '',
            'sec_bg_img' => '',
            'sec_img' => '',
            'sec_heading' => '',
            'sec_subheading' => '',
                        ), $atts));
        wp_enqueue_style('adforest-perfect-scrollbar');
        wp_enqueue_script('adforest-perfect-scrollbar');
        $rows = array();
        $cats_html = '';


        $jax_cat_class = '';
        if (isset($atts['cat_frontend_switch']) && $atts['cat_frontend_switch'] == 'ajax_based') {
            $jax_cat_class = 'sb-load-ajax-cats ';
        } else {
            $rows_d = vc_param_group_parse_atts($atts['cats_d']);
            $rows_d = apply_filters('adforest_validate_term_type', $rows_d);
            if (count($rows_d) > 0) {
                $cats_html .= '';
                $cats = FALSE;
                foreach ($rows_d as $row) {
                    if (isset($row['cat'])) {
                        if ($row['cat'] == 'all') {
                            $cats = TRUE;
                            $cats_html = '';
                            break;
                        }
                        $term = get_term($row['cat'], 'ad_cats');
                        if ($term) {
                            $cats_html .= '<option value="' . $row['cat'] . '">' . $term->name . '</option>';
                        }
                    }
                }
                if ($cats) {

                    if (isset($adforest_theme['display_taxonomies']) && $adforest_theme['display_taxonomies'] == 'hierarchical') {
                        $args = array(
                            'type' => 'html',
                            'taxonomy' => 'ad_cats',
                            'tag' => 'option',
                            'parent_id' => 0,
                        );
                        $cats_html = apply_filters('adforest_tax_hierarchy', $cats_html, $args);
                    } else {
                        $args = array('hide_empty' => 0);
                        $args = apply_filters('adforest_wpml_show_all_posts', $args); // for all lang texonomies
                        $ad_cats = get_terms('ad_cats', $args);
                        foreach ($ad_cats as $cat) {
                            $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '</option>';
                        }
                    }
                }
            }
        }

        $ads_html = '';
        $ads = new ads();
        $rows = vc_param_group_parse_atts($atts['cats']);
        $rows = apply_filters('adforest_validate_term_type', $rows);
        $args = array('hide_empty' => 0);
        $args = apply_filters('adforest_wpml_show_all_posts', $args); // for all lang texonomies
        $ad_type_arr = get_terms('ad_type', $args);

        $type_html = ' <option value="">' . esc_html__('Select type', 'adforest') . ' </option> ';
        if (isset($ad_type_arr) && count($ad_type_arr) > 0) {
            foreach ($ad_type_arr as $type_value) {
                $type_html .= ' <option value="' . esc_attr($type_value->name) . '">' . esc_html($type_value->name) . ' </option> ';
            }
        }


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
            'post_status ' => 'publish',
            'posts_per_page' => $no_of_ads,
            'meta_query' => array(
                array(
                    'key' => '_adforest_ad_status_',
                    'value' => 'active',
                    'compare' => '=',
                ),
            ),
            'orderby' => $order_by,
            'order' => $ordering,
        );


        if ($category != '') {
            $args['tax_query'][] = $category;
        }
        if ($countries_location != '') {
            $args['tax_query'][] = $countries_location;
        }

        if ($ad_type == 'feature') {
            $args['meta_query'][] = array(
                'key' => '_adforest_is_feature',
                'value' => 1,
                'compare' => '=',
            );
        } else if ($ad_type == 'both') {
            
        } else {
            $args['meta_query'][] = array(
                'key' => '_adforest_is_feature',
                'value' => 0,
                'compare' => '=',
            );
        }



        $args = apply_filters('adforest_wpml_show_all_posts', $args);

        $results = new WP_Query($args);
        if ($results->have_posts()) {
            $marker_counter = 1;
            while ($results->have_posts()) {
                $results->the_post();
                $pid = get_the_ID();
                $title = get_the_title();
                $ads_html .= $ads->adforest_search_layout_list_4(get_the_ID());
            }
        }

        $style_bg = '';
        if (isset($sec_bg_img) && !empty($sec_bg_img)) {
            $hero_src_url = adforest_returnImgSrc($sec_bg_img);
            $style_bg = ' style="background: url(' . $hero_src_url . ');"';
        }
        $sec_img_src_url = '#';
        if (isset($sec_img) && !empty($sec_img)) {
            $sec_img_src_url = adforest_returnImgSrc($sec_img);
        }
        $rand_id = rand(123, 123456);
        $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
        $html = '';
        $html .= '<section class="prop-hero-latest"' . adforest_returnEcho($style_bg) . '>
                    <div class="container-fluid no-padding">
                        <div class="row">
                            <div class="col-lg-8 col-xs-12 col-sm-6 col-md-7">
                                <div class="col-lg-7 col-md-6 col-xs-12 col-sm-12">
                                    <div class="prop-latest-selections">
                                        <img src="' . esc_url($sec_img_src_url) . '" alt="' . esc_html__('Setion image', 'adforest') . '" class="img-responsive">
                                    </div>
                                </div>
                                <div class="col-lg-5 col-sm-12 col-md-12 col-xs-12">
                                    <div class="prop-latest-content-area">
                                        <div class="prop-latest-text">
                                            <h1>' . esc_html($sec_heading) . '</h1>
                                            <p>' . esc_html($sec_subheading) . '</p>
                                        </div>
                                        <div class="prop-latest-textfields">
                                            <form action="' . get_the_permalink($sb_search_page) . '" onsubmit="adforest_disableEmptyInputs(this)">
                                                <div class="form-group">
                                                    <input type="text" placeholder="' . esc_html__('Enter ad title here', 'adforest') . '" class="form-control" name="ad_title">
                                                </div>
                                                <div class="form-group">
                                                    <select class="' . $jax_cat_class . 'js-example-basic-single" name="cat_id">
                                                        ' . adforest_returnEcho($cats_html) . '
                                                    </select>
                                                    <div class="prop-sumit-form">
                                                       <button class="btn btn-theme" type="submit"><i class="fa fa-search"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xs-12 col-sm-6 col-md-5">
                            <div class="prop-main-wrapped">
                                <div class="adforest-real prop-hero-text-section">
                                        <h3>' . esc_html($ads_title) . '</h3>
                                    </div>
                                <div class="scrollbar-wrap scrolable-ads" id="scrolable-ads-' . $rand_id . '">
                                    ' . $ads_html . '
                                </div>
                            </div>
                           </div>
                        </div>
                    </div>
                </section>';
        $html .= ' <script type="text/javascript">
                    jQuery( document ).ready(function() {
                        const ps = new PerfectScrollbar("#scrolable-ads-' . $rand_id . '");
                    });
                    </script>';

        return $html;
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('adforest_hero_realestate_base', 'adforest_hero_realestate_base_func');
}


