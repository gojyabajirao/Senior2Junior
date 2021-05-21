<?php

/* ------------------------------------------------ */
/* Hero Section Toy */
/* ------------------------------------------------ */
add_action('vc_before_init', 'adforest_hero_section_toys_shortcode');
if (!function_exists('adforest_hero_section_toys_shortcode')) {

    function adforest_hero_section_toys_shortcode() {

        $cat_array = array();

        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat', 'no');

        vc_map(array(
            'name' => __('Hero Section - Toys Banner Slider', 'adforest'),
            'description' => '',
            'base' => 'adforest_hero_section_toys',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('hero-toyforest.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    'group' => __('Categories Settings', 'adforest'),
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("Categories Title", "adforest"),
                    "param_name" => "category_title",
                    "value" => '',
                    "description" => '',
                ),
                array(
                    'group' => __('Categories Settings', 'adforest'),
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
                    'group' => __('Slider Settings', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Add Slides', 'adforest'),
                    'param_name' => 'slides',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "attach_image",
                            "class" => "",
                            "heading" => __("Slider Logo Image", "adforest"),
                            "param_name" => "slider_logo_image",
                            "value" => '',
                            "description" => __("Add an image of Slider : Recommended size (175 X 66)", "adforest")
                        ),
                        array(
                            "type" => "attach_image",
                            "class" => "",
                            "heading" => __("Slider Image", "adforest"),
                            "param_name" => "slider_image",
                            "value" => '',
                            "description" => __("Add an image of Slider : Recommended size (346 X 496)", "adforest")
                        ),
                        array(
                            "type" => "textfield",
                            "class" => "",
                            "heading" => __("Slider Title", "adforest"),
                            "param_name" => "slider_title",
                            "value" => '',
                            "description" => '',
                        ),
                        array(
                            "type" => "textarea",
                            "holder" => "div",
                            "class" => "",
                            "heading" => __("Slider Description", 'adforest'),
                            "param_name" => "slider_description",
                            "value" => "",
                        ),
                        array(
                            "type" => "vc_link",
                            "heading" => __("Slider Button", 'adforest'),
                            "param_name" => "slider_btn",
                            "description" => '',
                        ),
                    ),
                ),
            )
        ));
    }

}

if (!function_exists('adforest_hero_section_toys_callback')) {

    function adforest_hero_section_toys_callback($atts, $content = '') {
        extract(
                shortcode_atts(
                        array(
            'category_title' => '',
            'cats' => '',
            'slides' => '',
                        ), $atts)
        );
        wp_enqueue_script('carousel');
        $categoty_title_html = '';
        if (isset($category_title) && !empty($category_title)) {
            $categoty_title_html .= '<li class="t-colors btn-theme">
                                    <div class="mob-latest-contents">
                                        <h5>' . esc_html($category_title) . '</h5>
                                    </div>
                                </li>';
        }

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

                    $categories_html .= '<li> 
                                    <a href="' . get_term_link($cat->term_id) . '"> 
                                        <img src="' . esc_url($category_image) . '" alt="' . esc_html($cat->name) . '" class="img-responsive">
                                        <div class="mob-details-lg">
                                            <h6>' . esc_html($cat->name) . '</h6>
                                            <p>' . intval($count) . ' ' . esc_html__('Ads', 'adforest') . '</p>
                                        </div>
                                        <i class="fa fa-angle-right"></i> 
                                    </a> 
                                </li>';
                }
            }
        }

        $element_slides = vc_param_group_parse_atts($atts['slides']);
        $slider_html = '';
        if (isset($element_slides) && !empty($element_slides) && is_array($element_slides) && count($element_slides) > 0) {
            foreach ($element_slides as $slide) {
                $slider_image_id = isset($slide['slider_image']) ? $slide['slider_image'] : '';
                $slider_logo_image = isset($slide['slider_logo_image']) ? $slide['slider_logo_image'] : '';
                $slider_title = isset($slide['slider_title']) ? $slide['slider_title'] : '';
                $slider_description = isset($slide['slider_description']) ? $slide['slider_description'] : '';
                $slider_btn_data = isset($slide['slider_btn']) ? $slide['slider_btn'] : '';
                $slider_btn_html = adforest_ThemeBtn($slider_btn_data, 'btn btn-theme', false);
                $slider_image = adforest_returnImgSrc($slider_image_id);
                $slider_logo_image = adforest_returnImgSrc($slider_logo_image);
                $slider_html .= '<div class="item">
                                    <div class="toys-hero-content">
                                        <div class="col-lg-6 col-xs-12 col-sm-6 col-md-6">
                                            <div class="toys-hero-accesories">
                                                <div class="toys-hero-logo">
                                                    <img src="' . esc_url($slider_logo_image) . '" alt="' . esc_html__('Slider Logo Image', 'adforest') . '" class="img-responsive">
                                                </div>
                                                <div class="toys-hero-text">
                                                    <h3>' . esc_html($slider_title) . '</h3>
                                                    <p>' . esc_html($slider_description) . '</p>
                                                </div>
                                                <div class="toys-hero-shop">
                                                    ' . $slider_btn_html . '
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-xs-12 col-sm-6 col-md-6">
                                            <div class="toys-hero-img">
                                                <img src="' . esc_url($slider_image) . '" alt="' . esc_html__('Slider Image', 'adforest') . '" class="img-responsive">
                                            </div>
                                        </div>
                                    </div>
                                </div>';
            }
        }
        $html = '';
        $html .= '<section class="toys-hero-section">
            <div class="container">
                <div class="row">

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="mob-all-categories">
                            <ul class="mob-latest-categories">
                                ' . $categoty_title_html . '
                                ' . $categories_html . '
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-8 col-xs-12 col-sm-8 col-md-8">
                        <div class="toys-new-accessories owl-carousel owl-theme">
                        ' . $slider_html . '
                        </div>
                    </div>  
                </div>
            </div>
        </section>';
        return $html;
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('adforest_hero_section_toys', 'adforest_hero_section_toys_callback');
}