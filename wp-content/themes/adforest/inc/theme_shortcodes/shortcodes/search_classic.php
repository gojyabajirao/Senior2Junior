<?php

/* ------------------------------------------------ */
/* Search Classic */
/* ------------------------------------------------ */
if (!function_exists('search_classic_short')) {

    function search_classic_short() {

        $cat_array = array();

        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat');
        vc_map(array(
            "name" => __("Search - Classic", 'adforest'),
            "base" => "search_classic_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('search-classic.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => __("Background Image", 'adforest'),
                    "param_name" => "bg_img",
                    "description" => __("1280x800", 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Title", 'adforest'),
                    "param_name" => "section_title",
                ),
                apply_filters('adforest_admin_category_load_field', array()),
                array
                    (
                    'group' => __('Categories', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category ( All or Selective )', 'adforest'),
                    'param_name' => 'cats',
                    'dependency' => array(
                        'element' => 'cat_frontend_switch',
                        'value' => array(''),
                    ),
                    'value' => '',
                    'params' => array
                        ($cat_array)
                ),
            // Android
            ),
        ));
    }

}

add_action('vc_before_init', 'search_classic_short');
if (!function_exists('search_classic_short_base_func')) {

    function search_classic_short_base_func($atts, $content = '') {
        extract(shortcode_atts(array(
            'bg_img' => '',
            'section_title' => '',
            'section_tag_line' => '',
            'max_tags_limit' => '',
            'is_display_tags' => '',
            'cats' => '',
                        ), $atts));
        global $adforest_theme;


        $cats = false;
        $cats_html = '';

        $jax_cat_class = '';
        if (isset($atts['cat_frontend_switch']) && $atts['cat_frontend_switch'] == 'ajax_based') {
            $jax_cat_class = 'sb-load-ajax-cats ';
        } else {
            $rows = vc_param_group_parse_atts($atts['cats']);
            $rows = apply_filters('adforest_validate_term_type', $rows);
            if (count($rows) > 0) {
                $cats_html .= '';
                foreach ($rows as $row) {
                    if (isset($row['cat'])) {
                        if ($row['cat'] == 'all') {
                            $cats = true;
                            $cats_html = '';
                            break;
                        }
                        $term = get_term($row['cat'], 'ad_cats');
                        $cats_html .= '<option value="' . $row['cat'] . '">' . $term->name . '</option>';
                    }
                }

                if ($cats) {

                    if (isset($adforest_theme['display_taxonomies']) && $adforest_theme['display_taxonomies'] == 'hierarchical') {
                        $args = array(
                            'type' => 'html',
                            'taxonomy' => 'ad_cats',
                            'tag' => 'option',
                            'parent_id' => 0,
                        );
                        $cats_html = apply_filters('adforest_tax_hierarchy', $cats_html, $args);
                    } else {

                        $args = array('hide_empty' => 0);
                        $args = apply_filters('adforest_wpml_show_all_posts', $args); // for all lang texonomies
                        $ad_cats = get_terms('ad_cats', $args);
                        foreach ($ad_cats as $cat) {
                            $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '</option>';
                        }
                    }
                }
            }
        }






        $style = '';
        if ($bg_img != "") {
            $bgImageURL = adforest_returnImgSrc($bg_img);
            $style = ( $bgImageURL != "" ) ? ' style="background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ') fixed center center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
        }
        ob_start();

        adforest_load_search_countries();

        $contries_script = ob_get_contents();
        ob_end_clean();

        wp_enqueue_script('google-map-callback');
        $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
        return $contries_script . '<div id="banner" ' . $style . '>
         <div class="container">
            <div class="search-container">
               <h2>' . esc_html($section_title) . '</h2>
               <form method="get" action="' . urldecode(get_the_permalink($sb_search_page)) . '">
                  <div class="col-md-4 col-sm-6 col-xs-12 no-padding">
                     <div class="form-group">
                        <input type="text" autocomplete="off" name="ad_title" placeholder="' . __('Search here...', 'adforest') . '" class="form-control banner-icon-search"> 
                     </div>
                  </div>
                  <div class="col-md-3 col-sm-6 col-xs-12 no-padding">
                     <div class="form-group">
                        <input type="text" class="form-control" name="location" id="sb_user_address" placeholder="' . __('Location...', 'adforest') . '">
                     </div>
                  </div>
                  <div class="col-md-3 col-sm-9 col-xs-12 no-padding">
                     <div class="form-group">
                        <select class="' . $jax_cat_class . 'category form-control" name="cat_id">
							<option label="' . __('Select Category', 'adforest') . '" value="">' . __('Select Category', 'adforest') . '</option>
				  		' . $cats_html . '
                        </select>
                     </div>
                  </div>
                  ' . apply_filters('adforest_form_lang_field', false) . '
                  <div class="col-md-2 col-sm-3 col-xs-12 no-padding">
                     <div class="form-group form-action">
                        <button type="submit" class="btn btn-theme btn-search-submit">' . __('Search', 'adforest') . '</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>';
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('search_classic_short_base', 'search_classic_short_base_func');
}