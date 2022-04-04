<?php
/**
 * WooCommerce Pre-Orders
 *
 * @package     WC_Pre_Orders/Templates/Email
 * @author      WooThemes
 * @copyright   Copyright (c) 2013, WooThemes
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

/**
 * Customer pre-ordered order email
 *
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

$language = get_post_meta( $order->id, 'tor_order_translate', true);
$payment_method = get_post_meta( $order->id, '_payment_method', true );
?>


<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
		<title><?php echo get_bloginfo( 'name', 'display' ); ?></title>
	</head>
	<body  marginwidth="0" topmargin="0" marginheight="0" offset="0">
  <center>
    <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="mFullWidth" bgcolor="black">
      <tr>  
        <td width="35"></td>                     
        <td>    
          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="mFullWidth">
            <tr>              
              <td height="30"></td>
            </tr>  
            <tr>                  
            <td align="center" valign="top" style="font-size:25px; line-height:25px;  font-weight: 300; text-align:center; font-family:arial, sans-serif; color:#fbcf1f;">
              <?php echo $email_heading; ?> 
            </td>
            </tr>  
            <tr>              
              <td height="30"></td>
            </tr> 
          </table>
        </td>   
        <td width="35"></td>                 
      </tr>  
      <tr>
        <td width="35" style="background-color:#1a1918;  height: 100%;"></td>
        <td style="background-color:#1a1918; height: 100%;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="mFullWidth" bgcolor="#1a1918" style="background-color: #1a1918;">
          <tr><td height="30"></td></tr>

<?php if ($language == 'vi') { ?>
<tr><td>
  <table class="td" cellspacing="0" cellpadding="0" style="width: 100%; color: #ffffff; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" border="0">
    <?php do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>    
    <tr>
      <td style="font-size:16px; color: #fbcf1f !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">
          <?php
          if ( $sent_to_admin ) {
            $before = '<a class="link" href="' . esc_url( $order->get_edit_order_url() ) . '">';
            $after  = '</a>';
          } else {
            $before = '';
            $after  = '';
          }                
          echo wp_kses_post( $before . sprintf( __( '[Đơn hàng #%s]', 'woocommerce' ) . $after . ' (<time datetime="%s">%s</time>)', $order->get_order_number(), $order->get_date_created()->format( 'c' ), wc_format_datetime( $order->get_date_created() ) ) );
          ?>        
      </td>
    </tr>
    <tr><td height="30"></td></tr>
    <tr>
      <td style="font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;"> 
        <?php printf( esc_html__( 'Chào %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ?>        
      </td>
    </tr>
    <tr><td height="30"></td></tr>
    <tr>
      <td style="font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">     
        Đơn đặt hàng của bạn đã được xác nhận. Chúng tôi sẽ cập nhật khi đơn hàng đã đến kho và sẵn sàng để giao đến bạn. Đơn hàng sẽ được thanh toán tự động thông qua phương thức thanh toán bạn đã chọn. Thông tin đơn hàng của bạn như sau:
      </td>
    </tr>
    <tr><td height="30"></td></tr>   
    
   
    <tr>
      <td>
      <table class="td" cellspacing="0" cellpadding="0" style="width: 100%; color: #ffffff; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" border="0">
        <thead>
          <tr> 
            <th style="text-align:left; width: 38%; font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" vertical-align: middle; scope="col" ><?php esc_html_e( 'Sản phẩm', 'woocommerce' ); ?></th>
            <th style="text-align:left; width: 12%; font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" vertical-align: middle; scope="col" ><?php esc_html_e( 'Số lượng', 'woocommerce' ); ?>&nbsp;&nbsp;&nbsp;</th>            
            <th style="text-align:left; width: 50%; font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" vertical-align: middle; scope="col" ><?php esc_html_e( 'Giá', 'woocommerce' ); ?></th>
          </tr>
        </thead>
        <tbody>
        <tr><td colspan="3" height="10"></td></tr>
        <tr><td  colspan="3" ><hr style="width:100%; border-bottom: 1px solid #ffffff;" /></td></tr>
        <tr><td colspan="3" height="10"></td></tr>
          <?php
          echo wc_get_email_order_items( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            $order,
            array(
              'show_sku'      => $sent_to_admin,
              'show_image'    => false,
              'image_size'    => array( 32, 32 ),
              'plain_text'    => $plain_text,
              'sent_to_admin' => $sent_to_admin,
            )
          );
          ?>
        </tbody>        
        <tr><td colspan="3" height="10"></td></tr>   
        <tr><td colspan="3" ><hr style="width:100%; border-bottom: 1px solid #ffffff;" /></td></tr>             
          <?php
          $item_totals = $order->get_order_item_totals();

          if ( $item_totals ) {
            $numItems = count($item_totals);
            $i = 0;
            foreach ( $item_totals as $total ) {
              $i++;
              ?>
                <?php
              if($i === $numItems) { 
              ?>
              <tr><td  colspan="3" ><hr style="width:100%;" /></td></tr>  
              <?php
                }
              ?>              
              <tr><td colspan="3" height="10"></td></tr>
              <tr>
                <th  class="td" scope="row" colspan="2" style="line-height:26px; text-align:left; font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;  border: 0px !important;"><?php echo wp_kses_post(total_label_switch_vi_vn($total['label']) ); ?></th>
                <td  class="td" style="line-height:26px;  text-align:left; width: 30%; font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; border: 0px !important;"><?php echo wp_kses_post( $total['value'] ); ?></td>
              </tr>
              <tr><td colspan="3" height="10"></td></tr>  
          <?php
            }
          }
          if ( $order->get_customer_note() ) {
            ?>
            <tr><td colspan="3" height="10"></td></tr>
            <tr>
              <th class="td" valign="top" scope="row" colspan="2" style="line-height:26px;text-align: left; font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;"><?php esc_html_e( 'Ghi chú:', 'woocommerce' ); ?></th>
              <td class="td" style="line-height:26px; text-align: left; width: 30%; font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;"><?php echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></td>
            </tr>
            <tr><td colspan="3" height="10"></td></tr>
            <?php
          }
          ?>
      </table>
      </td>
    </tr>

    <?php do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>
    <tr><td height="20"></td></tr>
    <?php $address    = $order->get_formatted_billing_address();
          $shipping   = $order->get_formatted_shipping_address();  ?>
    <tr>
      <td>
        <table cellspacing="0" cellpadding="0" style="width: 100%; vertical-align: top; padding:0;" border="0">
          <tr>
            <td style="text-align:left; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; border:0; padding:0px;" valign="top" width="50%">
              <h2 style="font-size:16px; color: #fbcf1f !important;">Địa chỉ thanh toán</h2>
              <address class="address" style="font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">     
                <?php echo wp_kses_post( $address ? $address : esc_html__( 'N/A', 'woocommerce' ) ); ?>
                <?php if ( $order->get_billing_phone() ) : ?>
                  <br/> <?php echo wc_make_phone_clickable( $order->get_billing_phone() ); ?>
                <?php endif; ?>
                <?php if ( $order->get_billing_email() ) : ?>
                  <br/><a href="mailto:<?php echo esc_html( $order->get_billing_email() ); ?>"><?php echo esc_html( $order->get_billing_email() ); ?></a>
                <?php endif; ?>
              </address>
            </td>
            <?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() && $shipping ) : ?>
              <td style="text-align:left; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; padding:0px;" valign="top" width="50%">
                <h2 style="font-size:16px; color: #fbcf1f !important;">Địa chỉ giao hàng</h2>
                <address class="address" style="font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;"><?php echo wp_kses_post( $shipping ); ?></address>
              </td>
            <?php endif; ?>
          </tr>
        </table>
      </td>
    </tr>


    <tr><td height="30"></td></tr>
    <tr><td style="font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">Cảm ơn bạn đã mua sắm cùng chúng tôi.</td></tr>    
    <tr><td height="20"></td></tr>
    <tr><td style="font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">Trân trọng,</td></tr>
    <tr><td style="font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">Toragon HE</td></tr>
  </table>
</td></tr>
<?php } ?>
<?php if ($language == 'en_US') { ?>
<tr><td>
  <table class="td" cellspacing="0" cellpadding="0" style="width: 100%; color: #ffffff; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" border="0">
    <?php    do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>  
    <tr>
      <td style="font-size:16px; color: #fbcf1f !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">
          <?php
          if ( $sent_to_admin ) {
            $before = '<a class="link" href="' . esc_url( $order->get_edit_order_url() ) . '">';
            $after  = '</a>';
          } else {
            $before = '';
            $after  = '';
          }                
          echo wp_kses_post( $before . sprintf( __( '[Order #%s]', 'woocommerce' ) . $after . ' (<time datetime="%s">%s</time>)', $order->get_order_number(), $order->get_date_created()->format( 'c' ), wc_format_datetime( $order->get_date_created() ) ) );
          ?>        
      </td>
    </tr>
    <tr><td height="30"></td></tr>
    <tr>
      <td style="font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">
        Hi <?php printf(  esc_html( $order->get_billing_first_name() ) ); ?>        
      </td>
    </tr>
    <tr><td height="30"></td></tr>
    <tr>
      <td style="font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">    
        Your preorder has been received. We will update you when it is available and ready to be processed. You will be automatically charged for your order via your selected payment method. Here is your order summary:        
      </td>
    </tr>

    <tr><td height="30"></td></tr>
  
  

   
    <tr>
  <td>
  <table cellspacing="0" cellpadding="0" style="width: 100%; color: #ffffff; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; border-collapse: collapse;" border="0">
    <thead>
      <tr> 
        <th style="text-align:left; width: 38%; font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; font-weight: 300;" vertical-align: middle; scope="col" >Product</th>
        <th style="text-align:left; width: 12%; font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; font-weight: 300;" vertical-align: middle; scope="col" >Quantity&nbsp;&nbsp;&nbsp;</th>        
        <th style="text-align:left; width: 50%; font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; font-weight: 300;" vertical-align: middle; scope="col" >Price</th>
      </tr>
    </thead>
    <tbody>
    <tr><td colspan="3" height="10"></td></tr>
    <tr><td  colspan="3" ><hr style="width:100%; border-bottom: 1px solid #ffffff;" /></td></tr>
    <tr><td colspan="3" height="10"></td></tr>
      <?php
      echo wc_get_email_order_items( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        $order,
        array(
          'show_sku'      => $sent_to_admin,
          'show_image'    => false,
          'image_size'    => array( 32, 32 ),
          'plain_text'    => $plain_text,
          'sent_to_admin' => $sent_to_admin,
        )
      );
      ?>
    </tbody>    
    <tr><td colspan="3" height="10"></td></tr>
    <tr><td colspan="3" ><hr style="width:100%; border-bottom: 1px solid #ffffff;" /></td></tr>
    
    <tfoot>
      <?php
      $item_totals = $order->get_order_item_totals();

      if ( $item_totals ) {
        $numItems = count($item_totals);
        $i = 0;
        foreach ( $item_totals as $total ) {
          $i++;
          ?>
            <?php
          if($i === $numItems) { 
          ?>
          <tr><td  colspan="3" ><hr style="width:100%; " /></td></tr>  
          <?php
            }
          ?>
          <tr><td colspan="3" height="10"></td></tr>
          <tr>
            <th  class="td" scope="row" colspan="2" style="line-height:26px; text-align:left; font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; border: 0px !important;"><?php echo wp_kses_post( total_label_switch_en_us($total['label']) ); ?></th>
            <td  class="td" style="line-height:26px; text-align:left; width: 30%; font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; border: 0px !important;"><?php echo wp_kses_post( $total['value'] ); ?></td>
          </tr>
          <tr><td colspan="3" height="10"></td></tr>          
        
      <?php
        }
      }
      if ( $order->get_customer_note() ) {
        ?>
        <tr><td colspan="3" height="10"></td></tr>
        <tr>
          <th  valign="top" scope="row" colspan="2" style="line-height:25px;text-align: left; font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;"><?php esc_html_e( 'Note:', 'woocommerce' ); ?></th>
          <td class="td" style="line-height:25px;text-align: left; width: 30%; font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;"><?php echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></td>
        </tr>
        <tr><td colspan="3" height="10"></td></tr>
        <?php
      }
      ?>
    </tfoot>

  </table>
  </td>
</tr>
    

<?php do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>


  <?php
    $address    = $order->get_formatted_billing_address();
    $shipping   = $order->get_formatted_shipping_address();
    ?>
    <tr><td height="20"></td></tr>
    <tr>
      <td>
        <table cellspacing="0" cellpadding="0" style="width: 100%; vertical-align: top; padding:0;" border="0">
          <tr>
            <td style="text-align:left; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; border:0; padding:0px;" valign="top" width="51%">
              <h2 style="font-size:16px; color: #fbcf1f !important;">Billing address</h2>
              <address class="address" style="font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">     
                <?php echo wp_kses_post( $address ? $address : esc_html__( 'N/A', 'woocommerce' ) ); ?>
                <?php if ( $order->get_billing_phone() ) : ?>
                  <br/> <?php echo wc_make_phone_clickable( $order->get_billing_phone() ); ?>
                <?php endif; ?>
                <?php if ( $order->get_billing_email() ) : ?>
                  <br/><a href="mailto:<?php echo esc_html( $order->get_billing_email() ); ?>"><?php echo esc_html( $order->get_billing_email() ); ?></a>
                <?php endif; ?>
              </address>
            </td>
            <?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() && $shipping ) : ?>
              <td style="text-align:left; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; padding:0px;" valign="top" width="49%">
                <h2 style="font-size:16px; color: #fbcf1f !important;">Shipping address</h2>
                <address class="address" style="font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;"><?php echo wp_kses_post( $shipping ); ?></address>
              </td>
            <?php endif; ?>
          </tr>
        </table>
      </td>
    </tr>



    <tr><td height="30"></td></tr>
    <tr><td style="font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">Thank you for choosing Toragon HE.</td></tr>    
    <tr><td height="20"></td></tr>
    <tr><td style="font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">Regards,</td></tr>
    <tr><td style="font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">Toragon HE</td></tr>
  </table>
</td></tr>
<?php } ?>
<?php 
/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );








