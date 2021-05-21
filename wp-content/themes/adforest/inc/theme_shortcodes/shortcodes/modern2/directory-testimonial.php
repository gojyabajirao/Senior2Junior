<?php

/* ------------------------------------------------ */
/* directory_testimonial */
/* ------------------------------------------------ */
if (!function_exists('directory_testimonial_shortcodeBase')) {

    function directory_testimonial_shortcodeBase() {
        vc_map(array(
            'name' => __("Testimonials - Directory", 'adforest'),
            'base' => 'directory_testimonial',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('directory-testimonial.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
                        __('Gray', 'adforest') => 'gray',
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
                array
                    (
                    'group' => __("Testimonials", 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Add testimonial slides.', 'adforest'),
                    'param_name' => 'testimonials',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'admin_label' => true,
                            'heading' => __('Name', 'adforest'),
                            'param_name' => 'title',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'admin_label' => true,
                            'heading' => __('Designation', 'adforest'),
                            'param_name' => 'designation',
                        ),
                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'class' => '',
                            'admin_label' => true,
                            'heading' => __('Description', 'adforest'),
                            'param_name' => 'desc',
                        ),
                        array(
                            'type' => 'attach_image',
                            'holder' => 'div',
                            'class' => '',
                            'admin_label' => true,
                            'heading' => __('Side Image', 'adforest'),
                            'param_name' => 'img',
                            'description' => __('Section side image', 'adforest'),
                            'edit_field_class' => 'vc_col-sm-12 vc_column',
                        ),
                    )
                ),
            )
        ));
    }

}
add_action('vc_before_init', 'directory_testimonial_shortcodeBase');
if (!function_exists('directory_testimonial_func')) {

    function directory_testimonial_func($atts, $content = '') {
        // Attributes
        extract(shortcode_atts(
                        array(
            'testimonials' => '',
            'section_bg' => '',
            'sec_main_heading' => '',
            'sec_top_desc' => '',
                        ), $atts));
        $section_bg_class = ( $section_bg == 'gray' ) ? 'gray' : '';

        $points = false;
        $points_html = '';
        $inner_html = '';
        if (isset($atts['testimonials']) && $atts['testimonials'] != '') {
            $points_rows = vc_param_group_parse_atts($atts['testimonials']);
            if (count($points_rows) > 0) {

                foreach ($points_rows as $row) {
                    if (isset($row['title'])) {
                        $image_url = ( isset($row['img']) ) ? adforest_returnImgSrc($row['img']) : '';
                        $designation = ( isset($row['designation']) && $row['designation'] != "" ) ? $row['designation'] : 0;
                        $title = ( isset($row['title']) ) ? '<div class="land-one-h2"><h5>' . $row['title'] . "</h5></div>" : '';
                        $desc = ( isset($row['desc']) ) ? "<p>" . $row['desc'] . "</p>" : '';

                        $inner_html .= '<div class="item">
                                        <div class="test">
                                          <p>' . $desc . '</p>
                                          <div class="test-inner">
                                            <ul class="list-inline">
                                              <li class="client-img pull-left"><img src="' . $image_url . '" class="img-responsive img-circle" alt="client"/></li>
                                              <li class="testi-text pull-left"> <span>' . $title . '</span>
                                               ' . $designation . '
                                              </li>
                                              <li class="testi-img pull-right"> <img src="' . get_template_directory_uri() . '/images/11-testi.png" class="img-responsive" alt="client"/> </li>
                                            </ul>
                                          </div>
                                        </div>
                                      </div>';
                    }
                }
            }
        }


        $sec_top_desc_html = '';
        if (isset($sec_top_desc) && $sec_top_desc != '') {
            $sec_top_desc_html = '<p class="t-center">' . $sec_top_desc . '</p>';
        }

        $sec_main_heading_html = '';
        if (isset($sec_main_heading) && $sec_main_heading != '') {
            $sec_main_heading_html = adforest_color_text($sec_main_heading);
        }

        return '<div class="adf-sec-seven-11 ' . $section_bg_class . '">
                <section class="client-say-11 padding-bottom-60 ">
                  <div class="container">
                    <div class="row margin-bottom-30">
                      <div class="col-xs-12 col-sm-8 col-md-8">
                        <div class="hading">
                          ' . $sec_top_desc_html . '
                          <span class="t-center d-block">' . $sec_main_heading_html . '</span>
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="hading-btn text-right">
                          <div class="customize-tools">
                            <ul class="say-btns" id="say-btns" aria-label="Carousel Navigation" tabindex="0">
                              <li class="prev" aria-controls="customize" tabindex="-1" data-controls="prev"> <span>' . __('PREV', 'adforest') . '</span> </li>
                              <li class="next active" aria-controls="customize" tabindex="-1" data-controls="next"> <span>' . __('NEXT', 'adforest') . '</span> </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row margin-bottom-30">
                      <div class="testimonial-11-wraper" id="testimonial-11-wraper">
                        <div class="testimonial-11" id="testimonial-11">
                            ' . $inner_html . '
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
              </div>';
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('directory_testimonial', 'directory_testimonial_func');
}