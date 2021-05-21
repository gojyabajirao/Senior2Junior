<?php

/* ------------------------------------------------ */
/* Cats 1 */
/* ------------------------------------------------ */
if (!function_exists('cats_1_short')) {

    function cats_1_short() {

        $cat_array = array();

        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat','no');

        vc_map(array(
            "name" => __("Categories - 1", 'adforest'),
            "base" => "cats_1_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('cat1.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "attach_image",
                    "holder" => "img",
                    "heading" => __("SectionImage Image", 'adforest'),
                    "param_name" => "section_bg",
                    "description" => __("1920x474", 'adforest'),
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
                    "heading" => __("Background Color", 'adforest'),
                    "param_name" => "bg_color",
                    "admin_label" => true,
                    "value" => array(
                        __('Select Background Color', 'adforest') => '',
                        __('White', 'adforest') => '',
                        __('Gray', 'adforest') => 'gray',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                    "description" => __("Select background color.", 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "attach_image",
                    "holder" => "img",
                    "heading" => __("Background Image", 'adforest'),
                    "param_name" => "bg_img",
                    'dependency' => array(
                        'element' => 'section_bg',
                        'value' => array('img'),
                    ),
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
                            'type' => 'iconpicker',
                            'heading' => __('Icon', 'adforest'),
                            'param_name' => 'icon',
                            'settings' => array(
                                'emptyIcon' => false,
                                'type' => 'classified',
                                'iconsPerPage' => 100, // default 100, how many icons per/page to display
                            ),
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'cats_1_short');
if (!function_exists('cats_1_short_base_func')) {

    function cats_1_short_base_func($atts, $content = '') {
        extract(shortcode_atts(array(
            'section_bg' => '',
            'section_title' => '',
            'cat_link_page' => '',
            'bg_color' => '',
                        ), $atts));

        global $adforest_theme;
        $categories_html = '';
        if (isset($atts['cats'])) {
            $rows = vc_param_group_parse_atts($atts['cats']);
            $rows = apply_filters('adforest_validate_term_type',$rows);
            if (count($rows) > 0) {
                foreach ($rows as $row) {
                    if (isset($row['cat']) && isset($row['icon'])) {
                        $category = get_term($row['cat']);
                        if (count((array) $category) == 0)
                            continue;
                        $count = $category->count;
                        
                        $categories_html .= '<li><a href="' . adforest_cat_link_page($row['cat'], $cat_link_page) . '">
									<div class="new-main-section">
									  <div class="flat-icons"> <i class="' . $row['icon'] . '"></i> </div>
									  <div class="icons-text">
										<h2>' . $category->name . '</h2>
									  </div>
									</div>
									</a> </li>';
                    }
                }
            }
        }

        $bgImageURL = adforest_returnImgSrc($section_bg);
        $style = ( $bgImageURL != "" ) ? ' style="background: url(' . $bgImageURL . ');height: 370px;background-position: center;position: relative;"' : "";

        return '<section class="browse-categories" ' . $style . '>
  <div class="container">
    <div class="row">
      <div class="browse-categories-h3"> <h3>' . adforest_color_text($section_title) . '</h3> </div>
    </div>
  </div>
  <div class="clouds">
    <div class="clouds-images">
	<img src="' . trailingslashit(get_template_directory_uri()) . 'images/style-6.png" alt="' . __('image', 'adforest') . '" class="img-responsive">
	</div>
  </div>
</section>
<section class="new-boxes-section ' . $bg_color . '">
  <div class="container">
    <div class="row">
    <div class="col-lg-12 col-xs-12 col-md-12 col-sm-12">
      <div class="boxes-h1"> <ul> ' . $categories_html . ' </ul> </div>
      </div>
    </div>
  </div>
</section>
';

        return '<section class="section-padding categories ' . $bg_color . '" ' . $style . '>
            <div class="container">
               <div class="row">
			   		' . $header . '
			   <div class="col-md-12 category-blocks">
			   		<ul class="popular-categories"> ' . $categories_html . ' </ul>
				</div>
			   </div>
            </div>
         </section>';
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('cats_1_short_base', 'cats_1_short_base_func');
}