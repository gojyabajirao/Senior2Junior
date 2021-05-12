<?php
/**
 * External product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/external.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$product	=	wc_get_product( get_the_ID() );
?>
<a class="btn btn-theme" target="_blank" href="<?php echo esc_url( $product->get_product_url() ); ?>" rel="nofollow">
    <i class="fa fa-rocket" aria-hidden="true"></i> <span id="cart_msg"><?php echo esc_html( $product->get_button_text() ); ?></span>
</a>