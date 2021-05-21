<?php

/* ------------------------------------------------ */
/* browse_categories_with_icons */
/* ------------------------------------------------ */
add_action('vc_before_init', 'adforest_browsecategories_shortcode');
if (!function_exists('adforest_browsecategories_shortcode')) {

    function adforest_browsecategories_shortcode() {
        $cat_array = array();

        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat','no');
        vc_map(array(
            'name' => __('Browse Categories - With Icons', 'adforest'),
            'description' => __('Select categories you want to show in the shortcode.', 'adforest'),
            'base' => 'browse_categories_with_icons',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('animal-cats.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
                    "group" => __("Categories", "adforest"),
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
                            "type" => "attach_image",
                            "holder" => "div",
                            "class" => "",
                            "heading" => __("Category Image", 'adforest'),
                            "param_name" => "cat_img",
                            "description" => __("250X250", 'adforest'),
                        ),
                    )
                ),
            )
        ));
    }

}

if (!function_exists('adforest_browsecategorieswi_shortcode')) {

    function adforest_browsecategorieswi_shortcode($atts, $content = '') {

        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        extract(shortcode_atts(
                        array(
            'section_title' => __('Popular Categories', 'adforest'),
            'cat_link_page' => '',
            'cats' => '',
                        ), $atts));

        $section_title;
        $button_link;
        $ad_categories = $atts['cats'];

        // For custom locations
        $ad_categories_html = '';
        if (isset($atts['cats'])) {
            $rows = vc_param_group_parse_atts($atts['cats']);
            $rows = apply_filters('adforest_validate_term_type',$rows);
            if (count((array) $rows) > 0) {
                foreach ($rows as $row) {
                    if (isset($row['cat'])) {
                        $term = get_term($row['cat'], 'ad_cats');
                        $term_link = adforest_cat_link_page($row['cat'], $cat_link_page);

                        if ($term) {
                            $cat_img_url = ( isset($row['cat_img']) ) ? adforest_returnImgSrc($row['cat_img']) : '';
                            $ad_categories_html .= '<a href="' . esc_url($term_link) . '"> <span class="category_new"><img  alt="' . esc_attr('image', 'adforest') . '" src="' . esc_url($cat_img_url) . '" class="img-responsive"></span> <span class="title">' . esc_html($term->name) . '</span> </a>';
                        }
                    }
                }
            }
        }

        $view_all = '';
        return '<div class="wpb-browse-categories">
	  <section class="section-padding "> 
		<div class="container"> 
		  <div class="row"> 
			<!-- Heading Area -->
			' . $header . '
			<div class="row">
			  <div class="category_gridz text-center">' . $ad_categories_html . '</div>
			</div>
			' . $view_all . '
		  </div>
		</div>
	  </section>
	</div>';
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('browse_categories_with_icons', 'adforest_browsecategorieswi_shortcode');
}