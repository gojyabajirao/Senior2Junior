<?php

/* ------------------------------------------------ */
/* Search Modern */
/* ------------------------------------------------ */
if (!function_exists('search_modern_type_short')) {

    function search_modern_type_short() {

        $cat_array = array();
        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat');
        $cat_array1 = array();
        $cat_array1 = apply_filters('adforest_ajax_load_categories', $cat_array1, 'cat', 'no');

        vc_map(array(
            "name" => __("Search - Modern(New)", 'adforest'),
            "base" => "search_modern_type_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('search_modern_new.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Category link Page", 'adforest'),
                    "param_name" => "cat_link_page",
                    "admin_label" => true,
                    "value" => array(
                        __('Search Page', 'adforest') => 'search',
                        __('Category Page', 'adforest') => 'category',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => __("Background Image", 'adforest'),
                    "param_name" => "bg_img",
                    "description" => __("1280x800", 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Title", 'adforest'),
                    "param_name" => "section_title",
                    "description" => esc_html__("For bold the text;<strong>Your text</strong> and %count% for total ads.", 'adforest'),
                ),
                apply_filters('adforest_admin_category_load_field', array(), __("Dropdown Categories", "adforest")),
                array
                    (
                    'group' => __('Dropdown Categories', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category ( All or Selective )', 'adforest'),
                    'param_name' => 'cats',
                    'dependency' => array(
                        'element' => 'cat_frontend_switch',
                        'value' => array(''),
                    ),
                    'value' => '',
                    'params' => array
                        ($cat_array)
                ),
                array
                    (
                    'group' => __('Categories', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category', 'adforest'),
                    'param_name' => 'cats_round',
                    'value' => '',
                    'params' => array
                        (
                        $cat_array1,
                        array(
                            "group" => __("Basic", "adforest"),
                            "type" => "attach_image",
                            "holder" => "img",
                            "heading" => __("Category Image", 'adforest'),
                            "param_name" => "img",
                            "description" => __('100x100', 'adforest'),
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'search_modern_type_short');
if (!function_exists('search_modern_type_short_base_func')) {

    function search_modern_type_short_base_func($atts, $content = '') {
        extract(shortcode_atts(array(
            'bg_img' => '',
            'cat_link_page' => '',
            'section_title' => '',
            'cats' => '',
            'cats_round' => '',
                        ), $atts));
        global $adforest_theme;

        $cats = false;
        $cats_html = '';

        $jax_cat_class = '';
        if (isset($atts['cat_frontend_switch']) && $atts['cat_frontend_switch'] == 'ajax_based') {
            $jax_cat_class = 'sb-load-ajax-cats ';
        } else {
            $cats_data = isset($atts['cats']) && $atts['cats'] != '' ? $atts['cats'] : '';

            if ($cats_data != '') {
                $rows = vc_param_group_parse_atts($cats_data);
                $rows = apply_filters('adforest_validate_term_type', $rows);
                if (isset($rows) && is_array($rows) && !empty($rows[0]) && count($rows) > 0) {
                    $cats_html .= '';
                    foreach ($rows as $row) {
                        if (isset($row['cat'])) {
                            if ($row['cat'] == 'all') {
                                $cats = true;
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
        }

        $cats_round_html = '';

        $cats_round_data = isset($atts['cats_round']) && $atts['cats_round'] != '' ? $atts['cats_round'] : '';

        if ($cats_round_data != '') {
            $rows = vc_param_group_parse_atts($cats_round_data);
            $rows = apply_filters('adforest_validate_term_type', $rows);
            if (isset($rows) && !empty($rows) && is_array($rows) && count($rows) > 0) {
                foreach ($rows as $row) {
                    if (isset($row['cat']) && $row['cat'] != '') {
                        $term = get_term($row['cat'], 'ad_cats');
                        if ($term) {
                            $bgImageURL = adforest_returnImgSrc(isset($row['img']) && $row['img'] != '' ? $row['img'] : 0);
                            $cats_round_html .= '<div class="c-icon"> <a href="' . adforest_cat_link_page($row['cat'], $cat_link_page) . '" class="hover"><img alt="' . $term->name . '" src="' . esc_url($bgImageURL) . '" title="' . $term->name . '" width="100" height="100"></a> </div>';
                        }
                    }
                }
            }
        }



        $style = '';
        if ($bg_img != "") {
            $bgImageURL = adforest_returnImgSrc($bg_img);
            $style = ( $bgImageURL != "" ) ? ' style="background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ')  no-repeat scroll center center / cover ;"' : "";
        }


        $search_placeholder = __('Search...', 'adforest');
        $count_posts = wp_count_posts('ad_post');
        $main_title = str_replace('%count%', '<b>' . $count_posts->publish . '</b>', $section_title);
        $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
        return '<div class="modern_sample" ' . $style . '>
          <div class="container">
                <div class="content">
                    <h1 class="tx-smooth">' . $main_title . '</h1>
                    <form method="get" action="' . urldecode(get_the_permalink($sb_search_page)) . '">
             <div class="search-section">
                <div id="form-panel">
                   <ul class="list-unstyled search-options clearfix">
                      <li>
                        <select class="' . $jax_cat_class . 'category form-control" name="cat_id">
			     <option label="' . __('Select Category', 'adforest') . '" value="">' . __('Select Category', 'adforest') . '</option>
							' . $cats_html . '
			</select>	
                      </li>
                      <li>
                         <input type="text" autocomplete="off" name="ad_title" placeholder="' . esc_attr($search_placeholder) . '">
                      </li>
                      ' . apply_filters('adforest_form_lang_field', false) . '
                      <li>
                         <button type="submit" class="btn btn-danger btn-lg btn-block btn-theme">' . __('Search', 'adforest') . '</button>
                      </li>
                   </ul>
                </div>
             </div>
             </form>
                </div> 
                <div class="new-categoy">
                    <div class="cat_lists">	' . $cats_round_html . ' </div>
                </div>
        </div>
    </div>';
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('search_modern_type_short_base', 'search_modern_type_short_base_func');
}