<?php
/* ------------------------------------------------ */
/* Adforest Brands */
/* ------------------------------------------------ */
add_action('vc_before_init', 'adforest_brands_shortcode');
if (!function_exists('adforest_brands_shortcode')) {

    function adforest_brands_shortcode() {
        vc_map(array(
            'name' => __('Adforest Brands', 'adforest'),
            'description' => '',
            'base' => 'adforest_brands',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('adforest-brands.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
                        __('Gray', 'adforest') => 'gray'
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                    "description" => __("Select background color.", 'adforest'),
                ),
                array(
                    'group' => __('Ads Settings', 'adforest'),
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("Ads Head Title", "adforest"),
                    "param_name" => "ad_title",
                    "value" => '',
                    "description" => '',
                ),
                array(
                    "group" => __("Ads Settings", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Ads Type", 'adforest'),
                    "param_name" => "ad_type",
                    "admin_label" => true,
                    "value" => array(
                        __('Select Ads Type', 'adforest') => '',
                        __('Featured Ads', 'adforest') => 'feature',
                        __('Simple Ads', 'adforest') => 'regular',
                        __('Both', 'adforest') => 'both'
                    ),
                ),
                array(
                    "group" => __("Ads Settings", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Order By", 'adforest'),
                    "param_name" => "ad_order",
                    "admin_label" => true,
                    "value" => array(
                        __('Select Ads order', 'adforest') => '',
                        __('Oldest', 'adforest') => 'asc',
                        __('Latest', 'adforest') => 'desc',
                        __('Random', 'adforest') => 'rand'
                    ),
                ),
                array(
                    "group" => __("Ads Settings", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Number of Ads", 'adforest'),
                    "param_name" => "no_of_ads",
                    "admin_label" => true,
                    "value" => range(1, 500),
                ),
                array(
                    "type" => "vc_link",
                    "class" => "",
                    "heading" => __("More Ads Link", "adforest"),
                    "param_name" => "more_add_link",
                    "value" => '',
                    "description" => '',
                    'group' => __('Ads Settings', 'adforest'),
                ),
                array(
                    "group" => __("Banner Settings", "adforest"),
                    "type" => "textarea_raw_html",
                    "holder" => "div",
                    "heading" => __("Banner Code", "adforest"),
                    "param_name" => "brands_banner_code",
                    "value" => '',
                    "description" => __("Recommended banner size (750x56)", "adforest")
                ),
                array(
                    "group" => __("Banner Settings", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Banner Place", 'adforest'),
                    "param_name" => "banner_place",
                    "admin_label" => true,
                    "value" => array(
                        __('None', 'adforest') => '',
                        __('Top', 'adforest') => 'top',
                        __('Bottom', 'adforest') => 'bottom',
                    ),
                ),
                array(
                    'group' => __('Brand Settings', 'adforest'),
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("Brand Head Title", "adforest"),
                    "param_name" => "brand_title",
                    "value" => '',
                    "description" => '',
                ),
                array(
                    "type" => "vc_link",
                    "class" => "",
                    "heading" => __("View All Brands Link", "adforest"),
                    "param_name" => "brand_all_link",
                    "value" => '',
                    "description" => '',
                    'group' => __('Brand Settings', 'adforest'),
                ),
                array(
                    'group' => __('Brand Settings', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Add Image', 'adforest'),
                    'param_name' => 'brand_images',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "attach_image",
                            "class" => "",
                            "heading" => __("Brand Image", "adforest"),
                            "param_name" => "brand_image",
                            "value" => '',
                            "description" => __("Add an image of brand: Recommended size (150 X 110)", "adforest")
                        ),
                        array(
                            "type" => "textfield",
                            "class" => "",
                            "heading" => __("Image Link", "adforest"),
                            "param_name" => "image_link",
                            "value" => '',
                            "description" => '',
                        ),
                    ),
                ),
            )
        ));
    }

}

if (!function_exists('adforest_brands_callback')) {

    function adforest_brands_callback($atts, $content = '') {
        global $adforest_theme;
        extract(
                shortcode_atts(
                        array(
            'ad_type' => '',
            'ad_order' => '',
            'no_of_ads' => '',
            'more_add_link' => '',
            'brands_banner_code' => '',
            'banner_place' => '',
            'brand_title' => '',
            'brand_all_link' => '',
            'brand_images' => '',
            'ad_title' => '',
                        ), $atts)
        );
         require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        $brand_images_arr = vc_param_group_parse_atts($atts['brand_images']);
        $brands_banner_code = isset($brands_banner_code) && !empty($brands_banner_code) ? $brands_banner_code : '';
        $brand_html = '';
        if (isset($brand_images_arr) && !empty($brand_images_arr) && is_array($brand_images_arr) && sizeof($brand_images_arr) > 0) {
            foreach ($brand_images_arr as $brand) {
                $brand_image_id = isset($brand['brand_image']) ? $brand['brand_image'] : '';
                $image_link = isset($brand['image_link']) ? $brand['image_link'] : '';
                if(empty($brand_image_id)){
                    continue;
                }
                $brand_image = adforest_returnImgSrc($brand_image_id);
                $brand_html .= '<li> <a href="' . esc_url($image_link) . '">
                                    <div class="mob-brands-logo"><img src="' . esc_url($brand_image) . '" alt="' . esc_html__("Brand image", "adforest") . '" class="img-responsive"></div>
                                  </a> 
                                  </li>';
            }
        }

        $is_feature_br = '';
        if ($ad_type == 'feature') {
            $is_feature_br = array(
                'key' => '_adforest_is_feature',
                'value' => 1,
                'compare' => '=',
            );
        } else if ($ad_type == 'both') {
            $is_feature_br = '';
        } else {
            $is_feature_br = array(
                'key' => '_adforest_is_feature',
                'value' => 0,
                'compare' => '=',
            );
        }
        $is_active_br = array(
            'key' => '_adforest_ad_status_',
            'value' => 'active',
            'compare' => '=',
        );

        $ordering = 'DESC';
        $order_by_br = 'date';
        if ($ad_order == 'asc') {
            $ordering = 'ASC';
        } else if ($ad_order == 'desc') {
            $ordering = 'DESC';
        } else if ($ad_order == 'rand') {
            $order_by_br = 'rand';
        }


        $args = array(
            'post_type' => 'ad_post',
            'post_status' => 'publish',
            'posts_per_page' => $no_of_ads,
            'meta_query' => array(
                $is_feature_br,
                $is_active_br,
            ),
            'orderby' => $order_by_br,
            'order' => $ordering,
                //'fields' => 'ids',
        );
        $ads_html = '';
        $args = apply_filters('adforest_wpml_show_all_posts', $args);
        $args = apply_filters('adforest_site_location_ads', $args, 'ads');
        $results = new WP_Query($args);

        if ($results->have_posts()) {
            while ($results->have_posts()) {
                $results->the_post();
                global $post;
                $pid = get_the_ID();
                $img = '';
                $media = adforest_get_ad_images($pid);
                if (count($media) > 0) {
                    foreach ($media as $m) {
                        $mid = '';
                        if (isset($m->ID))
                            $mid = $m->ID;
                        else
                            $mid = $m;
                        $image = wp_get_attachment_image_src($mid, 'adforest-ad-small');
                        $img = '<a href="' . esc_url(get_the_permalink($pid)) . '"><img src="' . $image[0] . '" alt="' . get_the_title() . '" class="img-responsive"></a>';
                        break;
                    }
                }else {
                    $img = '<a href="' . esc_url(get_the_permalink($pid)) . '"><img src="' . adforest_get_ad_default_image_url('adforest-ad-small') . '" alt="' . get_the_title() . '" class="img-responsive"></a>';
                }

                $ad_title_p = get_the_title();
                if (function_exists('adforest_title_limit')) {
                    $ad_title_p = adforest_title_limit($ad_title_p);
                }
                $ads_html .= '<div class="mob-brand-box">
                                <div class="mob-theme-box">
                                  <div class="mob-brand-image"> ' . ($img) . ' </div>
                                  <div class="mob-brand-text-area">
                                    <h5><a href="' . esc_url(get_the_permalink($pid)) . '">' . esc_html($ad_title_p) . '</a></h5>
                                    <p><i class="fa fa-map-marker"></i>' . adforest_ad_locations_limit(get_post_meta($pid, '_adforest_ad_location', true)) . '</p>
                                    <span>' . adforest_adPrice($pid) . '</span> </div>
                                </div>
                              </div>';
            }
        }
        wp_reset_postdata();

        $banner_html = '';
        if (!empty($brands_banner_code)) {
            $banner_html = '<div class="mob-brand-banner"> ' . urldecode(adforest_decode($brands_banner_code)) . ' </div>';
        }


        $banner_top_html = '';
        $banner_bottom_html = '';

        if (!empty($banner_html) && isset($banner_place) && $banner_place == 'top') {
            $banner_top_html = $banner_html;
        } elseif (!empty($banner_html) && isset($banner_place) && $banner_place == 'bottom') {
            $banner_bottom_html = $banner_html;
        }
        
        
        $title_html = '';
        if(isset($brand_title) && !empty($brand_title)){
            $title_html = '<div class="mobile-brand-text">
                                <h3>' . esc_html($brand_title) . '</h3>
                              </div>';
        }
        
        $html = '';
        $html .= '<section class="mob-brands section-padding no-extra  ' . $bg_color . '">
                    <div class="container">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4 col-xs-12 col-md-4">
                          <div class="mob-brands-section">
                            <div class="mob-featured-ad">
                              <h4>' . esc_html($ad_title) . '</h4>
                            </div>
                            <div class="mob-brand-feature-ad">
                              ' . ($ads_html) . '
                            </div>
                            <div class="mob-brand-more-ads"> ' . adforest_ThemeBtn($more_add_link, 'btn btn-theme') . '</div>
                          </div>
                        </div>
                        <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
                          ' . ($banner_top_html) . '
                          <div class="mob-brand-content-area">
                            <div class="mob-brands-main-content-area">
                              '.$title_html.'
                              <ul>
                              ' . ($brand_html) . '
                              </ul>
                            </div>
                            <div class="mob-brand-categories"> ' . adforest_ThemeBtn($brand_all_link, 'btn-theme') . '</div>
                          </div>
                          ' . ($banner_bottom_html) . '
                        </div>
                      </div>
                    </div>
                  </section>';

        return $html;
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('adforest_brands', 'adforest_brands_callback');
}