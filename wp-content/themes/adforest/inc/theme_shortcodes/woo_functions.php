<?php

// After Successfull payment
//add_filter( 'woocommerce_payment_complete_order_status', 'adforest_after_payment', 10, 2 );

add_action('woocommerce_order_status_completed', 'adforest_after_payment');
if (!function_exists('adforest_after_payment')) {

    function adforest_after_payment($order_id) {
        global $adforest_theme;

        $profile = new adforest_profile();

        $order = new WC_Order($order_id);

        $uid = get_post_meta($order_id, '_customer_user', true);


        $items = $order->get_items();
        foreach ($items as $item) {
            $product_id = $item['product_id'];
            $product_type = wc_get_product($product_id);
            if (isset($adforest_theme['shop-turn-on']) && $adforest_theme['shop-turn-on'] && $product_type->get_type() != 'adforest_classified_pkgs') {
                continue;
            }

            $ads = get_post_meta($product_id, 'package_free_ads', true);
            $featured_ads = get_post_meta($product_id, 'package_featured_ads', true);
            $bump_ads = get_post_meta($product_id, 'package_bump_ads', true);
            $days = get_post_meta($product_id, 'package_expiry_days', true);
            /*
             * new features added start
             */
            $package_video_links = get_post_meta($product_id, 'package_video_links', true);
            $num_of_images = get_post_meta($product_id, 'package_num_of_images', true);
            $package_allow_tags = get_post_meta($product_id, 'package_allow_tags', true);
            $package_allow_bidding = get_post_meta($product_id, 'package_allow_bidding', true);
            $package_allow_categories = get_post_meta($product_id, 'package_allow_categories', true);


            update_user_meta($uid, '_sb_video_links', $package_video_links);
            update_user_meta($uid, '_sb_allow_tags', $package_allow_tags);
            update_user_meta($uid, 'package_allow_categories', $package_allow_categories);


            if ($num_of_images == '-1') {
                update_user_meta($uid, '_sb_num_of_images', $num_of_images);
            } else if (is_numeric($num_of_images) && $num_of_images != 0) {
                update_user_meta($uid, '_sb_num_of_images', $num_of_images);
            }
            if ($package_allow_bidding == '-1') {
                update_user_meta($uid, '_sb_allow_bidding', $package_allow_bidding);
            } else if (is_numeric($package_allow_bidding) && $package_allow_bidding != 0) {
                $already_stored_biddings = get_user_meta($uid, '_sb_allow_bidding', true);
                if ($already_stored_biddings != '-1') {
                    $new_bidding_count = $package_allow_bidding + $already_stored_biddings;
                    update_user_meta($uid, '_sb_allow_bidding', $new_bidding_count);
                } else if ($already_stored_biddings == '-1') {
                    update_user_meta($uid, '_sb_allow_bidding', $package_allow_bidding);
                }
            }

            /*
             * new features added end
             */

            update_user_meta($uid, '_sb_pkg_type', get_the_title($product_id));
            if ($ads == '-1') {
                update_user_meta($uid, '_sb_simple_ads', '-1');
            } else if (is_numeric($ads) && $ads != 0) {
                $simple_ads = get_user_meta($uid, '_sb_simple_ads', true);
                if ($simple_ads != '-1') {
                    $simple_ads = $simple_ads;
                    $new_ads = $ads + $simple_ads;
                    update_user_meta($uid, '_sb_simple_ads', $new_ads);
                } else if ($simple_ads == '-1') {
                    update_user_meta($uid, '_sb_simple_ads', $ads);
                }
            }
            if ($featured_ads == '-1') {
                update_user_meta($uid, '_sb_featured_ads', '-1');
            } else if (is_numeric($featured_ads) && $featured_ads != 0) {
                $f_ads = get_user_meta($uid, '_sb_featured_ads', true);
                if ($f_ads != '-1') {
                    $f_ads = (int) $f_ads;
                    $new_f_fads = $featured_ads + $f_ads;
                    update_user_meta($uid, '_sb_featured_ads', $new_f_fads);
                } else if ($f_ads == '-1') {
                    update_user_meta($uid, '_sb_featured_ads', $featured_ads);
                }
            }

            if ($bump_ads == '-1') {
                update_user_meta($uid, '_sb_bump_ads', '-1');
            } else if (is_numeric($bump_ads) && $bump_ads != 0) {
                $b_ads = get_user_meta($uid, '_sb_bump_ads', true);
                if ($b_ads != '-1') {
                    $b_ads = (int) $b_ads;
                    $new_b_fads = $bump_ads + $b_ads;
                    update_user_meta($uid, '_sb_bump_ads', $new_b_fads);
                } else if ($b_ads == '-1') {
                    update_user_meta($uid, '_sb_bump_ads', $bump_ads);
                }
            }

            if ($days == '-1') {
                update_user_meta($uid, '_sb_expire_ads', '-1');
            } else {
                $expiry_date = get_user_meta($uid, '_sb_expire_ads', true);
                $e_date = strtotime($expiry_date);
                $today = strtotime(date('Y-m-d'));
                if ($today > $e_date) {
                    $new_expiry = date('Y-m-d', strtotime("+$days days"));
                } else {
                    $date = date_create($expiry_date);
                    date_add($date, date_interval_create_from_date_string("$days days"));
                    $new_expiry = date_format($date, "Y-m-d");
                }
                update_user_meta($uid, '_sb_expire_ads', $new_expiry);
            }
        }
    }

}

