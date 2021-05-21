<?php
global $adforest_theme;
$pid = get_the_ID();
$poster_id = get_post_field('post_author', $pid);
$user_pic = adforest_get_user_dp($poster_id, 'adforest-shop-thumbnail');
$address = get_post_meta($pid, '_adforest_ad_location', true);
$type = $adforest_theme['cat_and_location'];


$breadcrumb_bg_img = isset($adforest_theme['breadcrumb_bg_modern_header']) && $adforest_theme['breadcrumb_bg_modern_header'] != '' ? $adforest_theme['breadcrumb_bg_modern_header'] : '';
$breadcrumb_bg_style = '';
if ($breadcrumb_bg_img != '') {
    $breadcrumb_bg_style = '  style="background: rgba(0, 0, 0, 0) url(' . $breadcrumb_bg_img['url'] . ') no-repeat scroll center center / cover !important;" ';
}
?>
<!-- Main Content Area -->
<div class="page-header-section-single">
    <div class="page-header-area"<?php echo adforest_returnEcho($breadcrumb_bg_style);?>> 
    </div>
</div>
<!--details sections start-->
<section class="details-section"> 
    <!--container-->
    <div class="container">
        <div class="row"> 
            <!--details-main-section-->
            <div class="details-main-section">
                <div class="row">
                    <div class="col-lg-9 col-xs-12 col-md-9 col-sm-12">
                        <div class="details-images">
                            <a href="<?php echo adforest_set_url_param(get_author_posts_url($poster_id), 'type', 'ads');?>"><img src="<?php echo esc_url($user_pic);?>" alt="<?php echo __('Profile Pic', 'adforest');?>" class="img-responsive"></a>
                        </div>
                        <div class="details-text-section">
                            <div class="details-price">
                                <?php
                                if (get_post_meta($pid, '_adforest_ad_status_', true) != "" && get_post_meta($pid, '_adforest_ad_status_', true) == 'active') {
                                    ?>
                                    <?php
                                    if (get_post_meta($pid, '_adforest_ad_price_type', true) == "no_price" || ( get_post_meta($pid, '_adforest_ad_price', true) == "" && get_post_meta($pid, '_adforest_ad_price_type', true) != "free" && get_post_meta($pid, '_adforest_ad_price_type', true) != "on_call" )) {
                                        
                                    } else {
                                        ?>
                                        <h2><?php echo adforest_adPrice($pid, 'negotiable-single');?></h2>
                                        <?php
                                    }
                                    ?>

                                    <?php
                                }
                                ?>
                            </div>                  
                            <div class="details-edition">
                                <h3><?php the_title();?></h3>
                            </div>
                            <div class="details-products">
                                <ul class="list-inline">
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
                            <div class="details-post-ad">
                                <ul class="new-details-pages-links">
                                    <li>
                                        <a href="<?php echo adforest_set_url_param(get_author_posts_url($poster_id), 'type', 'ads');?>">
                                            <span><?php echo __('By', 'adforest');?></span>
                                            <?php
                                            $poster_name = get_post_meta($pid, '_adforest_poster_name', true);
                                            if ($poster_name == "") {
                                                $user_info = get_userdata($poster_id);
                                                $poster_name = $user_info->display_name;
                                            }
                                            ?>
                                            <?php echo esc_html($poster_name);?>

                                        </a>
                                        <?php
                                        if (get_user_meta($poster_id, '_sb_badge_type', true) != "" && get_user_meta($poster_id, '_sb_badge_text', true) != "" && isset($adforest_theme['sb_enable_user_badge']) && $adforest_theme['sb_enable_user_badge'] && $adforest_theme['sb_enable_user_badge'] && isset($adforest_theme['user_public_profile']) && $adforest_theme['user_public_profile'] != "" && $adforest_theme['user_public_profile'] == "modern") {
                                            ?>
                                            <span class="label <?php echo get_user_meta($poster_id, '_sb_badge_type', true);?>">
                                                <?php echo get_user_meta($poster_id, '_sb_badge_text', true);?>
                                            </span>
                                            &nbsp;
                                            <?php
                                        }

                                        $user_type = '';
                                        if (get_user_meta($poster_id, '_sb_user_type', true) == 'Indiviual') {
                                            $user_type = __('Individual', 'adforest');
                                        } else if (get_user_meta($poster_id, '_sb_user_type', true) == 'Dealer') {
                                            $user_type = __('Dealer', 'adforest');
                                        }
                                        if ($user_type != "") {
                                            ?>
                                            <span class="label label-success">
                                                <?php echo adforest_returnEcho($user_type);?>
                                            </span>
                                            <?php
                                        }
                                        ?>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <span><?php echo __('Posted', 'adforest');?></span>
                                            <?php echo get_the_date();?>
                                        </a>
                                    </li>
                                    <li><a href="javascript:void(0);"><span><?php echo __('Views', 'adforest');?></span> <?php echo adforest_getPostViews($pid);?></a></li>
                                    <?php
                                    $my_url = adforest_get_current_url();
                                    if (strpos($my_url, 'adforest.scriptsbundle.com') !== false) {
                                        
                                    } else {
                                        if (get_post_field('post_author', $pid) == get_current_user_id() || is_super_admin(get_current_user_id())) {
                                            $sb_post_ad_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_post_ad_page']);
                                            $ad_update_url = adforest_set_url_param(get_the_permalink($sb_post_ad_page), 'id', $pid);
                                            ?>
                                            <li>
                                                <a href="<?php echo esc_url($ad_update_url);?>"><?php echo __('Edit', 'adforest');?></a>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-12 col-md-3 col-sm-12">
                        <div class="details-buttons">
                            <?php
                            if (get_post_meta($pid, '_adforest_ad_status_', true) != "" && get_post_meta($pid, '_adforest_ad_status_', true) == 'active') {
                                if ($adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'message') {
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
                                        <div class="details-click-view">
                                            <a href="<?php echo adforest_returnEcho($call_now);?>" class="btn btn-primary" id="show_ph_div" data-ph-num="<?php echo esc_attr($contact_num);?>">
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
                                        </div>
                                        <?php
                                    }
                                }
                            } else if (get_post_meta($pid, '_adforest_ad_status_', true) != "") {
                                ?>
                                <div class="details-messages">
                                    <a href="javascript:void(0);" class="btn btn-primary">
                                        <i class="fa fa-bullhorn"></i>
                                        <?php echo adforest_ad_statues(get_post_meta($pid, '_adforest_ad_status_', true));?>
                                    </a>
                                </div>
                                <?php
                            } else {
                                update_post_meta($pid, '_adforest_ad_status_', 'active');
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-xs-12 col-md-12 col-sm-12">
                        <div class="single-details-links-h1">
                            <div class="col-lg-8 col-xs-12 col-md-8 col-sm-6">
                                <div class="single-details-page-links">
                                    <ul class="list-inline single-details-list">
                                        <li><a class="page-scroll" href="#description"><i class="fa fa-file-text"></i><?php echo __('Description', 'adforest');?></a></li>
                                        <?php if (get_post_meta($pid, '_adforest_ad_location', true) != "") {?>
                                            <li><a class="page-scroll" href="#map-location"><i class="fa fa-location-arrow"></i><?php echo __('Location Map', 'adforest');?></a></li>
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
                                        <?php
                                        if (isset($adforest_theme['sb_enable_comments_offer']) && $adforest_theme['sb_enable_comments_offer'] && get_post_meta($pid, '_adforest_ad_status_', true) != 'sold' && get_post_meta($pid, '_adforest_ad_status_', true) != 'expired' && get_post_meta($pid, '_adforest_ad_price', true) != "0") {
                                            if (isset($adforest_theme['sb_enable_comments_offer_user']) && $adforest_theme['sb_enable_comments_offer_user'] && get_post_meta($pid, '_adforest_ad_bidding', true) == 1) {
                                                ?>
                                                <li><a class="page-scroll" href="#bids"><i class="fa fa-gavel"></i> <?php echo __('Bids', 'adforest');?></a></li>
                                                <?php
                                            } else if (isset($adforest_theme['sb_enable_comments_offer_user']) && $adforest_theme['sb_enable_comments_offer_user'] && get_post_meta($pid, '_adforest_ad_bidding', true) == 0) {
                                                
                                            } else {
                                                ?>
                                                <li><a class="page-scroll" href="#bids"><i class="fa fa-gavel"></i> <?php echo __('Bids', 'adforest');?></a></li>
                                                <?php
                                            }
                                        }
                                        ?>	
                                    </ul>
                                    <!--list-inline--> 

                                </div>
                                <!--single-details-page-links--> 
                            </div>
                            <div class="col-lg-4 col-xs-12 col-md-4 col-sm-6">
                                <div class="single-details-page-links-right">
                                    <ul class=" reporting_section list-inline">
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
                                                <i class="fa fa-star"></i> <span class="hidetext"><?php echo __('Favourite', 'adforest');?></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a data-target=".report-quote" data-toggle="modal">
                                                <i class="fa fa-warning"></i><?php echo __('Report', 'adforest');?>
                                            </a>
                                        </li>
                                    </ul>
                                    <?php
                                    get_template_part('template-parts/layouts/ad_style/report', 'ad');
                                    ?>
                                    <!--reporting_section--> 
                                </div>
                                <!--single-detail-page-links-right--> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--details-main-section-->
        </div>
    </div>
    <!--container end--> 
</section>

<!--details sections end--> 










<!-- =-=-=-=-=-=-= Main Content Area =-=-=-=-=-=-= -->
<div class="main-content-area clearfix">
    <!-- =-=-=-=-=-=-= Latest Ads =-=-=-=-=-=-= -->



    <section class="section-padding modern-version">

        <div class="container">

            <!-- Row -->
            <div class="row">
                <!-- Middle Content Area -->
                <div class="col-md-8 col-xs-12 col-sm-12">
                    <?php
                    get_template_part('template-parts/layouts/ad_style/rearrange', 'notification');
                    get_template_part('template-parts/layouts/ad_style/ad', 'status');
                    get_template_part('template-parts/layouts/ad_style/feature', 'notification');
                    ?>                  

                    <!-- Single Ad -->
                    <div class="singlepost-content">
                        <!-- Title -->
                        <div class="clearfix"></div>
                        <?php
                        $f_class = '';
                        if (get_post_meta($pid, '_adforest_is_feature', true) == '1' && get_post_meta($pid, '_adforest_ad_status_', true) == 'active') {
                            $ribbion = 'featured-ribbon';
                            if (is_rtl()) {
                                $ribbion = 'featured-ribbon-rtl';
                            }

                            echo '<div class="' . esc_attr($ribbion) . '">
					<span>' . __('Featured', 'adforest') . '</span>
					</div>';
                            $f_class = 'featured-border';
                        }
                        ?>
                        <?php get_template_part('template-parts/layouts/ad_style/slider', $adforest_theme['ad_slider_type']);?>
                        <?php get_template_part('template-parts/layouts/ad_style/desc', 'box');?>
                        <?php
                        if (isset($adforest_theme['sb_ad_rating']) && $adforest_theme['sb_ad_rating']) {
                            get_template_part('template-parts/layouts/ad_style/ad', 'rating');
                        }
                        ?>                     
                    </div>
                    <!-- Single Ad End --> 
                </div>
                <!-- Right Sidebar -->
                <div class="col-md-4 col-xs-12 col-sm-12">
                    <!-- Sidebar Widgets -->
                    <div class="sidebar">

                        <?php if (get_post_meta($pid, '_adforest_ad_type', true) != "") {?>
                            <div class="ad-type">

                                <?php
                                if (is_rtl()) {
                                    $link1 = trailingslashit(get_template_directory_uri()) . 'images/megaphone2.png';
                                    $link2 = trailingslashit(get_template_directory_uri()) . 'images/megaphone.png';
                                } else {
                                    $link1 = trailingslashit(get_template_directory_uri()) . 'images/megaphone.png';
                                    $link2 = trailingslashit(get_template_directory_uri()) . 'images/megaphone2.png';
                                }
                                ?>

                                <div class="type-icon">  <img src="<?php echo esc_url($link1);?>" alt="<?php echo esc_html__('ad type', 'adforest');?>" /> </div>
                                <div class="type-text"> <span><?php echo get_post_meta($pid, '_adforest_ad_type', true);?></span> <img src="<?php echo esc_url($link2);?>" alt="<?php echo esc_html__('Ad type', 'adforest');?>"/></div>
                            </div>
                            <br />
                        <?php }?>

                        <?php
                        if (isset($adforest_theme['sb_custom_location']) && $adforest_theme['sb_custom_location'] != "" && count(wp_get_post_terms($pid, 'ad_country')) > 0) {
                            ?>
                            <div class="country-locations">
                                <img src="<?php echo trailingslashit(get_template_directory_uri()) . 'images/earth-globe.png';?>" alt="<?php echo esc_html__('Globe location', 'adforest');?>"/>
                                <div class="class-name"><div id="word-count"><?php echo adforest_display_adLocation($pid);?></div></div>
                            </div>
                            <div class="clearfix"></div>
                            <?php
                        }
                        ?>

                        <?php if (is_active_sidebar('adforest_ad_sidebar_top')) {?>

                            <?php dynamic_sidebar('adforest_ad_sidebar_top');?>
                        <?php }?>
                        <?php
                        if (isset($adforest_theme['sb_enable_comments_offer']) && $adforest_theme['sb_enable_comments_offer'] && get_post_meta($pid, '_adforest_ad_status_', true) != 'sold' && get_post_meta($pid, '_adforest_ad_status_', true) != 'expired' && get_post_meta($pid, '_adforest_ad_price', true) != "0") {
                            if (isset($adforest_theme['sb_enable_comments_offer_user']) && $adforest_theme['sb_enable_comments_offer_user'] && get_post_meta($pid, '_adforest_ad_bidding', true) == 1) {
                                echo adforest_bidding_stats($pid);
                            } else if (isset($adforest_theme['sb_enable_comments_offer_user']) && $adforest_theme['sb_enable_comments_offer_user'] && get_post_meta($pid, '_adforest_ad_bidding', true) == 0) {
                                
                            } else {
                                echo adforest_bidding_stats($pid);
                            }
                        }
                        ?>

                        <!-- Saftey Tips  --> 
                        <?php
                        if ($adforest_theme['tips_title'] != '' && $adforest_theme['tips_for_ad'] != "") {
                            ?>
                            <div class="widget">
                                <div class="widget-heading">
                                    <div class="panel-title"><span><?php echo adforest_returnEcho($adforest_theme['tips_title']);?></span></div>
                                </div>
                                <div class="widget-content saftey">
                                    <?php echo adforest_returnEcho($adforest_theme['tips_for_ad']);?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <?php if (is_active_sidebar('adforest_ad_sidebar_bottom')) {?>
                            <?php dynamic_sidebar('adforest_ad_sidebar_bottom');?>
                        <?php }?>
                    </div>
                    <!-- Sidebar Widgets End -->
                </div>
                <!-- Middle Content Area  End -->
            </div>
            <!-- Row End -->
            <div class="row">
                <?php get_template_part('template-parts/layouts/ad_style/related', 'ads');?>
            </div>
        </div>
        <!-- Main Container End -->
    </section>
    <!-- =-=-=-=-=-=-= Ads Archives End =-=-=-=-=-=-= -->
</div>
<!-- Main Content Area End --> 



<?php
get_template_part('template-parts/layouts/ad_style/message', 'seller');
if (get_post_field('post_author', $pid) == $poster_id && get_post_meta($pid, '_adforest_ad_status_', true) == 'active') {
    get_template_part('template-parts/layouts/ad_style/sort', 'images');
}
?>