<?php
/**
 * Points and rewards email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/mwb-wpr-email-notification-template.php.
 *
 * @package    points-and-rewards-for-wooCommerce
 * @author  makewebbetter<ticket@makewebbetter.com>
 * @since      1.0.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
* This hooks use for emaail header
 *
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php

$template = '   
		<tr>
			<td>
				<table  border="0" width="100%" cellspacing="0" cellpadding="0">
					<tbody>
						<tr>
							<td>
								<div style="text-align: left; color: #fff; font-family: Helvetica, Roboto, Arial, sans-serif;"><span style="display: inline-block;padding: 5px 15px; margin-bottom: 10px;">' . esc_html( $email_content ) . '</span></div>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>';

echo wp_kses_post( html_entity_decode( $template ) ); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped

/**
* This hooks use for emaail footer
 *
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
