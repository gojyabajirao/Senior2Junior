<?php

if (!class_exists('adforest_ad_post')) {

    class adforest_ad_post {

// user object
        var $user_info;

        public function __construct() {
            $this->user_info = get_userdata(get_current_user_id());
        }

    }

}
// Ad Posting...
add_action('wp_ajax_sb_ad_posting', 'adforest_ad_posting');
if (!function_exists('adforest_ad_posting')) {

    function adforest_ad_posting() {
        global $adforest_theme;

        check_ajax_referer('sb_post_secure', 'security');
        adforest_set_date_timezone();
        if (get_current_user_id() == "") {
            echo "0";
            die();
        }


        if (!is_super_admin(get_current_user_id()) && $_POST['is_update'] == "") {
            $simple_ads = get_user_meta(get_current_user_id(), '_sb_simple_ads', true);
            $expiry = get_user_meta(get_current_user_id(), '_sb_expire_ads', true);
            if ($simple_ads == -1) {
                
            } else if ($simple_ads <= 0) {
                echo "1";
                die();
            }

            if ($expiry != '-1') {
                if ($expiry < date('Y-m-d')) {
                    echo "1";
                    die();
                }
            }
        }

        // Getting values
        $params = array();
        parse_str($_POST['sb_data'], $params);

        $cats = array();
        if (isset($params['ad_cat_sub_sub_sub']) && $params['ad_cat_sub_sub_sub'] != "") {
            $cats[] = $params['ad_cat_sub_sub_sub'];
        }
        if (isset($params['ad_cat_sub_sub']) && $params['ad_cat_sub_sub'] != "") {
            $cats[] = $params['ad_cat_sub_sub'];
        }
        if (isset($params['ad_cat_sub']) && $params['ad_cat_sub'] != "") {
            $cats[] = $params['ad_cat_sub'];
        }
        if (isset($params['ad_cat']) && $params['ad_cat'] != "") {
            $cats[] = $params['ad_cat'];
        }

        $sb_default_img_required = isset($adforest_theme['sb_default_img_required']) && $adforest_theme['sb_default_img_required'] ? true : false; // get image req or not in default template ad post

        $sb_form_is_custom = isset($params['sb_form_is_custom']) && $params['sb_form_is_custom'] == 'no' ? true : FALSE; // get ad post template type



        $ad_status = 'publish';

        if ($_POST['is_update'] != "") {
            $pid = $_POST['is_update'];
            if ($adforest_theme['sb_update_approval'] == 'manual') {
                $ad_status = 'pending';
            } else if (get_post_status($pid) == 'pending' || get_post_status($pid) == 'rejected') {
                $ad_status = 'pending';
            }

            $stored_ad_status = get_post_meta($pid, '_adforest_ad_status_', true);

            if (get_post_status($pid) == 'draft' || $stored_ad_status == 'sold' || $stored_ad_status == 'expired') {
                $ad_status = 'draft';
            }

            $is_imageallow = adforestCustomFieldsVals($pid, $cats);
            $media = get_attached_media('image', $pid);
            if ($sb_default_img_required && $sb_form_is_custom) {
                $is_imageallow = 1;
            }

            if ($is_imageallow == 1 && count($media) == 0) {
                echo "img_req";
                wp_die();
            }
        } else {
            if ($adforest_theme['sb_ad_approval'] == 'manual') {
                $ad_status = 'pending';
            }
            $pid = get_user_meta(get_current_user_id(), 'ad_in_progress', true);

            $is_imageallow = adforestCustomFieldsVals($pid, $cats);
            $media = get_attached_media('image', $pid);

            if ($sb_default_img_required && $sb_form_is_custom) {
                $is_imageallow = 1;
            }

            if ($is_imageallow == 1 && count($media) == 0) {
                echo "img_req";
                wp_die();
            }

            // Now user can post new ad
            delete_user_meta(get_current_user_id(), 'ad_in_progress');

            $simple_ads = get_user_meta(get_current_user_id(), '_sb_simple_ads', true);
            if ($simple_ads > 0 && !is_super_admin(get_current_user_id())) {
                $simple_ads = $simple_ads - 1;
                update_user_meta(get_current_user_id(), '_sb_simple_ads', $simple_ads);
            }
            //====
            $_sb_allow_bidding = get_user_meta(get_current_user_id(), '_sb_allow_bidding', true);
            if (isset($_sb_allow_bidding) && $_sb_allow_bidding > 0 && !is_super_admin(get_current_user_id()) && $params['ad_bidding'] == 1) {
                $_sb_allow_bidding = $_sb_allow_bidding - 1;
                update_user_meta(get_current_user_id(), '_sb_allow_bidding', $_sb_allow_bidding);
            }

            update_post_meta($pid, '_adforest_ad_status_', 'active');
            update_post_meta($pid, '_adforest_is_feature', '0');
            adforest_get_notify_on_ad_post($pid);
        }


        global $wpdb;
        $qry = "UPDATE $wpdb->postmeta SET meta_value = '' WHERE post_id = '$pid' AND meta_key LIKE '_adforest_tpl_field_%'";
        $wpdb->query($qry);

        // Bad words filteration
        $words = explode(',', $adforest_theme['bad_words_filter']);
        $replace = $adforest_theme['bad_words_replace'];
        $desc = adforest_badwords_filter($words, $params['ad_description'], $replace);
        $title = adforest_badwords_filter($words, $params['ad_title'], $replace);
        //$desc = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $desc);
        $desc = wp_kses_post($desc);

        if ($_POST['is_update'] != "") {

            $my_post = array(
                'ID' => $pid,
                'post_title' => sanitize_title($title),
                'post_status' => $ad_status,
                'post_content' => $desc,
                'post_name' => sanitize_text_field($title)
            );
        } else {
            $my_post = array(
                'ID' => $pid,
                'post_title' => sanitize_title($title),
                'post_status' => $ad_status,
                'post_content' => $desc,
                'post_name' => sanitize_text_field($title),
                'post_date' => current_time('mysql'),
                    //'post_date' => date('Y-m-d H:i:s'),
                    // 'post_date_gmt' => get_gmt_from_date(current_time('mysql'))
                    // 'post_date_gmt' => get_gmt_from_date(date('Y-m-d H:i:s'))
            );
        }



        wp_update_post($my_post);

        $category = array();
        if (isset($params['ad_cat']) && $params['ad_cat'] != "") {
            $category[] = $params['ad_cat'];
        }
        if (isset($params['ad_cat_sub']) && $params['ad_cat_sub'] != "") {
            $category[] = $params['ad_cat_sub'];
        }
        if (isset($params['ad_cat_sub_sub']) && $params['ad_cat_sub_sub'] != "") {
            $category[] = $params['ad_cat_sub_sub'];
        }
        if (isset($params['ad_cat_sub_sub_sub']) && $params['ad_cat_sub_sub_sub'] != "") {
            $category[] = $params['ad_cat_sub_sub_sub'];
        }


        wp_set_post_terms($pid, $category, 'ad_cats');

        /* countries */
        $countries = array();
        if (isset($params['ad_country']) && $params['ad_country'] != "") {
            $countries[] = $params['ad_country'];
        }
        if (isset($params['ad_country_states']) && $params['ad_country_states'] != "") {
            $countries[] = $params['ad_country_states'];
        }
        if (isset($params['ad_country_cities']) && $params['ad_country_cities'] != "") {
            $countries[] = $params['ad_country_cities'];
        }
        if (isset($params['ad_country_towns']) && $params['ad_country_towns'] != "") {
            $countries[] = $params['ad_country_towns'];
        }

        wp_set_post_terms($pid, $countries, 'ad_country');

        // setting taxonomoies selected
        $type = '';
        if (isset($params['buy_sell']) && $params['buy_sell'] != "") {
            $type_arr = explode('|', $params['buy_sell']);
            wp_set_post_terms($pid, $type_arr[0], 'ad_type');
            $type = $type_arr[1];
        }
        $conditon = '';
        if (isset($params['condition']) && $params['condition'] != "") {
            $condition_arr = explode('|', $params['condition']);
            wp_set_post_terms($pid, $condition_arr[0], 'ad_condition');
            $conditon = $condition_arr[1];
        }
        $warranty = '';
        if (isset($params['ad_warranty']) && $params['ad_warranty'] != "") {
            $warranty_arr = explode('|', $params['ad_warranty']);
            wp_set_post_terms($pid, $warranty_arr[0], 'ad_warranty');
            $warranty = $warranty_arr[1];
        }

        $currency = '';
        if (isset($params['ad_currency']) && $params['ad_currency'] != "") {
            $currency_arr = explode('|', $params['ad_currency']);
            wp_set_post_terms($pid, $currency_arr[0], 'ad_currency');
            $currency = $currency_arr[1];
            update_post_meta($pid, '_adforest_ad_currency', sanitize_text_field($currency));
        }

        $tags = explode(',', $params['tags']);
        wp_set_object_terms($pid, $tags, 'ad_tags');

        // Update post meta
        $theme_ad_bidding_date = ( isset($params['ad_bidding']) && $params['ad_bidding'] == 1 ) ? $params['ad_bidding_date'] : '';


        $sb_user_name = isset($params['sb_user_name']) && $params['sb_user_name'] != '' ? $params['sb_user_name'] : '';
        $sb_contact_number = isset($params['sb_contact_number']) && $params['sb_contact_number'] != '' ? $params['sb_contact_number'] : '';
        $sb_user_address = isset($params['sb_user_address']) && $params['sb_user_address'] != '' ? $params['sb_user_address'] : '';
        $ad_price = isset($params['ad_price']) && $params['ad_price'] != '' ? $params['ad_price'] : '';
        $ad_map_lat = isset($params['ad_map_lat']) && $params['ad_map_lat'] != '' ? $params['ad_map_lat'] : '';
        $ad_map_long = isset($params['ad_map_long']) && $params['ad_map_long'] != '' ? $params['ad_map_long'] : '';
        $ad_bidding = isset($params['ad_bidding']) && $params['ad_bidding'] != '' ? $params['ad_bidding'] : '';
        $ad_price_type = isset($params['ad_price_type']) && $params['ad_price_type'] != '' ? $params['ad_price_type'] : '';


        update_post_meta($pid, '_adforest_poster_name', sanitize_text_field($sb_user_name));
        update_post_meta($pid, '_adforest_poster_contact', sanitize_text_field($sb_contact_number));
        update_post_meta($pid, '_adforest_ad_location', sanitize_text_field($sb_user_address));
        update_post_meta($pid, '_adforest_ad_type', sanitize_text_field($type));
        update_post_meta($pid, '_adforest_ad_condition', sanitize_text_field($conditon));
        update_post_meta($pid, '_adforest_ad_warranty', sanitize_text_field($warranty));
        update_post_meta($pid, '_adforest_ad_price', sanitize_text_field($ad_price));
        update_post_meta($pid, '_adforest_ad_map_lat', sanitize_text_field($ad_map_lat));
        update_post_meta($pid, '_adforest_ad_map_long', sanitize_text_field($ad_map_long));
        update_post_meta($pid, '_adforest_ad_bidding', sanitize_text_field($ad_bidding));
        update_post_meta($pid, '_adforest_ad_price_type', sanitize_text_field($ad_price_type));
        update_post_meta($pid, '_adforest_ad_bidding_date', sanitize_text_field($theme_ad_bidding_date));
        if (isset($params['ad_yvideo']) && $params['ad_yvideo'] != "") {
            update_post_meta($pid, '_adforest_ad_yvideo', sanitize_text_field($params['ad_yvideo']));
        } else {
            update_post_meta($pid, '_adforest_ad_yvideo', '');
        }

        // Making it featured ad
        if (isset($params['sb_make_it_feature']) && $params['sb_make_it_feature']) {
            // Uptaing remaining ads.
            $featured_ad = get_user_meta(get_current_user_id(), '_sb_featured_ads', true);
            if ($featured_ad > 0 || $featured_ad == '-1') {
                update_post_meta($pid, '_adforest_is_feature', '1');
                update_post_meta($pid, '_adforest_is_feature_date', date('Y-m-d'));

                $old_featured_count = $featured_ad;
                $new_featured_count = '';
                if ($old_featured_count == '-1') {
                    $new_featured_count = '-1';
                } elseif ($old_featured_count > 0) {
                    $new_featured_count = $old_featured_count - 1;
                }
                update_user_meta(get_current_user_id(), '_sb_featured_ads', $new_featured_count);
            }
        }

        // Bumping it up
        if (isset($params['sb_bump_up']) && $params['sb_bump_up']) {
            // Uptaing remaining ads.
            $bump_ads = get_user_meta(get_current_user_id(), '_sb_bump_ads', true);
            if ($bump_ads > 0 || $bump_ads == '-1' || ( isset($adforest_theme['sb_allow_free_bump_up']) && $adforest_theme['sb_allow_free_bump_up'] )) {
                wp_update_post(
                        array(
                            'ID' => $pid, // ID of the post to update
                            'post_date' => current_time('mysql'),
                        //'post_date' => date('Y-m-d H:i:s'),
                        // 'post_date_gmt' => get_gmt_from_date(current_time('mysql'))
                        // 'post_date_gmt' => get_gmt_from_date(date('Y-m-d H:i:s'))
                        )
                );
                if (!$adforest_theme['sb_allow_free_bump_up'] && $bump_ads != '-1') {
                    $bump_ads = $bump_ads - 1;
                    update_user_meta(get_current_user_id(), '_sb_bump_ads', $bump_ads);
                }
            }
        }

        // Stroring Extra fileds in DB
        if (isset($params['sb_total_extra']) && $params['sb_total_extra'] > 0) {
            for ($i = 1; $i <= $params['sb_total_extra']; $i++) {
                update_post_meta($pid, "_sb_extra_" . $params["title_$i"], sanitize_text_field($params["sb_extra_$i"]));
            }
        }
        //Add Dynamic Fields
        if (isset($params['cat_template_field']) && count($params['cat_template_field']) > 0) {
            foreach ($params['cat_template_field'] as $key => $data) {
                if (is_array($data)) {
                    $dataArr = array();
                    foreach ($data as $k)
                        $dataArr[] = $k;
                    $data = stripslashes(json_encode($dataArr, JSON_UNESCAPED_UNICODE));
                }
                update_post_meta($pid, $key, sanitize_text_field($data));
            }
        }
        // Making Location DB
        // explode address
        if ($params['ad_map_lat'] == "" && $params['ad_map_long']) {
            $address = explode(',', $params['sb_user_address']);
            if (count($address) == 3) {
                $city = trim($address[0]);
                $state = trim($address[1]);
                $country = trim($address[2]);
                adforest_add_location($country, $state, $city);
            } else if (count($address) == 2) {
                $city = trim($address[0]);
                $country = trim($address[1]);
                $state = '';
                adforest_add_location($country, $state, $city);
            }
        }

        do_action('adforest_directory_fields_saving', $pid, $params); // save directory data

        if ($_POST['is_update'] == "") {
            do_action('adforest_duplicate_posts_lang', $pid);
        }
        echo get_the_permalink($pid);

        die();
    }

}

