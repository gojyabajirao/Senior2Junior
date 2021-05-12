<?php

/* ------------------------------------------------ */
/* Search Simple */
/* ------------------------------------------------ */
if (!function_exists('search_hero2_short')) {

    function search_hero2_short() {

        $cat_array = array();

        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat');

        vc_map(array(
            "name" => __("Search - Hero", 'adforest'),
            "base" => "search_hero2_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "show_settings_on_create" => true,
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('search_hero.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
                    "description" => __("%count% for total ads.", 'adforest'),
                    "param_name" => "section_title",
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Main Title", 'adforest'),
                    "param_name" => "sub_title",
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Button Text", 'adforest'),
                    "param_name" => "btn_text",
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Search Block Text", 'adforest'),
                    "param_name" => "block_text",
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Tagline", 'adforest'),
                    "param_name" => "section_description",
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
                    'dependency' => array(
                        'element' => 'cat_frontend_switch',
                        'value' => array(''),
                    ),
                    'value' => '',
                    'params' => array(
                        $cat_array
                    ),
                ),
                array
                    (
                    'group' => __('Custom Loctions', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Location', 'adforest'),
                    'param_name' => 'locations',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => __("Location", 'adforest'),
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

add_action('vc_before_init', 'search_hero2_short');
if (!function_exists('search_hero2_short_base_func')) {

    function search_hero2_short_base_func($atts, $content = '') {
        extract(shortcode_atts(array(
            'bg_img' => '',
            'section_title' => '',
            'sub_title' => '',
            'section_description' => '',
            'btn_text' => '',
            'block_text' => '',
            'location_type' => '',
            'cats' => '',
            'locations' => '',
                        ), $atts));
        global $adforest_theme;


        $cats = false;
        $cats_html = '';
        $args = array();

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
                $ad_country_arr = get_terms('ad_country', $args);
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
        $search_html = '';
        if ($bg_img != "") {
            $bgImageURL = adforest_returnImgSrc($bg_img);
            $style = ( $bgImageURL != "" ) ? ' style="background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ') center top no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
        }
        $location_type_html = '';
        if ($location_type == 'custom_locations') {
            $location_type_html = '<select class="category form-control" name="country_id">
                <option value="">' . esc_html__('Select Location', 'adforest') . '</option>
               	   ' . $locations_html . '
			   </select>';
        } else {
            ob_start();
            adforest_load_search_countries();
            $search_html .= ob_get_contents();
            ob_end_clean();
            wp_enqueue_script('google-map-callback');
            $location_type_html = '<input class="form-control" name="location" id="sb_user_address" placeholder="' . __('Location...', 'adforest') . '"  type="text">';
        }
        $count_posts = wp_count_posts('ad_post');
        $main_title = str_replace('%count%', '<b>' . $count_posts->publish . '</b>', $section_title);

        $class_attr = (isset($adforest_theme['sb_header']) && $adforest_theme['sb_header'] == 'modern' ) ? 'class="intro-hero-modern-transparent"' : '';

        $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
        $sb_post_ad_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_post_ad_page']);
        $search_html .= '<section id="intro-hero" ' . $style . ' ' . $class_attr . '>
                <div class="container">
                  <div class="row">
                    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 margin-top-50">
                      <span class="hero-title">' . $main_title . '</span>
                      <h1> ' . $sub_title . ' </h1>
                      <p class="hero-tagline"> ' . $section_description . ' </p>
                      <div class="intro-btn">
                        <a href="' . get_the_permalink($sb_post_ad_page) . '" class="btn btn-theme btn-round">' . $btn_text . '</a>
                      </div>
                    </div> <!-- END col-lg-6 hero-text--> 
                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                      <form class="form-join" action="' . urldecode(get_the_permalink($sb_search_page)) . '">
                        <span class="serach-form-heading">' . $block_text . '</span>
                      <div class="form-group">
                         <label for="exampleInputEmail1">' . __('Title', 'adforest') . '</label>
                          <input class="form-control" autocomplete="off" name="ad_title" placeholder="' . __('What Are You Looking For...', 'adforest') . '" type="text"> 
                       </div>
                      <div class="form-group">
                      <label for="exampleInputEmail1">' . __('Select Category', 'adforest') . '</label>
                          <select class="' . $jax_cat_class . 'category form-control" name="cat_id">
                             <option label="' . __('Select Category', 'adforest') . '" value="">' . __('Select Category', 'adforest') . '</option>
                             ' . $cats_html . '
                          </select>
                      </div>
                        <div class="form-group">
                        <label for="exampleInputEmail1">' . __('Location', 'adforest') . '</label>
                           ' . $location_type_html . '
                        </div>
                        ' . apply_filters('adforest_form_lang_field', false) . '
                        <button class="btn btn-theme btn-block" type="submit">' . __('search', 'adforest') . '</button>
                        </form>
                    </div>
                  </div>
                </div>
              </section>';

        return $search_html;
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('search_hero2_short_base', 'search_hero2_short_base_func');
}