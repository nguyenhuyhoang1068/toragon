<?php

/**
 * Plugin Name: ISOKOMA Shipping
 * Description: Base field 1000%, 400%, 100%, No Shipping
 * Version: 1.0.0
 * Author: Tommy
 * Author URI: https://toragon.vn
s
 */

if (!defined('WPINC')) {

  die;
}
/*
* Check if WooCommerce is active
*/
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

  function request_a_shipping_quote_init()  {
    if (!class_exists('Isokoma_WC_Pickup_Shipping')) {
      class Isokoma_WC_Pickup_Shipping_Method extends WC_Shipping_Method  {        
        /**
         * Contructor shipping extend class WC_Shipping
         */
        public function __construct($instance_id = 0) {
          $this->id                 = 'isokoma_shipping_via_sizes';
          $this->instance_id        = absint( $instance_id );
          $this->method_title       = __('Isokoma Shipping Per Product', 'isokoma');
          $this->method_description = __('Custom Shipping Method for Isokoma', 'isokoma');        
          $this->init();
          $this->enabled = isset($this->settings['enabled']) ? $this->settings['enabled'] : 'yes';
          $this->title = isset($this->settings['title']) ? $this->settings['title'] : __('Isokoma Shipping', 'isokoma');
          // $this->supports           = array(
          //   'shipping-zones',
          //   'instance-settings',
          //   'instance-settings-modal',
          // );  
         
        }

        function init() {
          // Load the settings API
          $this->init_form_fields();
          $this->init_settings();
           // Define user set variables
          $this->title = $this->get_option( 'title' );
           // Actions
          add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );         
        }

        function init_form_fields() {
          $this->instance_form_fields = array(
            'title' => array(
                'title'       => __( 'Isokoma 1000%', 'isokoma' ),
                'type'        => 'text',
                'description' => __( 'This controls the title which the user sees during checkout.', 'isokoma' ),
                'default'     => __( '1000%', 'isokoma' ),
                'desc_tip'    => true,
            ),
          );
          $this->form_fields = array(
            'enabled' => array(
              'title' => __('Enable', 'isokoma'),
              'type' => 'checkbox',
              'description' => __('Enable this shipping.', 'isokoma'),
              'default' => 'yes'
            ),
            'title' => array(
              'title' => __('Title', 'isokoma'),
              'type' => 'text',
              'description' => __('Title to be display on site', 'isokoma'),
              'default' => __('Shipping', 'isokoma')
            ),
            // 'quantityinhcmc' => array(
            //   'title' => __( 'F3 in HCMC', 'isokoma' ),              
            //   'type' => 'number',
            //   'description' => __( 'Price vnd', 'isokoma' ),              
            //   'default' => 35000              
            // ),           
            // 'quantityinhcmcf2' => array(
            //   'title' => __( 'F2 in HCMC', 'isokoma' ),              
            //   'type' => 'number',
            //   'description' => __( 'Price vnd', 'isokoma' ),              
            //   'default' => 40000              
            // ),
            // 'quantityouthcmc' => array(
            //   'title' => __( 'F3 out HCMC', 'isokoma' ),              
            //   'type' => 'number',
            //   'description' => __( 'Price vnd', 'isokoma' ),              
            //   'default' => 40000              
            // ),
            // 'quantityouthcmcf2' => array(
            //   'title' => __( 'F2 out HCMC', 'isokoma' ),              
            //   'type' => 'number',
            //   'description' => __( 'Price vnd', 'isokoma' ),              
            //   'default' => 60000              
            // ),
          );
        }


        public function calculate_shipping($package = array()) {    
         
       
          // $this->add_rate(array(
          //     'id' => $this->id,
          //     'label' => $this->title,
          //     'cost' => $cost
          // ));
          // add_rate( array(
          //   'id'       => $this->id,
          //   'label'    => $this->title,
          //   'cost'     => array_sum( wp_list_pluck( $packages, 'contents_cost' ) ) * $this->percentage_rate / 100,
          //   // 'calc_tax' => 'per_item'
          // ));
          //$total = WC()->cart->cart_contents_total;
          //$subtotal = WC()->cart->subtotal;
        
 
     
          //echo get_post_meta($product->get_id(), 'custom_text_field_size', TRUE); 
          // $shipping_methods = WC()->shipping->get_shipping_methods();
          // $shipping_packages = WC()->cart->get_shipping_packages();

          // foreach( array_keys( $shipping_packages ) as $key ) {
          //   if( $shipping_for_package = WC()->session->get('shipping_for_package_'.$key) ) {
          //     if( isset($shipping_for_package['rates']) ) {                
          //       // Loop through customer available shipping methods
          //       foreach ( $shipping_for_package['rates'] as $rate_key => $rate ) {
          //          var_dump($rate_key);
                   
          //           $rate_id = $rate->id; // the shipping method rate ID (or $rate_key)
          //           $method_id = $rate->method_id; // the shipping method label
          //           $instance_id = $rate->instance_id; // The instance ID
          //           $cost = $rate->label; // The cost
          //           $label = $rate->label; // The label name
          //           $taxes = $rate->taxes; // The taxes (array)                   
          //       }
          //     }
          //   }
          // }
            
         
         
          // foreach ($package['contents'] as $item_id => $values) {
          //   $_product = $values['data'];           
          //   $product_id = $_product->get_id();
           
          //   $shiping_id = get_post_meta($product_id, 'shipping_size_field_size', TRUE);            
          //   if (!empty($shiping_id)) {
          //     $term_name = get_term( $shiping_id )->name;                        
          //     foreach ($package['rates'] as $rate_key => $rate) {                        
          //       if (strcasecmp($term_name, $rate->label) == 0) {               
          //         $rate_id[$product_id] = array (
          //           $product_id => $rate->id,
          //         );
          //       }                 
          //     }   
          //   } else {
          //     $rate_id[$product_id] = array (
          //       $product_id => '',
          //     );
          //   }  
                              
          //   //$weight = $weight + $_product->get_weight() * $values['quantity'];
          // }         
        
          $cost = 0;
          $flag = false;
          $no_shipping = false;
          foreach ($package['rates'] as $rate_key => $rate) {           
            if ( $rate->id == 'flat_rate:3') {
              $rates_out_hcm = $rate->cost;
            } 
            if ( $rate->id == 'flat_rate:7') {
              $rates_hcm = $rate->cost;
            }             
          }          
          $state = $package["destination"]["state"];
          $country    = strtoupper( wc_clean( $package['destination']['country'] ) );
          if ($country === 'VN') { 
            if ($state == 'HOCHIMINH') {
              foreach ( WC()->cart->get_cart() as $cart_item ) {    
                $product = $cart_item['data'];
                $product_id = $product->get_id();
                $shiping_id = get_post_meta($product_id, 'shipping_size_field_size', TRUE);             
                $qty = $cart_item['quantity'];     
                if ($shiping_id === ''){
                  $flag = true;
                }   
                if ($flag == false) {
                  if (!empty($shiping_id)) {             
                    $term_name = get_term( $shiping_id )->name;     
                    foreach ($package['rates'] as $rate_key => $rate) {    
                      if (strcasecmp($term_name, $rate->label) == 0) {     
                        if ($term_name == 'No Shipping') {                     
                          $this->title =    __( 'Self collect', 'isokoma');                                                                     
                          $cost = 0;
                          $no_shipping = true;
                        } 
                        if ($no_shipping == false) {
                          if ($term_name == "F1") {
                            $cost += $qty*$rate->cost;  
                          } else if ($term_name == "F2") {
                            $cost += $qty*$rate->cost;  
                          } else if($term_name == "F3") {                                                
                            if ($qty < 10) {
                              $cost += $rate->cost;  
                              //$cost += $this->settings['quantityinhcmc'];                       
                            } 
                            if ($qty >= 10) {
                              $cost +=   $rates_hcm;
                              //$cost += $this->settings['quantityinhcmcf2'];
                            } 
                          } else {                        
                            $cost += $rate->cost;                                               
                          }
                        } else {
                          $this->title =    __( 'Self collect for method no shipping', 'isokoma');                                                                     
                          $cost = 0;
                        } 
                      }                
                    }
                  }
                } else{
                  $this->title =    __( 'Self collect for did not choose method', 'isokoma');                                                                     
                  $cost = 0;
                }              
              }
            }else {
              foreach ( WC()->cart->get_cart() as $cart_item ) {    
                $product = $cart_item['data'];
                $product_id = $product->get_id();
                $shiping_id = get_post_meta($product_id, 'shipping_size_field_size', TRUE);             
                $qty = $cart_item['quantity'];                  
                if ($shiping_id === ''){
                  $flag = true;
                }   
                if ($flag == false) {
                  if (!empty($shiping_id)) {             
                    $term_name = get_term( $shiping_id )->name;     
                    foreach ($package['rates'] as $rate_key => $rate) {                        
                      if (strcasecmp($term_name, $rate->label) == 0) {     
                        if ($term_name == 'No Shipping') {                     
                          $this->title =    __( 'Self collect', 'isokoma');                                                                     
                          $cost = 0;
                          $no_shipping = true;
                        }
                        if ($no_shipping == false) {
                          if ($term_name == "F1") {
                            $cost += $qty*$rate->cost;  
                          } else if ($term_name == "F2") {
                            $cost += $qty*$rate->cost;  
                          } else if($term_name == "F3") {
                            if ($qty < 10) {
                              //$cost += $qty*$rate->cost;  
                              $cost += $rate->cost;  
                              //$cost += $this->settings['quantityouthcmc'];                       
                            }
                            if ($qty >= 10) {
                              $cost += $rates_out_hcm;
                              //$cost += $this->settings['quantityouthcmcf2'];
                            }
                          } else {
                            $cost += $qty*$rate->cost;                         
                          }
                        } else{
                          $this->title =    __( 'Self collect for method no shipping', 'isokoma');                                                                     
                          $cost = 0;
                        }
                      }                
                    }
                  }
                } else {
                  $this->title =    __( 'Self collect for did not choose method', 'isokoma');                                                                     
                  $cost = 0;
                }                
                              
              }
            }
          } else {
            $this->title =  __( 'For oversea shipping, our customer service will contact you about the shipping fee', 'isokoma');   
          }
          
                      
          $rate = array(
            'id' => $this->id,
            'label' => $this->title,
            'cost' =>wc_price( $cost)
          );
          $this->add_rate($rate);
          
        }
      }
    }
  }

  add_action('woocommerce_shipping_init', 'request_a_shipping_quote_init');
  function request_shipping_quote_shipping_method($methods) {   
    $methods['isokoma_shipping_via_sizes'] = 'Isokoma_WC_Pickup_Shipping_Method';   
    return $methods;
  }
  add_filter('woocommerce_shipping_methods', 'request_shipping_quote_shipping_method');
}

