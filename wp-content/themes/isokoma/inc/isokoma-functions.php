<?php
/**
 * Isokoma  functions.
 *
 * @package Isokoma
 */


/**
 * Query WooCommerce activation
 */
function isokoma_is_woocommerce_activated() {
	return class_exists( 'woocommerce' ) ? true : false;
}
function isokoma_theme_setup() {
	add_image_size( 'isokoma-thumb-400', 400, 400, true );
	add_image_size( 'isokoma-banner-500', 500, 500, true );	
	add_image_size( 'carousel_image', 1200, 500, true );		
}


if(!function_exists('isokoma_highlight_search_keyword_title')){
	function isokoma_highlight_search_keyword_title(){
			$title = get_the_title( );
			$keys = implode('|' , explode(' ', get_search_query( )));
			$title = preg_replace('/('.$keys.')/iu', '<span class="selection">\0</span>' ,$title);
			echo $title;
	}
}
if(!function_exists('isokoma_highlight_search_keyword_excerpt')){
	function isokoma_highlight_search_keyword_excerpt( $limit){
			$title = get_the_excerpt( );
			$keys = implode('|' , explode(' ', get_search_query( )));
			// limit words
			$excerpt = explode(' ', get_the_excerpt(  ), $limit); // array có số phần tử = limit
			array_pop($excerpt);
			$excerpt = implode(' ',$excerpt );

			$excerpt = preg_replace('/('.$keys.')/iu', '<span class="selection">\0</span>' ,$title).'... <a href="'.get_permalink( $id_post ).'">'.__('Read more','glw').'</a>';
			
			echo $excerpt;
	}
}

if(!function_exists('isokoma_custom_pagination')){
	function isokoma_custom_pagination( WP_Query $wp_query = null , $echo = true){
			if($wp_query === null){
					global $wp_query;
			}

			$pages = paginate_links( array(
					'base'  => str_replace(9999999999, '%#%', esc_url(get_pagenum_link( 9999999999))),
					'format'    => '?paged=%#%',
					'current'   => max(1, get_query_var('paged')),
					'total'     => $wp_query->max_num_pages,
					'type'      => 'array',
					'show_all'  => false,
					'end_size'  => 2,
					'mid_size'  => 1,
					'prev_next' => true,
					'prev_text' => '<i class="zmdi zmdi-chevron-left"></i>',
					'next_text' => '<i class="zmdi zmdi-chevron-right"></i>',
					'add_args'  => false,
					'add_fragment'  => ''
			));
			if(is_array($pages)){
					$pagination = '<div class="rt-pagination pt-60 text-center">
														 <ul class="clearfix">';
					foreach($pages as $page){
							$pagination .= '<li'. (strpos($page,'current')!== false ? ' class="active" ':'') .'>';
							if(strpos($page,'current')!== false){
									if(get_query_var( 'paged' )>1){
											$pagination .='<a>'.get_query_var( 'paged' ).'</a>';
									}else{
											$pagination .= '<a>'. 1 .'</a>';
									}       
							}else{
									$pagination .= str_replace('class="page-numbers"','',$page);
							}
							$pagination .='</li>';
					}
					// $pagination  .=   

					$pagination .= '</ul></div>';
					echo $pagination;
			}
			return null;
	}
}

