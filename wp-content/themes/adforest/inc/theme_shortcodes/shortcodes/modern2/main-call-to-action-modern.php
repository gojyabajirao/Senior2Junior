<?php

/* ------------------------------------------------ */
/* adforest_main_call_to_action_modern */
/* ------------------------------------------------ */
if (!function_exists('adforest_maincallt_modern__integrateWithVC')) {

    function adforest_maincallt_modern__integrateWithVC() {

        $cat_array = array();

        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat');
        
        vc_map(array(
            'name' => __('Main Section - Call To Action Modern', 'adforest'),
            'base' => 'adforest_main_call_to_action_modern',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('wedd-main.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'admin_label' => true,
                    'heading' => __('Section Quote Text', 'adforest'),
                    'param_name' => 'main_quote',
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'admin_label' => true,
                    'heading' => __('Section Title', 'adforest'),
                    'param_name' => 'section_title',
                    'description' => __('For color ', 'adforest') . '<strong>' . esc_html('{color}') . '</strong>' . __('warp text within this tag', 'adforest') . '<strong>' . esc_html('{/color}') . '</strong>',
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'admin_label' => true,
                    'heading' => __('Section Subtitle', 'adforest'),
                    'param_name' => 'section_subtitle',
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'admin_label' => true,
                    'heading' => __('Section Description', 'adforest'),
                    'param_name' => 'section_desc',
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Search Block Text", 'adforest'),
                    "param_name" => "block_text",
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    'type' => 'vc_link',
                    'holder' => 'div',
                    'class' => '',
                    'admin_label' => true,
                    'heading' => __('Button 1', 'adforest'),
                    'param_name' => 'section_btn_1',
                    'edit_field_class' => 'vc_col-sm-6 vc_column',
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    'type' => 'vc_link',
                    'holder' => 'div',
                    'class' => '',
                    'admin_label' => true,
                    'heading' => __('Button 2', 'adforest'),
                    'param_name' => 'section_btn_2',
                    'edit_field_class' => 'vc_col-sm-6 vc_column',
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    'type' => 'attach_image',
                    'holder' => 'div',
                    'class' => '',
                    'admin_label' => true,
                    'heading' => __('Content Background Image', 'adforest'),
                    'param_name' => 'section_content_bg',
                    'description' => __('Background image behind the content.', 'adforest'),
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
                        ($cat_array)
                ),
                array(
                    "group" => __("Custom Loctions", "adforest"),
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
                array
                    (
                    'group' => __('Search Type', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Types', 'adforest'),
                    'param_name' => 'types',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => __("Select Type", 'adforest'),
                            "param_name" => "type",
                            "admin_label" => true,
                            "value" => adforest_cats('ad_type', 'no'),
                        ),
                        array(
                            'type' => 'attach_image',
                            'holder' => 'div',
                            'class' => '',
                            'admin_label' => true,
                            'heading' => __('Image', 'adforest'),
                            'param_name' => 'image',
                            'description' => __('select icon image (50pxX50px)', 'adforest'),
                            'edit_field_class' => 'vc_col-sm-12 vc_column',
                        ),
                    )
                ),
            )
        ));
    }

}
add_action('vc_before_init', 'adforest_maincallt_modern__integrateWithVC');
if (!function_exists('adforest_maincallt_modern__shortcode_func')) {

    function adforest_maincallt_modern__shortcode_func($atts, $content = '') {
        // Attributes
        extract(shortcode_atts(
                        array(
            'main_quote' => '', 'section_title' => '', 'section_subtitle' => '', 'section_desc' => '', 'section_btn_1' => '', 'section_btn_2' => '', 'section_content_bg' => '', 'section_img' => '', 'image_pos' => '', 'block_text' => '', 'cats' => '', 'locations' => '', 'location_type' => '', 'types' => '',
                        ), $atts
        ));


        $style = '';
        $section_content_bg_url = '';
        if ($section_content_bg != "") {
            $section_content_bg_url = adforest_returnImgSrc($section_content_bg);
            $style = ( $section_content_bg_url != "" ) ? ' style="background-image: url(' . $section_content_bg_url . ');"' : "";
        }

        $main_quote_html = ( $main_quote != "" ) ? '<span>' . esc_html($main_quote) . '</span>' : '';
        $section_title_html = adforest_color_text_custom_html($section_title, '<span>', '</span>');
        $section_subtitle_html = ( $section_subtitle != "" ) ? '<span>' . $section_subtitle . '</span>' : '';
        $section_desc_html = ( $section_desc != "" ) ? '<p>' . $section_desc . '</p>' : '';
        $side_img_url = ( $section_img ) ? adforest_returnImgSrc($section_img) : '';

        $btn_1 = adforest_ThemeBtn($section_btn_1, 'btn btn-theme', false);
        $btn_2 = adforest_ThemeBtn($section_btn_2, 'btn btn-theme', false);

        $rows = vc_param_group_parse_atts($atts['cats']);
        $rows = apply_filters('adforest_validate_term_type',$rows);
        $cats = false;
        $cats_html = '';
         $args = array('hide_empty' => 0);
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
               
                $args = apply_filters('adforest_wpml_show_all_posts', $args); // for all lang texonomies
                $ad_cats = get_terms('ad_cats', $args);
                foreach ($ad_cats as $cat) {
                    $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '</option>';
                }
            }
        }

        //types
        $types = false;
        $types_html = '';
        if (isset($atts['types']) && $atts['types'] != '') {
            $types_rows = vc_param_group_parse_atts($atts['types']);

            if (isset($types_rows) && count($types_rows) > 0 && $types_rows[0] != '') {
                $cats_html .= '';
                foreach ($types_rows as $row) {
                    if (isset($row['type'])) {
                        if ($row['type'] == 'all') {
                            $cats = true;
                            $cats_html = '';
                            break;
                        }
                        $term = get_term($row['type'], 'ad_type');
                        $image_url = '';
                        if(isset($row['image']) && $row['image'] != ''){
                          $image_url = adforest_returnImgSrc($row['image'], 'adforest-single-small-50');
                        }

                        
                        $types_html .= '<label><input type="radio" name="ad_type" value="' . $term->name . '" ><img src="' . esc_url($image_url) . '"  alt="' . esc_attr('image', 'adforest') . '"> <span>' . $term->name . '</span> </label>'; //
                        '<option value="' . $row['type'] . '">' . $term->name . '</option>';
                    }
                }
            }
        }
        //Types Ends		
        // For custom locations
        $locations_html = '';
        $ad_country_arr = get_terms('ad_country', $args);
        $rows = vc_param_group_parse_atts(isset($atts['locations']) && $atts['locations'] != '' ? $atts['locations'] : '');
        if (isset($rows[0]['location']) && $rows[0]['location'] == 'all' && $location_type == 'custom_locations') {
            $locations_html .= ' <option value="">' . esc_html__('Select location', 'adforest') . ' </option> ';
            if (isset($ad_country_arr) && count($ad_country_arr) > 0) {
                foreach ($ad_country_arr as $loc_value) {
                    $locations_html .= ' <option value="' . intval($loc_value->term_id) . '">' . esc_html($loc_value->name) . ' </option> ';
                }
            }
        } else {
            if (count((array) $rows) > 0 && $rows[0]['location'] != 'all') {
                $cats_html .= '';
                foreach ($rows as $row) {
                    if (isset($row['location'])) {
                        $term = get_term($row['location'], 'ad_country');
                        $locations_html .= ' <option value="' . $row['location'] . '">' . $term->name . '</option> ';
                    }
                }
            }
        }

        $location_type_html = '';
        $countries_script = '';
        if ($location_type == 'custom_locations') {
            $location_type_html = '<select class="category form-control" name="country_id">
					   ' . $locations_html . '
					   </select>';
        } else {
            ob_start();

            adforest_load_search_countries();

            $countries_script = ob_get_contents();
            ob_end_clean();

            wp_enqueue_script('google-map-callback');
            $location_type_html = '<input class="form-control" name="location" id="sb_user_address" placeholder="' . __('Location...', 'adforest') . '"  type="text">';
        }
        // Output Code
        global $adforest_theme;
        $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
        $output = $countries_script . '<section class="mat-hero-section" ' . $style . '>
  <div class="container">
    <div class="row">
      <div class="col-lg-7 col-xs-12 col-sm-6 col-md-6">
        <div class="mat-hero-details-section">
          <div class="mat-hero-new-section"> <span>' . $main_quote_html . '</span> </div>
          <div class="mat-hero-text-section"><h1>' . $section_title_html . '</h1></div>
		  <div class="mat-hero-new-section"><span>' . $section_subtitle_html . '</span></div>
          <div class="mat-ad-details-section">' . $section_desc_html . '</div>
          <div class="mat-hero-post-ads">
            <div class="mat-new-post-ads">' . $btn_1 . '</div>
            <div class="mat-hero-read-ads">' . $btn_2 . '</div>
          </div>
        </div>
      </div>
      <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
        <div class="mat-form-group">
		
        <form class="form-join" action="' . get_the_permalink($sb_search_page) . '">
          <h4>' . $block_text . '</h4>
            <div class="mat-gender-selection"> ' . $types_html . '  </div>		  
        <div class="form-group">
           <label for="exampleInputEmail1">' . __('Title', 'adforest') . '</label>
            <input class="form-control" autocomplete="off" name="ad_title" placeholder="' . __('What Are You Looking For...', 'adforest') . '" type="text"> 
         </div>
        <div class="form-group">
        <label for="exampleInputEmail1">' . __('Select Category', 'adforest') . '</label>
            <select class="category form-control" name="cat_id">
               <option label="' . __('Select Category', 'adforest') . '" value="">' . __('Select Category', 'adforest') . '</option>
               ' . $cats_html . '
            </select>
        </div>
          <div class="form-group">
          <label for="exampleInputEmail1">' . __('Location', 'adforest') . '</label>
             ' . $location_type_html . '
          </div>
          <button class="btn btn-theme btn-block" type="submit">' . __('search', 'adforest') . '</button>
          	
          </form>		
        </div>
      </div>
      <!-- END col-lg-5--> 
    </div>
  </div>
  <div class="mat-new-image"></div>
</section>';


        return $output;
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('adforest_main_call_to_action_modern', 'adforest_maincallt_modern__shortcode_func');
}