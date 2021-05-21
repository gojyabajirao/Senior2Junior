<?php
/* ------------------------------------------------ */
/* Adforest Category Ads Slider */
/* ------------------------------------------------ */
add_action('vc_before_init', 'adforest_category_ads_slider_shortcode');
if (!function_exists('adforest_category_ads_slider_shortcode')) {

    function adforest_category_ads_slider_shortcode() {

        $cat_array = array();

        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat','no');
        
        vc_map(array(
            'name' => __('Adforest Category Ads Slider', 'adforest'),
            'base' => 'adforest_category_ads_slider',
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('cats-ads-slider.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Slider Ads Settings", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Section Background Color", 'adforest'),
                    "param_name" => "section_bg",
                    "value" => array(
                        __('White', 'adforest') => '',
                        __('Gray', 'adforest') => 'gray'
                    ),
                    "description" => __("Select background color.", 'adforest'),
                ),
                array(
                    "group" => __("Slider Ads Settings", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Ads Type", 'adforest'),
                    "param_name" => "ad_typem",
                    "value" => array(
                        __('Select Ads Type', 'adforest') => '',
                        __('Featured Ads', 'adforest') => 'feature',
                        __('Simple Ads', 'adforest') => 'regular',
                        __('Both', 'adforest') => 'both'
                    ),
                ),
                array(
                    "group" => __("Slider Ads Settings", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Order By", 'adforest'),
                    "param_name" => "ad_orderm",
                    "value" => array(
                        __('Select Ads order', 'adforest') => '',
                        __('Oldest', 'adforest') => 'asc',
                        __('Latest', 'adforest') => 'desc',
                        __('Random', 'adforest') => 'rand'
                    ),
                ),
                array(
                    "group" => __("Slider Ads Settings", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Number of Ads for each category slider type", 'adforest'),
                    "param_name" => "no_of_adsm",
                    "value" => range(1, 500),
                ),
                array(
                    'group' => __('Slider Ads Settings', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category', 'adforest'),
                    'param_name' => 'catsm',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "textfield",
                            "heading" => __("Slider Category Title", "adforest"),
                            "param_name" => "slider_cat_title",
                            "description" => __('For color ', 'adforest') . '<strong>' . esc_html('{color}') . '</strong>' . __('warp text within this tag', 'adforest') . '<strong>' . esc_html('{/color}') . '</strong>',
                        ),
                        $cat_array,
                        array(
                            "type" => "dropdown",
                            "heading" => __("Banner Place", 'adforest'),
                            "param_name" => "banner_place",
                            "value" => array(
                                __('None', 'adforest') => '',
                                __('Top', 'adforest') => 'top',
                                __('Bottom', 'adforest') => 'bottom',
                            ),
                        ),
                        array(
                            "type" => "textarea",
                            "heading" => __("Banner Code", "adforest"),
                            "param_name" => "banner_code",
                            "holder" => "div",
                            "description" => __("Recommended banner size (750x56)", "adforest"),
                            'dependency' => array('element' => 'banner_place', 'value' => array('top', 'bottom')),
                        ),
                    ),
                    'description' => __('Select categories for each category slider', 'adforest'),
                ),
                array(
                    'group' => __('Sidebar Settings', 'adforest'),
                    "type" => "dropdown",
                    "heading" => __("Sidebar Place", 'adforest'),
                    "param_name" => "sidebar_place",
                    "value" => array(
                        __('Right Side', 'adforest') => 'right',
                        __('Left Side', 'adforest') => 'left',
                    ),
                ),
                array(
                    'group' => __('Sidebar Settings', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Add Sidebar Items', 'adforest'),
                    'param_name' => 'sidebar_group',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => __("Sidebar", 'adforest'),
                            "param_name" => "sidebar_settings",
                            "value" => array(
                                __('None', 'adforest') => '',
                                __('Banner', 'adforest') => 'side_banner',
                                __('Categories', 'adforest') => 'side_cats',
                                __('Ads', 'adforest') => 'side_ads',
                            ),
                        ),
                        array(
                            "type" => "textarea",
                            "heading" => __("Banner Code", "adforest"),
                            "param_name" => "side_banner_code",
                            "holder" => "div",
                            "description" => __("Recommended size (370 X 500) ", "adforest"),
                            'dependency' => array('element' => 'sidebar_settings', 'value' => array('side_banner')),
                        ),
                        array(
                            "type" => "textfield",
                            "heading" => __("Categories Title", "adforest"),
                            "param_name" => "side_cat_title",
                            "value" => '',
                            "description" => '',
                            'dependency' => array('element' => 'sidebar_settings', 'value' => array('side_cats')),
                        ),
                        array(
                            'type' => 'param_group',
                            'heading' => __('Select Category', 'adforest'),
                            'param_name' => 'cats',
                            'params' => array
                                (
                                array(
                                    "type" => "attach_image",
                                    "heading" => __("Category Image", "adforest"),
                                    "param_name" => "category_image",
                                    "description" => __("Add an image of Category : Recommended size (30 X 30)", "adforest")
                                ),
                                $cat_array,
                            ),
                            'dependency' => array('element' => 'sidebar_settings', 'value' => array('side_cats')),
                        ),
                        array(
                            "type" => "textfield",
                            "heading" => __("Ads Title", "adforest"),
                            "param_name" => "side_ads_title",
                            'dependency' => array('element' => 'sidebar_settings', 'value' => array('side_ads')),
                        ),
                        array(
                            "type" => "dropdown",
                            "heading" => __("Ads Type", 'adforest'),
                            "param_name" => "ad_type",
                            "value" => array(
                                __('Select Ads Type', 'adforest') => '',
                                __('Featured Ads', 'adforest') => 'feature',
                                __('Simple Ads', 'adforest') => 'regular',
                                __('Both', 'adforest') => 'both'
                            ),
                            'dependency' => array('element' => 'sidebar_settings', 'value' => array('side_ads')),
                        ),
                        array(
                            "type" => "dropdown",
                            "heading" => __("Order By", 'adforest'),
                            "param_name" => "ad_order",
                            "value" => array(
                                __('Select Ads order', 'adforest') => '',
                                __('Oldest', 'adforest') => 'asc',
                                __('Latest', 'adforest') => 'desc',
                                __('Random', 'adforest') => 'rand'
                            ),
                            'dependency' => array('element' => 'sidebar_settings', 'value' => array('side_ads')),
                        ),
                        array(
                            "type" => "dropdown",
                            "heading" => __("Number of Ads for each category slider type", 'adforest'),
                            "param_name" => "no_of_ads",
                            "value" => range(1, 500),
                            'dependency' => array('element' => 'sidebar_settings', 'value' => array('side_ads')),
                        ),
                        array(
                            'type' => 'vc_link',
                            'heading' => __('More Button Link', 'adforest'),
                            'param_name' => 'more_link',
                            'dependency' => array('element' => 'sidebar_settings', 'value' => array('side_ads')),
                        ),
                    ),
                ),
            )
        ));
    }

}




