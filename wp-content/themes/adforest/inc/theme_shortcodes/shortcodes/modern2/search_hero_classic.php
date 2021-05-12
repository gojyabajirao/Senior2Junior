<?php

/* ------------------------------------------------ */
/* search_hero_classic */
/* ------------------------------------------------ */
if (!function_exists('search_hero_classic_short')) {

    function search_hero_classic_short() {


        $cat_array = array();

        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat');

        vc_map(array(
            "name" => __("Search - Hero Classic", 'adforest'),
            "base" => "search_hero_classic_short_base",
            "category" => __("Theme Shortcodes - 2", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('animal-main.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Form Heading Text", 'adforest'),
                    "param_name" => "block_text",
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
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => __("Side Image", 'adforest'),
                    "param_name" => "side_img",
                    "description" => __("1280x800", 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    'type' => 'dropdown',
                    'holder' => 'div',
                    'class' => '',
                    'admin_label' => true,
                    'heading' => __('Image Position', 'adforest'),
                    'param_name' => 'image_pos',
                    'value' => array(__('Select Option', 'adforest') => "", __('Left', 'adforest') => "left", __('Right', 'adforest') => "right"),
                ),
                array(
                    "group" => __("Location type", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Location type", 'adforest'),
                    "param_name" => "location_type",
                    "admin_label" => true,
                    "value" => array(
                        __('Google', 'adforest') => 'g_locations',
                        __('Custom Location', 'adforest') => 'custom_locations',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                apply_filters('adforest_admin_category_load_field', array()),
                array
                    (
                    'group' => __('Categories', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category ( All or Selective )', 'adforest'),
                    'param_name' => 'cats',
                    'value' => '',
                    'dependency' => array(
                        'element' => 'cat_frontend_switch',
                        'value' => array(''),
                    ),
                    'params' => array
                        ($cat_array)
                ),
                array
                    (
                    'group' => __('Custom Loctions', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Location', 'adforest'),
                    'param_name' => 'locations',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => __("Location", 'adforest'),
                            "param_name" => "location",
                            "admin_label" => true,
                            "value" => adforest_cats('ad_country', 'yes'),
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'search_hero_classic_short');
if (!function_exists('search_hero_classic_short_base_func')) {

    function search_hero_classic_short_base_func($atts, $content = '') {
        extract(shortcode_atts(array(
            'bg_img' => '',
            'side_img' => '',
            'section_title' => '',
            'sub_title' => '',
            'section_description' => '',
            'btn_text' => '',
            'block_text' => '',
            'location_type' => '',
            'cats' => '',
            'locations' => '',
            'image_pos' => '',
                        ), $atts));
        global $adforest_theme;


        $cats = false;
        $cats_html = '';

        $jax_cat_class = '';
        if (isset($atts['cat_frontend_switch']) && $atts['cat_frontend_switch'] == 'ajax_based') {
            $jax_cat_class = 'sb-load-ajax-cats ';
        } else {

            $rows = vc_param_group_parse_atts(isset($atts['cats']) && $atts['cats'] != '' ? $atts['cats'] : '');
            $rows = apply_filters('adforest_validate_term_type', $rows);

            if (count($rows) > 0) {

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
                $args = array('hide_empty' => 0);
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
                        $args = apply_filters('adforest_wpml_show_all_posts', $args); // for all lang texonomies
                        $ad_cats = get_terms('ad_cats', $args);
                        foreach ($ad_cats as $cat) {
                            $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '</option>';
                        }
                    }
                }
            }
        }




        // For custom locations
        $locations_html = '';
        
        $rows = vc_param_group_parse_atts(isset($atts['locations']) && $atts['locations'] != '' ? $atts['locations'] : '');
        if (isset($rows[0]['location']) && $rows[0]['location'] == 'all' && $location_type == 'custom_locations') {
            $locations_html .= ' <option value="">' . esc_html__('Select location', 'adforest') . ' </option> ';

            if (isset($adforest_theme['display_taxonomies']) && $adforest_theme['display_taxonomies'] == 'hierarchical') {
                $args = array(
                    'type' => 'html',
                    'taxonomy' => 'ad_country',
                    'tag' => 'option',
                    'parent_id' => 0,
                );
                $locations_html = apply_filters('adforest_tax_hierarchy', $locations_html, $args);
            } else {
                $ad_country_arr = get_terms('ad_country', $args);
                if (isset($ad_country_arr) && count($ad_country_arr) > 0) {
                    foreach ($ad_country_arr as $loc_value) {
                        $locations_html .= ' <option value="' . intval($loc_value->term_id) . '">' . esc_html($loc_value->name) . ' </option> ';
                    }
                }
            }
        } else {
            if (count((array) $rows) > 0) {
                $locations_html .= '';
                foreach ($rows as $row) {
                    if (isset($row['location'])) {
                        $lc_id = isset($row['location']) && !empty($row['location']) ? $row['location'] : 0;
                        if ($lc_id != 0) {
                            $term = get_term($lc_id, 'ad_country');
                            $locations_html .= ' <option value="' . $lc_id . '">' . $term->name . '</option> ';
                        }
                    }
                }
            }
        }

        $style = '';
        $side_img_url = '';
        if ($side_img != "") {
            $side_img_url = adforest_returnImgSrc($side_img);
        }

        if ($bg_img != "") {
            $bgImageURL = adforest_returnImgSrc($bg_img);
            $style = ( $bgImageURL != "" ) ? ' style="background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ') center top no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
        }
        $location_type_html = '';
        $contries_script = '';
        if ($location_type == 'custom_locations') {
            $location_type_html = '<select class="category form-control" name="country_id">
               <option label="' . __('Select Location', 'adforest') . '" value="">' . __('Select Location', 'adforest') . '</option>
			   ' . $locations_html . '
			   </select>';
        } else {
            ob_start();

            adforest_load_search_countries();

            $contries_script = ob_get_contents();
            ob_end_clean();

            wp_enqueue_script('google-map-callback');
            $location_type_html = '<input class="form-control" name="location" id="sb_user_address" placeholder="' . __('Location...', 'adforest') . '"  type="text">';
        }

        $image_side = ($image_pos == "left") ? "left" : 'right';

        $image_html_left = $image_html_right = "";

        $image_html = '   <div class="col-lg-7 col-xs-12 col-md-7 col-sm-12"><div class="pets-images-section"> <img  alt="' . esc_html__('image', 'adforest') . '" src="' . esc_url($side_img_url) . '"  class="img-responsive"> </div></div>';
        $image_html_right = $image_html;
        if ($image_side == 'left') {
            $image_html_left = $image_html_right = "";
            $image_html_left = $image_html;
        }

        $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
        return $contries_script . '<section class="ad-pets-section"  ' . $style . '>
  <div class="container">
    <div class="row">
      <div class="pets-main-section">
        <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
		' . $image_html_left . '
          <div class="col-lg-5 col-xs-12 col-md-5 col-sm-12">
            <div class="new-sunmit-form">
              <div class="form-listing">
                        <form class="form-join" action="' . urldecode(get_the_permalink($sb_search_page)) . '">
          <div class="text-indent-fields"><h3>' . $block_text . '</h3></div>
        <div class="form-group">
           <label for="exampleInputEmail1">' . __('Search Keyword', 'adforest') . '</label>
            <input class="form-control" autocomplete="off" name="ad_title" placeholder="' . __('What Are You Looking For...', 'adforest') . '" type="text"> 
         </div>
        <div class="form-group">
        <label for="exampleInputEmail1">' . __('Select Category', 'adforest') . '</label>
            <select class="' . $jax_cat_class . 'category form-control" name="cat_id">
               <option label="' . __('Select Category', 'adforest') . '" value="">' . __('Select Category', 'adforest') . '</option>
               ' . $cats_html . '
            </select>
        </div>
          <div class="form-group">
          <label for="exampleInputEmail1">' . __('Location', 'adforest') . '</label>
             ' . $location_type_html . '
          </div>
          ' . apply_filters('adforest_form_lang_field', false) . '
          <button class="btn btn-theme btn-block" type="submit">' . __('search', 'adforest') . '</button>
          </form>
              </div>
            </div>
          </div>
   			' . $image_html_right . '
        </div>
      </div>
    </div>
  </div>
</section>';
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('search_hero_classic_short_base', 'search_hero_classic_short_base_func');
}