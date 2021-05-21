<?php

/* ------------------------------------------------ */
/* Categories - Srevices */
/* ------------------------------------------------ */
if (!function_exists('adforest_cats_sports_short')) {

    function adforest_cats_sports_short() {

        $cat_array = array();

        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat','no');

        vc_map(array(
            "name" => __("Categories - Sports", 'adforest'),
            "base" => "adforest_cats_sports_short_base",
            "category" => __("Theme Shortcodes - 2", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('categories-sports.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Category link Page", 'adforest'),
                    "param_name" => "cat_link_page",
                    "admin_label" => true,
                    "value" => array(
                        __('Search Page', 'adforest') => 'search',
                        __('Category Page', 'adforest') => 'category',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
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
                    "group" => __("Layout", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Column Style", 'adforest'),
                    "param_name" => "column_style",
                    "admin_label" => true,
                    "value" => array(
                        __('4 Column', 'adforest') => '3',
                        __('6 Column', 'adforest') => '2'
                    ),
                    "description" => __("Chose Categories style.", 'adforest'),
                ),
                array
                    (
                    'group' => __('Categories', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category', 'adforest'),
                    'param_name' => 'cats',
                    'value' => '',
                    'params' => array
                        (
                        $cat_array,
                        array(
                            "group" => __("Basic", "adforest"),
                            "type" => "attach_image",
                            "holder" => "img",
                            "heading" => __("Category Image : Recommended size (45 X 45)", 'adforest'),
                            "param_name" => "img",
                            "description" => __('45 X 45', 'adforest'),
                        ),
                    )
                ),
            ),
        ));
    }

}
add_action('vc_before_init', 'adforest_cats_sports_short');
if (!function_exists('adforest_cats_sports_short_base_func')) {

    function adforest_cats_sports_short_base_func($atts, $content = '') {
        global $adforest_theme;
        $bg_bootom = 'yes';
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        $categories_html = '';

        extract(shortcode_atts(
                        array(
            'column_style' => '3',
            'cats' => '',
                        ), $atts));

        if (empty($atts['column_style'])) {
            
        }

        if (isset($atts['cats'])) {
            $rows = vc_param_group_parse_atts($atts['cats']);
            $rows = apply_filters('adforest_validate_term_type',$rows);
            if (count($rows) > 0) {
                foreach ($rows as $row) {
                    if (isset($row['cat']) && isset($row['img'])) {
                        $category = get_term($row['cat']);
                        if (count((array) $category) == 0)
                            continue;
                        $count = $category->count;
                        
                        $bgImageURL = adforest_returnImgSrc($row['img']);
                        $categories_html .= '<div class="col-lg-' . intval($column_style) . ' col-sm-3 col-md-' . intval($column_style) . ' co-xs-12"> 
                            <div class="srvs-explore-box sprt-explore-box">
                                <a href="' . adforest_cat_link_page($row['cat'], $cat_link_page) . '">
                                    <div class="srvs-explore-img"> <img src="' . esc_url($bgImageURL) . '" alt="' . $category->name . '" class="img-responsive"> </div>
                                    <div class="srvs-explore-details">
                                        <h4>' . esc_html($category->name) . '</h4>
                                    </div>
                                </a>
                                <div class="sprt-ex-ads"><a href="javascript:void(0)" class="btn-theme">' . absint($count) . ' ' . __('Ads', 'adforest') . '</a>
                                </div>
                            </div>
                        </div>';
                    }
                }
            }
        }

        $html = '';
        $html .= '<div class="sprt-explore-section">
                    <section class="srvs-explore-section no-extra">
                        <div class="container">
                            <div class="row">
                                ' . ($header) . '
                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">
                                 ' . ($categories_html) . '
                                </div>
                            </div>
                        </div>
                    </section>
                </div>';
        return $html;
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('adforest_cats_sports_short_base', 'adforest_cats_sports_short_base_func');
}