<?php

global $adforest_theme;

$adforest_theme = get_option('adforest_theme');

/*
 * Theme Settings.
 * Make theme available for translation.
 * Translations can be filed in the /languages/ directory.
 * If you're building a theme based on Adforest, use a find and replace
 * to change ''rane to the name of your theme in all the template files.
 */
load_theme_textdomain('adforest', trailingslashit(get_template_directory()) . 'languages/');
// Content width
if (!isset($content_width)) {
    $content_width = 600;
}

add_action('adforestAction_header_content', 'adforest_header_content_html');
add_action('adforestAction_footer_content', 'adforest_footer_content_html');
add_action('adforestAction_app_notifier', 'adforest_app_notifier_html');
//WooCommrce
add_theme_support('woocommerce');
// Add default posts and comments RSS feed links to head.
add_theme_support('automatic-feed-links');

add_theme_support('wc-product-gallery-zoom');
add_theme_support('wc-product-gallery-lightbox');
add_theme_support('wc-product-gallery-slider');



/*
 * Let WordPress manage the document title.
 * By adding theme support, we declare that this theme does not use a
 * hard-coded <title> tag in the document head, and expect WordPress to
 * provide it for us.
 */
add_theme_support('title-tag');
// Theme editor style
add_editor_style('editor.css');
/*
 * Enable support for Post Thumbnails on posts and pages.
 *
 * @link https://developer.wordpress.org/themes/functionality/featured-SB_TAMEER_IMAGES-post-thumbnails/
 */
$crop_ad_images = isset($adforest_theme['crop_ad_images']) && $adforest_theme['crop_ad_images'] == false ? false : true;
add_theme_support('post-thumbnails', array('post', 'project'));
add_image_size('adforest-single-post', 760, 410, $crop_ad_images);
add_image_size('adforest-category', 400, 300, $crop_ad_images);
add_image_size('adforest-single-small', 80, 80, $crop_ad_images);
add_image_size('adforest-single-small-50', 50, 50, $crop_ad_images);
add_image_size('adforest-ad-thumb', 120, 63, $crop_ad_images);
add_image_size('adforest-ad-related', 313, 234, $crop_ad_images);
add_image_size('adforest-user-profile', 300, 300, $crop_ad_images);
add_image_size('adforest-ad-country', 250, 160, $crop_ad_images);
add_image_size('adforest-shop-thumbnail', 230, 230, $crop_ad_images);
add_image_size('adforest-shop-home', 265, 350, $crop_ad_images);
add_image_size('adforest-shop-gallery-main', 350, 350, $crop_ad_images);
add_image_size('adforest-shop-gallery', 110, 110, $crop_ad_images);
add_image_size('adforest-shop-gallery', 250, 250, $crop_ad_images);

/**
 * crop sizes for new home pages
 */
add_image_size('adforest-ads-medium', 169, 127, $crop_ad_images);
add_image_size('adforest-location-large', 370, 560, $crop_ad_images);
add_image_size('adforest-location-wide', 750, 270, $crop_ad_images);
add_image_size('adforest-location-grid', 360, 252, $crop_ad_images);
add_image_size('adforest-ad-small', 94, 102, $crop_ad_images);
add_image_size('adforest-ad-small-2', 180, 170, $crop_ad_images);
add_image_size('adforest-shop-book', 90, 147, $crop_ad_images);



/* This theme uses wp_nav_menu() in one location. */
register_nav_menus(array('main_menu' => esc_html__('adforest Primary Menu', 'adforest'),));
register_nav_menus(array('footer_main_menu' => esc_html__('adforest footer-6 , footer-7 Menu', 'adforest'),));

/*
 * Switch default core markup for search form, comment form, and comments
 * to output valid HTML5.
 */
add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption',));

/*
 * Enable support for Post Formats.
 * See https://developer.wordpress.org/themes/functionality/post-formats/
 */

/* Set up the WordPress core custom background feature. */
add_theme_support('custom-background', apply_filters('adforest_custom_background_args', array(
    'default-color' => 'ffffff',
    'default-image' => '',
)));

if (in_array('js_composer/js_composer.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    if (function_exists('vc_disable_frontend')) {
        /* vc_disable_frontend(); */
    }
}

// Register side bar for widgets
add_action('widgets_init', 'sb_themes_sidebar_widgets_init');
if (!function_exists('sb_themes_sidebar_widgets_init')) {

    function sb_themes_sidebar_widgets_init() {
        register_sidebar(array(
            'name' => esc_html__('adforest Sidebar', 'adforest'),
            'id' => 'sb_themes_sidebar',
            'before_widget' => '<div class="widget widget-content"><div id="%1$s">',
            'after_widget' => '</div></div>',
            'before_title' => '<div class="widget-heading"><h4 class="panel-title"><span>',
            'after_title' => '</span></h4></div>'
        ));
        register_sidebar(array(
            'name' => esc_html__('adforest Grid Sidebar', 'adforest'),
            'id' => 'sb_themes_grid_sidebar',
            'before_widget' => '<div class="widget widget-content"><div id="%1$s">',
            'after_widget' => '</div></div>',
            'before_title' => '<div class="widget-heading"><h4 class="panel-title"><span>',
            'after_title' => '</span></h4></div>'
        ));
        register_sidebar(array(
            'name' => esc_html__('Ads Search', 'adforest'),
            'id' => 'adforest_search_sidebar',
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '',
            'after_title' => ''
        ));
        register_sidebar(array(
            'name' => esc_html__('Single Ad Top', 'adforest'),
            'id' => 'adforest_ad_sidebar_top',
            'before_widget' => '<div class="widget">',
            'after_widget' => '</div></div>',
            'before_title' => '<div class="widget-heading"><div class="panel-title"><span>',
            'after_title' => '</span></div></div><div class="widget-content saftey">'
        ));
        register_sidebar(array(
            'name' => esc_html__('Single Ad Bottom', 'adforest'),
            'id' => 'adforest_ad_sidebar_bottom',
            'before_widget' => '<div class="widget">',
            'after_widget' => '</div></div>',
            'before_title' => '<div class="widget-heading"><div class="panel-title"><span>',
            'after_title' => '</span></div></div><div class="widget-content saftey">'
        ));
        register_sidebar(array(
            'name' => esc_html__('AdForest Woo-Commerce Siderbar', 'adforest'),
            'id' => 'adforest_woocommerce_widget',
            'before_widget' => '<div class="widget">',
            'after_widget' => '</div></div>',
            'before_title' => '<div class="widget-heading"><div class="panel-title"><a>',
            'after_title' => '</a></div></div><div class="widget-content saftey">'
        ));

        register_sidebar(array(
            'name' => esc_html__('TechForest Ajax Section - Siderbar', 'adforest'),
            'id' => 'adforest_tech_ajax_section',
            'before_widget' => '<div class="widget tech-section-widget">',
            'after_widget' => '</div></div>',
            'before_title' => '<div class="widget-heading tech-section-widget-heading"><div class="panel-title"><a>',
            'after_title' => '</a></div></div><div class="widget-content  tech-section-widget-content">'
        ));


        register_sidebar(array(
            'name' => esc_html__('Category Search - Siderbar', 'adforest'),
            'id' => 'adforest_cat_search',
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '',
            'after_title' => ''
        ));

        register_sidebar(array(
            'name' => esc_html__('Location Search - Siderbar', 'adforest'),
            'id' => 'adforest_location_search',
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '',
            'after_title' => ''
        ));
    }

}