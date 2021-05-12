<?php
global $adforest_theme;
$sb_sign_in_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_sign_in_page']);
$sb_sign_up_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_sign_up_page']);
$sb_notification_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_notification_page']);
?>


<div class="sb-light-header">

<div class="sb-colored-header">
    <!-- Top Bar -->
    <div class="sb-new-version">
        <!-- Top Bar End -->
        <!-- Navigation Menu -->
        <nav id="menu-1" class="mega-menu">
            <!-- menu list items container -->
            <section class="menu-list-items">
                <div class="container-fluid">
                    <div class="sb-logo-area">
                        <!-- menu logo -->
                        <ul class="menu-logo">
                            <li>
                                <?php get_template_part('template-parts/layouts/site', 'logo'); ?>
                            </li>
                        </ul>

                    </div>   
                    <!-- menu links -->
                    <?php get_template_part('template-parts/layouts/main', 'nav'); ?>
                    <?php
                    $user_id = get_current_user_id();
                    ?>
                    <ul class="menu-search-bar">
                        <?php
                        $user_info = get_userdata($user_id);
                        if (isset($adforest_theme['communication_mode']) && ( $adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'message' )) {
                            if (is_user_logged_in()) {
                                ?>
                                <li class="p-relative"> 
                                    <a href="<?php echo get_the_permalink($sb_notification_page); ?>"><i class="icon-envelope"></i>
                                        <div class="sb-notify">
                                            <?php
                                            //global $wpdb;
                                            //$unread_msgs = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->commentmeta WHERE comment_id = '$user_id' AND meta_value = '0' ");
                                            $unread_msgs = ADFOREST_MESSAGE_COUNT; // Message count define in header
                                            if ($unread_msgs > 0) {
                                                $msg_count = $unread_msgs;
                                                ?>
                                                <span class="sb-heartbit"></span><span class="point"></span>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </a>
                                </li>
                                <?php
                            }
                        }
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
                                        <img class="img-circle" src="<?php echo esc_url($dp); ?>" alt="<?php __('user prfile picture', 'adforest'); ?>" width="32" height="32">

                                        <?php
                                    }
                                    ?>
                                </span>

                            </a>

                            <?php
                            if (is_user_logged_in()) {
                                //global $wpdb;
                                //$unread_msgs = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->commentmeta WHERE comment_id = '$user_id' AND meta_value = '0' ");
                                $unread_msgs = ADFOREST_MESSAGE_COUNT; // Message count define in header
                                $sb_profile_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_profile_page']);
                                ?>
                                <ul class="dropdown-menu sb-user-pro">
                                    <li>
                                        <a href="<?php echo get_the_permalink($sb_profile_page); ?>">
                                            <i class="fa fa-user"></i> <?php echo __("Profile", "adforest"); ?></a>
                                    </li>
                                    <?php
                                    if (isset($adforest_theme['communication_mode']) && ( $adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'message' )) {
                                        ?>
                                        <li>
                                            <a href="<?php echo get_the_permalink($sb_notification_page); ?>">
                                                <i class="fa fa-envelope"></i> <?php echo __('Messages', 'adforest'); ?> <span class="badge"><?php echo esc_html($unread_msgs); ?></span></a> 
                                        </li>
                                        <?php
                                    }
                                    if (isset($adforest_theme['sb_cart_in_menu']) && $adforest_theme['sb_cart_in_menu'] && in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                                        global $woocommerce;
                                        ?>
                                        <li>
                                            <a href="<?php echo wc_get_cart_url(); ?>">
                                                <i class="fa fa-shopping-cart"></i> <?php echo __('Cart', 'adforest'); ?> <span class="badge"><?php echo adforest_returnEcho($woocommerce->cart->cart_contents_count); ?></span></a> 
                                        </li>
                                        <?php
                                    }
                                    ?>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="<?php echo wp_logout_url(get_the_permalink($sb_sign_in_page)); ?>">
                                            <i class="fa fa-power-off"></i> <?php echo __("Logout", "adforest"); ?></a>
                                    </li>
                                </ul>
                            </li>
                            <?php
                        } else {
                            if (isset($adforest_theme['sb_sign_in_page']) && $adforest_theme['sb_sign_in_page'] != "") {
                                ?> 
                                <li>
                                    <a href="<?php echo get_the_permalink($sb_sign_in_page); ?>">
                                        <?php echo get_the_title($sb_sign_in_page); ?>
                                    </a>
                                </li>
                                <?php
                            }
                            if (isset($adforest_theme['sb_sign_up_page']) && $adforest_theme['sb_sign_up_page'] != "") {
                                ?>
                                <li>
                                    <a href="<?php echo get_the_permalink($sb_sign_up_page); ?>">
                                        <?php echo get_the_title($sb_sign_up_page); ?>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>

                        <li>
                            <?php get_template_part('template-parts/layouts/ad', 'button'); ?>
                        </li>

                    </ul>
                </div>
            </section>
        </nav>            
    </div>   
</div>
	
</div>	