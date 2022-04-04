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
$current_url = home_url(add_query_arg(array(), $wp->request));
$url_array = explode('/', $current_url);
$remove_page_param = explode('page/', $current_url);

//Menu Brand toy 	
$flag_brandtoy = false;
$main_brandtoy_items = wp_get_nav_menu_items(62);
foreach ((array) $main_brandtoy_items as $key => $menu_item) {
	if (in_array('brands', $url_array)) {
		if (($current_url === rtrim($menu_item->url, '/'))
			|| ($current_url === $menu_item->url)
			|| ($remove_page_param[0] === $menu_item->url)
		) {
			$flag_brandtoy = true;
		}
	}
}
//Menu Brand Fashion 	
$flag_brandfashion = false;
$main_brandfashion_items = wp_get_nav_menu_items(63);
foreach ((array) $main_brandfashion_items as $key => $menu_item) {
	if (in_array('brands', $url_array)) {
		if (($current_url === rtrim($menu_item->url, '/')) || ($current_url === $menu_item->url)
			|| ($remove_page_param[0] === $menu_item->url)
		) {
			$flag_brandfashion = true;
		}
	}
}

//Menu Electronic 	
$flag_brandelectronic = false;
$main_brandelectronic_items = wp_get_nav_menu_items(128);
foreach ((array) $main_brandelectronic_items as $key => $menu_item) {
	if (in_array('brands', $url_array)) {
		if (($current_url === rtrim($menu_item->url, '/')) || ($current_url === $menu_item->url)
			|| ($remove_page_param[0] === $menu_item->url)
		) {
			$flag_brandelectronic = true;
		}
	}
}

//Menu hanggiadung 	
$flag_brandhanggiadung = false;
$main_brandhanggiadung_items = wp_get_nav_menu_items(129);
foreach ((array) $main_brandhanggiadung_items as $key => $menu_item) {
	if (in_array('brands', $url_array)) {
		if (($current_url === rtrim($menu_item->url, '/')) || ($current_url === $menu_item->url)
			|| ($remove_page_param[0] === $menu_item->url)
		) {
			$flag_brandhanggiadung = true;
		}
	}
}

//Menu tranh 	
$flag_brandtranh = false;
$main_brandtranh_items = wp_get_nav_menu_items(130);
foreach ((array) $main_brandtranh_items as $key => $menu_item) {
	if (in_array('brands', $url_array)) {
		if (($current_url === rtrim($menu_item->url, '/')) || ($current_url === $menu_item->url)
			|| ($remove_page_param[0] === $menu_item->url)
		) {
			$flag_brandtranh = true;
		}
	}
}

//Main menu	
$flag_mainmenu = false;
$main_menu_items = wp_get_nav_menu_items(43);
foreach ((array) $main_menu_items as $key => $menu_item) {
	if (in_array('product-category', $url_array)) {
		if ((rtrim($current_url, '/') === rtrim($menu_item->url, '/')) || ($current_url === $menu_item->url)
			|| ($remove_page_param[0] === $menu_item->url)
		) {
			$flag_mainmenu = true;
		}
	}
}

?>
<!--<div class="breadcrumbs-area">
	<div class="box-breadcrumb mobile deskstop">			
		<div class="banner-text text-center">
			<h2 class="mb-0"></h2>
			<div class="d-none d-sm-block"><?php _e('Trang chủ', 'isokoma'); ?> > <?php _e('Sản phẩm', 'isokoma'); ?></div>
		</div>
		<?php
		//icon for brand
		if ($flag_brandtoy == TRUE) { ?>               
        <noscript><img src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-1.png"  alt=""></noscript>
        <img class=" ls-is-cached lazyloaded breadcrumb-icon mobile" src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-1.png" data-src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-1.png" alt="">
        
        <noscript><img src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_1.jpg" alt=""></noscript>
        <img class=" ls-is-cached lazyloaded breadcrumb-icon desktop" src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_1.jpg" data-src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_1.jpg" alt="">
          
			<?php	} elseif ($flag_brandtranh == TRUE) { ?>
        <noscript><img src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-3.png"  alt=""></noscript>
        <img class=" ls-is-cached lazyloaded breadcrumb-icon mobile" src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-3.png" data-src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-3.png" alt="">
        
        <noscript><img src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_3.jpg" alt=""></noscript>
        <img class=" ls-is-cached lazyloaded breadcrumb-icon desktop" src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_3.jpg" data-src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_3.jpg" alt="">
        				
			<?php } elseif ($flag_brandhanggiadung == TRUE) { ?>
        <noscript><img src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-4.png"  alt=""></noscript>
        <img class=" ls-is-cached lazyloaded breadcrumb-icon mobile" src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-4.png" data-src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-4.png" alt="">
        
        <noscript><img src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_4.jpg" alt=""></noscript>
        <img class=" ls-is-cached lazyloaded breadcrumb-icon desktop" src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_4.jpg" data-src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_4.jpg" alt="">
        
			<?php } elseif ($flag_brandfashion == TRUE) {  ?>

        <noscript><img src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-2.png"  alt=""></noscript>
        <img class=" ls-is-cached lazyloaded breadcrumb-icon mobile" src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-2.png" data-src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-2.png" alt="">
        
        <noscript><img src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_2.jpg" alt=""></noscript>
        <img class=" ls-is-cached lazyloaded breadcrumb-icon desktop" src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_2.jpg" data-src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_2.jpg" alt="">
        
			<?php } elseif ($flag_brandelectronic == TRUE) { ?>

        <noscript><img src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-5.png"  alt=""></noscript>
        <img class=" ls-is-cached lazyloaded breadcrumb-icon mobile" src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-5.png" data-src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-5.png" alt="">
        
        <noscript><img src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_5.jpg" alt=""></noscript>
        <img class=" ls-is-cached lazyloaded breadcrumb-icon desktop" src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_5.jpg" data-src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_5.jpg" alt="">
        
			<?php } elseif (in_array('product-category', $url_array)) { ?>				
				<img class="breadcrumb-icon mobile" src="<?php echo Categories_Multiple_Images::get_image($category->term_id, 1, 'full'); ?>" alt="">
				<img class="breadcrumb-icon desktop" src="<?php echo Categories_Multiple_Images::get_image($category->term_id, 2, 'full'); ?>" alt="">		
			<?php } else { ?>
				 <noscript><img src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-5.png"  alt=""></noscript>
        <img class=" ls-is-cached lazyloaded breadcrumb-icon mobile" src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-5.png" data-src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-5.png" alt="">
        
        <noscript><img src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_5.jpg" alt=""></noscript>
        <img class=" ls-is-cached lazyloaded breadcrumb-icon desktop" src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_5.jpg" data-src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_5.jpg" alt="">
        
			<?php } ?>		
		
	</div>
