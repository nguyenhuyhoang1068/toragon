<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="summary entry-summary">
		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		do_action( 'woocommerce_single_product_summary' );		
		
		wp_commerce_template_single_add_to_cart();
		?>
	</div>

	
	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>


<div id="recent-product" class="related products">
	
		<?php
		global $woocommerce;		
		$viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
		$viewed_products = array_filter( array_map( 'absint', $viewed_products ) );		
		if ( empty( $viewed_products ) ){
			return ;		
		}
			
		ob_start();		
		echo '<h2>';
		 _e('Sản phẩm đã xem', 'isokoma'); 
		echo '</h2>';				
		echo '<ul class="products columns-4">';	
		if( !isset( $per_page ) ? $number = 4 : $number = $per_page )
		// Create query arguments array
		$query_args = array(
										'posts_per_page' => $number, 
										'no_found_rows'  => 1, 
										'post_status'    => 'publish', 
										'post_type'      => 'product', 
										'post__in'       => $viewed_products, 
										'orderby'        => 'rand'
										);
		// Add meta_query to query args
		$query_args['meta_query'] = array();
		// Check products stock status
		$query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
		// Create a new query
		$loop = new WP_Query($query_args);
		if ($loop->have_posts()) :
		while ( $loop->have_posts() ) : $loop->the_post(); global $product;	 ?>				
			<li class="product">
				<div class="card box-product">
					<div class="wrap-img">						
						<?php 
							$thumb_id = get_post_thumbnail_id();
							$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'isokoma-banner-500', true);
							$thumb_url = $thumb_url_array[0];
						?>													
						<a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">		
							<img src="<?php echo $thumb_url ?>"  />
						</a>
           
					</div>
					<div class="card-body">						
						<?php if ($product->single_add_to_cart_text() === 'Pre-Order') : ?>			
							<div class="pre-order">
								<?php echo 'Pre-Order' ; ?>
							</div>
						<?php endif; ?>			
						<h3 class="product-name">
						<a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
							<?php the_title(); ?>
						</a>
            </h3>
						<p class="text-center txt-blur small">
						<?php if ( get_post_meta($loop->post->ID, 'custom_text_field_size', true) ) : ?>										
							<b><?php echo get_post_meta($loop->post->ID, 'custom_text_field_size', TRUE); ?></b>							
						<?php endif; ?>	
						</p>
						<p class="text-center txt-blur small">
							<?php echo $product->get_price_html(); ?>
						</p>	
						<?php
								add_action( 'isokoma_single_product_out_of_stock', 'isokoma_out_of_stock',		10 );
								do_action( 'isokoma_single_product_out_of_stock' );
						?>
						<?php 								
							wp_commerce_template_single_add_to_cart();								
						?>			
						
					</div>
          <?php   
              echo do_shortcode( '[woosw id="' . $product->get_id() . '"]');
            ?>	
				</div>											
				</li>
			<?php endwhile; 
			endif;
			wp_reset_postdata();
		?>
  </ul>	
</div>
