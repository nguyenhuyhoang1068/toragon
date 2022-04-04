<?php
/**
 * Plugin Name: Tor Order Status
 * Plugin URI: https://patroids.com
 * Description: This plugin provides Tor Order Status
 * Author: thuytranthanhbd
 * Author URI: https://patroids.com
 * Text Domain: tor-order-status
 * Domain Path: /languages
 * Version: 1.6.1
 *
 * WC requires at least: 3.0
 * WC tested up to: 5.7.1
 *
 * License:     GPLv2+
 */

if (!defined('ABSPATH')) {
  exit;
}
/*
if(current_user_can('administrator')) { 
current_user_can('shop-manager') && 
}*/

add_action( 'manage_shop_order_posts_custom_column' , 'custom_orders_list_column_content', 50, 2 );
function custom_orders_list_column_content( $column, $post_id ) {
    global $the_order;
    if ( $column == 'order_number' )  {        
      if( $phone = $the_order->get_billing_phone() ){
          $phone_wp_dashicon = '<span class="dashicons dashicons-phone"></span> ';
          echo '<br><a href="tel:'.$phone.'">' . $phone_wp_dashicon . $phone.'</a></strong>';
      }
      if( $email = $the_order->get_billing_email() ){
          echo '<br><strong><a href="mailto:'.$email.'">' . $email . '</a></strong>';
      }     
    }
    if ( $column == 'order_status' )  {
      $pre_order = $the_order->get_meta('_wc_pre_orders_is_pre_order');
      if ($pre_order) {          
        echo '<br><strong>Item: Pre-Order</strong>';
      } else {
        echo '<br><strong>Item: Normal</strong>';          
      }
    }
 
}

add_action( 'woocommerce_order_status_collected', 'tor_collected_status_custom_notification', 20, 2 );  
function tor_collected_status_custom_notification( $order_id, $order ) {
  
    $language = get_post_meta( $order->id, 'tor_order_translate', true);
    //$order = wc_get_order( $order_id );
    if ($language == 'vi') {
      $heading = 'Đơn hàng của bạn đã được lấy'; 
      $subject = 'Đơn hàng của bạn đã được lấy';      
    }
    if ($language == 'en_US') {
      $heading = 'Your Toragon HE order has been collected'; 
      $subject = 'Your Toragon HE order has been collected';    
    } 
    $mailer = WC()->mailer();      
    $recipient = $order->get_billing_email();    
    $content = tor_get_processing_notification_content_collected( $order,$heading, $mailer, $language );
    $headers = "Content-Type: text/html\r\n";
    $mailer->send( $recipient, $subject, $content, $headers );
    // $mailer = WC()->mailer()->get_emails(); 
    // $mailer['WC_Email_Customer_Completed_Order']->heading = $heading; 
    // $mailer['WC_Email_Customer_Completed_Order']->settings['heading'] = $heading; 
    // $mailer['WC_Email_Customer_Completed_Order']->subject = $subject; 
    // $mailer['WC_Email_Customer_Completed_Order']->settings['subject'] = $subject;
    // $mailer['WC_Email_Customer_Completed_Order']->trigger( $order_id ); 
}
function tor_get_processing_notification_content_collected( $order, $heading,  $mailer, $language ) {
    $template = 'emails/customer-collected-order.php';
    return wc_get_template_html( $template, array(
      'order'         => $order,
      'email_heading' => $heading,
      'sent_to_admin' => false,
      'plain_text'    => false,
      'email'         => $mailer,
      'language'      => $language
    ) );
}


add_action( 'woocommerce_order_status_shipped', 'tor_shipped_status_custom_notification', 20, 2 );  
function tor_shipped_status_custom_notification( $order_id, $order ) {  
    $language = get_post_meta( $order->id, 'tor_order_translate', true);
    if ($language == 'vi') {
      $heading = 'Đơn hàng của bạn đang được vận chuyển'; 
      $subject = 'Đơn hàng của bạn đang được vận chuyển';      
    }
    if ($language == 'en_US') {
      $heading = 'Your Toragon HE order has been shipped'; 
      $subject = 'Your Toragon HE order has been shipped';
    }
    $mailer = WC()->mailer();      
    $recipient = $order->get_billing_email();    
    $content = tor_get_processing_notification_content_shipped( $order,$heading, $mailer, $language );
    $headers = "Content-Type: text/html\r\n";
    $mailer->send( $recipient, $subject, $content, $headers ); 
    // $mailer = WC()->mailer()->get_emails(); 
    // $mailer['WC_Shipped_Order_Email']->heading = $heading; 
    // $mailer['WC_Shipped_Order_Email']->settings['heading'] = $heading; 
    // $mailer['WC_Shipped_Order_Email']->subject = $subject; 
    // $mailer['WC_Shipped_Order_Email']->settings['subject'] = $subject; 
    // $mailer['WC_Shipped_Order_Email']->trigger( $order_id );      
}

