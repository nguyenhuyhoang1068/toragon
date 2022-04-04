<?php
/**
 * Customer shipped order email
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
      <td>
        <?php printf( esc_html__( 'Chào %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ?>        
      </td>
    </tr>
    <tr><td height="15"></td></tr>
    <tr>
      <td>        
        Đơn hàng của bạn đã được vận chuyển. Chúng tôi sẽ thông báo cho bạn khi bạn nhận được hàng. Thông tin đơn hàng của bạn như sau:               
      </td>
    </tr>
    <tr><td height="30"></td></tr>
    <?php 
      /*
      * @hooked WC_Emails::order_details() Shows the order details table.
      * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
      * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
      * @since 2.5.0
      */
      do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

      /*
      * @hooked WC_Emails::order_meta() Shows order meta data.
      */
      do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

      /*
      * @hooked WC_Emails::customer_details() Shows customer details
      * @hooked WC_Emails::email_address() Shows email address
      */
      do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );
    ?>

    <tr><td height="30"></td></tr>
    <tr><td>Cảm ơn bạn đã mua sắm cùng chúng tôi.</td></tr>    
    <tr><td height="15"></td></tr>
    <tr><td> Trân trọng,</td></tr>
    <tr><td>Toragon HE</td></tr>
  </table>
</td></tr>
<?php } ?>
<?php if ($language == 'en_US') { ?>
<tr><td>
  <table class="td" cellspacing="0" cellpadding="0" style="width: 100%; color: #ffffff; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" border="0">
    <tr>
      <td>
        <?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ?>        
      </td>
    </tr>
    <tr><td height="15"></td></tr>
    <tr>
      <td>        
        Your order has been shipped. We will notify you when you receive it. Here is your order summary:        
      </td>
    </tr>

    <tr><td height="30"></td></tr>
    <?php 
      /*
      * @hooked WC_Emails::order_details() Shows the order details table.
      * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
      * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
      * @since 2.5.0
      */
      do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

      /*
      * @hooked WC_Emails::order_meta() Shows order meta data.
      */
      do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

      /*
      * @hooked WC_Emails::customer_details() Shows customer details
      * @hooked WC_Emails::email_address() Shows email address
      */
      do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );
    ?>
    <tr><td height="30"></td></tr>
    <tr><td>Thank you for shopping with us.</td></tr>    
    <tr><td height="15"></td></tr>
    <tr><td>Regards,</td></tr>
    <tr><td>Toragon HE</td></tr>
  </table>
</td></tr>
<?php } ?>
<?php 
/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
