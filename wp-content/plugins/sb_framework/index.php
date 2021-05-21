<?php

/**
 * Plugin Name: SB Framework
 * Plugin URI: https://themeforest.net/user/scriptsbundle/
 * Description: This plugin is essential for the proper theme funcationality.
 * Version: 3.2.8
 * Author: Scripts Bundle
 * Author URI: https://themeforest.net/user/scriptsbundle/
 * License: GPL2
 * Text Domain: redux-framework
 */
$my_theme = wp_get_theme();
$my_theme->get('Name');
//if( $my_theme->get( 'Name' ) != 'adforest' && $my_theme->get( 'Name' ) != 'adforest child' ) return;

define('SB_PLUGIN_FRAMEWORK_PATH', plugin_dir_path(__FILE__));

define('SB_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('SB_PLUGIN_URL', plugin_dir_url(__FILE__));
define('SB_THEMEURL_PLUGIN', get_template_directory_uri() . '/');
define('SB_IMAGES_PLUGIN', SB_THEMEURL_PLUGIN . 'images/');
define('SB_CSS_PLUGIN', SB_THEMEURL_PLUGIN . 'css/');

/* For Redux Framework */
require SB_PLUGIN_FRAMEWORK_PATH . '/admin-init.php';

/* For Add to Cart */
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    //require SB_PLUGIN_PATH . 'cart/cart-js.php';
}

/* For Contact us */
if ($my_theme->get('Name') == 'adforest' || $my_theme->get('Name') == 'adforest child') {
    require SB_PLUGIN_PATH . 'js/bg.php';
}
/* Category Templates */
require SB_PLUGIN_PATH . 'ad_post/custom-category-templates.php';
/* For Metaboxes */
require SB_PLUGIN_PATH . 'ad_post/index.php';
require SB_PLUGIN_PATH . 'cpt/index.php';




/* For Metaboxes  User profile */
require SB_PLUGIN_PATH . 'user_profile/index.php';


/* Theme functions */
require SB_PLUGIN_PATH . 'functions.php';
require SB_PLUGIN_PATH . 'inc/class-commom-email-templates.php';
require SB_PLUGIN_PATH . 'inc/adforest-common-functions.php';

add_action('admin_enqueue_scripts', 'sb_framework_scripts', 0);

function sb_framework_scripts() {
    wp_enqueue_style('sb-frm-plugin-css', plugin_dir_url(__FILE__) . 'css/plugin.css');
    wp_enqueue_script('sb-frm-plugin-js', plugin_dir_url(__FILE__) . 'js/plugin.js', false, false, true);
}

add_action('wp_enqueue_scripts', 'sb_theme_scripts');

function sb_theme_scripts() {
    wp_register_script('adforest-theme-js', plugin_dir_url(__FILE__) . 'js/theme.js', false, false, true);
    wp_register_script('adforest-jquery-ui', plugin_dir_url(__FILE__) . 'js/jquery-ui.js', false, false, true);

    wp_enqueue_script('adforest-theme-js');
}

add_action('wp', 'remove_admin_bar');

function remove_admin_bar() {
    global $adforest_theme;
    //if (!current_user_can('administrator') && !is_admin())
    //{
    if ($adforest_theme['admin_bar']) {

        if (is_user_logged_in()) {
            show_admin_bar(true);
        }
    } else {
        show_admin_bar(false);
    }
    //}
}

// Load text domain
add_action('plugins_loaded', 'sb_framework_load_plugin_textdomain');

function sb_framework_load_plugin_textdomain() {
    load_plugin_textdomain('redux-framework', FALSE, basename(dirname(__FILE__)) . '/languages/');
}

