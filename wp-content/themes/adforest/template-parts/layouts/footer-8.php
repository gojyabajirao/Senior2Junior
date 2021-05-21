<?php
global $adforest_theme;
$adforest_sidebars_col = isset($adforest_theme['sb_footer_cols']) && !empty($adforest_theme['sb_footer_cols']) ? $adforest_theme['sb_footer_cols'] : '';
$adforest_sidebars_switch = isset($adforest_theme['sb_footer_widget_switch']) && !empty($adforest_theme['sb_footer_widget_switch']) ? $adforest_theme['sb_footer_widget_switch'] : '';
?>


<?php if (isset($adforest_sidebars_switch) && empty($adforest_sidebars_switch)) { ?>
    <div class="mob-wrap-footer">
    <?php } ?>  
    <div class="mob-footer-section sb-foot-8">
        <footer> 
            <!-- Footer Content -->
            <div class="footer-top new-demo">

                <?php if (isset($adforest_sidebars_switch) && !empty($adforest_sidebars_switch) && isset($adforest_sidebars_col) && is_array($adforest_sidebars_col) && sizeof($adforest_sidebars_col) > 0) { ?>
                    <div class="container">
                        <div class="row">
                            <?php do_action('adforest_footer_sidebar_widgets'); ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="copyrights">
                    <div class="container">
                        <div class="copyright-content">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <?php
                                    if (isset($adforest_theme['sb_footer']) && $adforest_theme['sb_footer'] != "") {
                                        echo wp_kses($adforest_theme['sb_footer'], adforest_required_tags());
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Copyrights --> 
        </footer>
    </div>  
    <?php if (isset($adforest_sidebars_switch) && empty($adforest_sidebars_switch)) { ?>
    </div>
<?php } ?>  

