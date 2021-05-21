<?php

/* ------------------------------------------------ */
/* browse_categories_with_icons2 */
/* ------------------------------------------------ */
add_action('vc_before_init', 'adforest_browsecategories2_shortcode');
if (!function_exists('adforest_browsecategories2_shortcode')) {

    function adforest_browsecategories2_shortcode() {

        $cat_array = array();

        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat','no');


        vc_map(array(
            'name' => __('Browse Categories 2', 'adforest'),
            'description' => __('Select categories with icons and background images.', 'adforest'),
            'base' => 'browse_categories_with_icons2',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('tech-browse-categories.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
                    'type' => 'vc_link',
                    'holder' => 'div',
                    'class' => '',
                    'admin_label' => true,
                    'heading' => __('View All Button', 'adforest'),
                    'param_name' => 'view_all',
                    'value' => 'View All Categories',
                    'description' => __('Select link to show View All Button. Leave empty to hide the button.', 'adforest')
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
                    'edit_field_class' => 'vc_col-sm-6 vc_column',
                    'description' => __('Select link type', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    'type' => 'dropdown',
                    'holder' => 'div',
                    'class' => '',
                    'admin_label' => true,
                    'heading' => __('Text Position', 'adforest'),
                    'param_name' => 'text_pos',
                    'value' => array(__('Select Option', 'adforest') => "", __('Default', 'adforest') => "default", __('Center', 'adforest') => "center"),
                    'description' => __('Select Text position. left or right.', 'adforest'),
                    'edit_field_class' => 'vc_col-sm-6 vc_column',
                ),
                array
                    (
                    'group' => __('Categories', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category ( All or Selective )', 'adforest'),
                    'param_name' => 'cats',
                    'value' => '',
                    'params' => array
                        (
                        $cat_array,
                        array(
                            "type" => "textfield",
                            "holder" => "div",
                            "class" => "",
                            "heading" => __("Category Tag line", 'adforest'),
                            "param_name" => "cat_tagline",
                            "value" => "",
                            'edit_field_class' => 'vc_col-sm-12 vc_column',
                        ),
                        array(
                            'edit_field_class' => 'vc_col-sm-12 vc_column',
                            "type" => "attach_image",
                            "holder" => "div",
                            "class" => "",
                            "heading" => __("Category Image", 'adforest'),
                            "param_name" => "cat_img",
                            "description" => __("150X150", 'adforest'),
                        ),
                        array(
                            'type' => 'iconpicker',
                            'heading' => __('Icon', 'adforest'),
                            'param_name' => 'icon',
                            'settings' => array(
                                'emptyIcon' => false,
                                'type' => 'classified',
                                'iconsPerPage' => 100, // default 100, how many icons per/page to display
                            ),
                        ),
                        array(
                            "group" => __("Basic", "adforest"),
                            "type" => "attach_image",
                            "holder" => "img",
                            "heading" => __("Icon Image", 'adforest'),
                            "param_name" => "icon_img",
                            'description' => __('If you upload the icons images then icons will be overidden. max icon image size (32px X 32px)', 'adforest'),
                        ),
                    )
                ),
            )
        ));
    }

}

if (!function_exists('adforest_browsecategories2_func')) {

    function adforest_browsecategories2_func($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        extract(shortcode_atts(
                        array(
            'section_title' => __('Popular Categories', 'adforest'),
            'cat_link_page' => '',
            'text_pos' => '',
            'view_all' => '',
            'cats' => '',
                        ), $atts));

        // Attributes in var
        global $adforest_theme;

        $section_title;
        $button_link;
        $ad_categories = $atts['cats'];

        $text_pos_class = ( isset($text_pos) && $text_pos == 'center' ) ? 'text-center' : '';
        // For custom locations
        $ad_categories_html = '';
        if (isset($atts['cats'])) {
            $rows = vc_param_group_parse_atts($atts['cats']);
            $rows = apply_filters('adforest_validate_term_type',$rows);
            if (count((array) $rows) > 0) {
                foreach ($rows as $row) {
                    if (isset($row['cat'])) {
                        $term = get_term($row['cat'], 'ad_cats');
                        if ($term) {
                            $term_link = adforest_cat_link_page($row['cat'], $cat_link_page);
                            //$cats_round_html .= '<a href="'. adforest_cat_link_page($row['cat'], $cat_link_page).'">
                            $icon_cat = ( isset($row['cat']) && isset($row['icon']) ) ? $row['icon'] : '';

                            $icon_cat_html = ( $icon_cat != "" ) ? '<div class="tech-basics-icons"> <i class="' . $icon_cat . '"></i> </div>' : '';

                            $icon_img = ( isset($row['icon_img']) && $row['icon_img'] != "" ) ? $row['icon_img'] : '';
                            if ($icon_img != "") {
                                $imgURL = adforest_returnImgSrc($row['icon_img']);
                                if ($imgURL != "") {
                                    $icon_cat_html = '<img src="' . esc_url($imgURL) . '" alt="' . __("icon", "adforest") . '" class="img-responsive">';
                                }
                            }

                            $cat_img_url = ( isset($row['cat_img']) ) ? adforest_returnImgSrc($row['cat_img']) : '';
                            $cat_tagline_html = ( isset($row['cat_tagline']) && $row['cat_tagline'] != "" ) ? "<p>" . $row['cat_tagline'] . "</p>" : '';
                            $ad_categories_html .= '<div class="col-lg-3 col-sm-4 col-md-3 col-xs-12">
						  <a href="' . $term_link . '">
						  <div class="tech-latest-categories ' . esc_attr($text_pos_class) . '">
						  <img src="' . esc_url($cat_img_url) . '" alt="' . esc_attr($term->name) . '" class="img-responsive">
							<div class="tech-categories-bg"> </div>
							<div class="tech-st-text-section">
							  ' . $icon_cat_html . '
							  <div class="tech-brand-section">
								<h5>' . esc_html($term->name) . '</h5>
								' . $cat_tagline_html . '
							  </div>
							</div>
						  </div>
						  </a>
						</div>';
                        }
                    }
                }
            }
        }
        // Output Code
        $btn_1 = adforest_ThemeBtn($view_all, 'btn btn-theme', false);
        $btn_html = '';
        if ($btn_1 != "") {
            $btn_html = '<div class="our-product-categories">' . $btn_1 . '</div>';
        }
        return '<section class="tech-new-explore-categories">
		  <div class="container">
			<div class="row clear-custom">
			  <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">' . $header . ' </div>
			  <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">' . $ad_categories_html . '</div>
			  ' . $btn_html . '
		  </div>
		</section>';
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('browse_categories_with_icons2', 'adforest_browsecategories2_func');
}