/**
 * Custom the Shipping Size
 */

function isokoma_shipping_size_custom_field() {
  $args = array(
    'taxonomy'     => 'shippings',   
    'hide_empty' => false,
    'order' => 'ASC',    
  );  
  $options[''] = __( 'Select a value', 'isokoma'); 
  $all_categories = get_categories( $args );	
	foreach ($all_categories as $cat) {	    
    $options[$cat->term_id] = $cat->name;      	       
  } 
  woocommerce_wp_select( 
    array( 
        'id'      => 'shipping_size_field_size', 
        'label'   => __( 'Shipping method', 'isokoma' ), 
        'options' => $options,
        )
    );
 }
 add_action( 'woocommerce_product_options_general_product_data', 'isokoma_shipping_size_custom_field' );

function isokoma_shipping_save_size_custom_field( $post_id ) {
  $product = wc_get_product( $post_id );
  $title = isset( $_POST['shipping_size_field_size'] ) ? $_POST['shipping_size_field_size'] : '';
  $product->update_meta_data( 'shipping_size_field_size', sanitize_text_field( $title ) );
  $product->save();
}
add_action( 'woocommerce_process_product_meta', 'isokoma_shipping_save_size_custom_field' );


function custom_shipping_taxonomy_item() {
  $labels = array(
    'name'                       => 'Shippings',
    'singular_name'              => 'Shipping',
    'menu_name'                  => 'Shipping type',
    'all_items'                  => 'All Items',
    'parent_item'                => 'Parent Item',
    'parent_item_colon'          => 'Parent Item:',
    'new_item_name'              => 'New Item Name',
    'add_new_item'               => 'Add New Item',
    'edit_item'                  => 'Edit Item',
    'update_item'                => 'Update Item',
    'separate_items_with_commas' => 'Separate Item with commas',
    'search_items'               => 'Search Items',
    'add_or_remove_items'        => 'Add or remove Items',
    'choose_from_most_used'      => 'Choose from the most used Items',
  );
  $args = array(
    'labels'                     => $labels,
    'hierarchical'               => false,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_quick_edit'         => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => false,
    'has_archive'                 => false, 
    'show_in_menu'               => true,
    'meta_box_cb'                => false,
  );
  register_taxonomy('shippings', 'product', $args);
}
add_action( 'init', 'custom_shipping_taxonomy_item', 0 );




