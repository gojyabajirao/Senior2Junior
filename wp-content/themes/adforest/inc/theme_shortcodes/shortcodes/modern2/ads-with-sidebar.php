<?php

/* ------------------------------------------------ */
/* Ads With SIdebar Menu */
/* ------------------------------------------------ */
if (!function_exists('adforest_adswithsidebaraja_integrateWithVC')) {

    function adforest_adswithsidebaraja_integrateWithVC() {
        $grid_array;
        if (Redux::getOption('adforest_theme', 'design_type') == 'modern') {
            $grid_array = array(
                __('Select Layout Type', 'adforest') => '',
                __('Grid 1', 'adforest') => 'grid_1',
                __('Grid 2', 'adforest') => 'grid_2',
                __('Grid 3', 'adforest') => 'grid_3',
                __('Grid 4', 'adforest') => 'grid_4',
                __('Grid 5', 'adforest') => 'grid_5',
                __('Grid 6', 'adforest') => 'grid_6',
                __('Grid 7', 'adforest') => 'grid_7',
                __('Grid 8', 'adforest') => 'grid_8',
                __('Grid 9', 'adforest') => 'grid_9',
                __('Grid 10', 'adforest') => 'grid_10',
            );
        } else {
            $grid_array = array(
                __('Select Layout Type', 'adforest') => '',
                __('Grid 1', 'adforest') => 'grid_1',
                __('Grid 2', 'adforest') => 'grid_2',
                __('Grid 3', 'adforest') => 'grid_3',
            );
        }
        $cat_array = array();

        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat','no');

        vc_map(array(
            'name' => __('Ads With Sidebar - Ajax Based', 'adforest'),
            'description' => __('Ajax Based', 'adforest'),
            'base' => 'ads_with_sidebar_ajax',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('tech-ads-with-cats.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Main Section", "adforest"),
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'admin_label' => true,
                    'heading' => __('Section Title', 'adforest'),
                    'param_name' => 'section_title',
                    "description" => __('For color ', 'adforest') . '<strong>' . esc_html('{color}') . '</strong>' . __('warp text within this tag', 'adforest') . '<strong>' . esc_html('{/color}') . '</strong>',
                ),
                array(
                    "group" => __("Main Section", "adforest"),
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
                    'edit_field_class' => 'vc_col-sm-6 vc_column',
                ),
                array(
                    "group" => __("Main Section", "adforest"),
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
                    'edit_field_class' => 'vc_col-sm-6 vc_column',
                ),
                array(
                    "group" => __("Main Section", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Layout Type", 'adforest'),
                    "param_name" => "layout_type",
                    "admin_label" => true,
                    "value" => $grid_array,
                    'edit_field_class' => 'vc_col-sm-6 vc_column',
                ),
                array(
                    "group" => __("Main Section", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Number fo Ads", 'adforest'),
                    "param_name" => "no_of_ads",
                    "admin_label" => true,
                    "value" => range(1, 500),
                    'edit_field_class' => 'vc_col-sm-6 vc_column',
                ),
                array(
                    "group" => __("Main Section", "adforest"),
                    'type' => 'dropdown',
                    'holder' => 'div',
                    'class' => '',
                    'admin_label' => true,
                    'heading' => __('Sider Position', 'adforest'),
                    'param_name' => 'sidebar_pos',
                    'value' => array(__('Select Option', 'adforest') => "", __('Left', 'adforest') => "left", __('Right', 'adforest') => "right"),
                    'description' => __('Select siderbar position. left or right.', 'adforest'),
                    'edit_field_class' => 'vc_col-sm-6 vc_column',
                ),
                array(
                    "group" => __("Main Section", "adforest"),
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'admin_label' => true,
                    'heading' => __('View All Button Text', 'adforest'),
                    'param_name' => 'view_all',
                    'description' => __('Leave empty if you want to hide the view all button.', 'adforest'),
                    'edit_field_class' => 'vc_col-sm-6 vc_column',
                ),
                array(
                    "group" => __("Main Section", "adforest"),
                    'type' => 'textarea_raw_html',
                    'holder' => 'div',
                    'class' => '',
                    'admin_label' => true,
                    'heading' => __('Banner Top', 'adforest'),
                    'description' => __('Write your html or simple code here', 'adforest'),
                    'param_name' => 'banner_top',
                ),
                array(
                    "group" => __("Main Section", "adforest"),
                    'type' => 'textarea_raw_html',
                    'holder' => 'div',
                    'class' => '',
                    'admin_label' => true,
                    'heading' => __('Banner Bottom', 'adforest'),
                    'param_name' => 'banner_bottom',
                    'description' => __('Write your html or simple code here', 'adforest'),
                ),
                /* Sidebar section */
                array(
                    "group" => __("Sidebar", "adforest"),
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'admin_label' => true,
                    'heading' => __('Sidebar Title', 'adforest'),
                    'param_name' => 'sidebar_title',
                ),
                array(
                    "group" => __("Sidebar", "adforest"),
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
                /* Cats loop starts */
                array
                    (
                    'group' => __('Sidebar', 'adforest'),
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
                /* Cats loop ends */
                /* links loop starts */
                array
                    (
                    'group' => __('Sidebar (Links)', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Links', 'adforest'),
                    'param_name' => 'cats_links',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            'type' => 'vc_link',
                            'holder' => 'div',
                            'class' => '',
                            'admin_label' => true,
                            'heading' => __('Buttons', 'adforest'),
                            'param_name' => 'btn_1',
                        ),
                    )
                ),
                /* links loop ends */
                /* Featured Slider starts */
                array(
                    'group' => __('Sidebar Widgets', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'featured_slider',
                    'description' => esc_html__('Please go to Widgets and add slider in TechForest Ajax Section - Siderbar', 'adforest')
                ),
            /* Featured Slider Ends */
            )
        ));
    }

}
add_action('vc_before_init', 'adforest_adswithsidebaraja_integrateWithVC');

if (!function_exists('adforest_adswithsidebaraja_shortcode')) {

    function adforest_adswithsidebaraja_shortcode($atts) {
        // Attributes
        extract(shortcode_atts(array('section_title' => '', 'sidebar_title' => '', 'cat_link_page' => '', 'btn_1' => '', 'cats' => '', 'ad_type' => 'both', 'ad_order' => 'desc', 'layout_type' => 'grid_7', 'no_of_ads' => '10', 'banner_top' => '', 'banner_bottom' => '', 'view_all' => '', 'sidebar_pos' => '', 'featured_slider' => ''), $atts, 'ads_with_sidebar_ajax'));
        // Attributes in var
        $layout_type = ( $layout_type != "" ) ? $layout_type : 'grid_7';
        $show_subcats = false;
        $btn_1 = adforest_ThemeBtn($btn_1, 'btn btn-theme', false);
        /* Siderbar settings starts */
        $cats = array();
        $categories_html = '';
        $random_number = rand(11111, 999999999);

        $hidden_inputs = wp_nonce_field('ads_with_sidebar_ajax', 'ads_with_sidebar_ajax_' . $random_number);
        $inputs = array('no_of_ads' => $no_of_ads, 'layout_type' => $layout_type, 'ad_order' => $ad_order, 'ad_type' => $ad_type, 'cat_link_page' => $cat_link_page, 'view_all' => $view_all);
        foreach ($inputs as $key => $val) {
            $unique_name = $key . '_' . $random_number;
            $hidden_inputs .= '<input type="hidden" id="' . $unique_name . '" value="' . $val . '" />';
        }
        if (isset($atts['cats'])) {
            $rows = vc_param_group_parse_atts($atts['cats']);
            $rows = apply_filters('adforest_validate_term_type',$rows);
            if (count($rows) > 0) {
                foreach ($rows as $row) {
                    if (isset($row['cat'])) {
                        $cats[] = $row['cat'];
                        $term = get_term($row['cat'], 'ad_cats');
                        //$count_cats = $term->count;
                        if (count((array) $term) == 0)
                            continue;
                        $icon_html = '';

                        $final_icon_html = (isset($row['icon']) && $row['icon'] != "") ? '<i class="icon fa ' . esc_attr($row['icon']) . '" aria-hidden="true"></i>' : '';

                        $icon_img = ( isset($row['icon_img']) && $row['icon_img'] != "" ) ? $row['icon_img'] : '';

                        if ($icon_img != "") {
                            $imgURL = adforest_returnImgSrc($row['icon_img']);
                            if ($imgURL != "") {
                                $final_icon_html = '<img src="' . esc_url($imgURL) . '" alt="' . __("icon", "adforest") . '" class="img-responsive">';
                            }
                        }


                        $sub_menu_html = adforest_ads_with_sidebar_has_child($term->term_id, 'ad_cats', $show_subcats, $cat_link_page, $random_number);
                        $categories_html .= '<li class="dropdown menu-item"> <a href="#" data-toggle="dropdown"  data-sidebar-term-id="' . $term->term_id . '" class="ajax-anchor dropdown-toggle" data-unique-id="' . $random_number . '">' . $final_icon_html . $term->name . '</a>' . $sub_menu_html . '</li>';
                    }
                }
            }
        }
        $ad_single = '';
        if (count($cats) > 0) {
            $ad_single = adforest_get_ads_with_sidebar_section('site', $cats, $ad_type, $ad_order, $layout_type, $no_of_ads, $cat_link_page, $view_all);
        }

        $cats_links = '';
        if (isset($atts['cats_links'])) {
            $links = vc_param_group_parse_atts($atts['cats_links']);
            if (count($links) > 0) {
                $counter_links = 0;
                foreach ($links as $link) {
                    if ($counter_links % 2) {
                        $bgclass = 'bg-white';
                    } else {
                        $bgclass = '';
                    }

                    $btn_1 = isset($link['btn_1']) && !empty($link['btn_1']) ? $link['btn_1'] : '';

                    $cats_links .= '<div class="other-categories ' . $bgclass . '">' . adforest_ThemeBtn($btn_1, '', false, '<h2>', '</h2>') . '</div>';
                    $counter_links++;
                }
            }
        }
        /* Sidebar settings ends */
        // Output Code
        $section_title_html = '';
        if ($section_title != "") {
            $section_title_html = '<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12"><div class="tech-latest-primary-section"><h3>' . adforest_color_text_custom_html($section_title, '<span class="explore-style">', '</span>') . '</h3></div></div>	
';
        }

        $sidebar_pos_css = ( $sidebar_pos == 'right' ) ? 'pull-right' : 'pull-left';
        $banner_top_html = '';
        if ($banner_top != "") {
            $banner_top_html = '<div class="tech-new-banner"> ' . urldecode(adforest_decode($banner_top)) . '  </div><br />';
        }
        $banner_bottom_html = '';
        if ($banner_bottom != "") {
            $banner_bottom_html = '<div class="tech-new-banner">' . urldecode(adforest_decode($banner_bottom)) . '  </div>';
        }

        $slider_HTML = '';

        ob_start();
        dynamic_sidebar('adforest_tech_ajax_section');
        $slider_HTML = ob_get_contents();
        ob_end_clean();

        $output = '<section class="tech-new-great-product">
	  <div class="container">
		<div class="row">
		<div class="sb_loading"></div>
		' . $section_title_html . '
		<div class="col-md-4 col-lg-3 col-xs-12 col-sm-12 sidebar ' . $sidebar_pos_css . '">
			<div class="new-side-menu">
			  <div class="new-all-categories">
				<div class="icons-categorie"> <i class="fa fa-bars"></i> </div>
				<div class="tech-categories">
				  <div class="categories-text-section">
					<h2>' . esc_html($sidebar_title) . '</h2>
				  </div>
				</div>
			  </div>
			  <div class="side-menu">
				<nav class="yamm megamenu-horizontal"><ul class="nav ads-with-sidebar-section">' . $categories_html . ' </ul></nav>
				' . $cats_links . '
			  </div>
			  ' . $slider_HTML . '
			</div>
		  </div>
		  <div class="col-lg-9 col-xs-12 col-sm-12 col-md-8">
			<div class="row">
			' . $banner_top_html . '
			<div class="ads-sidebar-loader"><div class="loader_ajax_small"></div></div>
			<div id="ads-with-sidebar-section-' . $random_number . '" class="ads-with-sidebar-sections">
			' . $ad_single . ' ' . $banner_bottom_html . ' ' . $hidden_inputs . '
		  </div>
		</div>
	  </div>
	</section>';

        return $output;
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('ads_with_sidebar_ajax', 'adforest_adswithsidebaraja_shortcode');
}

if (!function_exists('adforest_ads_with_sidebar_has_child')) {

    function adforest_ads_with_sidebar_has_child($cat_id = 0, $tax_name = 'ad_cats', $has_child = false, $cat_link_page = '', $random_number = '') {
        if ($has_child == false) {
            return '';
        }
        $sub_cat_html = $html = '';
        $ad_sub_cats = adforest_get_cats($tax_name, $cat_id);
        $i = 1;
        if (isset($ad_sub_cats) && count($ad_sub_cats) > 0) {
            foreach ($ad_sub_cats as $sub_cat) {
                $adforest_cat_link_page = adforest_cat_link_page($sub_cat->term_id, $cat_link_page);
                $adforest_cat_link_page = 'javascript:void(0);';
                $count = ($sub_cat->count);
                $sub_cat_html .= '<li><a href="' . $adforest_cat_link_page . '" data-sidebar-term-id="' . $sub_cat->term_id . '" class="ajax-anchor"  data-unique-id="' . $random_number . '">' . $sub_cat->name . '<span> (' . $count . ')</span></a></li>';
            }
            $html .= '<ul class="dropdown-menu mega-menu-left"><li class="yamm-content"><div class="row"><div class="col-sm-3 col-xs-6 col-md-3"> <ul class="links list-unstyled"> ' . $sub_cat_html . ' </ul></div> </div></li></ul>';
        }
        return $html;
    }

}
// Ajax handler for add to cart
add_action('wp_ajax_get_ads_with_sidebar_section', 'adforest_get_ads_with_sidebar_section');
add_action('wp_ajax_nopriv_get_ads_with_sidebar_section', 'adforest_get_ads_with_sidebar_section');
// Addind Subcriber into Mailchimp
if (!function_exists('adforest_get_ads_with_sidebar_section')) {

    function adforest_get_ads_with_sidebar_section($request_from = '', $cats = array(), $ad_type = '', $ad_order = 'desc', $layout_type = '', $no_of_ads = 10, $cat_link_page = '', $view_all = '') {

        global $adforest_theme;


        if ($request_from == '') {
            $cats = array(sanitize_text_field($_POST['cat_id']));
            $ad_type = 'both';
            $ad_order == 'desc';
            $layout_type = 'grid_5';
            $unique_id = sanitize_text_field($_POST['unique_id']);

            $no_of_ads = sanitize_text_field($_POST['no_of_ads']);
            $layout_type = sanitize_text_field($_POST['layout_type']);
            $ad_order = sanitize_text_field($_POST['ad_order']);
            $ad_type = sanitize_text_field($_POST['ad_type']);
            $cat_link_page = sanitize_text_field($_POST['cat_link_page']);
            $view_all = sanitize_text_field($_POST['view_all']);
        }

        $category = array();
        $first_term = '';
        if (count($cats) > 0) {
            $first_term = $cats[0];
            $category = array('taxonomy' => 'ad_cats', 'field' => 'term_id', 'terms' => $first_term,);
        }

        $is_feature = array();
        if ($ad_type == 'feature') {
            $is_feature = array('key' => '_adforest_is_feature', 'value' => 1, 'compare' => '=',);
        } else if ($ad_type == 'both') {
            $is_feature = array();
        } else {
            $is_feature = array('key' => '_adforest_is_feature', 'value' => 0, 'compare' => '=',);
        }

        $is_active = array('key' => '_adforest_ad_status_', 'value' => 'active', 'compare' => '=',);

        $ordering = 'DESC';
        $order_by = 'date';
        if ($ad_order == 'asc') {
            $ordering = 'ASC';
        } else if ($ad_order == 'desc') {
            $ordering = 'DESC';
        } else if ($ad_order == 'rand') {
            $order_by = 'rand';
        }
        $countries_location = '';
        $countries_location = apply_filters('adforest_site_location_ads', $countries_location, 'search');
        $args = array(
            'post_type' => 'ad_post',
            'post_status' => 'publish',
            'posts_per_page' => $no_of_ads,
            'meta_query' => array(
                $is_feature,
                $is_active,
            ),
            'tax_query' => array($category, $countries_location),
            'orderby' => $order_by,
            'order' => $ordering,
        );

        $ads_html = '';
        $ads = new ads();
        $args = apply_filters('adforest_wpml_show_all_posts', $args);
        $results = new WP_Query($args);
        if ($results->have_posts()) {
            while ($results->have_posts()) {
                $results->the_post();
                $ads_html .= ' ';
                $function = "adforest_search_layout_$layout_type";
                $ads_html .= $ads->$function(get_the_ID(), 4, 4, '');
                $ads_html .= ' ';
            }

            if ($view_all != "") {
                $term_link = adforest_cat_link_page($first_term, $cat_link_page);
                $ads_html .= '		<div class="clearfix"></div>
				<div class="our-product-categories"><a href="' . $term_link . '" class="btn btn-theme">' . $view_all . '</a></div>';
            }

            $ads_html .= '</div></div>';
        } else {
            echo '<div class="item padding-left-20"><h2>' . __("No Ad Found.", "adforest") . '</h2><div>';
        }
        wp_reset_postdata();
        if ($request_from == '') {
            echo adforest_returnEcho($ads_html);
        } else if ($request_from == 'site') {
            return $ads_html;
        }
        wp_die();
    }

}