<?php

if (!function_exists('adforest_color_text')) {

    function adforest_color_text($str) {
        preg_match_all('~{color}([^{]*){/color}~i', $str, $matches);
        $i = 1;
        $found = array();
        foreach ($matches as $key => $val) {
            if ($i == 2) {
                $found = $val;
            }
            $i++;
        }
        foreach ($found as $k) {
            $search = "{color}" . $k . "{/color}";
            $replace = '<span class="heading-color">' . $k . '</span>';
            $str = str_replace($search, $replace, $str);
        }
        return $str;
    }

}

if (!function_exists('adforest_vc_forntend_edit')) {

    function adforest_vc_forntend_edit() {
        return function_exists('vc_is_inline') && vc_is_inline() ? true : false;
    }

}



if (!function_exists('adforest_color_text_custom_html')) {

    function adforest_color_text_custom_html($str = '', $before = '', $after = '') {
        preg_match_all('~{color}([^{]*){/color}~i', $str, $matches);
        $i = 1;
        $found = array();
        foreach ($matches as $key => $val) {
            if ($i == 2) {
                $found = $val;
            }
            $i++;
        }
        foreach ($found as $k) {
            $search = "{color}" . $k . "{/color}";
            $replace = $before . $k . $after;
            $str = str_replace($search, $replace, $str);
        }
        return $str;
    }

}

// For Section header
if (!function_exists('adforest_getHeader')) {

    function adforest_getHeader($sb_section_title, $sb_section_description, $style = 'classic', $view_all_btn = '') {
        if ($style == 'classic') {
            $desc = '';
            if ($sb_section_description != '') {
                $desc = '<p class="heading-text">' . $sb_section_description . '</p>';
            }
            $main_title = adforest_color_text($sb_section_title);
            return '<div class="text-center">
				 <div class="heading-panel">
					<!-- Main Title -->
					<h2>' . $main_title . '</h2>
					<!-- Short Description -->
					' . $desc . '
				 </div>
			  </div>';
        } else if ($style == 'regular') {
            $sb_section_title = adforest_color_text($sb_section_title);
            return '<div class="heading-panel">
                        <h3 class="main-title text-left">
                           ' . ($sb_section_title) . '
                        </h3>
                     </div>';
        } else if ($style == 'fancy') {
            $sb_section_title = adforest_color_text($sb_section_title);

            $btn_html = '';
            if (isset($view_all_btn) && !empty($view_all_btn)) {
                $btn_html = adforest_ThemeBtn($view_all_btn, "btn btn-theme", false);
            }

            return '<div class="prop-newset-heading">
                       
                        <h2> ' . ($sb_section_title) . '</h2>
                            ' . $btn_html . '
                         
                    </div>';
        }
    }

}

// Get param array
if (!function_exists('adforest_generate_type')) {

    function adforest_generate_type($heading = '', $type = '', $para_name = '', $description = '', $group = '', $values = array(), $default = '', $class = 'vc_col-sm-12 vc_column', $dependency = '', $holder = 'div') {

        $val = '';
        if (is_array($values) && count($values) > 0) {
            $val = $values;
        }

        return array(
            "group" => $group,
            "type" => $type,
            "holder" => $holder,
            "class" => "",
            "heading" => $heading,
            "param_name" => $para_name,
            "value" => $val,
            "description" => $description,
            "edit_field_class" => $class,
            "std" => $default,
            'dependency' => $dependency,
        );
    }

}


if (!function_exists('adforest_ThemeBtn')) {

    function adforest_ThemeBtn($section_btn = '', $class = '', $onlyAttr = false, $iconBefore = '', $iconAfter = '') {
        $buttonHTML = "";
        if (isset($section_btn) && $section_btn != "") {
            $button = adforest_extarct_link($section_btn);
            $class = ( $class != "" ) ? 'class="' . esc_attr($class) . '"' : '';
            $rel = ( isset($button["rel"]) && $button["rel"] != "" ) ? ' rel="' . esc_attr($button["rel"]) . ' "' : "";
            $href = ( isset($button["url"]) && $button["url"] != "" ) ? ' href="' . esc_url($button["url"]) . ' "' : "javascript:void(0);";
            $title = ( isset($button["title"]) && $button["title"] != "" ) ? ' title="' . esc_attr($button["title"]) . '"' : "";
            $target = ( isset($button["target"]) && $button["target"] != "" ) ? ' target="' . esc_attr(trim($button["target"])) . '"' : "";
            $titleText = ( isset($button["title"]) && $button["title"] != "" ) ? esc_html($button["title"]) : "";

            if (isset($button["url"]) && $button["url"] != "") {
                $btn = ( $onlyAttr == true ) ? $href . $target . $class . $rel : '<a ' . $href . ' ' . $target . ' ' . $class . ' ' . $rel . '>' . $iconBefore . ' ' . esc_html($titleText) . ' ' . $iconAfter . '</a>';
                $buttonHTML = ( isset($title) ) ? $btn : "";
            }
        }
        return $buttonHTML;
    }

}