add_filter( 'woocommerce_cart_shipping_method_full_label', 'bbloomer_remove_shipping_label', 9999, 2 );   
function bbloomer_remove_shipping_label( $label, $method ) {
    $new_label = preg_replace( '/^.+:/', '', $label );
    return $new_label;
}


add_filter( 'woocommerce_package_rates', 'isokoma_unset_shipping_available_in_zone', 10, 2 );   
function isokoma_unset_shipping_available_in_zone( $rates, $package ) {    
  // Only unset rates if free_shipping is available
 // if ( isset( $rates['isokoma_shipping_via_sizes'] ) ) {
    unset( $rates['flat_rate:6'] );
    unset( $rates['flat_rate:7'] );
    unset( $rates['flat_rate:8'] );
    unset( $rates['flat_rate:2'] );   
    unset( $rates['flat_rate:3'] );
    unset( $rates['flat_rate:4'] );     
    unset( $rates['flat_rate:12'] );   
    unset( $rates['flat_rate:13'] );   
       
    
    foreach( $rates as $rate_key => $rate ) {            
      if ( __( 'No Shipping', 'woocommerce' ) == $rate->label ) {
        $rates[$rate_key]->label = __( 'Self collect', 'isokoma' ); 
      }        
    }
  
  return $rates;    
}