function tor_get_processing_notification_content_shipped( $order, $heading,  $mailer, $language ) {
  $template = 'emails/customer-shipped-order.php';
  return wc_get_template_html( $template, array(
    'order'         => $order,
    'email_heading' => $heading,
    'sent_to_admin' => false,
    'plain_text'    => false,
    'email'         => $mailer,
    'language'      => $language
  ) );
}

function total_label_switch_vi_vn ( $label) {
  if ($label == 'Subtotal:') {
    $label = 'Tổng số phụ:';
  }
  if ($label == 'Shipping:') {
    $label = 'Giao nhận hàng:';
  }
  if ($label == 'Payment method:') {
    $label = 'Phương thức thanh toán:';
  }
  if ($label == 'Total:') {
    $label = 'Tổng cộng:';
  }
  if ($label == 'Transaction fee:') {
    $label = 'Phí giao dịch:';
  }  
  if ($label == 'Cart Discount:') {
    $label = 'Giảm giá:';
  }
  if ($label == 'Phí giao dịch:') {
    $label = 'Phí giao dịch:';
  }
  if ($label == 'Tổng số phụ:') {
    $label = 'Tổng số phụ:';
  }
  if ($label == 'Giao nhận hàng:') {
    $label = 'Giao nhận hàng:';
  }
  if ($label == 'Phương thức thanh toán:') {
    $label = 'Phương thức thanh toán:';
  }
  if ($label == 'Tổng cộng:') {
    $label = 'Tổng cộng:';
  }
  if ($label == 'Giảm giá:') {
    $label = 'Giảm giá:';
  }  
  return $label;
}
function total_label_switch_en_us ( $label) {
  if ($label == 'Phí giao dịch:') {
    $label = 'Transaction fee:';
  }
  if ($label == 'Tổng số phụ:') {
    $label = 'Subtotal:';
  }
  if ($label == 'Giao nhận hàng:') {
    $label = 'Shipping:';
  }
  if ($label == 'Phương thức thanh toán:') {
    $label = 'Payment method:';
  }
  if ($label == 'Tổng cộng:') {
    $label = 'Total:';
  }
  if ($label == 'Subtotal:') {
    $label = 'Subtotal:';
  }
  if ($label == 'Shipping:') {
    $label = 'Shipping:';
  }
  if ($label == 'Payment method:') {
    $label = 'Payment method:';
  }
  if ($label == 'Total:') {
    $label = 'Total:';
  }
  return $label;
}

/*
function add_shipped_order_woocommerce_email( $email_classes ) {	
	require_once( 'includes/class-wc-shipped-order-email.php' );	
	$email_classes['WC_Shipped_Order_Email'] = new WC_Shipped_Order_Email();
	return $email_classes;
}
add_filter( 'woocommerce_email_classes', 'add_shipped_order_woocommerce_email' );
*/


add_action( 'woocommerce_order_status_readytocollect', 'tor_readytocollect_status_custom_notification', 20, 2 );  
function tor_readytocollect_status_custom_notification( $order_id, $order ) {
    $language = get_post_meta( $order->id, 'tor_order_translate', true);
    if ($language == 'vi') {
      $heading = 'Đơn hàng của bạn đang được chuẩn bị'; 
      $subject = 'Đơn hàng của bạn đang được chuẩn bị';
    }
    if ($language == 'en_US') {
      $heading = 'Your Toragon HE order is ready to be collected'; 
      $subject = 'Your Toragon HE order is ready to be collected';
    }   
    $mailer = WC()->mailer();      
    $recipient = $order->get_billing_email();    
    $content = tor_get_processing_notification_content_readytocollect( $order,$heading, $mailer, $language );
    $headers = "Content-Type: text/html\r\n";
    $mailer->send( $recipient, $subject, $content, $headers ); 

    /*$mailer = WC()->mailer()->get_emails(); 
    $mailer['WC_Email_Customer_Processing_Order']->heading = $heading; 
    $mailer['WC_Email_Customer_Processing_Order']->settings['heading'] = $heading; 
    $mailer['WC_Email_Customer_Processing_Order']->subject = $subject; 
    $mailer['WC_Email_Customer_Processing_Order']->settings['subject'] = $subject; 
    $mailer['WC_Email_Customer_Processing_Order']->trigger( $order_id ); */
}