// Get sub cats
add_action('wp_ajax_sb_get_sub_cat_search', 'adforest_get_sub_cats_search');
add_action('wp_ajax_nopriv_sb_get_sub_cat_search', 'adforest_get_sub_cats_search');
if (!function_exists('adforest_get_sub_cats_search')) {

    function adforest_get_sub_cats_search() {
        global $adforest_theme;


        $search_popup_cat_disable = isset($adforest_theme['search_popup_cat_disable']) ? $adforest_theme['search_popup_cat_disable'] : false;

        $cat_id = $_POST['cat_id'];
        $ad_cats = adforest_get_cats('ad_cats', $cat_id);
        $res = '';
        if (count($ad_cats) > 0) {
            $selected_cats = adforest_get_taxonomy_parents($cat_id, 'ad_cats', false);
            $find = '&raquo;';
            $replace = '';
            $selected_cats = preg_replace("/$find/", $replace, $selected_cats, 1);
            $res = '<label>' . $selected_cats . '</label>';
            $res .= '<ul class="city-select-city" >';
            foreach ($ad_cats as $ad_cat) {
                $id = 'ajax_cat';
                $count_p = ($ad_cat->count);
                $res .= '<li class="col-sm-4 col-xs-6 margin-top-10"><a href="javascript:void(0);" data-cat-id="' . esc_attr($ad_cat->term_id) . '" id="' . $id . '">' . $ad_cat->name . ' (' . $count_p . ')</a></li>';
            }
            $res .= '</ul>';
            echo adforest_returnEcho($res);
        } else {
            echo "submit";
        }
        die();
    }

}