if (get_option('adforest_theme') == "") {
    $sb_option_name = 'adforest_theme';

    // Header Options
    Redux::setOption($sb_option_name, 'sb_site_logo', array('url' => SB_THEMEURL_PLUGIN . 'images/logo.png'));
    Redux::setOption($sb_option_name, 'sb_site_logo_light', array('url' => SB_THEMEURL_PLUGIN . 'images/logo.png'));
    Redux::setOption($sb_option_name, 'sb_enable_top_bar', '0');
    Redux::setOption($sb_option_name, 'admin_bar', '1');
    Redux::setOption($sb_option_name, 'theme_color', 'defualt');
    Redux::setOption($sb_option_name, 'sb_header', 'white');
    Redux::setOption($sb_option_name, 'sb_sticky_header', '0');
    Redux::setOption($sb_option_name, 'scroll_to_top', '1');
    Redux::setOption($sb_option_name, 'sell_button', '1');
    Redux::setOption($sb_option_name, 'sb_top_bar', '1');
    Redux::setOption($sb_option_name, 'top_bar_pages', '');
    Redux::setOption($sb_option_name, 'sb_sign_in_page', '');
    Redux::setOption($sb_option_name, 'sb_sign_up_page', '');
    Redux::setOption($sb_option_name, 'sb_profile_page', '');
    Redux::setOption($sb_option_name, 'sb_post_ad_page', '');
    Redux::setOption($sb_option_name, 'sb_color_plate', '0');
    Redux::setOption($sb_option_name, 'sb_pre_loader', '0');
    Redux::setOption($sb_option_name, 'ad_in_menu', '0');
    Redux::setOption($sb_option_name, 'sb_rtl', '0');
    Redux::setOption($sb_option_name, 'sb_admin_translate', '0');
    Redux::setOption($sb_option_name, 'search_in_header', '1');


    // Social Media
    Redux::setOption($sb_option_name, 'social_media', array(
        'Facebook' => '',
        'Twitter' => '',
        'Linked In' => '',
        'Google +' => '',
        'YouTube' => '',
        'Vimeo' => '',
        'Pinterest' => '',
        'Tumblr' => '',
        'Instagram' => '',
        'Reddit' => '',
        'Flickr' => '',
        'StumbleUpon' => '',
        'Delicious' => '',
        'dribble' => '',
        'behance' => '',
        'DeviantART' => '',
    ));

    // Social Media Coming Soon
    Redux::setOption($sb_option_name, 'social_media_soon', array(
        'Facebook' => '',
        'Twitter' => '',
        'Linked In' => '',
        'Google +' => '',
        'YouTube' => '',
        'Vimeo' => '',
        'Pinterest' => '',
        'Tumblr' => '',
        'Instagram' => '',
        'Reddit' => '',
        'Flickr' => '',
        'StumbleUpon' => '',
        'Delicious' => '',
        'dribble' => '',
        'behance' => '',
        'DeviantART' => '',
    ));

    // Footer Options
    Redux::setOption($sb_option_name, 'footer_style', '1');
    Redux::setOption($sb_option_name, 'footer_options', '');
    Redux::setOption($sb_option_name, 'footer_bg', array('url' => SB_THEMEURL_PLUGIN . 'images/footer.jpg'));
    Redux::setOption($sb_option_name, 'footer_site_logo', array('url' => SB_THEMEURL_PLUGIN . 'images/logo-1.png'));
    Redux::setOption($sb_option_name, 'footer_logo', array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'));
    Redux::setOption($sb_option_name, 'footer_text_under_logo', 'Aoluptas sit aspernatur aut odit aut fugit, sed elits quias horisa hinoe magni magni dolores eos qui ratione volust luptatem sequised.');
    Redux::setOption($sb_option_name, 'section_2_title', 'Hot Links');
    Redux::setOption($sb_option_name, 'footer_post_numbers', '2');
    Redux::setOption($sb_option_name, 'section_3_title', 'Recent Posts');
    Redux::setOption($sb_option_name, 'sb_footer_pages', array('2'));
    Redux::setOption($sb_option_name, 'section_4_title', 'Quick Links');
    Redux::setOption($sb_option_name, 'sb_footer_links', array('2'));
    Redux::setOption($sb_option_name, 'footer-contact-details', array(
        'Address' => '75 Blue Street, PK 54000',
        'Phone' => '(+92) 12 345 6879',
        'Fax' => '(+92) 98 765 4321',
        'Email' => 'contact@scriptsbundle.com',
        'Timing' => 'Mon-Fri 12:00pm - 12:00am'
    ));

    Redux::setOption($sb_option_name, 'footer_android_app', '');
    Redux::setOption($sb_option_name, 'footer_ios_app', '');
    Redux::setOption($sb_option_name, 'section_3_text', 'We may send you information about related events, webinars, products and services which we believe.');
    Redux::setOption($sb_option_name, 'section_3_mc', '0');
    Redux::setOption($sb_option_name, 'mailchimp_footer_list_id', '');
    Redux::setOption($sb_option_name, 'sb_footer', 'Copyright 2016 &copy; Theme Created By <a href="https://themeforest.net/user/scriptsbundle/portfolio">ScriptsBundle</a> All Rights Reserved.');
    Redux::setOption($sb_option_name, 'footer_js_and_css', '');
    Redux::setOption($sb_option_name, 'footer_4_bg', 'gray');


    // BreadCrumb
    Redux::setOption($sb_option_name, 'breadcrumb_bg', array('url' => SB_THEMEURL_PLUGIN . 'images/breadcrumb.jpg'));


    // Blog 
    Redux::setOption($sb_option_name, 'sb_blog_page_title', 'Blog Posts');
    Redux::setOption($sb_option_name, 'sb_blog_single_title', 'Blog Details');
    Redux::setOption($sb_option_name, 'blog_sidebar', 'right');
    Redux::setOption($sb_option_name, 'enable_share_post', '1');

    // Ad Post 
    Redux::setOption($sb_option_name, 'communication_mode', 'both');
    Redux::setOption($sb_option_name, 'sb_send_email_on_message', '1');
    Redux::setOption($sb_option_name, 'sb_send_email_on_ad_post', '1');
    Redux::setOption($sb_option_name, 'ad_post_email_value', get_option('admin_email'));
    Redux::setOption($sb_option_name, 'sb_currency', 'USD');

    Redux::setOption($sb_option_name, 'sb_allow_ads', '1');
    Redux::setOption($sb_option_name, 'sb_free_ads_limit', '-1');


    Redux::setOption($sb_option_name, 'admin_allow_unlimited_ads', '1');
    Redux::setOption($sb_option_name, 'sb_allow_featured_ads', '1');
    Redux::setOption($sb_option_name, 'sb_featured_ads_limit', '1');
    Redux::setOption($sb_option_name, 'sb_package_validity', '-1');


    Redux::setOption($sb_option_name, 'sb_upload_limit', '5');
    Redux::setOption($sb_option_name, 'sb_upload_size', '819200-800kb');
    Redux::setOption($sb_option_name, 'sb_ad_approval', 'auto');
    Redux::setOption($sb_option_name, 'sb_update_approval', 'auto');


    Redux::setOption($sb_option_name, 'sb_ad_update_notice', 'Hey, be careful you are updating this AD.');
    Redux::setOption($sb_option_name, 'bad_words_filter', '');
    Redux::setOption($sb_option_name, 'bad_words_replace', '');

    Redux::setOption($sb_option_name, 'ad_layout_style', '1');
    Redux::setOption($sb_option_name, 'ad_slider_type', '1');
    Redux::setOption($sb_option_name, 'style_ad_720_1', '');
    Redux::setOption($sb_option_name, 'style_ad_720_2', '');
    Redux::setOption($sb_option_name, 'style_ad_160_1', '');
    Redux::setOption($sb_option_name, 'style_ad_160_2', '');
    Redux::setOption($sb_option_name, 'report_options', 'Spam|Offensive|Duplicated|Fake');

    Redux::setOption($sb_option_name, 'featured_expiry', '7');
    Redux::setOption($sb_option_name, 'sb_packages_page', '');
    Redux::setOption($sb_option_name, 'report_limit', '10');
    Redux::setOption($sb_option_name, 'report_action', '1');
    Redux::setOption($sb_option_name, 'report_email', get_option('admin_email'));

    Redux::setOption($sb_option_name, 'Related_ads_on', '1');
    Redux::setOption($sb_option_name, 'share_ads_on', '1');
    Redux::setOption($sb_option_name, 'sb_related_ads_title', 'Similiar Ads');
    Redux::setOption($sb_option_name, 'related_ad_style', '1');
    Redux::setOption($sb_option_name, 'max_ads', '5');
    Redux::setOption($sb_option_name, 'default_related_image', array('url' => SB_THEMEURL_PLUGIN . 'images/no-image.jpg'));
    Redux::setOption($sb_option_name, 'tips_title', 'Safety tips for deal');
    Redux::setOption($sb_option_name, 'tips_for_ad', '<ol>
							 <li>Use a safe location to meet seller</li>
							 <li>Avoid cash transactions</li>
							 <li>Beware of unrealistic offers</li>
						  </ol>
	');

    Redux::setOption($sb_option_name, 'sb_search_page', '');
    Redux::setOption($sb_option_name, 'search_layout', 'grid_1');
    Redux::setOption($sb_option_name, 'search_bg', 'gray');
    Redux::setOption($sb_option_name, 'search_res_bg', 'white-bg');
    Redux::setOption($sb_option_name, 'feature_on_search', '1');
    Redux::setOption($sb_option_name, 'max_ads_feature', '5');
    Redux::setOption($sb_option_name, 'feature_ads_title', 'Featured Ads');
    Redux::setOption($sb_option_name, 'search_ad_720_1', '');
    Redux::setOption($sb_option_name, 'search_ad_720_2', '');


    // Contact Info
    Redux::setOption($sb_option_name, 'sb_timing', 'Mon - Sat: 09.00 - 19.00');
    Redux::setOption($sb_option_name, 'sb_phone', '+(789) 675 978');
    Redux::setOption($sb_option_name, 'sb_email', 'support@glixentech.com');
    Redux::setOption($sb_option_name, 'sb_address', 'Link Road, Lahore, Pakistan');
    Redux::setOption($sb_option_name, 'sb_fax', '(880) 777 4444');
    Redux::setOption($sb_option_name, 'sb_site_logo', array('url' => SB_THEMEURL_PLUGIN . 'images/logo.png'));

    // Comming Soon
    Redux::setOption($sb_option_name, 'sb_comming_soon_logo', array('url' => SB_THEMEURL_PLUGIN . 'images/logo.png'));
    Redux::setOption($sb_option_name, 'sb_comming_soon_mode', 0);
    Redux::setOption($sb_option_name, 'sb_comming_soon_date', '2017/06/28');
    Redux::setOption($sb_option_name, 'coming_soon_notify', '0');
    Redux::setOption($sb_option_name, 'mailchimp_notify_list_id', '');
    Redux::setOption($sb_option_name, 'sb_comming_soon_title', "Our website is under construction.");


    // W00 Commerce
    Redux::setOption($sb_option_name, 'shop_view', 'grid');
    Redux::setOption($sb_option_name, 'sb_shop_page_title', 'Shop');
    Redux::setOption($sb_option_name, 'sb_shop_single_title', 'Product Details');
    Redux::setOption($sb_option_name, 'enable_share', '1');
    Redux::setOption($sb_option_name, 'sb_woo_related_products', '1');
    Redux::setOption($sb_option_name, 'single_shop_view', 'without_sidebar');
    Redux::setOption($sb_option_name, 'sb_bread_crumb_enable_shop', '1');
    Redux::setOption($sb_option_name, 'sb_bread_crumb_shop', array('url' => SB_THEMEURL_PLUGIN . 'images/bredcrumb.jpg'));
    Redux::setOption($sb_option_name, 'sb_woo_related_products_title', 'Related Products');
    Redux::setOption($sb_option_name, 'sb_woo_related_products_description', 'You may like also.');

    // API Settings
    Redux::setOption($sb_option_name, 'google_api_key', '');
    Redux::setOption($sb_option_name, 'google_api_secret', '');
    Redux::setOption($sb_option_name, 'gmap_api_key', 'AIzaSyB_La6qmewwbVnTZu5mn3tVrtu6oMaSXaI');
    Redux::setOption($sb_option_name, 'mailchimp_api_key', '');
    Redux::setOption($sb_option_name, 'fb_api_key', '');
    Redux::setOption($sb_option_name, 'gmail_api_key', '');
    Redux::setOption($sb_option_name, 'hotmail_api_key', '');
    Redux::setOption($sb_option_name, 'linked_api_key', '');
    Redux::setOption($sb_option_name, 'redirect_uri', '');

    // Modern Design Settings
    Redux::setOption($sb_option_name, 'design_type', 'modern');
    Redux::setOption($sb_option_name, 'ad_layout_style_modern', '3');
    Redux::setOption($sb_option_name, 'search_design', 'sidebar');
    Redux::setOption($sb_option_name, 'search_ad_layout', 'grid_1');
}

// On Plugin Activation.
register_activation_hook(__FILE__, 'sb_framework_activate');

function sb_framework_activate() {
    // creating location table
    global $wpdb;

    $table_name = $wpdb->prefix . 'adforest_locations';
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
		  lid int NOT NULL AUTO_INCREMENT,
		  name varchar(100) NOT NULL,
		  latitude varchar(200) NOT NULL,
		  longitude varchar(200) NOT NULL,
		  country_id int NOT NULL,
		  state_id int NOT NULL,
		  location_type varchar(20) NOT NULL,
		  PRIMARY KEY  (lid)
		) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($sql);

        $wpdb->query("insert into $table_name (`lid`, `name`, `latitude`, `longitude`, `country_id`, `state_id`, `location_type`) values 
		(1, 'Punjab', '31.1704063', '72.7097161', 23, 0, 'state'),
                (2, 'Lahore', '31.5546061', '74.3571581', 23, 1, 'city'),
                (9, 'AL', '32.3182314', '-86.902298', 56, 0, 'state'),
                (10, 'Birmingham', '33.5206608', '-86.80249', 56, 9, 'city'),
                (13, 'IL', '', '', 56, 0, 'state'),
                (14, 'Chicago', '41.8781136', '-87.6297982', 56, 13, 'city'),
                (15, 'NC', '35.7595731', '-79.0192997', 56, 0, 'state'),
                (16, 'Charlotte', '35.2270869', '-80.8431267', 56, 15, 'city'),
                (17, 'Urbana', '40.1105875', '-88.2072697', 56, 13, 'city'),
                (18, 'FL', '27.6648274', '-81.5157535', 56, 0, 'state'),
                (19, 'Sydney', '27.9633563', '-82.2073118', 56, 18, 'city'),
                (20, 'AL', '32.3182314', '-86.902298', 0, 0, 'state'),
                (21, 'Birmingham', '33.5206608', '-86.80249', 0, 20, 'city'),
                (22, 'Multan', '30.1983807', '71.4687028', 23, 1, 'city'),
                (23, 'CA', '36.778261', '-119.4179324', 56, 0, 'state'),
                (24, 'Los Angeles', '34.0522342', '-118.2436849', 56, 23, 'city'),
                (25, '', '', '', 131, 0, 'state'),
                (26, 'aajsaksjas', '', '', 131, 25, 'city'),
                (27, 'NY', '43.2994285', '-74.2179326', 56, 0, 'state'),
                (28, 'New York', '43.2994285', '-74.2179326', 56, 27, 'city'),
                (29, 'NJ', '40.0583238', '-74.4056612', 56, 0, 'state'),
                (30, 'Jersey City', '40.7281575', '-74.0776417', 56, 29, 'city'),
                (31, 'Newark', '40.735657', '-74.1723667', 56, 29, 'city'),
                (32, 'WA', '47.7510741', '-120.7401386', 56, 0, 'state'),
                (33, 'Central Park', '44.938014', '-93.078205', 56, 32, 'city'),
                (34, 'Cheektowaga', '42.9026136', '-78.744572', 56, 27, 'city'),
                (35, 'Nyack', '41.0906519', '-73.9179146', 56, 27, 'city'),
                (36, 'Albany', '42.6525793', '-73.7562317', 56, 27, 'city'),
                (37, 'OR', '43.8041334', '-120.5542012', 56, 0, 'state'),
                (38, 'Nyssa', '43.8768289', '-116.9948804', 56, 37, 'city'),
                (39, 'Dover', '39.158168', '-75.5243682', 56, 29, 'city'),
                (40, 'DC', '38.9071923', '-77.0368707', 56, 0, 'state'),
                (41, 'Washington', '47.7510741', '-120.7401386', 56, 40, 'city'),
                (42, 'Washington Township', '39.7561387', '-75.0727956', 56, 29, 'city'),
                (43, 'San Francisco', '37.7749295', '-122.4194155', 56, 23, 'city'),
                (44, 'ID', '37.09024', '-95.712891', 56, 0, 'state'),
                (45, 'Idaho City', '43.8285046', '-115.8345537', 56, 44, 'city'),
                (46, 'OH', '40.4172871', '-82.907123', 56, 0, 'state'),
                (47, 'Idaho', '44.0682019', '-114.7420408', 56, 46, 'city'),
                (48, 'MI', '37.09024', '-95.712891', 56, 0, 'state'),
                (49, 'Wyoming', '43.0759678', '-107.2902839', 56, 48, 'city'),
                (50, 'TX', '31.9685988', '-99.9018131', 56, 0, 'state'),
                (51, 'El Paso', '31.7618778', '-106.4850217', 56, 50, 'city'),
                (52, 'AR', '35.20105', '-91.8318334', 56, 0, 'state'),
                (53, 'CO', '39.5500507', '-105.7820674', 56, 0, 'state'),
                (54, 'Colorado City', '32.3881745', '-100.8645576', 56, 53, 'city'),
                (55, 'NE', '37.09024', '-95.712891', 56, 0, 'state'),
                (56, 'Nebraska City', '40.6765745', '-95.8593616', 56, 55, 'city'),
                (57, 'IN', '37.09024', '-95.712891', 56, 0, 'state'),
                (58, 'Nebraska', '41.4925374', '-99.9018131', 56, 57, 'city'),
                (59, 'MO', '37.9642529', '-91.8318334', 56, 0, 'state'),
                (60, 'Kansas City', '39.0997265', '-94.5785667', 56, 59, 'city'),
                (61, 'Denver', '39.7616189', '-104.9622498', 56, 53, 'city'),
                (62, 'Oregon City', '45.3573429', '-122.6067583', 56, 37, 'city'),
                (63, 'Oregon', '43.8041334', '-120.5542012', 56, 46, 'city'),
                (64, 'Dallas', '32.7766642', '-96.7969879', 56, 50, 'city'),
                (65, 'Nevada', '38.8026097', '-116.419389', 56, 59, 'city'),
                (66, 'SD', '43.9695148', '-99.9018131', 56, 0, 'state'),
                (67, 'South Dakota Park', '43.7266181', '-103.4168231', 56, 66, 'city'),
                (68, 'NV', '38.8026097', '-116.419389', 56, 0, 'state'),
                (69, 'Las Vegas', '36.1699412', '-115.1398296', 56, 68, 'city')
		");
    }
    $url = esc_url("http://authenticate.scriptsbundle.com/adforest/activated.php") . "?purchase_code=" . get_option('_sb_purchase_code');
    $res = file_get_contents($url);
}

register_uninstall_hook(__FILE__, 'sb_framework_uninstall');

// And here goes the uninstallation function:
function sb_framework_uninstall() {
    delete_option('_sb_purchase_code');
}

// Keep admin section in english
$get_val = get_option('adforest_theme');
if (isset($get_val['sb_admin_translate']) && $get_val['sb_admin_translate'] == 0 && $my_theme->get('Name') == 'adforest' && $my_theme->get('Name') == 'adforest child') {
    add_filter('locale', 'sb_admin_in_english_locale');
}

// Keep admin section in english
function sb_admin_in_english_locale($locale) {
    if (sb_admin_in_english_should_use_english()) {
        $locale = 'en_US';
    }
    return $locale;
}

function sb_admin_in_english_should_use_english() {
    // frontend AJAX calls are mistakend for admin calls, because the endpoint is wp-admin/admin-ajax.php
    return sb_admin_in_english_is_admin() && !sb_admin_in_english_is_frontend_ajax();
}

function sb_admin_in_english_is_admin() {
    return
            is_admin() || sb_admin_in_english_is_tiny_mce() || sb_admin_in_english_is_login_page();
}

function sb_admin_in_english_is_frontend_ajax() {
    return defined('DOING_AJAX') && DOING_AJAX && false === strpos(wp_get_referer(), '/wp-admin/');
}

function sb_admin_in_english_is_tiny_mce() {
    return false !== strpos($_SERVER['REQUEST_URI'], '/wp-includes/js/tinymce/');
}

function sb_admin_in_english_is_login_page() {
    return false !== strpos($_SERVER['REQUEST_URI'], '/wp-login.php');
}