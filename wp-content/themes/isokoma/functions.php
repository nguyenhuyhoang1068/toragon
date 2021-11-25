<?php
/**
 * Isokoma functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage isokoma
 * @since Isokoma
 */


add_action('wp_enqueue_scripts',  'isokoma_scripts');
function isokoma_scripts() {
	wp_enqueue_style('isokoma-bootstrap-css', get_stylesheet_directory_uri() . '/libs/bootstrap/css/bootstrap.min.css', array(), '');  
	wp_enqueue_style('isokoma-full-style', get_stylesheet_directory_uri() . '/style.css', array(), true);  	
	wp_enqueue_style("responsive", get_stylesheet_directory_uri() . "/css/responsive.css",  array(), '');
  wp_enqueue_style("woocommerce", get_stylesheet_directory_uri() . "/css/woocommerce.css",  array(), '');    
	wp_enqueue_style("isokoma", get_stylesheet_directory_uri() . "/css/isokoma.css",  array(), '');	
	wp_enqueue_style( 'isokoma-flexslider-css', get_stylesheet_directory_uri() . '/css/flexslider.min.css', array(), '' );   
  wp_enqueue_style("icons", get_stylesheet_directory_uri() . "/css/icons.css",  array(), '');  

  wp_enqueue_script('proper-js', get_stylesheet_directory_uri() . '/js/popper.min.js', array(), '', true);
	wp_enqueue_script('bootstrap-js', get_stylesheet_directory_uri() . '/libs/bootstrap/js/bootstrap.min.js', array(), '', true);  
	wp_enqueue_script( 'isokoma-flexslider-js', get_stylesheet_directory_uri() . '/js/jquery.flexslider-min.js', array(), '', true );
	wp_enqueue_script( 'isokoma-slider-js', get_stylesheet_directory_uri() . '/js/slider-setup.js', array(), '', true );      
	//wp_enqueue_script( 'isokoma-fontawesome-js', get_stylesheet_directory_uri() . '/js/fontawesome.js', array(), '', true );     
 
  wp_enqueue_script( 'isokoma-video-js', get_stylesheet_directory_uri() . '/js/script.js', array(), '5.8', true );    

  
	if(is_singular() && comments_open() && get_option("thread_comments")){
		wp_enqueue_script("comment-reply");
	}
}

/**
 * Register widget area.
 * 
 */