// Get sub cats
add_action('wp_ajax_sb_get_sub_cat', 'adforest_get_sub_cats');
if (!function_exists('adforest_get_sub_cats')) {

    function adforest_get_sub_cats() {
        global $adforest_theme;

        $cat_id = $_POST['cat_id'];
        $ad_cats = adforest_get_cats('ad_cats', $cat_id, 0, 'post_ad');

        /*
         * for package base categories
         */

        $parent_child_pkg_flag = FALSE;
        $cat_pkg_type = isset($adforest_theme['cat_pkg_type']) && $adforest_theme['cat_pkg_type'] != '' ? $adforest_theme['cat_pkg_type'] : 'parent';
        if ($cat_pkg_type == 'child') {
            $parent_child_pkg_flag = TRUE;
        } else {
            if (!adforest_category_has_parent($cat_id)) { // applied only in parent paid categories
                $parent_child_pkg_flag = TRUE;
            }
        }


        if ($parent_child_pkg_flag) {
            $adforest_make_cat_paid = get_term_meta($cat_id, 'adforest_make_cat_paid', true);
            $paid_category = FALSE;
            if (isset($adforest_make_cat_paid) && $adforest_make_cat_paid == 'yes') {
                $paid_category = TRUE;
            }
            $selected_categories = get_user_meta(get_current_user_id(), "package_allow_categories", true);
            $selected_categories = isset($selected_categories) && !empty($selected_categories) ? $selected_categories : '';
            $selected_categories_arr = array();

            $category_package_flag = FALSE;
            if ($selected_categories == '') {    // scanerio 1  select paid category but package is empty
                if ($paid_category) {
                    $category_package_flag = TRUE; // display package error
                }
            }
            if ($selected_categories == 'all') {    // scanerio 2  select Any category but package selection is all
                $category_package_flag = FALSE; // display package free
            }
            if ($selected_categories != '' && $selected_categories != 'all') { // selected category is not in buy package or/not
                $selected_categories_arr = explode(",", $selected_categories);
                if ($paid_category) {
                    if (!in_array($cat_id, $selected_categories_arr)) {
                        $category_package_flag = TRUE; // display package error
                    }
                }
            }

            if ($category_package_flag && !$has_parent_cat) {
                echo "cat_error";
                die();
            }
        }


        /*
         * End for package base categories
         */

        if (count($ad_cats) > 0) {
            $cats_html = '<select class="category form-control" id="ad_cat_sub" name="ad_cat_sub" >';
            $cats_html .= '<option label="Select Option"></option>';
            foreach ($ad_cats as $ad_cat) {
                $cats_html .= '<option value="' . $ad_cat->term_id . '">' . $ad_cat->name . '</option>';
            }
            $cats_html .= '</select>';
            echo adforest_returnEcho($cats_html);
            die();
        } else {
            echo "";
            die();
        }
    }

}

