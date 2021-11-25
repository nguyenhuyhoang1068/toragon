<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package isokoma
 */
?>
  </div><!-- .container -->
</div><!-- #content -->
<?php wp_footer() ?>
<div id="footer_content" class="contain">
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-3 contact">
        <h3><?php echo _e('Công ty Cổ phần <nobr>TORAGON HE</nobr> ', 'isokoma'); ?></h3>
        <p class="location footer-icon"><span>140 Lý Chính Thắng, Phường Võ Thị Sáu, <nobr>Quận 3, </nobr>Tp. Hồ Chí Minh.</span></p>
        <p class="phone  footer-icon"><a href="tel:02866505565">028 6650 5565</a></p>
        <p class="mail  footer-icon"><a href="mailto:sales@toragon.vn" target="_self">sales@toragon.vn</a></p>
        <p class="license_toragon">         
          Giấy CNĐKDN Số: 0316929447 do Sở kế hoạch và đầu tư Tp. HCM cấp ngày 07/07/2021
        </p>
        <div class="quota">
          <a href='http://online.gov.vn/Home/WebDetails/85932' target="_blank" rel="nofollow">
          <noscript><img src="<?php echo get_stylesheet_directory_uri()   ?>/images/logoSaleNoti.png" alt=""></noscript>
          <img class=" ls-is-cached lazyloaded" src="<?php echo get_stylesheet_directory_uri()   ?>/images/logoSaleNoti.png" data-src="<?php echo get_stylesheet_directory_uri()   ?>/images/logoSaleNoti.png" alt="">          
          </a>        
        </div>
      </div>
      <div class="col-6 col-sm-3 info">
        <h3><?php echo _e('Thông tin', 'isokoma'); ?></h3>
        <ul>
          <li><a href="/gioi-thieu/" class="txt-blur"><?php echo _e('Giới thiệu', 'isokoma'); ?> </a></li>
          <li><a href="/lien-he/" class="txt-blur"><?php echo _e('Liên hệ', 'isokoma'); ?> </a></li>
          <li><a href="/dieu-khoan-va-dieu-le" class="txt-blur"><?php echo _e('Điều khoản và điều lệ', 'isokoma'); ?></a></li>
          <li><a href="/chinh-sach-bao-mat" class="txt-blur"><?php echo _e('Chính sách bảo mật', 'isokoma'); ?> </a></li>
          <li><a href="#" class="txt-blur"><?php echo _e('Dịch vụ khách hàng', 'isokoma'); ?> </a></li>
          <li><a href="/cau-hoi-thuong-gap" class="txt-blur"><?php echo _e('Câu hỏi thường gặp', 'isokoma'); ?> </a></li>
        </ul>
      </div>
      <div class="col-6 col-sm-3 account">
        <h3><?php echo _e('Tài khoản', 'isokoma'); ?></h3>
        <ul>
          <li><a href="/my-account" class="txt-blur"><?php echo _e('Tài khoản của tôi', 'isokoma'); ?> </a></li>
          <li><a href="/my-account/orders" class="txt-blur"><?php echo _e('Theo dõi đơn hàng', 'isokoma'); ?> </a></li>
          <li><a href="/wishlist" class="txt-blur"><?php echo _e('Danh sách yêu thích', 'isokoma'); ?> </a></li>
          <li><a href="/cart" class="txt-blur"><?php echo _e('Giỏ hàng', 'isokoma'); ?> </a></li>
          <li><a href="/checkout" class="txt-blur"><?php echo _e('Thanh toán', 'isokoma'); ?> </a></li>
          
        </ul>
      </div>
      <div class="col-12 col-sm-3">
        <h3><?php echo _e('Đăng kí nhận tin', 'isokoma'); ?></h3>
        <p class="txt-blur"><?php echo _e('Đăng ký ngay để nhận được thông tin khuyến mãi mới nhất', 'isokoma'); ?></p>
        <div id="es_form_f1-n1" class="input-group emaillist">
          <input type="email" class="form-control txt-email-subscribe es_required_field es_txt_email ig_es_form_field_email" name="esfpx_email" placeholder="Email của bạn">
          <input type="hidden" name="esfpx_lists[]" value="20e7a6c26415"><input type="hidden" name="esfpx_form_id" value="1">
          <input type="hidden" name="es" value="subscribe">
          <input type="hidden" name="esfpx_es_form_identifier" value="f1-n1">
          <input type="hidden" name="esfpx_es_email_page" value="2812">
          <input type="hidden" name="esfpx_es_email_page_url" value="#">
          <input type="hidden" name="esfpx_status" value="Unconfirmed">
          <input type="hidden" name="esfpx_es-subscribe" id="es-subscribe" value="c75fc1d1b0">
          <div class="input-group-append">
            <button class="btn btn-subscribe es_subscription_form_submit es_submit_button es_textbox_button" type="button">
              <image src="https://staging.toragon.vn/wp-content/uploads/2021/11/arrow-right.png">
            </button>
          </div>
          <input type="hidden" name="formsubmit" value="1" />
        </div>
        <div id="es_subscription_message" style="color:#FCCE23;">
        </div>
      </div>
    </div>
  </div>
</div>
<div id="footer_rights" class="contain text-center txt-blur"><a href="index.php"><b>© Toragon HE </b></a> - All rights Reserved</div>
</body>
</html>