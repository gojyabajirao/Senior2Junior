<?php
global $adforest_theme;
$pid = get_the_ID();
if ($adforest_theme['share_ads_on']) {
    $flip_it = 'text-left';
    if (is_rtl()) {
        $flip_it = 'text-right';
    }
    ?>
    <!-- =-=-=-=-=-=-= Share Modal =-=-=-=-=-=-= -->
    <div class="modal fade share-ad" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content <?php echo esc_attr($flip_it); ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&#10005;</span><span class="sr-only">Close</span></button>
                    <div class="modal-title"><?php echo __('Share', 'adforest'); ?></div>
                </div>
                <div class="modal-body <?php echo esc_attr($flip_it); ?>">
                    <div class="recent-ads">
                        <div class="recent-ads-list">
                            <div class="recent-ads-container">
                                <div class="recent-ads-list-image">
                                    <?php
                                    $media = adforest_get_ad_images($pid);
                                    $img = adforest_get_ad_default_image_url('adforest-ad-related');
                                    if (count($media) > 0) {
                                        foreach ($media as $m) {
                                            $mid = '';
                                            if (isset($m->ID))
                                                $mid = $m->ID;
                                            else
                                                $mid = $m;

                                            $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                                            $img = $image[0];
                                            break;
                                        }
                                        ?>
                                        <a href="javascript:void(0);" class="recent-ads-list-image-inner">
                                            <img  src="<?php echo esc_url($img); ?>" alt="<?php echo get_the_title(); ?>"> 
                                        </a><!-- /.recent-ads-list-image-inner -->
                                        <?php
                                    }
                                    ?>
                                </div>
                                <!-- /.recent-ads-list-image -->
                                <div class="recent-ads-list-content">
                                    <h3 class="recent-ads-list-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <div class="recent-ads-list-price">
                                        <?php echo adforest_adPrice($pid); ?>
                                    </div>
                                    <p><?php echo adforest_words_count(get_the_excerpt(get_the_ID()), 250); ?></p>

                                    <!-- /.recent-ads-list-price -->
                                </div>
                                <!-- /.recent-ads-list-content -->
                            </div>
                            <!-- /.recent-ads-container -->
                        </div>
                    </div>
                    <div class="share-link"><?php echo __('Link', 'adforest'); ?></div>
                    <p><a href="javascript:void(0);"><?php the_permalink(); ?></a></p>
                </div>
                <div class="modal-footer">
                    <?php echo adforest_social_share(); ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>