function adforest_category_has_parent($catid) {
    $category = get_term($catid);
    if ($category->parent > 0) {
        return true;
    }
    return false;
}

if (!function_exists('adforest_check_author')) {

    function adforest_check_author($ad_id) {
        if (get_post_field('post_author', $ad_id) != get_current_user_id()) {
            return false;
        } else {
            return true;
        }
    }

}

add_action('wp_ajax_post_ad', 'adforest_post_ad_process');
if (!function_exists('adforest_post_ad_process')) {

    function adforest_post_ad_process() {

        if ($_POST['is_update'] != "") {
            wp_die();
        }


        $title = sanitize_title($_POST['title']);

        if (get_current_user_id() == "") {
            wp_die();
        }

        if (!isset($title)) {
            wp_die();
        }

        $ad_id = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
        if (get_post_status($ad_id) && $ad_id != "" && get_post_status($ad_id) != 'publish') {
            $my_post = array(
                'ID' => get_user_meta(get_current_user_id(), 'ad_in_progress', true),
                'post_title' => $title,
                'post_status' => 'private',
            );
            wp_update_post($my_post);
            wp_die();
        }

        // Gather post data.
        $my_post = array(
            'post_title' => sanitize_title($title),
            'post_status' => 'private',
            'post_author' => get_current_user_id(),
            'post_type' => 'ad_post'
        );

        // Insert the post into the database.
        $id = wp_insert_post($my_post);
        if ($id) {
            update_user_meta(get_current_user_id(), 'ad_in_progress', $id);
        }

        wp_die();
    }

}


