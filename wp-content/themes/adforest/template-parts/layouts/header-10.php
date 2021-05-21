<?php
global $adforest_theme;


$sb_sign_up_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_sign_up_page']);
$sb_notification_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_notification_page']);

$class = 'sprt-colored-header';
if (isset($adforest_theme['design_type']) && $adforest_theme['design_type'] == 'modern' && isset($adforest_theme['sb_header']) && $adforest_theme['sb_header'] == 'transparent-3' && is_page_template('page-home.php'))
    $class = 'sprt-header';
?>
<div class="sb-header-top5">
<section class="sb-sprt-top-bar"> 
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-7 col-md-8 col-lg-8">
                <div class="sb-sprt-top-scl">
                    <ul class="list-inline sb-spt-alignment">
                        <?php
                        if (isset($adforest_theme['social_media']) && !empty($adforest_theme['social_media']) && is_array($adforest_theme['social_media'])) {
                            foreach ($adforest_theme['social_media'] as $index => $val) {
                                ?>
                                <?php
                                if ($val != "") {
                                    ?>
                                    <li>
                                        <a <?php do_action('adforest_relation_follow_links');?>href="<?php echo esc_url($val);?>">
                                            <i class="<?php echo adforest_social_icons($index);?>"></i>
                                        </a>
                                    </li>
                                    <?php
                                }
                            }
                        }
                        ?>
                        <li class="sb-mob-top-bar-location">
                            <?php do_action('adforest_topbar_location');?>
                        </li> 
                    </ul>

                </div>

            </div>
            <div class="col-xs-12 col-sm-5 col-md-4 col-lg-4">
                <div class="sb-sprt-top-sign">
                    <ul class="list-inline sb-spt-links">
                        <?php
                        $user_id = get_current_user_id();
                        $sb_sign_in_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_sign_in_page']);
                        if (is_user_logged_in()) {
                            global $wpdb;
                            //$unread_msgs = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->commentmeta WHERE comment_id = '$user_id' AND meta_value = '0' ");
                            $unread_msgs = ADFOREST_MESSAGE_COUNT; // Message count define in header
                            $user_info = get_userdata($user_id);

                            if (isset($adforest_theme['communication_mode']) && ( $adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'message' )) {
                                ?>
                                <li> 
                                    <a href="<?php echo get_the_permalink($sb_notification_page);?>"><i class="icon-envelope"></i>
                                        <div class="sb-notify">
                                            <?php
                                            global $wpdb;
                                            //$unread_msgs = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->commentmeta WHERE comment_id = '$user_id' AND meta_value = '0' ");
                                            $unread_msgs = ADFOREST_MESSAGE_COUNT; // Message count define in header
                                            if ($unread_msgs > 0) {
                                                $msg_count = $unread_msgs;
                                                ?>
                                                <span class="sb-heartbit"></span><span class="point"></span>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </a>
                                </li>
                                <?php
                            }
                            $sb_profile_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_profile_page']);
                            ?>
                            <li class="sb-nav-table dropdown hidden-sm-down">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <span class="sb-nav-cell">
                                        <?php
                                        if (is_user_logged_in()) {
                                            $dp = '';
                                            if (function_exists('adforest_get_user_dp')) {
                                                $dp = adforest_get_user_dp($user_id);
                                            }
                                            ?>
                                            <img class="img-circle" src="<?php echo esc_url($dp);?>" alt="<?php __('user prfile picture', 'adforest');?>" width="32" height="32">

                                            <?php
                                        }
                                        ?>
                                    </span>

                                </a>
                                <ul class="dropdown-menu sb-user-pro">
                                    <li>
                                        <a href="<?php echo get_the_permalink($sb_profile_page);?>">
                                            <i class="fa fa-user"></i> <?php echo __("Profile", "adforest");?></a>
                                    </li>
                                    <?php
                                    if (isset($adforest_theme['communication_mode']) && ( $adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'message' )) {
                                        ?>
                                        <li>
                                            <a href="<?php echo get_the_permalink($sb_notification_page);?>">
                                                <i class="fa fa-envelope"></i> <?php echo __('Messages', 'adforest');?> <span class="badge"><?php echo esc_html($unread_msgs);?></span></a> 
                                        </li>
                                        <?php
                                    }
                                    if (isset($adforest_theme['sb_cart_in_menu']) && $adforest_theme['sb_cart_in_menu'] && in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                                        global $woocommerce;
                                        ?>
                                        <li>
                                            <a href="<?php echo wc_get_cart_url();?>">
                                                <i class="fa fa-shopping-cart"></i> <?php echo __('Cart', 'adforest');?> <span class="badge"><?php echo adforest_returnEcho($woocommerce->cart->cart_contents_count);?></span></a> 
                                        </li>
                                        <?php
                                    }
                                    ?>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="<?php echo wp_logout_url(get_the_permalink($sb_sign_in_page));?>">
                                            <i class="fa fa-power-off"></i> <?php echo __("Logout", "adforest");?></a>
                                    </li>
                                </ul>
                            </li>   
                            <?php
                        } else {
                            if (isset($adforest_theme['sb_sign_up_page']) && $adforest_theme['sb_sign_up_page'] != "") {
                                ?>
                                <li><a href="<?php echo get_the_permalink($sb_sign_up_page);?>"><?php echo esc_html__('Sign Up', 'adforest');?>/</a></li>
                                <?php
                            }
                            if (isset($adforest_theme['sb_sign_in_page']) && $adforest_theme['sb_sign_in_page'] != "") {
                                ?>
                                <li class="new-sea-green"><a href="<?php echo get_the_permalink($sb_sign_in_page);?>"><?php echo esc_html__('Sign In', 'adforest');?></a></li>
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
</div>


<!--adforest-header-->

<div class="clearfix"></div>
<!--adforest-header--> 

<!--top-bar--> 

<div class="sb-transparent3-header">
<div class="<?php echo esc_attr($class);?>">
    <div class="sb-srvs-top-header">
        <div class="sb-top-header-3">
            <div class="sb-top-header">
                <nav id="menu-1" class="mega-menu menu-2"> 
                    <!-- menu list items container -->
                    <section class="menu-list-items">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 col-md-12"> 
                                    <!-- menu logo -->
                                    <ul class="menu-logo">
                                        <li> <?php get_template_part('template-parts/layouts/site', 'logo');?></li>
                                    </ul>
                                    <!-- menu links -->
                                    <?php
                                    get_template_part('template-parts/layouts/main', 'nav');
                                    ?>
                                    <div class="sb-sprt-header-box">

                                        <?php
                                        if (isset($adforest_theme['ad_in_menu']) && $adforest_theme['ad_in_menu']) {
                                            $sb_post_ad_page = apply_filters('adforest_ad_post_verified_id', $adforest_theme['sb_post_ad_page']); // phone verification redirection
                                            $sb_post_ad_page = apply_filters('adforest_language_page_id', $sb_post_ad_page);
                                            $sb_ad_post_url = isset($sb_post_ad_page) && !empty($sb_post_ad_page) ? apply_filters('adforest_ad_post_verified_link', get_the_permalink($sb_post_ad_page)) : home_url('/');
                                            ?>
                                            <a  href="<?php echo esc_url($sb_ad_post_url);?>"><i class="fa fa-plus"></i><p><?php echo esc_html($adforest_theme['ad_in_menu_text']);?></p></a>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </nav>
            </div>
        </div>
    </div>
</div>
</div>	

<div class="clearfix"></div>