<?php
/* ------------------------------------------------ */
/* Call To Action - 4 */
/* ------------------------------------------------ */
add_action('vc_before_init', 'adforest_call_to_action_toy_shortcode');
if (!function_exists('adforest_call_to_action_toy_shortcode')) {

    function adforest_call_to_action_toy_shortcode() {
        vc_map(array(
            'name' => __('Call To Action - Toy', 'adforest'),
            'description' => '',
            'base' => 'call_to_action_toy',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('call-to-action-toy.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "heading" => __("Title", 'adforest'),
                    "param_name" => "toy_title",
                    "description" => '',
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Description", 'adforest'),
                    "param_name" => "toy_description",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    'type' => 'vc_link',
                    'holder' => 'div',
                    'class' => '',
                    'admin_label' => true,
                    'heading' => __('Button Link', 'adforest'),
                    'param_name' => 'toy_link',
                ),
                array(
                    "group" => __("Images", "adforest"),
                    "type" => "attach_image",
                    "class" => "",
                    "heading" => __("Image 1", "adforest"),
                    "param_name" => "image_1",
                    "value" => '',
                    "description" => __("Add an image of service : Recommended size (246x448)", "adforest")
                ),
                array(
                    "group" => __("Images", "adforest"),
                    "type" => "attach_image",
                    "class" => "",
                    "heading" => __("Image 2", "adforest"),
                    "param_name" => "image_2",
                    "value" => '',
                    "description" => __("Add an image of service : Recommended size (621x512)", "adforest")
                ),
            )
        ));
    }

}

if (!function_exists('adforest_call_to_action_toy_func')) {

    function adforest_call_to_action_toy_func($atts, $content = '') {
        extract(shortcode_atts(
                        array(
            'toy_title' => '',
            'toy_description' => '',
            'toy_link' => '',
            'image_1' => '',
            'image_2' => '',
                        ), $atts));

        $toy_link = adforest_ThemeBtn($toy_link, 'btn btn-theme', false);


        $image_1_id = isset($image_1) ? $image_1 : '';
        $image_2_id = isset($image_2) ? $image_2 : '';
        
        $toy_title = isset($toy_title) ? $toy_title : '';
        $toy_description = isset($toy_description) ? $toy_description : '';
        

        $image_1_src = adforest_returnImgSrc($image_1_id);
        $image_2_src = adforest_returnImgSrc($image_2_id);

        $html = '';
        $html .= '<section class="toys-call-to-action no-extra">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                                <div class="col-lg-6 col-sm-5 col-md-6 col-xs-12">
                                    <div class="toys-action-main-content">
                                        <div class="toys-action-text">
                                            <h3>'.esc_html($toy_title).'</h3>
                                            <p>'.esc_html($toy_description).'</p>
                                        </div>
                                        <div class="toys-action-shop">
                                            '.($toy_link).'
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xs-12 col-sm-7 col-md-6">
                                    <div class="toys-action-img">
                                       <img src="'.esc_url($image_2_src).'" alt="'.esc_html__('Call to action image','adforest').'" class="img-responsive">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="toys-latest-products">
                        <img src="'.esc_url($image_1_src).'" alt="'.esc_html__('Call to action image','adforest').'" class="img-responsive">
                    </div>
                </section>';
        return $html;
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('call_to_action_toy', 'adforest_call_to_action_toy_func');
}