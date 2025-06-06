<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>

<li <?php wc_product_class( '', $product ); ?>>
<div class="card box-product">
	<div class="wrap-img">
		<?php 
			$thumb_id = get_post_thumbnail_id();
			$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'isokoma-banner-500', true);
			$thumb_url = $thumb_url_array[0];
		?>						
		<a href="<?php the_permalink(); ?>">
			<?php 
				echo '<img src="'.$thumb_url.'"  />'; 
			?>
		</a>
	</div>
	<div class="card-body">	
		<?php if ($product->single_add_to_cart_text() === 'Pre-Order') : ?>			
			<div class="pre-order">
				<?php echo 'Pre-Order' ; ?>
			</div>
		<?php endif; ?>							
		<h3 class="product-name">			
			<a href="<?php echo get_permalink( $product->get_id() ) ?>">
				<?php echo $product->get_title(); ?>
			</a>
    </h3>									
		<p class="text-center txt-blur small">
			<b><?php echo get_post_meta($product->get_id(), 'custom_text_field_size', TRUE); ?></b>
		</p>							
		<p class="text-center txt-blur small">
			<?php echo $product->get_price_html(); ?>
		</p>							
		<?php
				add_action( 'isokoma_single_product_out_of_stock', 'isokoma_out_of_stock',		10 );
				do_action( 'isokoma_single_product_out_of_stock' );
		?>
		<?php wp_commerce_template_single_add_to_cart(); ?>
	</div>
</div>	

	<?php
	
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	

	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	
	
	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	//do_action( 'woocommerce_after_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item' );
	?>
</li>