if (!function_exists('adforest_category_ads_slider_callback')) {

    function adforest_category_ads_slider_callback($atts, $content = '') {
        global $adforest_theme;
        extract(shortcode_atts(
                        array('ad_typem' => '',
            'ad_orderm' => '',
            'no_of_adsm' => '',
            'catsm' => '',
            'sidebar_group' => '',
            'sidebar_place' => '',
                        ), $atts)
        );
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        $cats_arr = vc_param_group_parse_atts($atts['catsm']);
        $cats_arr = apply_filters('adforest_validate_term_type',$cats_arr);
        $sidebar_group = vc_param_group_parse_atts($atts['sidebar_group']);

        /*
         * Sidebar Html
         */

        $sidebar_html = '';
        $bottom_banner = '';
        if (isset($sidebar_group) && !empty($sidebar_group) && is_array($sidebar_group) && count($sidebar_group) > 0) {

            foreach ($sidebar_group as $sidebar_part) {
                if (isset($sidebar_part['sidebar_settings']) && $sidebar_part['sidebar_settings'] == 'side_banner') {
                    $side_banner_code = isset($sidebar_part['side_banner_code']) ? $sidebar_part['side_banner_code'] : '';
                    $sidebar_html .= '<div class="mob-app-widget"><div class="mob-new-ads"> ' . $side_banner_code . '</div></div>';
                } elseif (isset($sidebar_part['sidebar_settings']) && $sidebar_part['sidebar_settings'] == 'side_cats') {
                    $ad_cats = vc_param_group_parse_atts($sidebar_part['cats']);
                    $ad_cats = apply_filters('adforest_validate_term_type',$ad_cats);
                    $side_cat_title = ($sidebar_part['side_cat_title']);
                    $sidebar_cats_html = '';
                    if (isset($ad_cats) && !empty($ad_cats) && is_array($ad_cats) && count($ad_cats) > 0) {
                        $sidebar_cats_html .= '<div class="mob-app-widget"><div class="mob-all-categories">
                                                <ul class="mob-latest-categories">';
                        $sidebar_cats_html .= '<li>
                                                   <div class="mob-latest-contents">
                                                        <h5>' . esc_html($side_cat_title) . '</h5>
                                                    </div>
                                                </li>';

                        foreach ($ad_cats as $cats) {
                            $category_image_id = isset($cats['category_image']) ? $cats['category_image'] : '';
                            $category_image = adforest_returnImgSrc($category_image_id);
                            $cat = get_term_by('id', $cats['cat'], 'ad_cats', 'OBJECT');
                            if (isset($cat) && !empty($cat) && is_object($cat)) {
                                $count = ($cat->count);
                                $sidebar_cats_html .= '<li> 
                                                        <a href="' . get_term_link($cat->term_id) . '"> <img src="' . esc_url($category_image) . '" alt="' . esc_html($cat->name) . '" class="img-responsive">
                                                            <div class="mob-details-lg">
                                                                <h6>' . esc_html($cat->name) . '</h6>
                                                                <p>' . intval($count) . ' ' . esc_html__('Ads', 'adforest') . '</p>
                                                            </div>
                                                            <i class="fa fa-angle-right"></i> </a> 
                                                    </li>';
                            }
                        }
                        $sidebar_cats_html .= '</ul>
                                                </div>
                                                </div>';
                    }
                    $sidebar_html .= $sidebar_cats_html;
                } elseif (isset($sidebar_part['sidebar_settings']) && $sidebar_part['sidebar_settings'] == 'side_ads') {
                    $ad_html = '';
                    $ad_typee = $sidebar_part['ad_type'];
                    $ad_orderr = $sidebar_part['ad_order'];
                    $no_of_adss = $sidebar_part['no_of_ads'];
                    $side_ads_title = isset($sidebar_part['side_ads_title']) ? $sidebar_part['side_ads_title'] : '';

                    $is_featuree = '';
                    if ($ad_typee == 'feature') {
                        $is_featuree = array(
                            'key' => '_adforest_is_feature',
                            'value' => 1,
                            'compare' => '=',
                        );
                    } else if ($ad_typee == 'both') {
                        $is_featuree = '';
                    } else {
                        $is_featuree = array(
                            'key' => '_adforest_is_feature',
                            'value' => 0,
                            'compare' => '=',
                        );
                    }
                    $is_activee = array(
                        'key' => '_adforest_ad_status_',
                        'value' => 'active',
                        'compare' => '=',
                    );
                    $ordering = 'DESC';
                    $order_by = 'date';
                    if ($ad_orderr == 'asc') {
                        $ordering = 'ASC';
                    } else if ($ad_orderr == 'desc') {
                        $ordering = 'DESC';
                    } else if ($ad_orderr == 'rand') {
                        $order_by = 'rand';
                    }
                    $args_side = array(
                        'post_type' => 'ad_post',
                        'post_status' => 'publish',
                        'posts_per_page' => $no_of_adss,
                        'meta_query' => array(
                            $is_featuree,
                            $is_activee,
                        ),
                        'orderby' => $order_by,
                        'order' => $ordering,
                            // 'fields' => 'ids',
                    );
                    $args_side = apply_filters('adforest_wpml_show_all_posts', $args_side);
                    $args_side = apply_filters('adforest_site_location_ads', $args_side, 'ads');
                    $results_side = new WP_Query($args_side); //side_ads_title

                    if ($results_side->have_posts()) {
                        $ad_html .= '<div class="mob-app-widget">';
                        $ad_html .= '<div class="mob-featured-ad">
                                        <h4>' . esc_html($side_ads_title) . '</h4>
                                      </div>';
                        $ad_html .= '<div class="mob-brand-feature-ad mob-brand-feature-ad-2">';
                        while ($results_side->have_posts()) {
                            $results_side->the_post();
                            $ad_html .= apply_filters('adforest_sidebar_ad_listings', get_the_ID());
                        }
                        $ad_html .= '</div>';
                        if (isset($sidebar_part['more_link']) && !empty($sidebar_part['more_link'])) {
                            $more_ads_btn = adforest_ThemeBtn($sidebar_part['more_link'], 'btn btn-theme', false);
                            $ad_html .= '<div class="mob-brand-more-ads">' . $more_ads_btn . '</div>';
                        }
                        $ad_html .= '</div>';
                    }
                    wp_reset_postdata();
                    $sidebar_html .= $ad_html;
                }
            }
        }

        $tab_field_name = 'cat';
        $taxonomy_slug = 'ad_cats';
        $cats_slider_html = '';

        if (isset($cats_arr) && !empty($cats_arr) && is_array($cats_arr) && count($cats_arr) > 0) {
            $cats_slider_html .= '';
            foreach ($cats_arr as $row) {
                $banner_code_id = isset($row['banner_code']) ? $row['banner_code'] : '';
                if (isset($row['banner_place']) && $row['banner_place'] == 'top') { // top banner code
                    $cats_slider_html .= '<div class="mob-brand-banner-4"> ' . $banner_code_id . ' </div>';
                }
                // categories slider html
                if (isset($row[$tab_field_name])) {

                    $cat_obj = get_term($row[$tab_field_name],$taxonomy_slug);
                    if (count((array) $cat_obj) == 0)
                        continue;
                    $rand_num = rand(1222, 454578);
                    ob_start();
                    ?>
                    <script>
                        jQuery(document).ready(function () {
                            var adforest_is_rtl = jQuery('#is_rtl').val();
                            var slider_rtl = false;
                            if (adforest_is_rtl != 'undefined' && adforest_is_rtl == '1') {
                                slider_rtl = true;
                            }

                            jQuery(".samsung-brand-<?php echo intval($rand_num);?>").owlCarousel({
                                loop: true,
                                margin: 10,
                                nav: true,
                                dots: false,
                                autoplay: true,
                                rtl: slider_rtl,
                                responsiveClass: true,
                                navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
                                responsive: {
                                    0: {
                                        items: 1,
                                        nav: true
                                    },
                                    600: {
                                        items: 2,
                                        nav: true
                                    },
                                    1000: {
                                        items: 4,
                                        nav: true
                                    }
                                }
                            });
                        });
                    </script>
                    <?php
                    $cats_slider_html .= ob_get_contents();
                    ob_end_clean();


                    $cats_slider_html .= '<div class="mob-sa-contents">
                                        <div class="prop-newset-heading">
                                            <h2>' . adforest_color_text($row['slider_cat_title']) . '</h2>
                                        </div>
                                        <div class="samsung-brand-' . $rand_num . ' owl-carousel owl-theme">';
                    $category = array(
                        array(
                            'taxonomy' => $taxonomy_slug,
                            'field' => 'term_id',
                            'terms' => $row[$tab_field_name],
                            'include_children' => 0,
                        ),
                    );
                    $is_feature = '';
                    if ($ad_typem == 'feature') {
                        $is_feature = array(
                            'key' => '_adforest_is_feature',
                            'value' => 1,
                            'compare' => '=',
                        );
                    } else if ($ad_typem == 'both') {
                        $is_feature = '';
                    } else {
                        $is_feature = array(
                            'key' => '_adforest_is_feature',
                            'value' => 0,
                            'compare' => '=',
                        );
                    }
                    $is_active = array(
                        'key' => '_adforest_ad_status_',
                        'value' => 'active',
                        'compare' => '=',
                    );
                    $ordering = 'DESC';
                    $order_by = 'date';
                    if ($ad_orderm == 'asc') {
                        $ordering = 'ASC';
                    } else if ($ad_orderm == 'desc') {
                        $ordering = 'DESC';
                    } else if ($ad_orderm == 'rand') {
                        $order_by = 'rand';
                    }
                    $countries_location = '';
                    $countries_location = apply_filters('adforest_site_location_ads', $countries_location, 'search');
                    $args = array(
                        'post_type' => 'ad_post',
                        'post_status' => 'publish',
                        'posts_per_page' => $no_of_adsm,
                        'meta_query' => array(
                            $is_feature,
                            $is_active,
                        ),
                        'tax_query' => array(
                            $category,
                            $countries_location,
                        ),
                        'orderby' => $order_by,
                        'order' => $ordering,
                        'fields' => 'ids',
                    );
                    $args = apply_filters('adforest_wpml_show_all_posts', $args);
                    $results = new WP_Query($args);
                    if ($results->have_posts()) {
                        while ($results->have_posts()) {
                            $results->the_post();
                            $cats_slider_html .= apply_filters('adforest_cats_sllder_view', get_the_ID(), $cat_obj);
                        }
                    }
                    $cats_slider_html .= '</div>';
                    $cats_slider_html .= '</div>';
                    //$cats_slider_html .= '';
                }

                if (isset($row['banner_place']) && $row['banner_place'] == 'bottom') { // bottom banner code
                    $cats_slider_html .= '<div class="mob-brand-banner-4">  ' . $banner_code_id . ' </div>';
                }
            }
        }
        $cats_slider_html .= $bottom_banner;


        $right_sidebar_html = '';
        $left_sidebar_html = '';

        if (isset($sidebar_place) && $sidebar_place == 'left') {
            $left_sidebar_html = '<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                                    ' . ($sidebar_html) . '
                                    </div>  ';
        } else {
            $right_sidebar_html = '<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                                    ' . ($sidebar_html) . '
                                    </div>  ';
        }

        $html = '';
        $html .= '<section class="mob-samsung-categories section-padding no-extra  ' . $bg_color . '">
                    <div class="container">
                        <div class="row">
                            ' . $left_sidebar_html . '
                            <div class="col-lg-8 col-sm-8 col-xs-12 col-md-8">
                                ' . ($cats_slider_html) . '
                            </div>
                            ' . $right_sidebar_html . '
                        </div>
                    </div>
                </section>';

        return $html;
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('adforest_category_ads_slider', 'adforest_category_ads_slider_callback');
}



add_filter('adforest_cats_sllder_view', 'adforest_cats_sllder_view_callback', 10, 2);
add_filter('adforest_sidebar_ad_listings', 'adforest_sidebar_ad_listings_callback', 10, 1);

function adforest_sidebar_ad_listings_callback($pid = 0) {
    global $adforest_theme;
    $html = '';
    if ($pid == 0) {
        return $html;
    }


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
            $img = '<a href="' . get_the_permalink() . '"><img src="' . $image[0] . '" alt="' . get_the_title() . '" class="img-responsive"> </a>';
            break;
        }
    }
    else {
        $img = '<a href="' . get_the_permalink() . '"><img src="' . adforest_get_ad_default_image_url('adforest-ad-small') . '" alt="' . get_the_title() . '" class="img-responsive"> </a>';
    }

    $ad_title = get_the_title();
    if (function_exists('adforest_title_limit')) {
        $ad_title = adforest_title_limit($ad_title);
    }

    $html .= '<div class="mob-brand-box">
                        <div class="mob-theme-box">
                            <div class="mob-brand-image"> ' . ($img) . ' </div>
                            <div class="mob-brand-text-area">
                                <h5>' . esc_html($ad_title) . '</h5>
                                <p><i class="fa fa-map-marker"></i>' . adforest_ad_locations_limit(get_post_meta(get_the_ID(), '_adforest_ad_location', true)) . '</p>
                                <span>' . adforest_adPrice(get_the_ID()) . '</span> </div>
                        </div>
                    </div>';

    return $html;
}