function isokoma_widgets_init() {

	register_sidebar(
		array(
			'name'          => __( 'Footer', 'isokoma' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your footer.', 'isokoma' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
  register_sidebar(
    array(
      'name'          => __( 'Left sidebar', 'isokoma' ),
      'id'            => 'leftsidebar',
      'description'   => __( 'Add widgets here to appear in Left sidebar.', 'isokoma' ),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    )
);

}
add_action( 'widgets_init', 'isokoma_widgets_init' );



/**Woocommerce Include*/
require get_stylesheet_directory() . '/inc/hyperlink-meta.php';
require 'inc/isokoma-functions.php';
require 'inc/isokoma-template-functions.php';
require 'inc/isokoma-template-hooks.php';
require 'inc/woocommerce.php';



if ( ! file_exists( get_stylesheet_directory() . '/inc/class-wp-bootstrap-navwalker.php' ) ) {  
  return new WP_Error( 'class-wp-bootstrap-navwalker-missing', __( 'It appears the class-wp-bootstrap-navwalker.php file may be missing.', 'wp-bootstrap-navwalker' ) );
} else {  
  require_once get_stylesheet_directory() . '/inc/class-wp-bootstrap-navwalker.php';
}


// This theme uses wp_nav_menu() in one location.
register_nav_menus( array(
  'top-nav' => esc_html__('Main Menu', 'isokoma'),      
  'brandtoys-nav' => 'Brand Toys Nav',
  'brandtranh-nav' => 'Brand Tranh Nav',
  'brandhanggiadung-nav' => 'Brand Hanggiadung Nav',
  'brandfashion-nav' => 'Brand Fashion Nav',
  'brandelectronic-nav' => 'Brand Electronic Nav',
) );
add_theme_support( 'menus' );


/*
add_action( 'after_setup_theme', 'isokoma_language_theme_setup' );
function isokoma_language_theme_setup(){ 
  load_theme_textdomain( 'isokoma', get_template_directory() . '/languages' );
}
*/

add_action( 'wp_enqueue_scripts', 'isokoma_deregister_styles', 200 );
function isokoma_deregister_styles() {   
  if ( ! is_user_logged_in() ) {
    wp_deregister_style( 'dashicons' );
  }
  //wp_deregister_script('jquery-migrate');
}


function isokoma_deregister_scripts(){
  wp_deregister_script( 'wp-embed' );
  wp_deregister_script( 'wp-polyfill' );
  wp_deregister_script( 'lodash' );
  wp_deregister_script( 'wp-i18n' );
  wp_deregister_script( 'wp-url' );
  wp_deregister_script( 'wp-hooks' );    
}
add_action( 'wp_footer', 'isokoma_deregister_scripts' );

 
function cfwc_create_size_custom_field() {
  $args = array(
  'id' => 'custom_text_field_size',
  'label' => __( 'The size', 'isokoma' ),
  'class' => 'cfwc-custom-field',
  'desc_tip' => true,
  'description' => __( 'Enter the Size.', 'ctwc' ),
  );
  woocommerce_wp_text_input( $args );
 }
 add_action( 'woocommerce_product_options_general_product_data', 'cfwc_create_size_custom_field' );

 function cfwc_save_size_custom_field( $post_id ) {
  $product = wc_get_product( $post_id );
  $title = isset( $_POST['custom_text_field_size'] ) ? $_POST['custom_text_field_size'] : '';
  $product->update_meta_data( 'custom_text_field_size', sanitize_text_field( $title ) );
  $product->save();
 }
 add_action( 'woocommerce_process_product_meta', 'cfwc_save_size_custom_field' );

/**
  * Breadcrumb
  */

add_filter( 'woocommerce_breadcrumb_defaults', 'wcc_change_breadcrumb_delimiter' );
function wcc_change_breadcrumb_delimiter( $defaults ) {
	// Change the breadcrumb delimeter from '/' to '>'
	$defaults['delimiter'] = ' &gt; ';
	return $defaults;
}

/*
/// To change add to cart text on single product page
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' ); 
function woocommerce_custom_single_add_to_cart_text() {
    return __( 'Cart', 'woocommerce' ); 
}

// To change add to cart text on product archives(Collection) page
add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text' );  
function woocommerce_custom_product_add_to_cart_text() {
    return __( 'Cart', 'woocommerce' );
}
*/
/**
  * Woocommerce
  */
//remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
//remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

  
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
//remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
//remove_action( 'woocommerce_before_shop_loop', 'storefront_woocommerce_pagination', 30 );
remove_action( 'woocommerce_before_shop_loop', 'storefront_woocommerce_pagination', 30 );
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );



/**
 * Change number of related products output
 */ 
function woo_related_products_limit() {
  global $product;	
	$args['posts_per_page'] = 4;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'isokoma_related_products_args', 20 );
  function isokoma_related_products_args( $args ) {
	$args['posts_per_page'] = 4; // 4 related products
	$args['columns'] = 4; // arranged in 2 columns
	return $args;
}



add_filter( 'woocommerce_single_product_carousel_options', 'customslug_single_product_carousel_options', 99, 1 );
function customslug_single_product_carousel_options( $options ) {
    $options['animation'] = 'fade';
    $options['animationSpeed'] = 400;
    return $options;
}

/* Add sku to product search */

function isokoma_pre_get_posts( $query ) {  
  if ( is_admin() || ! $query->is_main_query() || ! $query->is_search()){
    return;
  }  
  add_filter('posts_join', 'isokoma_search_join' );
  add_filter('posts_where', 'isokoma_search_where' );
  add_filter('posts_groupby', 'isokoma_search_groupby' );  
  }
  add_action( 'pre_get_posts', 'isokoma_pre_get_posts' );
  
  function isokoma_search_join( $join ){
     global $wpdb;     
     $join .= " LEFT JOIN $wpdb->postmeta gm ON (" . 
     $wpdb->posts . ".ID = gm.post_id AND gm.meta_key='_sku')"; // change to your meta key if not woo  
     return $join;
  }
  
  function isokoma_search_where( $where ){
     global $wpdb;
     $where = preg_replace(
       "/\(\s*{$wpdb->posts}.post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
       "({$wpdb->posts}.post_title LIKE $1) OR (gm.meta_value LIKE $1)", $where );
     return $where;
  }
  /* grouping by id to make sure no dupes */
  function isokoma_search_groupby( $groupby ){
     global $wpdb;
     $mygroupby = "{$wpdb->posts}.ID";
     if( preg_match( "/$mygroupby/", $groupby )) {
       // grouping we need is already there
       return $groupby;
     }
     if( !strlen(trim($groupby))) {
        // groupby was empty, use ours
        return $mygroupby;
     }
     // wasn't empty, append ours
     return $groupby . ", " . $mygroupby;
  }



function custom_track_product_view() {
  if ( ! is_singular( 'product' ) ) {
      return;
  }
  global $post;
  if ( empty( $_COOKIE['woocommerce_recently_viewed'] ) )
      $viewed_products = array();
  else
      $viewed_products = (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] );

  if ( ! in_array( $post->ID, $viewed_products ) ) {
      $viewed_products[] = $post->ID;
  }

  if ( sizeof( $viewed_products ) > 15 ) {
      array_shift( $viewed_products );
  }
  wc_setcookie( 'woocommerce_recently_viewed', implode( '|', $viewed_products ) );
}
add_action( 'template_redirect', 'custom_track_product_view', 20 );

function isokoma_woocommerce_recently_viewed_products( $atts, $content = null ) {
  // Get shortcode parameters
  extract(shortcode_atts(array(
      "per_page" => '12'
  ), $atts));
  // Get WooCommerce Global
  global $woocommerce;
  // Get recently viewed product cookies data
  $viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
  $viewed_products = array_filter( array_map( 'absint', $viewed_products ) );
  // If no data, quit
  if ( empty( $viewed_products ) )
      return __( 'Chưa có sản phẩm đã xem', 'isokoma' );
  // Create the object
  ob_start();
  // Get products per page
  if( !isset( $per_page ) ? $number = 12 : $number = $per_page )
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
  $get_product = new WP_Query($query_args);
  // If query return results
  $content = "";
  if ( $get_product->have_posts() ) {    
    // Start the loop
    while ( $get_product->have_posts()) {
      $get_product->the_post();
      global $product;
      $content .= '<div class="item-viewed-product">';
      $content .= '<a href="'. get_permalink().'" >';          
      $content .= get_the_post_thumbnail($get_product->post->ID, 'isokoma-banner-500', array('class'=>'thumbnail'));          
      $content .= '</a>';
      $content .= '<h3><a href="'. get_permalink().'">';
      $content .=   get_the_title(); 
      $content .= '</a> </h3>';
      $content .= '<div class="product-price">'. $product->get_price_html().'</div>';
      //$content .= '<a href="'. bloginfo('url').'"add-to-cart="'. the_ID().'"><i class="fas fa-shopping-basket" aria-hidden="true"></i> Cart</a>';          
      $content .= '</div>';
    }      
  }
  // Get clean object
  $content .= ob_get_clean();
  // Return whole content
  return $content;
}




// Register the shortcode
add_shortcode("woocommerce_recently_viewed_products", "isokoma_woocommerce_recently_viewed_products");


// $templates = wp_get_theme()->get_page_templates();
// print_r( $templates );
/**
 * List of perchased products 
 */
add_filter ( 'woocommerce_account_menu_items', 'isokoma_purchased_products_link', 40 );
add_action( 'init', 'isokoma_add_products_endpoint' );
add_action( 'woocommerce_account_purchased-products_endpoint', 'isokoma_populate_products_page' );



function isokoma_add_woocommerce_support() {
  add_theme_support( 'woocommerce');
  add_theme_support( 'wc-product-gallery-zoom' );
  add_theme_support( 'wc-product-gallery-lightbox' );
  add_theme_support( 'wc-product-gallery-slider' );
  add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'isokoma_add_woocommerce_support' );
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

function isokoma_theme_support() {
  remove_theme_support( 'widgets-block-editor' );
  
}
add_action( 'after_setup_theme', 'isokoma_theme_support' );

//require 'inc/woocommerce/class-storefront-woocommerce.php';
//require 'inc/woocommerce/class-storefront-woocommerce-customizer.php';
require 'inc/class-storefront-woocommerce-adjacent-products.php';
require 'inc/storefront-woocommerce-template-hooks.php';
require 'inc/storefront-woocommerce-template-functions.php';
require 'inc/storefront-woocommerce-functions.php';



// here we hook the My Account menu links and add our custom one
function isokoma_purchased_products_link( $menu_links ){

	return array_slice( $menu_links, 0, 2, true )
	+ array( 'purchased-products' => 'Purchased Products' )
	+ array_slice( $menu_links, 2, NULL, true );
 
}
 
// here we register our rewrite rule
function isokoma_add_products_endpoint() {
	add_rewrite_endpoint( 'purchased-products', EP_ALL );
  flush_rewrite_rules();
}
 
// here we populate the new page with the content
function isokoma_populate_products_page() {

 
	global $wpdb;
 
	// this SQL query allows to get all the products purchased by the current user
	// in this example we sort products by date but you can reorder them another way
	$purchased_products_ids = $wpdb->get_col( $wpdb->prepare(
		"
		SELECT      itemmeta.meta_value
		FROM        " . $wpdb->prefix . "woocommerce_order_itemmeta itemmeta
		INNER JOIN  " . $wpdb->prefix . "woocommerce_order_items items
		            ON itemmeta.order_item_id = items.order_item_id
		INNER JOIN  $wpdb->posts orders
		            ON orders.ID = items.order_id
		INNER JOIN  $wpdb->postmeta ordermeta
		            ON orders.ID = ordermeta.post_id
		WHERE       itemmeta.meta_key = '_product_id'
		            AND ordermeta.meta_key = '_customer_user'
		            AND ordermeta.meta_value = %s
		ORDER BY    orders.post_date DESC
		",
		get_current_user_id()
	) );
  
	// some orders may contain the same product, but we do not need it twice
	$purchased_products_ids = array_unique( $purchased_products_ids );
 
	// if the customer purchased something
	if( !empty( $purchased_products_ids ) ) :
 
		// it is time for a regular WP_Query
		$purchased_products = new WP_Query( array(
			'post_type' => 'product',
			'post_status' => 'publish',
			'post__in' => $purchased_products_ids,
			'orderby' => 'post__in'
		) );
 
		echo '<div class="woocommerce columns-3">';
 
		woocommerce_product_loop_start();
 
		while ( $purchased_products->have_posts() ) : $purchased_products->the_post();
    
			wc_get_template_part( 'content', 'product' );
 
		endwhile;
 
		woocommerce_product_loop_end();
 
		//woocommerce_reset_loop();
		wp_reset_postdata();
 
		echo '</div>';
	else:		
    echo _e('Nothing purchased yet', 'isokoma');
	endif;

}


/**
 * Remove stock to empty in product teaser
 */
add_filter( 'woocommerce_get_stock_html', '__return_empty_string' );

/**
 * Remove sort popularity
 */
function my_woocommerce_catalog_orderby( $orderby ) {
  unset($orderby["popularity"]);  
  return $orderby;
}
add_filter( "woocommerce_catalog_orderby", "my_woocommerce_catalog_orderby", 20 );



/**
 * Transaction Fees
 */

add_action( 'woocommerce_cart_calculate_fees', 'isokoma_add_checkout_fee_for_gateway' );
  
function isokoma_add_checkout_fee_for_gateway() {
    $settings = PfpViet::get_settings();   
    if ($settings) {
      $amount = WC()->cart->cart_contents_total;  
      if (get_woocommerce_currency_symbol() === 'đ' || get_woocommerce_currency_symbol() === 'VND') {
        $stripe_fees = ((($settings['vnd_stripe_fees']['rate'] * $amount) + $settings['vnd_stripe_fees']['paypalfixedfee']) / (1 - $settings['vnd_stripe_fees']['rate']));
      } else {
        $stripe_fees = ((($settings['vnd_stripe_fees']['rate'] * $amount) + $settings['vnd_stripe_fees']['fixedfee']) / (1 - $settings['vnd_stripe_fees']['rate']));
      }   
    } else {      
      return;
    }    
    $chosen_gateway = WC()->session->get( 'chosen_payment_method' ); 
    if ( $chosen_gateway == 'stripe' ) {
      WC()->cart->add_fee( 'Transaction fee', round($stripe_fees, 2));
    }
}
 
add_action( 'woocommerce_after_checkout_form', 'isokoma_refresh_checkout_on_payment_methods_change' );
   
function isokoma_refresh_checkout_on_payment_methods_change(){
    wc_enqueue_js( "
       $( 'form.checkout' ).on( 'change', 'input[name^=\'payment_method\']', function() {
           $('body').trigger('update_checkout');
        });
   ");
}


function my_woocommerce_make_tags_hierarchical( $args ) {
  $args['hierarchical'] = true;
  return $args;
};
add_filter( 'woocommerce_taxonomy_args_product_tag', 'my_woocommerce_make_tags_hierarchical' );





/**
 * Register method
 */


// Function to check starting char of a string
function startsWith($haystack, $needle){
  return $needle === '' || strpos($haystack, $needle) === 0;
}


// Custom function to display the Billing Address form to registration page
function isokoma_add_billing_form_to_registration(){
  global $woocommerce;
  $checkout = $woocommerce->checkout();
  ?>
  <?php foreach ( $checkout->get_checkout_fields( 'billing' ) as $key => $field ) : ?>

      <?php if($key!='billing_email'){ 
           
          woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
          
      } ?>

  <?php endforeach; 
}
add_action('woocommerce_register_form_start','isokoma_add_billing_form_to_registration');

// Custom function to save Usermeta or Billing Address of registered user
function isokoma_save_billing_address($user_id){
  global $woocommerce;
  $address = $_POST;
  foreach ($address as $key => $field){
   
      if(startsWith($key,'billing_')){
          // Condition to add firstname and last name to user meta table
          if($key == 'billing_first_name' || $key == 'billing_last_name'){
              $new_key = explode('billing_',$key);
              
              update_user_meta( $user_id, $new_key[1], $_POST[$key] );
          }
          update_user_meta( $user_id, $key, $_POST[$key] );
      }
  }

}
add_action('woocommerce_created_customer','isokoma_save_billing_address');


// Registration page billing address form Validation
function isokoma_validation_billing_address(){
  global $woocommerce;
  $address = $_POST;
  foreach ($address as $key => $field) :
      // Validation: Required fields
      if(startsWith($key,'billing_')){
          if($key == 'billing_country' && $field == ''){
              $woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please select a country.', 'woocommerce' ) );
          }
          if($key == 'billing_first_name' && $field == ''){
              $woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter first name.', 'woocommerce' ) );
          }
          if($key == 'billing_last_name' && $field == ''){
              $woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter last name.', 'woocommerce' ) );
          }
          if($key == 'billing_address_1' && $field == ''){
              $woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter address.', 'woocommerce' ) );
          }
          if($key == 'billing_city' && $field == ''){
              $woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter city.', 'woocommerce' ) );
          }
          if($key == 'billing_state' && $field == ''){
              $woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter state.', 'woocommerce' ) );
          }
          if($key == 'billing_postcode' && $field == ''){
              $woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter a postcode.', 'woocommerce' ) );
          }
          /*
          if($key == 'billing_email' && $field == ''){
              $woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter billing email address.', 'woocommerce' ) );
          }
          */
          if($key == 'billing_phone' && $field == ''){
              $woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter phone number.', 'woocommerce' ) );
          }

      }
  endforeach;
 
}
add_action('register_post','isokoma_validation_billing_address');


add_filter( 'woocommerce_billing_fields' , 'isokoma_remove_billing_lastname_fields' );
function isokoma_remove_billing_lastname_fields( $fields ) {
  unset($fields['billing_last_name']);
  return $fields;
}

add_filter( 'woocommerce_shipping_fields' , 'isokoma_remove_shipping_lastname_fields' );
function isokoma_remove_shipping_lastname_fields( $fields ) {
  unset($fields['shipping_last_name']);
  return $fields;
}

add_filter( 'woocommerce_checkout_fields' , 'custom_remove_woo_checkout_fields' ); 
function custom_remove_woo_checkout_fields( $fields ) {
  
  if ((get_post_type() === 'page') && is_page() && (get_post()->post_type === 'page') && get_the_ID() === 255) {
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_postcode']);    
    unset($fields['billing']['billing_state']);    
    $fields['billing']['billing_first_name']['label'] = 'Họ Tên';  
    $fields['billing']['billing_address_1']['label'] = 'Địa chỉ';
    $fields['billing']['billing_address_1']['placeholder'] = '';
    //$fields['billing']['billing_phone']['placeholder'] = 'Điện thoại';
    $fields['billing']['billing_phone']['label'] = 'Điện thoại';
  } 
    
  return $fields;
}

add_shortcode( 'wc_reg_form_isokoma', 'isokoma_separate_registration_form' );
    
function isokoma_separate_registration_form() {
   if ( is_admin() ) return;
   if ( is_user_logged_in() ) return;
   ob_start(); 
 
   do_action( 'woocommerce_before_customer_login_form' );
 
   ?>
      <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >
 
         <?php do_action( 'woocommerce_register_form_start' ); ?>
 
         <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
 
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
               <label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?> <span class="required">*</span></label>
               <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
            </p>
 
         <?php endif; ?>
 
         <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
            <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
         </p>
 
         <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
 
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
               <label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
               <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
            </p>
 
         <?php else : ?>
 
            <p><?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?></p>
 
         <?php endif; ?>
 
         <?php do_action( 'woocommerce_register_form' ); ?>
 
         <p class="woocommerce-FormRow form-row">
            <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
            <button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
         </p>
 
         <?php do_action( 'woocommerce_register_form_end' ); ?>
         
      </form>
 
   <?php
     
   return ob_get_clean();
}


add_filter( 'woocommerce_registration_redirect', 'isokoma_redirection_after_registration', 10, 1 );
function isokoma_redirection_after_registration( $redirection_url ){
    // Change the redirection Url
    $redirection_url = get_home_url(). '/my-account'; // Home page
    return $redirection_url; // Always return something
}

/*
add_shortcode( 'wc_login_form_isokoma', 'isokoma_separate_login_form' );
  
function isokoma_separate_login_form() {
   if ( is_admin() ) return;
   if ( is_user_logged_in() ) return; 
   ob_start();
   woocommerce_login_form( array( 'redirect' => 'https://custom.url' ) );
   return ob_get_clean();
}*/



function woocommerce_registration_errors_validation($reg_errors, $sanitized_user_login, $user_email) {
	global $woocommerce;
	extract( $_POST );
	if ( strcmp( $password, $password2 ) !== 0 ) {
		return new WP_Error( 'registration-error', __( 'Passwords do not match.', 'woocommerce' ) );
	}
	return $reg_errors;
}
add_filter('woocommerce_registration_errors', 'woocommerce_registration_errors_validation', 10, 3);

function woocommerce_register_form_password_repeat() {
	?>
	<p class="form-row form-row-wide">
		<label for="reg_password2"><?php _e( 'Confirm password', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="password" class="input-text" name="password2" id="reg_password2" value="<?php if ( ! empty( $_POST['password2'] ) ) echo esc_attr( $_POST['password2'] ); ?>" />
	</p>
	<?php
}
add_action( 'woocommerce_register_form', 'woocommerce_register_form_password_repeat' );


function custom_count_wishlist() {
	$url = WPcleverWoosw::get_url();
	$icon_html  = "<div class='menu-item woosw-menu-item menu-item-type-woosw'><a href='{$url}'>";
	$icon_html .= '<span class="woosw-menu-item-inner" data-count="'.WPcleverWoosw::get_count().'"><img src="https://staging.toragon.vn/wp-content/uploads/2021/11/heart.png" alt="wishlist"></span>';
	$icon_html .= '</a></div>';
	return $icon_html;
}
add_shortcode( 'wishlist_count', 'custom_count_wishlist' );



add_filter( 'woocommerce_add_to_cart_fragments', 'iconic_cart_count_fragments', 10, 1 );
function iconic_cart_count_fragments( $fragments ) {    
  $fragments['div.header-cart-count'] = '<div class="header-cart-count">' . WC()->cart->get_cart_contents_count() . '</div>';    
  return $fragments;    
}


function custom_count_cart() {
    $url = wc_get_cart_url();
    $count = 0;
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $count++;
    }
    $icon_html  = "<div class='menu-item cart-menu-item menu-item-type-cart'><a href='{$url}'>";
    $icon_html .= '<span class="cart-menu-item-inner" data-count="'.$count.'"><i class="fa fa-shopping-basket"></i></span>';
    $icon_html .= '</a></div>';
    return $icon_html;
}
add_shortcode( 'cart_count', 'custom_count_cart' );





function custom_ajax_logout_js() {  
  if (is_admin()) {
  // We only need to setup ajax action in admin.
  add_action('wp_ajax_custom_ajax_logout', 'custom_ajax_logout');
  } else {
  wp_enqueue_script('custom-ajax-logout', get_stylesheet_directory_uri() . '/js/logout.js', array('jquery') );
    wp_localize_script('custom-ajax-logout', 'ajax_object',
      array(
          'ajax_url' => admin_url('admin-ajax.php'),
          'home_url' => get_home_url(),
          'logout_nonce' => wp_create_nonce('ajax-logout-nonce'),
      )
    );
  }  
}
add_action('wp_enqueue_scripts', 'custom_ajax_logout_js');



add_action('wp_ajax_custom_ajax_logout', 'custom_ajax_logout');
add_action('wp_ajax_nopriv_custom_ajax_logout', 'custom_ajax_logout');

function custom_ajax_logout(){
  check_ajax_referer( 'ajax-logout-nonce', 'ajaxsecurity' );
  wp_clear_auth_cookie();
  wp_logout();
  ob_clean(); 
  wp_send_json_success();
}


add_filter ( 'woocommerce_account_menu_items', 'isokoma_remove_my_account_links' );
function isokoma_remove_my_account_links( $menu_links ){	
	//unset( $menu_links['edit-address'] ); // Addresses	
	//unset( $menu_links['dashboard'] ); // Remove Dashboard
	//unset( $menu_links['payment-methods'] ); // Remove Payment Methods
	//unset( $menu_links['orders'] ); // Remove Orders
	unset( $menu_links['downloads'] ); // Disable Downloads
	//unset( $menu_links['edit-account'] ); // Remove Account details tab
	unset( $menu_links['customer-logout'] ); // Remove Logout link	
	return $menu_links;
	
}

add_filter('wp_nav_menu_items', 'add_search_form', 10, 2);
function add_search_form($items, $args) {
    if( $args->theme_location == 'top-nav' )
        $items .= do_shortcode('[language-switcher]');
        $items .= "<div class='mb-social d-block d-sm-none'><a href='https://www.facebook.com/ToragonHE/' class='txt-blur' target='_blank'>
        <img src='https://staging.toragon.vn/wp-content/uploads/2021/11/Facebook.png' alt='facebook'></a>
        <a href='https://www.instagram.com/tigertoyz_isokoma/' class='txt-blur' target='_blank'>
        <img src='https://staging.toragon.vn/wp-content/uploads/2021/11/ins-logo.png' alt='instagram'>
        </a>
        </div>
        ";

        return $items;

}

/*Email search*/
function directory_search_js() {
	global $wp_query;
	wp_enqueue_script('jquery');
	wp_enqueue_script('directory_search_js', get_stylesheet_directory_uri() . '/js/directory-search.js', array('jquery'));
	//wp_localize_script( 'ajaxjs', 'ajax_object', array( site_url() . '/wp-admin/admin-ajax.php' ) );  
	wp_localize_script('directory_search_js', 'directory_search_params', array(
		'ajaxurl' => site_url(null, 'https') . '/wp-admin/admin-ajax.php', // WordPress AJAX
		'posts' => json_encode($wp_query->query_vars), // everything about your loop is here
		'current_page' => get_query_var('paged') ? get_query_var('paged') : 1,
		'max_page' => $wp_query->max_num_pages
	));
	wp_enqueue_script('directory-ajaxjs');
}
add_action('wp_enqueue_scripts', 'directory_search_js');
/**
 * Subscriber form
 */

function sytp_insert_db_record(){
	global $wpdb;
    $email = sanitize_email( $_POST['email'] );
		if (empty($email)) {
			echo "<div class='es_caption'>Vui lòng nhập email.</div>";
			wp_die();
		}else {
			$table_name = 'wp_sfba_subscribers_lists' ;
			$check_existing = $wpdb->get_results(
					"SELECT * FROM `$table_name` WHERE `email` = '$email'" 
					);
			if (empty($check_existing)) {
				$t=time();     
				$data = array(          
						'name'          => 'Toragon user',     
						'email'         => $email,  
						'page_link'     => date('Y-m-d'),          
				);
				$format = array(
						'%s',
						'%s'
				);
				$success=$wpdb->insert( $table_name, $data, $format );
				if($success){
					echo "<div class='es_caption'>Cảm ơn bạn đã theo dõi.</div>" ; 
				}
			}else {
				echo "<div class='es_caption'>Email này đã được đăng ký.</div>" ; 
			} 
			wp_die();
		}  

}

add_action('wp_ajax_sytp_insert_db_record', 'sytp_insert_db_record');
add_action('wp_ajax_nopriv_sytp_insert_db_record', 'sytp_insert_db_record');