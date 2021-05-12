<?php global $adforest_theme; ?>

<section class="pets-footer-section pets-footer-section-2 sb-foot-9">
    <div class="container">
        <div class="row">
            <div class="footer-content-area">
                <div class="col-lg-4 col-xs-12 col-sm-6 col-md-4">
                    <div class="pets-footer-main-section">
                        <div class="pets-adforest-logo">
                            <a href="<?php echo home_url('/'); ?>">
                                <?php
                                if (isset($adforest_theme['footer_logo']['url']) && $adforest_theme['footer_logo']['url'] != "") {
                                    ?>
                                    <img class="img-responsive" src="<?php echo esc_url($adforest_theme['footer_logo']['url']); ?>"  alt="<?php echo esc_attr__('Site Logo', 'adforest'); ?>">
                                    <?php
                                } else {
                                    ?>
                                    <img class="img-responsive" src="<?php echo esc_url(trailingslashit(get_template_directory_uri())) . 'images/logo.png' ?>" alt="<?php echo esc_attr__('Site Logo', 'adforest'); ?>" />
                                    <?php
                                }
                                ?> 
                            </a>
                        </div>
                        <div class="pets-footer-text-section">
                            <p><?php echo esc_html($adforest_theme['footer_text_under_logo']); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-12 col-md-4 col-sm-6">
                    <div class="pets-new-categories">
                        <div class="footer-title"><?php echo __('Categories','adforest');?></div>
                    </div>
                    <div class="pets-all-categories">
                        <ul class="animals-top-categories">
                            <?php
                            if (isset($adforest_theme['sb_footer_cats']) && !empty($adforest_theme['sb_footer_cats'])) {
                                foreach ($adforest_theme['sb_footer_cats'] as $foot_page) {
                                    $cat = get_term_by('id', $foot_page, 'ad_cats', 'OBJECT');
                                    if (isset($cat) && !empty($cat) && is_object($cat)) {
                                        echo '<li><a href="' . get_term_link($cat->term_id) . '">' . esc_html($cat->name) . '</a></li>';
                                    }
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-12 col-md-4 col-sm6">
                    <div class="pets-new-categories">
                         <div class="footer-title"><?php echo esc_html($adforest_theme['section_3_title']); ?></div>
                    </div>
                    <div class="pets-footer-text-section-1">
                        <p><?php echo esc_html($adforest_theme['section_3_text']); ?></p>
                    </div>
                    <?php
                    if (isset($adforest_theme['section_3_mc']) && $adforest_theme['section_3_mc']) {
                        ?>
                        <form>
                            <div class="submit-form-section">
                                <div class="form-group">
                                    <input name="sb_email" id="sb_email" class="form-control" placeholder="<?php echo __('Enter your email address', 'adforest'); ?>" type="text" autocomplete="off">
                                </div>
                            </div>
                            <div class="submit-categories">
                                <button id="save_email" type="button" class="btn btn-primary btn-theme"><?php echo esc_html__('Submit', 'adforest'); ?></button>
                                 <button class="btn btn-primary btn-theme" id="processing_req" type="button"><i class="fa fa-spinner fa-spin"></i></button>
                            </div>
                           
                            <input type="hidden" id="sb_action" value="footer_action" />
                        </form>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-deails-section">
        <?php
        if (isset($adforest_theme['sb_footer']) && $adforest_theme['sb_footer'] != "") {
            echo wp_kses($adforest_theme['sb_footer'], adforest_required_tags());
        } else {
            echo wp_kses("Copyright 2017 &copy; Theme Created By <a href='https://themeforest.net/user/scriptsbundle/portfolio'>ScriptsBundle</a> All Rights Reserved.", adforest_required_tags());
        }
        ?>
    </div>
</section>
