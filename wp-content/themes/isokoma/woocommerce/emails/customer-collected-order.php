<?php
/**
 * Customer collected order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-completed-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
do_action( 'woocommerce_email_header', $email_heading, $email );
  if ($language == 'vi') {
?>
<tr><td>
  <table class="td" cellspacing="0" cellpadding="0" style="width: 100%; color: #ffffff; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" border="0">
    <tr>
      <td align="left" style="font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">  
        <?php printf( esc_html__( 'Chào %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ?>        
      </td>
    </tr>
    <tr><td height="30"></td></tr>
    <tr>
      <td align="left" style="font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">              
        Cảm ơn bạn đã nhận đơn hàng số <?php echo $order->id; ?>. Hy vọng bạn cảm thấy hài lòng với dịch vụ của chúng tôi.
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
    <tr>
      <td align="left" style="font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">  
      Hi  <?php printf( esc_html( $order->get_billing_first_name() ) ); ?>        
      </td>
    </tr>
    <tr><td height="30"></td></tr>
    <tr>
      <td align="left" style="font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">     
        Thank you for collecting the order <?php echo $order->id; ?>. Hope you are satisfied with <br/>our service.
      </td>
    </tr>
   
    <tr><td height="30"></td></tr>
    <tr><td style="font-size:16px; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">Thank you for shopping with us.</td></tr>    
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
