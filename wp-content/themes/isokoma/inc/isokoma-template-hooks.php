
<?php
/**
 * Isokoma hooks
 *
 * @package Isokoma
 */


/**
 * General
 * @see  storefront_scripts()
 */
add_action( 'isokoma_header_nav', 'storefront_header_cart', 		60 );
add_action( 'isokoma_slider', 			'isokoma_featured_slider',			60 );
add_action( 'isokoma_page', 			'storefront_page_content',		10 );
add_action( 'isokoma_breadcrumb', 				'woocommerce_breadcrumb', 					10 );
// add_action( 'retailer_slider', 'retailer_featured_slider',	60 );

add_action( 'isokoma_new_product', 'isokoma_new_product_slider',	60 );
add_action( 'isokoma_hot_product', 'isokoma_hot_product_slider',	60 );
add_action( 'isokoma_product_category', 'isokoma_product_categories',	60 );



//add_action( 'isokoma_content_page', 			'storefront_page_content',		10 );