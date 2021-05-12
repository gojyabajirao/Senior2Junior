<?php

/* ------------------------------------------------ */
/* Search Modern */
/* ------------------------------------------------ */
if (!function_exists('search_modern_short')) {

    function search_modern_short() {

        $cat_array = array();

        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat');

        vc_map(array(
            "name" => __("Search - Modern", 'adforest'),
            "base" => "search_modern_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('search-modern.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Tagline", 'adforest'),
                    "description" => __("%count% for total ads.", 'adforest'),
                    "param_name" => "section_tag_line",
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Search Place holder", 'adforest'),
                    "param_name" => "m_search_placeholder",
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Search Place holder", 'adforest'),
                    "param_name" => "m_location_placeholder",
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Display tags?", 'adforest'),
                    "param_name" => "is_display_tags",
                    "admin_label" => true,
                    "value" => array(
                        __('Select Option', 'adforest') => '',
                        __('Yes', 'adforest') => '1',
                        __('No', 'adforest') => '0'
                    ),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Max number of tags", 'adforest'),
                    "param_name" => "max_tags_limit",
                    "admin_label" => true,
                    "value" => range(1, 500),
                    'dependency' => array(
                        'element' => 'is_display_tags',
                        'value' => array('1'),
                    ),
                ),
                array(
                    "group" => __("Location type", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Location type", 'adforest'),
                    "param_name" => "location_type",
                    "admin_label" => true,
                    "value" => array(
                        __('Google', 'adforest') => 'g_locations',
                        __('Custom Location', 'adforest') => 'custom_locations',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                apply_filters('adforest_admin_category_load_field', array()),
                array
                    (
                    'group' => __('Categories', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category ( All or Selective )', 'adforest'),
                    'param_name' => 'cats',
                    'value' => '',
                    'dependency' => array(
                        'element' => 'cat_frontend_switch',
                        'value' => array(''),
                    ),
                    'params' => array
                        ($cat_array)
                ),
                array(
                    'group' => __('Cosutom Loctions', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Location', 'adforest'),
                    'param_name' => 'locations',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => __("Category", 'adforest'),
                            "param_name" => "location",
                            "admin_label" => true,
                            "value" => adforest_cats('ad_country', 'yes'),
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'search_modern_short');
if (!function_exists('search_modern_short_base_func')) {

    function search_modern_short_base_func($atts, $content = '') {
        extract(shortcode_atts(array(
            'bg_img' => '',
            'section_title' => '',
            'section_tag_line' => '',
            'm_search_placeholder' => '',
            'm_location_placeholder' => '',
            'max_tags_limit' => '',
            'is_display_tags' => '',
            'cats' => '',
            'location_type' => '',
            'locations' => '',
                        ), $atts));
        global $adforest_theme;

        $cats_html = '';

        $jax_cat_class = '';
        if (isset($atts['cat_frontend_switch']) && $atts['cat_frontend_switch'] == 'ajax_based') {
            $jax_cat_class = 'sb-load-ajax-cats ';
        } else {
            if (isset($atts['cats'])) {
                $rows = vc_param_group_parse_atts($atts['cats']);
                $rows = apply_filters('adforest_validate_term_type', $rows);
                $cats = false;
                if (count($rows) > 0) {
                    $cats_html .= '';
                    foreach ($rows as $row) {
                        if (isset($row['cat'])) {
                            if ($row['cat'] == 'all') {
                                $cats = true;
                                $cats_html = '';
                                break;
                            }
                            $term = get_term($row['cat'], 'ad_cats');
                            $cats_html .= '<option value="' . $row['cat'] . '">' . $term->name . '</option>';
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


        // For custom locations
        $locations_html = '';
        $args_loc = array('hide_empty' => 0);
       
        $rows = vc_param_group_parse_atts(isset($atts['locations']) && $atts['locations'] != '' ? $atts['locations'] : '');
        if (isset($rows[0]['location']) && $rows[0]['location'] == 'all' && $location_type == 'custom_locations') {
            $locations_html .= ' <option value="">' . esc_html__('Select location', 'adforest') . ' </option> ';

            if (isset($adforest_theme['display_taxonomies']) && $adforest_theme['display_taxonomies'] == 'hierarchical') {

                $args = array(
                    'type' => 'html',
                    'taxonomy' => 'ad_country',
                    'tag' => 'option',
                    'parent_id' => 0,
                );
                $locations_html = apply_filters('adforest_tax_hierarchy', $locations_html, $args);
            } else {
                 $ad_country_arr = get_terms('ad_country', $args_loc);
                if (isset($ad_country_arr) && count($ad_country_arr) > 0) {
                    foreach ($ad_country_arr as $loc_value) {
                        $locations_html .= ' <option value="' . intval($loc_value->term_id) . '">' . esc_html($loc_value->name) . ' </option> ';
                    }
                }
            }
        } else {
            if (count((array) $rows) > 0 && $rows[0]['location'] != 'all') {
                $locations_html .= '';
                foreach ($rows as $row) {
                    if (isset($row['location'])) {
                        $term = get_term($row['location'], 'ad_country');
                        $locations_html .= ' <option value="' . $row['location'] . '">' . $term->name . '</option> ';
                    }
                }
            }
        }




        $style = '';
        if ($bg_img != "") {
            $bgImageURL = adforest_returnImgSrc($bg_img);
            $style = ( $bgImageURL != "" ) ? ' style="background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ')  no-repeat scroll center center / cover ;"' : "";
        }
        $tags = '';
        if ($is_display_tags == 1) {
            $tags = '<div class="hero-form-sub">
                  <strong class="hidden-sm-down">' . __('Popular Tags', 'adforest') . '</strong>';
            $args = array(
                'smallest' => 12,
                'largest' => 12,
                'unit' => 'px',
                'number' => $max_tags_limit,
                'format' => 'list',
                'separator' => "\n",
                'orderby' => 'name',
                'order' => 'ASC',
                'link' => 'view',
                'taxonomy' => 'ad_tags',
                'echo' => false,
            );
            $tags .= wp_tag_cloud($args);
            $tags .= '</div>';
        }

        $search_placeholder = __('Search here...', 'adforest');
        if (isset($m_search_placeholder) && $m_search_placeholder != "") {
            $search_placeholder = $m_search_placeholder;
        }

        $location_placeholder = __('Location...', 'adforest');
        if (isset($m_location_placeholder) && $m_location_placeholder != "") {
            $location_placeholder = $m_location_placeholder;
        }





        $location_type_html = '';
        $contries_script = '';
        if ($location_type == 'custom_locations') {
            $location_type_html = '<select class="category form-control" name="country_id">
                                        <option label="' . __('Select Location', 'adforest') . '" value="">' . __('Select Location', 'adforest') . '</option>
                                        ' . $locations_html . '
                                        </select>';
        } else {
            ob_start();

            adforest_load_search_countries();
            $contries_script = ob_get_contents();
            ob_end_clean();

            wp_enqueue_script('google-map-callback');
            $location_type_html = '<input type="text" name="location" id="sb_user_address" placeholder="' . esc_attr($location_placeholder) . '">';
        }

        $count_posts = wp_count_posts('ad_post');

        $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
        return $contries_script . ' <section class="main-search parallex " ' . $style . '>
                    <div class="container">
                          <div class="row">
                          <div class="col-md-12">
                             <div class="main-search-title">
                                <h1>' . esc_html($section_title) . '</h1>
                                <p>' . str_replace('%count%', '<strong>' . $count_posts->publish . '</strong>', $section_tag_line) . '</p>
                             </div>
                             <form method="get" action="' . urldecode(get_the_permalink($sb_search_page)) . '">
                             <div class="search-section">
                                <div id="form-panel">
                                   <ul class="list-unstyled search-options clearfix">
                                      <li>
                                        <select class="' . $jax_cat_class . 'category form-control" name="cat_id" data-placeholder="' . __('Select Category', 'adforest') . '">
                                        <option label="' . __('Select Category', 'adforest') . '" value="">' . __('Select Category', 'adforest') . '</option>
                                                ' . $cats_html . '
                                        </select>
                                      </li>
                                      <li>
                                         <input type="text" autocomplete="off" name="ad_title" placeholder="' . esc_attr($search_placeholder) . '">
                                      </li>
                                      <li>
                                         ' . $location_type_html . '
                                      </li>
                                      ' . apply_filters('adforest_form_lang_field', false) . '
                                      <li>
                                         <button type="submit" class="btn btn-danger btn-lg btn-block btn-theme">' . __('Search', 'adforest') . '</button>
                                      </li>
                                   </ul>
                                  ' . $tags . '
                                </div>
                             </div>
                                     </form>
                             </div>
                             </div>
                           </div>
                          </section>';
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('search_modern_short_base', 'search_modern_short_base_func');
}