if (!function_exists('adforest_extarct_link')) {

    function adforest_extarct_link($string) {
        $arr = explode('|', $string);
        list($url, $title, $target, $rel) = $arr;
        $rel = urldecode(adforest_themeGetExplode($rel, ':', '1'));
        $url = urldecode(adforest_themeGetExplode($url, ':', '1'));
        $title = urldecode(adforest_themeGetExplode($title, ':', '1'));
        $target = urldecode(adforest_themeGetExplode($target, ':', '1'));
        return array("url" => $url, "title" => $title, "target" => $target, "rel" => $rel);
    }

}


if (!function_exists('adforest_themeGetExplode')) {

    function adforest_themeGetExplode($string = "", $explod = "", $index = "") {
        $ar = '';
        if ($string != "") {
            $exp = explode($explod, $string);
            $ar = ( $index != "" ) ? $exp[$index] : $exp;
        }
        return ( $ar != "" ) ? $ar : "";
    }

}


// BG Color or Image
if (!function_exists('adforest_bg_func')) {

    function adforest_bg_func($sb_bg_color, $sb_bg = '') {
        $bg = '';
        if ($sb_bg_color == 'bg_img') {
            $bgimg = wp_get_attachment_image_src($sb_bg, 'full');
            if ($bgimg[0] != "") {
                $bg = $bgimg[0];
            }
        }
        return array('url' => $bg, 'color' => $sb_bg_color);
    }

}

if (!function_exists('adforest_returnImgSrc')) {

    function adforest_returnImgSrc($id, $size = 'full', $showHtml = false, $class = '', $alt = '') {

        $img = '';
        if (isset($id) && $id != "") {
            if ($showHtml == false) {
                $img1 = wp_get_attachment_image_src($id, $size);
                $img = $img1[0];
            } else {
                $class = ( $class != "" ) ? 'class="' . esc_attr($class) . '"' : '';
                $alt = ( $alt != "" ) ? 'alt="' . esc_attr($alt) . '"' : '';
                $img1 = wp_get_attachment_image_src($id, $size);
                $img = '<img src="' . esc_url($img1[0]) . '" ' . $class . ' ' . $alt . '>';
            }
        }
        return $img;
    }

}

if (!function_exists('adforest_VCImage')) {

    function adforest_VCImage($imgName = '') {
        $val = '';
        if ($imgName != "") {
            $path = esc_url(trailingslashit(get_template_directory_uri()) . 'vc_images/' . $imgName);
            $val = '<img src="' . esc_url($path) . '" style="width:100%" class="img-responsive"  alt="' . esc_attr__('image', 'adforest') . '"  />';
        }

        return $val;
    }

}

// Get cats
if (!function_exists('adforest_cats')) {

    function adforest_cats($taxonomy = 'ad_cats', $all = 'yes') {
        global $sitepress, $adforest_theme;


        if (!is_admin()) {
            return array();
        }


        if ($all == 'yes') {
            $cats = array(__('All', 'adforest') => 'all');
        } else if ($taxonomy == 'ad_country') {
            $cats = array(__('Select Location', 'adforest') => '');
        } else if ($taxonomy == 'ad_warranty') {
            $cats = array(__('Select Warranty', 'adforest') => '');
        } else if ($taxonomy == 'ad_condition') {
            $cats = array(__('Select Condition', 'adforest') => '');
        } else if ($taxonomy == 'ad_type') {
            $cats = array(__('Select Ad Type', 'adforest') => '');
        } else {
            $cats = array();
        }

       // if (isset($adforest_theme['display_taxonomies']) && $adforest_theme['display_taxonomies'] == 'hierarchical') {

//            $args_cat = array(
//                'type' => 'array',
//                'taxonomy' => $taxonomy,
//                'tag' => 'option',
//                'parent_id' => 0,
//                'vc' => true,
//            );

            //$cats = apply_filters('adforest_tax_hierarchy', $cats, $args_cat);
        //} else {

            $args = array('hide_empty' => 0);
            $args = apply_filters('adforest_wpml_show_all_posts', $args); // for all lang texonomies
            $ad_cats = get_terms($taxonomy, $args);

            if (count($ad_cats) > 0) {
                foreach ($ad_cats as $cat) {
                    $count = ($cat->count);
                    $cats[wp_specialchars_decode($cat->name) . ' (' . urldecode_deep($cat->slug) . ')' . ' (' . $count . ')'] = $cat->term_id;
                }
            }
        //}


        return $cats;
    }

}

