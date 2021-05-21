<?php
global $adforest_theme;
$adforest_theme = get_option('adforest_theme');

add_filter('adforest_footer_sidebar_options', 'adforest_footer_sidebar_options_callback', 10, 1);
add_filter('adforest_footer_widget_col_class', 'adforest_footer_widget_col_class_callback', 10, 1);
add_action('adforest_relation_follow_links', 'adforest_relation_follow_links_callback');

function adforest_relation_follow_links_callback() {

    $social_follow = '';
    if (class_exists('Redux')) {
        $social_follow = Redux::getOption('adforest_theme', 'social_follow');
    }
    if ($social_follow == 'nofollow') {
        echo adforest_returnEcho(' rel="nofollow" ');
    }
}

function adforest_footer_widget_col_class_callback($col = '') {
// 0-5 = 2 column
// 6-9 = 3 column
// 10-12 = 4 column
// 13-14 = 5 column
// 15-16 = 6 column
// 17 = 7 column
// 18 = 8 colimn
// 19 = 9 column
// 20 = 10 column
// 21 = 12 column
    $col_class = 'col-md-12 col-sm-6 col-xs-12 col-lg-12';
    if ($col >= 0 && $col <= 5) {
        $col_class = 'col-md-2 col-sm-6 col-xs-12 col-lg-2';
    } elseif ($col >= 6 && $col <= 9) {
        $col_class = 'col-md-3 col-sm-6 col-xs-12 col-lg-3';
    } elseif ($col >= 10 && $col <= 12) {
        $col_class = 'col-md-4 col-sm-6 col-xs-12 col-lg-4';
    } elseif ($col >= 13 && $col <= 14) {
        $col_class = 'col-md-5 col-sm-6 col-xs-12 col-lg-5';
    } elseif ($col >= 15 && $col <= 16) {
        $col_class = 'col-md-6 col-sm-6 col-xs-12 col-lg-6';
    } elseif ($col == 17) {
        $col_class = 'col-md-7 col-sm-6 col-xs-12 col-lg-7';
    } elseif ($col == 18) {
        $col_class = 'col-md-8 col-sm-6 col-xs-12 col-lg-8';
    } elseif ($col == 19) {
        $col_class = 'col-md-9 col-sm-6 col-xs-12 col-lg-9';
    } elseif ($col == 20) {
        $col_class = 'col-md-10 col-sm-6 col-xs-12 col-lg-10';
    } elseif ($col == 21) {
        $col_class = 'col-md-12 col-sm-6 col-xs-12 col-lg-12';
    }
    return $col_class;
}

function adforest_footer_sidebar_options_callback($options = array()) {
    $footer_cols_arr = array(
        'column 2',
        'column 2',
        'column 2',
        'column 2',
        'column 2',
        'column 2',
        'column 3',
        'column 3',
        'column 3',
        'column 3',
        'column 4',
        'column 4',
        'column 4',
        'column 5',
        'column 5',
        'column 6',
        'column 6',
        'column 7',
        'column 8',
        'column 9',
        'column 10',
        'column 12',
    );



    $options = array(
        'title' => __('Footer Widgets', 'adforest'),
        'id' => 'sb-footer-sidebar',
        'desc' => __('Enable(on) the footer widgets and add custom footer sidebar columns of your choice.After that you can add widgets in these custom footer sidebar <b>(dashboard > Apperance > widgets)</b> these widgets displays at the top of the footer.', 'adforest'),
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'sb_footer_widget_switch',
                'type' => 'switch',
                'title' => __('Footer Widgets', 'adforest'),
                'default' => false,
                'desc' => __('<b>Note</b> : This widgetize area will only work for footer-8', 'adforest'),
            ),
            array(
                'id' => 'sb_footer_cols',
                'type' => 'select',
                'multi' => true,
                'sortable' => true,
                'title' => __('Register Sidebar', 'adforest'),
                'desc' => __('Set custom footer sidebar columns for the footer widgetize area.', 'adforest'),
                'options' => $footer_cols_arr,
                'required' => array('sb_footer_widget_switch', 'equals', true)
            ),
        )
    );

    return $options;
}