add_action('wp_ajax_delete_ad_image', 'adforest_delete_ad_image');
if (!function_exists('adforest_delete_ad_image')) {

    function adforest_delete_ad_image() {
        if (get_current_user_id() == "")
            die();


        if ($_POST['is_update'] != "") {
            $ad_id = $_POST['is_update'];
        } else {
            $ad_id = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
        }

        if (!is_super_admin(get_current_user_id()) && get_post_field('post_author', $ad_id) != get_current_user_id())
            die();


        $attachmentid = $_POST['img'];
        wp_delete_attachment($attachmentid, true);

        if (get_post_meta($ad_id, '_sb_photo_arrangement_', true) != "") {
            $ids = get_post_meta($ad_id, '_sb_photo_arrangement_', true);
            $res = str_replace($attachmentid, "", $ids);
            $res = str_replace(',,', ",", $res);
            $img_ids = trim($res, ',');
            update_post_meta($ad_id, '_sb_photo_arrangement_', $img_ids);
        }


        echo "1";
        die();
    }

}

add_action('wp_ajax_upload_ad_images', 'adforest_upload_ad_images');
if (!function_exists('adforest_upload_ad_images')) {

    function adforest_upload_ad_images() {

        global $adforest_theme;

        adforest_authenticate_check();

        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        if (isset($adforest_theme['sb_standard_images_size']) && $adforest_theme['sb_standard_images_size']) {
            list($width, $height) = getimagesize($_FILES["my_file_upload"]["tmp_name"]);
            if ($width < 760) {
                echo '0|' . __("Minimum image dimension should be", 'adforest') . ' 760x410';
                die();
            }

            if ($height < 410) {
                echo '0|' . __("Minimum image dimension should be", 'adforest') . ' 760x410';
                die();
            }
        }


        $size_arr = explode('-', $adforest_theme['sb_upload_size']);
        $display_size = $size_arr[1];
        $actual_size = $size_arr[0];

        $data_files = explode('.', $_FILES['my_file_upload']['name']);
        // Allow certain file formats
        $imageFileType = strtolower(end($data_files));
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo '0|' . __("Sorry, only JPG, JPEG, PNG & GIF files are allowed.", 'adforest');
            die();
        }

        // Check file size
        if ($_FILES['my_file_upload']['size'] > $actual_size) {
            echo '0|' . __("Max allowed image size is", 'adforest') . " " . $display_size;
            die();
        }


        // Let WordPress handle the upload.
        // Remember, 'my_image_upload' is the name of our file input in our form above.
        if ($_GET['is_update'] != "") {
            $ad_id = $_GET['is_update'];
        } else {
            $ad_id = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
        }

        if ($ad_id == "") {
            echo '0|' . __("Please enter title first in order to create ad.", 'adforest');
            die();
        }
        $user_packages_images = get_user_meta(get_current_user_id(), '_sb_num_of_images', true);

        $user_upload_max_images = '';
        if (isset($user_packages_images) && $user_packages_images == '-1') {
            $user_upload_max_images = '';
        } elseif (isset($user_packages_images) && $user_packages_images > 0) {
            $user_upload_max_images = $user_packages_images;
        } else {
            $user_upload_max_images = $adforest_theme['sb_upload_limit'];
        }



        $media = get_attached_media('image', $ad_id);

        if ($user_upload_max_images != '') {
            if (count($media) >= $user_upload_max_images) {
                echo '0|' . __("You can not upload more than ", 'adforest') . " " . $user_upload_max_images;
                die();
            }
        }



        $attachment_id = media_handle_upload('my_file_upload', $ad_id);
        $imgaes = get_post_meta($ad_id, '_sb_photo_arrangement_', true);
        if ($imgaes != "") {
            $imgaes = $imgaes . ',' . $attachment_id;
            update_post_meta($ad_id, '_sb_photo_arrangement_', $imgaes);
        }
        echo adforest_returnEcho($attachment_id);
        die();
    }

}

add_action('wp_ajax_sb_sort_images', 'adforest_sort_images');
if (!function_exists('adforest_sort_images')) {

    function adforest_sort_images() {
        update_post_meta($_POST['ad_id'], '_sb_photo_arrangement_', $_POST['ids']);
        die();
    }

}

add_action('wp_ajax_get_uploaded_ad_images', 'adforest_get_uploaded_ad_images');
if (!function_exists('adforest_get_uploaded_ad_images')) {

    function adforest_get_uploaded_ad_images() {
        if ($_POST['is_update'] != "") {
            $ad_id = $_POST['is_update'];
        } else {
            $ad_id = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
            if (get_post_status($ad_id) && $ad_id != "" && get_post_status($ad_id) != 'publish') {
                
            } else {
                return '';
                die();
            }
        }


        $media = adforest_get_ad_images($ad_id);
        $result = array();
        foreach ($media as $m) {
            $mid = '';
            $guid = '';
            if (isset($m->ID)) {
                $mid = $m->ID;
                //$guid	=	get_the_guid( $mid );

                $source = wp_get_attachment_image_src($mid, 'adforest-user-profile');
                $guid = $source[0];
            } else {
                $mid = $m;
                //$guid	=	get_the_guid( $mid );

                $source = wp_get_attachment_image_src($mid, 'adforest-user-profile');
                $guid = $source[0];
            }

            $obj = array();
            $obj['dispaly_name'] = basename(get_attached_file($mid));
            ;
            $obj['name'] = $guid;
            $obj['size'] = filesize(get_attached_file($mid));
            $obj['id'] = $mid;
            $result[] = $obj;
        }
        header('Content-type: text/json');
        header('Content-type: application/json');
        echo json_encode($result);
        die();
    }

}