// Get Products
if (!function_exists('adforest_get_products')) {

    function adforest_get_products() {

        global $adforest_theme;
        $products = array(__('Select Product', 'adforest') => '');

        if (!is_admin()) {
            return $products;
        }

        if (isset($adforest_theme['shop-turn-on']) && $adforest_theme['shop-turn-on']) {
            $args = array(
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_type',
                        'field' => 'slug',
                        'terms' => 'adforest_classified_pkgs'
                    ),
                ),
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'order' => 'DESC',
                'orderby' => 'ID',
            );
        } else {
            $args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'order' => 'DESC',
                'orderby' => 'ID',
            );
        }

        $args = apply_filters('adforest_wpml_show_all_posts', $args);
        $packages = new WP_Query($args);
        if ($packages->have_posts()) {
            while ($packages->have_posts()) {
                $packages->the_post();
                $products[get_the_title()] = get_the_ID();
            }
        }
        return $products;
    }

}

// Get Countries
if (!function_exists('adforest_locations')) {

    function adforest_locations($type) {
        if ($type == 'countries') {
            
        }
    }

}

if (!function_exists('adforest_get_location')) {

    function adforest_get_location($call_back = '') {
        global $adforest_theme;
        $api_key = $adforest_theme['gmap_api_key'];
        return $snippnet = '<script src="https://maps.googleapis.com/maps/api/js?key=' . $api_key . '&libraries=places&callback=' . $call_back . '" type="text/javascript"></script>';
    }

}


// get latitude and longitude
if (!function_exists('adforest_lat_long')) {

    function adforest_lat_long($address) {
        $api_key = $adforest_theme['gmap_api_key'];

        $param = "?address=" . $address . "&key=" . $api_key;
        $url = esc_url("https://maps.googleapis.com/maps/api/geocode/json") . $param;
        $json = wp_remote_get($url);
        $res = $data = json_decode($json['body'], true);

        $latitude = $res['results'][0]['geometry']['location']['lat'];
        $longitude = $res['results'][0]['geometry']['location']['lng'];

        $send_data = array();
        $send_data[] = $latitude;
        $send_data[] = $longitude;

        return $send_data;
    }

}


if (!function_exists('adforest_add_location')) {

    function adforest_add_location($country = '', $state = '', $city = '') {
        global $wpdb;
        $country_data = $wpdb->get_row("SELECT ID FROM $wpdb->posts WHERE post_type = '_sb_country' AND post_title LIKE '%$country%'");

        $country_id = $country_data->ID;

        $table_name = $wpdb->prefix . 'adforest_locations';


        $state_id = 0;

        $is_state = $wpdb->get_row("SELECT lid FROM $table_name WHERE country_id = '$country_id' AND location_type = 'state'  AND name = '$state'");
        if (!isset($is_state->lid)) {
            $res = adforest_lat_long($state . $country);

            $wpdb->query("INSERT INTO $table_name (name,latitude,longitude,country_id,state_id,location_type) VALUES ('" . $state . "','" . $res[0] . "','" . $res[1] . "','" . $country_id . "','$state_id','state')");
            $state_id = $wpdb->insert_id;
        } else {
            $state_id = $is_state->lid;
        }

        $is_city = $wpdb->get_row("SELECT lid FROM $table_name WHERE country_id = '$country_id' AND location_type = 'city'  AND name = '$city'");
        if (!isset($is_city->lid)) {
            $res = adforest_lat_long($city . $country);

            $wpdb->query("INSERT INTO $table_name (name,latitude,longitude,country_id,state_id,location_type) VALUES ('" . $city . "','" . $res[0] . "','" . $res[1] . "','" . $country_id . "','$state_id','city')");
        }
    }

}