if (!function_exists('adforest_dynamic_sidebars')) {

    /**
     * Adforest Dynamic Sidebars.
     * @generate sidebars
     */
    function adforest_dynamic_sidebars() {

        $adforest_sidebars = array();
        if (class_exists('Redux')) {
            $adforest_sidebars = Redux::getOption('adforest_theme', 'sb_footer_cols');
        }

        $adforest_sidebars = isset($adforest_sidebars) && !empty($adforest_sidebars) ? $adforest_sidebars : array();
        if (is_array($adforest_sidebars) && sizeof($adforest_sidebars) > 0) {
            $counter = 1;
            foreach ($adforest_sidebars as $sidebar) {
                if ($sidebar != '') {
                    $sidebar_name = sprintf(esc_html__('Footer Sidebar - %d', 'adforest'), $counter);
                    $sidebar_id = 'footer-' . $counter;
                    register_sidebar(array(
                        'name' => $sidebar_name,
                        'id' => $sidebar_id,
                        'description' => esc_html__('Add widgets here.', 'adforest'),
                        'before_widget' => '<div id="%1$s" class="widget %2$s">',
                        'after_widget' => '</div>',
                        'before_title' => '<div class="footer-widget-title"><h2>',
                        'after_title' => '</h2></div>',
                    ));
                }
                $counter++;
            }
        }
    }

    add_action('widgets_init', 'adforest_dynamic_sidebars');
}


if (!function_exists('adforest_footer_sidebar_widgets')) {

    /**
     * Footer Sidebar Widgets section.
     * @return markup
     */
    function adforest_footer_sidebar_widgets() {

        $adforest_sidebars_col = array();
        $adforest_sidebars_switch = false;
        if (class_exists('Redux')) {
            $adforest_sidebars_col = Redux::getOption('adforest_theme', 'sb_footer_cols');
            $adforest_sidebars_switch = Redux::getOption('adforest_theme', 'sb_footer_widget_switch');
        }

        if (isset($adforest_sidebars_switch) && isset($adforest_sidebars_col) && is_array($adforest_sidebars_col) && sizeof($adforest_sidebars_col) > 0) {
            $counter = 1;
            foreach ($adforest_sidebars_col as $sidebar) {
                $sidebar_id = 'footer-' . $counter;
                if (is_active_sidebar($sidebar_id)) {
                    $sidebar_col_class = apply_filters('adforest_footer_widget_col_class', $sidebar);
                    ?>
                    <div class="<?php echo esc_attr($sidebar_col_class)?>">
                        <?php dynamic_sidebar($sidebar_id)?>
                    </div>
                    <?php
                }
                $counter++;
            }
        }
    }

    add_action('adforest_footer_sidebar_widgets', 'adforest_footer_sidebar_widgets', 10);
}