if (!function_exists('adforest_delete_post_taxonomies')) {

    function adforest_delete_post_taxonomies($object_id, $taxonomy) {
        global $wpdb;
        $rows = $wpdb->get_results("SELECT term_taxonomy_id FROM $wpdb->term_relationships WHERE object_id = '$object_id'");
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $rs = $wpdb->get_row("SELECT taxonomy FROM $wpdb->term_taxonomy WHERE term_taxonomy_id = '" . $row->term_taxonomy_id . "'");
                if ($rs->taxonomy == $taxonomy) {
                    echo "DELETE FROM $wpdb->term_relationships WHERE object_id = '$object_id' AND term_taxonomy_id = '" . $row->term_taxonomy_id . "'";

                    $wpdb->delete($wpdb->term_relationships, array('object_id' => $object_id, 'term_taxonomy_id' => $row->term_taxonomy_id));
                }
            }
        }
    }

}

if (!function_exists('sort_terms_hierarchicaly')) {

    function sort_terms_hierarchicaly(&$cats, &$into, $parentId = 0) {
        foreach ($cats as $i => $cat) {
            if ($cat->parent == $parentId) {
                $into[$cat->term_id] = $cat;
                unset($cats[$i]);
            }
        }

        foreach ($into as $topCat) {
            $topCat->children = array();
            sort_terms_hierarchicaly($cats, $topCat->children, $topCat->term_id);
        }
    }

}

if (!function_exists('adforest_get_ad_cats')) {

    function adforest_get_ad_cats($id, $by = 'name', $for_country = false) {
        $taxonomy = 'ad_cats'; //Put your custom taxonomy term here

        if ($for_country) {
            $taxonomy = 'ad_country';
        } else {
            $taxonomy = 'ad_cats'; //Put your custom taxonomy term here
        }

        $terms = wp_get_post_terms($id, $taxonomy);
        $cats = array();
        $myparentID = '';
        foreach ($terms as $term) {
            if ($term->parent == 0) {
                $myparent = $term;
                $myparentID = $myparent->term_id;
                $cats[] = array('name' => $myparent->name, 'id' => $myparent->term_id);
                break;
            }
        }

        if ($myparentID != "") {
            $mychildID = '';
            // Right, the parent is set, now let's get the children
            foreach ($terms as $term) {
                if ($term->parent == $myparentID) { // this ignores the parent of the current post taxonomy
                    $child_term = $term; // this gets the children of the current post taxonomy	
                    $mychildID = $child_term->term_id;
                    $cats[] = array('name' => $child_term->name, 'id' => $child_term->term_id);
                    break;
                }
            }
            if ($mychildID != "") {
                $mychildchildID = '';
                // Right, the parent is set, now let's get the children
                foreach ($terms as $term) {
                    if ($term->parent == $mychildID) { // this ignores the parent of the current post taxonomy
                        $child_term = $term; // this gets the children of the current post taxonomy
                        $mychildchildID = $child_term->term_id;
                        $cats[] = array('name' => $child_term->name, 'id' => $child_term->term_id);
                        break;
                    }
                }
                if ($mychildchildID != "") {
                    // Right, the parent is set, now let's get the children
                    foreach ($terms as $term) {
                        if ($term->parent == $mychildchildID) { // this ignores the parent of the current post taxonomy
                            $child_term = $term; // this gets the children of the current post taxonomy	  
                            $cats[] = array('name' => $child_term->name, 'id' => $child_term->term_id);
                            break;
                        }
                    }
                }
            }
        }
        return $cats;

//
//        $post_categories = wp_get_object_terms($id, array('ad_cats'), array('orderby' => 'term_group'));
//        $cats = array();
//        foreach ($post_categories as $c) {
//            $cat = get_term($c);
//            $cats[] = array('name' => $cat->name, 'id' => $cat->term_id);
//        }
//        return $cats;
    }

}

// Get all messages of particular ad
add_action('wp_ajax_sb_get_messages', 'adforest_get_messages');
if (!function_exists('adforest_get_messages')) {

    function adforest_get_messages() {
        adforest_authenticate_check();
        check_ajax_referer('sb_msg_secure', 'security');
        $ad_id = $_POST['ad_id'];
        $user_id = $_POST['user_id'];
        $authors = array($user_id, get_current_user_id());

        $blocked_user_array2 = get_user_meta(get_current_user_id(), 'adforest_blocked_users', true);

        if (isset($blocked_user_array2) && !empty($blocked_user_array2) && is_array($blocked_user_array2) && in_array($user_id, $blocked_user_array2)) {
            echo '0|' . __("Unblock this user to send message.", 'adforest');
            die();
        }

        // Mark as read conversation
        update_comment_meta(get_current_user_id(), $ad_id . "_" . $user_id, 1);


        $parent = $user_id;
        if ($_POST['inbox'] == 'yes') {
            $parent = get_current_user_id();
        }
        $args = array(
            'author__in' => $authors,
            'post_id' => $ad_id,
            'parent' => $parent,
            'orderby' => 'comment_date',
            'order' => 'ASC',
        );
        $comments = get_comments($args);
        $messages = '';
        $i = 1;
        $total = count($comments);
        if (count($comments) > 0) {
            foreach ($comments as $comment) {
                $user_pic = '';
                $class = 'friend-message';
                if ($comment->user_id == get_current_user_id()) {
                    $class = 'my-message';
                }
                $user_pic = adforest_get_user_dp($comment->user_id);
                $id = '';
                if ($i == $total) {
                    $id = 'id="last_li"';
                }
                $i++;
                $messages .= '<li class="' . $class . ' clearfix" ' . $id . '>
							 <figure class="profile-picture">
                                                         <a href="' . get_author_posts_url($comment->user_id) . '?type=ads" class="link" target="_blank">
								<img src="' . $user_pic . '" class="img-circle" alt="' . __('Profile Pic', 'adforest') . '"  alt="image">
                                                          </a>          
							 </figure>
							 <div class="message">
								' . $comment->comment_content . '
								<div class="time"><i class="fa fa-clock-o"></i> ' . adforest_timeago($comment->comment_date) . '</div>
							 </div>
						  </li>';
            }
        }
        echo adforest_returnEcho($messages);
        die();
    }

}

