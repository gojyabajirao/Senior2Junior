<?php global $adforest_theme; ?>
<?php
$author_id = get_query_var('author');
$author = get_user_by('ID', $author_id);
$user_pic = adforest_get_user_dp($author_id, 'adforest-user-profile');
?>
<section class="seller-public-profile padding-top-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <?php
                require trailingslashit(get_template_directory()) . 'template-parts/layouts/profile/profile-header.php';
                if (get_user_meta($author_id, '_sb_user_intro', true) != "") {
                    ?>
                    <div class="seller-description-area">
                        <div class="seller-description-reviews-heading">
                            <div class="heading-panel">
                                <h3 class="main-title text-left"><?php echo __('Introduction', 'adforest'); ?></h3>
                            </div>
                        </div>
                        <div class="seller-product-area-texts"><?php echo get_user_meta($author_id, '_sb_user_intro', true); ?></div>
                    </div>
                    <?php
                }
                ?>
                <div class="seller-product-trigger margin-top-20">
                    <div class="heading-panel">
                        <h3 class="main-title text-left"><?php echo __('Ad(s) posted by', 'adforest'); ?>
                            <span class="showed"><?php echo " " . $author->display_name; ?></span>
                        </h3>
                    </div>
                </div>
                <div class="grid-card">
                    <?php
                    if (have_posts() > 0 && in_array('sb_framework/index.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                        while (have_posts()) {

                            the_post();
                            $pid = get_the_ID();
                            $ad = new ads();
                            echo adforest_returnEcho($ad->adforest_search_layout_list_2($pid));
                            ?>
                            <?php
                        }
                    } else {
                        echo __('No record found.', 'adforest');
                    }
                    ?>
                    <div class="clearfix"></div>
                    <div class="text-center">
                        <?php adforest_pagination(); ?>
                    </div>

                </div>

            </div>
            <div class="col-lg-4">
                <div class="seller-public-profile-left-section">
                    <?php
                    require trailingslashit(get_template_directory()) . 'template-parts/layouts/profile/contact_form.php';
                    ?>

                </div>
            </div>
        </div>
    </div>
</section>