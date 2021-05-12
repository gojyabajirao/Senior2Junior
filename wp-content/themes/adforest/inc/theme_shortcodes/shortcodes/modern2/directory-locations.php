<?php

/* ------------------------------------------------ */
/* Ads */
/* ------------------------------------------------ */
if (!function_exists('adforest_location_data_shortcode')) {

    function adforest_location_data_shortcode($term_type = 'ad_country') {
        $result = array();
        if (!is_admin()) {
            return $result;
        }

        $args = array('hide_empty' => 0);
        $args = apply_filters('adforest_wpml_show_all_posts', $args); // for all lang texonomies
        $terms = get_terms($term_type, $args);
        if (count($terms) > 0) {
            foreach ($terms as $term) {
                $result[] = array
                    (
                    'value' => $term->slug,
                    'label' => $term->name,
                );
            }
        }
        return $result;
    }

}

if (!function_exists('directory_ads_by_countries')) {

    function directory_ads_by_countries() {
        vc_map(array(
            "name" => __("Location - Directory", 'adforest'),
            "base" => "location_directory",
            "category" => __("Theme Shortcodes - 2", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('directory-locations.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Location link Page", 'adforest'),
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
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Top Text", 'adforest'),
                    "param_name" => "sec_top_desc",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("Section Main Heading", "adforest"),
                    "param_name" => "sec_main_heading",
                    "value" => '',
                    "description" => __('For color ', 'adforest') . '<strong>' . esc_html('{color}') . '</strong>' . __('warp text within this tag', 'adforest') . '<strong>' . esc_html('{/color}') . '</strong>',
                    'group' => __('Basic', 'adforest'),
                ),
                array(
                    "type" => "vc_link",
                    "class" => "",
                    "heading" => __("More ads Button", "adforest"),
                    "param_name" => "more_ads",
                    "value" => '',
                    "description" => '',
                    'group' => __('Basic', 'adforest'),
                ),
                array(
                    'group' => esc_html__('Locations', 'adforest'),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Locations', 'adforest'),
                    'param_name' => 'select_locations',
                    'value' => '',
                    'params' => array(
                        array(
                            "type" => "autocomplete",
                            "holder" => "div",
                            "heading" => esc_html__("Location Name", 'adforest'),
                            "param_name" => "name",
                            'settings' => array('values' => adforest_location_data_shortcode()),
                        ),
                        array(
                            "type" => "attach_image",
                            "holder" => "bg_img",
                            "heading" => esc_html__("Location Background Image", 'adforest'),
                            "param_name" => "img",
                            "description" => __("Recommended size 250x160.", 'adforest'),
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'directory_ads_by_countries');

if (!function_exists('location_directory_func')) {

    function location_directory_func($atts, $content = '') {

        extract(shortcode_atts(array(
            'cat_link_page' => '',
            'more_ads' => '',
            'sec_main_heading' => '',
            'sec_top_desc' => '',
            'select_locations' => 'grid_8',
                        ), $atts));

        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";

        $g_cls = 'gradient1';
        if (adforest_detect_ie()) {
            $g_cls = '';
        }

        $marker_div = '<div class="marker-img"><img src="' . trailingslashit(get_template_directory_uri()) . 'images/route.png' . '" alt="' . __(' location', 'adforest') . '"></div>';
        $locations_html = '';
        if (isset($atts['select_locations']) && $atts['select_locations'] != '') {
            $rows = vc_param_group_parse_atts($atts['select_locations']);

            if (count($rows) > 0) {

                foreach ($rows as $r) {
                    if ($r != '') {
                        $img_thumb = '';
                        $img = (isset($r['img'])) ? $r['img'] : '';
                        $id = (isset($r['name'])) ? $r['name'] : '';
                        $img_url = wp_get_attachment_image_src($img, 'adforest-ad-country');
                        $img_thumb = $img_url[0];
                        $term = get_term_by('slug', $id, 'ad_country');
                        if (isset($term->name)) {
                            $id_get = $term->term_id;
                            $slug = $term->slug;
                            $name = $term->name;
                            $count = $term->count;

                            $link = get_term_link($slug, 'ad_country');
                            // If there was an error, continue to the next term.
                            if (is_wp_error($link)) {
                                continue;
                            }
                            $parent = $term->parent;
                            $locations_html .= '<div class="col-xs-12 col-sm-6 col-md-3 margin-bottom-30">
                                                <div class="place-data"> <a href="' . adforest_cat_link_page($id_get, $cat_link_page, 'country_id') . '"><img src="' . esc_url($img_thumb) . '" class="img-responsive" alt="' . esc_html($name) . '"/> </a>
                                                  <div class="place-hading"> <span class="name-h text-capitalize">' . esc_html($name) . '</span>
                                                    <p class="num-ads"><span>' . $count . '</span>' . __(' Ads', 'adforest') . '</p>
                                                  </div>
                                                  <a href="' . adforest_cat_link_page($id_get, $cat_link_page, 'country_id') . '" class="bg-btns"><span class="pl-badge badge"><i class="fa fa-angle-right"></i></span></a> </div>
                                              </div>';
                        }
                    }
                }
            }
        }
        
        $sec_top_desc_html = '';
        if (isset($sec_top_desc) && $sec_top_desc != '') {
            $sec_top_desc_html = '<p class="t-center">'.$sec_top_desc.'</p>';
        }
        
        $sec_main_heading_html = '';
        if(isset($sec_main_heading) && $sec_main_heading != ''){
         $sec_main_heading_html =    adforest_color_text($sec_main_heading);
         
        }
        
        

        return '<div class="adf-sec-six-11">
                    <section class="dream-place-11 custom-padding">
                      <div class="container">
                        <div class="row margin-bottom-30">
                          <div class="col-xs-12 col-sm-8 col-md-8">
                            <div class="hading">
                              '.$sec_top_desc_html.'
                              <span class="t-center d-block">'.$sec_main_heading_html.'</span> </div>
                          </div>
                          <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="hading-btn text-right">
                               ' . adforest_ThemeBtn($more_ads, 'btn btn-lg btn-theme') . '
                            </div>
                          </div>
                        </div>
                        <div class="row">
                            ' . $locations_html . '
                        </div>
                      </div>
                    </section>
                  </div>';
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('location_directory', 'location_directory_func');
}