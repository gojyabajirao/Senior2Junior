<?php
/* ------------------------------------------------ */
/* Shop Modern 2 */
/* ------------------------------------------------ */
if (!function_exists('shop_layout_data_shortcode2')) {

    function shop_layout_data_shortcode2($term_type = 'ad_country') {
        

        $result = array();
        if (!is_admin()) {
            return $result;
        }
        
        $args = array('hide_empty' => 0);
        $args = apply_filters('adforest_wpml_show_all_posts', $args); // for all lang texonomies
        $terms = get_terms($term_type, $args);
        
        if ($terms && !is_wp_error($terms)) {
            if (count($terms) > 0) {
                foreach ($terms as $term) {
                    $result[] = array('value' => $term->slug, 'label' => $term->name,);
                }
            }
        }
        return $result;
    }

}
if (!function_exists('shop_layout_book_short2')) {

    function shop_layout_book_short2() {
        vc_map(array(
            "name" => __("Shop Layout - Book", 'adforest'),
            "base" => "shop_layout_book_short2_base",
            "category" => __("Theme Shortcodes - 2", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('shop-layout-book.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
                        __('Regular', 'adforest') => 'regular',
                        __('Fancy', 'adforest') => 'fancy',
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
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "description" => __('For color ', 'adforest') . '<strong>' . esc_html('{color}') . '</strong>' . __('warp text within this tag', 'adforest') . '<strong>' . esc_html('{/color}') . '</strong>',
                    "heading" => __("Section Title", 'adforest'),
                    "param_name" => "section_title_fancy",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'header_style',
                        'value' => array('fancy'),
                    ),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "vc_link",
                    "heading" => __("View All Link", 'adforest'),
                    "param_name" => "view_link_fancy",
                    "description" => __("Read more Link if any.", "adforest"),
                    'dependency' => array(
                        'element' => 'header_style',
                        'value' => array('fancy'),
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
                    "heading" => __("Select Number of Product", 'adforest'),
                    "param_name" => "max_limit",
                    "value" => range(1, 100),
                ),
                array(
                    "group" => __("Products Setting", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Column", 'adforest'),
                    "param_name" => "p_cols",
                    "value" => array(
                        __('Select Col ', 'adforest') => '',
                        __('3 Col', 'adforest') => '4',
                        __('4 Col', 'adforest') => '3',
                        __('6 Col', 'adforest') => '2'
                    ),
                ),
                array(
                    'group' => __('Products', 'adforest'),
                    "type" => "dropdown",
                    "heading" => __("Select Products", 'adforest'),
                    "param_name" => "all_products",
                    "value" => array(
                        __('Select Option', 'adforest') => '',
                        __('All Categories', 'adforest') => 'all',
                        __('Selective Categories', 'adforest') => 'selective',
                    ),
                ),
                array
                    (
                    'group' => __('Products', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category', 'adforest'),
                    'param_name' => 'woo_products',
                    'value' => '',
                    'dependency' => array('element' => 'all_products', 'value' => array('selective'),),
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => __("Select Product Categories", 'adforest'),
                            "param_name" => "product",
                            "admin_label" => true,
                            "value" => shop_layout_data_shortcode2('product_cat'),
                            "description" => __("Remove All categories to show products from all categories.", "adforest"),
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'shop_layout_book_short2');
if (!function_exists('shop_layout_book_short2_base_func')) {

    function shop_layout_book_short2_base_func($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";

        $html = '';

        $rows = vc_param_group_parse_atts($woo_products);
        $categories_html = '';

        $product_cats = array();
        $max_limit = (isset($max_limit) ) ? $max_limit : 4;
        if ($all_products == "selective") {
            if (count($rows) > 0) {
                foreach ($rows as $row) {
                    if (isset($row['product'])) {
                        $product_cats[] = $row['product'];
                    }
                }
            }
            $loop_args = array(
                'post_type' => 'product',
                'posts_per_page' => $max_limit,
                'order' => 'DESC',
                'tax_query' => array(array('taxonomy' => 'product_cat', 'field' => 'slug', 'terms' => $product_cats))
            );
        } else {
            $loop_args = array('post_type' => 'product', 'posts_per_page' => $max_limit, 'order' => 'DESC',);
        }

        $loop_args = apply_filters('adforest_wpml_show_all_posts', $loop_args);
        $product_loop = new WP_Query($loop_args);
        if ($product_loop->have_posts()) {
            while ($product_loop->have_posts()) {
                $product_loop->the_post();
                $product_id = get_the_ID();
                global $product;
                $currency = get_woocommerce_currency_symbol();
                //$price = get_post_meta($product_id, '_regular_price', true);
                //$sale = get_post_meta($product_id, '_sale_price', true);
                $price = $product->get_regular_price();
                $sale = $product->get_sale_price();
                $product_typee = adforest_get_product_type($product_id);
                if (isset($product_typee) && $product_typee == 'variable') {
                    $available_variations = $product->get_available_variations();
                    if (isset($available_variations[0]['variation_id']) && !empty($available_variations[0]['variation_id'])) {
                        $variation_id = $available_variations[0]['variation_id'];
                        $variable_product1 = new WC_Product_Variation($variation_id);
                        $price = $variable_product1->get_regular_price();
                                            $sale = $variable_product1->get_sale_price();
                    }
                }
                $sale_html = ($sale) ? '<div class="shop-main-title-area"><div class="shop-new-product-area"><span>' . __("Sale", "adforest") . '</span></div></div>' : "";

                $shop_thumb = '<a href="' . esc_url(get_the_permalink($product_id)) . '"><img class="img-responsive" alt="' . get_the_title($product_id) . '" src="' . esc_url(wc_placeholder_img_src()) . '"></a>';

                if (get_the_post_thumbnail($product_id)) {
                    $shop_thumb = '<a href="' . esc_url(get_the_permalink($product_id)) . '">' . get_the_post_thumbnail(get_the_ID(), 'adforest-shop-home') . '</a>';
                }

                $average_rating = $product->get_average_rating(false);

                $sale_price = ($sale) ? '<span>' . esc_html(adforest_shopPriceDirection($sale, $currency)) . '&nbsp;</span>' : '';

                $regular_price = ($price) ? '<strike>' . esc_html(adforest_shopPriceDirection($price, $currency)) . '</strike>' : '';
                if (!$sale) {
                    $regular_price = ($price) ? '<span>' . esc_html(adforest_shopPriceDirection($price, $currency)) . '</span>' : '';
                }
                $html .= '<div class="col-lg-3 col-xs-12 col-sm-6 col-md-3">
                            <div class="bk-products-box">
                                <div class="bk-products-img">
                                    ' . $shop_thumb . ' 
                                </div>
                                <div class="bk-selections">
                                    <div class="bk-sel-rate">
                                        ' . adforest_get_woo_stars($average_rating) . '
                                    </div>
                                    <div class="bk-sel-ctrgs">
                                        <a href="' . get_the_permalink($product_id) . '" title="' . get_the_title($product_id) . '"><h4>' . get_the_title($product_id) . '</h4></a>
                                    </div>
                                    <div class="bk-sel-price">
                                        <span>' . $regular_price . ' &nbsp;</span>
                                        <span>' . $sale_price . ' &nbsp;</span>    
                                    </div>
                                </div>
                            </div>	
                        </div>';
            }
        }
        wp_reset_postdata();

        $parallex = '';
        if ($section_bg == 'img') {
            $parallex = 'parallex';
        }



        return '<section class="bk-latest-products ' . $parallex . ' ' . $bg_color . '" ' . $style . '>
                <div class="container">
                    <div class="row">
                         ' . $header . '
                        <div class="col-lg-12 col-xs-12 col-md-12 col-sm-12">
                            <div class="row">
                            ' . $html . '
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        
                    </div>
                </div>
            </section>';
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('shop_layout_book_short2_base', 'shop_layout_book_short2_base_func');
}