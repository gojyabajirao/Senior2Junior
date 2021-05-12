<?php

/* ------------------------------------------------ */
/* Select Product */
/* ------------------------------------------------ */
if (!function_exists('select_product_short')) {

    function select_product_short() {
        vc_map(array(
            "name" => __("Select Product", 'adforest'),
            "base" => "select_product_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('select_product.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => __("Background Image", 'adforest'),
                    "param_name" => "bg_img",
                    "description" => __("1280x480", 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Tagline", 'adforest'),
                    "param_name" => "section_tag_line",
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
                    "type" => "vc_link",
                    "holder" => "div",
                    "heading" => __("Button Title & Link", 'adforest'),
                    "param_name" => "link",
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Select Product", 'adforest'),
                    "param_name" => "one_product",
                    "admin_label" => true,
                    "value" => adforest_get_products(),
                ),
                array
                    (
                    'group' => __('Key Points', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category', 'adforest'),
                    'param_name' => 'points',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "textfield",
                            "holder" => "div",
                            "heading" => __("Point", 'adforest'),
                            "param_name" => "title",
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'select_product_short');
if (!function_exists('select_product_short_base_func')) {

    function select_product_short_base_func($atts, $content = '') {
        extract(shortcode_atts(array(
            'bg_img' => '',
            'section_title' => '',
            'section_tag_line' => '',
            'one_product' => '',
            'link' => '',
            'i_link' => '',
            'points' => '',
                        ), $atts));
        global $adforest_theme;

        $allow_arr = array(
            'no' => __('No', 'adforest'),
            'yes' => __('Yes', 'adforest'),
        );

        $rows = vc_param_group_parse_atts($atts['points']);
        $point_html = '';
        if (count($rows) > 0) {
            $point_html .= '<ul>';
            foreach ($rows as $row) {
                if (isset($row['title'])) {
                    $point_html .= '<li>' . $row['title'] . '</li>';
                }
            }
            $point_html .= '</ul>';
        }

        $style = '';
        if ($bg_img != "") {
            $bgImageURL = adforest_returnImgSrc($bg_img);
            $style = ( $bgImageURL != "" ) ? ' style="background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ') fixed center center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
        }
        $inner_html = '';
        $product_html = '';

        $price = '';
        if (isset($one_product) && $one_product != "") {
            $product_satus = get_post_status($one_product);
            if ($product_satus == false || $product_satus != 'publish') {
                return;
            }
            global $product;
            $product = new WC_Product($one_product);


            if (get_post_meta($one_product, 'package_expiry_days', true) == "-1") {
                $inner_html .= '<span class="f_custom">' . __('Validity', 'adforest') . ': ' . __('Lifetime', 'adforest') . '</span>';
            } else if (get_post_meta($one_product, 'package_expiry_days', true) != "") {
                $inner_html .= '<span class="f_custom">' . __('Validity', 'adforest') . ': ' . get_post_meta($one_product, 'package_expiry_days', true) . ' ' . __('Days', 'adforest') . '</span>';
            }

            if (get_post_meta($one_product, 'package_free_ads', true) != "") {
                $free_ads = get_post_meta($one_product, 'package_free_ads', true) == '-1' ? __('Unlimited', 'adforest') : get_post_meta($one_product, 'package_free_ads', true);
                $inner_html .= '<span class="f_custom">' . __('Ads', 'adforest') . ': ' . $free_ads . '</span>';
            }

            if (get_post_meta($one_product, 'package_featured_ads', true) != "") {
                $feature_ads = get_post_meta($one_product, 'package_featured_ads', true) == '-1' ? __('Unlimited', 'adforest') : get_post_meta($one_product, 'package_featured_ads', true);
                $inner_html .= '<span class="f_custom">' . __('Featured Ads', 'adforest') . ': ' . $feature_ads . '</span>';
            }
            //new features
            if (get_post_meta($one_product, 'package_num_of_images', true) != "") {
                $package_num_of_images = get_post_meta($one_product, 'package_num_of_images', true) == '-1' ? __('Unlimited', 'adforest') : get_post_meta($one_product, 'package_num_of_images', true);
                $inner_html .= '<span class="f_custom">' . __('No Of Images ', 'adforest') . ': ' . $package_num_of_images . '</span>';
            }

            if (get_post_meta($one_product, 'package_allow_bidding', true) != "") {
                $package_allow_bidding = get_post_meta($one_product, 'package_allow_bidding', true) == '-1' ? __('Unlimited', 'adforest') : get_post_meta($one_product, 'package_allow_bidding', true);
                $inner_html .= '<span class="f_custom">' . __('Allow Bidding ', 'adforest') . ': ' . $package_allow_bidding . '</span>';
            }
            if (get_post_meta($one_product, 'package_video_links', true) != "") {
                $package_video_links = get_post_meta($one_product, 'package_video_links', true);
                $inner_html .= '<span class="f_custom">' . __('Video URL ', 'adforest') . ': ' . $allow_arr[$package_video_links] . '</span>';
            }
            if (get_post_meta($one_product, 'package_allow_tags', true) != "") {
                $package_allow_tags = get_post_meta($one_product, 'package_allow_tags', true);
                $inner_html .= '<span class="f_custom">' . __('Allow Tags ', 'adforest') . ': ' . $allow_arr[$package_allow_tags] . '</span>';
            }

            if (get_post_meta($one_product, 'package_allow_categories', true) != "") {
                $selected_categories = get_post_meta($one_product, "package_allow_categories", true);
                $selected_categories = isset($selected_categories) && !empty($selected_categories) ? $selected_categories : '';
                $selected_categories_arr = array();
                if ($selected_categories != '') {
                    $selected_categories_arr = explode(",", $selected_categories);
                }
                $cat_list_ = '';
                if (isset($selected_categories_arr) && !empty($selected_categories_arr) && is_array($selected_categories_arr)) {

                    if (isset($selected_categories_arr[0]) && $selected_categories_arr[0] != 'all') {
                        $cat_list_ .= '<div  class="category_package_list"  style="display:none;" ><ul>';
                        foreach ($selected_categories_arr as $single_cat_id) {
                            $category = get_term($single_cat_id);
                            $cat_list_ .= '<li > <i class="fa fa-check"></i> ' . $category->name . '</li>';
                        }
                        $cat_list_ .= '</ul></div>';
                    }
                }
                if (isset($selected_categories_arr[0]) && $selected_categories_arr[0] == 'all') {
                    $inner_html .= '<span class="f_custom">' . __('Categories ', 'adforest') . ': ' . __('All ', 'adforest') . '</span>';
                } else {
                    $inner_html .= '<span class="f_custom" data-toggle="popover" data-placement="top" data-toggle="popover" title="' . __('Allowed Categories ', 'adforest') . '">' . __('Categories ', 'adforest') . ': ' . __('See All ', 'adforest') . '<i class="fa fa-question-circle"></i> ' . $cat_list_ . '</span>';
                }
            }


            $price = $product->get_price();
            $curreny = get_woocommerce_currency_symbol();
            if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'right') {
                $price = $price . '<span class="dollartext">' . $curreny . '</span>';
            } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'right_with_space') {
                $price = $price . " " . '<span class="dollartext">' . $curreny . '</span>';
            } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'left') {
                $price = '<span class="dollartext">' . $curreny . '</span>' . $price;
            } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'left_with_space') {
                $price = '<span class="dollartext">' . $curreny . '</span>' . " " . $price;
            } else {
                $price = '<span class="dollartext">' . $curreny . '</span>' . $price;
            }

            $product_html = '<div class="pricing-fancy adforest-packages">
                
                        <div class="icon-bg"><i class="flaticon-money-2"></i></div>
                        <h3><strong>' . get_the_title($one_product) . '</strong></h3>
                        <div class="price-box">
						    <div class="price-large">
								 ' . adforest_product_price($product, 'select') . '</div>
                           <p>' . $inner_html . '</p>
                                 <a href="javascript:void(0);" class="btn btn-block btn-theme sb_add_cart" data-product-id="' . $one_product . '" data-product-qty="1">' . __('Select Plan', 'adforest') . ' <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                        </div>
                     </div>';


            return '<section class="morden-pricing parallex for-modern-type" ' . $style . '>
            <div class="container">
               <div class="container">
                  <div class="col-md-8 col-sm-6 no-padding">
                     <div class="app-text-section">
                        <h5>' . esc_html($section_tag_line) . '</h5>
                        <h3>' . esc_html($section_title) . '</h3>
                            ' . $point_html . '
                            ' . adforest_ThemeBtn($link, 'btn btn-lg btn-theme', false, '', '<i class="fa fa-refresh"></i>') . '
                     </div>
                  </div>
                  <div class="col-md-4 col-sm-6 no-padding">
                   ' . adforest_sale_html($product) . '
				  ' . $product_html . '
                  </div>
               </div>
            </div>
         </section>';
        }
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('select_product_short_base', 'select_product_short_base_func');
}