if (!function_exists('adforest_header_fav_ads_callback')) {

    function adforest_header_fav_ads_callback() {
        $profile_type = isset($_GET['type']) && !empty($_GET['type']) ? $_GET['type'] : '';
        $post_ad_id = isset($_GET['id']) && !empty($_GET['id']) ? $_GET['id'] : 0;

        if ($profile_type == 'fav_ads') {
            ?>
            <script>
                jQuery(document).ready(function () {
                    jQuery('#adforest-fav-ads').click();
                    var uri = window.location.toString();
                    if (uri.indexOf("?") > 0) {
                        var clean_uri = uri.substring(0, uri.indexOf("?"));
                        window.history.replaceState({}, document.title, clean_uri);
                    }
                });
            </script>
            <?php
        }
        if ($profile_type == 'phone_verification') {
            ?>
            <script>
                jQuery(document).ready(function () {
                    setTimeout(function () {
                        jQuery('#sb-verify-phone').click();
                        var uri = window.location.toString();
                        if (uri.indexOf("?") > 0) {
                            var clean_uri = uri.substring(0, uri.indexOf("?"));
                            console.log(clean_uri);
                            window.history.replaceState({}, document.title, clean_uri);
                        }
                    }, 1000);

                });
            </script>
            <?php
        }
        if ($post_ad_id != 0) {
            $posttags = get_the_terms($post_ad_id, 'ad_tags');

            $total_tags = isset($posttags) && !empty($posttags) && count($posttags) > 0 ? count($posttags) : 0;
            ?>
            <input type="hidden" id="tags_count" value="<?php echo adforest_returnEcho($total_tags);?>" />
            <?php
        }
        if (class_exists('Redux')) {
            $hide_captcha_badge = Redux::getOption('adforest_theme', 'hide_captcha_badge');
        }
        $hide_captcha_badge = isset($hide_captcha_badge) ? $hide_captcha_badge : false;
        if (isset($hide_captcha_badge) && $hide_captcha_badge) {
            ?>
            <style>
                .grecaptcha-badge {
                    display: none;
                }
            </style>
            <?php
        }

        global $adforest_theme;
        $sb_disable_menu = isset($adforest_theme['sb_disable_menu']) ? $adforest_theme['sb_disable_menu'] : false;
        if ($sb_disable_menu) {
            ?>
            <script>
                jQuery(document).ready(function () {

                    if (jQuery('.menu-mobile-collapse-trigger').length > 0) {
                        jQuery('.menu-mobile-collapse-trigger').remove();
                    }

                });
            </script>
            <style>
                .menu-mobile-collapse-trigger {
                    display: none;
                }
            </style>
            <?php
        }
    }

    add_action('wp_footer', 'adforest_header_fav_ads_callback');
}

$adforest_themee = get_option('adforest_theme');
$package_expiry_notification = isset($adforest_themee['package_expiry_notification']) ? $adforest_themee['package_expiry_notification'] : false;
if (isset($package_expiry_notification) && ($package_expiry_notification)) {
    if (!wp_next_scheduled('adforest_package_expiray_notification')) {
        wp_schedule_event(time(), 'daily', 'adforest_package_expiray_notification');
    }
} else {
    if (wp_next_scheduled('adforest_package_expiray_notification')) {
        $timestamp = wp_next_scheduled('adforest_package_expiray_notification');
        wp_unschedule_event($timestamp, 'adforest_package_expiray_notification');
    }
}

add_action('adforest_package_expiray_notification', 'adforest_package_expiray_notification_callback');

function adforest_package_expiray_notification_callback() {
    global $adforest_theme;
    $adforest_theme = get_option('adforest_theme');
    $before_days = isset($adforest_theme['package_expire_notify_before']) ? $adforest_theme['package_expire_notify_before'] : 0;
    if (isset($adforest_theme['package_expiry_notification']) && ($adforest_theme['package_expiry_notification'])) {
        $adforest_users = get_users(['role__in' => ['subscriber']]);
        if (isset($adforest_users) && !empty($adforest_users) && is_array($adforest_users)) {
            foreach ($adforest_users as $key => $user) {
                $package_expiry_data = get_user_meta($user->ID, '_sb_expire_ads', true);
                $sb_pkg_name = get_user_meta($user->ID, '_sb_pkg_type', true);
                $user_data = $user->data;
                $user_display_name = $user_data->display_name;
                if (empty($package_expiry_data) || $package_expiry_data == -1) {
                    continue;
                }
                $notification_date = date("Y-m-d", strtotime("-{$before_days} days", strtotime($package_expiry_data)));
                $today_data = date("Y-m-d");
                if ($today_data == $notification_date) {
                    do_action('adforest_package_expiry_notification', $before_days, $user->ID);
                }
            }
        }
    }
}