function tor_get_processing_notification_content_readytocollect( $order, $heading,  $mailer, $language ) {
  $template = 'emails/customer-readytocollect-order.php';
  return wc_get_template_html( $template, array(
    'order'         => $order,
    'email_heading' => $heading,
    'sent_to_admin' => false,
    'plain_text'    => false,
    'email'         => $mailer,
    'language'      => $language
  ) );
}





add_action( 'woocommerce_order_status_processing', 'tor_processing_status_custom_notification', 20, 2 );  
function tor_processing_status_custom_notification( $order_id, $order ) {

    $language = get_post_meta( $order->id, 'tor_order_translate', true);
    $pre_order = get_post_meta( $order->id, '_wc_pre_orders_is_pre_order', true);

    if (isset($pre_order) && !empty($pre_order) && $pre_order == 1) {
      if ($language == 'vi') {
        $heading = 'Đơn hàng đặt trước của bạn đã sẵn sàng' ; 
        $subject = 'Đơn hàng đặt trước của bạn đã sẵn sàng';
      }
      if ($language == 'en_US') {
        $heading = 'Your Toragon HE pre-order is now available'; 
        $subject = 'Your Toragon HE pre-order is now available';
      } 
      
      $mailer = WC()->mailer();      
      $recipient = $order->get_billing_email();    
      $content = tor_get_processing_notification_content_pre_order( $order,$heading, $mailer, $language );
      $headers = "Content-Type: text/html\r\n";
      $mailer->send( $recipient, $subject, $content, $headers ); 
    } else {
      if ($language == 'vi') {
        $heading = 'Đơn hàng của bạn đã được xác nhận' ; 
        $subject = 'Đơn hàng của bạn đã được xác nhận';
      }
      if ($language == 'en_US') {
        $heading = 'Your Toragon HE order has been confirmed'; 
        $subject = 'Your Toragon HE order has been confirmed';
      }
      $mailer = WC()->mailer()->get_emails(); 
      $mailer['WC_Email_Customer_Processing_Order']->heading = $heading; 
      $mailer['WC_Email_Customer_Processing_Order']->settings['heading'] = $heading; 
      $mailer['WC_Email_Customer_Processing_Order']->subject = $subject; 
      $mailer['WC_Email_Customer_Processing_Order']->settings['subject'] = $subject; 
    }   
}


function tor_get_processing_notification_content_pre_order( $order, $heading,  $mailer, $language ) {
  $template = 'emails/customer-pre-order-available.php';
  return wc_get_template_html( $template, array(
    'order'         => $order,
    'email_heading' => $heading,
    'sent_to_admin' => false,
    'plain_text'    => false,
    'email'         => $mailer,
    'language'      => $language
  ) );
}


add_action( 'woocommerce_order_status_on-hold', 'tor_on_hold_status_custom_notification', 20, 2 );  
function tor_on_hold_status_custom_notification( $order_id, $order ) {
  $language = get_post_meta( $order->id, 'tor_order_translate', true);
  if ($language == 'vi') {
    $heading = 'Chúng tôi đã nhận được đơn hàng' ; 
    $subject = 'Chúng tôi đã nhận được đơn hàng' ;
  }
  if ($language == 'en_US') {
    $heading = 'Your order has been received by us'; 
    $subject = 'Your order has been received by us';
  }   
  $mailer = WC()->mailer()->get_emails(); 
  $mailer['WC_Email_Customer_On_Hold_Order']->heading = $heading; 
  $mailer['WC_Email_Customer_On_Hold_Order']->settings['heading'] = $heading; 
  $mailer['WC_Email_Customer_On_Hold_Order']->subject = $subject; 
  $mailer['WC_Email_Customer_On_Hold_Order']->settings['subject'] = $subject; 
  //$mailer['WC_Email_Customer_On_Hold_Order']->trigger( $order_id ); 
}