if (!function_exists('adforest_after_payment_test')) {

    function adforest_after_payment_test($product_id) {

        $profile = new adforest_profile();
        $uid = $profile->user_info->ID;


        $ads = get_post_meta($product_id, 'package_free_ads', true);
        $featured_ads = get_post_meta($product_id, 'package_featured_ads', true);
        $days = get_post_meta($product_id, 'package_expiry_days', true);

        update_user_meta($uid, '_sb_pkg_type', get_the_title($product_id));
        if ($ads == '-1') {
            update_user_meta($uid, '_sb_simple_ads', '-1');
        } else if (is_numeric($ads) && $ads != 0) {
            $simple_ads = get_user_meta($uid, '_sb_simple_ads', true);
            $simple_ads = $simple_ads;
            $new_ads = $ads + $simple_ads;
            update_user_meta($uid, '_sb_simple_ads', $new_ads);
        }
        if ($featured_ads == '-1') {
            update_user_meta($uid, '_sb_featured_ads', '-1');
        } else if (is_numeric($featured_ads) && $featured_ads != 0) {
            $f_ads = get_user_meta($uid, '_sb_featured_ads', true);
            $f_ads = (int) $f_ads;
            $new_f_fads = $featured_ads + $f_ads;
            update_user_meta($uid, '_sb_featured_ads', $new_f_fads);
        }

        if ($days == '-1') {
            update_user_meta($uid, '_sb_expire_ads', '-1');
        } else {
            $expiry_date = get_user_meta($uid, '_sb_expire_ads', true);
            $e_date = strtotime($expiry_date);
            $today = strtotime(date('Y-m-d'));
            if ($today > $e_date) {
                $new_expiry = date('Y-m-d', strtotime("+$days days"));
            } else {
                $date = date_create($expiry_date);
                date_add($date, date_interval_create_from_date_string("$days days"));
                $new_expiry = date_format($date, "Y-m-d");
            }
            update_user_meta($uid, '_sb_expire_ads', $new_expiry);
        }
    }

}


if (!function_exists('adforest_hide_package_quantity')) {

    function adforest_hide_package_quantity($return, $product) {

        global $adforest_theme;
        if (isset($adforest_theme['shop-turn-on']) && $adforest_theme['shop-turn-on']) {
            return false;
        } else {
            return true;
        }
    }

}

add_filter('woocommerce_is_sold_individually', 'adforest_hide_package_quantity', 10, 2);


if (!function_exists('adforest_woo_price')) {

    function adforest_woo_price($currency = '', $price = 0) {
        global $adforest_theme;
        $thousands_sep = wc_get_price_thousand_separator();
        $decimals = wc_get_price_decimals();
        ;
        $decimals_separator = wc_get_price_decimal_separator();

        $price = number_format((int) $price, $decimals, $decimals_separator, $thousands_sep);
        $price = ( isset($price) && $price != "") ? $price : 0;

        if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'right') {
            $price = $price . $currency;
        } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'left') {
            $price = $currency . $price;
        } else {
            $price = $currency . $price;
        }

        return $price;
    }

}

/**
 * Auto Complete all WooCommerce orders.
 */
add_action('woocommerce_thankyou', 'adforest_custom_woocommerce_auto_complete_order', 10, 1);
if (!function_exists('adforest_custom_woocommerce_auto_complete_order')) {

    function adforest_custom_woocommerce_auto_complete_order($order_id) {
        if (!$order_id) {
            return;
        }

        global $adforest_theme;
        $adforest_theme = get_option('adforest_theme');

        if (isset($adforest_theme['sb_order_auto_approve']) && $adforest_theme['sb_order_auto_approve']) {
            $disable_auto_approve = isset($adforest_theme['sb_order_auto_approve_disable']) && !empty($adforest_theme['sb_order_auto_approve_disable']) ? $adforest_theme['sb_order_auto_approve_disable'] : array();
            $order_paid_method = get_post_meta($order_id, '_payment_method', true);
            $order_paid_method = isset($order_paid_method) && !empty($order_paid_method) ? $order_paid_method : '';
            if (isset($disable_auto_approve) && !empty($disable_auto_approve) && is_array($disable_auto_approve)) {
                if ($order_paid_method !== '' && in_array($order_paid_method, $disable_auto_approve)) {
                    return;
                }
            }

            $order = wc_get_order($order_id);
            $order->update_status('completed');
        }
    }

}

if (!function_exists('adforest_product_img_url')) {

    function adforest_product_img_url($size = 'shop_catalog') {
        global $post;
        $image_size = apply_filters('single_product_archive_thumbnail_size', $size);
        return get_the_post_thumbnail_url($post->ID, $image_size);
    }

}

