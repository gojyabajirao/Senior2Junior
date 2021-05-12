<?php
global $adforest_theme;


$sb_sign_in_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_sign_in_page']);
$sb_sign_up_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_sign_up_page']);
$sb_notification_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_notification_page']);
?>

<div class="sb-modern-header">

<div class="sb-colors-combination-c1">
    <div class="sb-colored-header"> 
        <?php
        $pg_class = 'header-position';
        if (basename(get_page_template()) == 'page-home.php' || is_singular('ad_post')) {
            $pg_class = '';
        }
        ?>
        <div class="sb-top-header <?php echo esc_attr($pg_class);?>">
            <nav id="menu-1" class="mega-menu menu-2"> 
                <!-- menu list items container -->
                <section class="menu-list-items">
                    <div class="container-fluaid">
                        <div class="row">
                            <div class="col-lg-12 col-md-12"> 
                                <!-- menu logo -->
                                <ul class="menu-logo">
                                    <li> <?php get_template_part('template-parts/layouts/site', 'logo');?></li>
                                </ul>
                                <?php get_template_part('template-parts/layouts/main', 'nav');?>
                                <div class="sb-header-social-h2">
                                    <ul class="list-inline">
                                        <?php
                                        $user_id = get_current_user_id();
                                        if (is_user_logged_in()) {
                                            global $wpdb;
                                            //$unread_msgs = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->commentmeta WHERE comment_id = '$user_id' AND meta_value = '0' ");
                                            $user_info = get_userdata($user_id);
                                            if (isset($adforest_theme['communication_mode']) && ( $adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'message' )) {
                                                ?>
                                                <li class="sb-bg-blue p-relative"> 
                                                    <a href="<?php echo urldecode(get_the_permalink($sb_notification_page));?>"><i class="icon-envelope"></i>
                                                        <div class="sb-notify">
                                                            <?php
                                                            //global $wpdb;
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
                                            <li class="sb-new-sea-green sb-nav-table dropdown"> 

                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-user"></i>
                                                </a>
                                                <ul class="dropdown-menu sb-user-pro">
                                                    <li>
                                                        <a href="<?php echo urldecode(get_the_permalink($sb_profile_page));?>">
                                                            <?php echo __("Profile", "adforest");?></a>
                                                    </li>
                                                    <?php
                                                    if (isset($adforest_theme['sb_cart_in_menu']) && $adforest_theme['sb_cart_in_menu'] && in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                                                        global $woocommerce;
                                                        ?>
                                                        <li>
                                                            <a href="<?php echo wc_get_cart_url();?>">
                                                                <?php echo __('Cart', 'adforest');?><span class="badge"><?php echo adforest_returnEcho($woocommerce->cart->cart_contents_count);?></span></a>
                                                        </li>
                                                        <?php
                                                    }
                                                    ?>
                                                    <li role="separator" class="divider"></li>
                                                    <li>
                                                        <a href="<?php echo wp_logout_url(get_the_permalink($sb_sign_in_page));?>">
                                                            <?php echo __("Logout", "adforest");?></a>
                                                    </li>
                                                </ul>
                                            </li>

                                            <?php
                                        } else {
                                            if (isset($adforest_theme['sb_sign_up_page']) && $adforest_theme['sb_sign_up_page'] != "") {
                                                ?>
                                                <li class="sb-bg-blue p-relative"><a href="<?php echo get_the_permalink($sb_sign_up_page);?>"><i class="fa fa-unlock"></i></a></li>
                                                <?php
                                            }
                                            if (isset($adforest_theme['sb_sign_in_page']) && $adforest_theme['sb_sign_in_page'] != "") {
                                                ?>
                                                <li class="sb-new-sea-green"><a href="<?php echo get_the_permalink($sb_sign_in_page);?>"><i class="fa fa-sign-in"></i></a></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <?php
                                        if (isset($adforest_theme['ad_in_menu']) && $adforest_theme['ad_in_menu']) {
                                            $btn_text = __('Post Free Ad', 'adforest');
                                            if (isset($adforest_theme['ad_in_menu_text']) && $adforest_theme['ad_in_menu_text'] != "") {
                                                $btn_text = $adforest_theme['ad_in_menu_text'];
                                            }
                                            $sb_post_ad_page = apply_filters('adforest_ad_post_verified_id', $adforest_theme['sb_post_ad_page']); // phone verification redirection
                                            $sb_post_ad_page = apply_filters('adforest_language_page_id', $sb_post_ad_page);
                                            $sb_ad_post_url = isset($sb_post_ad_page) && !empty($sb_post_ad_page) ? apply_filters('adforest_ad_post_verified_link',get_the_permalink($sb_post_ad_page)) : home_url('/');

                                            ?>
                                            <li>
                                                <a href="<?php echo esc_url($sb_ad_post_url);?>" class="btn btn-primary"><i class="custom fa fa-plus"></i><?php echo esc_html($btn_text);?></a>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
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