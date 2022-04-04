<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package isokoma
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo("charset"); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i">
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-CZTCGM5KN4"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'G-CZTCGM5KN4');
  </script>
  <?php wp_head(); ?>


</head>

<body <?php body_class(); ?>>
  <div class="header_wraper">
    <div id="header_info">
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-4 info-col-l d-none d-sm-flex">
            <div class="ml-3">
              <a href="https://www.facebook.com/ToragonHE/" class="txt-blur" target="_blank">
                <img src="https://toragon.vn/wp-content/uploads/2022/01/fb.png" alt="facebook">
              </a>
            </div>

            <div class="ml-3">
              <a href="https://www.instagram.com/tigertoyz_isokoma/" class="txt-blur" target="_blank">
                <img src="https://toragon.vn/wp-content/uploads/2022/01/ig.png" alt="instagram">
              </a>
            </div>
          </div>
          <div class="col-12 col-sm-8 info-col-r">
            <?php
            if (is_user_logged_in()) { ?>
              <div class="txt-blur">
                <div class="dropdown ml-3 pl-3">
                  <a href="#" class="dropdown-toggle txt-blur" data-toggle="dropdown"><?php _e('Xin chào', 'isokoma')  ?>
                    <?php
                    $user = wp_get_current_user();
                    echo $user->user_login;
                    ?></a>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="/my-account"><?php echo _e('Tài khoản', 'isokoma'); ?></a>
                    <a class="dropdown-item" href="/my-account/orders"><?php echo _e('Lịch sử mua hàng', 'isokoma'); ?></a>
                    <a class="dropdown-item" href="/my-account/edit-account/"><?php echo _e('Đổi mật khẩu', 'isokoma'); ?></a>
                    <a class="dropdown-item logout" href="#"><?php echo _e('Đăng xuất', 'isokoma'); ?></a>
                  </div>
                </div>
              </div>
            <?php } else { ?>
              <div class="txt-blur">
                <a href="<?php echo site_url('/my-account'); ?>" class="txt-blur">
                  <?php echo _e('Đăng nhập', 'isokoma'); ?>
                </a>
                <div class="border-center"></div>
                <a class="txt-blur" href="<?php echo site_url('/register'); ?>">
                  <?php echo _e('Tạo tài khoản', 'isokoma'); ?>
                </a>
              </div>
            <?php } ?>
            <div class="border-center"></div>
            <div class="dropdown language">
              <?php echo do_shortcode('[language-switcher]'); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="header_logo" class="container">
      <div class="row">
        <div class="col-12 col-sm-2 logo-col-l  d-sm-flex">
          <a href="<?php echo home_url(); ?>" class="navbar-brand">
            <img class="main-logo" src="https://toragon.vn/wp-content/uploads/2022/01/logo_toragon.png" border="0" alt="Toragon" title="" />
          </a>
        </div>
        <div class="col-12 col-sm-6 text-center logo-col-c">
          <nav id="header_menu" class="navbar navbar-expand-md navbar-light sticky-top">

            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#collapsible_navbar" aria-expanded="false">
              <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
            </button>
            <a class="navbar-brand d-sm-none" href="<?php echo home_url(); ?>" class="navbar-brand">
              <img class="main-logo" src="https://toragon.vn/wp-content/uploads/2022/01/logo_toragon.png" border="0" alt="Toragon" title="" />
            </a>
            <div class="logo-col-r mobile-only d-flex d-sm-none">
              <div class="ml-3">
                <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">
                  <div class="cart_count">
                    <img src="https://toragon.vn/wp-content/uploads/2022/01/tiger.png" alt="cart">
                  </div>
                </a>
              </div>
              <div class="ml-3">
                <?php echo do_shortcode('[wishlist_count]'); ?>               
              </div>
              <div class="ml-3">
                <a href="<?php echo wc_get_cart_url(); ?>">
                  <div class="cart_count">
                    <img src="https://toragon.vn/wp-content/uploads/2022/01/briefcaseic.png" alt="cart">
                    <div class="header-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></div>
                  </div>
                </a>
              </div>
            </div>

            <?php
            wp_nav_menu(array(
              'theme_location'  => 'top-nav',
              'depth'           =>  2, // 1 = no dropdowns, 2 = with dropdowns.
              'container'       => 'div',
              'container_class' => 'navbar-collapse collapse',
              'menu_id' => 'navbarIsokomaContent',
              'container_id'    => 'collapsible_navbar',
              'menu_class'      => 'navbar-nav',
              'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
              'walker'          => new WP_Bootstrap_Navwalker(),
            ));
            ?>


          </nav>
        </div>
        <div class="col-sm-4 logo-col-r d-none d-sm-flex">
          <?php get_search_form(); ?>

          <div class="ml-3">
            <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">
              <div class="cart_count">
                <img src="https://toragon.vn/wp-content/uploads/2022/01/tiger.png" alt="cart">
              </div>
            </a>
          </div>
          <div class="ml-3">
            <?php echo do_shortcode('[wishlist_count]'); ?>            
          </div>
          <div class="ml-3">
            <a href="<?php echo wc_get_cart_url(); ?>">
              <div class="cart_count">
                <img src="https://toragon.vn/wp-content/uploads/2022/01/briefcaseic.png" alt="cart">
                <div class="header-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
    <?php do_action('woocommerce_after_cart_table'); ?>



  </div>


  <?php
  if (is_front_page()) :
    do_action('isokoma_slider');
  endif;
  ?>

  <div id="content" class="site-content" tabindex="-1">
    <div class="content-inner">