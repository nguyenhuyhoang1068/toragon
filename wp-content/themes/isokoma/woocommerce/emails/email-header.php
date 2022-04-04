<?php
/**
 * Email Header
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-header.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 4.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

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
   