add_action('wp_ajax_sb_set_site_location', 'sb_set_site_location_callback');
add_action('wp_ajax_nopriv_sb_set_site_location', 'sb_set_site_location_callback');

function sb_set_site_location_callback() {
    global $adforest_theme;
    $set_location_id = isset($_POST['location_id']) && !empty($_POST['location_id']) ? $_POST['location_id'] : 0;
    if ($set_location_id != 0) {
        $adforest_theme['adforest_site_location_id'] = $set_location_id;
        update_option('adforest_theme', $adforest_theme);
        echo '1';
    } else {
        if ($set_location_id == 'all') {
            $adforest_theme['adforest_site_location_id'] = '';
            update_option('adforest_theme', $adforest_theme);
            echo '1';
        } else {
            echo '0';
        }
    }
    wp_die();
}

add_action('adforest_topbar_location', 'adforest_topbar_location_callback');

function adforest_topbar_location_callback() {

    global $adforest_theme;

    if (isset($adforest_theme["sb_top_location"]) && !empty($adforest_theme["sb_top_location"]) && $adforest_theme["sb_top_location"] == '1') {

        wp_enqueue_style('adforest-perfect-scrollbar');
        wp_enqueue_script('adforest-perfect-scrollbar');

        $active_class = $image_idz = $final_img = $sel_image_link = $selected_loc = $loc_name = $selected_location = $image_id = $get_valz = '';
        if (isset($adforest_theme["sb_top_location_list"]) && !empty($adforest_theme["sb_top_location_list"]) && count($adforest_theme["sb_top_location_list"]) > 0) {

            $adforest_site_location_id = isset($adforest_theme["adforest_site_location_id"]) && !empty($adforest_theme["adforest_site_location_id"]) ? $adforest_theme["adforest_site_location_id"] : '';

            if ($adforest_site_location_id != "") {
                $selected_location = $adforest_site_location_id;
                $selected_loc = get_term_by('id', $selected_location, 'ad_country');
                $loc_name = $selected_loc->name;
                $image_idz = get_term_meta($selected_loc->term_id, 'taxonomy_image', true);
                $sel_image_link = wp_get_attachment_image_src($image_idz, 'adforest-single-small-50');
                if ($sel_image_link[0] != "") {
                    $final_img = $sel_image_link[0];
                } else {
                    $final_img = esc_url(trailingslashit(get_template_directory_uri()) . 'images/global.png');
                }
            } else {
                $loc_name = esc_html__('All Locations', 'adforest');
                $final_img = esc_url(trailingslashit(get_template_directory_uri()) . 'images/global.png');
            }
            ?>	 
            <ul class="list-inline">
                <li class="dropdown sb-location-selector">
                    <span class="loc"><?php echo esc_attr($loc_name);?> :</span>  
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" data-close-others="true">
                        <img src="<?php echo esc_url($final_img);?>" alt="<?php echo esc_attr($loc_name);?>"/>
                    </a>
                    <ul class="dropdown-menu pull-right sb-top-loc">
                        <li>
                            <a href="javascript:void(0)" data-loc-id="all" class="top-loc-selection">
                                <img src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'images/global.png');?>" alt="<?php echo esc_attr__('All Locations', 'adforest');?>"/>
                                <span><?php echo esc_html__('All Locations', 'adforest');?></span>
                            </a>
                        </li>
                        <?php
                        $selected_location;
                        foreach ($adforest_theme["sb_top_location_list"] as $val) {
                            $image_link = '';
                            $get_valz = get_term_by('id', $val, 'ad_country');
                            if (get_term_meta($get_valz->term_id, 'taxonomy_image', true) != "") {
                                $image_id = get_term_meta($get_valz->term_id, 'taxonomy_image', true);
                                $image_link = wp_get_attachment_image_src($image_id, 'adforest-single-small-50');
                            }
                            ?>	 
                            <li <?php
                            if ($get_valz->term_id == $selected_location) {
                                echo 'class=active';
                            }
                            ?>>
                                <a href="javascript:void(0)" data-loc-id="<?php echo esc_attr($get_valz->term_id);?>" class="top-loc-selection">
                                    <?php if (isset($image_link[0]) && $image_link[0] != "") {?>
                                        <img src="<?php echo esc_url($image_link[0]);?>" alt="<?php echo esc_attr($get_valz->name);?>"/>
                                    <?php }?>  
                                    <span><?php echo esc_attr($get_valz->name);?></span>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
            </ul>
            <?php
        }
    }
}

