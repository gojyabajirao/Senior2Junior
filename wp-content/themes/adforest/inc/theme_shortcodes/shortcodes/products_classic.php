<?php
/* ------------------------------------------------ */
/* Pricing Classic */
/* ------------------------------------------------ */
if (!function_exists('price_classic_short')) {

    function price_classic_short() {
        vc_map(array(
            "name" => __("Products - Classic", 'adforest'),
            "base" => "price_classic_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('pricing-classic.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Background Color", 'adforest'),
                    "param_name" => "section_bg",
                    "admin_label" => true,
                    "value" => array(
                        __('Select Background Color', 'adforest') => '',
                        __('White', 'adforest') => '',
                        __('Gray', 'adforest') => 'gray',
                        __('Image', 'adforest') => 'img'
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                    "description" => __("Select background color.", 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => __("Background Image", 'adforest'),
                    "param_name" => "bg_img",
                    'dependency' => array(
                        'element' => 'section_bg',
                        'value' => array('img'),
                    ),
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
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Title", 'adforest'),
                    "param_name" => "section_title",
                    "description" => __('For color ', 'adforest') . '<strong>' . esc_html('{color}') . '</strong>' . __('warp text within this tag', 'adforest') . '<strong>' . esc_html('{/color}') . '</strong>',
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'header_style',
                        'value' => array('classic'),
                    ),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Title", 'adforest'),
                    "param_name" => "section_title_regular",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'header_style',
                        'value' => array('regular'),
                    ),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Description", 'adforest'),
                    "param_name" => "section_description",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'header_style',
                        'value' => array('classic'),
                    ),
                ),
                array(
                    "group" => __("Products Setting", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Column", 'adforest'),
                    "param_name" => "p_cols",
                    "value" => array(
                        __('Select Col ', 'adforest') => '',
                        __('3 Col', 'adforest') => '4',
                        __('4 Col', 'adforest') => '3'
                    ),
                ),
                array
                    (
                    'group' => __('Products', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category', 'adforest'),
                    'param_name' => 'woo_products',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => __("Select Product", 'adforest'),
                            "param_name" => "product",
                            "admin_label" => true,
                            "value" => adforest_get_products(),
                        ),
                    )
                ),
            ),
        ));
    }

}
add_action('vc_before_init', 'price_classic_short');
if (!function_exists('price_classic_short_base_func')) {

    function price_classic_short_base_func($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";



        $html = '';
        $allow_arr = array(
                        'no' => __('No', 'adforest'),
                        'yes' => __('Yes', 'adforest'),
                    );
        $rows = vc_param_group_parse_atts($woo_products);
        $categories_html = '';
        if (isset($rows) && !empty($rows) && is_array($rows) && sizeof($rows) > 0 && isset($rows[0]) && is_array($rows[0]) && sizeof($rows[0]) > 0) {
            foreach ($rows as $row) {
                if (isset($row['product'])) {
                    global $product;
                    $product_satus = get_post_status($row['product']);
                    if ($product_satus == false || $product_satus != 'publish') {
                        continue;
                    }
                    $product = new WC_Product($row['product']);
                    $cls = 'block';
                    if (get_post_meta($row['product'], 'package_bg_color', true) == 'dark')
                        $cls = 'block featured';



                    


                    $li = '';
                    if (get_post_meta($row['product'], 'package_expiry_days', true) == "-1") {
                        $li .= '<li>' . __('Validity', 'adforest') . ': ' . __('Lifetime', 'adforest') . '</li>';
                    } else if (get_post_meta($row['product'], 'package_expiry_days', true) != "") {
                        $li .= '<li>' . __('Validity', 'adforest') . ': ' . get_post_meta($row['product'], 'package_expiry_days', true) . ' ' . __('Days', 'adforest') . '</li>';
                    }

                    if (get_post_meta($row['product'], 'package_free_ads', true) != "") {
                        $free_ads = get_post_meta($row['product'], 'package_free_ads', true) == '-1' ? __('Unlimited', 'adforest') : get_post_meta($row['product'], 'package_free_ads', true);
                        $li .= '<li>' . __('Simple Ads', 'adforest') . ': ' . $free_ads . '</li>';
                    }

                    if (get_post_meta($row['product'], 'package_featured_ads', true) != "") {
                        $feature_ads = get_post_meta($row['product'], 'package_featured_ads', true) == '-1' ? __('Unlimited', 'adforest') : get_post_meta($row['product'], 'package_featured_ads', true);
                        $li .= '<li>' . __('Featured Ads', 'adforest') . ': ' . $feature_ads . '</li>';
                    }

                    if (get_post_meta($row['product'], 'package_bump_ads', true) != "") {
                        $bump_ads = get_post_meta($row['product'], 'package_bump_ads', true) == '-1' ? __('Unlimited', 'adforest') : get_post_meta($row['product'], 'package_bump_ads', true);
                        $li .= '<li>' . __('Bump-up Ads', 'adforest') . ': ' . $bump_ads . '</li>';
                    }
                    //new added
                    if (get_post_meta($row['product'], 'package_allow_bidding', true) != "") {
                        $package_allow_bidding = get_post_meta($row['product'], 'package_allow_bidding', true) == '-1' ? __('Unlimited', 'adforest') : get_post_meta($row['product'], 'package_allow_bidding', true);
                        $li .= '<li>' . __('Allow Bidding ', 'adforest') . ': ' . $package_allow_bidding . '</li>';
                    }
                    if (get_post_meta($row['product'], 'package_num_of_images', true) != "") {
                        $num_of_images = get_post_meta($row['product'], 'package_num_of_images', true) == '-1' ? __('Unlimited', 'adforest') : get_post_meta($row['product'], 'package_num_of_images', true);
                        $li .= '<li>' . __('No Of Images ', 'adforest') . ': ' . $num_of_images . '</li>';
                    }

                    if (get_post_meta($row['product'], 'package_video_links', true) != "") {
                        $video_links = get_post_meta($row['product'], 'package_video_links', true);
                        $li .= '<li>' . __('Video URL ', 'adforest') . ': ' . $allow_arr[$video_links] . '</li>';
                    }

                    if (get_post_meta($row['product'], 'package_allow_tags', true) != "") {
                        $package_allow_tags = get_post_meta($row['product'], 'package_allow_tags', true);
                        $li .= '<li>' . __('Allow Tags ', 'adforest') . ': ' . $allow_arr[$package_allow_tags] . '</li>';
                    }

                    if (get_post_meta($row['product'], 'package_allow_categories', true) != "") {
                        $selected_categories = get_post_meta($row['product'], "package_allow_categories", true);
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
                                $li .= '<li class="price-category">' . __('Categories ', 'adforest') . ': ' . __('All ', 'adforest') . '</li>';
                        } else {
                            $li .= '<li class="price-category" data-toggle="popover" data-placement="top" data-toggle="popover" title="' . __('Allowed Categories ', 'adforest') . '">' . __('Categories ', 'adforest') . ': ' . __('See All ', 'adforest') . '<i class="fa fa-question-circle"></i> ' . $cat_list_ . '</li>';
                        }
                    }


                    $html .= '<div class="col-sm-6 col-lg-' . esc_attr($p_cols) . ' col-md-' . esc_attr($p_cols) . '">
                          '.adforest_sale_html($product).'
					   <div class="' . $cls . '">
                                              
						  <h3>' . get_the_title($row['product']) . '</h3>
						  ' . adforest_product_price($product) . '
						  <ul>
							 ' . $li . '
						  </ul>
						  <a href="javascript:void(0);" class="btn btn-theme sb_add_cart" data-product-id="' . $row['product'] . '" data-product-qty="1">' . __('Select Plan', 'adforest') . ' <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
					   </div>
					</div>';
                }
            }
        }

        $parallex = '';
        if ($section_bg == 'img') {
            $parallex = 'parallex';
        }

        return '<section class="section-padding ' . $parallex . ' ' . $bg_color . '" ' . $style . '>
            <div class="container">
               <div class="row">
                  ' . $header . '
                  <div class="col-md-12 col-xs-12 col-sm-12">
                     <div class="row pricing adforest-packages">
					 	' . $html . '
                     </div>
                  </div>
               </div>
            </div>
         </section>
					 ';
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('price_classic_short_base', 'price_classic_short_base_func');
}