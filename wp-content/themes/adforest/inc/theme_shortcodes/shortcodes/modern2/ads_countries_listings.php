<?php
/* ------------------------------------------------ */
/* Adforest Locations Listings */
/* ------------------------------------------------ */
if (!function_exists('ads_countries_listings_short')) {

    function ads_countries_listings_short() {

        vc_map(array(
            "name" => __("Adforest Locations Listings", 'adforest'),
            "description" => __("Once on a Page.", 'adforest'),
            "base" => "ads_countries_listings",
            "category" => __("Theme Shortcodes - 2", 'adforest'),
            "params" => array(
                array(
                    "type" => "dropdown",
                    "heading" => __("Countries Style", 'adforest'),
                    "param_name" => "country_style",
                    "admin_label" => true,
                    "value" => array(
                        __('Style 1', 'adforest') => '',
                        __('Style 2', 'adforest') => 'style2',
                        __('Style 3', 'adforest') => 'style3',
                        __('Style 4', 'adforest') => 'style4',
                    ),
                    "group" => __("Shortcode Output", "adforest"),
                ),
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Style 1', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('countries_listings.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Style 2', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('countries_listings2.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Style 3', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('countries_listings3.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Style 4', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('countries_listings4.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
                    "heading" => __("Number of Countries", 'adforest'),
                    "param_name" => "no_of_countries",
                    "description" => __("Add num of countries to display in per page.", "adforest"),
                    "admin_label" => true,
                    "value" => range(1, 500),
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
                    'group' => __('Countries', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Ad Countries', 'adforest'),
                    'param_name' => 'ads_counries',
                    "description" => __("Add num of countries to display in per page.", "adforest"),
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => __("Ad Conditions", 'adforest'),
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
                            "description" => __("<b>Note :</b> Uploaded iamge size should be greater or equal to these following image size for best results. <br /> <b> Grid : Recommended(360 x 252)</b><br /> <b> wide : Recommended(750 x 270)</b><br /> <b> large : Recommended(370 x 560)</b> ", "adforest")
                        ),
                    ),
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'ads_countries_listings_short');

if (!function_exists('ads_countries_listings_callback')) {

    function ads_countries_listings_callback($atts, $content = '') {
        global $adforest_theme;
        extract(shortcode_atts(array(
            'section_title' => '',
            'country_style' => 'style1',
            'section_description' => '',
            'no_of_countries' => 1,
            'country_link_page' => '',
            'ads_counries' => '',
            'header_style' => '',
                        ), $atts));
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";

        $cats_round_html = '';

        $rows = vc_param_group_parse_atts($atts['ads_counries']);
        $cats_round_html = apply_filters("adforest_countries_listings_{$country_style}", $cats_round_html, $rows, $country_link_page);
        $html = '';
        $html .= '<section class="prop-ad-location-v2 custom-padding ' . $bg_color . '">
                        <div class="container">
                            <div class="row">
                              ' . ($header) . '
                                
                              ' . ($cats_round_html) . '
                                
                            </div>
                        </div>
                    </section>';
        return $html;
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('ads_countries_listings', 'ads_countries_listings_callback');
}



add_filter('adforest_countries_listings_style1', 'adforest_countries_listings_style1', 10, 3);
add_filter('adforest_countries_listings_style2', 'adforest_countries_listings_style2', 10, 3);
add_filter('adforest_countries_listings_style3', 'adforest_countries_listings_style3', 10, 3);
add_filter('adforest_countries_listings_style4', 'adforest_countries_listings_style4', 10, 3);

function adforest_countries_listings_style1($cats_round_html = '', $rows = array(), $country_link_page = 'javascript:void(0)') {

    if (count($rows) > 0) {
        $counter = 0;
        $col_8_flag = false;
        foreach ($rows as $row) {
            if (isset($row['ads_counry']) && $row['ads_counry'] != "") {
                $bgImageURL = adforest_returnImgSrc($row['country_image']);
                $term = get_term($row['ads_counry'], 'ad_country');
                if ($term) {
                    $count = ($term->count);
                    if ($counter == 0) {
                        $bgImageURL = adforest_returnImgSrc($row['country_image'], 'adforest-location-large');
                        $cats_round_html .= '<div class="col-lg-4 col-xs-12 col-sm-4 col-md-4">
                                    <div class="prop-ad-location-images"> <img  src="' . esc_url($bgImageURL) . '" alt="' . esc_html($term->name) . '" class="img-responsive">
                                        <div class="prop-location-city"> <span>' . esc_html($term->name) . '</span>
                                            <p>' . intval($count) . ' ' . _n('Ad', 'Ads', intval($count), 'adforest') . '</p>
                                        </div>
                                        <div class="prop-location-details"> <a href="' . adforest_cat_link_page($row['ads_counry'], $country_link_page, 'country_id') . '" class="btn-theme">' . esc_html__('View Details', 'adforest') . '</a> </div>
                                    </div>
                                </div>';
                    }
                    if ($counter == 1) {
                        $cats_round_html .= '<div class="col-lg-8 col-xs-12 col-sm-8 col-md-8 no-padding">';
                    }
                    if ($counter == 1 || $counter == 2) {
                        $bgImageURL = adforest_returnImgSrc($row['country_image'], 'adforest-location-grid');
                        $cats_round_html .= '<div class="col-lg-6 col-xs-12 col-sm-6 col-md-6">
                                                
                                                    <div class="prop-ad-location-section"> <img  src="' . esc_url($bgImageURL) . '" alt="' . esc_html($term->name) . '" class="img-responsive">
                                                        <div class="prop-location-city"> <span>' . esc_html($term->name) . '</span>
                                                            <p>' . intval($count) . ' ' . _n('Ad', 'Ads', intval($count), 'adforest') . '</p>
                                                        </div>
                                                        <div class="prop-location-details"> <a href="' . adforest_cat_link_page($row['ads_counry'], $country_link_page, 'country_id') . '" class="btn-theme">' . esc_html__('View Details', 'adforest') . '</a> </div>
                                                    </div>
                                                       
                                            </div>';
                    }
                    if ($counter == 3) {
                        $bgImageURL = adforest_returnImgSrc($row['country_image'], 'adforest-location-wide');
                        $cats_round_html .= '<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                                                <div class="ad-location-main-area"> <img src="' . esc_url($bgImageURL) . '" alt="' . esc_html($term->name) . '" class="img-responsive">
                                                    <div class="prop-location-city prop-loc"> <span>' . esc_html($term->name) . '</span>
                                                        <p>' . intval($count) . ' ' . _n('Ad', 'Ads', intval($count), 'adforest') . '</p>
                                                    </div>
                                                    <div class="prop-location-details prop-detail"> <a href="' . adforest_cat_link_page($row['ads_counry'], $country_link_page, 'country_id') . '" class="btn-theme">' . esc_html__('View Details', 'adforest') . '</a> </div>
                                                </div>
                                            </div>';
                    }
                    if ($counter == 3) {
                        $cats_round_html .= '</div>';
                    }
                    if ($counter >= 4) {
                        $bgImageURL = adforest_returnImgSrc($row['country_image'], 'adforest-location-grid');
                        $cats_round_html .= '<div class="col-lg-4 col-xs-12 col-sm-6 col-md-4">
                                                <div class="prop-ad-location-section"> <img src="' . esc_url($bgImageURL) . '" alt="' . esc_html($term->name) . '" class="img-responsive">
                                                    <div class="prop-location-city"> <span>' . esc_html($term->name) . '</span>
                                                        <p>' . intval($count) . ' ' . _n('Ad', 'Ads', intval($count), 'adforest') . '</p>
                                                    </div>
                                                    <div class="prop-location-details"> <a href="' . adforest_cat_link_page($row['ads_counry'], $country_link_page, 'country_id') . '" class="btn-theme">' . esc_html__('View Details', 'adforest') . '</a> </div>
                                                </div>
                                            </div>';
                    }
                }
            }
            $counter ++;
        }
    }

    return $cats_round_html;
}

function adforest_countries_listings_style2($cats_round_html = '', $rows = array(), $country_link_page = 'javascript:void(0)') {

    if (count($rows) > 0) {
        $counter = 0;
        $col_8_flag = false;
        foreach ($rows as $row) {
            if (isset($row['ads_counry']) && $row['ads_counry'] != "") {
                $bgImageURL = adforest_returnImgSrc($row['country_image']);
                $term = get_term($row['ads_counry'], 'ad_country');
                if ($term) {
                    $count = ($term->count);
                    if ($counter == 0) {
                        $bgImageURL = adforest_returnImgSrc($row['country_image'], 'adforest-location-large');
                        $cats_round_html .= '<div class="col-lg-4 col-xs-12 col-sm-4 col-md-4">
                                    <div class="prop-ad-location-images"> <img src="' . esc_url($bgImageURL) . '" alt="' . esc_html($term->name) . '" class="img-responsive">
                                        <div class="prop-location-city"> <span>' . esc_html($term->name) . '</span>
                                           <p>' . intval($count) . ' ' . _n('Ad', 'Ads', intval($count), 'adforest') . '</p>
                                        </div>
                                        <div class="prop-location-details"> <a href="' . adforest_cat_link_page($row['ads_counry'], $country_link_page, 'country_id') . '" class="btn-theme">' . esc_html__('View Details', 'adforest') . '</a> </div>
                                    </div>
                                </div>';
                    }

                    if ($counter == 1) {
                        $cats_round_html .= '<div class="col-lg-8 col-xs-12 col-sm-8 col-md-8 no-padding">';
                    }

                    if ($counter == 2 || $counter == 3) {
                        $bgImageURL = adforest_returnImgSrc($row['country_image'], 'adforest-location-grid');
                        $cats_round_html .= '<div class="col-lg-6 col-xs-12 col-sm-6 col-md-6">
                                                <div class="prop-ad-location-section"> <img src="' . esc_url($bgImageURL) . '" alt="' . esc_html($term->name) . '" class="img-responsive">
                                                    <div class="prop-location-city"> <span>' . esc_html($term->name) . '</span>
                                                        <p>' . intval($count) . ' ' . _n('Ad', 'Ads', intval($count), 'adforest') . '</p>
                                                    </div>
                                                    <div class="prop-location-details"> <a href="' . adforest_cat_link_page($row['ads_counry'], $country_link_page, 'country_id') . '" class="btn-theme">' . esc_html__('View Details', 'adforest') . '</a> </div>
                                                </div>
                                            </div>';
                    }

                    if ($counter == 1) {
                        $bgImageURL = adforest_returnImgSrc($row['country_image'], 'adforest-location-wide');
                        $cats_round_html .= '<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                                                <div class="ad-location-main-area"> <img src="' . esc_url($bgImageURL) . '" alt="' . esc_html($term->name) . '" class="img-responsive">
                                                    <div class="prop-location-city prop-loc"> <span>' . esc_html($term->name) . '</span>
                                                       <p>' . intval($count) . ' ' . _n('Ad', 'Ads', intval($count), 'adforest') . '</p>
                                                    </div>
                                                    <div class="prop-location-details prop-detail"> <a href="' . adforest_cat_link_page($row['ads_counry'], $country_link_page, 'country_id') . '" class="btn-theme">' . esc_html__('View Details', 'adforest') . '</a> </div>
                                                </div>
                                            </div>';
                    }
                    if ($counter == 3) {
                        $cats_round_html .= '</div>';
                    }

                    if ($counter >= 4) {
                        $bgImageURL = adforest_returnImgSrc($row['country_image'], 'adforest-location-grid');
                        $cats_round_html .= '<div class="col-lg-4 col-xs-12 col-sm-6 col-md-4">
                                                <div class="prop-ad-location-section"> <img src="' . esc_url($bgImageURL) . '" alt="' . esc_html($term->name) . '" class="img-responsive">
                                                    <div class="prop-location-city"> <span>' . esc_html($term->name) . '</span>
                                                        <p>' . intval($count) . ' ' . _n('Ad', 'Ads', intval($count), 'adforest') . '</p>
                                                    </div>
                                                    <div class="prop-location-details"> <a href="' . adforest_cat_link_page($row['ads_counry'], $country_link_page, 'country_id') . '" class="btn-theme">' . esc_html__('View Details', 'adforest') . '</a> </div>
                                                </div>
                                            </div>';
                    }
                }
            }
            $counter ++;
        }
    }

    return $cats_round_html;
}

function adforest_countries_listings_style3($cats_round_html = '', $rows = array(), $country_link_page = 'javascript:void(0)') {

    if (count($rows) > 0) {
        $counter = 0;
        $col_8_flag = false;
        foreach ($rows as $row) {
            if (isset($row['ads_counry']) && $row['ads_counry'] != "") {
                $bgImageURL = adforest_returnImgSrc($row['country_image']);
                $term = get_term($row['ads_counry'], 'ad_country');
                if ($term) {
                    $count = ($term->count);
                    if ($counter == 3) {
                        $bgImageURL = adforest_returnImgSrc($row['country_image'], 'adforest-location-large');
                        $cats_round_html .= '<div class="col-lg-4 col-xs-12 col-sm-4 col-md-4">
                                    <div class="prop-ad-location-images ad-img-cus"> <img src="' . esc_url($bgImageURL) . '" alt="' . esc_html($term->name) . '" class="img-responsive">
                                        <div class="prop-location-city"> <span>' . esc_html($term->name) . '</span>
                                           <p>' . intval($count) . ' ' . _n('Ad', 'Ads', intval($count), 'adforest') . '</p>
                                        </div>
                                        <div class="prop-location-details"> <a href="' . adforest_cat_link_page($row['ads_counry'], $country_link_page, 'country_id') . '" class="btn-theme">' . esc_html__('View Details', 'adforest') . '</a> </div>
                                    </div>
                                </div>';
                    }

                    if ($counter == 0) {
                        $cats_round_html .= '<div class="col-lg-8 col-xs-12 col-sm-8 col-md-8 no-padding">';
                    }

                    if ($counter == 1 || $counter == 2) {
                        $bgImageURL = adforest_returnImgSrc($row['country_image'], 'adforest-location-grid');
                        $cats_round_html .= '<div class="col-lg-6 col-xs-12 col-sm-6 col-md-6">
                                                <div class="prop-ad-location-section"> <img src="' . esc_url($bgImageURL) . '" alt="' . esc_html($term->name) . '" class="img-responsive">
                                                    <div class="prop-location-city"> <span>' . esc_html($term->name) . '</span>
                                                       <p>' . intval($count) . ' ' . _n('Ad', 'Ads', intval($count), 'adforest') . '</p>
                                                    </div>
                                                    <div class="prop-location-details"> <a href="' . adforest_cat_link_page($row['ads_counry'], $country_link_page, 'country_id') . '" class="btn-theme">' . esc_html__('View Details', 'adforest') . '</a> </div>
                                                </div>
                                            </div>';
                    }

                    if ($counter == 0) {
                        $bgImageURL = adforest_returnImgSrc($row['country_image'], 'adforest-location-wide');
                        $cats_round_html .= '<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                                                <div class="ad-location-main-area"> <img src="' . esc_url($bgImageURL) . '" alt="' . esc_html($term->name) . '" class="img-responsive">
                                                    <div class="prop-location-city prop-loc"> <span>' . esc_html($term->name) . '</span>
                                                        <p>' . intval($count) . ' ' . _n('Ad', 'Ads', intval($count), 'adforest') . '</p>
                                                    </div>
                                                    <div class="prop-location-details prop-detail"> <a href="' . adforest_cat_link_page($row['ads_counry'], $country_link_page, 'country_id') . '" class="btn-theme">' . esc_html__('View Details', 'adforest') . '</a> </div>
                                                </div>
                                            </div>';
                    }
                    if ($counter == 2) {
                        $cats_round_html .= '</div>';
                    }

                    if ($counter >= 4) {
                        $bgImageURL = adforest_returnImgSrc($row['country_image'], 'adforest-location-grid');
                        $cats_round_html .= '<div class="col-lg-4 col-xs-12 col-sm-6 col-md-4">
                                                <div class="prop-ad-location-section"> <img src="' . esc_url($bgImageURL) . '" alt="' . esc_html($term->name) . '" class="img-responsive">
                                                    <div class="prop-location-city"> <span>' . esc_html($term->name) . '</span>
                                                        <p>' . intval($count) . ' ' . _n('Ad', 'Ads', intval($count), 'adforest') . '</p>
                                                    </div>
                                                    <div class="prop-location-details"> <a href="' . adforest_cat_link_page($row['ads_counry'], $country_link_page, 'country_id') . '" class="btn-theme">' . esc_html__('View Details', 'adforest') . '</a> </div>
                                                </div>
                                            </div>';
                    }
                }
            }
            $counter ++;
        }
    }

    return $cats_round_html;
}

function adforest_countries_listings_style4($cats_round_html = '', $rows = array(), $country_link_page = 'javascript:void(0)') {

    if (count($rows) > 0) {
        $counter = 0;
        $col_8_flag = false;
        foreach ($rows as $row) {
            if (isset($row['ads_counry']) && $row['ads_counry'] != "") {
                $bgImageURL = adforest_returnImgSrc($row['country_image']);
                $term = get_term($row['ads_counry'], 'ad_country');
                if ($term) {
                    $count = ($term->count);
                    if ($counter == 3) {
                        $bgImageURL = adforest_returnImgSrc($row['country_image'], 'adforest-location-large');
                        $cats_round_html .= '<div class="col-lg-4 col-xs-12 col-sm-4 col-md-4">
                                    <div class="prop-ad-location-images ad-img-cus"> <img src="' . esc_url($bgImageURL) . '" alt="' . esc_html($term->name) . '" class="img-responsive">
                                        <div class="prop-location-city"> <span>' . esc_html($term->name) . '</span>
                                            <p>' . intval($count) . ' ' . _n('Ad', 'Ads', intval($count), 'adforest') . '</p>
                                        </div>
                                        <div class="prop-location-details"> <a href="' . adforest_cat_link_page($row['ads_counry'], $country_link_page, 'country_id') . '" class="btn-theme">' . esc_html__('View Details', 'adforest') . '</a> </div>
                                    </div>
                                </div>';
                    }

                    if ($counter == 0) {
                        $cats_round_html .= '<div class="col-lg-8 col-xs-12 col-sm-8 col-md-8 no-padding">';
                    }

                    if ($counter == 0 || $counter == 1) {
                        $bgImageURL = adforest_returnImgSrc($row['country_image'], 'adforest-location-grid');
                        $cats_round_html .= '<div class="col-lg-6 col-xs-12 col-sm-6 col-md-6">
                                                <div class="prop-ad-location-section"> <img src="' . esc_url($bgImageURL) . '" alt="' . esc_html($term->name) . '" class="img-responsive">
                                                    <div class="prop-location-city"> <span>' . esc_html($term->name) . '</span>
                                                       <p>' . intval($count) . ' ' . _n('Ad', 'Ads', intval($count), 'adforest') . '</p>
                                                    </div>
                                                    <div class="prop-location-details"> <a href="' . adforest_cat_link_page($row['ads_counry'], $country_link_page, 'country_id') . '" class="btn-theme">' . esc_html__('View Details', 'adforest') . '</a> </div>
                                                </div>
                                            </div>';
                    }

                    if ($counter == 2) {
                        $bgImageURL = adforest_returnImgSrc($row['country_image'], 'adforest-location-wide');
                        $cats_round_html .= '<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                                                <div class="ad-location-main-area"> <img src="' . esc_url($bgImageURL) . '" alt="' . esc_html($term->name) . '" class="img-responsive">
                                                    <div class="prop-location-city prop-loc"> <span>' . esc_html($term->name) . '</span>
                                                        <p>' . intval($count) . ' ' . _n('Ad', 'Ads', intval($count), 'adforest') . '</p>
                                                    </div>
                                                    <div class="prop-location-details prop-detail"> <a href="' . adforest_cat_link_page($row['ads_counry'], $country_link_page, 'country_id') . '" class="btn-theme">' . esc_html__('View Details', 'adforest') . '</a> </div>
                                                </div>
                                            </div>';
                    }
                    if ($counter == 2) {
                        $cats_round_html .= '</div>';
                    }

                    if ($counter >= 4) {
                        $bgImageURL = adforest_returnImgSrc($row['country_image'], 'adforest-location-grid');
                        $cats_round_html .= '<div class="col-lg-4 col-xs-12 col-sm-6 col-md-4">
                                                <div class="prop-ad-location-section"> <img src="' . esc_url($bgImageURL) . '" alt="' . esc_html($term->name) . '" class="img-responsive">
                                                    <div class="prop-location-city"> <span>' . esc_html($term->name) . '</span>
                                                        <p>' . intval($count) . ' ' . _n('Ad', 'Ads', intval($count), 'adforest') . '</p>
                                                    </div>
                                                    <div class="prop-location-details"> <a href="' . adforest_cat_link_page($row['ads_counry'], $country_link_page, 'country_id') . '" class="btn-theme">' . esc_html__('View Details', 'adforest') . '</a> </div>
                                                </div>
                                            </div>';
                    }
                }
            }
            $counter ++;
        }
    }

    return $cats_round_html;
}