add_action( 'woocommerce_order_status_pre-ordered', 'tor_pre_ordered_status_custom_notification', 20, 2 );  
function tor_pre_ordered_status_custom_notification( $order_id, $order ) {
  $language = get_post_meta( $order->id, 'tor_order_translate', true);
  if ($language == 'vi') {
    $heading = 'Chúng tôi đã nhận được đơn hàng' ; 
    $subject = 'Chúng tôi đã nhận được đơn hàng' ;
  }
  if ($language == 'en_US') {
    $heading = 'Your Toragon HE pre-order has been placed'; 
    $subject = 'Your Toragon HE pre-order has been placed';
  }   
  $mailer = WC()->mailer()->get_emails(); 
  $mailer['WC_Pre_Orders_Email_Pre_Ordered']->heading = $heading; 
  $mailer['WC_Pre_Orders_Email_Pre_Ordered']->settings['heading'] = $heading; 
  $mailer['WC_Pre_Orders_Email_Pre_Ordered']->subject = $subject; 
  $mailer['WC_Pre_Orders_Email_Pre_Ordered']->settings['subject'] = $subject; 
  //$mailer['WC_Email_Customer_On_Hold_Order']->trigger( $order_id ); 
}

/*
add_action( 'woocommerce_order_status_completed', 'tor_completed_status_custom_notification', 20, 2 );  
function tor_completed_status_custom_notification( $order_id, $order ) {
    $language = get_post_meta( $order->id, 'tor_order_translate', true);
    if ($language == 'vi') {
      $heading = 'Đơn hàng của bạn đã được giao'; 
      $subject = 'Đơn hàng của bạn đã được giao';
    }
    if ($language == 'en_US') {
      $heading = 'Your order has been delivered'; 
      $subject = 'Your order has been delivered';
    }   
    $mailer = WC()->mailer()->get_emails(); 
    $mailer['WC_Email_Customer_Completed_Order']->heading = $heading; 
    $mailer['WC_Email_Customer_Completed_Order']->settings['heading'] = $heading; 
    $mailer['WC_Email_Customer_Completed_Order']->subject = $subject; 
    $mailer['WC_Email_Customer_Completed_Order']->settings['subject'] = $subject;
    $mailer['WC_Email_Customer_Completed_Order']->trigger( $order_id );  
}
*/
/*
 * goes in theme functions.php or a custom plugin
 *
 *   woocommerce_email_heading_new_order
 *   woocommerce_email_heading_customer_processing_order
 *   woocommerce_email_heading_customer_completed_order
 *   woocommerce_email_heading_customer_invoice
 *   woocommerce_email_heading_customer_note
 *   woocommerce_email_heading_low_stock
 *   woocommerce_email_heading_no_stock
 *   woocommerce_email_heading_backorder
 *   woocommerce_email_heading_customer_new_account
 *   woocommerce_email_heading_customer_invoice_paid
 *
 * USAGE: add_filter('woocommerce_email_heading_new_order', 'my_filter_email_heading_new_order', 10, 2);
 *
 **/ 
function tor_email_heading_new_order($email_heading, $email){  
  $order_id = $email->get_id();
  //$email_heading = sprintf( __('Order #%1$s', 'twenty-sixteen'), $order_id );
  $language = get_post_meta( $order_id, 'tor_order_translate', true);  
  if ($language == 'vi') {   
    $email_heading = 'Đơn đặt hàng mới' ;
  }
  if ($language == 'en_US') {    
    $email_heading = 'New order placed';
  } 
  return $email_heading;
}
add_filter('woocommerce_email_heading_new_order', 'tor_email_heading_new_order', 10, 2);

function tor_email_heading_customer_completed_order($email_heading, $email){  
  $order_id = $email->get_id();
  //$email_heading = sprintf( __('Order #%1$s', 'twenty-sixteen'), $order_id );
  $language = get_post_meta( $order_id, 'tor_order_translate', true);  
  if ($language == 'vi') {   
    $email_heading = 'Đơn hàng của bạn đã được giao' ;
  }
  if ($language == 'en_US') {    
    $email_heading = 'Your order has been delivered';
  } 
  return $email_heading;
}
add_filter('woocommerce_email_heading_customer_completed_order', 'tor_email_heading_customer_completed_order', 10, 2);

