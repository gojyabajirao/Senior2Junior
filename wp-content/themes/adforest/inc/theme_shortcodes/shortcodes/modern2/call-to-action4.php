<?php
/* ------------------------------------------------ */
/* Call To Action - 4 */
/* ------------------------------------------------ */
add_action('vc_before_init', 'adforest_call_to_action_m4_shortcode');
if (!function_exists('adforest_call_to_action_m4_shortcode')) {

    function adforest_call_to_action_m4_shortcode() {
        vc_map(array(
            'name' => __('Call To Action - 4', 'adforest'),
            'description' => '',
            'base' => 'call_to_action_m4',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('call-to-action-4.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
                        __('Image', 'adforest') => 'img'
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                    "description" => __("Select background color.", 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => __("Background Image", 'adforest'),
                    "param_name" => "bg_img",
                    'dependency' => array(
                        'element' => 'section_bg',
                        'value' => array('img'),
                    ),
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
                    "group" => __("Basic", "adforest"),
                    'type' => 'vc_link',
                    'holder' => 'div',
                    'class' => '',
                    'admin_label' => true,
                    'heading' => __('Button 1', 'adforest'),
                    'param_name' => 'btn_1',
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    'type' => 'vc_link',
                    'holder' => 'div',
                    'class' => '',
                    'admin_label' => true,
                    'heading' => __('Button 2', 'adforest'),
                    'param_name' => 'btn_2',
                ),
                
            )
        ));
    }

}

if (!function_exists('adforest_call_to_action_m4_func')) {

    function adforest_call_to_action_m4_func($atts, $content = '') {
        extract(shortcode_atts(
                        array(
            'heading_1' => '',
            'heading_2' => '',
            'btn_1' => '',
            'btn_2' => '',
            
                        ), $atts));
        
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        
        
        
        
        
        $btn_1 = adforest_ThemeBtn($btn_1, 'btn-theme', false);
        $btn_2 = adforest_ThemeBtn($btn_2, 'btn-theme', false);
        $html = '';
        $html .= '<section class="prop-call-to-action custom-padding' . $bg_color . '" ' . $style . '>
                    <div class="container">
                      <div class="row">
                        <div class="prop-content-to-action">
                          <div class="prop-action-text-area">
                            <h4>' . esc_html($heading_1) . '</h4>
                            <h3>' . esc_html($heading_2) . '</h3>
                          </div>
                          <div class="prop-action-submit-area">
                            <ul class="list-inline prop-list">
                              <li>' . ($btn_1) . '</li>
                              <li class="prop-action-preview">' . ($btn_2) . '</li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </section>';
        return $html;
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('call_to_action_m4', 'adforest_call_to_action_m4_func');
}