// Get lat lon by location
if (!function_exists('adforest_get_latlon')) {

    function adforest_get_latlon($location) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'adforest_locations';
        // Explode location
        $address = explode(',', $location);
        if (count($address) == 1) {
            return array();
        }
        if (count($address) == 3) {
            $country = trim($address[2]);
            $state = trim($address[1]);
            $city = trim($address[0]);
        }
        if (count($address) == 4) {
            $country = trim($address[3]);
            $state = trim($address[2]);
            $city = trim($address[1]);
        } else if (count($address) == 2) {
            $country = trim($address[1]);
            $city = trim($address[0]);
        }
        $country_data = $wpdb->get_row("SELECT ID FROM $wpdb->posts WHERE post_type = '_sb_country' AND post_title LIKE '%$country%'");
        if (count((array) $country_data) == 0) {
            return array();
        }
        $country_id = $country_data->ID;
        $arr = $wpdb->get_row("SELECT latitude,longitude FROM $table_name WHERE country_id = '$country_id' AND location_type = 'city'  AND name = '$city'");
        if (count((array) $arr) > 0) {
            if ($arr->latitude != "" && $arr->longitude != "") {
                return array($arr->latitude, $arr->longitude);
            }
        }
        return array();
    }

}

// Making shortcode function
if (!function_exists('adforest_clean_shortcode')) {

    function adforest_clean_shortcode($string) {
        $replace = str_replace("`{`", "[", $string);
        $replace = str_replace("`}`", "]", $replace);
        $replace = str_replace("``", '"', $replace);
        return $replace;
    }

}


if (!function_exists('adforest_cat_link_page')) {

    function adforest_cat_link_page($category_id, $type = '', $tax = 'cat_id') {
        global $adforest_theme;

        $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
        //$link = get_the_permalink($sb_search_page) . "?$tax=" . $category_id;
        $link = adforest_set_url_param(get_the_permalink($sb_search_page), $tax, $category_id);
        if ($type == 'category') {
            $link = get_term_link((int) $category_id);
        }
        return $link;
    }

}

add_action('wp_ajax_nopriv_fetch_suggestions', 'adforest_listing_live_search');
add_action('wp_ajax_fetch_suggestions', 'adforest_listing_live_search');
if (!function_exists('adforest_listing_live_search')) {

    function adforest_listing_live_search() {
        $return = array();
        $args = array(
            's' => isset($_GET['q']) && !empty($_GET['q']) ? $_GET['q'] : '',
            'post_type' => 'ad_post',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1,
            'posts_per_page' => 25
        );

        $args = apply_filters('adforest_wpml_show_all_posts', $args);
        $args = apply_filters('adforest_site_location_ads', $args, 'ads');
        $search_results = new WP_Query($args);
        if ($search_results->have_posts()) :
            while ($search_results->have_posts()) : $search_results->the_post();
                // shorten the title a little
                $title = $search_results->post->post_title;
                $return[] = adforest_clean_strings($title);
            endwhile;
            wp_reset_postdata();
        endif;
        echo json_encode($return);
        die;
    }

}
if (!function_exists('adforest_clean_strings')) {

    function adforest_clean_strings($string = '') {
        $string = preg_replace('/%u([0-9A-F]+)/', '&#x$1;', $string);
        return html_entity_decode($string, ENT_COMPAT, 'UTF-8');
    }

}

if (!function_exists('adforest_get_ad_default_image_url')) {

    function adforest_get_ad_default_image_url($ad_img_size = '') {
        global $adforest_theme;
        $image_url = $adforest_theme['default_related_image']['url'];
        if (isset($adforest_theme['default_related_image']['id']) && !empty($adforest_theme['default_related_image']['id'])) {
            $image_url = wp_get_attachment_image_src($adforest_theme['default_related_image']['id'], $ad_img_size);
            $image_url = isset($image_url[0]) && !empty($image_url[0]) ? $image_url[0] : $adforest_theme['default_related_image']['url'];
        }
        return $image_url;
    }

}


add_action('wp_ajax_adforest_term_autocomplete', 'adforest_term_autocomplete_callback');

if (!function_exists('adforest_term_autocomplete_callback')) {

    function adforest_term_autocomplete_callback() {
        $result = array();
        $args = array('hide_empty' => 0);
        $args = apply_filters('adforest_wpml_show_all_posts', $args); // for all lang texonomies
        $terms = get_terms('ad_cats', $args);
        $cats_html = '';
        $cats_html .= '<ul class="sb-admin-dropdown">';
        if (count($terms) > 0) {
            foreach ($terms as $term) {
                $total_posts = get_term_meta($term->term_id, '_adforest_term_count', true);
                $count = isset($total_posts) && $total_posts > 0 ? $total_posts : 0;
                $cats_html .= '<li class="sb-select-term" data-sb-term-value="' . $term->term_id . '|' . $term->name . '">' . $term->name . ' (' . urldecode_deep($term->slug) . ')' . ' (' . $count . ') </li>';
            }
        }
        $cats_html .= '</ul>';
        echo json_encode($cats_html);
        wp_die();
    }

}

