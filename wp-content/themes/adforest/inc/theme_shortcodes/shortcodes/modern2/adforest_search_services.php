<?php

/* ------------------------------------------------ */
/* Search - Services */
/* ------------------------------------------------ */
if (!function_exists('adforest_search_services_short')) {

    function adforest_search_services_short() {
        vc_map(array(
            "name" => __("Search - Services", 'adforest'),
            "base" => "adforest_search_services",
            "category" => __("Theme Shortcodes - 2", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('search-services.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("Section Title", "adforest"),
                    "param_name" => "section_title",
                    "value" => '',
                    "description" => '',
                    'group' => __('Basic', 'adforest'),
                ),
                array(
                    "type" => "textarea",
                    "class" => "",
                    "heading" => __("Section Description", "adforest"),
                    "param_name" => "section_description",
                    "value" => '',
                    "description" => __("Enter section description here .", "adforest"),
                    'group' => __('Basic', 'adforest'),
                ),
                array(
                    "group" => __("Search Settings", "adforest"),
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
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("Search Keyword Label", "adforest"),
                    "param_name" => "keyword_label",
                    "value" => __("Search Keyword", "adforest"),
                    "description" => '',
                    'group' => __('Search Settings', 'adforest'),
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("Search Location Label", "adforest"),
                    "param_name" => "location_label",
                    "value" => __("Select Location", "adforest"),
                    "description" => '',
                    'group' => __('Search Settings', 'adforest'),
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("Search Ads Type Label", "adforest"),
                    "param_name" => "type_label",
                    "value" => __("Select Ads Type", "adforest"),
                    "description" => '',
                    'group' => __('Search Settings', 'adforest'),
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

add_action('vc_before_init', 'adforest_search_services_short');
if (!function_exists('adforest_search_services_func_callback')) {

    function adforest_search_services_func_callback($atts, $content = '') {
        extract(shortcode_atts(array(
            'header_style' => '',
            'section_title' => '',
            'section_description' => '',
            'keyword_label' => __("Search Keyword", "adforest"),
            'location_label' => __("Select Location", "adforest"),
            'type_label' => __("Select Ads Type", "adforest"),
            'location_type' => '',
            'locations' => '',
                        ), $atts));
        global $adforest_theme;
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";

        wp_enqueue_script('select-2');
        $ad_type_arr = adforest_cats('ad_type', 'no');
        $ad_country_arr = adforest_cats('ad_country', 'no');


        $args = array('hide_empty' => 0);
        $args = apply_filters('adforest_wpml_show_all_posts', $args); // for all lang texonomies

        $ad_type_arr = get_terms('ad_type', $args);
        $type_html = ' <option value="">' . esc_html__('Select type', 'adforest') . ' </option> ';
        if (isset($ad_type_arr) && count($ad_type_arr) > 0) {
            foreach ($ad_type_arr as $type_value) {
                $type_html .= ' <option value="' . esc_attr($type_value->name) . '">' . esc_html($type_value->name) . ' </option> ';
            }
        }


        $final_loc_html = '';
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

        $contries_script = '';
        if ($location_type == 'custom_locations') {
            $final_loc_html .= '<select class="js-example-basic-single" name="country_id">';
            $final_loc_html .= $locations_html;
            $final_loc_html .= '</select>';
        } else {
            ob_start();

            adforest_load_search_countries();

            $contries_script = ob_get_contents();
            ob_end_clean();

            wp_enqueue_script('google-map-callback');
            $final_loc_html = '<input class="form-control" name="location" id="sb_user_address" placeholder="' . __('Location...', 'adforest') . '"  type="text">';
        }
        $html = '';
        if ((isset($section_title) && !empty($section_title)) || (isset($section_description) && !empty($section_description))) {
            $html .= ($header);
        }

        $html .= $contries_script;

        $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
        $html .= '<div class="srvs-search-bars">
                <section class="prop-search-box">
                <div class="container">
                  <div class="row">
                   <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                  <form class="form-join" action="' . urldecode(get_the_permalink($sb_search_page)) . '" onsubmit="adforest_disableEmptyInputs(this)">
                    <div class="prop-search-contents">
                      
                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                          
                            <div class="prop-search-bar">
                              <div class="form-group">
                                <label>' . adforest_returnEcho($keyword_label) . '</label>
                                <input type="text" placeholder="' . esc_html__('Enter ad title here', 'adforest') . '" class="form-control" name="ad_title" autocomplete="off">
                              </div>
                            </div>
                         
                        </div>
                        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                          
                            <label>' . adforest_returnEcho($location_label) . '</label>
                            
                              ' . adforest_returnEcho($final_loc_html) . '
                        </div>
                        <div class="col-lg-4 col-xs-12 col-sm-3 col-md-3">
                          
                            <label>' . adforest_returnEcho($type_label) . '</label>
                            <select class="js-example-basic-single" name="ad_type">
                            ' . adforest_returnEcho($type_html) . '
                            </select>
                          
                        </div>
                        <div class="col-lg-1 col-sm-1 col-md-1 col-xs-12">
                          ' . apply_filters('adforest_form_lang_field', false) . '
                            <div class="prop-search-categories"> <button class="btn btn-theme" type="submit"><i class="fa fa-search"></i></button></div>
                          
                        </div>
                     
                    </div>
                   </form>
                  </div>
                 </div>
                </div>
              </section></div>';

        return $html;
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('adforest_search_services', 'adforest_search_services_func_callback');
}