if ( ! function_exists( 'isokoma_out_of_stock' ) ):
	function isokoma_out_of_stock() {
		global $product;	
		if (is_user_logged_in()) { 	
			if ( ! $product->managing_stock() && ! $product->is_in_stock() ){
        echo '<div class="woocommerce-product-details__short-description out-of-stock">';
				echo '<div class="text-danger text-center"><div class="cart">';
				echo '<button type="submit" name="add-to-cart" value="" class="single_add_to_cart_button button alt">';
				_e('Hết hàng', 'isokoma');
				echo "</button></div></div>";
        echo "</div>";
			}
			if (!$product->is_type('variable')) {
				if ($product->get_manage_stock()) {
					if (!$product->is_in_stock()) {
            echo '<div class="woocommerce-product-details__short-description out-of-stock">';
						echo '<div class="text-danger text-center"><div class="cart">';
						echo '<button type="submit" name="add-to-cart" value="" class="single_add_to_cart_button button alt">';
						_e('Hết hàng', 'isokoma');
						echo "</button></div></div>";
            echo "</div>";
					}
				}
			}	
			
		} else {
			if ( ! $product->managing_stock() && ! $product->is_in_stock() ){
				echo '<div class="remaining-out-stock text-center">';
				_e('Hết hàng', 'isokoma');
				echo "</div>";
			}
			if (!$product->is_type('variable')) {
				if ($product->get_manage_stock()) {
					if (!$product->is_in_stock()) {
						echo "<div class='remaining-out-stock text-center'>".esc_html__(' Hết hàng', 'isokoma') ."</div>";
						return;
					}
				}
			}
		}
	}
endif;

if ( ! function_exists( 'isokoma_get_quantity_availability' ) ):
	function isokoma_get_quantity_availability() {
		global $product;
		$low_stock_notify = wc_get_low_stock_amount($product); // get low stock from product	
		if ( ! $product->managing_stock() && ! $product->is_in_stock() ){
			echo '<div class="remaining-out-stock">';
			_e('Hết hàng.', 'isokoma');
			echo "</div>";
		}
		// check if product type is not variable
		if (!$product->is_type('variable')) {
			if ($product->get_manage_stock()) {
				if (!$product->is_in_stock()) {
					echo "<div class='remaining-out-stock'>".esc_html__(' Hết hàng.', 'isokoma') ."</div>";
          return;
				}
				$stockNum = $product->get_stock_quantity();
				if ($stockNum <= $low_stock_notify) {          
          echo "<div class='remaining'><span>";
          echo $stockNum ;
          echo "</span> <span>";
          echo _e('sản phẩm có sẵn', 'isokoma');
          echo "</span> </div>";		
				} else {
          echo "<div class='remaining'><span>";
          echo $stockNum ;
          echo "</span> <span>";
          echo _e('sản phẩm có sẵn', 'isokoma');
          echo "</span> </div>";

        }
       
				// return printf(          
				// 	__("<div class='remaining'><span> %s </span> <span> sản phẩm có sẵn</span> </div>", 'isokoma'),
				// 	$stockNum
				// );

			}			
		} else {
			if ($product->get_manage_stock()) {
				$product_variations = $product->get_available_variations();
        $stock = 0;
				foreach ($product_variations as $variation) {
					$stock += $variation['max_qty'];
				}
				if ($stock > 0) {
					if ($stock <= $low_stock_notify) {	
            echo "<div class='remaining'><span>";
            echo _e('Chỉ còn', 'isokoma');
            echo "</span> <span>";
            echo $stock ;
            echo "</span> <span>";
            echo _e('sản phẩm', 'isokoma');
            echo "</span> </div>";
							// return printf(				
							// __("<div class='remaining-low-stock'><span>". _e('Chỉ còn', 'isokoma') ."</span> <span> %s </span> <span>". _e('sản phẩm', 'isokoma') ."</span></div>", 'isokoma'),
							// 		$stock
							// );
					} else {
            echo "<div class='remaining'><span>";
            echo _e('Còn', 'isokoma');
            echo "</span> <span>";
            echo $stock ;
            echo "</span> <span>";
            echo _e('sản phẩm', 'isokoma');
            echo "</span> </div>";
          }
         
					// return printf(					
					// __("<div class='remaining'> <span>". _e('Còn', 'isokoma') ."</span> <span> %s </span> <span>". _e('sản phẩm', 'isokoma') ."</span> </div>", 'isokoma'),
					// 		$stock
					// );
				}
			}
		}
		
	}
endif;

