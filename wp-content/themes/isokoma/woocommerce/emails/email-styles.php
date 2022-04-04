<?php
/**
 * Email Styles
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-styles.php.
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
	exit;
}
?>
html {
  -webkit-text-size-adjust: 100% !important;
}

table,
tr,
td {
  border-collapse: collapse;
  mso-table-lspace: 0pt;
  mso-table-rspace: 0pt;
}
td time,
td a{
  color: #ffffff !important;
}

img {
  display: block;
}

@media only screen and (max-width:799px) {
  td.mW15 {
    width: 15px !important;
  }

  td[class=mW15] {
    width: 15px !important;
  }

  td.mW50 {
    width: 50% !important;
  }

  td[class=mW50] {
    width: 50% !important;
  }

  img.mH40 {
    height: 40px !important;
  }

  img[class=mH40] {
    height: 40px !important;
  }

  table.mFullWidth,
  td.mFullWidth,
  img.mFullWidth {
    width: 100% !important;
  }

  table[class=mFullWidth],
  td[class=mFullWidth],
  img[class=mFullWidth] {
    width: 100% !important;
  }

  table.mHalfWidth,
  td.mHalfWidth,
  img.mHalfWidth {
    width: 50% !important;
  }

  table[class=mHalfWidth],
  td[class=mHalfWidth],
  img[class=mHalfWidth] {
    width: 50% !important;
  }

  table.mBlock,
  td.mBlock,
  img.mBlock {
    display: block !important;
  }

  table[class=mBlock],
  td[class=mBlock],
  img[class=mBlock] {
    display: block !important;
  }

  table.mTable {
    display: table !important;
  }

  table[class=mTable] {
    display: table !important;
  }

  table.mPadBtm20,
  td.mPadBtm20 {
    padding-bottom: 20px !important;
  }

  table[class=mPadBtm20],
  td[class=mPadBtm20] {
    padding-bottom: 20px !important;
  }

  td.mPadLeft25 {
    padding-left: 25px !important;
  }

  td[class=mPadLeft25] {
    padding-left: 25px !important;
  }

  table.mHide,
  td.mHide,
  img.mHide,
  br.mHide {
    display: none !important;
    height: 0px !important;
    width: 0px !important;
  }

  table[class=mHide],
  td[class=mHide],
  img[class=mHide],
  br[class=mHide] {
    display: none !important;
    height: 0px !important;
    width: 0px !important;
  }

  td[class=mBackground] {
    background: none;
    background-color: #dbdae0;
  }

  td.mBackground {
    background: none;
    background-color: #dbdae0;
  }

  td.font30 {
    font-size: 30px !important;
    line-height: 33px !important;
  }

  td[class=font30] {
    font-size: 30px !important;
    line-height: 33px !important;
  }

  td.font33 {
    font-size: 33px !important;
    line-height: 36px !important;
  }

  td[class=font33] {
    font-size: 33px !important;
    line-height: 36px !important;
  }

  td.font24 {
    font-size: 24px !important;
    line-height: 27px !important;
  }

  td[class=font24] {
    font-size: 24px !important;
    line-height: 27px !important;
  }

  td.font13 {
    font-size: 13px !important;
    line-height: 16px !important;
  }

  td[class=font13] {
    font-size: 13px !important;
    line-height: 16px !important;
  }

  table.mShow,
  td.mShow,
  img.mShow,
  br.mShow {
    display: block !important;
    height: 100% !important;
    width: 100% !important;
  }

  table[class=mShow],
  td[class=mShow],
  img[class=mShow],
  br[class=mShow] {
    display: block !important;
    height: 100% !important;
    width: 100% !important;
  }
}
<?php
