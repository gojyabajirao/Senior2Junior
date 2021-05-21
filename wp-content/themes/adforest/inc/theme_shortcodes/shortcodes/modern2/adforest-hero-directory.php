<?php

/* ------------------------------------------------ */
/* Hero Section Toy */
/* ------------------------------------------------ */
add_action('vc_before_init', 'adforest_hero_directory_shortcode');
if (!function_exists('adforest_hero_directory_shortcode')) {

    function adforest_hero_directory_shortcode() {

        $cat_array = array();

        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat', 'no');

        vc_map(array(
            'name' => __('Hero Section - Directory', 'adforest'),
            'description' => '',
            'base' => 'adforest_hero_directory',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('hero-directory.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Search Settings", "adforest"),
                    "type" => "attach_image",
                    "class" => "",
                    "heading" => __("Background Image", 'adforest'),
                    "param_name" => "dir_bg_img",
                    "description" => __("1920 X 750", 'adforest'),
                ),
                array(
                    'group' => __('Search Settings', 'adforest'),
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("Main Title", "adforest"),
                    "param_name" => "dir_main_title",
                    "value" => '',
                    "description" => '',
                ),
                array(
                    'group' => __('Search Settings', 'adforest'),
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("Subtitle", "adforest"),
                    "param_name" => "dir_main_subtitle",
                    "value" => '',
                    "description" => '',
                ),
                array(
                    "group" => __("Search Settings", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Display tags?", 'adforest'),
                    "param_name" => "is_display_tags",
                    "admin_label" => true,
                    "value" => array(
                        __('Select Option', 'adforest') => '',
                        __('Yes', 'adforest') => '1',
                        __('No', 'adforest') => '0'
                    ),
                ),
                array(
                    'group' => __('Search Settings', 'adforest'),
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("Tags Label", "adforest"),
                    "param_name" => "dir_tag_label",
                    "std" => __('Trending keywords', 'adforest'),
                    "description" => '',
                    'dependency' => array(
                        'element' => 'is_display_tags',
                        'value' => array('1'),
                    ),
                ),
                array(
                    "group" => __("Search Settings", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Max number of tags", 'adforest'),
                    "param_name" => "max_tags_limit",
                    "admin_label" => true,
                    "value" => range(1, 500),
                    'dependency' => array(
                        'element' => 'is_display_tags',
                        'value' => array('1'),
                    ),
                ),
                array(
                    "group" => __("Search Settings", "adforest"),
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
                array(
                    'group' => __('Slider Categories', 'adforest'),
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("Categories Title", "adforest"),
                    "param_name" => "category_title",
                    "value" => '',
                    "description" => '',
                ),
                array(
                    'group' => __('Slider Categories', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category', 'adforest'),
                    'param_name' => 'cats',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "attach_image",
                            "class" => "",
                            "heading" => __("Category Image", "adforest"),
                            "param_name" => "category_image",
                            "value" => '',
                            "description" => __("Add an image of Category : Recommended size (53 X 43)", "adforest")
                        ),
                        $cat_array,
                    ),
                ),
                array(
                    'group' => __('Cosutom Loctions', 'adforest'),
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
                    ),
                    'dependency' => array(
                        'element' => 'location_type',
                        'value' => array('custom_locations'),
                    ),
                ),
            )
        ));
    }

}

