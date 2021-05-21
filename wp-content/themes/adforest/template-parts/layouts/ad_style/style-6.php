<?php
global $adforest_theme;
$pid = get_the_ID();
$poster_id = get_post_field('post_author', $pid);
$user_pic = adforest_get_user_dp($poster_id, 'adforest-single-small-50');
$address = get_post_meta($pid, '_adforest_ad_location', true);
$type = $adforest_theme['cat_and_location'];
wp_enqueue_script('lightslider');
$ad_layout_style_modern = isset($adforest_theme['ad_layout_style_modern']) ? $adforest_theme['ad_layout_style_modern'] : '3';
$sb_style_4_bg = isset($adforest_theme['sb_style_4_bg']) && !empty($adforest_theme['sb_style_4_bg']) ? $adforest_theme['sb_style_4_bg']['url'] : trailingslashit(get_template_directory_uri()) . 'images/var.png';
$style = ' style="background: url(' . $sb_style_4_bg . ');" ';
$disable_optimize_img = isset($adforest_theme['sb_optimize_img_switch']) && $adforest_theme['sb_optimize_img_switch'] ? TRUE : FALSE;
wp_enqueue_style('adforest-perfect-scrollbar');
wp_enqueue_script('adforest-perfect-scrollbar');
?>

<section class="des-hero"<?php echo adforest_returnEcho($style);?>>
    <div class="container">

        <div class="row">
            <div class="col-lg-8 col-sm-12 col-xs-12 col-md-12">
                <div class="des-hero-main-content"> 
                    <?php
                    if ($adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'phone') {
                        $call_now = 'javascript:void(0);';
                        if (wp_is_mobile())
                            $call_now = 'tel:' . adforest_get_CallAbleNumber(get_post_meta($pid, '_adforest_poster_contact', true));

                        $contact_num = get_post_meta($pid, '_adforest_poster_contact', true);
                        $batch_text = '';
                        if (isset($adforest_theme['sb_phone_verification']) && $adforest_theme['sb_phone_verification']) {
                            $contact_num = get_user_meta($poster_id, '_sb_contact', true);
                            if ($contact_num != "") {
                                if (get_user_meta($poster_id, '_sb_is_ph_verified', true) == '1') {
                                    $batch_text = __('Verified', 'adforest');
                                } else {
                                    $batch_text = __('Not verified', 'adforest');
                                }
                            } else {
                                $contact_num = get_post_meta($pid, '_adforest_poster_contact', true);
                                $batch_text = __('Not verified', 'adforest');
                            }
                        }
                        if ($contact_num != "") {
                            if (adforest_showPhone_to_users()) {
                                $contact_num = __("Login To View", "adforest");
                                $call_now = "javascript:void(0)";
                                $adforest_login_page = isset($adforest_theme['sb_sign_in_page']) ? $adforest_theme['sb_sign_in_page'] : '';
                                $adforest_login_page = apply_filters('adforest_language_page_id', $adforest_login_page);
                                if ($adforest_login_page != '') {

                                    $redirect_url = adforest_login_with_redirect_url_param(adforest_get_current_url());
                                    $call_now = $redirect_url;
                                }
                            }
                            ?>
                            <a href="<?php echo adforest_returnEcho($call_now);?>" class="btn btn-theme btn-style" id="show_ph_div" data-ph-num="<?php echo esc_attr($contact_num);?>">
                                <i class="fa fa-mobile-phone"></i>
                                <span id="show_ph_num"><?php echo __('Click To View', 'adforest');?></span>
                                <?php
                                if ($batch_text != "") {
                                    ?>
                                    <small class="sb-small">-<?php echo adforest_returnEcho($batch_text);?></small>
                                    <?php
                                }
                                ?>
                            </a>
                            <?php
                        }
                    }
                    ?>
                    <div class="des-hero-details">
                        <ul>
                            <?php
                            $post_categories = wp_get_object_terms($pid, array('ad_cats'), array('orderby' => 'term_group'));
                            foreach ($post_categories as $c) {
                                $cat = get_term($c);
                                if ($type == 'search') {
                                    $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
                                    $link = get_the_permalink($sb_search_page) . '?cat_id=' . $cat->term_id;
                                } else {
                                    $link = get_term_link($cat->term_id);
                                }
                                ?>
                                <li><a href="<?php echo esc_url($link);?>"><?php echo esc_html($cat->name);?></a></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="des-featured">
                        <ul>
                            <li>
                                <h1><?php the_title();?></h1>
                            </li>
                            <?php
                            $f_class = '';
                            if (get_post_meta($pid, '_adforest_is_feature', true) == '1' && get_post_meta($pid, '_adforest_ad_status_', true) == 'active') {
                                echo '<li> <span class="badge">' . __('Featured', 'adforest') . '</span> </li>';
                            }
                            ?>
                        </ul>
                    </div>

                    <div class="des-hero-adres">
                        <p><i class="fa fa-location-arrow"></i><?php echo get_post_meta($pid, '_adforest_ad_location', true);?></p>
                    </div>

                </div>
                <div class="des-us-details">
                    <ul>
                        <li><span><?php echo get_the_date();?></span> </li>
                        <li> <?php echo __('Views', 'adforest');?> <span> <b><?php echo adforest_getPostViews($pid);?></b> </span> </li>

                        <?php
                        if (get_post_field('post_author', $pid) == get_current_user_id() || is_super_admin(get_current_user_id())) {
                            $sb_post_ad_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_post_ad_page']);
                            $ad_update_url = adforest_set_url_param(get_the_permalink($sb_post_ad_page), 'id', $pid);
                            ?>
                            <li>
                                <a href="<?php echo esc_url($ad_update_url);?>"><?php echo __('Edit', 'adforest');?></a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <div class="des-price">
                    <ul>
                        <li>
                            <span>
                                <?php
                                if (get_post_meta($pid, '_adforest_ad_status_', true) != "" && get_post_meta($pid, '_adforest_ad_status_', true) == 'active') {
                                    ?>
                                    <?php
                                    if (get_post_meta($pid, '_adforest_ad_price_type', true) == "no_price" || ( get_post_meta($pid, '_adforest_ad_price', true) == "" && get_post_meta($pid, '_adforest_ad_price_type', true) != "free" && get_post_meta($pid, '_adforest_ad_price_type', true) != "on_call" )) {
                                        
                                    } else {
                                        ?>
                                        <?php echo adforest_adPrice($pid, 'negotiable-single');?>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                }
                                ?>
                            </span>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ad-gallery ad-style-6">
    <div class="container color-style">
        <div class="row">  
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="des-bar">
                    <ul>
                        <li> <a  class="page-scroll" href="#description"><i class="fa fa-star"></i><?php echo __('Description', 'adforest');?></a> </li>
                        <?php
                        if (isset($adforest_theme['sb_enable_comments_offer']) && $adforest_theme['sb_enable_comments_offer'] && get_post_meta($pid, '_adforest_ad_status_', true) != 'sold' && get_post_meta($pid, '_adforest_ad_status_', true) != 'expired' && get_post_meta($pid, '_adforest_ad_price', true) != "0") {
                            if (isset($adforest_theme['sb_enable_comments_offer_user']) && $adforest_theme['sb_enable_comments_offer_user'] && get_post_meta($pid, '_adforest_ad_bidding', true) == 1) {
                                echo '<li><a class="page-scroll" href="#bids"> <i class="fa fa-gavel"></i>' . __('Bids ', 'adforest') . '</a></li>';
                            } else if (isset($adforest_theme['sb_enable_comments_offer_user']) && $adforest_theme['sb_enable_comments_offer_user'] && get_post_meta($pid, '_adforest_ad_bidding', true) == 0) {
                                
                            } else {
                                echo '<li><a class="page-scroll" href="#bids"> <i class="fa fa-gavel"></i>' . __('Bids ', 'adforest') . ' </a></li>';
                            }
                            ?>

                            <?php
                        }
                        ?> 
                        <?php
                        if (get_post_meta($pid, '_adforest_ad_yvideo', true) != "") {
                            ?>
                            <li><a class="page-scroll" href="#video"><i class="fa fa-video-camera"></i> <?php echo __('Video', 'adforest');?></a></li>
                            <?php
                        }
                        ?>
                        <li><a class="page-scroll" href="#rating"> <i class="fa fa-gavel"></i><?php echo __('Rating', 'adforest');?> </a></li>
                        <?php
                        if (isset($adforest_theme['share_ads_on']) && $adforest_theme['share_ads_on']) {
                            ?>
                            <li>
                                <a data-toggle="modal" data-target=".share-ad">
                                    <i class="fa fa-share-alt"></i> <span class="hidetext"><?php echo __('Share', 'adforest');?></span>
                                </a>
                            </li>
                            <?php
                            get_template_part('template-parts/layouts/ad_style/share', 'ad');
                        }
                        ?>
                        <li >
                            <a href="javascript:void(0);" id="ad_to_fav" data-adid="<?php echo get_the_ID();?>">
                                <i class="fa fa-navicon"></i> <span class="hidetext"><?php echo __('Favourite', 'adforest');?></span>
                            </a>
                        </li>
                        <li>
                            <a data-target=".report-quote" data-toggle="modal">
                                <i class="fa fa-exclamation-triangle"></i><?php echo __('Report', 'adforest');?>
                            </a>
                        </li>

                    </ul>

                </div>
            </div>
            <?php
            get_template_part('template-parts/layouts/ad_style/report', 'ad');
            ?>

            <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 custom-style">
                <?php
                get_template_part('template-parts/layouts/ad_style/rearrange', 'notification');
                get_template_part('template-parts/layouts/ad_style/ad', 'status');
                get_template_part('template-parts/layouts/ad_style/feature', 'notification');
                ?>
                <div class="style-6-slider-area">
                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                        <div class="slider-style">
                            <ul id="imageGallery">
                                <?php
                                $ad_id = get_the_ID();
                                $media = adforest_get_ad_images(get_the_ID());
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
                                        $thumb_img = wp_get_attachment_image_src($mid, 'adforest-ad-thumb');



                                        if ($img[0] == "") {
                                            continue;
                                        }
                                        $slider_img = $img[0];
                                        if ($disable_optimize_img) {
                                            $slider_img = $full_img[0];
                                        }
                                        ?>
                                        <li data-thumb="<?php echo esc_url($thumb_img[0]);?>">
                                            <a href="<?php echo esc_url($full_img[0]);?>" data-caption="<?php echo esc_attr($title);?>" data-fancybox="group">  
                                                <img src="<?php echo esc_url($slider_img);?>" alt="<?php echo esc_attr($title);?>" /> 
                                            </a>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 col-md-12 col-xs-12">
                        <div class="ad-detils">
                            <ul>
                                <?php
//                                echo '<pre>';
//                                print_r(get_post_meta(67));
//                                echo '</pre>';


                                if (get_post_meta($pid, '_adforest_ad_price_type', true) == "no_price" || ( get_post_meta($pid, '_adforest_ad_price', true) == "" && get_post_meta($pid, '_adforest_ad_price_type', true) != "free" && get_post_meta($pid, '_adforest_ad_price_type', true) != "on_call" )) {
                                    
                                } else {
                                    ?>
                                    <li><?php echo __('Price', 'adforest');?>:<span><?php echo adforest_adPrice($pid);?> </span></li>
                                    <?php
                                }
                                ?>
                                <?php if (get_post_meta($pid, '_adforest_ad_type', true) != "") {?>

                                    <li><?php echo __('Type', 'adforest');?> :<span><?php echo get_post_meta($pid, '_adforest_ad_type', true);?></span></li>
                                    <?php
                                }
                                if (get_post_meta($pid, '_adforest_ad_condition', true) != "" && isset($adforest_theme['allow_tax_condition']) && $adforest_theme['allow_tax_condition']) {
                                    ?>

                                    <li><?php echo __('Condition', 'adforest');?> :<span><?php echo get_post_meta($pid, '_adforest_ad_condition', true);?></span></li>
                                    <?php
                                }
                                if (get_post_meta($pid, '_adforest_ad_warranty', true) != "" && isset($adforest_theme['allow_tax_warranty']) && $adforest_theme['allow_tax_warranty']) {
                                    ?>

                                    <li><?php echo __('Warranty', 'adforest');?> :<span><?php echo get_post_meta($pid, '_adforest_ad_warranty', true);?></span></li>
                                    <?php
                                }
                                // extra fields
                                global $wpdb;
                                $rows = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE post_id = '$pid' AND meta_key LIKE '_sb_extra_%'");
                                foreach ($rows as $row) {
                                    $caption = explode('_', $row->meta_key);
                                    if ($row->meta_value == "") {
                                        continue;
                                    }
                                    ?>

                                    <li><?php echo esc_html(ucfirst($caption[3]));?> :<span><?php echo esc_html($row->meta_value);?></span></li>

                                    <?php
                                }
                                // custom fields
                                if (function_exists('adforestCustomFieldsHTML')) {
                                    echo adforestCustomFieldsHTML($pid, 4, 'style-6');
                                }
                                ?>

                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?php
                        if (isset($adforest_theme['style_ad_720_1']) && $adforest_theme['style_ad_720_1'] != "") {
                            ?>
                            <div class="margin-top-30 margin-bottom-10">
                                <?php echo adforest_returnEcho($adforest_theme['style_ad_720_1']);?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="ad-des-details" id="description">
                            <span class="ad-detail-6-title"><?php echo __('Description', 'adforest');?></span>
                            <?php get_template_part('template-parts/layouts/ad_style/status', 'watermark');?>
                            <?php
                            $contents = get_the_content();
                            echo wp_kses_post($contents);
                            do_action('adforest_owner_text');
                            ?>

                            <?php
                            $pid = get_the_ID();
                            $posttags = get_the_terms(get_the_ID(), 'ad_tags');

                            $flip_it = '';
                            if (is_rtl()) {
                                $flip_it = 'flip';
                            }
                            $count = 0;
                            $tags = '';
                            if ($posttags) {
                                ?>
                                <div class="ad-des-bar">
                                    <div class="ad-des-barlist <?php echo esc_attr($flip_it);?>">
                                        <ul>
                                            <li><i class="fa fa-tag"></i></li>
                                            <?php
                                            foreach ($posttags as $tag) {
                                                ?>
                                                <li>
                                                    <a href="<?php echo esc_url(get_term_link($tag->term_id, 'ad_tags'));?>" title="<?php echo esc_attr($tag->name);?>">
                                                        <?php echo esc_attr($tag->name);?>
                                                    </a>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>


                        </div>

                    </div>
                </div>
                <?php
                if (isset($adforest_theme['style_ad_720_2']) && $adforest_theme['style_ad_720_2'] != "") {
                    ?>
                    <div class="margin-top-30 margin-bottom-30">
                        <?php echo adforest_returnEcho($adforest_theme['style_ad_720_2']);?>
                    </div>
                    <?php
                }
                ?>

                <?php
                if (get_post_meta($pid, '_adforest_ad_yvideo', true) != "") {

                    $ty_video_url = get_post_meta($pid, '_adforest_ad_yvideo', true);
                    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $ty_video_url, $match);

                    if (isset($match[1]) && $match[1] != "") {

                        $video_id = $match[1];

//                        $extra_params = explode("?", $ty_video_url)[1];
//                        if (isset($extra_params) && $extra_params != '') {
//                            $extra_params = explode("=", $extra_params); // check for video start time
//                            if (isset($extra_params[0]) && $extra_params[0] == 't') {
//                                $video_id = $video_id . '?start=' . $extra_params[1];
//                            }
//                        }
                        ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div id="video" class="ad-6-video">
                                    <div class="heading-panel">
                                        <div class="ad-detail-6-title">
                                            <?php echo __('Ad Video', 'adforest');?> 
                                        </div>
                                    </div>
                                    <?php
                                    $iframe = 'iframe';
                                    echo '<' . $iframe . ' width="560" height="450" src="https://www.youtube.com/embed/' . esc_attr($video_id) . '" frameborder="0" allowfullscreen></' . $iframe . '>';
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?> 

                <?php
                if (isset($adforest_theme['sb_enable_comments_offer']) && $adforest_theme['sb_enable_comments_offer'] && get_post_meta($pid, '_adforest_ad_status_', true) != 'sold' && get_post_meta($pid, '_adforest_ad_status_', true) != 'expired' && get_post_meta($pid, '_adforest_ad_price', true) != "0") {
                    if (isset($adforest_theme['sb_enable_comments_offer_user']) && $adforest_theme['sb_enable_comments_offer_user'] && get_post_meta($pid, '_adforest_ad_bidding', true) == 1) {
                        echo adforest_html_bidding_system($pid, 'style-2');
                    } else if (isset($adforest_theme['sb_enable_comments_offer_user']) && $adforest_theme['sb_enable_comments_offer_user'] && get_post_meta($pid, '_adforest_ad_bidding', true) == 0) {
                        
                    } else {
                        echo adforest_html_bidding_system($pid, 'style-2');
                    }
                    ?>

                    <?php
                }
                ?>





                <?php
                if (isset($adforest_theme['sb_ad_rating']) && $adforest_theme['sb_ad_rating']) {
                    get_template_part('template-parts/layouts/ad_style/ad', 'rating2');
                }
                ?>

            </div>

            <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
                <div class="sidebar">
                    <?php
                    if ($adforest_theme['communication_mode'] == 'bothe' || $adforest_theme['communication_mode'] == 'messagee') {
                        if (get_current_user_id() == "") {
                            $redirect_url = adforest_login_with_redirect_url_param(adforest_get_current_url());
                            ?>
                            <div class="details-messages">
                                <a class="btn btn-primary" href="<?php echo esc_url($redirect_url);?>">
                                    <i class="fa fa-envelope"></i><?php echo __('Send Message', 'adforest');?>
                                </a>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="details-messages">
                                <a class="btn btn-primary" href="javascript:void(0);" role="button" data-toggle="modal" data-target=".price-quote">
                                    <i class="fa fa-envelope"></i><?php echo __('Send Message', 'adforest');?>
                                </a>
                            </div>

                            <?php
                        }
                    }
                    $user_info = get_userdata(get_current_user_id());
                    $poster_name = get_post_meta($pid, '_adforest_poster_name', true);
                    if ($poster_name == "") {
                        $user_info = get_userdata($poster_id);
                        $poster_name = $user_info->display_name;
                    }
                    ?>
                    <div class="ad-sidebar-content">
                        <div class="ad-sidebar-profile"> 
                            <img src="<?php echo esc_url($user_pic);?>" alt="<?php echo __('User image', 'adforest');?>" class="img-fluid">
                            <div class="ad-prof-raing"> 
                                <?php
                                $_adforest_rating_avg = get_user_meta($poster_id, "_adforest_rating_avg", true);
                                if ($_adforest_rating_avg == "")
                                    $_adforest_rating_avg = 0;
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= round($_adforest_rating_avg))
                                        echo '<i class="fa fa-star"></i>';
                                    else
                                        echo '<i class="fa fa-star-o"></i>';
                                }

                                $user_type = '';
                                if (get_user_meta($poster_id, '_sb_user_type', true) == 'Indiviual') {
                                    $user_type = __('Individual', 'adforest');
                                } else if (get_user_meta($poster_id, '_sb_user_type', true) == 'Dealer') {
                                    $user_type = __('Dealer', 'adforest');
                                }
                                ?>
                                <span>(<?php echo count(adforest_get_all_ratings($poster_id));?>)</span>
                                <a href="<?php echo adforest_set_url_param(get_author_posts_url($poster_id), 'type', 'ads');?>"><span class="ad-poster-6">
                                        <?php echo esc_html($poster_name);?>
                                        <?php
                                        if ($user_type != "") {
                                            ?>
                                            <p class="badge label <?php echo get_user_meta($poster_id, '_sb_badge_type', true);?>"><?php echo adforest_returnEcho($user_type);?></p>
                                            <?php
                                        }
                                        ?>
                                    </span></a>

                                <a href="<?php echo adforest_set_url_param(get_author_posts_url($poster_id), 'type', 'ads');?>"><p><?php echo __('View Details', 'adforest');?></p></a>
                            </div>
                        </div>

                        <?php
                        if ($adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'message') {
                            if (get_current_user_id() == "") {
                                $redirect_url = adforest_login_with_redirect_url_param(adforest_get_current_url());
                                ?>
                                <div class="ad-sidebar-form">
                                    <form>
                                        <span class="ad-6-message"><?php echo __('Send Message', 'adforest');?></span>
                                        <div class="form-group">
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                        </div>
                                        <a class="btn btn-theme" href="<?php echo esc_url($redirect_url);?>">
                                            <i class="fa fa-envelope"></i><?php echo __(' Send Message', 'adforest');?>
                                        </a>
                                    </form>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="ad-sidebar-form">
                                    <form id="send_message_pop">
                                        <div class="form-group no-display">
                                            <label><?php echo __('Your Name', 'adforest');?></label>
                                            <input type="text" name="name" readonly class="form-control" value="<?php echo esc_attr($user_info->display_name);?>"> 
                                        </div>
                                        <div class="form-group no-display">
                                            <label><?php echo __('Email Address', 'adforest');?></label>
                                            <input type="email" name="email" readonly class="form-control" value="<?php echo esc_attr($user_info->user_email);?>"> 
                                        </div>
                                        <span class="ad-6-message"><?php echo __('Send Messages', 'adforest');?></span>
                                        <div class="form-group">
                                            <textarea id="sb_forest_message" name="message" placeholder="<?php echo __('Type here...', 'adforest');?>" rows="3" class="form-control" data-parsley-required="true" data-parsley-error-message="<?php echo __('This field is required.', 'adforest');?>"></textarea>
                                        </div>
                                        <input type="hidden" name="ad_post_id" value="<?php echo esc_attr($pid);?>" />
                                        <input type="hidden" name="usr_id" value="<?php echo get_current_user_id();?>" />
                                        <input type="hidden" name="msg_receiver_id" value="<?php echo esc_attr($poster_id);?>" />
                                        <input type="hidden" id="sb-msg-token" value="<?php echo wp_create_nonce('sb_msg_secure');?>" />
                                        <button type="submit" id="send_ad_message" class="btn btn-theme"><i class="fa fa-envelope"></i> <?php echo __('Submit', 'adforest');?></button>
                                    </form>
                                </div>
                                <?php
                            }
                        }
                        ?>

                    </div>

                    <?php
                    if (is_active_sidebar('adforest_ad_sidebar_top')) {

                        dynamic_sidebar('adforest_ad_sidebar_top');
                    }
                    if (get_post_meta($pid, '_adforest_ad_type', true) != "") {
                        ?>
                        <div class="ad-sidebar-style">
                            <?php
                            if (is_rtl()) {
                                $link1 = trailingslashit(get_template_directory_uri()) . 'images/megaphone2.png';
                                $link2 = trailingslashit(get_template_directory_uri()) . 'images/megaphone.png';
                            } else {
                                $link1 = trailingslashit(get_template_directory_uri()) . 'images/megaphone.png';
                                $link2 = trailingslashit(get_template_directory_uri()) . 'images/megaphone2.png';
                            }
                            ?>
                            <i class="fa fa-bullhorn"></i> <span><?php echo get_post_meta($pid, '_adforest_ad_type', true);?></span> 
                            <img src="<?php echo esc_url($link1);?>" alt="<?php echo esc_html__('ad type', 'adforest');?>" class="img-fluid" />
                        </div>
                        <?php
                    }

                    $get_all_cats = adforest_get_cats('ad_cats');
                    $sb_single_cat_limit = isset($adforest_theme['sb_single_cat_limit']) && $adforest_theme['sb_single_cat_limit'] != '' ? $adforest_theme['sb_single_cat_limit'] : 10;
                    if (isset($get_all_cats) && !empty($get_all_cats) && sizeof($get_all_cats) > 0) {
                        ?>
                        <div class="ad-sidebar-categories">
                            <ul>
                                <li>
                                    <div class="ad-6-cat-title"><?php echo __('All Categories', 'adforest');?></div>
                                </li> 
                                <?php
                                $counter = 0;
                                foreach ($get_all_cats as $each_cat) {
                                    if ($counter == $sb_single_cat_limit) {
                                        break;
                                    }
                                    $count = ($each_cat->count);
                                    echo '<li> <a href="' . adforest_cat_link_page($each_cat->term_id, 'category', 'ad_cats') . '">
                                    <p>' . $each_cat->name . '</p>
                                <span>' . $count . '</span> </a></li>';

                                    $counter++;
                                }
                                ?>
                            </ul>
                        </div>
                        <?php
                    }

                    if (isset($adforest_theme['sb_custom_location']) && $adforest_theme['sb_custom_location'] != "" && count(wp_get_post_terms($pid, 'ad_country')) > 0) {
                        ?>
                        <div class="country-locations margin-top-30">
                            <img src="<?php echo trailingslashit(get_template_directory_uri()) . 'images/earth-globe.png';?>" alt="<?php echo esc_html__('Globe location', 'adforest');?>"/>
                            <div class="class-name"><div id="word-count"><?php echo adforest_display_adLocation($pid);?></div></div>
                        </div>
                        <div class="clearfix"></div>
                        <?php
                    }


                    if (isset($adforest_theme['allow_lat_lon']) && $adforest_theme['allow_lat_lon']) {
                        ?>
                        <div id="ad-map-integration">
                            <?php
                            // Getting lat lon
                            $map_lat = get_post_meta($pid, '_adforest_ad_map_lat', true);
                            $map_long = get_post_meta($pid, '_adforest_ad_map_long', true);
                            if ($map_lat != "" && $map_long != "") {
                                ?>
                                <div id="itemMap" style="width: 100%; height: 450px; margin:20px 0px 20px 0px;border:0"></div>
                                <input type="hidden" id="lat" value="<?php echo esc_attr($map_lat);?>" />
                                <input type="hidden" id="lon" value="<?php echo esc_attr($map_long);?>" />
                                <?php
                            } else {
                                $res_arr = adforest_get_latlon($address);
                                if (isset($res_arr) && count($res_arr) > 0) {
                                    ?>
                                    <div id="itemMap" style="width: 100%; height: 450px; margin:20px 0px 20px 0px;border:0"></div>
                                    <input type="hidden" id="lat" value="<?php echo esc_attr($res_arr[0]);?>" />
                                    <input type="hidden" id="lon" value="<?php echo esc_attr($res_arr[1]);?>" />
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <?php
                    }

                    do_action('adforest_directory_claim_html_frontend');
                    do_action('adforest_directory_coupon_code_detail_page_display', $pid);
                    do_action('adforest_directory_opening_hours_detail_page_display', $pid);

                    if (isset($adforest_theme['sb_enable_comments_offer']) && $adforest_theme['sb_enable_comments_offer'] && get_post_meta($pid, '_adforest_ad_status_', true) != 'sold' && get_post_meta($pid, '_adforest_ad_status_', true) != 'expired' && get_post_meta($pid, '_adforest_ad_price', true) != "0") {
                        if (isset($adforest_theme['sb_enable_comments_offer_user']) && $adforest_theme['sb_enable_comments_offer_user'] && get_post_meta($pid, '_adforest_ad_bidding', true) == 1) {
                            echo adforest_bidding_stats($pid, 'style-2');
                        } else if (isset($adforest_theme['sb_enable_comments_offer_user']) && $adforest_theme['sb_enable_comments_offer_user'] && get_post_meta($pid, '_adforest_ad_bidding', true) == 0) {
                            
                        } else {
                            echo adforest_bidding_stats($pid, 'style-2');
                        }
                    }
                    ?>
                    <?php
                    if ($adforest_theme['tips_title'] != '' && $adforest_theme['tips_for_ad'] != "") {
                        ?>
                        <div class="widget safety-tips">
                            <div class="widget-heading">
                                <div class="panel-title"><span><?php echo adforest_returnEcho($adforest_theme['tips_title']);?></span></div>
                            </div>
                            <div class="widget-content saftey">
                                <?php echo adforest_returnEcho($adforest_theme['tips_for_ad']);?>
                            </div>
                        </div>
                        <?php
                    }
                    if (is_active_sidebar('adforest_ad_sidebar_bottom')) {
                        ?>
                        <?php dynamic_sidebar('adforest_ad_sidebar_bottom');?>
                    <?php }?>

                </div>
            </div>
        </div>
</section>

<section class="ad-grid-10">
    <div class="container">
        <?php get_template_part('template-parts/layouts/ad_style/related2', 'ads');?>
    </div>
</section>
<?php
if (get_post_field('post_author', $pid) == $poster_id && get_post_meta($pid, '_adforest_ad_status_', true) == 'active') {
    get_template_part('template-parts/layouts/ad_style/sort', 'images');
}
?>