<?php global $adforest_theme; ?>
<section class="new-footer-section sb-foot-6">
    <div class="border-bottom">
        <div class="container">
            <div class="row">
                <div class="new-footer-content">
                    <div class="col-lg-4 col-xs-12 col-md-3">
                        <div class="new-adforest-logo">
                            <a href="<?php echo home_url('/'); ?>">
                                <?php
                                if (isset($adforest_theme['footer_logo']['url']) && $adforest_theme['footer_logo']['url'] != "") {
                                    $logo_url = $adforest_theme['footer_logo']['url'];
                                    ?>
                                    <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr__('Site Logo', 'adforest'); ?>">
                                    <?php
                                } else {
                                    ?>
                                    <img src="<?php echo esc_url(trailingslashit(get_template_directory_uri())) . 'images/logo.png' ?>" alt="<?php echo esc_attr__('Site Logo', 'adforest'); ?>" />
                                    <?php
                                }
                                ?>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-8 col-xs-12 col-md-9">
                        <div class="footer-anchor-section">
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'footer_main_menu',
                                'items_wrap' => '<ul  class="list-inline"><li></li>%3$s</ul>'
								
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="footer-last-section">
                <div class="col-lg-7 col-xs-12 col-md-7">
                    <div class="new-footer-text-h1">
                        <?php
                        if (isset($adforest_theme['sb_footer']) && $adforest_theme['sb_footer'] != "") {
                            echo wp_kses($adforest_theme['sb_footer'], adforest_required_tags());
                        }
                        ?>
                    </div>
                </div>
                <div class="col-lg-5 col-xs-12 col-md-5">
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
    </div>
</section>