add_action('wp_enqueue_scripts',  'isokoma_shipping_scripts');
function isokoma_shipping_scripts() {
	wp_enqueue_style('isokoma-shipping',  plugins_url('isokoma-shipping/css/shipping.css'), array(), '');  
  wp_enqueue_script( 'isokoma-shipping', plugins_url('isokoma-shipping/js/shipping.js'), array(), '3.0');  
}

add_filter( 'woocommerce_get_country_locale', function( $locale ) {
	$locale['VN']['state']['required'] = true;
	return $locale;
} );

add_filter( 'default_checkout_billing_country', 'change_default_checkout_country', 10, 1 );

function change_default_checkout_country( $country ) {
    // If the user already exists, don't override country
    if ( WC()->customer->get_is_paying_customer() ) {
        return $country;
    }

    return 'VN'; // Override default to Germany (an example)
}

// add_filter( 'default_checkout_billing_country', 'change_default_checkout_country' );
// function change_default_checkout_country() {
//   return 'XX'; // country code
// }

add_filter( 'default_checkout_billing_state', 'change_default_checkout_state' );

function change_default_checkout_state() {
  return 'HOCHIMINH'; // state code
}

add_filter( 'woocommerce_default_address_fields', 'bbloomer_reorder_checkout_fields' );
 
function bbloomer_reorder_checkout_fields( $fields ) { 
   // default priorities:
   // 'first_name' - 10
   // 'last_name' - 20
   // 'company' - 30
   // 'country' - 40
   // 'address_1' - 50
   // 'address_2' - 60
   // 'city' - 70
   // 'state' - 80
   // 'postcode' - 90
 
  // e.g. move 'company' above 'first_name':
  // just assign priority less than 10
  $fields['state']['priority'] = 42;
 
  return $fields;
}


add_filter( 'woocommerce_states', 'isokoma_shipping_woocommerce_states' );
function isokoma_shipping_woocommerce_states( $states ) {
  $states['VN'] = array(
    "HANOI" => "Hà Nội",
    "HOCHIMINH" => "Hồ Chí Minh",
    "ANGIANG" => "An Giang",
    "BACGIANG" => "Bắc Giang",
    "BACKAN" => "Bắc Kạn",
    "BACLIEU" => "Bạc Liêu",
    "BACNINH" => "Bắc Ninh",
    "BARIAVUNGTAU" => "Bà Rịa - Vũng Tàu",
    "BENTRE" => "Bến Tre",
    "BINHDINH" => "Bình Định",
    "BINHDUONG" => "Bình Dương",
    "BINHPHUOC" => "Bình Phước",
    "BINHTHUAN" => "Bình Thuận",
    "CAMAU" => "Cà Mau",
    "CANTHO" => "Cần Thơ",
    "CAOBANG" => "Cao Bằng",
    "DAKLAK" => "Đắk Lắk",
    "DAKNONG" => "Đắk Nông",
    "DANANG" => "Đà Nẵng",
    "DIENBIEN" => "Điện Biên",
    "DONGNAI" => "Đồng Nai",
    "DONGTHAP" => "Đồng Tháp",
    "GIALAI" => "Gia Lai",
    "HAGIANG" => "Hà Giang",
    "HAIDUONG" => "Hải Dương",
    "HAIPHONG" => "Hải Phòng",
    "HANAM" => "Hà Nam",
    "HATINH" => "Hà Tĩnh",
    "HAUGIANG" => "Hậu Giang",
    "HOABINH" => "Hòa Bình",
    "HUNGYEN" => "Hưng Yên",
    "KHANHHOA" => "Khánh Hòa",
    "KIENGIANG" => "Kiên Giang",
    "KONTUM" => "Kon Tum",
    "LAICHAU" => "Lai Châu",
    "LAMDONG" => "Lâm Đồng",
    "LANGSON" => "Lạng Sơn",
    "LAOCAI" => "Lào Cai",
    "LONGAN" => "Long An",
    "NAMDINH" => "Nam Định",
    "NGHEAN" => "Nghệ An",
    "NINHBINH" => "Ninh Bình",
    "NINHTHUAN" => "Ninh Thuận",
    "PHUTHO" => "Phú Thọ",
    "PHUYEN" => "Phú Yên",
    "QUANGBINH" => "Quảng Bình",
    "QUANGNAM" => "Quảng Nam",
    "QUANGNGAI" => "Quảng Ngãi",
    "QUANGNINH" => "Quảng Ninh",
    "QUANGTRI" => "Quảng Trị",
    "SOCTRANG" => "Sóc Trăng",
    "SONLA" => "Sơn La",
    "TAYNINH" => "Tây Ninh",
    "THAIBINH" => "Thái Bình",
    "THAINGUYEN" => "Thái Nguyên",
    "THANHHOA" => "Thanh Hóa",
    "THUATHIENHUE" => "Thừa Thiên Huế",
    "TIENGIANG" => "Tiền Giang",
    "TRAVINH" => "Trà Vinh",
    "TUYENQUANG" => "Tuyên Quang",
    "VINHLONG" => "Vĩnh Long",
    "VINHPHUC" => "Vĩnh Phúc",
    "YENBAI" => "Yên Bái",
  );
  return $states;
}



