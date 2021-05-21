<?php

/* ------------------------------------------------ */
/* directory_callto_action_1 */
/* ------------------------------------------------ */
add_action('vc_before_init', 'adforest_directory_callto_action_1_shortcode');
if (!function_exists('adforest_directory_callto_action_1_shortcode')) {

    function adforest_directory_callto_action_1_shortcode() {
        vc_map(array(
            'name' => __('Call To Action - Directory', 'adforest'),
            'description' => '',
            'base' => 'directory_callto_action_1',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('calltoactiond-1.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Ads count section", 'adforest'),
                    "description" => __("%count% for total ads.", 'adforest'),
                    "param_name" => "ads_count_section",
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
                    "group" => __("Basic", "adforest"),
                    "type" => "textarea_html",
                    "class" => "",
                    "heading" => __("Description", 'adforest'),
                    "param_name" => "content",
                    "value" => "",
                    "holder" => "div",
                ),
                array(
                    'group' => __('Services Settings', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Add Services', 'adforest'),
                    'param_name' => 'services',
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
                array(
                    "group" => __("Video setting", "adforest"),
                    "type" => "attach_image",
                    "holder" => "img",
                    "heading" => __("Video Image : : Recommended size (555 X 370)", 'adforest'),
                    "param_name" => "call_img",
                ),
                array(
                    "group" => __("Video setting", "adforest"),
                    "type" => "textfield",
                    "heading" => __("Video URL ( youtube link)", 'adforest'),
                    "param_name" => "video_url",
                    "description" => '',
                ),
            )
        ));
    }

}

if (!function_exists('adforest_directory_callto_action_1_func')) {

    function adforest_directory_callto_action_1_func($atts, $content = '') {
        extract(shortcode_atts(
                        array(
            'ads_count_section' => '',
            'sec_main_heading' => '',
            'services' => '',
            'call_img' => '',
            'video_url' => '',
                        ), $atts));

        $count_posts = wp_count_posts('ad_post');
        $ads_count_section = str_replace('%count%', '<b>' . $count_posts->publish . '</b>', $ads_count_section);

        $services = vc_param_group_parse_atts($atts['services']);
        $services_html = '';

        if (isset($services) && is_array($services) && count($services) > 0) {
            foreach ($services as $service) {
                $service_img = ( isset($service['img']) && $service['img'] != '' ) ? adforest_returnImgSrc($service['img']) : '';
                $service_title = ( isset($service['service_title']) && $service['service_title'] != '' ) ? $service['service_title'] : '';
                $service_desc = ( isset($service['service_desc']) && $service['service_desc'] != '' ) ? $service['service_desc'] : '';

                $service_img_html = '';
                if ($service_img != '') {
                    $service_img_html = ' <div class="img-container"> <img src="' . $service_img . '" class="img-responsive" alt="phone"> </div>';
                }

                $service_title_html = '';
                if ($service_title != '') {
                    $service_title_html = '<span class="text-capitalize">' . $service_title . '</span>';
                }

                $service_desc_html = '';
                if ($service_desc != '') {
                    $service_desc_html = '<p>' . $service_desc . '</p>';
                }

                $services_html .= '<div class="col-xs-12 col-sm-6 col-md-6 no-padding services">
                                   ' . $service_img_html . '
                                    <div class="img-data"> 
                                    ' . $service_title_html . '
                                     ' . $service_desc_html . ' 
                                    </div>
                                  </div>';
            }
        }


        $call_video_img = ( isset($call_img) && $call_img != '' ) ? adforest_returnImgSrc($call_img) : '';
        $sec_main_heading_html = '';
        if (isset($sec_main_heading) && $sec_main_heading != '') {
            $sec_main_heading_html = adforest_color_text($sec_main_heading);
        }

        $video_url_html = '';
        if(isset($video_url) && $video_url != ''){
            $video_url_html = '<div class="img-icon"> 
                                <a  class="trust play-video" href="' . esc_url($video_url) . '">
                                  <img src="' . get_template_directory_uri() . '/images/11-video-icon.png" class="img-responsive" alt="icon-img"/>
                                </a> 
                              </div>';
        }
        
        $call_video_img_html = '';
        if(isset($call_video_img) && $call_video_img != ''){
            $call_video_img_html = '<img src="' . esc_url($call_video_img) . '" alt="circle-image" class="img-responsive"/> </div>';
        }
        
        
        $html = '';
        $html .= '<!-- Section-four-11--start-->
                <div class="adf-sec-four-11">
                  <section class="name-can-11 padding-bottom-60">
                    <div class="container">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-7 margin-bottom-30">
                          <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="hading">
                              <p class="t-center">' . $ads_count_section . '</p>
                              <span class="t-center d-block text-capitalize">' . $sec_main_heading_html . '</div>
                            <div class="explain-data margin-top-10">
                              <p>' . adforest_returnEcho($content) . '</p>
                            </div>
                            ' . $services_html . '
                        </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-5 margin-bottom-30">
                          <div class="circle-imgdata">
                            '.$video_url_html.'
                            '.$call_video_img_html.'
                        </div>
                      </div>
                    </div>
                  </section>
                </div>
<!-- Section-four-11--close--> ';




        return $html;
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('directory_callto_action_1', 'adforest_directory_callto_action_1_func');
}