</div>-->
<div class="container">
	<div class="product-category" id="product_product_content">
		<div class="product-cat-name text-center">
			<h2><?php
				if (in_array('product-category', $url_array)) {
					$category_vi = get_term_by('slug', $url_array[4], 'product_cat');
					$category_en = get_term_by('slug', $url_array[5], 'product_cat');
					if ($category_vi) {
						$category = $category_vi;
					}

					if ($category_en) {
						$category = $category_en;
					}

					echo $category->name;
				} elseif (in_array('brands', $url_array)) {
					if ($flag_brandtoy == TRUE) {
						_e('Art toys', 'isokoma');
					}
					if ($flag_brandfashion == TRUE) {
						_e('Thời trang', 'isokoma');
					}
					if ($flag_brandelectronic == TRUE) {
						_e('Hàng điện tử', 'isokoma');
					}
					if ($flag_brandhanggiadung == TRUE) {
						_e('Hàng gia dụng', 'isokoma');
					}
					if ($flag_brandtranh == TRUE) {
						_e('Tranh', 'isokoma');
					}
				} else {
					_e('All Shops', 'isokoma');
				}

				?></h2>
			<img src="https://toragon.vn/wp-content/uploads/2022/01/design-element.png" alt="toragon">
		</div>
		<div class="row">
			<div class="col-12 col-sm-3 content-l">
				<?php dynamic_sidebar('leftsidebar'); ?>
				<div class="l-menu">

					<?php if (($flag_brandtoy == true) || ((in_array('product-category', $url_array)) && (in_array('arttoys', $url_array)))) { ?>
						<h5><?php _e('Thương hiệu', 'isokoma'); ?></h5>
						<div class="list-group">
							<?php
							wp_nav_menu(array(
								'theme_location' => 'brandtoys-nav',
								'container' => 'nav',
								'container_class' => 'main-nav',

							));
							?>
						</div>
					<?php } ?>
					<?php if (($flag_brandfashion == true) || ((in_array('product-category', $url_array)) && (in_array('thoi-trang', $url_array)))) { ?>
						<h5><?php _e('Thương hiệu', 'isokoma'); ?></h5>
						<div class="list-group">
							<?php
							wp_nav_menu(array(
								'theme_location' => 'brandfashion-nav',
								//'theme_location' => 'brandtoys-nav',
								'container' => 'nav',
								'container_class' => 'main-nav',
							));
							?>
						</div>
					<?php } ?>
					<?php if ($flag_brandelectronic == true) { ?>
						<h5><?php _e('Thương hiệu', 'isokoma'); ?></h5>
						<div class="list-group">
							<?php
							wp_nav_menu(array(
								'theme_location' => 'brandelectronic-nav',
								//'theme_location' => 'brandtoys-nav',
								'container' => 'nav',
								'container_class' => 'main-nav',
							));
							?>
						</div>
					<?php } ?>
					<?php if ($flag_brandhanggiadung == true) { ?>
						<h5><?php _e('Thương hiệu', 'isokoma'); ?></h5>
						<div class="list-group">
							<?php
							wp_nav_menu(array(
								'theme_location' => 'brandhanggiadung-nav',
								//'theme_location' => 'brandtoys-nav',
								'container' => 'nav',
								'container_class' => 'main-nav',
							));
							?>
						</div>
					<?php } ?>
					<?php if (($flag_brandtranh == true) || ((in_array('product-category', $url_array)) && (in_array('tranh', $url_array)))) { ?>
						<h5><?php _e('Thương hiệu', 'isokoma'); ?></h5>
						<div class="list-group">
							<?php
							wp_nav_menu(array(
								'theme_location' => 'brandtranh-nav',
								//'theme_location' => 'brandtoys-nav',
								'container' => 'nav',
								'container_class' => 'main-nav',
							));
							?>
						</div>
					<?php } ?>
					<?php if (in_array('shop', $url_array)) { ?>
						<h5><?php _e('Thương hiệu', 'isokoma'); ?></h5>
						<div class="list-group">
							<?php
							wp_nav_menu(array(
								'theme_location' => 'brandtoys-nav',
								'container' => 'nav',
								'container_class' => 'main-nav',
							));
							?>
						</div>
					<?php } ?>

				</div>
			</div>
			<div class="col-12 col-sm-9 content-r">
				<h1 class="page-title" style="display: none;"><?php
																printf(__('Category Archives: %s', 'isokoma'), ' ' . single_cat_title('', false) . ' ');
																?></h1>
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

get_footer('shop');


?>