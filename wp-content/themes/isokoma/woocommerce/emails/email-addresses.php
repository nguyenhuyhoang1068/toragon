<?php
/**
 * Email Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-addresses.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$text_align = is_rtl() ? 'right' : 'left';
$address    = $order->get_formatted_billing_address();
$shipping   = $order->get_formatted_shipping_address();
$language = get_post_meta( $order->id, 'tor_order_translate', true);
?> 
<tr><td height="20"></td></tr>
<?php if ($language == 'vi') { ?>
<tr>
  <td>
    <table cellspacing="0" cellpadding="0" style="width: 100%; vertical-align: top; padding:0;" border="0">
      <tr>
        <td style="text-align:left; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; border:0; padding:0px;" valign="top" width="50%">
          <h2 style="font-size:16px; color: #fbcf1f !important;">Địa chỉ thanh toán</h2>
          <address class="address" style="color: #ffffff !important;">     
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
            <address class="address" style="color: #ffffff !important;"><?php echo wp_kses_post( $shipping ); ?></address>
          </td>
        <?php endif; ?>
      </tr>
    </table>
  </td>
</tr>
<?php } ?>
<?php if ($language == 'en_US') { ?>
  <tr>
  <td>
    <table cellspacing="0" cellpadding="0" style="width: 100%; vertical-align: top; padding:0;" border="0">
      <tr>
        <td style="text-align:left; color: #ffffff !important; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; border:0; padding:0px;" valign="top" width="50%">
          <h2 style="font-size:16px; color: #fbcf1f !important;">Billing address</h2>
          <address class="address" style="color: #ffffff !important;">     
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
            <h2 style="font-size:16px; color: #fbcf1f !important;">Shipping address</h2>
            <address class="address" style="color: #ffffff !important;"><?php echo wp_kses_post( $shipping ); ?></address>
          </td>
        <?php endif; ?>
      </tr>
    </table>
  </td>
</tr>
<?php } ?>