if (!function_exists('adforest_hero_directory_callback')) {

    function adforest_hero_directory_callback($atts, $content = '') {
        global $adforest_theme;
        
        extract(
                shortcode_atts(
                        array(
            'dir_bg_img' => '',
            'category_title' => '',
            'cats' => '',
            'slides' => '',
            'slides' => '',
            'max_tags_limit' => '',
            'dir_tag_label' => '',
            'is_display_tags' => '',
            'dir_main_subtitle' => '',
            'dir_main_title' => '',
            'location_type' => '',
                        ), $atts)
        );
        
        wp_enqueue_script('adforest-tiny-slider');

        $slider_cats = array();
        if (isset($atts['cats']) && $atts['cats'] != '') {
            $slider_cats = vc_param_group_parse_atts($atts['cats']);
            $slider_cats = apply_filters('adforest_validate_term_type', $slider_cats);
        }
        $categories_html = '';
        if (isset($slider_cats) && !empty($slider_cats) && is_array($slider_cats) && count($slider_cats) > 0) {
            foreach ($slider_cats as $cats) {
                $category_image_id = isset($cats['category_image']) ? $cats['category_image'] : '';
                $category_image = adforest_returnImgSrc($category_image_id);

                if (isset($cats['cat']) && $cats['cat'] != '') {
                    $cat = get_term_by('id', $cats['cat'], 'ad_cats', 'OBJECT');
                    $count = ($cat->count);
                    $categories_html .= '<div class="item">
                                            <div class="internal-data">
                                                <a href="' . get_term_link($cat->term_id) . '"><img src="' . esc_url($category_image) . '" alt="' . esc_html($cat->name) . '" class="img-responsive">
                                                  <div class="internal-txt"> <span class="h-primary">' . esc_html($cat->name) . '</span><span class="h-2nd">' . intval($count) . ' ' . esc_html__('Ads', 'adforest') . '</span></div>
                                                </a>
                                             </div>
                                         </div>';
                }
            }
        }

        /*
         * Search dropdown cats
         */

        $cats_html = '';
        $args = array('hide_empty' => 0, 'include_children' => 0);
        $args = apply_filters('adforest_wpml_show_all_posts', $args); // for all lang texonomies
        $ad_cats = get_terms('ad_cats', $args);
        foreach ($ad_cats as $cat) {
            $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '</option>';
        }

        /*
         * Location field html
         */


        // For custom locations
        $locations_html = '';
        $args_loc = array('hide_empty' => 0);
        $ad_country_arr = get_terms('ad_country', $args_loc);
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
                $locations_html .= '';
                foreach ($rows as $row) {
                    if (isset($row['location'])) {
                        $term = get_term($row['location'], 'ad_country');
                        $locations_html .= ' <option value="' . $row['location'] . '">' . $term->name . '</option> ';
                    }
                }
            }
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
            $location_type_html = '<input type="text" name="location" id="sb_user_address" placeholder="' . __('Location...', 'adforest') . '">';

            $location_type_html = '<input class="form-control" type="text" id="sb_user_address" autocomplete="off" name="location" placeholder="' . __('Location...', 'adforest') . '">';
        }

        /*
         * Search tags
         */

        $tags = '';
        if ($is_display_tags == 1) {
            $tags = '<div class="cat-tags">
                  <span class="key-heading">' . __('Trending keywords', 'adforest') . ' : </span>';
            $args = array(
                'smallest' => 12,
                'largest' => 12,
                'unit' => 'px',
                'number' => $max_tags_limit,
                'format' => 'list',
                'separator' => "\n",
                'orderby' => 'name',
                'order' => 'ASC',
                'link' => 'view',
                'taxonomy' => 'ad_tags',
                'echo' => false,
            );
            $tags .= wp_tag_cloud($args);
            $tags .= '</div>';
        }

        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";




        $bg_img_style = '';
        if (isset($dir_bg_img) && $dir_bg_img != '') {

            $bgImageURL = adforest_returnImgSrc($dir_bg_img);

            $bg_img_style = ' style="background: rgba(0, 0, 0, 0.6) url(' . $bgImageURL . ') no-repeat;"';
        }

        $search_placeholder = __('What are you looking for...', 'adforest');

        $dir_main_title_html = '';
        if (isset($dir_main_title) && $dir_main_title != '') {
            $dir_main_title_html = '<h1 class="main-hading">' . $dir_main_title . '</h1>';
        }
        $dir_main_subtitle_html = '';
        if (isset($dir_main_subtitle) && $dir_main_subtitle != '') {
            $dir_main_subtitle_html = '<p class="main-des">' . $dir_main_subtitle . '</p>';
        }

        $cat_slider_class = 'col-md-12 no-padding';
        $category_title_html = '';
        if (isset($category_title) && $category_title != '') {
            $category_title_html = '<div class="col-sm-3 col-md-3">
                                        <div class="heading-cats">
                                          <p class="exp">' . $category_title . '</p>
                                        </div>
                                      </div>';
            $cat_slider_class = 'col-md-9 no-padding';
        }



        $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
        $html = '';
        $html .= '<!-- Section-One-11--start-->
                    <div class="adf-sec-one-11">
                      <section id="hero" class="hero-11 bg-img" ' . $bg_img_style . '>
                        <div class="content">
                          <div class="search-container-11"> 
                            <!-- Form -->
                            ' . $dir_main_title_html . '
                            ' . $dir_main_subtitle_html . '
                            <form class="padding-top-40"  action="' . get_the_permalink($sb_search_page) . '" onsubmit="adforest_disableEmptyInputs(this)">
                              <!-- Search Input -->
                              <div class="col-md-4 col-sm-4 col-xs-12 no-padding">
                                <div class="form-group bg-white bgw-1">
                                  <label>' . __("Title", "adforest") . '</label>
                                  <input class="form-control" type="text" autocomplete="off" name="ad_title" placeholder="' . esc_attr($search_placeholder) . '">
                                </div>
                              </div>
                              <!-- Search Category -->
                              <div class="col-md-3 col-sm-3 col-xs-12 no-padding ">
                                <div class="form-group bg-white active-br">
                                  <label>' . __("Category", "adforest") . '</label>
                                  <select class="category form-control">
                                     <option label="' . __('Select Category', 'adforest') . '" value="">' . __('Select Category', 'adforest') . '</option>
                                         ' . $cats_html . '
                                  </select>
                                </div>
                              </div>
                              <!-- Search Location -->
                              <div class="col-md-3 col-sm-3 col-xs-12 no-padding ">
                                <div class="form-group bg-white bgw-2">
                                  <label>' . __("Location", "adforest") . '</label>
                                  ' . $location_type_html . '
                                </div>
                              </div>
                              <div class="col-md-2 col-sm-2 col-xs-12 mb-padding">
                                <div class="form-group form-action">
                                  <input type="submit" class="search-btn btn btn-theme" value="' . __("Search", "adforest") . '"/>
                                </div>
                              </div>
                            </form>
                            <!-- search Tags-->
                            ' . $tags . '
                          </div>

                          <!-- .search-holder --> 
                        </div>
                        <!-- .content --> 
                      </section>
                    </div>
                    <!-- Section-One-11--start End --> 

                    <!-- Section-two-11--start-->
                    <div class="adf-sec-two-11">
                      <div class="main-content-area clearfix"> 
                        <!-- =-=-=-=-=-=-= Home Tabs =-=-=-=-=-=-= -->
                        <section class="home-tabs">
                          <div class="container">
                            <div class="row">
                               ' . $category_title_html . '
                              <div class="' . $cat_slider_class . '">
                                <div class="taber-container">
                                  <div class="cat-11">
                                    <!-- =-=-=-=-=-=-= Popular Categories  items =-=-=-=-=-=-= --> 
                                    ' . $categories_html . '
                                  </div>
                                  <div class="customize-tools">
                                    <ul class="cats-11" id="cat-customize" aria-label="Carousel Navigation" tabindex="0">
                                      <li class="prev" aria-controls="customize" tabindex="-1" data-controls="prev"> <i class="fa fa-angle-left"></i> </li>
                                      <li class="next" aria-controls="customize" tabindex="-1" data-controls="next"> <i class="fa fa-angle-right"></i> </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </section>
                      </div>
                      <!-- =-=-=-=-=-=-= Popular Categories  End =-=-=-=-=-=-= --> 
                    </div>
                    <!-- Section-two-11--close--> ';
        return $html;
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('adforest_hero_directory', 'adforest_hero_directory_callback');
}