add_filter('adforest_ajax_load_categories', 'adforest_ajax_load_categories_callback', 10, 3);

function adforest_ajax_load_categories_callback($cat_arr = array(), $param_name = 'cat', $all = 'yes') {
    global $adforest_theme;
    $ajax_base_load = isset($adforest_theme['sb_cat_load_style']) && $adforest_theme['sb_cat_load_style'] == 'live' ? TRUE : FALSE;
    if ($ajax_base_load) {
        $cat_arr = array(
            "type" => "textfield",
            "heading" => __("Category ( ajax based )", 'adforest'),
            "param_name" => $param_name,
            "admin_label" => true,
            "holder" => "div",
            "description" => __("Load all categories", 'adforest'),
        );
    } else {
        $cat_arr = array(
            "type" => "dropdown",
            "heading" => __("Category", 'adforest'),
            "param_name" => $param_name,
            "admin_label" => true,
            "value" => adforest_cats('ad_cats', $all),
        );
    }
    return $cat_arr;
}

add_filter('adforest_validate_term_type', 'adforest_validate_term_type_callback', 10, 1);

function adforest_validate_term_type_callback($arr_data = array()) {
    global $adforest_theme;
    $ajax_base_load = isset($adforest_theme['sb_cat_load_style']) && $adforest_theme['sb_cat_load_style'] == 'live' ? TRUE : FALSE;

    if (isset($arr_data) && !empty($arr_data) && is_array($arr_data) && sizeof($arr_data) > 0) {
        $final_arr_data = array();
        foreach ($arr_data as $each_val) {
            $arr_exp = '';
            $final_arr_dataa = array();
            foreach ($each_val as $key => $each_vali) {
                $arr_exp = explode("|", $each_vali);
                $final_arr_dataa[$key] = $arr_exp[0];
            }
            $final_arr_data[] = $final_arr_dataa;
        }
        $arr_data = $final_arr_data;
    }
    return $arr_data;
}

add_filter('adforest_admin_category_load_field', 'adforest_admin_category_load_field_callback', 10, 2);

function adforest_admin_category_load_field_callback($cat_field = array(), $term_group = 'Categories') {

    $group = __("Categories", "adforest");
    if ($term_group != 'Categories') {
        $group = $term_group;
    }

    $cat_field = array(
        "group" => $group,
        "type" => "dropdown",
        "heading" => __("Categories Load on frontend", 'adforest'),
        "param_name" => "cat_frontend_switch",
        "admin_label" => true,
        "value" => array(
            __('Default', 'adforest') => '',
            __('Ajax Based ( Load All )', 'adforest') => 'ajax_based',
        ),
        'edit_field_class' => 'vc_col-sm-12 vc_column',
        'description' => __('Please choose categories load type on frontend for this element. ', 'adforest'),
    );
    return $cat_field;
}

add_action('wp_ajax_load_categories_frontend_html', 'load_categories_frontend_html_callback');
add_action('wp_ajax_nopriv_load_categories_frontend_html', 'load_categories_frontend_html_callback');

function load_categories_frontend_html_callback() {

    global $adforest_theme;

    $args = array('taxonomy' => 'ad_cats', 'hide_empty' => 0);
    if (isset($_GET['q']) && $_GET['q'] != '') {
        $args['name__like'] = $_GET['q'];
    }

    $args = apply_filters('adforest_wpml_show_all_posts', $args); // for all lang texonomies
    $results = array();

    if (isset($adforest_theme['display_taxonomies']) && $adforest_theme['display_taxonomies'] == 'hierarchical') {

        $args_cat = array(
            'type' => 'array',
            'taxonomy' => 'ad_cats',
            'tag' => 'option',
            'parent_id' => 0,
            'q' => isset($_GET['q']) && $_GET['q'] != '' ? $_GET['q'] : '',
        );

        $results = apply_filters('adforest_tax_hierarchy', $results, $args_cat);
    } else {

        $data_terms = new WP_Term_Query($args);
        $results = array();
        if (!empty($data_terms->terms)) {
            if (count($data_terms->terms) > 0) {
                foreach ($data_terms->terms as $item_term) {
                    $results[] = array($item_term->term_id, wp_specialchars_decode($item_term->name));
                }
            }
        }
    }

    echo json_encode($results);
    wp_die();
}
