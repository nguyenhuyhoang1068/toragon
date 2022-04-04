<?php
/**
 * Customer Reset Password email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-reset-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 4.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
		<title><?php echo get_bloginfo( 'name', 'display' ); ?></title>
  </head>
<body bgcolor="#ffffff">
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
            <?php esc_html_e( 'Password reset requested', 'isokoma' ); ?>            
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
      <td width="35" style="background-color:#1a1918;"></td>
      <td style="background-color:#1a1918;">    
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="mFullWidth" bgcolor="#1a1918" style="background-color: #1a1918;">
          <tr><td height="30" style="height:30px;"></td></tr>      
          <tr>                  
          <td align="left" style="font-size:16px; line-height:1.3; text-align:left; font-family:arial, sans-serif; color:#ffffff;">
            <?php printf( esc_html__( 'Dear %s,', 'isokoma' ), esc_html( $user_login ) ); ?>
          </td>            
          </tr>  
          <tr>          
            <td height="30"></td>
          </tr>
          <tr>              
            <td style="font-size:16px; line-height:1.3; text-align:left; font-family:arial, sans-serif; color:#ffffff;">   
            <?php printf( esc_html__( 'Someone has requested a new password for the following account on', 'isokoma' ) ); ?>
            <br /> <?php printf( esc_html__( '%s:', 'woocommerce' ), esc_html( wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES ) ) ); ?>
            </td>
          </tr>
          <tr>              
            <td height="30"></td>
          </tr>  
          <tr>              
            <td style="font-size:16px; line-height:1.3; text-align:left; font-family:arial, sans-serif; color:#ffffff;">             
              <?php printf( esc_html__( 'Username: %s', 'woocommerce' ), esc_html( $user_login ) ); ?>                     
            </td>
          </tr>
          <tr>              
            <td style="font-size:16px; line-height:1.3; text-align:left; font-family:arial, sans-serif; color:#ffffff;">
              <?php esc_html_e( "If you didn't make this request, just ignore this email. If you'd like to proceed:", 'isokoma' ); ?>   
              <br />
              <a class="link" href="<?php echo esc_url( add_query_arg( array( 'key' => $reset_key, 'id' => $user_id ), wc_get_endpoint_url( 'lost-password', '', wc_get_page_permalink( 'myaccount' ) ) ) ); ?>"><?php // phpcs:ignore ?>
                <?php esc_html_e( 'Click here to reset your password', 'isokoma' ); ?>
              </a>           
            </td>
          </tr>             
          <tr>              
          <td height="30"></td>
          </tr>  
          <tr>                  
          <td align="left" style="font-size:16px; line-height:1.3; text-align:left; font-family:arial, sans-serif; color:#ffffff;">
            <?php printf( esc_html__( 'Regards,', 'isokoma' )); ?>
          </td>            
          </tr>
          <tr>                  
          <td align="left" style="font-size:16px; line-height:1.3; text-align:left; font-family:arial, sans-serif; color:#ffffff;">
            <?php printf( esc_html__( 'Toragon HE', 'isokoma' )); ?>
          </td>                
          </tr>  
          <tr>              
          <td height="30"></td>
          </tr>
        </table>
      </td>     
      <td width="35" style="background-color:#1a1918;"></td>
    </tr>
  </table> 
</center>

</body>
</html>
