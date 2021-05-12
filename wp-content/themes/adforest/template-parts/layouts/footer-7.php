<?php
global $adforest_theme;
$footer_color = isset($adforest_theme['footer-color']) && !empty($adforest_theme['footer-color']) ? $adforest_theme['footer-color'] : '#FFFFFF';
$footer_options = isset($adforest_theme['footer_options']) && !empty($adforest_theme['footer_options']) ? $adforest_theme['footer_options'] : '';
$footer_bg = isset($adforest_theme['footer_bg']) && !empty($adforest_theme['footer_bg']) ? $adforest_theme['footer_bg'] : '';
$bg_footer = '';
if ($footer_options == 'with_bg' && !empty($footer_bg)) {
    $bg_footer = ' style="background: url(' . $footer_bg['url'] . ')"';
}

$color_footer = ' style="color:' . $footer_color . ' !important"';
?>

<section class="custom-padding prop-footer-section sb-foot-7"<?php echo adforest_returnEcho($bg_footer); ?>>

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-xs-12 col-sm-3 col-md-3">
                <div class="prop-footer-logo"> 
                    <a href="<?php echo home_url('/'); ?>">
                        <?php
                        if (isset($adforest_theme['footer_logo']['url']) && $adforest_theme['footer_logo']['url'] != "") {
                            $logo_url = $adforest_theme['footer_logo']['url'];
                            ?>
                            <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr__('Site Logo', 'adforest'); ?>" class="img-responsive">
                            <?php
                        } else {
                            ?>
                            <img  class="img-responsive" src="<?php echo esc_url(trailingslashit(get_template_directory_uri())) . 'images/logo.png' ?>" alt="<?php echo esc_attr__('Site Logo', 'adforest'); ?>" />
                            <?php
                        }
                        ?>
                    </a> 
                </div>
            </div>
            <div class="col-lg-9 col-xs-12 col-md-9 col-sm-9">
                <div class="prop-footer-categories">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer_main_menu',
                        'items_wrap' => '<ul  class="list-inline prop-footer-content"><li></li>%3$s</ul>'
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="prop-footer-content-area"></div>

    <div class="container">
        <div class="row">

            <div class="col-lg-6 col-xs-12 col-md-6 col-sm-6">
                <div class="prop-footer-cr"<?php echo adforest_returnEcho($color_footer); ?>>

                    <?php
                    if (isset($adforest_theme['sb_footer']) && $adforest_theme['sb_footer'] != "") {
                        echo wp_kses($adforest_theme['sb_footer'], adforest_required_tags());
                    }
                    ?>
                </div>

            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="new-social-icons">
                    <ul class="list-inline">
                        <?php
                        foreach ($adforest_theme['social_media'] as $index => $val) {
                            ?>
                            <?php
                            if ($val != "") {
                                ?>
                                <li>
                                    <a <?php do_action('adforest_relation_follow_links');?>href="<?php echo esc_url($val); ?>">
                                        <i class="<?php echo adforest_social_icons($index); ?>"></i>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</section>
<?php

function adforest_footer_colors() {
    global $adforest_theme;
    $footer_color = isset($adforest_theme['footer-color']) && !empty($adforest_theme['footer-color']) ? $adforest_theme['footer-color'] : '#FFFFFF';
    ?>
    <style>
        .prop-footer-cr p, .prop-footer-section .prop-footer-content li a{color:<?php echo adforest_returnEcho($footer_color); ?> !important;}
    </style>    
    <?php
}

add_action('wp_footer', 'adforest_footer_colors', 100);
