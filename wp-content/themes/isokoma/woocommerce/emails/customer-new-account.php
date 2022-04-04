<?php
/**
 * Customer new account email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-new-account.php.
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

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
		<title><?php echo get_bloginfo( 'name', 'display' ); ?></title>
  </head>
<body bgcolor="#ffffff">
  <style> 
  td a {
    color: #fbcf1f !important;
  }
  </style>
<center>
  <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="mFullWidth" bgcolor="black">
    <tr>  
      <td width="35" ></td>                     
      <td>    
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="mFullWidth">
          <tr>              
          <td height="30"></td>
          </tr>  
          <tr>                  
          <td align="center" valign="top" style="font-size:25px; line-height:25px;  font-weight: 300; text-align:center; font-family:arial, sans-serif; color:#fbcf1f;">                  
              <?php printf( esc_html__( 'Welcome aboard!', 'isokoma' )); ?>            
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
      <td width="35"  style="background-color:#1a1918;"></td>
      <td style="background-color:#1a1918;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="mFullWidth" bgcolor="#1a1918" style="background-color: #1a1918;">
          <tr>                          
            <td>      
              <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="mFullWidth" bgcolor="#1a1918" style="background-color: #1a1918;">
                <tr><td height="30" style="height:30px;"></td></tr>      
                <tr>                  
                <td align="left" style="font-size:16px; line-height:1.3; text-align:left; font-family:arial, sans-serif; color:#ffffff;">
                  <?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $user_login ) ); ?>
                </td>            
                </tr>  
                <tr>          
                <td height="30"></td>
                </tr>
                <tr>              
                <td style="font-size:16px; line-height:1.3; text-align:left; font-family:arial, sans-serif; color:#ffffff;">                      
                  <?php printf( esc_html__( 'Thank you for creating an account at Toragon HE. We welcome you to be a part of us!', 'isokoma' )); ?>
                </td>
                </tr>
                <tr>              
                <td height="30"></td>
                </tr>  
                <tr>              
                <td style="font-size:16px; line-height:1.3; text-align:left; font-family:arial, sans-serif; color:#ffffff;">                      
                  <?php printf( esc_html__( 'Your username is  %1$s. You can access your account area to view orders, change your password, and more at:', 'isokoma' ), '<strong>' . esc_html( $user_login ) . '</strong>' );  ?>
                  <br />
                  <?php printf( esc_html__( '%1$s', 'woocommerce' ), make_clickable( esc_url( wc_get_page_permalink( 'myaccount' ) ) ) ); ?>
                </td>
                </tr>
              </table> 
            </td>         
          </tr> 
          <tr>                          
            <td>  
              <table width="100%" border="0" cellspacing="0" cellpadding="0" align="left" class="mFullWidth">  
                <tr>              
                <td height="30"></td>
                </tr>  
                <tr>                  
                <td align="left" style="font-size:16px; line-height:1.3; text-align:left; font-family:arial, sans-serif; color:#ffffff;">
                  <?php printf( esc_html__( 'Happy shopping!', 'isokoma' )); ?>
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
          </tr>
        </table> 
      </td>
      <td width="35"  style="background-color:#1a1918;"></td>
    </tr>
  </table> 
</center>

</body>
</html>