/*
public static function get_zone_matching_package( $packages ) {  
  foreach ( $packages as $package_key => $package ) { 
    global $wpdb;
    $country          = strtoupper( wc_clean( $package['destination']['country'] ) );
    var_dump($country);
    $state            = strtoupper( wc_clean( $package['destination']['state'] ) );
    $continent        = strtoupper( wc_clean( WC()->countries->get_continent_code_for_country( $country ) ) );
    $postcode         = wc_normalize_postcode( wc_clean( $package['destination']['postcode'] ) );
    $cache_key        = WC_Cache_Helper::get_cache_prefix( 'shipping_zones' ) . 'wc_shipping_zone_' . md5( sprintf( '%s+%s+%s', $country, $state, $postcode ) );
    $matching_zone_id = wp_cache_get( $cache_key, 'shipping_zones' );
    var_dump($matching_zone_id);
    // die;

    if ( false === $matching_zone_id ) {

        // Work out criteria for our zone search
        $criteria = array();
        $criteria[] = $wpdb->prepare( "( ( location_type = 'country' AND location_code = %s )", $country );
        $criteria[] = $wpdb->prepare( "OR ( location_type = 'state' AND location_code = %s )", $country . ':' . $state );
        $criteria[] = $wpdb->prepare( "OR ( location_type = 'continent' AND location_code = %s )", $continent );
        $criteria[] = "OR ( location_type IS NULL ) )";

        // Postcode range and wildcard matching
        $postcode_locations = $wpdb->get_results( "SELECT zone_id, location_code FROM {$wpdb->prefix}woocommerce_shipping_zone_locations WHERE location_type = 'postcode';" );

        if ( $postcode_locations ) {
            $zone_ids_with_postcode_rules = array_map( 'absint', wp_list_pluck( $postcode_locations, 'zone_id' ) );
            $matches                      = wc_postcode_location_matcher( $postcode, $postcode_locations, 'zone_id', 'location_code', $country );
            $do_not_match                 = array_unique( array_diff( $zone_ids_with_postcode_rules, array_keys( $matches ) ) );

            if ( ! empty( $do_not_match ) ) {
                $criteria[] = "AND zones.zone_id NOT IN (" . implode( ',', $do_not_match ) . ")";
            }
        }

        // Get matching zones
        $m_zone_id = $wpdb->get_var( "
            SELECT zones.zone_id FROM {$wpdb->prefix}woocommerce_shipping_zones as zones
            LEFT OUTER JOIN {$wpdb->prefix}woocommerce_shipping_zone_locations as locations ON zones.zone_id = locations.zone_id  JOIN {$wpdb->prefix}mpseller_meta as seller_meta on locations.zone_id = seller_meta.zone_id AND location_type != 'postcode'
            WHERE " . implode( ' ', $criteria ) . "
            ORDER BY zone_order ASC LIMIT 1
        " ); 
        if (!empty($m_zone_id)) {
                $matching_zone_id=$m_zone_id;
            }
        else{
            $matching_zone_id=null;
        }
        wp_cache_set( $cache_key, $matching_zone_id, 'shipping_zones' );
    }

    return new WC_Shipping_Zone( $matching_zone_id ? $matching_zone_id : 0 );

    }

}   

*/