<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $product;
$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );
if ( ! $short_description ) {
	return;
}
if($short_description  != ''){
?>      
<div class="description-overview">
	<h3><?php echo esc_html__("Overview", "adforest");?></h3>
    <?php echo ''.$short_description;  ?> 
</div>
<?php } ?>
