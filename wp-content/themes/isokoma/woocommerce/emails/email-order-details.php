<?php
/**
 * Order details table shown in emails.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-details.php.
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

defined( 'ABSPATH' ) || exit;



do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>
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
<tr><td height="15"></td></tr>
<tr>
  <td>
  <table class="td" cellspacing="0" cellpadding="0" style="width: 100%; color: #ffffff; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" border="0">
    <thead>
      <tr> 
        <th style="text-align:left; width: 38%;" vertical-align: middle; scope="col" ><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
        <th style="text-align:left; width: 12%;" vertical-align: middle; scope="col" ><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
        <th style="text-align:left; width: 50%;" vertical-align: middle; scope="col" ><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
      </tr>
    </thead>
    <tbody>
    <tr><td colspan="3" height="15"></td></tr>
    <tr><td  colspan="3" ><hr style="width:100%; border-bottom: 1px solid #ffffff;" /></td></tr>
    <tr><td colspan="3" height="15"></td></tr>
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
    <tr><td colspan="3" height="15"></td></tr>
    <tr><td colspan="3" ><hr style="width:100%; border-bottom: 1px solid #ffffff;" /></td></tr>
    <tr><td colspan="3" height="5"></td></tr>
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
          <tr><td colspan="3" height="15"></td></tr>
          <tr>
            <th  class="td" scope="row" colspan="2" style="text-align:left; <?php echo ( 1 === $i ) ? 'border-top-width: 4px;' : ''; ?>"><?php echo wp_kses_post( $total['label'] ); ?></th>
            <td  class="td" style="text-align:left; width: 30%; <?php echo ( 1 === $i ) ? 'border-top-width: 4px;' : ''; ?>"><?php echo wp_kses_post( $total['value'] ); ?></td>
          </tr>
          <tr><td colspan="3" height="15"></td></tr>          
        
      <?php
        }
      }
      if ( $order->get_customer_note() ) {
        ?>
        <tr><td colspan="3" height="15"></td></tr>
        <tr>
          <th class="td" scope="row" colspan="2" style="text-align: left;"><?php esc_html_e( 'Note:', 'woocommerce' ); ?></th>
          <td class="td" style="text-align: left; width: 30%;"><?php echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></td>
        </tr>
        <tr><td colspan="3" height="15"></td></tr>
        <?php
      }
      ?>
    </tfoot>

  </table>
  </td>
</tr>

<?php do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>
