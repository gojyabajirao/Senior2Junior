<!--mob-top-bar start-->
<?php
global $adforest_theme;

$sb_sign_in_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_sign_in_page']);
$sb_sign_up_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_sign_up_page']);
$sb_notification_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_notification_page']);
?>

<?php
if (isset($adforest_theme['sb_top_bar']) && $adforest_theme['sb_top_bar'] == true) {

    $top_bar_text = isset($adforest_theme['top_bar_text']) && !empty($adforest_theme['top_bar_text']) ? $adforest_theme['top_bar_text'] : '';
    $top_bar_contact = isset($adforest_theme['top_bar_contact']) && !empty($adforest_theme['top_bar_contact']) ? $adforest_theme['top_bar_contact'] : '';
    ?>

	<div class="sb-header-top3">	
    <section class="sb-mob-top-bar">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-9 col-md-8 col-lg-8">
                    <div class="sb-mob-bar-content">
                        <ul class="list-inline sb-top-social-icons">
                            <?php if (!empty($top_bar_text)) {?>
                                <li><?php echo esc_html($top_bar_text);?></li>
                                <?php
                            }
                            if (!empty($top_bar_contact)) {
                                ?>
                                <li><i class="fa fa-phone"></i><?php echo esc_html__('Call Us', 'adforest');?>:<?php echo esc_html($top_bar_contact);?></li>
                            <?php }?>
                        </ul>
                    </div>
                    <div class="sb-mob-top-bar-location">
                        <?php do_action('adforest_topbar_location');?>
                    </div>

                </div>
                <div class="col-xs-12 col-sm-3  col-md-4 col-lg-4 ">
                    <div class="sb-mob-top-icons-area">
                        <ul class="list-inline sb-top-main-contents">
                            <?php
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
                            ?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>	
    <?php
}
?>

<!--mob-top-bar start--> 

<!--adforest-header-->
<div class="sb-modern3-header">

<div class="sb-mega-menu-3">
    <nav id="menu-1" class="mega-menu menu-2"> 
        <!-- menu list items container -->
        <section class="menu-list-items menu-list-items-h2">
            <div class="container-fluaid">
                <div class="row">
                    <div class="col-lg-12 col-md-12"> 
                        <!-- menu logo -->
                        <ul class="menu-logo">
                            <li> <?php get_template_part('template-parts/layouts/site', 'logo');?></li>
                        </ul>
                        <!-- menu links --> 

                        <!-- menu links -->
                        <ul class="menu-links" style="display: none; max-height: 400px; overflow: auto;">

                            <?php
                            get_template_part('template-parts/layouts/main', 'nav');

                            if (isset($adforest_theme['search_in_header']) && $adforest_theme['search_in_header'] && !wp_is_mobile()) {
                                ?>
                                <li>
                                    <div class="sb-adf-header">
                                        <?php
                                        $search_title = '';
                                        if (isset($_GET['ad_title']) && $_GET['ad_title'] != "")
                                            $search_title = $_GET['ad_title'];
                                        $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
                                        ?>
                                        <form class="form-inline" method="get" action="<?php echo urldecode(get_the_permalink($sb_search_page));?>">
                                            <div class="form-group">
                                                <label class="sr-only" for="lokking-for"><?php echo __('Email address', 'adforest');?></label>
                                                <input id ="lokking-for" placeholder="<?php echo __('What Are You Looking For ?', 'adforest');?>" type="text" name="ad_title" class="form-control" value="<?php echo esc_attr($search_title);?>" autocomplete="off">

                                                <span class="adforest-spinner" style="display:none"><i class="fa fa-spinner spin"></i></span>
                                            </div>
                                            <?php apply_filters('adforest_form_lang_field', true);?>
                                            <button class="btn btn-theme" type="submit"><i class="fa fa-search"></i></button>
                                        </form>
                                    </div>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                        <?php
                        if (isset($adforest_theme['search_in_header']) && $adforest_theme['search_in_header'] && wp_is_mobile()) {
                            ?>

                            <div class="sb-adf-header">
                                <?php
                                $search_title = '';
                                if (isset($_GET['ad_title']) && $_GET['ad_title'] != "")
                                    $search_title = $_GET['ad_title'];
                                $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
                                ?>
                                <form class="form-inline" method="get" action="<?php echo urldecode(get_the_permalink($sb_search_page));?>">
                                    <div class="form-group">
                                        <label class="sr-only" for="lokking-for"><?php echo __('Email address', 'adforest');?></label>
                                        <input id ="lokking-for" placeholder="<?php echo __('What Are You Looking For ?', 'adforest');?>" type="text" name="ad_title" class="form-control" value="<?php echo esc_attr($search_title);?>" autocomplete="off">

                                        <span class="adforest-spinner" style="display:none"><i class="fa fa-spinner spin"></i></span>
                                    </div>
                                    <?php apply_filters('adforest_form_lang_field', true);?>
                                    <button class="btn btn-theme" type="submit"><i class="fa fa-search"></i></button>
                                </form>
                            </div>

                            <?php
                        }
                        ?>
                        <div class="sb-header-social-h2">
                            <ul class="list-inline social-select-icons">
                                <?php
                                $user_id = get_current_user_id();
                                if (is_user_logged_in()) {
                                    global $wpdb;
                                    //$unread_msgs = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->commentmeta WHERE comment_id = '$user_id' AND meta_value = '0' ");
                                    $unread_msgs = '';
                                    $user_info = get_userdata($user_id);
                                    $sb_profile_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_profile_page']);
                                    if (isset($adforest_theme['communication_mode']) && ( $adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'message' )) {
                                        ?>
                                        <li class="p-relative sb-bg-blue"> 
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
                                        <li class="sb-new-sea-green sb-nav-table dropdown"> 

                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-user"></i>
                                            </a>
                                            <ul class="dropdown-menu sb-user-pro">
                                                <li>
                                                    <a href="<?php echo get_the_permalink($sb_profile_page);?>">
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
                                    }
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

                                if (isset($adforest_theme['ad_in_menu']) && $adforest_theme['ad_in_menu']) {
                                    $sb_post_ad_page = apply_filters('adforest_ad_post_verified_id', $adforest_theme['sb_post_ad_page']); // phone verification redirection
                                    $sb_post_ad_page = apply_filters('adforest_language_page_id', $sb_post_ad_page);
                                    $sb_ad_post_url = isset($sb_post_ad_page) && !empty($sb_post_ad_page) ? apply_filters('adforest_ad_post_verified_link',get_the_permalink($sb_post_ad_page)) : home_url('/');
                                    ?>
                                    <li class="sb-new-h-bar"><a href="<?php echo esc_url($sb_ad_post_url);?>"><i class="fa fa-plus"></i></a></li>
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
<div class="clearfix"></div>
<!--adforest-header--> 