add_filter('adforest_site_location_ads', 'adforest_site_location_ads_callback', 10, 2);

function adforest_site_location_ads_callback($loc_args, $arg_type = 'search') {
    global $adforest_theme;

    $top_location_enable = FALSE;
    if (isset($adforest_theme['sb_header']) &&
            $adforest_theme['sb_header'] != 'modern' &&
            $adforest_theme['sb_header'] != 'light' &&
            $adforest_theme['sb_header'] != 'modern2'
    ) {
        $top_location_enable = TRUE;
    }

    if (empty($loc_args)) {
        $loc_args = '';
    }


    if (!isset($_GET['country_id'])) {

        if (isset($adforest_theme["sb_top_location"]) && $adforest_theme["sb_top_location"] && $top_location_enable) {

            $adforest_site_location_id = isset($adforest_theme["adforest_site_location_id"]) && !empty($adforest_theme["adforest_site_location_id"]) ? $adforest_theme["adforest_site_location_id"] : '';
            if ($adforest_site_location_id != "") {
                $loc_args = isset($loc_args) && !empty($loc_args) && sizeof($loc_args) > 0 ? $loc_args : array();
                if ($arg_type == 'ads') {
                    $loc_args['tax_query'] = array(
                        array(
                            'taxonomy' => 'ad_country',
                            'field' => 'term_id',
                            'terms' => $adforest_site_location_id,
                        ),
                    );
                } else {
                    $loc_args[] = array(
                        'taxonomy' => 'ad_country',
                        'field' => 'term_id',
                        'terms' => $adforest_site_location_id,
                    );
                }
            }
        }
    }
    return $loc_args;
}

add_action('wp_ajax_sb_display_bidding_section', 'sb_display_bidding_section_callback');
if (!function_exists('sb_display_bidding_section_callback')) {

    function sb_display_bidding_section_callback() {
        global $adforest_theme;
        $sb_make_bid_categorised = isset($adforest_theme['sb_make_bid_categorised']) ? $adforest_theme['sb_make_bid_categorised'] : true;
        $bid_categorised_type = isset($adforest_theme['bid_categorised_type']) ? $adforest_theme['bid_categorised_type'] : 'all';
        if ($sb_make_bid_categorised && $bid_categorised_type == 'selective') {
            $cat_id = isset($_POST['cat_id']) && !empty($_POST['cat_id']) ? $_POST['cat_id'] : 0;
            $bid_cat_base = get_term_meta($cat_id, 'adforest_make_bid_cat_base', true);
            if (isset($bid_cat_base) && $bid_cat_base == 'yes') {
                echo '1';
            } else {
                echo '0';
            }
            $ad_id = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
            update_post_meta($ad_id, 'adforest_latest_bid_cat_id', $cat_id);
        } else {
            echo '1';
        }
        wp_die();
    }

}

add_filter('adforest_make_bid_categ', 'adforest_make_bid_categ_callback', 11, 1);

