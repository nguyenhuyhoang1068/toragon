<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package isokoma
 */
?>

  <div class="breadcrumbs-area">
    <div class="box-breadcrumb mobile deskstop">      
      <div class="banner-text text-center">
        <h2 class="mb-0"><?php _e('Đăng nhập', 'isokoma') ?></h2>
        <div class="d-none d-sm-block"><?php _e('Trang chủ', 'isokoma') ?>  &gt; <?php _e('Khách hàng', 'isokoma') ?></div>
      </div>
      <img class="breadcrumb-icon mobile" src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-1.png" alt="">
			<img class="breadcrumb-icon desktop" src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_1.jpg" alt="">      
    </div>
  </div>



<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	
	<div class="entry-content container">
		<?php
		  the_content();	
		?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
