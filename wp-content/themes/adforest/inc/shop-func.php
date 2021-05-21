<?php
/* Shop Settings */
add_action('pre_get_posts', 'adforest_shop_filter_cat');
if (!function_exists('adforest_shop_filter_cat')) {

    function adforest_shop_filter_cat($query) {
        if (!is_admin() && is_post_type_archive('product') && $query->is_main_query()) {
            $query->set('tax_query', array(
                array(
                    'taxonomy' => 'product_type',
                    'field' => 'slug',
                    'terms' => 'adforest_classified_pkgs',
                    'operator' => 'NOT IN'
                ),
                    )
            );
        }
    }

}

if (!function_exists('adforest_shopPriceDirection')) {

    function adforest_shopPriceDirection($price = '', $curreny = '') {

        global $adforest_theme;
        $price = ( isset($price) && $price != "") ? $price : 0;

        if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'right') {
            $price = $price . $curreny;
        } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'right_with_space') {
            $price = $price . " " . $curreny;
        } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'left') {
            $price = $curreny . $price;
        } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'left_with_space') {
            $price = $curreny . " " . $price;
        } else {
            $price = $curreny . $price;
        }

        return $price;
    }

}


/**
 * Change number of products that are displayed per page (shop page)
 */
add_filter('loop_shop_per_page', 'adforest_new_loop_shop_per_page', 20);

if (!function_exists('adforest_new_loop_shop_per_page')) {

    function adforest_new_loop_shop_per_page($cols) {
        global $adforest_theme;
        // $cols contains the current number of products per page based on the value stored on Options -> Reading
        // Return the number of products you wanna show per page.
        $cols = (isset($adforest_theme['shop-number-of-products'])) ? $adforest_theme['shop-number-of-products'] : 9;
        return $cols;
    }

}

/* AdForest Custom Package */
if (!function_exists('adforest_register_custom_packages')) {

    function adforest_register_custom_packages() {
        if (class_exists('WooCommerce')) {

            class WC_Product_adforest_custom_packages extends WC_Product {

                public $product_type = 'adforest_classified_pkgs';

                public function __construct($product) {
                    parent::__construct($product);
                }

            }

        }
    }

}
add_action('init', 'adforest_register_custom_packages', 1);
//AdForest Custom Package Ends

if (!function_exists('adforest_add_packages_type')) {

    function adforest_add_packages_type($types) {
        // Key should be exactly the same as in the class product_type parameter
        $types['adforest_classified_pkgs'] = __('AdForest Packages', 'adforest');
        return $types;
    }

}
add_filter('product_type_selector', 'adforest_add_packages_type', 1);

//class for custom product type
if (!function_exists('adforest_woocommerce_product_class')) {

    function adforest_woocommerce_product_class($classname, $product_type) {
        if ($product_type == 'adforest_classified_pkgs') { // notice the checking here.
            $classname = 'WC_Product_adforest_custom_packages';
        }
        return $classname;
    }

}
add_filter('woocommerce_product_class', 'adforest_woocommerce_product_class', 10, 2);
/* * * Show pricing fields for simple_rental product. */
if (!function_exists('adforest_render_package_custom_js')) {

    function adforest_render_package_custom_js() {

        if ('product' != get_post_type()) :
            return;
        endif;
        ?><script type='text/javascript'>
            jQuery(document).ready(function () {
                jQuery('#sb_thmemes_adforest_metaboxes').hide();
                jQuery('.options_group.pricing').addClass('show_if_adforest_classified_pkgs').show();
                jQuery('#product-type').on('change', function ()
                {
                    if (jQuery(this).val() == 'adforest_classified_pkgs')
                    {
                        jQuery('#sb_thmemes_adforest_metaboxes').show();
                    } else
                    {
                        jQuery('#sb_thmemes_adforest_metaboxes').hide();
                    }
                });
                jQuery('#product-type').trigger('change');
            });

        </script><?php
    }

}
add_action('admin_footer', 'adforest_render_package_custom_js');

if (!function_exists('adforest_hide_attributes_data_panel')) {

    function adforest_hide_attributes_data_panel($tabs) {
        $tabs['attribute']['class'][] = 'hide_if_adforest_classified_pkgs';
        $tabs['shipping']['class'][] = 'hide_if_adforest_classified_pkgs';
        $tabs['linked_product']['class'][] = 'hide_if_adforest_classified_pkgs';
        $tabs['advanced']['class'][] = 'hide_if_adforest_classified_pkgs';
        return $tabs;
    }

}
add_filter('woocommerce_product_data_tabs', 'adforest_hide_attributes_data_panel');

if (!function_exists('adforest_get_woo_categories')) {

    function adforest_get_woo_categories($post_id = 0, $product_cat = 'product_cat', $args = array()) {
        $post_id = (int) $post_id;

        $defaults = array();
        $args = wp_parse_args($args, $defaults);

        $product_categories = wp_get_object_terms($post_id, $product_cat, $args);

        $cats = array();
        $html = '';
        foreach ($product_categories as $c) {
            $cat = get_category($c);
            $html .= '<a href="' . esc_url(get_term_link($cat->term_id)) . '">' . $cat->name . '</a>,';
        }
        $return_value = rtrim($html, ",");
        return $return_value;
    }

}

if (!function_exists('adforest_get_woo_stars')) {

    function adforest_get_woo_stars($average = 0) {
        $starsHTML = '';
        $ratting = round($average);
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $ratting) {
                $starsHTML .= '<i class="fa fa-star colored"></i>';
            } else {
                $starsHTML .= '<i class="fa fa-star"></i>';
            }
        }
        return $starsHTML;
    }

}
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

function adforest_get_product_type($product_id) {
    $cache_key = WC_Cache_Helper::get_cache_prefix('product_' . $product_id) . '_type_' . $product_id;
    $product_type = wp_cache_get($cache_key, 'products');

    if ($product_type) {
        return $product_type;
    }

    $post_type = get_post_type($product_id);

    if ('product_variation' === $post_type) {
        $product_type = 'variation';
    } elseif ('product' === $post_type) {
        $terms = get_the_terms($product_id, 'product_type');
        $product_type = !empty($terms) ? sanitize_title(current($terms)->name) : 'simple';
    } else {
        $product_type = false;
    }

    wp_cache_set($cache_key, $product_type, 'products');

    return $product_type;
}
