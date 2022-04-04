<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    mwb_wpr_points_template.php
 * @subpackage points-and-rewards-for-wooCommerce/public/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
Declarations
*/
$user_id = get_current_user_id();
$membership_expiration = get_user_meta( $user_id, 'membership_expiration', true );
$recurrence = get_user_meta( $user_id, 'membership_recurrence', true );
$membership_delete = get_user_meta( $user_id, 'membership_delete', true );

$currency_rate_fee = WOOMULTI_CURRENCY_F_Admin_Settings::get_field( 'currency_rate', array( 0.0000 ) );
$total_price = 0;
$normal_date = '';
$my_role = ! empty( get_user_meta( $user_id, 'membership_level', true ) ) ? get_user_meta( $user_id, 'membership_level', true ) : '';
if ( isset( $_POST['mwb_wpr_save_level'] ) && isset( $_POST['membership-save-level'] ) && isset( $_POST['mwb_wpr_membership_roles'] ) && sanitize_text_field( wp_unslash( $_POST['mwb_wpr_membership_roles'] ) ) != $my_role ) {
	$mwb_wpr_nonce = sanitize_text_field( wp_unslash( $_POST['membership-save-level'] ) );
	if ( wp_verify_nonce( $mwb_wpr_nonce, 'membership-save-level' ) ) {
		$selected_role = isset( $_POST['mwb_wpr_membership_roles'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_wpr_membership_roles'] ) ) : '';// phpcs:ignore WordPress.Security.NonceVerification
		$user_id = get_current_user_id();
		$user = get_user_by( 'ID', $user_id );
		$get_points = (int) get_user_meta( $user_id, 'mwb_wpr_points', true );
		$membership_detail = get_user_meta( $user_id, 'points_details', true );
		$today_date = date_i18n( 'Y-m-d h:i:sa', current_time( 'timestamp', 0 ) );
		$expiration_date = '';
		$membership_settings_array = get_option( 'mwb_wpr_membership_settings', true );
		$mwb_wpr_membership_roles = isset( $membership_settings_array['membership_roles'] ) && ! empty( $membership_settings_array['membership_roles'] ) ? $membership_settings_array['membership_roles'] : array();
		foreach ( $mwb_wpr_membership_roles as $roles => $values ) {
			if ( $selected_role == $roles && ( $values['Points'] == $get_points || $values['Points'] < $get_points ) ) {
				/*Calculate the points*/
				//$remaining_points = $get_points - $values['Points'];
        $remaining_points = $get_points - (int) 0;
				/*Update points log*/
				$data = array();
				$this->mwb_wpr_update_points_details( $user_id, 'membership', $values['Points'], $data );

				if ( isset( $values['Exp_Number'] ) && ! empty( $values['Exp_Number'] ) && isset( $values['Exp_Days'] ) && ! empty( $values['Exp_Days'] ) ) {
					$expiration_date = date_i18n( 'Y-m-d', strtotime( $today_date . ' +' . $values['Exp_Number'] . ' ' . $values['Exp_Days'] ) );
				}
      
				update_user_meta( $user_id, 'mwb_wpr_points', $remaining_points );
				update_user_meta( $user_id, 'membership_level', $selected_role );
				update_user_meta( $user_id, 'membership_expiration', $expiration_date );
				/*Send mail*/
				$user = get_user_by( 'ID', $user_id );
				$mwb_wpr_shortcode = array(
					'[USERLEVEL]' => $selected_role,
					'[USERNAME]'  => $user->user_login,
				);

				$mwb_wpr_subject_content = array(
					'mwb_wpr_subject' => 'mwb_wpr_membership_email_subject',
					'mwb_wpr_content' => 'mwb_wpr_membership_email_discription_custom_id',
				);
				$this->mwb_wpr_send_notification_mail_product( $user_id, $values['Points'], $mwb_wpr_shortcode, $mwb_wpr_subject_content );
			}
		}
	}
}



/* Get points of the Membership Level*/
$mwb_user_level = get_user_meta( $user_id, 'membership_level', true );
/* Get the General Settings*/
$general_settings = get_option( 'mwb_wpr_settings_gallery', true );
$enable_mwb_refer = isset( $general_settings['mwb_wpr_general_refer_enable'] ) ? intval( $general_settings['mwb_wpr_general_refer_enable'] ) : 0;
$mwb_refer_value = isset( $general_settings['mwb_wpr_general_refer_value'] ) ? intval( $general_settings['mwb_wpr_general_refer_value'] ) : 1;
$mwb_text_points_value = isset( $general_settings['mwb_wpr_general_text_points'] ) ? $general_settings['mwb_wpr_general_text_points'] : esc_html__( 'Total spend', 'points-and-rewards-for-woocommerce' );
$mwb_ways_to_gain_points_value = isset( $general_settings['mwb_wpr_general_ways_to_gain_points'] ) ? $general_settings['mwb_wpr_general_ways_to_gain_points'] : '';
// End Section of the Setings.
// Get the General Settings.
$membership_settings_array = get_option( 'mwb_wpr_membership_settings', true );
$mwb_wpr_mem_enable = isset( $membership_settings_array['mwb_wpr_membership_setting_enable'] ) ? intval( $membership_settings_array['mwb_wpr_membership_setting_enable'] ) : 0;
$coupon_settings = get_option( 'mwb_wpr_coupons_gallery', true );
$get_points = (int) get_user_meta( $user_id, 'mwb_wpr_points', true );
$coupon_redeem_price = ( isset( $coupon_settings['coupon_redeem_price'] ) && null != $coupon_settings['coupon_redeem_price'] ) ? $coupon_settings['coupon_redeem_price'] : 1;
$coupon_redeem_points = ( isset( $coupon_settings['coupon_redeem_points'] ) && null != $coupon_settings['coupon_redeem_points'] ) ? intval( $coupon_settings['coupon_redeem_points'] ) : 1;

$mwb_per_currency_spent_price = isset( $coupon_settings['mwb_wpr_coupon_conversion_price'] ) ? intval( $coupon_settings['mwb_wpr_coupon_conversion_price'] ) : 1;
$mwb_per_currency_spent_points = isset( $coupon_settings['mwb_wpr_coupon_conversion_points'] ) ? intval( $coupon_settings['mwb_wpr_coupon_conversion_points'] ) : 1;
$mwb_comment_value = isset( $general_settings['mwb_comment_value'] ) ? intval( $general_settings['mwb_comment_value'] ) : 1;
$mwb_refer_value_disable = isset( $general_settings['mwb_wpr_general_refer_value_disable'] ) ? intval( $general_settings['mwb_wpr_general_refer_value_disable'] ) : 0;
$mwb_user_point_expiry = get_user_meta( $user_id, 'mwb_wpr_points_expiration_date', true );
/* End the memebership settings*/
$get_referral = get_user_meta( $user_id, 'mwb_points_referral', true );
$get_referral_invite = get_user_meta( $user_id, 'mwb_points_referral_invite', true );
$points_notification_translate = get_user_meta( $user_id, 'points_notification_translate', true );


if ( (isset($recurrence)  && !empty($recurrence)) ) {
  $end_recurrence = $recurrence['recurrence'];
  $end_recurrence = end($end_recurrence);

  $today_year = date('Y', strtotime($end_recurrence['current']));
  $today_mon = date('m', strtotime($end_recurrence['current']));
  $today_day = date('d', strtotime($end_recurrence['current']));
  //$today = getdate();
  $customer_orders = get_posts( array(
    'numberposts' => - 1,
    'meta_key'    => '_customer_user',
    'meta_value'  => get_current_user_id(),
    'post_type'   => array( 'shop_order' ),
    'post_status' => array( 'wc-completed' , 'wc-collected'),
    'date_query' =>
      array(
        array(
            'year'  => $today_year,
            'compare'   => '>=',
        ),
        array(
            'month' => $today_mon,
            'compare' => '>=',
        ),
        array(
            'day' => $today_day,
            'compare' => '>=',
        )
      ),
      /*
      'date_query' => array(
          // 'after' => date('Y-m-d', strtotime('-10 days')),  
          // 'before' => date('Y-m-d', strtotime('today')) 
          'after' => date('Y-m-d', strtotime($end_recurrence['current'])),
          'before' => date('Y-m-d', strtotime($membership_expiration))           
      )*/

  ));
  foreach ( $customer_orders as $customer_order ) {        
    $orderq = wc_get_order($customer_order);    
    $currency_code = $orderq->get_currency();
    $currency_symbol = get_woocommerce_currency_symbol( $currency_code );     
    if ($currency_code === 'VND') {
      $total_price += $orderq->get_total();        
    } else {
      $total_price += ($orderq->get_total() /$currency_rate_fee[1]);
    }
  }   
 
} else if ((isset($membership_delete)  && !empty($membership_delete)) ) {
  $membership_delete = $membership_delete['data_delete'];
  $membership_delete = end($membership_delete);

  $today_year = date('Y', strtotime($membership_delete['delete']));
  $today_mon = date('m', strtotime($membership_delete['delete']));
  $today_day = date('d', strtotime($membership_delete['delete']));
  //$today = getdate();
  $customer_orders = get_posts( array(
    'numberposts' => - 1,
    'meta_key'    => '_customer_user',
    'meta_value'  => get_current_user_id(),
    'post_type'   => array( 'shop_order' ),
    'post_status' => array( 'wc-completed', 'wc-collected'),
    'date_query' =>
      array(
        array(
            'year'  => $today_year,
            'compare'   => '>=',
        ),
        array(
            'month' => $today_mon,
            'compare' => '>=',
        ),
        array(
            'day' => $today_day,
            'compare' => '>=',
        )
      ),
      /*
      'date_query' => array(
          // 'after' => date('Y-m-d', strtotime('-10 days')),  
          // 'before' => date('Y-m-d', strtotime('today')) 
          'after' => date('Y-m-d', strtotime($end_recurrence['current'])),
          'before' => date('Y-m-d', strtotime($membership_expiration))           
      )*/

  ));
  foreach ( $customer_orders as $customer_order ) {        
    $orderq = wc_get_order($customer_order);    
    $currency_code = $orderq->get_currency();
    $currency_symbol = get_woocommerce_currency_symbol( $currency_code );     
    if ($currency_code === 'VND') {
      $total_price += $orderq->get_total();        
    } else {
      $total_price += ($orderq->get_total() /$currency_rate_fee[1]);
    }
  }   
} else {
  // Get all customer orders
  
  $customer_orders = get_posts(array(
    'numberposts' => -1,
    'meta_key' => '_customer_user',
    'orderby' => 'date',
    'order' => 'DESC',
    'meta_value' => get_current_user_id(),
    'post_type' => wc_get_order_types(),
    'post_status' => array_keys(wc_get_order_statuses()), 'post_status' => array('wc-completed', 'wc-collected'),
  ));
  $Order_Array = [];     
    

  $today = date_i18n( 'Y-m-d', current_time( 'timestamp', 0 ) );
  $date_today = new DateTime($today);
  foreach ($customer_orders as $customer_order) {
      $orderq = wc_get_order($customer_order);    
      $currency_code = $orderq->get_currency();
      $currency_symbol = get_woocommerce_currency_symbol( $currency_code ); 
    
      $date_order = new DateTime($orderq->get_date_created()->date_i18n('Y-m-d'));        
      $diff = $date_today->diff($date_order);    
      $day_remaining = $diff->days;
      $Order_Array[] = [
        "ID" => $orderq->get_id(),
        "Value" => $orderq->get_total(),
        "Date" => $orderq->get_date_created()->date_i18n('Y-m-d'),
        'Day' => $day_remaining,
        'Currency_code' => $currency_code,
      ];       
  }
  $normal_date = end($Order_Array);
  
  foreach ($Order_Array as $key => $value) {
    if ($value['Currency_code'] === 'VND') {
      if ($value['Day'] <= 365){
        $total_price += $value['Value'];        
      }
    } else {
      if ($value['Day'] <= 365){
        $total_price += ($value['Value']/$currency_rate_fee[1]);        
      }
    }    
  }  
}

// $order->get_date_created();
// $order->get_date_modified();
// $order->get_date_completed();
// $order->get_date_paid();




if ($total_price >= 100000000 && $my_role == '') {
 
  $recurrence = get_user_meta( $user_id, 'membership_recurrence', true );
  $selected_role = 'VIP';
  $user_id = get_current_user_id();
  $user = get_user_by( 'ID', $user_id );
  $get_points = (int) get_user_meta( $user_id, 'mwb_wpr_points', true );
  $membership_detail = get_user_meta( $user_id, 'points_details', true );
  $today_date = date_i18n( 'Y-m-d', current_time( 'timestamp', 0 ) );
  $expiration_date = '';
  $membership_settings_array = get_option( 'mwb_wpr_membership_settings', true );
  $mwb_wpr_membership_roles = isset( $membership_settings_array['membership_roles'] ) && ! empty( $membership_settings_array['membership_roles'] ) ? $membership_settings_array['membership_roles'] : array();
  
  foreach ( $mwb_wpr_membership_roles as $roles => $values ) {    
    $next_day =  date('d/m/Y', strtotime('365 day', strtotime($saved_date))); 
       
    if ( $selected_role == $roles ) {   	
     
      //$remaining_points = $get_points - $values['Points'];
      $remaining_points = $get_points - (int) 0;
      /*Update points log*/
      $data = array();        
      if ( isset( $values['Exp_Number'] ) && ! empty( $values['Exp_Number'] ) && isset( $values['Exp_Days'] ) && ! empty( $values['Exp_Days'] ) ) {
        $expiration_date = date_i18n( 'Y-m-d', strtotime( $today_date . ' +' . $values['Exp_Number'] . ' ' . $values['Exp_Days'] ) );
      }        
      if ( ! is_array( $recurrence ) ) {
        $recurrence = array();
      }

      $data = [
        'current' => $today_date,
      ];
      $recurrence['recurrence'][] = $data;      
      update_user_meta( $user_id, 'mwb_wpr_points', $remaining_points );
      update_user_meta( $user_id, 'membership_level', $selected_role );
      update_user_meta( $user_id, 'membership_expiration', $expiration_date );
      update_user_meta( $user_id, 'membership_recurrence', $recurrence );

      /*Send mail*/
      $user = get_user_by( 'ID', $user_id );
      $mwb_wpr_shortcode = array(
        '[USERLEVEL]' => $selected_role,
        '[USERNAME]'  => $user->user_login,
      );
      
      $mwb_wpr_subject_content = array(
        'mwb_wpr_subject' => 'mwb_wpr_membership_email_subject',
        'mwb_wpr_content' => 'mwb_wpr_membership_email_discription_custom_id',
      );

      if ($points_notification_translate == 'vi') {
        $mwb_wpr_subject_content = array(
          'mwb_wpr_subject' => 'mwb_wpr_membership_email_subject_vi',
          'mwb_wpr_content' => 'mwb_wpr_membership_email_discription_custom_id_vi',
        );
      } elseif ($points_notification_translate == 'en_US') {
        $mwb_wpr_subject_content = array(
          'mwb_wpr_subject' => 'mwb_wpr_membership_email_subject',
          'mwb_wpr_content' => 'mwb_wpr_membership_email_discription_custom_id',
        );
      } else{
        $mwb_wpr_subject_content = array(
          'mwb_wpr_subject' => 'mwb_wpr_membership_email_subject',
          'mwb_wpr_content' => 'mwb_wpr_membership_email_discription_custom_id',
        );
      }

      $this->mwb_wpr_send_notification_mail_product( $user_id, $values['Points'], $mwb_wpr_shortcode, $mwb_wpr_subject_content );
    }
  }
}


if (($my_role != '') && isset($my_role) && ($my_role == 'VIP')  && (isset($membership_expiration)) ){    
  $today_date = date_i18n( 'Y-m-d', current_time( 'timestamp', 0 ) );
  if ($today_date >= $membership_expiration ) {    
    $data = array();        
    delete_user_meta( $user_id, 'mwb_wpr_points', $get_points );   
    delete_user_meta( $user_id, 'membership_level', 'VIP' );   
    update_user_meta( $user_id, 'points_details', $data );   
    update_user_meta( $user_id, 'admin_points', $data );   
    delete_user_meta( $user_id, 'membership_expiration', $membership_expiration );         
    $data = [
      'delete' => $today_date,
    ];
    $data_delete['data_delete'][] = $data;
    update_user_meta( $user_id, 'membership_delete', $data_delete );
  }    
  /*
  $point_log    = get_user_meta( $user_id, 'points_details', true );  
  if ( isset( $point_log ) && is_array( $point_log ) && null != $point_log ) {
    foreach ( $point_log['pro_conversion_points'] as $key => $value ) { 
      $next_day =  date('Y-m-d', strtotime('365 day', strtotime($value['date'])));
      
      if ($key == 0) {        
        $date1 = new DateTime($today_date);
        $date2 = new DateTime($next_day);
        $diff = $date1->diff($date2);    
        $day_remaining = $diff->days;
        if ($diff->days == 0) {
          update_user_meta( $user_id, 'mwb_wpr_points', 0 );  
                          
        }   
      }    
    }
  } */   
} 





if ( ! is_array( $coupon_settings ) ) {
	$coupon_settings = array();
}
if(get_woocommerce_currency() =='VND'){    
  $total_price =  wc_price( $total_price,  'VND' );
}
else{
  $total_spent =  (round ($total_price, 2) * $currency_rate_fee[1]);  
  $total_price =  wc_price( $total_spent,  'USD' );
}

?>

<div class="mwb_wpr_points_wrapper_with_exp">
	<div class="mwb_wpr_points_only">


    <?php if ($my_role != '') { ?>
   	<?php
		$get_points = get_user_meta( $user_id, 'mwb_wpr_points', true );
		//$get_point = get_user_meta( $user_id, 'points_details', true );
    
    
		?>
    <p class="mwb_wpr_heading_para" >
		<span class="mwb_wpr_heading"><?php echo esc_html_e( 'Total points', 'points-and-rewards-for-woocommerce' ) . ': '; ?></span>
    <span class="mwb_wpr_heading" id="mwb_wpr_points_only">
			<?php       
        echo ( isset( $get_points ) && null != $get_points ) ? esc_html( $get_points ) : 0;               
			?>
		</span>
    </p>
    <h2><?php echo esc_html_e( 'Membership', 'points-and-rewards-for-woocommerce' ) . ':'; ?> VIP</h2>
    <p class="vip-des">
    <span class="mwb_wpr_heading">Tư cách thành viên VIP của bạn sẽ hết hạn vào ngày  <span><?php echo date('d', strtotime($membership_expiration) ).'/'. date('m', strtotime($membership_expiration)).'/'. date('Y', strtotime($membership_expiration)); ?></span> và điểm TORA sẽ bị mất. 
    Để tiếp tục hưởng các quyền lợi VIP, vui lòng chi tiêu 100.000.000 VND trước ngày <span><?php echo  date('d', strtotime($membership_expiration) ).'/'. date('m', strtotime($membership_expiration)).'/'. date('Y', strtotime($membership_expiration)); ?></span>.</span>
    </p>
    <p class="total-spend">
    	<span class="mwb_wpr_heading"><?php echo esc_html_e( 'Total spend ', 'points-and-rewards-for-woocommerce' ). ':'; ?></span> 
       <span class="mwb_wpr_heading" id="mwb_wpr_points_only">
        <?php        
          echo $total_price;      
        ?>
      </span>
    </p>
    <?php 
     } else {
      
    ?>
      <p class="mwb_wpr_heading_para">
    	<span class="mwb_wpr_heading"><?php echo esc_html_e( 'Total spend ', 'points-and-rewards-for-woocommerce' ). ':'; ?></span> 
       <span class="mwb_wpr_heading" id="mwb_wpr_points_only">
        <?php        
          echo $total_price;      
        ?>
      </span>
      </p>
      <p  class="vip-des">
      <span class="mwb_wpr_heading">
      <?php echo esc_html_e( 'To become a VIP member, spend a total of 100.000.000d (about US$4360) within a year from your first purchase, before', 'points-and-rewards-for-woocommerce' ); ?>
      <?php 
        if (isset($end_recurrence['current']) && ! empty($end_recurrence['current'])) {          
          echo mwb_wpr_set_the_wordpress_date_format_custom_one_year($end_recurrence['current']). '.';
        } else if (isset($normal_date['Date']) && !empty($normal_date['Date'])) {
          echo mwb_wpr_set_the_wordpress_date_format_custom_one_year($normal_date['Date']) . '.';
        } else {
          $today_date = date_i18n( 'Y-m-d', current_time( 'timestamp', 0 ) );
          echo mwb_wpr_set_the_wordpress_date_format_custom_one_year($today_date). '.';          
        }
      ?>
      </span>
      </p>
      
    <?php 
     }
    ?>
	</div>	
</div>		








<?php
if ( isset( $user_id ) && null != $user_id && is_numeric( $user_id ) && $my_role != '' ) {
	$point_log    = get_user_meta( $user_id, 'points_details', true );
	$total_points = get_user_meta( $user_id, 'mwb_wpr_points', true );
  
	if ( isset( $point_log ) && is_array( $point_log ) && null != $point_log ) {
		?>
		<h3><?php esc_html_e( ' Point Log Table', 'points-and-rewards-for-woocommerce' ); ?></h3>
		<?php if ( array_key_exists( 'registration', $point_log ) || array_key_exists( 'import_points', $point_log ) ) { ?>
			<div class="mwb_wpr_slide_toggle">
				<table class="mwb_wpr_common_table">
					<thead>
						<tr>
							<th class="mwb-wpr-view-log-Date">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Date', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
							<th class="mwb-wpr-view-log-Status">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Point Status', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
						</tr>
					</thead>
					<tr>
						<?php
						if ( array_key_exists( 'registration', $point_log ) ) {
							?>

							<p class="mwb_wpr_view_log_notice mwb_wpr_common_slider" ><?php esc_html_e( 'Signup Event', 'points-and-rewards-for-woocommerce' ); ?><a class ="mwb_wpr_open_toggle"  href="javascript:;"></a></p>
							<td>
								<?php
								echo esc_html( mwb_wpr_set_the_wordpress_date_format( $point_log['registration']['0']['date'] ) );
								?>
							</td>
							<td>
								<?php
								echo '+' . esc_html( $point_log['registration']['0']['registration'] );
								?>
							</td>
							<?php
						}
						?>
					</tr>
					<tr>
						<?php
						if ( array_key_exists( 'import_points', $point_log ) ) {
							?>

							<td><?php echo esc_html( mwb_wpr_set_the_wordpress_date_format( $point_log['import_points']['0']['date'] ) ); ?></td>
							<td><?php echo '+' . esc_html( $point_log['import_points']['0']['import_points'] ); ?></td>
							<?php
						}
						?>
					</tr>
				</table>
			</div> 
			<?php
		}
		if ( array_key_exists( 'Coupon_details', $point_log ) ) {
			?>
			<div class="mwb_wpr_slide_toggle">
				<p class="mwb_wpr_view_log_notice mwb_wpr_common_slider"><?php esc_html_e( 'Coupon Creation', 'points-and-rewards-for-woocommerce' ); ?><a class ="mwb_wpr_open_toggle"  href="javascript:;"></a></p>
				<table class="mwb_wpr_common_table">
					<thead>
						<tr>
							<th class="mwb-wpr-view-log-Date">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Date', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
							<th class="mwb-wpr-view-log-Status">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Point Status', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
						</tr>
					</thead>
					<?php
					foreach ( $point_log['Coupon_details'] as $key => $value ) {
						?>
						<tr>
							<td><?php echo esc_html( mwb_wpr_set_the_wordpress_date_format( $value['date'] ) ); ?></td>
							<td><?php echo '-' . esc_html( $value['Coupon_details'] ); ?></td>
						</tr>
						<?php
					}
					?>
				</table>
			</div>
			<?php
		}
		if ( array_key_exists( 'product_details', $point_log ) ) {
			?>
			<div class="mwb_wpr_slide_toggle">
				<p class="mwb_wpr_view_log_notice mwb_wpr_common_slider"><?php esc_html_e( 'Points Earned via Particular Product', 'points-and-rewards-for-woocommerce' ); ?> <a class ="mwb_wpr_open_toggle"  href="javascript:;"></a></p>

				<table class="mwb_wpr_common_table">
					<thead>
						<tr>
							<th class="mwb-wpr-view-log-Date">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Date', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
							<th class="mwb-wpr-view-log-Status">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Point Status', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
						</tr>
					</thead>
					<?php
					foreach ( $point_log['product_details'] as $key => $value ) {
						?>
						<tr>
							<td><?php echo esc_html( mwb_wpr_set_the_wordpress_date_format( $value['date'] ) ); ?></td>
							<td><?php echo '+' . esc_html( $value['product_details'] ); ?></td>
						</tr>
						<?php
					}
					?>
				</table>
			</div>
			<?php
		}
		if ( array_key_exists( 'pro_conversion_points', $point_log ) ) {     
      //Points_Rewards_For_WooCommerce_Admin::mwb_wpr_update_admin_points_order_total( $user_id, 'pro_conversion_points' );      
			?>
			<div class="mwb_wpr_slide_toggle">
				<p class="mwb_wpr_view_log_notice mwb_wpr_common_slider"><?php esc_html_e( 'Point earned', 'points-and-rewards-for-woocommerce' ); ?><a class ="mwb_wpr_open_toggle"  href="javascript:;"></a></p>
				<table class="mwb_wpr_common_table">
					<thead>
						<tr>
              <th class="mwb-wpr-view-log-Order-id">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Order Id', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
              <th class="mwb-wpr-view-log-Status">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Points', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
							<th class="mwb-wpr-view-log-Date">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Date', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>				
						</tr>
					</thead>
					<?php foreach ( $point_log['pro_conversion_points'] as $key => $value ) { 
         
            ?>
						<tr>
              <td>#<?php echo esc_html(  $value['order_id']  ); ?></td>
							<td><?php echo '+' . esc_html( $value['pro_conversion_points'] ); ?></td>
              <td><?php echo esc_html( mwb_wpr_set_the_wordpress_date_format_custom( $value['date'] ) ); ?></td>						
              
						</tr>
						<?php
					}
					?>
				</table>
			</div>
			<?php
		}
		if ( array_key_exists( 'points_on_order', $point_log ) ) {
      
			?>
			<div class="mwb_wpr_slide_toggle">
				<p class="mwb_wpr_view_log_notice mwb_wpr_common_slider"><?php esc_html_e( 'Points Log Table With Points Earned Each time on Order Total', 'points-and-rewards-for-woocommerce' ); ?><a class ="mwb_wpr_open_toggle"  href="javascript:;"></a></p>
				<table class="mwb_wpr_common_table">
					<thead>
						<tr>
							<th class="mwb-wpr-view-log-Date">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Date', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
							<th class="mwb-wpr-view-log-Status">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Point Earn', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
						</tr>
					</thead>
					<?php foreach ( $point_log['points_on_order'] as $key => $value ) {  ?>
						<tr>
							<td><?php echo esc_html( mwb_wpr_set_the_wordpress_date_format( $value['date'] ) ); ?></td>
							<td><?php echo '+' . esc_html( $value['points_on_order'] ); ?></td>
						</tr>
						<?php
					}
					?>
				</table>
			</div>
			<?php
		}
		if ( array_key_exists( 'refund_points_on_order', $point_log ) ) {
			?>
			<div class="mwb_wpr_slide_toggle">
				<p class="mwb_wpr_view_log_notice mwb_wpr_common_slider"><?php esc_html_e( 'Deducted Points earned on Order Total on Order Refund', 'points-and-rewards-for-woocommerce' ); ?><a class ="mwb_wpr_open_toggle"  href="javascript:;"></a></p>
				<table class="mwb_wpr_common_table">
					<thead>
						<tr>
							<th class="mwb-wpr-view-log-Date">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Date', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
							<th class="mwb-wpr-view-log-Status">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Point Status', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
						</tr>
					</thead>
					<?php foreach ( $point_log['refund_points_on_order'] as $key => $value ) {  ?>
						<tr>
							<td><?php echo esc_html( mwb_wpr_set_the_wordpress_date_format( $value['date'] ) ); ?></td>
							<td><?php echo '-' . esc_html( $value['refund_points_on_order'] ); ?></td>
						</tr>
						<?php
					}
					?>
				</table>
			</div>
			<?php
		}
		if ( array_key_exists( 'cancel_points_on_order_total', $point_log ) ) {
			?>
			<div class="mwb_wpr_slide_toggle">
				<p class="mwb_wpr_view_log_notice mwb_wpr_common_slider"><?php esc_html_e( 'Deducted Points earned on Order Total on Order Cancellation', 'points-and-rewards-for-woocommerce' ); ?><a class ="mwb_wpr_open_toggle"  href="javascript:;"></a></p>
				<table class="mwb_wpr_common_table">
					<thead>
						<tr>
							<th class="mwb-wpr-view-log-Date">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Date', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
							<th class="mwb-wpr-view-log-Status">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Point Status', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
						</tr>
					</thead>
					<?php foreach ( $point_log['cancel_points_on_order_total'] as $key => $value ) { ?>
						<tr>
							<td><?php echo esc_html( mwb_wpr_set_the_wordpress_date_format( $value['date'] ) ); ?></td>
							<td><?php echo '-' . esc_html( $value['cancel_points_on_order_total'] ); ?></td>
						</tr>
						<?php
					}
					?>
				</table>
			</div>
			<?php
		}
		if ( array_key_exists( 'comment', $point_log ) ) {
			?>
			<div class="mwb_wpr_slide_toggle">
				<p class="mwb_wpr_view_log_notice mwb_wpr_common_slider"><?php esc_html_e( 'Points earned via giving review/comment', 'points-and-rewards-for-woocommerce' ); ?><a class ="mwb_wpr_open_toggle"  href="javascript:;"></a></p>
				<a class ="mwb_wpr_open_toggle"  href="javascript:;"></a>
				<table class="mwb_wpr_common_table">
					<thead>
							<tr>
								<th class="mwb-wpr-view-log-Date">
									<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Date', 'points-and-rewards-for-woocommerce' ); ?></span>
								</th>
								<th class="mwb-wpr-view-log-Status">
									<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Point Status', 'points-and-rewards-for-woocommerce' ); ?></span>
								</th>
							</tr>
						</thead> 
					<?php
					foreach ( $point_log['comment'] as $key => $value ) {
						?>
						<tr>
							<td><?php echo esc_html( mwb_wpr_set_the_wordpress_date_format( $value['date'] ) ); ?></td>
							<td><?php echo '+' . esc_html( $value['comment'] ); ?></td>
						</tr>
						<?php
					}
					?>
				</table>
			</div>
			<?php
		}
	
		if ( array_key_exists( 'pur_by_points', $point_log ) ) {
			?>
			<div class="mwb_wpr_slide_toggle">
				<p class="mwb_wpr_view_log_notice mwb_wpr_common_slider"><?php esc_html_e( 'Deduction of points as you has purchased your product through points', 'points-and-rewards-for-woocommerce' ); ?><a class ="mwb_wpr_open_toggle"  href="javascript:;"></a></p>

				<table class="mwb_wpr_common_table">
					<thead>
						<tr>
							<th class="mwb-wpr-view-log-Date">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Date', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
							<th class="mwb-wpr-view-log-Status">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Point Status', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
						</tr>
					</thead>
					<?php
					foreach ( $point_log['pur_by_points'] as $key => $value ) {
           
						?>
						<tr>
							<td><?php echo esc_html( mwb_wpr_set_the_wordpress_date_format( $value['date'] ) ); ?></td>
							<td><?php echo '-' . esc_html( $value['pur_by_points'] ); ?></td>
						</tr>
						<?php
					}
					?>
				</table>
			</div>
			<?php
		}
		if ( array_key_exists( 'deduction_of_points', $point_log ) ) {
			?>
			<div class="mwb_wpr_slide_toggle">
				<p class="mwb_wpr_view_log_notice mwb_wpr_common_slider"><?php esc_html_e( 'Deduction of points for your return request', 'points-and-rewards-for-woocommerce' ); ?><a class ="mwb_wpr_open_toggle"  href="javascript:;"></a></p>

				<table class="mwb_wpr_common_table">
					<thead>
						<tr>
							<th class="mwb-wpr-view-log-Date">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Date', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
							<th class="mwb-wpr-view-log-Status">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Point Status', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
						</tr>
					</thead>
					<?php
					foreach ( $point_log['deduction_of_points'] as $key => $value ) {
						?>
						<tr>
							<td><?php echo esc_html( mwb_wpr_set_the_wordpress_date_format( $value['date'] ) ); ?></td>
							<td><?php echo '-' . esc_html( $value['deduction_of_points'] ); ?></td>
						</tr>
						<?php
					}
					?>
				</table> 
			</div>
			<?php
		}
		if ( array_key_exists( 'return_pur_points', $point_log ) ) {
			?>
			<div class="mwb_wpr_slide_toggle">
				<p class="mwb_wpr_view_log_notice mwb_wpr_common_slider"><?php esc_html_e( 'Points returned successfully on your return request', 'points-and-rewards-for-woocommerce' ); ?><a class ="mwb_wpr_open_toggle"  href="javascript:;"></a></p>

				<table class="mwb_wpr_common_table">
					<thead>
						<tr>
							<th class="mwb-wpr-view-log-Date">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Date', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
							<th class="mwb-wpr-view-log-Status">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Point Status', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
						</tr>
					</thead>
					<?php
					foreach ( $point_log['return_pur_points'] as $key => $value ) {
						?>
						<tr>
							<td><?php echo esc_html( mwb_wpr_set_the_wordpress_date_format( $value['date'] ) ); ?> </td>
							<td><?php echo '+' . esc_html( $value['return_pur_points'] ); ?></td>
						</tr>
						<?php
					}
					?>
				</table>
			</div>
			<?php
		}
		if ( array_key_exists( 'deduction_currency_spent', $point_log ) ) {
			?>
			<div class="mwb_wpr_slide_toggle">
				<p class="mwb_wpr_view_log_notice mwb_wpr_common_slider"><?php esc_html_e( 'Deduct Per Currency Spent Point on your return request', 'points-and-rewards-for-woocommerce' ); ?><a class ="mwb_wpr_open_toggle"  href="javascript:;"></a></p>

				<table class="mwb_wpr_common_table">
					<thead>
						<tr>
							<th class="mwb-wpr-view-log-Date">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Date', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
							<th class="mwb-wpr-view-log-Status">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Point Status', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
						</tr>
					</thead>
					<?php
					foreach ( $point_log['deduction_currency_spent'] as $key => $value ) {
						?>
						<tr>
							<td><?php echo esc_html( mwb_wpr_set_the_wordpress_date_format( $value['date'] ) ); ?></td>
							<td><?php echo '-' . esc_html( $value['deduction_currency_spent'] ); ?></td>
						</tr>
						<?php
					}
					?>
				</table>
			</div>
			<?php
		}
		if ( array_key_exists( 'cart_subtotal_point', $point_log ) ) {
			?>
			<div class="mwb_wpr_slide_toggle">
				<p class="mwb_wpr_view_log_notice mwb_wpr_common_slider"><?php esc_html_e( 'Points applied on cart', 'points-and-rewards-for-woocommerce' ); ?><a class ="mwb_wpr_open_toggle"  href="javascript:;"></a></p>

				<table class="mwb_wpr_common_table">
					<thead>
						<tr>
              <th class="mwb-wpr-view-log-Order-id">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Order Id', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
              <th class="mwb-wpr-view-log-Status">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Points', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
							<th class="mwb-wpr-view-log-Date">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Date', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
					
						</tr>
					</thead>
					<?php
					foreach ( $point_log['cart_subtotal_point'] as $key => $value ) {
           
						?>
						<tr>
              <td>#<?php esc_html_e( $value['order_id'] ); ?></td>
              <td><?php echo '-' . esc_html( $value['cart_subtotal_point'] ); ?></td>
							<td><?php echo esc_html( mwb_wpr_set_the_wordpress_date_format_custom( $value['date'] ) ); ?></td>							
						</tr>
						<?php
					}
					?>
				</table>
			</div>
			<?php
		}
		if ( array_key_exists( 'expired_details', $point_log ) ) {
			?>
			<div class="mwb_wpr_slide_toggle">
				<p class="mwb_wpr_view_log_notice mwb_wpr_common_slider"><?php esc_html_e( 'Oops!! Points are expired!', 'points-and-rewards-for-woocommerce' ); ?><a class ="mwb_wpr_open_toggle"  href="javascript:;"></a></p>

				<table class="mwb_wpr_common_table">
					<thead>
						<tr>
							<th class="mwb-wpr-view-log-Date">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Date', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
							<th class="mwb-wpr-view-log-Status">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Point Status', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
						</tr>
					</thead>
					<?php
					foreach ( $point_log['expired_details'] as $key => $value ) {
						?>
						<tr>
							<td><?php echo esc_html( mwb_wpr_set_the_wordpress_date_format( $value['date'] ) ); ?></td>
							<td><?php echo '-' . esc_html( $value['expired_details'] ); ?></td>
						</tr>
						<?php
					}
					?>
				</table>
			</div> 
			<?php
		}
		if ( array_key_exists( 'deduct_currency_pnt_cancel', $point_log ) ) {
			?>
			<div class="mwb_wpr_slide_toggle">
				<p class="mwb_wpr_view_log_notice mwb_wpr_common_slider"><?php esc_html_e( 'Order Points Deducted due to Cancelation of Order', 'points-and-rewards-for-woocommerce' ); ?><a class ="mwb_wpr_open_toggle"  href="javascript:;"></a></p>

				<table class="mwb_wpr_common_table">
					<thead>
						<tr>
							<th class="mwb-wpr-view-log-Date">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Date', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
							<th class="mwb-wpr-view-log-Status">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Point Status', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
						</tr>
					</thead>
					<?php
					foreach ( $point_log['deduct_currency_pnt_cancel'] as $key => $value ) {
						?>
						<tr>
							<td><?php echo esc_html( mwb_wpr_set_the_wordpress_date_format( $value['date'] ) ); ?></td>
							<td><?php echo '-' . esc_html( $value['deduct_currency_pnt_cancel'] ); ?></td>
						</tr>
						<?php
					}
					?>
				</table>
			</div> 
			<?php
		}
		if ( array_key_exists( 'deduct_bcz_cancel', $point_log ) ) {
			?>
			<div class="mwb_wpr_slide_toggle">
				<p class="mwb_wpr_view_log_notice mwb_wpr_common_slider"><?php esc_html_e( 'Assigned Points Deducted due Cancelation of Order', 'points-and-rewards-for-woocommerce' ); ?><a class ="mwb_wpr_open_toggle"  href="javascript:;"></a></p>

				<table class="mwb_wpr_common_table">
					<thead>
						<tr>
							<th class="mwb-wpr-view-log-Date">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Date', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
							<th class="mwb-wpr-view-log-Status">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Point Status', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
						</tr>
					</thead>
					<?php
					foreach ( $point_log['deduct_bcz_cancel'] as $key => $value ) {
						?>
						<tr>
							<td><?php echo esc_html( mwb_wpr_set_the_wordpress_date_format( $value['date'] ) ); ?></td>
							<td><?php echo '-' . esc_html( $value['deduct_bcz_cancel'] ); ?></td>
						</tr>
						<?php
					}
					?>
				</table>
			</div> 
			<?php
		}
		if ( array_key_exists( 'pur_points_cancel', $point_log ) ) {
			?>
			<div class="mwb_wpr_slide_toggle">
				<p class="mwb_wpr_view_log_notice mwb_wpr_common_slider"><?php esc_html_e( 'Points Returned due to Cancelation of Order', 'points-and-rewards-for-woocommerce' ); ?><a class ="mwb_wpr_open_toggle"  href="javascript:;"></a></p>

				<table class="mwb_wpr_common_table">
					<thead>
						<tr>
							<th class="mwb-wpr-view-log-Date">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Date', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
							<th class="mwb-wpr-view-log-Status">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Point Status', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
						</tr>
					</thead>
					<?php
					foreach ( $point_log['pur_points_cancel'] as $key => $value ) {
						?>
						<tr>
							<td><?php echo esc_html( mwb_wpr_set_the_wordpress_date_format( $value['date'] ) ); ?></td>
							<td><?php echo '+' . esc_html( $value['pur_points_cancel'] ); ?></td>
						</tr>
						<?php
					}
					?>
				</table>
			</div> 
			<?php
		}
		// MWB CUSTOM CODE.
		if ( array_key_exists( 'pur_pro_pnt_only', $point_log ) ) {
			?>
			<div class="mwb_wpr_slide_toggle">
				<p class="mwb_wpr_view_log_notice mwb_wpr_common_slider"><?php esc_html_e( 'Points deducted for purchasing the product', 'points-and-rewards-for-woocommerce' ); ?><a class ="mwb_wpr_open_toggle"  href="javascript:;"></a></p>

				<table class="mwb_wpr_common_table">
					<thead>
						<tr>
							<th class="mwb-wpr-view-log-Date">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Date', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
							<th class="mwb-wpr-view-log-Status">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Point Status', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
						</tr>
					</thead>
					<?php
					foreach ( $point_log['pur_pro_pnt_only'] as $key => $value ) {
						?>
						<tr>
							<td><?php echo esc_html( mwb_wpr_set_the_wordpress_date_format( $value['date'] ) ); ?></td>
							<td><?php echo '-' . esc_html( $value['pur_pro_pnt_only'] ); ?></td>
						</tr>
						<?php
					}
					?>
				</table>
			</div> 
			<?php
		}
		// END OF MWB CUSTOM CODE.
		if ( array_key_exists( 'Sender_point_details', $point_log ) ) {
			?>
			<div class="mwb_wpr_slide_toggle">
				<p class="mwb_wpr_view_log_notice mwb_wpr_common_slider"><?php esc_html_e( 'Points deducted successfully as you have shared your points', 'points-and-rewards-for-woocommerce' ); ?><a class ="mwb_wpr_open_toggle"  href="javascript:;"></a></p>

				<table class="mwb_wpr_common_table">
					<thead>
						<tr>
							<th class="mwb-wpr-view-log-Date">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Date', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
							<th class="mwb-wpr-view-log-Status">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Point Status', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
							<th class="mwb-wpr-view-log-Activity">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Shared to', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
						</tr>
					</thead>
					<?php
					foreach ( $point_log['Sender_point_details'] as $key => $value ) {
						$user_name = '';
						if ( isset( $value['given_to'] ) && ! empty( $value['given_to'] ) ) {
							$user      = get_user_by( 'ID', $value['given_to'] );
							if ( isset( $user ) && ! empty( $user ) ) {
								$user_name = $user->user_nicename;
							} else {
								$user_name = esc_html__( 'This user doesn\'t exists', 'points-and-rewards-for-woocommerce' );
							}
						}
						?>
						<tr>
							<td><?php echo esc_html( mwb_wpr_set_the_wordpress_date_format( $value['date'] ) ); ?> </td>
							<td><?php echo '-' . esc_html( $value['Sender_point_details'] ); ?></td>
							<td>
								<?php
								echo esc_html( $user_name );
								?>
							</td>
						</tr>
						<?php
					}
					?>
				</table>
			</div>   
			<?php
		}
		if ( array_key_exists( 'Receiver_point_details', $point_log ) ) {
			?>
			<div class="mwb_wpr_slide_toggle">
				<p class="mwb_wpr_view_log_notice mwb_wpr_common_slider"><?php esc_html_e( 'Points received successfully as someone has shared', 'points-and-rewards-for-woocommerce' ); ?><a class ="mwb_wpr_open_toggle"  href="javascript:;"></a></p>

				<table class="mwb_wpr_common_table">
					<thead>
						<tr>
							<th class="mwb-wpr-view-log-Date">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Date', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
							<th class="mwb-wpr-view-log-Status">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Point Status', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
							<th class="mwb-wpr-view-log-Activity">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Received Points via ', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
						</tr>
					</thead>
					<?php
					foreach ( $point_log['Receiver_point_details'] as $key => $value ) {
						$user_name = '';
						if ( isset( $value['received_by'] ) && ! empty( $value['received_by'] ) ) {
							$user      = get_user_by( 'ID', $value['received_by'] );
							if ( isset( $user ) && ! empty( $user ) ) {
								$user_name = $user->user_nicename;
							} else {
								$user_name = esc_html__( 'This user doesn\'t exists', 'points-and-rewards-for-woocommerce' );
							}
						}
						?>
						<tr>
							<td><?php echo esc_html( mwb_wpr_set_the_wordpress_date_format( $value['date'] ) ); ?></td>
							<td><?php echo '+' . esc_html( $value['Receiver_point_details'] ); ?></td>
							<td>
								<?php
								echo esc_html( $user_name );
								?>
							</td>
						</tr>
						<?php
					}
					?>
				</table>
			</div>
			<?php
		}
		if ( array_key_exists( 'admin_points', $point_log ) ) {      
      if (isset($user_id) && ! empty($user_id)){        
        //Points_Rewards_For_WooCommerce_Admin::mwb_wpr_update_admin_points_detail( $user_id, 'admin_points' );        
      }      
     
			?>
			<div class="mwb_wpr_slide_toggle">
				<p class="mwb_wpr_view_log_notice mwb_wpr_common_slider"><?php esc_html_e( 'Updated by admin', 'points-and-rewards-for-woocommerce' ); ?><a class ="mwb_wpr_open_toggle"  href="javascript:;"></a></p>
				<table class="mwb_wpr_common_table">
					<thead>
						<tr>
              <th class="mwb-wpr-view-log-Activity">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Remarks', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
              <th class="mwb-wpr-view-log-Status">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Points', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>	
							<th class="mwb-wpr-view-log-Date">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Date', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
           		
						</tr>
					</thead>
					<?php
					foreach ( $point_log['admin_points'] as $key => $value ) {
						$value['sign']   = isset( $value['sign'] ) ? $value['sign'] : '+/-';
						$value['reason'] = isset( $value['reason'] ) ? $value['reason'] : __( 'Updated By Admin', 'points-and-rewards-for-woocommerce' );
						?>
						<tr>
              <td><?php echo esc_html( $value['reason'] ); ?></td>
              <td><?php echo esc_html( $value['sign'] ) . esc_html( $value['admin_points'] ); ?></td>
							<td><?php echo esc_html( mwb_wpr_set_the_wordpress_date_format_custom( $value['date'] ) ); ?></td>												
						</tr>
						<?php				
          }      
					?>
				</table>
			</div>
			<?php
		}
		if ( array_key_exists( 'reference_details', $point_log ) ) {
			?>
			<div class="mwb_wpr_slide_toggle">
				<p class="mwb_wpr_view_log_notice mwb_wpr_common_slider"><?php esc_html_e( ' Check Number of Points Earned by Referring Others ', 'points-and-rewards-for-woocommerce' ); ?><a class ="mwb_wpr_open_toggle"  href="javascript:;"></a></p>
				<table class="mwb_wpr_common_table">
					<thead>
						<tr>
							<th class="mwb-wpr-view-log-Date">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Date', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
							<th class="mwb-wpr-view-log-Status">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Point Status', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
							<th class="mwb-wpr-view-log-Activity">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Sign Up by', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
						</tr>
					</thead>
					<?php
					foreach ( $point_log['reference_details'] as $key => $value ) {
						$user_name = '';
						if ( isset( $value['refered_user'] ) && ! empty( $value['refered_user'] ) ) {
							$user      = get_user_by( 'ID', $value['refered_user'] );
							if ( isset( $user ) && ! empty( $user ) ) {
								$user_name = $user->user_login;
							} else {
								$user_name = esc_html__( 'This user doesn\'t exists', 'points-and-rewards-for-woocommerce' );
							}
						}
						?>
						<tr>
							<td><?php echo esc_html( mwb_wpr_set_the_wordpress_date_format( $value['date'] ) ); ?></td>
							<td><?php echo '+' . esc_html( $value['reference_details'] ); ?></td>
							<td>
								<?php
								if ( isset( $user ) && ! empty( $user ) ) {
									echo esc_html( $user_name );
								} else {
									echo esc_html( $user_name );
								}
								?>
							</td>
						</tr>
						<?php
					}
					?>
				</table> 
			</div>
			<?php
		}
		if ( array_key_exists( 'ref_product_detail', $point_log ) ) {
			?>
			<div class="mwb_wpr_slide_toggle">
				<p class="mwb_wpr_view_log_notice mwb_wpr_common_slider"><?php esc_html_e( 'Points earned by the purchase has been made by referrals', 'points-and-rewards-for-woocommerce' ); ?><a class ="mwb_wpr_open_toggle"  href="javascript:;"></a></p>
				<table class="mwb_wpr_common_table">
					<thead>
						<tr>
							<th class="mwb-wpr-view-log-Date">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Date', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
							<th class="mwb-wpr-view-log-Status">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Point Status', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
							<th class="mwb-wpr-view-log-Activity">
								<span class="mwb_wpr_nobr"><?php echo esc_html__( 'Product purchase by Referred User Points', 'points-and-rewards-for-woocommerce' ); ?></span>
							</th>
						</tr>
					</thead>
					<?php
					foreach ( $point_log['ref_product_detail'] as $key => $value ) {
						$user_name = '';
						if ( isset( $value['refered_user'] ) && ! empty( $value['refered_user'] ) ) {
							$user      = get_user_by( 'ID', $value['refered_user'] );
							if ( isset( $user ) && ! empty( $user ) ) {
								$user_name = $user->user_nicename;
							} else {
								$user_name = esc_html__( 'This user doesn\'t exists', 'points-and-rewards-for-woocommerce' );
							}
						}
						?>
						<tr>
							<td><?php echo esc_html( mwb_wpr_set_the_wordpress_date_format( $value['date'] ) ); ?></td>
							<td><?php echo '+' . esc_html( $value['ref_product_detail'] ); ?></td>
							<td>
								<?php
								echo esc_html( $user_name );
								?>
							</td>
						</tr>
						<?php
					}
					?>

				</table>
			</div> 
			
			<?php

		}
		do_action( 'mwb_points_on_first_order', $point_log );

		?>
		<div class="mwb_wpr_slide_toggle">
			<table class="mwb_wpr_total_points">
				<tr>
					<td><h4><?php esc_html_e( 'Total Points', 'points-and-rewards-for-woocommerce' ); ?></h4></td>
					<td><h4><?php echo esc_html( $total_points ); ?></h4></td>
					<td></td>
				</tr>        
			</table>
</div>
		<?php
	} else {
		echo '<h3>' . esc_html__( 'No Points Generated Yet. ', 'points-and-rewards-for-woocommerce' ) . '<h3>';
	}
}
?>
















<?php	
//do_action( 'mwb_wpr_add_coupon_generation', $user_id );
?>

<?php
//do_action( 'mwb_wpr_list_coupons_generation', $user_id );

/*Start of the Referral Section*/
if ( $enable_mwb_refer ) {
	$public_obj = new Points_Rewards_For_WooCommerce_Public( 'points-and-rewards-for-woocommerce', '1.0.0' );
	$public_obj->mwb_wpr_get_referral_section( $user_id );
}
/* of the Referral Section*/
do_action( 'mwb_wpr_add_share_points', $user_id );
$mwb_wpr_user_can_send_point = get_option( 'mwb_wpr_user_can_send_point', 0 );
