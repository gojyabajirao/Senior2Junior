<?php
/* ------------------------------------------------ */
/* directory_callto_action_2 */
/* ------------------------------------------------ */
add_action('vc_before_init', 'adforest_directory_callto_action_2_shortcode');
if (!function_exists('adforest_directory_callto_action_2_shortcode')) {

    function adforest_directory_callto_action_2_shortcode() {
        vc_map(array(
            'name' => __('Call To Action 2 - Directory', 'adforest'),
            'description' => '',
            'base' => 'directory_callto_action_2',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('calltoactiond-2.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    'group' => __('Basic', 'adforest'),
                    'type' => 'attach_image',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Background Image', 'adforest'),
                    'param_name' => 'call_bg_img',
                    'description' => __('Section background image', 'adforest'),
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("Heading 1", "adforest"),
                    "param_name" => "heading_1",
                    'group' => __('Basic', 'adforest'),
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("Heading 2", "adforest"),
                    "param_name" => "heading_2",
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
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("App Store URL", "adforest"),
                    "param_name" => "app_store",
                    "value" => '',
                    "description" => '',
                    'group' => __('App Buttons', 'adforest'),
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("Google Store URL", "adforest"),
                    "param_name" => "google_store",
                    "value" => '',
                    "description" => '',
                    'group' => __('App Buttons', 'adforest'),
                ),
                array(
                    'group' => __('App Buttons', 'adforest'),
                    'type' => 'attach_image',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('App Image', 'adforest'),
                    'param_name' => 'call_app_img',
                    'description' => __('Right Section image', 'adforest'),
                ),
            )
        ));
    }

}

if (!function_exists('adforest_directory_callto_action_2_func')) {

    function adforest_directory_callto_action_2_func($atts, $content = '') {
        extract(shortcode_atts(
                        array(
            'call_bg_img' => '',
            'heading_1' => '',
            'heading_2' => '',
            'app_store' => '',
            'google_store' => '',
            'call_app_img' => '',
                        ), $atts));



        $call_app_img_src = isset($call_app_img) && $call_app_img != '' ? adforest_returnImgSrc($call_app_img) : '';



        $heading_1_html = '';
        if (isset($heading_1) && $heading_1 != '') {
            $heading_1_html = '<p class="t-center">' . $heading_1 . '</p>';
        }
        $heading_2_html = '';
        if (isset($heading_2) && $heading_2 != '') {
            $heading_2_html = '<span class="t-center d-block col-md-8 no-padding clearfix"><span class="bold-hading">' . $heading_2 . '</span></span>';
        }

        $app_store_html = '';
        if (isset($app_store) && $app_store != '') {
            $app_store_html = '<div class="apple-div padding-top-20"> 
                                <!-- Apple Store -->
                                <a href="' . esc_url($app_store) . '" class="btn app-download-button1">
                                  <span class="app-store-btn1"> <i class="fa fa-apple"></i>
                                    <span> 
                                      <span>' . __('Get It On', 'adforest') . '</span>
                                      <span>' . __('Apple Store ', 'adforest') . '</span>
                                    </span>
                                  </span>
                                  </a>
                                  <!-- /Apple Store --> 
                              </div>';
        }
        $google_store_html = '';
        if (isset($google_store) && $google_store != '') {
            $google_store_html = '<div class="and-div padding-top-20"> 
                                    <!-- Google Store --> 
                                    <a href="' . esc_url($google_store) . '" title="Google Store" class="btn app-download-button1">
                                        <span class="app-store-btn1"> <i class="fa fa-play"></i> 
                                        <span>
                                           <span>' . __('Get It On', 'adforest') . '</span>
                                           <span>' . __('Google Store', 'adforest') . '</span>
                                        </span> 
                                        </span>
                                    </a> 
                                    <!-- /Google Store --> 
                                  </div>';
        }


        $heading_2_html = '';
        if (isset($call_app_img_src) && $call_app_img_src != '') {
            $call_app_img_src = '<div class="col-xs-12 col-sm-6 col-md-6">
                                   <div class="mobi-2"> <img src="'.esc_url($call_app_img_src).'" class="img-responsive" alt="'.__('Call to Action Image','adforest').'"> </div>
                                 </div>';
        }

        
        $html = '';
        $html .= '<div class="adf-sec-eight-11">
                    <section class="down-mobile-11 custom-padding parallex">
                      <div class="container">
                        <div class="row margin-bottom-30">
                          <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="hading">
                              ' . $heading_1_html . '
                              ' . $heading_2_html . '
                              <div class="clearfix"></div>
                              <p class="margin-top-10">' . adforest_returnEcho($content) . '</p>
                            </div>
                            <div class="col-xs12 col-sm-12 col-md-12 no-padding ">
                              ' . $app_store_html . '
                              ' . $google_store_html . '
                            </div>
                          </div>
                          '.$call_app_img_src.'
                        </div>
                      </div>
                    </section>
                  </div>';




        return $html;
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('directory_callto_action_2', 'adforest_directory_callto_action_2_func');
}