/*
 * goes in theme functions.php or a custom plugin
 *
 * Subject filters: 
 *   woocommerce_email_subject_new_order
 *   woocommerce_email_subject_customer_processing_order
 *   woocommerce_email_subject_customer_completed_order
 *   woocommerce_email_subject_customer_invoice
 *   woocommerce_email_subject_customer_note
 *   woocommerce_email_subject_low_stock
 *   woocommerce_email_subject_no_stock
 *   woocommerce_email_subject_backorder
 *   woocommerce_email_subject_customer_new_account
 *   woocommerce_email_subject_customer_invoice_paid
 **/

 /*
add_filter('woocommerce_email_subject_new_order', 'tor_change_admin_email_subject', 1, 2);
function tor_change_admin_email_subject( $subject, $order ) {
	$language = get_post_meta( $order->id, 'tor_order_translate', true);
  if ($language == 'vi') {   
    $subject = 'Đơn đặt hàng mới' ;
  }
  if ($language == 'en_US') {    
    $subject = 'New order placed';
  } 
	// $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
	// $subject = sprintf( '[%s] New Customer Order (# %s) from Name %s %s', $blogname, $order->id, $order->billing_first_name, $order->billing_last_name );
	return $subject;
}
*/
/*
function tor_email_subject_customer_completed_order( $subject, $order ) {
	$language = get_post_meta( $order->id, 'tor_order_translate', true);
  if ($language == 'vi') {   
    $subject = 'Đơn hàng của bạn đã được giao' ;
  }
  if ($language == 'en_US') {    
    $subject = 'Your order has been delivered';
  } 
	// $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
	// $subject = sprintf( '[%s] New Customer Order (# %s) from Name %s %s', $blogname, $order->id, $order->billing_first_name, $order->billing_last_name );
	return $subject;
}
add_filter('woocommerce_email_subject_customer_completed_order', 'tor_email_subject_customer_completed_order', 10, 2);

*/

add_action( 'woocommerce_email_before_order_table', function(){
  if ( ! class_exists( 'WC_Payment_Gateways' ) ) return;

  $gateways = WC_Payment_Gateways::instance(); // gateway instance
  $available_gateways = $gateways->get_available_payment_gateways();

  if ( isset( $available_gateways['bacs'] ) )
      remove_action( 'woocommerce_email_before_order_table', array( $available_gateways['bacs'], 'email_instructions' ), 10, 3 );
}, 1 );




add_filter( 'woocommerce_admin_order_preview_actions', 'filter_admin_order_preview_actions', 10, 2 );
function filter_admin_order_preview_actions( $actions, $order ) {
    $actions        = array();
    $status_actions = array();
    $pre_order = $order->get_meta('_wc_pre_orders_is_pre_order');
  
    //if ( isset( $pre_order ) && ! empty( $pre_order)  ) {    
      if ( $order->has_status( array( 'pre-ordered', 'on-hold' ) ) ) {
        $status_actions['processing'] = array(
            'url'    => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status=processing&order_id=' . $order->get_id() ), 'woocommerce-mark-order-status' ),
            'name'   => __( 'Processing', 'woocommerce' ),
            'title'  => __( 'Change order status to Processing', 'woocommerce' ),
            'action' => 'processing',
        );
      }
      if ( $order->has_status( array(  'pre-ordered', 'on-hold','processing' ) ) ) {
        $status_actions['shipped'] = array(
            'url'    => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status=shipped&order_id=' . $order->get_id() ), 'woocommerce-mark-order-status' ),
            'name'   => __( 'Shipped', 'woocommerce' ),
            'title'  => __( 'Change order status to Shipped', 'woocommerce' ),
            'action' => 'shipped',
        );  
        $status_actions['readytocollect'] = array(
              'url'    => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status=readytocollect&order_id=' . $order->get_id() ), 'woocommerce-mark-order-status' ),
              'name'   => __( 'Ready to collect', 'woocommerce' ),
              'title'  => __( 'Change order status to Ready to collect', 'woocommerce' ),
              'action' => 'readytocollect',
          );
      }

      if ( $order->has_status( array(  'pre-ordered', 'on-hold','processing', 'readytocollect', 'shipped' ) ) ) {
          $status_actions['collected'] = array(
              'url'    => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status=collected&order_id=' . $order->get_id() ), 'woocommerce-mark-order-status' ),
              'name'   => __( 'Collected', 'woocommerce' ),
              'title'  => __( 'Change order status to Collected', 'woocommerce' ),
              'action' => 'collected',
          );
          $status_actions['complete'] = array(
            'url'    => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status=completed&order_id=' . $order->get_id() ), 'woocommerce-mark-order-status' ),
            'name'   => __( 'Delivered', 'woocommerce' ),
            'title'  => __( 'Change order status to Delivered', 'woocommerce' ),
            'action' => 'complete',
          );
      }
    /*} else {
      if ( $order->has_status( array( 'pending' ) ) ) {
        $status_actions['on-hold'] = array(
            'url'    => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status=on-hold&order_id=' . $order->get_id() ), 'woocommerce-mark-order-status' ),
            'name'   => __( 'On-hold', 'woocommerce' ),
            'title'  => __( 'Change order status to On-hold', 'woocommerce' ),
            'action' => 'on-hold',
        );
      }
      
      if ( $order->has_status( array( 'pending', 'on-hold' ) ) ) {
          $status_actions['processing'] = array(
              'url'    => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status=processing&order_id=' . $order->get_id() ), 'woocommerce-mark-order-status' ),
              'name'   => __( 'Processing', 'woocommerce' ),
              'title'  => __( 'Change order status to Processing', 'woocommerce' ),
              'action' => 'processing',
          );
      }
      if ( $order->has_status( array( 'pending', 'on-hold', 'processing' ) ) ) {
        $status_actions['shipped'] = array(
            'url'    => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status=shipped&order_id=' . $order->get_id() ), 'woocommerce-mark-order-status' ),
            'name'   => __( 'Shipped', 'woocommerce' ),
            'title'  => __( 'Change order status to Shipped', 'woocommerce' ),
            'action' => 'shipped',
        );
      }
       
      if ( $order->has_status( array( 'pending', 'on-hold' , 'shipped' ) ) ) {
          $status_actions['complete'] = array(
              'url'    => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status=completed&order_id=' . $order->get_id() ), 'woocommerce-mark-order-status' ),
              'name'   => __( 'Delivered', 'woocommerce' ),
              'title'  => __( 'Change order status to Delivered', 'woocommerce' ),
              'action' => 'complete',
          );
      }
    } */

    if ( $status_actions ) {
        $actions['status'] = array(
            'group'   => __( 'Change status: ', 'woocommerce' ),
            'actions' => $status_actions,
        );
    }
    return $actions;
}




