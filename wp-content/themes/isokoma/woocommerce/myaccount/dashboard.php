<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$allowed_html = array(
	'a' => array(
		'href' => array(),
	),
);
?>
<h1 class="h2">
	<?php
	printf(
		/* translators: 1: user display name 2: logout url */
		wp_kses( __( 'Hello %1$s', 'isokoma' ), $allowed_html ),'<strong>' . esc_html( $current_user->display_name ) .'</strong>'
	);
	?>
</h1>

<p class="welcome-dashboard">
	<?php
	/* translators: 1: Orders URL 2: Address URL 3: Account URL. */
	$dashboard_desc = __( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">billing address</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce' );
	if ( wc_shipping_enabled() ) {
		/* translators: 1: Orders URL 2: Addresses URL 3: Account URL. */
		$dashboard_desc = __( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">shipping and billing addresses</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce' );
	}
	printf(
		wp_kses( $dashboard_desc, $allowed_html ),
		esc_url( wc_get_endpoint_url( 'orders' ) ),
		esc_url( wc_get_endpoint_url( 'edit-address' ) ),
		esc_url( wc_get_endpoint_url( 'edit-account' ) )
	);
	?>
</p>

<?php
//  $mwb_user_level = get_user_meta( get_current_user_id(), 'membership_level', true );
  $get_points = (int) get_user_meta( get_current_user_id(), 'mwb_wpr_points', true );
  $my_role = ! empty( get_user_meta( get_current_user_id(), 'membership_level', true ) ) ? get_user_meta( get_current_user_id(), 'membership_level', true ) : ' - ';
  if (isset($my_role) && !empty ($my_role) && $my_role == 'VIP') {
    $membership_expiration = get_user_meta( get_current_user_id(), 'membership_expiration', true );
    $recurrence = get_user_meta( get_current_user_id(), 'membership_recurrence', true );
    if (!empty($recurrence )) {
      $end_recurrence = $recurrence['recurrence'];
      $end_recurrence = end($end_recurrence);
    }
  }  
  
  $customer_orders_pending = get_posts(array(
    'numberposts' => -1,
    'meta_key' => '_customer_user',
    'orderby' => 'date',
    'order' => 'DESC',
    'meta_value' => get_current_user_id(),
    'post_type' => wc_get_order_types(),
    'post_status' => array_keys(wc_get_order_statuses()), 'post_status' => array('wc-pending', 'wc-on-hold'),
  ));
  $customer_orders_completed = get_posts(array(
    'numberposts' => -1,
    'meta_key' => '_customer_user',
    'orderby' => 'date',
    'order' => 'DESC',
    'meta_value' => get_current_user_id(),
    'post_type' => wc_get_order_types(),
    'post_status' => array_keys(wc_get_order_statuses()), 'post_status' => array('wc-completed', 'wc-collected'),
  ));
  
  $current_language = get_locale();
  $current_user = wp_get_current_user();
  $current_user_id = $current_user->ID;
  update_user_meta ( $current_user_id, 'points_notification_translate', $current_language );
  

  //   $order = wc_get_order( $order_id );
// // Get Order Dates
// $order->get_date_created();
// $order->get_date_modified();
// $order->get_date_completed();
// $order->get_date_paid();
/*
$email_actions = array(
  'woocommerce_low_stock',
  'woocommerce_no_stock',
  'woocommerce_product_on_backorder',
  'woocommerce_order_status_pending_to_processing',
  'woocommerce_order_status_pending_to_completed',
  'woocommerce_order_status_pending_to_on-hold',
  'woocommerce_order_status_failed_to_processing',
  'woocommerce_order_status_failed_to_completed',
  'woocommerce_order_status_completed',
  'woocommerce_new_customer_note',
  'woocommerce_created_customer'
);
*/
?>



<div class="row point-intro">
  <div class="col-sm-6 col-xs-12 col-sm-offset-2">
    <table class="table table-bordered"> 
      <tbody>
        <tr>
          <td style="font-weight: 500;">Tư cách thành viên</td>
          <td><?php echo $my_role ; echo $end_recurrence['current'] ? '/Member since: '. $end_recurrence['current']: '';  ?></td>   
        </tr>
        <tr>
          <td style="font-weight: 500;">Số lượng đơn đã hoàn thành</td>
          <td><?php echo count($customer_orders_completed); ?></td>     
        </tr>
        <tr>
          <td style="font-weight: 500;">Số lượng đơn đang xử lý</td>
          <td><?php echo count($customer_orders_pending); ?></td>      
        </tr>
        <tr>
          <td style="font-weight: 500;">Điểm thưởng TORA hiện có</td>
          <td><?php echo $get_points ;  ?></td>      
        </tr>     
      </tbody>
    </table>
  </div>
</div>
<style> 
.point-intro .table-bordered {
  border: 1px solid #606060 !important;
  border-collapse: collapse;
}
.point-intro .table-bordered tr td {
  background-color: #2d2d2d !important;
  color: #fff;
  font-size: 18px; 
  border: 1px solid #606060 !important;
}
</style>
<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );


  
/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
