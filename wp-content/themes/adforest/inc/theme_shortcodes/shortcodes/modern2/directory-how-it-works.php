<?php

/* ------------------------------------------------ */
/* how_it_works_directory */
/* ------------------------------------------------ */
add_action('vc_before_init', 'adforest_how_it_works_directory_shortcode');
if (!function_exists('adforest_how_it_works_directory_shortcode')) {

    function adforest_how_it_works_directory_shortcode() {
        vc_map(array(
            'name' => __('How it Works - Directory', 'adforest'),
            'description' => '',
            'base' => 'how_it_works_directory',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('how-its-work-directory.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "type" => "attach_image",
                    "heading" => __("Background Image", 'adforest'),
                    "param_name" => "how_bg_img",
                    "description" => __('470 X 1920', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "heading" => __("Heading 1", 'adforest'),
                    "param_name" => "heading_1",
                    "description" => '',
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "heading" => __("Heading 2", 'adforest'),
                    "param_name" => "heading_2",
                    "description" => '',
                ),
                array(
                    'group' => __('Works Steps', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Add Steps', 'adforest'),
                    'param_name' => 'work_steps',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "attach_image",
                            "holder" => "service_img",
                            "heading" => __("Category Image : Recommended size (45 X 45)", 'adforest'),
                            "param_name" => "img",
                            "description" => __('45 X 45', 'adforest'),
                        ),
                        array(
                            "type" => "textfield",
                            "holder" => "div",
                            "class" => "",
                            "heading" => __("Service Title", 'adforest'),
                            "param_name" => "service_title",
                        ),
                        array(
                            "type" => "textarea",
                            "holder" => "div",
                            "class" => "",
                            "heading" => __("Service Description", 'adforest'),
                            "param_name" => "service_desc",
                            "value" => "",
                            'edit_field_class' => 'vc_col-sm-12 vc_column',
                        ),
                    )
                ),
            )
        ));
    }

}

if (!function_exists('adforest_how_it_works_directory_func')) {

    function adforest_how_it_works_directory_func($atts, $content = '') {
        extract(shortcode_atts(
                        array(
            'heading_1' => '',
            'heading_2' => '',
            'work_steps' => '',
            'how_bg_img' => '',
                        ), $atts));

        $work_steps = vc_param_group_parse_atts($atts['work_steps']);
        $services_html = '';

        if (isset($work_steps) && is_array($work_steps) && count($work_steps) > 0) {
            $counter = 1;
            foreach ($work_steps as $service) {
                $service_img = ( isset($service['img']) && $service['img'] != '' ) ? adforest_returnImgSrc($service['img']) : '';
                $service_title = ( isset($service['service_title']) && $service['service_title'] != '' ) ? $service['service_title'] : '';
                $service_desc = ( isset($service['service_desc']) && $service['service_desc'] != '' ) ? $service['service_desc'] : '';



                if ($counter <= 9) {
                    $counter_text = '0' . $counter;
                } else {
                    $counter_text = $counter;
                }

                $service_img_html = '';
                if ($service_img != '') {
                    $service_img_html = '<div class="work-grids">
                                            <div class="icon-data"> <img src="' . $service_img . '" class="img-responsive" alt="' . __('Works Image', 'adforest') . '"> <span class="my-badge badge">' . $counter_text . '</span> </div>
                                          </div>';
                }

                $service_title_html = '';
                if ($service_title != '') {
                    $service_title_html = '<span class="text-capitalize">' . $service_title . '</span>';
                }

                $service_desc_html = '';
                if ($service_desc != '') {
                    $service_desc_html = '<p>' . $service_desc . '</p>';
                }


                $services_html .= '<div class="col-xs-12 col-sm-4 col-md-4 padding-bottom-30">
                                    ' . $service_img_html . '
                                    <div class="work-data">
                                    ' . $service_title_html . '
                                     ' . $service_desc_html . '
                                    </div>
                                  </div>';

                $counter++;
            }
        }

        
        $how_bg_img_ = isset($how_bg_img) && $how_bg_img != '' ? adforest_returnImgSrc($how_bg_img) : '';
        
        $html = '';
        $how_bg_img_style = '';
        if($how_bg_img_ != ''){
         $how_bg_img_style = ' style="background:rgba(0, 0, 0, 0.6) url('.$how_bg_img_.') no-repeat;" ';   
        }




        $html .= '<div class="adf-sec-five-11">
                    <section class="how-work-11 parallex padding-top-60 padding-bottom-30"'.$how_bg_img_style.'>
                      <div class="container">
                        <div class="row">
                          <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="hading">
                              <p class="t-center">' . $heading_1 . '</p>
                              <span class="t-center d-block text-capitalize">' . $heading_2 . '</div>
                          </div>
                        </div>
                        <div class="row padding-top-60">
                          <div class="col-xs-12 col-sm-12 col-md-12 no-padding">
                            ' . $services_html . '
                          </div>
                        </div>
                      </div>
                    </section>
                  </div>';

        return $html;
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('how_it_works_directory', 'adforest_how_it_works_directory_func');
}