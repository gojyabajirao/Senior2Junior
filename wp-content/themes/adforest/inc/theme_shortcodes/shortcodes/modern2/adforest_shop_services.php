<?php

/* ------------------------------------------------ */
/* Shop Layout - Services */
/* ------------------------------------------------ */

if (!function_exists('adforest_shop_layout_service_cats')) {

    function adforest_shop_layout_service_cats($term_type = 'product_cat') {

        $result = array('value' => '', 'label' => __('Select Categories', 'adforest'));

        if (!is_admin()) {
            return $result;
        }

        $args = array('hide_empty' => 0);
        $args = apply_filters('adforest_wpml_show_all_posts', $args); // for all lang texonomies
        $terms = get_terms($term_type, $args);


        if (isset($terms) && !empty($terms) && is_array($terms) && count($terms) > 0) {
            foreach ($terms as $term) {
                $result[] = array('value' => $term->slug, 'label' => $term->name,);
            }
        }
        return $result;
    }

}

if (!function_exists('adforest_shop_services')) {

    function adforest_shop_services() {
        vc_map(array(
            "name" => __("Shop Layout - Services", 'adforest'),
            "base" => "adforest_shop_services",
            "category" => __("Theme Shortcodes - 2", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('shop-services.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
                    "heading" => __("Select Number of Product", 'adforest'),
                    "param_name" => "max_limit",
                    "value" => range(1, 100),
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
                            "value" => adforest_shop_layout_service_cats('product_cat'),
                            "description" => __("Remove All categories to show products from all categories.", "adforest"),
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'adforest_shop_services');
if (!function_exists('adforest_shop_services_callback')) {

    function adforest_shop_services_callback($atts, $content = '') {

        extract(shortcode_atts(
                        array(
            'max_limit' => '',
            'woo_products' => '',
            'all_products' => '',
            'section_description' => '',
            'section_title_regular' => '',
            'section_title' => '',
                        ), $atts));

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
        $prod_html = '';
        $loop_args = apply_filters('adforest_wpml_show_all_posts', $loop_args);
        $product_loop = new WP_Query($loop_args);
        if ($product_loop->have_posts()) {
            while ($product_loop->have_posts()) {
                $product_loop->the_post();
                $product_id = get_the_ID();
                global $product;

                $shop_thumb_url = wc_placeholder_img_src('thumbnail');
                if (get_the_post_thumbnail($product_id)) {
                    $shop_thumb_url = adforest_product_img_url('thumbnail');
                }

                $args = array();
                $cat_name = '';
                $product_categories = wp_get_object_terms($product_id, 'product_cat', $args);
                foreach ($product_categories as $c) {
                    $cat = get_category($c);
                    $cat_name = $cat->name;
                }
                $prod_html .= '<div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                            <a href="' . get_the_permalink($product_id) . '">
                                <div class="srvs-contents">
                                    <div class="srvs-new-products">
                                        <img src="' . esc_url($shop_thumb_url) . '" alt="' . esc_html__('Product Image', 'adforest') . '" class="img-responsive">
                                    </div>
                                    <div class="srvs-products-details">
                                        <h4>' . get_the_title($product_id) . '</h4>
                                        <span>' . esc_html($cat_name) . '</span>
                                    </div>
                                </div>
                            </a>
                        </div>';
            }
        }
        wp_reset_postdata();

        $html = '';
        $html .= '<section class="srvs-great-products no-extra">
                    <div class="container">
                        <div class="row">
                            ' . ($header) . '
                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">  
                            <div class="row">
                                ' . ($prod_html) . '
                            </div>
                            </div>
                        </div>
                    </div>
                </section>';
        return $html;
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('adforest_shop_services', 'adforest_shop_services_callback');
}


