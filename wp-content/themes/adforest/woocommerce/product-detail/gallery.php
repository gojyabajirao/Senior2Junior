<?php
defined( 'ABSPATH' ) || exit;
global  $product;
$full_img = $get_img_thumb = $product_id = '';
$product_id = get_the_ID();
$product = wc_get_product( $product_id );

$sale_banner = '';
if( $product->is_on_sale() ) {
	$sale_banner = '<span class="prod-sale-banner">'.esc_html__('Sale','adforest').'</span>';
}
if( $product->get_image_id() != "")
{
?>

    <div class="flexslider single-page-slider" id="overview">
    <div class="flex-viewport">
      <ul class="slides slide-main">   
		<?php	
        $fetch_images =  adforest_fetch_product_images($product_id); 
        foreach( $fetch_images as $product_images )
        {
            $full_img 		=	wp_get_attachment_image_src( $product_images ,'adforest-shop-gallery-main' );
            /*$get_img_thumb 	=	wp_get_attachment_image_src( $product_images ,'adforest-shop-thumbnail' );*/
            $product_title = get_the_title($product_id);
             echo '<li class=""><img alt="'.esc_html( $product_title ).'" src="'.esc_url( $full_img[0]).'" title="'.esc_html($product_title).'" data-sale-type="'.esc_attr($sale_banner).'"></li>';
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
        $fetch_images =  adforest_fetch_product_images($product_id); 
        foreach( $fetch_images as $product_images )
        {
            //$full_img 		=	wp_get_attachment_image_src( $product_images ,'full' );
            $get_img_thumb 	=	wp_get_attachment_image_src( $product_images ,'adforest-shop-gallery' );
            $product_title = get_the_title($product_id);
             echo '<li class=""><img alt="'.esc_html( $product_title ).'" src="'.esc_url( $get_img_thumb[0]).'" title="'.esc_html($product_title).'" data-sale-type="'.esc_attr($sale_banner).'"></li>';
        }
        ?>
  </ul>
</div>
</div>

<?php
}
else
{
?>
<?php echo ''.$sale_banner; ?>
<img class="img-responsive" alt="<?php esc_html__( 'image', 'adforest' ); ?>" src="<?php echo esc_url( wc_placeholder_img_src() ); ?>">
<?php
	}
?>