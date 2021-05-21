<?php
global $adforest_theme;

$sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
$sb_sign_in_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_sign_in_page']);
$sb_sign_up_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_sign_up_page']);
$sb_profile_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_profile_page']);
$sb_notification_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_notification_page']);
?>


<div class="sb-header-top4">	
    <div class="sb-bk-clr-scheme">
        <section class="sb-sprt-top-bar"> 
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-xs-12 col-sm-7 col-md-8">
                        <div class="sb-sprt-top-scl">
                            <ul class="list-inline sb-spt-alignment">
                                <?php
                                $social_flag = FALSE;
                                if (isset($adforest_theme['social_media']) && !empty($adforest_theme['social_media']) && is_array($adforest_theme['social_media'])) {
                                    $counter = 1;
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
                                            $counter++;
                                        }
                                        if ($counter == 4 && wp_is_mobile()) {
                                            $social_flag = TRUE;
                                            break;
                                        }
                                    }
                                }
                                if ($social_flag && wp_is_mobile()) {
                                    ?>
                                    <!-- Trigger the modal with a button -->
                                    <li><a data-toggle="modal" data-target="#sb-social-more"><i class="fa fa-plus"></i></a></li>


                                    <?php
                                    add_action('wp_footer', 'adforest_load_all_social_media');

                                    function adforest_load_all_social_media() {
                                        global $adforest_theme;
                                        ?>
                                        <!-- Modal -->
                                        <div id="sb-social-more" class="modal fade sb-social-mobile" role="dialog">
                                            <div class="modal-dialog">

                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <ul class="list-inline">
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
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <?php
                                    }

                                }
                                ?>
                                <li class="sb-mob-top-bar-location">
                                    <?php do_action('adforest_topbar_location');?>
                                </li> 
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-5 col-xs-12 col-md-4">
                        <div class="row">
                            <div class="col-lg-7 col-md-6 col-sm-6 col-xs-6">
                                <div class="sb-sprt-top-sign">
                                    <ul class="list-inline sb-spt-links">
                                        <?php
                                        $user_id = get_current_user_id();
                                        if (is_user_logged_in()) {
                                            global $wpdb;
                                            //$unread_msgs = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->commentmeta WHERE comment_id = '$user_id' AND meta_value = '0' ");
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
                                            <?php }?>
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
                            <div class="col-lg-5">
                                <div class="sb-dec-top-ad-post">
                                    <?php
                                    if (isset($adforest_theme['ad_in_menu']) && $adforest_theme['ad_in_menu']) {
                                        $sb_post_ad_page = apply_filters('adforest_ad_post_verified_id', $adforest_theme['sb_post_ad_page']); // phone verification redirection
                                        $sb_post_ad_page = apply_filters('adforest_language_page_id', $sb_post_ad_page);
                                        $sb_ad_post_url = isset($sb_post_ad_page) && !empty($sb_post_ad_page) ? apply_filters('adforest_ad_post_verified_link', get_the_permalink($sb_post_ad_page)) : home_url('/');
                                        ?>
                                        <a class="btn btn-theme" href="<?php echo esc_url($sb_ad_post_url);?>"><i class="fa fa-plus"></i><?php echo esc_html($adforest_theme['ad_in_menu_text']);?></a>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>	


<!--adforest-header-->

<div class="clearfix"></div>

<div class="sb-modern4-header">

    <section class="sb-bk-search-area"> 
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-xs-12 col-sm-3 col-md-2">
                    <div class="bk-srch-logo">

                        <?php get_template_part('template-parts/layouts/site', 'logo');?>
                    </div>
                </div>

                <?php
                if (isset($adforest_theme['search_in_header']) && $adforest_theme['search_in_header']) {

                    $search_title = '';
                    if (isset($_GET['ad_title']) && $_GET['ad_title'] != "")
                        $search_title = $_GET['ad_title'];
                    ?>
                    <div class="col-lg-6 col-sm-5 col-xs-12 col-md-6 col-lg-offset-1 col-md-offset-1">
                        <form action="<?php echo urldecode(get_the_permalink($sb_search_page));?>">
                            <div class="sb-bk-new-srch-area">
                                <div class="form-group">
                                    <input placeholder="<?php echo __('What Are You Looking For ?', 'adforest');?>" type="text" name="ad_title"  value="<?php echo esc_attr($search_title);?>" autocomplete="off">                               
                                    <div class="sb-bk-submit-form">
                                        <?php apply_filters('adforest_form_lang_field', true);?>
                                        <button class="btn-theme" type="submit"><i class="fa fa-search-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php
                }
                ?>
                <div class="col-lg-2 col-xs-12 col-sm-4 col-md-3 col-lg-offset-1">
                    <div class="sb-bk-side-btns">
                        <div class="sb-bk-srch-links">
                            <ul class="list-inline sb-bk-srch-contents">
                                <?php
                                if (!is_user_logged_in() && isset($adforest_theme['sb_sign_in_page']) && $adforest_theme['sb_sign_in_page'] != "") {
                                    ?>
                                    <li><a href="<?php echo get_the_permalink($sb_sign_in_page);?>"><i class="fa fa-heart"></i></a></li>
                                    <?php
                                } else {//
                                    ?>
                                    <li title="<?php esc_html_e('Favourite Ads', 'adforest');?>"><a href="<?php echo adforest_set_url_param(trailingslashit(get_the_permalink($sb_profile_page)), 'type', 'fav_ads');?>" ><i class="fa fa-heart"></i></a></li>
                                    <?php
                                }
                                ?>
                                <?php if (class_exists('WooCommerce')) {?>    
                                    <li class="sb-bk-absolute"><i class="fa fa-shopping-basket"></i></li>
                                <?php }?>
                            </ul>
                        </div>
                        <?php if (class_exists('WooCommerce')) {?>
                            <div class="dropdown">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php
                                    $woo_emp_val = 0.00;
                                    if (class_exists('WooCommerce')) {
                                        echo WC()->cart->get_cart_total();
                                    } else {
                                        echo esc_html($woo_emp_val);
                                    }
                                    ?>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1 bk-drop-down">
                                    <?php
                                    if (class_exists('WooCommerce')) {
                                        global $woocommerce, $product;
                                        $woo_items = $woocommerce->cart->get_cart();
                                        if (isset($woo_items) && !empty($woo_items) && is_array($woo_items)) {
                                            foreach ($woo_items as $item => $values) {
                                                $_product = wc_get_product($values['data']->get_id());
                                                $getProductDetail = wc_get_product($values['product_id']);
                                                $product = new WC_Product($values['product_id']);
                                                $image = wp_get_attachment_image_src(get_post_thumbnail_id($values['product_id']), 'adforest-single-small');
                                                $shop_thumb = '<a href="' . esc_url(get_the_permalink($values['product_id'])) . '"><img class="img-responsive" alt="' . get_the_title($values['product_id']) . '" src="' . esc_url(wc_placeholder_img_src('adforest-single-small')) . '"></a>';
                                                if (get_the_post_thumbnail($values['product_id'])) {
                                                    $shop_thumb = '<a href="' . esc_url(get_the_permalink($values['product_id'])) . '">' . get_the_post_thumbnail($values['product_id'], 'adforest-single-small') . '</a>';
                                                }
                                                $getProductDetail->get_image('adforest-single-small'); // accepts 2 arguments ( size, attr )
                                                $price = get_post_meta($values['product_id'], '_price', true);
                                                $price = get_post_meta($values['product_id'], '_price', true);
                                                ?>
                                                <li>
                                                    <div class="sb-bk-top-accesories">
                                                        <div class="sb-bk-top-product">
                                                            <?php echo adforest_returnEcho($shop_thumb);?>
                                                        </div>
                                                        <div class="bk-top-details">
                                                            <a href="<?php echo get_the_permalink($values['product_id'])?>"><h3><?php echo (get_the_title($values['product_id']));?></h3></a>
                                                            <strike>
                                                                <?php
                                                                //echo get_woocommerce_currency_symbol();
                                                                //$price = get_post_meta($values['product_id'], '_regular_price', true);
                                                                //$sale  = get_post_meta($values['product_id'], '_sale_price', true);

                                                                $price = $product->get_regular_price();
                                                                $sale = $product->get_sale_price();

                                                                $product_type = adforest_get_product_type($values['product_id']);
                                                                $var_flag = false;
                                                                if (isset($product_type) && $product_type == 'variable') {
                                                                    //$available_variations = $product->get_available_variations();

                                                                    $tickets = new WC_Product_Variable($values['product_id']);
                                                                    $available_variations = $tickets->get_available_variations();

                                                                    if (isset($available_variations[0]['variation_id']) && !empty($available_variations[0]['variation_id'])) {
                                                                        $variation_id = $available_variations[0]['variation_id'];
                                                                        $variable_product1 = new WC_Product_Variation($variation_id);
                                                                        $price = $variable_product1->get_regular_price();
                                                                        $sale = $variable_product1->get_sale_price();
                                                                    }
                                                                    $var_flag = true;
                                                                }
                                                                //echo esc_html($price);
                                                                ?>
                                                            </strike>
                                                            <span>
                                                                <?php
                                                                if ($var_flag) {
                                                                    echo get_woocommerce_currency_symbol();
                                                                    //echo adforest_returnEcho($sale);
                                                                    echo adforest_returnEcho($price);
                                                                } else {
                                                                    echo adforest_product_price($product);
                                                                }
                                                                ?>
                                                            </span>

                                                        </div>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                        } else {
                                            echo '<li><div class="sb-bk-top-accesories"><a href="javascript:void(0)"><i class="fa fa-trash"></i> ' . esc_html__('Your cart is currently empty.', 'adforest') . '</a></div></li>';
                                        }
                                    } else {
                                        echo '<li><div class="sb-bk-top-accesories"><a href="javascript:void(0)"><i class="fa fa-trash"></i> ' . esc_html__('Your cart is currently empty.', 'adforest') . '</a></div></li>';
                                    }
                                    ?>
                                    <li>
                                        <div class="sb-bk-bottom-box">
                                            <div class="sb-bk-top-area">
                                                <div class="sb-bk-top-order">
                                                    <span class="bk-colors"><?php echo esc_html__('Total Order', 'adforest');?></span>
                                                </div>
                                                <div class="sb-bk-top-content">
                                                    <a href="<?php echo get_permalink(wc_get_page_id('cart'));?>" class="btn-theme"><?php echo esc_html__('View Cart', 'adforest');?></a>
                                                </div>
                                            </div>
                                            <div class="sb-bk-top-order">
                                                <span class="sb-bk-colors">
                                                    <?php
                                                    $woo_emp_val = 0.00;
                                                    if (class_exists('WooCommerce')) {
                                                        echo WC()->cart->get_cart_total();
                                                    } else {
                                                        echo esc_html($woo_emp_val);
                                                    }
                                                    ?>
                                                </span>
                                            </div>
                                            <div class="sb-bk-top-content">
                                                <a href="<?php echo get_permalink(wc_get_page_id('checkout'));?>" class="btn-theme"><?php echo esc_html__('Check Out', 'adforest');?></a>
                                            </div>
                                        </div>
                                    </li>

                                </ul>

                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <?php
    $sb_menu_categories_switch = isset($adforest_theme['sb_menu_categories_switch']) && $adforest_theme['sb_menu_categories_switch'] != '' ? $adforest_theme['sb_menu_categories_switch'] : 1;

    $menu_cat_search_type = isset($adforest_theme['menu_cat_search_type']) && $adforest_theme['menu_cat_search_type'] != '' ? $adforest_theme['menu_cat_search_type'] : 'search_page';


    $sb_menu_categories = isset($adforest_theme['sb_menu_categories']) && $adforest_theme['sb_menu_categories'] != '' ? $adforest_theme['sb_menu_categories'] : array();
    $cats_html = '<li><a href="javascript:void(0)">' . esc_html__('Select Category', 'adforest') . '</a></li>';
    if ($sb_menu_categories_switch && !empty($sb_menu_categories)) {
        foreach ($sb_menu_categories as $sb_menu_cat) {
            $tax = 'cat_id';
            $category_id = $sb_menu_cat;
            $term_data = get_term_by('id', $sb_menu_cat, 'ad_cats');
            $link = adforest_set_url_param(get_the_permalink($sb_search_page), $tax, $category_id);


            if ($menu_cat_search_type == 'cate_page') {
                $link = adforest_cat_link_page($sb_menu_cat, 'category', 'ad_cats');
            } else {
                $link = adforest_set_url_param(get_the_permalink($sb_search_page), $tax, $category_id);
            }




            $cats_html .= '<li><a href="' . $link . '">' . $term_data->name . '</a></li>';
        }
    } else {
        $args = array('hide_empty' => 0);
        $args = apply_filters('adforest_wpml_show_all_posts', $args); // for all lang texonomies
        $ad_cats = get_terms('ad_cats', $args);
        if (isset($ad_cats) && !empty($ad_cats)) {
            foreach ($ad_cats as $cat) {
                $tax = 'cat_id';
                $category_id = $cat->term_id;

                if ($menu_cat_search_type == 'cate_page') {
                    $link = esc_url(get_term_link($category_id));
                } else {
                    $link = adforest_set_url_param(get_the_permalink($sb_search_page), $tax, $category_id);
                }


                $cats_html .= '<li><a href="' . $link . '">' . $cat->name . '</a></li>';
            }
        }
    }
    ?>
    <div class="sb-latest-book-menu">
        <div class="sb-sprt-header">
            <div class="sb-srvs-top-header">
                <div class="sb-top-header-3">
                    <div class="sb-top-header">
                        <nav id="menu-1" class="mega-menu menu-2"> 
                            <!-- menu list items container -->
                            <section class="menu-list-items">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12"> 
                                            <?php if (isset($adforest_theme['sb_menu_categories_switch']) && ($adforest_theme['sb_menu_categories_switch'])) {?>
                                                <ul class="menu-logo">
                                                    <li class="menu-separator dropdown"> <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                                            <div class="book-menu-list-items">
                                                                <i class="fa fa-bars"></i>
                                                            </div>
                                                            <?php echo esc_html__('All Categories', 'adforest');?></a>
                                                        <ul class="dropdown-menu">
                                                            <?php echo adforest_returnEcho($cats_html);?>
                                                        </ul>
                                                    </li>
                                                </ul>
                                                <?php
                                            } else {
                                                if (wp_is_mobile()) {
                                                    ?>
                                                    <div class="menu-mobile-collapse-trigger"><span></span></div>
                                                            <?php
                                                        }
                                                    }
                                                    get_template_part('template-parts/layouts/main', 'nav');
                                                    ?>

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

</div>



