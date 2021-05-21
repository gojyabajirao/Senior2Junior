<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */
global $adforest_theme;
if (get_current_user_id() == "" && isset($adforest_theme['shop-turn-on']) && $adforest_theme['shop-turn-on'] == false) {
    $sb_sign_in_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_sign_in_page']);
    wp_redirect(get_the_permalink($sb_sign_in_page));
    exit;
} else if (get_current_user_id() != "" && isset($adforest_theme['shop-turn-on']) && $adforest_theme['shop-turn-on'] == false) {
    $sb_profile_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_profile_page']);
    wp_redirect(get_the_permalink($sb_profile_page));
    exit;
} else {
    defined('ABSPATH') || exit;

    /**
     * My Account navigation.
     *
     * @since 2.6.0
     */
    do_action('woocommerce_account_navigation');
    ?>

    <div class="woocommerce-MyAccount-content">
        <?php
        /**
         * My Account content.
         *
         * @since 2.6.0
         */
        do_action('woocommerce_account_content');
        ?>
    </div>
<?php } ?>