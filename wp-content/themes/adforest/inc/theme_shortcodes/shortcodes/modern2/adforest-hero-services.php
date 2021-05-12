<?php
/* ------------------------------------------------ */
/* services */
/* ------------------------------------------------ */
add_action('vc_before_init', 'adforest_hero_services_shortcode');
if (!function_exists('adforest_hero_services_shortcode')) {

    function adforest_hero_services_shortcode() {
        vc_map(array(
            'name' => __('Hero - Services Banner', 'adforest'),
            'description' => '',
            'base' => 'adforest_hero_services',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('hero-services.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("Banner Title", "adforest"),
                    "param_name" => "banner_title",
                    "value" => '',
                    "description" => '',
                    'group' => __('Basic', 'adforest'),
                ),
                array(
                    "type" => "textarea",
                    "class" => "",
                    "heading" => __("Banner Description", "adforest"),
                    "param_name" => "banner_description",
                    "value" => '',
                    "description" => __("Enter banner description here .", "adforest"),
                    'group' => __('Basic', 'adforest'),
                ),
                array(
                    "type" => "attach_image",
                    "class" => "",
                    "heading" => __("Banner Background Image", "adforest"),
                    "param_name" => "banner_bg_image",
                    "value" => '',
                    "description" => __("Add an image of banner background : Recommended size (1920x850)", "adforest"),
                    'group' => __('Basic', 'adforest'),
                ),
                array(
                    "type" => "attach_image",
                    "class" => "",
                    "heading" => __("Banner Image", "adforest"),
                    "param_name" => "banner_image",
                    "value" => '',
                    "description" => __("Add an image of banner that will apply at the bottom of banner descrpition.: Recommended size (1079x187)", "adforest"),
                    'group' => __('Basic', 'adforest'),
                ),
            )
        ));
    }

}

if (!function_exists('adforest_hero_services_callback')) {

    function adforest_hero_services_callback($atts, $content = '') {
        extract(
                shortcode_atts(
                        array(
            'banner_title' => '',
            'banner_description' => '',
            'banner_bg_image' => '',
            'banner_image' => '',
                        ), $atts)
        );
         $banner_image = adforest_returnImgSrc($banner_image);
         $banner_bg_image = adforest_returnImgSrc($banner_bg_image);
         
        
        $bg_style = ' style="background: url('.esc_url($banner_bg_image).') !important;"';
        
        
        

        $html = '';
        $html .= '<section class="srvs-hero-section"'.($bg_style).'>
                    <div class="container">
                      <div class="row">
                        <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                          <div class="srvs-hero-content-area">
                            <div class="srvs-hero-text-section">
                              <h1>'.esc_html($banner_title).'</h1>
                            </div>
                            <div class="srvs-hero-img"> <img src="'.get_template_directory_uri().'/images/gty.png" alt="'.esc_html__('Heading seperator image','adforest').'" class="img-responsive"> </div>
                            <div class="srvs-hero-details">
                              <p>'.esc_html($banner_description).'</p>
                            </div>
                          </div>
                          <div class="srvs-hero-workers"> <img src="'.esc_url($banner_image).'" alt="'.esc_html__('Banner image','adforest').'" class="img-responsive"> </div>
                        </div>
                      </div>
                    </div>
                  </section>';


        return $html;
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('adforest_hero_services', 'adforest_hero_services_callback');
}