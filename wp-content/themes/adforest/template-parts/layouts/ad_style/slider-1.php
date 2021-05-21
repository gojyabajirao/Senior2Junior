<div class="flexslider single-page-slider">
    <div class="flex-viewport">
        <ul class="slides slide-main gallery">
            <?php
            global $adforest_theme;
            $ad_id = get_the_ID();
            $media = adforest_get_ad_images(get_the_ID());

            $disable_optimize_img = isset($adforest_theme['sb_optimize_img_switch']) && $adforest_theme['sb_optimize_img_switch'] ? TRUE : FALSE;


            $title = get_the_title();
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
                    <li class="">
                        <div>
                            <a href="<?php echo esc_url($full_img[0]);?>" data-caption="<?php echo esc_attr($title);?>" data-fancybox="group">     
                                <img alt="<?php echo esc_attr($title);?>" src="<?php echo esc_url($slider_img);?>">

                            </a>
                        </div>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
    </div>
</div>
<!-- Listing Slider Thumb --> 
<div class="flexslider" id="carousels">
    <div class="flex-viewport">
        <ul class="slides slide-thumbnail">
            <?php
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;

                    $img = wp_get_attachment_image_src($mid, 'adforest-ad-thumb');
                    if ($img[0] == "")
                        continue;
                    ?>
                    <li><img alt="<?php echo esc_attr($title);?>" draggable="false" src="<?php echo esc_attr($img[0]);?>"></li>
                    <?php
                }
            }
            ?>

        </ul>
    </div>
</div>