if (!function_exists('adforest_authenticate_check')) {

    function adforest_authenticate_check() {
        if (get_current_user_id() == "") {
            echo '0|' . __("You are not logged in.", 'adforest');
            die();
        }
    }

}

if (!function_exists('adforestCustomFieldsVals')) {

    function adforestCustomFieldsVals($post_id = '', $terms = array()) {
        if ($post_id == "")
            return;
        /* $terms = wp_get_post_terms($post_id, 'ad_cats'); */
        $is_show = '';
        if (count($terms) > 0) {

            foreach ($terms as $term) {
                $term_id = $term;
                $t = adforest_dynamic_templateID($term_id);
                if ($t)
                    break;
            }
            $templateID = adforest_dynamic_templateID($term_id);
            $result = get_term_meta($templateID, '_sb_dynamic_form_fields', true);

            $is_show = '';
            $html = '';

            if (isset($result) && $result != "") {
                $is_show = sb_custom_form_data($result, '_sb_default_cat_image_required');
            }
        }
        return ($is_show == 1) ? 1 : 0;
    }

}

/* Get States */
add_action('wp_ajax_sb_get_sub_states', 'adforest_get_sub_states');
add_action('wp_ajax_nopriv_sb_get_sub_states_search', 'adforest_get_sub_states_search');
if (!function_exists('adforest_get_sub_states')) {

    function adforest_get_sub_states() {
        $country_id = $_POST['country_id'];
        $ad_country = adforest_get_cats('ad_country', $country_id, 0, 'post_ad');
        if (count($ad_country) > 0) {
            $cats_html = '<select class="category form-control">';
            $cats_html .= '<option label="' . esc_html__('Select Option', 'adforest') . '"></option>';
            foreach ($ad_country as $ad_cat) {
                $cats_html .= '<option value="' . $ad_cat->term_id . '">' . $ad_cat->name . '</option>';
            }
            $cats_html .= '</select>';
            echo adforest_returnEcho($cats_html);
            die();
        } else {
            echo "";
            die();
        }
    }

}

/* Get States Search */
add_action('wp_ajax_get_related_cities', 'adforest_get_countries');
add_action('wp_ajax_nopriv_get_related_cities', 'adforest_get_countries');
if (!function_exists('adforest_get_countries')) {

    function adforest_get_countries() {
        global $adforest_theme;

        $cat_id = $_POST['country_id'];
        $ad_cats = adforest_get_cats('ad_country', $cat_id);
        $res = '';
        if (count($ad_cats) > 0) {
            $selected_cats = adforest_get_taxonomy_parents($cat_id, 'ad_country', false);
            $find = '&raquo;';
            $replace = '';
            $selected_cats = preg_replace("/$find/", $replace, $selected_cats, 1);
            $res = '<label>' . $selected_cats . '</label>';
            //$res = '<label>'.adforest_get_taxonomy_parents( $cat_id, 'ad_country', false).'</label>';
            $res .= '<ul class="city-select-city" >';
            foreach ($ad_cats as $ad_cat) {
                $location_count = get_term($ad_cat->term_id);
                $count = $location_count->count;

                $id = 'ajax_states';
                $res .= '<li class="col-sm-4 col-md-4 col-xs-6"><a href="javascript:void(0);" data-country-id="' . esc_attr($ad_cat->term_id) . '" id="' . $id . '">' . $ad_cat->name . ' <span>(' . esc_html($count) . ')</span></a></li>';
            }
            $res .= '</ul>';
            echo adforest_returnEcho($res);
        } else {
            echo "submit";
        }
        die();
    }

}

