<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$terms = get_the_terms( $post->ID, 'product_cat' );
foreach ($terms as $term) {
	$slug = $term->slug;
	$term_name = $term->name;	
}

get_header( 'shop' ); ?>
<div class="product-detail">
<div class="breadcrumbs-area">
	<div class="box-breadcrumb mobile deskstop">			
		<div class="banner-text text-center">
			<h2 class="mb-0"><?php echo $term_name; ?></h2>
			<div class="d-none d-sm-block"><?php  _e('Trang chủ', 'isokoma'); ?> > <?php  _e('Sản phẩm', 'isokoma'); ?></div>
		</div>
		<?php if ($slug === 'toys') { ?>
			<img class="breadcrumb-icon mobile" src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-1.png" alt="">
			<img class="breadcrumb-icon desktop" src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_1.jpg" alt="">
		<?php } ?>
		<?php if ($slug === 'tranh')  { ?>
			<img class="breadcrumb-icon mobile" src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-3.png" alt="">
			<img class="breadcrumb-icon desktop" src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_2.jpg" alt="">
		<?php } ?>
		<?php if ($slug === 'hang-gia-dung')  { ?>
			<img class="breadcrumb-icon mobile" src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-4.png" alt="">
			<img class="breadcrumb-icon desktop" src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_5.jpg" alt="">
		<?php } ?>
		<?php if ($slug === 'thoi-trang') { ?>
			<img class="breadcrumb-icon mobile" src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-2.png" alt="">
			<img class="breadcrumb-icon desktop" src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_3.jpg" alt="">
		<?php } ?>
		<?php if  ($slug === 'do-dien-tu') { ?>
			<img class="breadcrumb-icon mobile" src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-5.png" alt="">
			<img class="breadcrumb-icon desktop" src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_4.jpg" alt="">
		<?php } ?>
	</div>
</div>
<div class="container">
	<div class="product-detail-inner">
	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>

			<?php wc_get_template_part( 'content', 'single-product' ); ?>
		
	
		<?php endwhile; // end of the loop. ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>
</div>
</div>
</div>
<?php
get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
