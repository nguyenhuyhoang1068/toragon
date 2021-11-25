<?php
/**
 * Single product short description
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/short-description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

	global $post;
	global $product;
	$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );

?>


	<div class="txt-blur mb-2"><b><?php echo _e('MSP', 'isokoma'); ?>:</b> <?php 
		
		echo $product->get_sku();
	?> </div>
	<?php if ( get_post_meta($post->ID, 'custom_text_field_size', true) ) : ?>				
	<div class="txt-blur mb-3"><b>SIZE:</b>
		<?php echo get_post_meta($post->ID, 'custom_text_field_size', TRUE); ?>
	</div>
	<?php endif; ?>	
	
	<p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>"><?php echo $product->get_price_html(); ?></p>

	<?php
		add_action( 'isokoma_single_product_quantity_action', 'isokoma_get_quantity_availability',		40 );
		do_action( 'isokoma_single_product_quantity_action' );
	?>
  <?php if (!empty($short_description) ) {?>
  <hr>
	<?php echo $short_description; // WPCS: XSS ok. ?>
  <?php } ?>