add_filter( 'woocommerce_admin_order_preview_get_order_details', 'admin_order_preview_add_custom_meta_data', 10, 2 );
function admin_order_preview_add_custom_meta_data( $data, $order ) {
    // Replace '_custom_meta_key' by the correct postmeta key
    // if( $custom_value = $order->get_meta('_payment_method') )
    //    
    $pre_order = $order->get_meta('_wc_pre_orders_is_pre_order');
    if ($pre_order) {
      $data['key_pre_order'] = "Pre-Order"; 
    } else {
      $data['key_pre_order'] = "normal"; 
    }
   
    return $data;
}

// Display custom values in Order preview
add_action( 'woocommerce_admin_order_preview_end', 'custom_display_order_data_in_admin2' );
function custom_display_order_data_in_admin2(){
    // Call the stored value and display it
    echo '<h2 style="text-align:center;">Item: {{data.key_pre_order}}</h2>';
}



















//For scheduling events 48 hours
add_action( 'wpb_custom_notify_48h', 'wpb_custom_cron_48h' );
 
function wpb_custom_cron_48h($status) {
  if ( $status == 'delivered' || $status == 'ready_to_collect' ) {
    $customer_orders = get_posts(array(
      'numberposts' => -1,
      'meta_key' => '_customer_user',
      'orderby' => 'date',
      'order' => 'DESC',      
      'post_type' => wc_get_order_types(),
      'post_status' => array_keys(wc_get_order_statuses()), 'post_status' => array('wc-processing'),
    ));
    
    if (!empty($customer_orders) ){
      $message = '';      
      $subject = "Vui lòng cập nhật tình trạng của đơn hàng.";
      $message .= '<center>';
      $message .= '<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="mFullWidth" bgcolor="black">';
      $message .= '<tr>';              
      $message .= '<td height="30"></td>';
      $message .= '</tr>';  
      $message .= '<tr>';             
      $message .= '<td align="center" valign="top" style="font-size:25px; line-height:25px;  font-weight: 300; text-align:center; font-family:arial, sans-serif; color:#fbcf1f;">
        Vui lòng cập nhật tình trạng của đơn hàng</td>';
      $message .= '</tr>';  
      $message .= '<tr>';              
      $message .= '<td height="30"></td>';
      $message .= '</tr>';  
      $message .= '</table>'; 
      $message .= '<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="mFullWidth" bgcolor="#1a1918" style="background-color: #1a1918;">';
      $message .= '<tr>';  
      $message .= '<td width="35"></td>';                 
      $message .= '<td>';      
      $message .= '<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="mFullWidth">';

      $message .= '<tr><td height="30" style="height:30px;"></td></tr>';      
      $message .= '<tr>';                  
      $message .= '<td align="left" style="font-size:16px; line-height:1.3; text-align:left; font-family:arial, sans-serif; color:#ffffff;">Gửi nhân viên,</td>';            
      $message .= '</tr>';  
      $message .= '<tr>';              
      $message .= '<td height="15"></td>';
      $message .= '</tr>';
      $message .= '<tr>';              
      $message .= '<td style="font-size:16px; line-height:1.3; text-align:left; font-family:arial, sans-serif; color:#ffffff;">
      Vui lòng cập nhật tình trạng cho đơn hàng dưới đây, trạng thái hiện tại sau 48 giờ vẫn là “Đang chuẩn bị”. Vui lòng thay đổi sang “Đã nhận hàng” hoặc “Sẵn sàng giao hàng”.
      </td>';
      $message .= '</tr>';
      $message .= '<tr>';              
      $message .= '<td height="15"></td>';
      $message .= '</tr>';  
      $message .= '</table>'; 
    
      $message .= '<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center" class="mFullWidth">';
    
      $message .='<tr><th align="center" style="font-size:16px; line-height: 25px; text-align:center; font-family:arial, sans-serif; color:#ffffff;">Mã đặt hàng</th>
      <th align="center" style="font-size:16px; line-height: 25px; text-align:center; font-family:arial, sans-serif; color:#ffffff;">Ngày đặt hàng</th></tr>';
      $message .='<tr><td  colspan="2" ><hr style="width:100%;" /></td></tr>';    
      foreach ($customer_orders as $customer_order) {
        $orderq = wc_get_order($customer_order);    
        $date_order = $orderq->get_date_created()->date_i18n('d-m-Y');     
        $currency_code = $orderq->get_currency();
        $currency_symbol = get_woocommerce_currency_symbol( $currency_code );                    
        $message .= '<tr>';                  
        $message .= '<td align="center"  style="font-size:16px; line-height:25px; text-align:center; font-family:arial, sans-serif; color:#ffffff;">#'.$orderq->get_id().'</td>'; 
        $message .= '<td align="center"  style="font-size:16px; line-height:25px; text-align:center; font-family:arial, sans-serif; color:#ffffff;">'.$date_order.'</td>';        
        $message .= '</tr>';       
      }      
      $message .= '</table>'; 

      $message .= '<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="mFullWidth">';       
      $message .= '<tr>';              
      $message .= '<td height="15"></td>';
      $message .= '</tr>';  
      $message .= '<tr>';                  
      $message .= '<td align="left" style="font-size:16px; line-height:1.3; text-align:left; font-family:arial, sans-serif; color:#ffffff;">Trân trọng,</td>';            
      $message .= '</tr>';
    
      $message .= '<tr>';                  
      $message .= '<td align="left" style="font-size:16px; line-height:1.3; text-align:left; font-family:arial, sans-serif; color:#ffffff;">Toragon HE</td>';                
      $message .= '</tr>';  
      $message .= '<tr>';              
      $message .= '<td height="30"></td>';
      $message .= '</tr>';
      $message .= '</table>'; 

      $message .= '</td>';  
      $message .= '<td width="35"></td>';     
      $message .= '</tr>';  
      $message .= '</table>'; 
      $message .= '</center>';
      
      $to = array('sales_toragon@ligust.com');  
      $sale = 'sales@toragon.vn';
      $headers = [];    
      $headers[] = 'From: Toragon HE Sales <'.$sale.'>';
      $headers[] = 'MIME-Version: 1.0' . "\r\n";
      $headers[] = 'Content-type: text/html; charset="UTF-8' . "\r\n";
      wp_mail($to, $subject, $message, $headers);
    }
  }
}

