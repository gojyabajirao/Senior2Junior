<?php
/* ------------------------------------------------ */
/* Adforest Services */
/* ------------------------------------------------ */
add_action('vc_before_init', 'adforest_sales_shortcode');
if (!function_exists('adforest_sales_shortcode')) {

    function adforest_sales_shortcode() {
        vc_map(array(
            'name' => __('Adforest Sales', 'adforest'),
            'description' => '',
            'base' => 'adforest_sales',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('adforest-sales.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    'group' => __('Sale Data', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Add Services', 'adforest'),
                    'param_name' => 'sales',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => __("Size", 'adforest'),
                            "param_name" => "sale_size",
                            "admin_label" => true,
                            "value" => array(
                                __('Grid', 'adforest') => 'grid',
                                __('Wide', 'adforest') => 'wide',
                            ),
                            'dependency' => array('element' => 'sidebar_settings', 'value' => array('side_ads')),
                        ),
                        array(
                            "type" => "attach_image",
                            "class" => "",
                            "heading" => __("Background Image", "adforest"),
                            "param_name" => "sale_grid_bg",
                            "value" => '',
                            "description" => __("Add an image of Background : Recommended size (270x200)", "adforest"),
                            'dependency' => array('element' => 'sale_size', 'value' => array('grid')),
                        ),
                        array(
                            "type" => "attach_image",
                            "class" => "",
                            "heading" => __("Sale Image", "adforest"),
                            "param_name" => "sale_grid_img",
                            "value" => '',
                            "description" => __("Add an image of sale : Recommended size (108 X 103)", "adforest"),
                            'dependency' => array('element' => 'sale_size', 'value' => array('grid')),
                        ),
                        array(
                            "type" => "attach_image",
                            "class" => "",
                            "heading" => __("Background Image", "adforest"),
                            "param_name" => "sale_wide_bg",
                            "value" => '',
                            "description" => __("Add an image of Background : Recommended size (570x200)", "adforest"),
                            'dependency' => array('element' => 'sale_size', 'value' => array('wide')),
                        ),
                        array(
                            "type" => "attach_image",
                            "class" => "",
                            "heading" => __("Sale Image", "adforest"),
                            "param_name" => "sale_wide_img",
                            "value" => '',
                            "description" => __("Add an image of sale : Recommended size (246 X 182)", "adforest"),
                            'dependency' => array('element' => 'sale_size', 'value' => array('wide')),
                        ),
                        array(
                            "type" => "textfield",
                            "class" => "",
                            "heading" => __("Sale Title", "adforest"),
                            "param_name" => "sale_title",
                            "value" => '',
                            "description" => '',
                        ),
                        array(
                            "type" => "vc_link",
                            "heading" => __("Sale Link", 'adforest'),
                            "param_name" => "sale_link",
                            "description" => '',
                        ),
                    ),
                ),
            )
        ));
    }

}

if (!function_exists('adforest_sales_callback')) {

    function adforest_sales_callback($atts, $content = '') {
        extract(
                shortcode_atts(
                        array(
            'sales' => '',
                        ), $atts)
        );
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        $sales_arr = vc_param_group_parse_atts($atts['sales']);

        $sales_html = '';
        if (isset($sales_arr) && !empty($sales_arr) && is_array($sales_arr) && sizeof($sales_arr) > 0) {
            foreach ($sales_arr as $sale) {
                $sale_size = isset($sale['sale_size']) ? $sale['sale_size'] : 'grid';
                
                
                
                $sale_title = isset($sale['sale_title']) ? $sale['sale_title'] : '';
                $sale_link_data = isset($sale['sale_link']) ? $sale['sale_link'] : '';
                $sale_link_html = adforest_ThemeBtn($sale_link_data, 'btn btn-theme', false);
                
                
                if($sale_size == 'grid'){
                    $sale_grid_bg_id = isset($sale['sale_grid_bg']) ? $sale['sale_grid_bg'] : '';
                    $sale_grid_img_id = isset($sale['sale_grid_img']) ? $sale['sale_grid_img'] : '';
                    $sale_grid_bg = adforest_returnImgSrc($sale_grid_bg_id);
                    $sale_grid_img = adforest_returnImgSrc($sale_grid_img_id);
                    $sm_col = 4;
                    if(is_rtl()){
                       $sm_col = 6;
                    }
                    $sales_html .='<div class="col-lg-3 col-xs-12 col-sm-'.$sm_col.' col-md-3">
                                    <div class="toys-es-sale">
                                        <img src="'.esc_url($sale_grid_bg).'" alt="'.esc_html__('sale background image','adforest').'" class="img-responsive">
                                        <div class="toys-es-text grid">
                                            <h4>'.esc_html($sale_title).'</h4>
                                        </div>
                                        <div class="toys-ex-categories">
                                            <img src="'.esc_url($sale_grid_img).'" alt="'.esc_html__('sale image','adforest').'" class="img-responsive">
                                        </div>
                                        <div class="toys-ex-shops">
                                            '.$sale_link_html.'
                                        </div>
                                    </div>
                                </div>';
                    
                }else{
                   $sale_wide_bg_id = isset($sale['sale_wide_bg']) ? $sale['sale_wide_bg'] : '';
                    $sale_wide_img_id = isset($sale['sale_wide_img']) ? $sale['sale_wide_img'] : '';
                    $sale_wide_bg = adforest_returnImgSrc($sale_wide_bg_id);
                    $sale_wide_img = adforest_returnImgSrc($sale_wide_img_id);
                    $sm_col = 8;
                    if(is_rtl()){
                       $sm_col = 12;
                    }
                    $sales_html .='<div class="col-lg-6 col-xs-12 col-sm-'.$sm_col.' col-md-6">
                                    <div class="toys-es-img">
                                        <img src="'.esc_url($sale_wide_bg).'" alt="'.esc_html__('sale background image','adforest').'" class="img-responsive">
                                        <div class="toys-es-text wide">
                                            <h4>'.esc_html($sale_title).'</h4>
                                        </div>
                                        <div class="toys-ex-categories">
                                            <img src="'.esc_url($sale_wide_img).'" alt="'.esc_html__('sale image','adforest').'" class="img-responsive">
                                        </div>
                                        <div class="toys-ex-shops">
                                            '.$sale_link_html.'
                                        </div>
                                    </div>
                                </div>';
                }
                
                
                
            }
        }

        $html = '';
        $html .= '<section class="toys-biggest-sale">
                    <div class="container">
                        <div class="row">
                        '.$sales_html.'
                        </div>
                    </div>
                </section>';

        return $html;
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('adforest_sales', 'adforest_sales_callback');
}