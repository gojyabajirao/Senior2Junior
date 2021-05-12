<?php
/* ------------------------------------------------ */
/* call_to_action_m2 */
/* ------------------------------------------------ */
add_action('vc_before_init', 'adforest_call_to_action_m2_shortcode');
if (!function_exists('adforest_call_to_action_m2_shortcode')) {

    function adforest_call_to_action_m2_shortcode() {
        vc_map(array(
            'name' => __('Call To Action', 'adforest'),
            'description' => '',
            'base' => 'call_to_action_m2',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('animal-call-to-action.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Title", 'adforest'),
                    "param_name" => "section_title",
                    "description" => __('For color ', 'adforest') . '<strong>' . esc_html('{color}') . '</strong>' . __('warp text within this tag', 'adforest') . '<strong>' . esc_html('{/color}') . '</strong>',
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Description", 'adforest'),
                    "param_name" => "section_description",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
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
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "attach_image",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Image", 'adforest'),
                    "param_name" => "section_img",
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
                    'type' => 'dropdown',
                    'holder' => 'div',
                    'class' => '',
                    'admin_label' => true,
                    'heading' => __('Image Position', 'adforest'),
                    'param_name' => 'image_pos',
                    'value' => array(__('Select Option', 'adforest') => "", __('Left', 'adforest') => "left", __('Right', 'adforest') => "right"),
                ),
            )
        ));
    }

}

if (!function_exists('adforest_call_to_action_m2_func')) {

    function adforest_call_to_action_m2_func($atts, $content = '') {
        extract(shortcode_atts(
                        array(
            'section_title' => '',
            'section_description' => '',
            'btn_1' => '',
            'btn_2' => '',
            'section_img' => '',
            'section_bg' => '',
            'image_pos' => '',
                        ), $atts));


        $section_title = adforest_color_text($section_title);

        $section_img = ( isset($section_img) ) ? adforest_returnImgSrc($section_img) : '';

        $btn_1 = adforest_ThemeBtn($btn_1, 'btn btn-theme', false);
        $btn_2 = adforest_ThemeBtn($btn_2, 'btn btn-theme', false);
        $section_bg_class = ( $section_bg == 'gray' ) ? 'gray' : '';

        $image_side = ($image_pos == "left") ? "left" : 'right';
        $image_html_left = $image_html_right = "";
        $image_html = '<div class="col-lg-6 col-xs-12 col-md-6 col-sm-12"><div class="call-images-section"> <img src="' . esc_url($section_img) . '" alt="' . esc_attr($section_title) . '" class="img-responsive"> </div> </div>';
        $image_html_right = $image_html;
        if ($image_side == 'left') {
            $image_html_left = $image_html_right = "";
            $image_html_left = $image_html;
        }

        return '<section class="call-to-action ' . $section_bg_class . '">
  <div class="container">
    <div class="row">
	  ' . $image_html_left . '
      <div class="col-lg-6 col-xs-12 col-md-6 col-sm-12">
        <div class="call-heading-section">
          <h4>' . $section_title . '</h4>
        </div>
        <div class="call-main-section">
          <div class="call-text-section">
            <p class="text-format">' . $section_description . '</p>
          </div>
          <div class="call-all-categories">
            <div class="call-post-categories">' . $btn_1 . '</div>
            <div class="call-read-categories">' . $btn_2 . '</div>
          </div>
        </div>
      </div>' . $image_html_right . '
      </div>
  </div>
</section>';
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('call_to_action_m2', 'adforest_call_to_action_m2_func');
}