//For scheduling events 24 hours
add_action( 'wpb_custom_notify_24h', 'wpb_custom_cron_24h' );
 
function wpb_custom_cron_24h($status) {
  if ( $status == 'processing' ) {
    $customer_orders = get_posts(array(
      'numberposts' => -1,
      'meta_key' => '_customer_user',
      'orderby' => 'date',
      'order' => 'DESC',      
      'post_type' => wc_get_order_types(),
      'post_status' => array_keys(wc_get_order_statuses()), 'post_status' => array('wc-on-hold', 'wc-pending'),
    ));
    if (!empty($customer_orders) ){
      $message = '';
      $subject = "Vui lòng cập nhật tình trạng của đơn hàng.";
      $message .= '<center>';
      $message .= '<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="mFullWidth" bgcolor="black">';
      $message .= '<tr>';              
      $message .= '<td height="30"></td>';
      $message .= '</tr>';  
      $message .= '<tr>';                  
      $message .= '<td align="center" valign="top" style="font-size:25px; line-height:25px;  font-weight: 300; text-align:center; font-family:arial, sans-serif; color:#fbcf1f;">
      Vui lòng cập nhật tình trạng của đơn hàng</td>';
      $message .= '</tr>';  
      $message .= '<tr>';              
      $message .= '<td height="30"></td>';
      $message .= '</tr>';  
      $message .= '</table>'; 
      $message .= '<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="mFullWidth" bgcolor="#1a1918" style="background-color: #1a1918;">';
      $message .= '<tr>';         
      $message .= '<td width="35"></td>';     
      $message .= '<td>';              
      $message .= '<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="mFullWidth">';
      $message .= '<tr>';              
      $message .= '<td height="30"></td>';
      $message .= '</tr>';  
      $message .= '<tr>';                  
      $message .= '<td align="left" style="font-size:16px; line-height:25px; text-align:left; font-family:arial, sans-serif; color:#ffffff;">Gửi nhân viên,</td>';            
      $message .= '</tr>';  
      $message .= '<tr>';              
      $message .= '<td height="15"></td>';
      $message .= '</tr>';  
      $message .= '<tr>';              
      $message .= '<td style="font-size:16px; line-height:25px; text-align:left; font-family:arial, sans-serif; color:#ffffff;">
      Vui lòng cập nhật tình trạng cho đơn hàng dưới đây, trạng thái hiện tại sau 24 giờ vẫn là “Giữ hàng”. Vui lòng thay đổi sang “Đang chuẩn bị”.</td>';
      $message .= '</tr>';
      $message .= '<tr>';              
      $message .= '<td height="15"></td>';
      $message .= '</tr>';  
      $message .= '</table>'; 

    
      $message .= '<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center" class="mFullWidth">';
    
      $message .='<tr><th align="center"  style="font-size:16px; line-height: 25px; text-align:center; font-family:arial, sans-serif; color:#ffffff;">Mã đặt hàng</th>
      <th align="center"  style="font-size:16px; line-height:25px; text-align:center; font-family:arial, sans-serif; color:#ffffff;">Ngày đặt hàng</th></tr>';
      $message .='<tr><td  colspan="2" ><hr style="width:100%; border-bottom: 1px solid #ffffff;" /></td></tr>';
      foreach ($customer_orders as $customer_order) {
        $orderq = wc_get_order($customer_order);    
        $date_order = $orderq->get_date_created()->date_i18n('d-m-Y');     
        $currency_code = $orderq->get_currency();
        $currency_symbol = get_woocommerce_currency_symbol( $currency_code );                    
        $message .= '<tr>';                  
        $message .= '<td align="center" style="font-size:16px; line-height: 25px; text-align:center; font-family:arial, sans-serif; color:#ffffff;">#'.$orderq->get_id().'</td>'; 
        $message .= '<td align="center" style="font-size:16px; line-height: 25px; text-align:center; font-family:arial, sans-serif; color:#ffffff;">'. $date_order.'</td>';        
        $message .= '</tr>';       
      }      
      $message .= '</table>'; 

      $message .= '<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="mFullWidth">';       
      $message .= '<tr>';              
      $message .= '<td height="15"></td>';
      $message .= '</tr>';  
      $message .= '<tr>';                  
      $message .= '<td align="left" style="font-size:16px; line-height:1.3; text-align:left; font-family:arial, sans-serif; color:#ffffff;">Trân trọng,</td>';            
      $message .= '</tr>';
    
      $message .= '<tr>';                  
      $message .= '<td align="left" style="font-size:16px; line-height:1.3; text-align:left; font-family:arial, sans-serif; color:#ffffff;">Toragon HE</td>';                
      $message .= '</tr>';  
      $message .= '<tr>';              
      $message .= '<td height="30"></td>';
      $message .= '</tr>';
      $message .= '</table>'; 


      $message .= '</td>';  
      $message .= '<td width="35"></td>';     
      $message .= '</tr>';        
      $message .= '</table>'; 
      $message .= '</center>';
      
      $to = array('sales_toragon@ligust.com');  
      $sale = 'sales@toragon.vn';
      $headers = [];    
      $headers[] = 'From: Toragon HE Sales <'.$sale.'>';
      $headers[] = 'MIME-Version: 1.0' . "\r\n";
      $headers[] = 'Content-type: text/html; charset="UTF-8' . "\r\n";
      wp_mail($to, $subject, $message, $headers);
    }
  }
}





