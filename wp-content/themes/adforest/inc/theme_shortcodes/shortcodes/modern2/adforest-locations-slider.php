<?php

/* ------------------------------------------------ */
/* Adforest Locations Listings */
/* ------------------------------------------------ */
if (!function_exists('adforest_locations_slider_short')) {

    function adforest_locations_slider_short() {

        

        vc_map(array(
            "name" => __("Adforest Locations Slider", 'adforest'),
            "description" => "",
            "base" => "adforest_locations_slider",
            "category" => __("Theme Shortcodes - 2", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Location Style', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('locations-sports.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "attach_image",
                    "class" => "",
                    "heading" => __("Background Image", "adforest"),
                    "param_name" => "location_bg",
                    "value" => '',
                    "description" => __("Add an image of locations background. Note : Recommended size (1920 X 965)", "adforest")
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
                    "group" => __("Basic", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Country link Page", 'adforest'),
                    "param_name" => "country_link_page",
                    "admin_label" => true,
                    "value" => array(
                        __('Search Page', 'adforest') => 'search',
                        __('Category Page', 'adforest') => 'category',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    'group' => __('Locations', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Ad Countries', 'adforest'),
                    'param_name' => 'ads_counries',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => __("Ad Location", 'adforest'),
                            "param_name" => "ads_counry",
                            "admin_label" => true,
                            "value" => adforest_cats('ad_country', 'no'),
                        ),
                        array(
                            "type" => "attach_image",
                            "class" => "",
                            "heading" => __("Country Image", "adforest"),
                            "param_name" => "country_image",
                            "value" => '',
                            "description" => __("Add an image of country you selected.Note : Recommented size (370 X 270)", "adforest")
                        ),
                    ),
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'adforest_locations_slider_short');

if (!function_exists('adforest_locations_slider_callback')) {

    function adforest_locations_slider_callback($atts, $content = '') {
        global $adforest_theme;
        extract(shortcode_atts(array(
            'section_title' => '',
            'section_description' => '',
            'country_link_page' => '',
            'ads_counries' => '',
            'header_style' => '',
            'location_bg' => '',
                        ), $atts));
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";

        $cats_round_html = '';
        wp_enqueue_script('carousel');

        $location_bg_id = isset($location_bg) ? $location_bg : '';
        $loc_image = adforest_returnImgSrc($location_bg_id);
        $bg_style = '';
        if (!empty($location_bg_id)) {
            $bg_style = ' style="background: url(' . esc_url($loc_image) . ') !important;"';
        }


        $rows = vc_param_group_parse_atts($atts['ads_counries']);
        $cats_round_html = apply_filters("adforest_locations_listings", $cats_round_html, $rows, $country_link_page);


        $html = '';
        $html .= '<div class="sprt-ad-location">
                    <section class="dec-location-section"' . $bg_style . '>
                        <div class="container">
                            <div class="row">
                            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                             ' . ($header) . '
                                <div class="dec-location-cotent">
                                    <div class="dec-location owl-carousel owl-theme">
                                    ' . ($cats_round_html) . '
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </section>
                </div>';



        return $html;
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('adforest_locations_slider', 'adforest_locations_slider_callback');
}



add_filter('adforest_locations_listings', 'adforest_locations_listings_callback', 10, 3);

function adforest_locations_listings_callback($cats_round_html = '', $rows = array(), $country_link_page = 'javascript:void(0)') {

    if (count($rows) > 0) {
        $counter = 0;
        $col_8_flag = false;
        foreach ($rows as $row) {
            if (isset($row['ads_counry']) && $row['ads_counry'] != "") {
                $bgImageURL = adforest_returnImgSrc($row['country_image']);
                $term = get_term($row['ads_counry'], 'ad_country');
                if ($term) {
                    $count = ($term->count);
                    $bgImageURL = adforest_returnImgSrc($row['country_image']);
                    $cats_round_html .= '<div class="item">
                                            <div class="prop-ad-location-section"> <img src="' . esc_url($bgImageURL) . '" alt="' . esc_html($term->name) . '" class="img-responsive">
                                                <div class="prop-location-city"> <span>' . esc_html($term->name) . '</span>
                                                    <p>' . intval($count) . ' ' . _n('Ad', 'Ads', intval($count), 'adforest') . '</p>
                                                </div>
                                                <div class="prop-location-details"> <a href="' . adforest_cat_link_page($row['ads_counry'], $country_link_page, 'country_id') . '" class="btn-theme">' . esc_html__('View Details', 'adforest') . '</a> </div>
                                            </div>
                                        </div>';
                }
            }
            $counter ++;
        }
    }

    return $cats_round_html;
}