function adforest_make_bid_categ_callback($bid_categories = true) {
    global $adforest_theme;

    $_sb_allow_bidding = get_user_meta(get_current_user_id(), '_sb_allow_bidding', true);
    $sb_enable_comments_offer = isset($adforest_theme['sb_enable_comments_offer']) ? $adforest_theme['sb_enable_comments_offer'] : false;

    if (!$sb_enable_comments_offer) { /// check bidding is enable or not
        return false;
    }


    if (isset($_sb_allow_bidding) && !empty($_sb_allow_bidding) && $_sb_allow_bidding <= 0) {
        $bid_categories = false;
    } else {
        $sb_make_bid_categorised = isset($adforest_theme['sb_make_bid_categorised']) ? $adforest_theme['sb_make_bid_categorised'] : true;
        $bid_categorised_type = isset($adforest_theme['bid_categorised_type']) ? $adforest_theme['bid_categorised_type'] : 'all';
        $ad_id = isset($_GET['id']) && !empty($_GET['id']) ? $_GET['id'] : 0;
        if ($sb_make_bid_categorised && $bid_categorised_type == 'selective') {
            $cat_id = get_post_meta($ad_id, 'adforest_latest_bid_cat_id', true);
            $cat_id = isset($cat_id) && !empty($cat_id) ? $cat_id : 0;
            $bid_cat_base = get_term_meta($cat_id, 'adforest_make_bid_cat_base', true);
            if (isset($bid_cat_base) && $bid_cat_base == 'yes') {
                $bid_categories = true;
            } else {
                $bid_categories = false;
            }
            $ad_id = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
            update_user_meta($ad_id, 'adforest_latest_bid_cat_id', $cat_id);
        } else {
            $bid_categories = true;
        }
    }

    return $bid_categories;
}

add_action('wp_ajax_adforest_ads_rating_reaction', 'adforest_ads_rating_reaction_emoji');
add_action('wp_ajax_nopriv_adforest_ads_rating_reaction', 'adforest_ads_rating_reaction_emoji');
if (!function_exists('adforest_ads_rating_reaction_emoji')) {

    function adforest_ads_rating_reaction_emoji() {
        if (!is_user_logged_in()) {
            echo '0|' . __("You need to login.", 'adforest');
            die();
        }

        global $adforest_listing_options;
        $reaction_id = '';
        $comment_id = '';
        if (isset($_POST['r_id']) && $_POST['r_id'] != "") {
            $reaction_id = $_POST['r_id'];
        }
        if (isset($_POST['c_id']) && $_POST['c_id'] != "") {
            $comment_id = $_POST['c_id'];
        }

        if ($reaction_id && $comment_id) {
            if (get_user_meta(get_current_user_id(), 'adforest_listing_review_submit_id' . $comment_id, true) == $comment_id) {
                echo '0|' . esc_html__("You have already reacted on this review.", 'adforest');
                die();
            } else {
                //get comment listing id and current user id
                $get_comment = get_comment($comment_id);
                $listing_id = $get_comment->comment_post_ID;

                update_user_meta(get_current_user_id(), 'adforest_listing_review_submit_id' . $comment_id, $comment_id);

                if ($reaction_id == 1) {
                    if (get_comment_meta($comment_id, 'review_like', true) != "") {
                        $current_count = get_comment_meta($comment_id, 'review_like', true);
                        $update_count = $current_count + 1;
                        update_comment_meta($comment_id, 'review_like', $update_count);
                        echo '' . $update_count;
                    } else {
                        $total_count = '1';
                        update_comment_meta($comment_id, 'review_like', $total_count);
                        echo '' . $total_count;
                    }
                }
                if ($reaction_id == 2) {
                    if (get_comment_meta($comment_id, 'review_love', true) != "") {
                        $current_count = get_comment_meta($comment_id, 'review_love', true);
                        $update_count = $current_count + 1;
                        update_comment_meta($comment_id, 'review_love', $update_count);
                        echo '' . $update_count;
                    } else {
                        $total_count = '1';
                        update_comment_meta($comment_id, 'review_love', $total_count);
                        echo '' . $total_count;
                    }
                }
                if ($reaction_id == 3) {
                    if (get_comment_meta($comment_id, 'review_wow', true) != "") {
                        $current_count = get_comment_meta($comment_id, 'review_wow', true);
                        $update_count = $current_count + 1;
                        update_comment_meta($comment_id, 'review_wow', $update_count);
                        echo '' . $update_count;
                    } else {
                        $total_count = '1';
                        update_comment_meta($comment_id, 'review_wow', $total_count);
                        echo '' . $total_count;
                    }
                }
                if ($reaction_id == 4) {
                    if (get_comment_meta($comment_id, 'review_angry', true) != "") {
                        $current_count = get_comment_meta($comment_id, 'review_angry', true);
                        $update_count = $current_count + 1;
                        update_comment_meta($comment_id, 'review_angry', $update_count);
                        echo '' . $update_count;
                    } else {
                        $total_count = '1';
                        update_comment_meta($comment_id, 'review_angry', $total_count);
                        echo '' . $total_count;
                    }
                }
            }
        }
        die();
    }

}