function adforest_cats_sllder_view_callback($pid = 0, $taxonomy_obj = 'ad_cat') {

    $html_slider = '';
    if ($pid == 0) {
        return $html;
    }
    global $adforest_theme;
    $img = '';
    $media = adforest_get_ad_images($pid);
    if (count($media) > 0) {
        foreach ($media as $m) {
            $mid = '';
            if (isset($m->ID))
                $mid = $m->ID;
            else
                $mid = $m;
            $image = wp_get_attachment_image_src($mid, 'adforest-ad-small-2');
            $img = '<a href="' . get_the_permalink() . '"><img src="' . $image[0] . '" alt="' . get_the_title() . '" class="img-responsive"> </a>';
            break;
        }
    }
    else {
        $img = '<a href="' . get_the_permalink() . '"><img src="' . adforest_get_ad_default_image_url('adforest-ad-small-2') . '" alt="' . get_the_title() . '" class="img-responsive"> </a>';
    }

    $ad_title = get_the_title();

    $html_slider .= '<div class="item">
                            <div class="mob-samsung-products">
                                <div class="mob-samsung-latest-product"> ' . ($img) . ' </div>
                                <div class="mob-samsung-text">
                                    <h4><a href="' . get_the_permalink($pid) . '">' . adforest_words_count($ad_title, 18) . '</a></h4>
                                    <span>' . esc_html($taxonomy_obj->name) . '</span> </div>
                            </div>
                        </div>';

    return $html_slider;
}
