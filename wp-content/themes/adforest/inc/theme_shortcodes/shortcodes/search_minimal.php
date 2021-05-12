<?php

/* ------------------------------------------------ */
/* Search Minimal */
/* ------------------------------------------------ */
if (!function_exists('search_minimal_short')) {

    function search_minimal_short() {

        $cat_array = array();

        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat');

        vc_map(array(
            "name" => __("Search - Minimal", 'adforest'),
            "base" => "search_minimal_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('search-minimal.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
            ),
        ));
    }

}

add_action('vc_before_init', 'search_minimal_short');
if (!function_exists('search_minimal_short_base_func')) {

    function search_minimal_short_base_func($atts, $content = '') {
        extract(shortcode_atts(array(
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



//adforest_load_search_countries();
//wp_enqueue_script( 'google-map-callback');
        $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
        return '<div id="search-section">
         <div class="container">
            <div class="row">
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
				  <form method="get" action="' . urldecode(get_the_permalink($sb_search_page)) . '" class="search-form">
                     <div class="col-md-3 col-xs-12 col-sm-4 no-padding">
                        <select class="' . $jax_cat_class . 'category form-control" name="cat_id">
							<option label="' . __('Select Category', 'adforest') . '" value="">' . __('Select Category', 'adforest') . '</option>
				  		' . $cats_html . '
                        </select>
                     </div>
                     <!-- Search Field -->
                     <div class="col-md-6 col-xs-12 col-sm-4 no-padding">
                        <input type="text" autocomplete="off" name="ad_title" class="form-control" placeholder="' . __('What Are You Looking For...', 'adforest') . '" />
                     </div>
                     ' . apply_filters('adforest_form_lang_field', false) . '
                     <div class="col-md-3 col-xs-12 col-sm-4 no-padding">
                        <button type="submit" class="btn btn-block btn-light">' . __('Search', 'adforest') . '</button>
                     </div>
                  </form>
                  </div>
               </div>
         </div>
      </div>';
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('search_minimal_short_base', 'search_minimal_short_base_func');
}