function adforest_exclude_child_from_tax_page($query) {
    $taxonomy_slugs = ['ad_cats'];
    if ($query->is_main_query() && is_tax($taxonomy_slugs)) {
        foreach ($query->tax_query->queries as &$tax_query_item) {
            if (empty($taxonomy_slugs) || in_array($tax_query_item['taxonomy'], $taxonomy_slugs)) {
                $tax_query_item['include_children'] = 0;
            }
        }
    }
}

//add_action('parse_tax_query', 'adforest_exclude_child_from_tax_page');


add_filter('adforest_category_widget_form_action', 'adforest_category_widget_form_action', 10, 2);

function adforest_category_widget_form_action($sb_search_page, $widget_action = '') {
    global $template, $wp;
    $page_template = basename($template);

    if ($page_template == 'taxonomy-ad_cats.php') {
        $sb_search_page = home_url($wp->request);
        if ($widget_action == 'cat_page') {
            $sb_search_page = 'javascript:void(0)';
        }
    }

    if ($page_template == 'taxonomy-ad_country.php') {
        $sb_search_page = home_url($wp->request);
        if ('location_page' == $widget_action) {
            $sb_search_page = 'javascript:void(0)';
        }
    }

    return $sb_search_page;
}

add_filter('adforest_filter_taxonomy_popup_actions', 'adforest_filter_taxonomy_popup_actions_callback', 10, 3);

function adforest_filter_taxonomy_popup_actions_callback($sb_search_page, $tax_id = '', $tax_name = 'ad_cats') {
    global $template, $wp;
    $page_template = basename($template);

    if ($page_template == 'taxonomy-ad_cats.php' && $tax_name == 'ad_cats') {
        if (isset($tax_id) && $tax_id != '') {
            $sb_search_page = get_term_link($tax_id, $tax_name);
        }
    }

    if ($page_template == 'taxonomy-ad_country.php' && $tax_name == 'ad_country') {
        if (isset($tax_id) && $tax_id != '') {
            $sb_search_page = get_term_link($tax_id, $tax_name);
        }
    }

    return $sb_search_page;
}
/*
 * Used to refresh the enqueued style and script version 
 * 
 */
$sb_refersh_enqueued = isset($adforest_theme['sb_refersh_enqueued']) && $adforest_theme['sb_refersh_enqueued'] ? TRUE : FALSE;
if ($sb_refersh_enqueued) {

    function adforest_refresh_enqueued_files($enq_source) {
        if (strpos($enq_source, 'ver=')) {
            $enq_source = remove_query_arg('ver', $enq_source);
            $enq_source = add_query_arg(array('ver' => wp_rand(99, 9999)), $enq_source);
        }
        return $enq_source;
    }

    add_filter('style_loader_src', 'adforest_refresh_enqueued_files',10, 2);
    add_filter('script_loader_src', 'adforest_refresh_enqueued_files',10, 2);
}