function adforest_product_price($product, $view = 'default', $price_class = '') {
    global $product, $adforest_theme;

    $sb_regular_price = $product->get_regular_price();
    $sb_sale_price = $product->get_sale_price();

    if ($view == 'fancy') {
        $sb_prod_price = ' <h5>' . sb_product_currency($sb_regular_price, 'span') . '</h5>';
        if ($product->is_on_sale()) {
            $sb_prod_price = ' <h5>' . sb_product_currency($sb_sale_price, 'span'). '<small class="sale-value"><del>' . sb_product_currency($product->get_regular_price()) . '</del></small></h5>';
        }
    } elseif ($view == 'minimal') {
        
        $sb_prod_price = '<div class="price">' . sb_product_currency($sb_regular_price,'small') .'</div>';
        if ($product->is_on_sale()) {
            $sb_prod_price = '<div class="price">' . sb_product_currency($sb_sale_price,'small').'<small class="sale-value"><del>' . sb_product_currency($sb_regular_price) . '</del></small></div>';
        }
    } elseif ($view == 'modern') {
        
        $sb_prod_price = sb_product_currency($sb_regular_price,'span','dollartext'). '</div>';
        if ($product->is_on_sale()) {
            $sb_prod_price = sb_product_currency($sb_sale_price,'span','dollartext'). '<small class="sale-value"><del>' . sb_product_currency($sb_regular_price) . '</del></small></div>';
        }
    } elseif ($view == 'simple') {
        $sb_prod_price = '<span class="price">' . sb_product_currency($sb_regular_price) . '</span>';
        if ($product->is_on_sale()) {
            $sb_prod_price = '<span class="price">' .sb_product_currency($sb_sale_price). '<small class="sale-value"><del>' . sb_product_currency($sb_regular_price). '</del></small></span>';
        }
    } elseif ($view == 'modern2') {
        $sb_prod_price = '<p ' . $price_class . '>' . sb_product_currency($sb_regular_price). '</p>';
        if ($product->is_on_sale()) {

            $sb_prod_price = '<p ' . $price_class . '>' . sb_product_currency($sb_sale_price) . '<small class="sale-value"><del>' . sb_product_currency($sb_regular_price) . '</del></small></p>';
        }
    } elseif ($view == 'select') {

        $sb_prod_price = sb_product_currency($sb_regular_price,'span','dollartext');
        if ($product->is_on_sale()) {
            $sb_prod_price = sb_product_currency($sb_sale_price,'span','dollartext'). '<small class="sale-value"><del>' . sb_product_currency($sb_regular_price) . '</del></small>';
        }
    } else {
        $sb_prod_price = '<span class="price">' . sb_product_currency($product->get_regular_price()) . '</span>';
        if ($product->is_on_sale()) {
            $sb_prod_price = '<span class="price">' .sb_product_currency($product->get_sale_price()). '</span><small class="sale-value"><del>' . sb_product_currency($product->get_regular_price()) . '</del></small>';
        }
    }

    return $sb_prod_price;
}

function sb_product_currency($price,$tag = '', $class = '') {
    global $adforest_theme;
    $html = '';
    
    if ($price == '') {
        return $html;
    }

    $currency_sym = get_woocommerce_currency_symbol();
    $sb_price_direction = $adforest_theme['sb_price_direction'];
    $class = isset($class) && $class != '' ? ' class="' . $class . '" ' : '';
    $currency_html = '';

    if (isset($sb_price_direction) && ($sb_price_direction == 'right_with_space' || $sb_price_direction == 'right')) {
        if ($sb_price_direction == 'right_with_space') {
            $currency_html = ' ' . $currency_sym;
        }
        if ($sb_price_direction == 'right') {
            $currency_html = $currency_sym;
        }

        if (isset($tag) && $tag != '') {
            $html .= $price.'<' . $tag . $class . '>' . $currency_html . '</' . $tag . '>';
        } else {
            $html .= $price.$currency_html;
        }
    } else if (isset($sb_price_direction) && ($sb_price_direction == 'left_with_space' || $sb_price_direction == 'left')) {
        if ($sb_price_direction == 'left_with_space') {
            $currency_html = $currency_sym . ' ';
        }
        if ($sb_price_direction == 'left') {
            $currency_html = $currency_sym;
        }
        if (isset($tag) && $tag != '') {
            $html .= '<' . $tag . $class . '>' . $currency_html . '</' . $tag . '>'.$price;
        } else {
            $html .= $currency_html.$price;
        }
    }


    return $html;
}

function adforest_sale_html($product, $view = 'default') {

    $sale_html = '';
    if ($view == 'modern') {
        if ($product->is_on_sale()) {
            $sale_html = '<div class="sb-modern-sale">
                            <img src="' . get_template_directory_uri() . '/images/sale2.png" alt="sale image"/>
                                <div class="sale-text">' . __('Sale', 'adforest') . '</div>
                           </div>';
        }
    } else {
        if ($product->is_on_sale()) {
            $sale_html = '<div class="sale-div">
                                <img src="' . get_template_directory_uri() . '/images/sale.png" alt="sale image"/>
                                <div class="sale-text">' . __('Sale', 'adforest') . '</div>
                           </div>';
        }
    }
    return $sale_html;
}
