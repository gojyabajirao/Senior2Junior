<div class="owl-carousel owl-theme single-details gallery">
    <?php
    global $adforest_theme;
    $ad_id = get_the_ID();
    $media = adforest_get_ad_images(get_the_ID());
    $title = get_the_title();
    $disable_optimize_img = isset($adforest_theme['sb_optimize_img_switch']) && $adforest_theme['sb_optimize_img_switch'] ? TRUE : FALSE;
    if (count($media) > 0) {
        foreach ($media as $m) {
            $mid = '';
            if (isset($m->ID))
                $mid = $m->ID;
            else
                $mid = $m;

            $img = wp_get_attachment_image_src($mid, 'adforest-single-post');
            $full_img = wp_get_attachment_image_src($mid, 'full');
            if ($img[0] == "") {
                continue;
            }
            $slider_img = $img[0];
            if ($disable_optimize_img) {
                $slider_img = $full_img[0];
            }
            ?>
            <div class="item">
                <div>
                    <a href="<?php echo esc_url($full_img[0]);?>" data-caption="<?php echo esc_attr($title);?>" data-fancybox="">    
                        <img alt="<?php echo esc_attr($title);?>" src="<?php echo esc_url($slider_img);?>">

                    </a>
                </div>
            </div>

            <?php
        }
    }
    ?>
</div>