<!doctype html>
<html <?php language_attributes(); ?> >
    <head>
        <?php global $adforest_theme; ?>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <?php
        if (isset($adforest_theme['header_js_and_css']) && $adforest_theme['header_js_and_css'] != "") {
            echo adforest_returnEcho($adforest_theme['header_js_and_css']);
        }
        $sb_body_class = '';
        if (isset($adforest_theme['design_type']) && $adforest_theme['design_type'] == 'modern' && isset($adforest_theme['sb_header']) && $adforest_theme['sb_header'] == 'transparent' && is_page_template('page-home.php')) {
            $sb_body_class = 'enable-transparent';
        }
        ?>
        <style id="adforest-custom-css"></style>
        <?php wp_head(); 
        
        $custom_switcher =  isset($adforest_theme['custom_theme_color_switch']) && $adforest_theme['custom_theme_color_switch'] ? $adforest_theme['custom_theme_color_switch'] : false;
        $cus_switch_class = '';
        if($custom_switcher){
            $cus_switch_class = ' custom-switcher';
        }
        ?>

    </head>
    <body <?php body_class($sb_body_class); ?>>
        <?php do_action('adforest_language_switcher');?>
        <?php if (isset($adforest_theme['sb_pre_loader']) && $adforest_theme['sb_pre_loader']) { ?><div id="loader-wrapper"><div id="loader"></div><div class="loader-section section-left"></div><div class="loader-section section-right"></div></div><?php } ?>
        <?php if (isset($adforest_theme['sb_color_plate']) && $adforest_theme['sb_color_plate']) { ?>
            <div class="color-switcher<?php echo esc_attr($cus_switch_class);?>" id="choose_color"><a href="javascript:void(0)" class="picker_close"><i class="fa fa-gear"></i></a><h5><?php echo __('Style Switcher', 'adforest'); ?></h5> <div class="theme-colours"><p> <?php echo __('Choose Colour style', 'adforest'); ?> </p>
                    <?php
                    if ($custom_switcher) {

                        $custom_theme_color = isset($adforest_theme['custom-theme-color']) && !empty($adforest_theme['custom-theme-color']) ? $adforest_theme['custom-theme-color'] : '#f58936';
                        $custom_btn_hover_color = isset($adforest_theme['custom-btn-hover-color']) && !empty($adforest_theme['custom-btn-hover-color']) ? $adforest_theme['custom-btn-hover-color'] : '#f58936';
                        $custom_btn_border_color = isset($adforest_theme['custom-btn-border-color']) && !empty($adforest_theme['custom-btn-border-color']) ? $adforest_theme['custom-btn-border-color'] : '#f58936';
                        ?>
                        <ul>
                            <li><label><?php echo esc_html__('Theme Color', 'adforest'); ?></label> <input value="<?php echo esc_attr($custom_theme_color);?>" type='text' id="theme-color" /> </li>
                            <li><label><?php echo esc_html__('Hover Color', 'adforest'); ?></label> <input value="<?php echo esc_attr($custom_btn_hover_color);?>" type='text' id="btn-hover-color" /> </li>
                            <li><label><?php echo esc_html__('Border Color', 'adforest'); ?></label> <input value="<?php echo esc_attr($custom_btn_border_color);?>" type='text' id="btn-border-color" /> </li>
                            <li class="color-test"><a href="#." class="custom-theme btn btn-theme" id="custom-theme" style="width: auto;; height: auto;;;"><?php echo esc_html__('Apply', 'adforest'); ?></a></li>
                        </ul>
                    <?php } else { ?>
                        <ul>
                            <li><a href="#." class="defualt" id="defualt"></a></li>
                            <li>   <a href="#." class="green" id="green"></a></li>
                            <li>   <a href="#." class="blue" id="blue"></a></li>
                            <li>   <a href="#." class="red" id="red"></a></li>
                            <li>   <a href="#." class="dark-red" id="dark-red"></a></li>
                            <li>   <a href="#." class="sea-green" id="sea-green"></a></li>
                        </ul>
                    <?php } ?>
                </div>
                <div class="clearfix">
                </div>
            </div>
        <?php } ?>
        <?php
        if (isset($adforest_theme['sb_comming_soon_mode']) && $adforest_theme['sb_comming_soon_mode']) {
            if (!current_user_can('administrator') && !is_admin()) {
                get_template_part('template-parts/layouts/coming', 'soon');
                exit;
            }
        }
        ?>
        <div class="loading" id="sb_loading"><?php __('Loading', 'adforest'); ?>&#8230;</div>