/* Ad rating */
add_action('wp_ajax_sb_ad_rating', 'adforest_ad_rating');
add_action('wp_ajax_nopriv_sb_ad_rating', 'adforest_ad_rating');
if (!function_exists('adforest_ad_rating')) {

    function adforest_ad_rating() {

        check_ajax_referer('sb_review_secure', 'security');
        adforest_set_date_timezone();
        if (get_current_user_id() == "") {
            echo '0|' . __("You are not logged in.", 'adforest');
            die();
        } else {
            global $adforest_theme;


            $params = array();
            parse_str($_POST['sb_data'], $params);

            $sender_id = get_current_user_id();
            $sender = get_userdata($sender_id);

            if ($sender_id == $params['ad_owner']) {
                echo '0|' . __("Ad author can't post rating.", 'adforest');
                die();
            }
            if (!$adforest_theme['sb_update_rating'] && get_user_meta($sender_id, 'ad_ratting_' . $sender_id, true) == $params['ad_id']) {
                echo '0|' . __("You've posted rating already.", 'adforest');
                die();
            }

            if (isset($adforest_theme['sb_update_rating']) && $adforest_theme['sb_update_rating']) {
                $args = array(
                    'type__in' => array('ad_post_rating'),
                    'post_id' => $params['ad_id'],
                    'user_id' => $sender_id,
                    'number' => 1,
                    'parent' => 0,
                );
                $comment_exist = get_comments($args);
                if (count($comment_exist) > 0) {
                    $comment = array();
                    $comment['comment_ID'] = $comment_exist[0]->comment_ID;
                    $comment['comment_content'] = sanitize_textarea_field($params['rating_comments']);
                    wp_update_comment($comment);
                    update_comment_meta($comment_exist[0]->comment_ID, 'review_stars', $params['rating']);
                    if (isset($adforest_theme['sb_rating_email_author']) && $adforest_theme['sb_rating_email_author']) {
                        adforest_email_ad_rating($params['ad_id'], $sender_id, $params['rating'], $params['rating_comments']);
                    }
                    echo '1|' . __("Your rating has been updated.", 'adforest');
                    die();
                }
            }

            //$time = current_time('mysql');

            $time = date('Y-m-d H:i:s');
            $data = array(
                'comment_post_ID' => $params['ad_id'],
                'comment_author' => $sender->display_name,
                'comment_author_email' => $sender->user_email,
                'comment_author_url' => '',
                'comment_content' => sanitize_textarea_field($params['rating_comments']),
                'comment_type' => 'ad_post_rating',
                'user_id' => $sender_id,
                'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
                'comment_date' => $time,
                'comment_approved' => 1,
            );

            $comment_id = wp_insert_comment($data);
            if ($comment_id) {
                update_comment_meta($comment_id, 'review_stars', $params['rating']);
                if (isset($adforest_theme['sb_rating_email_author']) && $adforest_theme['sb_rating_email_author']) {
                    adforest_email_ad_rating($params['ad_id'], $sender_id, $params['rating'], $params['rating_comments']);
                }
                echo '1|' . __("Your rating has been posted.", 'adforest');
                die();
            }
        }
    }

}

/* Ad rating Reply */
add_action('wp_ajax_sb_ad_rating_reply', 'adforest_ad_rating_reply');
add_action('wp_ajax_nopriv_ad_rating_reply', 'adforest_ad_rating_reply');
if (!function_exists('adforest_ad_rating_reply')) {

    function adforest_ad_rating_reply() {

        check_ajax_referer('sb_review_reply_secure', 'security');
        adforest_set_date_timezone();
        if (get_current_user_id() == "") {
            echo '0|' . __("You are not logged in.", 'adforest');
            die();
        } else {

            global $adforest_theme;
            $params = array();
            parse_str($_POST['sb_data'], $params);

            $sender_id = get_current_user_id();
            $sender = get_userdata($sender_id);

            if ($sender_id != $params['ad_owner']) {
                echo '0|' . __("Only Ad owner can reply the rating.", 'adforest');
                die();
            }

            $args = array(
                'type__in' => array('ad_post_rating'),
                'post_id' => $params['ad_id'],
                'user_id' => $sender_id,
                'number' => 1,
                'parent' => $params['parent_comment_id'],
            );
            $comment_exist = get_comments($args);
            if (count($comment_exist) > 0) {
                $comment = array();
                $comment['comment_ID'] = $comment_exist[0]->comment_ID;
                $comment['comment_content'] = $params['reply_comments'];
                wp_update_comment($comment);

                if (isset($adforest_theme['sb_rating_reply_email']) && $adforest_theme['sb_rating_reply_email']) {
                    $comment_data = get_comment($params['parent_comment_id']);
                    $rating = get_comment_meta($params['parent_comment_id'], 'review_stars', true);
                    adforest_email_ad_rating_reply($params['ad_id'], $comment_data->user_id, $params['reply_comments'], $rating, $comment_data->comment_content);
                }
                echo '1|' . __("Your reply has been updated.", 'adforest');
                die();
            }

            //$time = current_time('mysql');
            $time = date('Y-m-d H:i:s');


            $data = array(
                'comment_post_ID' => $params['ad_id'],
                'comment_author' => $sender->display_name,
                'comment_author_email' => $sender->user_email,
                'comment_author_url' => '',
                'comment_content' => $params['reply_comments'],
                'comment_type' => 'ad_post_rating',
                'user_id' => $sender_id,
                'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
                'comment_date' => $time,
                'comment_parent' => $params['parent_comment_id'],
                'comment_approved' => 1
            );

            $comment_id = wp_insert_comment($data);
            if ($comment_id) {
                if (isset($adforest_theme['sb_rating_reply_email']) && $adforest_theme['sb_rating_reply_email']) {
                    $comment_data = get_comment($params['parent_comment_id']);
                    $rating = get_comment_meta($params['parent_comment_id'], 'review_stars', true);
                    adforest_email_ad_rating_reply($params['ad_id'], $comment_data->user_id, $params['reply_comments'], $rating, $comment_data->comment_content);
                }
                echo '1|' . __("Your reply has been posted.", 'adforest');
                die();
            }
        }
    }

}