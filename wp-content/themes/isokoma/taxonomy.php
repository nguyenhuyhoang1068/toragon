<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
	
	global $wp;	
	$current_url = home_url( add_query_arg( array(), $wp->request ) ); 						
	$url_array = explode('/',$current_url); 
?>
<?php 
if ( is_search() ) { 	
?>
<div class="breadcrumbs-area">
	<div class="box-breadcrumb mobile deskstop">			
		<div class="banner-text text-center">
			<h2 class="mb-0"><?php			
				 _e('Kết quả tìm kiếm', 'isokoma'); 			
			?></h2>
			<div class="d-none d-sm-block"><?php  _e('Trang chủ', 'isokoma'); ?> > <?php  _e('Sản phẩm', 'isokoma'); ?></div>
		</div>		
			<img class="breadcrumb-icon mobile" src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-1.png" alt="">
			<img class="breadcrumb-icon desktop" src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_1.jpg" alt="">		
	</div>
</div>


<div class="container">
	<div class="product-category" id="product_search_content">
		<div class="row">			
			<div class="col-12 col-sm-12 content-r">
			<div class="mb-3">Kết quả tìm kiếm cho từ khóa <b><?php 			 
			 echo $_GET['s'];
			 ?></b></div>
	<?php
	do_action('woocommerce_before_main_content');
	if (woocommerce_product_loop()) {

		/**
		 * Hook: woocommerce_before_shop_loop.
		 *
		 * @hooked woocommerce_output_all_notices - 10
		 * @hooked woocommerce_result_count - 20
		 * @hooked woocommerce_catalog_ordering - 30
		 */
		do_action('woocommerce_before_shop_loop');		
	?>		
			<?php woocommerce_product_loop_start(); ?>
			
				<?php
				if (wc_get_loop_prop('total')) {
					while (have_posts()) {
						the_post();
						/**
						 * Hook: woocommerce_shop_loop.
						 */
						do_action('woocommerce_shop_loop');						
						//echo get_post_meta($loop->post->ID, 'custom_text_field_pre_order', true) ;
						wc_get_template_part('content', 'product');				
						
					}
				}
				woocommerce_product_loop_end();
				?>
			
	<?php
		/**
		 * Hook: woocommerce_after_shop_loop.
		 *
		 * @hooked woocommerce_pagination - 10
		 */
		echo '<div class="wrap-pagination">';		
		do_action('woocommerce_after_shop_loop');
		echo '</div>';
	} else {
		/**
		 * Hook: woocommerce_no_products_found.
		 *
		 * @hooked wc_no_products_found - 10
		 */
		do_action('woocommerce_no_products_found');
	}

	/**
	 * Hook: woocommerce_after_main_content.
	 *
	 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
	 */
	do_action('woocommerce_after_main_content');

	/**
	 * Hook: woocommerce_sidebar.
	 *
	 * @hooked woocommerce_get_sidebar - 10
	 */
	do_action('woocommerce_sidebar');
	
	
	?>
			</div>
		</div>
</div>
</div>



<?php
} else {
?>
<div class="breadcrumbs-area">
	<div class="box-breadcrumb mobile deskstop">			
		<div class="banner-text text-center">
			<h2 class="mb-0"><?php
				if ((in_array('toys', $url_array))  && (in_array('product-category', $url_array))
				|| (in_array('hot-toys', $url_array))  && (in_array('brand', $url_array))	
				|| (in_array('bearbrick', $url_array))  && (in_array('brand', $url_array))				
				|| (in_array('pop-mart', $url_array))  && (in_array('brand', $url_array)))	{
					 _e('Toys', 'isokoma'); 
				}		
				if ((in_array('tranh', $url_array))  && (in_array('product-category', $url_array))							
				)	{
					 _e('Tranh', 'isokoma'); 
				}
				if ((in_array('hang-gia-dung', $url_array))  && (in_array('product-category', $url_array))							
				)	{
					 _e('Hàng gia dụng', 'isokoma'); 
				}
				if ((in_array('thoi-trang', $url_array))  && (in_array('product-category', $url_array))	
				|| (in_array('bape', $url_array))  && (in_array('brand', $url_array))	
				|| (in_array('medicom-toy', $url_array))  && (in_array('brand', $url_array))							
				)	{
					 _e('Thời Trang', 'isokoma'); 
				}
				if ((in_array('do-dien-tu', $url_array))  && (in_array('product-category', $url_array))							
				)	{
					 _e('Đồ Điện Tử', 'isokoma'); 
				}
				if (in_array('shop', $url_array)) {
					 _e('Shop', 'isokoma'); 
				}
			
			?></h2>
			<div class="d-none d-sm-block"><?php  _e('Trang chủ', 'isokoma'); ?> > <?php  _e('Sản phẩm', 'isokoma'); ?></div>
		</div>
		<?php if ((in_array('toys', $url_array))  && (in_array('product-category', $url_array))
			|| (in_array('hot-toys', $url_array))  && (in_array('brand', $url_array))	
			|| (in_array('bearbrick', $url_array))  && (in_array('brand', $url_array))				
			|| (in_array('pop-mart', $url_array))  && (in_array('brand', $url_array))	
			|| (in_array('shop', $url_array)) 	
			) { ?>
			<img class="breadcrumb-icon mobile" src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-1.png" alt="">
			<img class="breadcrumb-icon desktop" src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_1.jpg" alt="">
		<?php } ?>
		<?php if ((in_array('tranh', $url_array))  && (in_array('product-category', $url_array)) ) { ?>
			<img class="breadcrumb-icon mobile" src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-3.png" alt="">
			<img class="breadcrumb-icon desktop" src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_2.jpg" alt="">
		<?php } ?>
		<?php if ((in_array('hang-gia-dung', $url_array))  && (in_array('product-category', $url_array)) ) { ?>
			<img class="breadcrumb-icon mobile" src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-4.png" alt="">
			<img class="breadcrumb-icon desktop" src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_5.jpg" alt="">
		<?php } ?>
		<?php if ((in_array('thoi-trang', $url_array))  && (in_array('product-category', $url_array)) 
			|| (in_array('medicom-toy', $url_array))  && (in_array('brand', $url_array))	
			|| (in_array('bape', $url_array))  && (in_array('brand', $url_array))		
			) { ?>
			<img class="breadcrumb-icon mobile" src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-2.png" alt="">
			<img class="breadcrumb-icon desktop" src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_3.jpg" alt="">
		<?php } ?>
		<?php if ((in_array('do-dien-tu', $url_array))  && (in_array('product-category', $url_array)) ) { ?>
			<img class="breadcrumb-icon mobile" src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-5.png" alt="">
			<img class="breadcrumb-icon desktop" src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_4.jpg" alt="">
		<?php } ?>
	</div>
</div>
<div class="container">
	<div class="product-category" id="product_product_content">
		<div class="row">
			<div class="col-12 col-sm-3 content-l">
				<div class="l-menu">
          
          <?php dynamic_sidebar('leftsidebar'); ?>
					<h5><?php  _e('Thương hiệu', 'isokoma'); ?></h5>
					<div class="list-group">
					<?php						
						if ((in_array('toys', $url_array))  && (in_array('product-category', $url_array))
							|| ((in_array('brand', $url_array))  && (in_array('bearbrick', $url_array)))
							|| ((in_array('brand', $url_array))  && (in_array('hot-toys', $url_array)))
							|| ((in_array('brand', $url_array))  && (in_array('pop-mart', $url_array)))
						) {
							wp_nav_menu( array(
								'theme_location' => 'brandtoys-nav', 
								'container' => 'nav', 
								'container_class' => 'main-nav',
							));							
						}		
						if ((in_array('thoi-trang', $url_array))  && (in_array('product-category', $url_array))
						|| ((in_array('brand', $url_array))  && (in_array('medicom-toy', $url_array)))
						|| ((in_array('brand', $url_array))  && (in_array('bape', $url_array)))						
						) {
							wp_nav_menu( array(
								'theme_location' => 'brandfashion-nav', 
								'container' => 'nav', 
								'container_class' => 'main-nav',
							));							
						}						
					?>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-9 content-r">
	<?php
	do_action('woocommerce_before_main_content');
	if (woocommerce_product_loop()) {

		/**
		 * Hook: woocommerce_before_shop_loop.
		 *
		 * @hooked woocommerce_output_all_notices - 10
		 * @hooked woocommerce_result_count - 20
		 * @hooked woocommerce_catalog_ordering - 30
		 */
		do_action('woocommerce_before_shop_loop');		
	?>		
			<?php woocommerce_product_loop_start(); ?>
			
				<?php
				if (wc_get_loop_prop('total')) {
					while (have_posts()) {
						the_post();
						/**
						 * Hook: woocommerce_shop_loop.
						 */
						do_action('woocommerce_shop_loop');						
						//echo get_post_meta($loop->post->ID, 'custom_text_field_pre_order', true) ;
						wc_get_template_part('content', 'product');				
						
					}
				}
				woocommerce_product_loop_end();
				?>
			
	<?php
		/**
		 * Hook: woocommerce_after_shop_loop.
		 *
		 * @hooked woocommerce_pagination - 10
		 */
		echo '<div class="wrap-pagination">';		
		do_action('woocommerce_after_shop_loop');
		echo '</div>';
	} else {
		/**
		 * Hook: woocommerce_no_products_found.
		 *
		 * @hooked wc_no_products_found - 10
		 */
		do_action('woocommerce_no_products_found');
	}

	/**
	 * Hook: woocommerce_after_main_content.
	 *
	 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
	 */
	do_action('woocommerce_after_main_content');

	/**
	 * Hook: woocommerce_sidebar.
	 *
	 * @hooked woocommerce_get_sidebar - 10
	 */
	do_action('woocommerce_sidebar');
	
	
	?>
			</div>
		</div>
</div>
</div>



<?php
}
?>
<?php
get_footer('shop');
?>
