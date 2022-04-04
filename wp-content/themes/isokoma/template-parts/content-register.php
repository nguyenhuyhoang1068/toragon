<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package isokoma
 */
?>
<?php 
if (( $post->ID  == 139) || ( $post->ID  == 12) || ( $post->ID  == 255)) : ?>
   <div class="page-title text-center">
	<h2><?php the_title(); ?></h2>
	<img src="https://toragon.vn/wp-content/uploads/2022/01/design-element.png" alt="toragon">
</div>
<?php endif ?>   


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	
	<div class="entry-content container">
  <h1 class="mt-5 register"><?php esc_html_e( 'ĐĂNG KÝ TÀI KHOẢN', 'isokoma' ); ?></h1>
		<?php
		  the_content();	      
      echo do_shortcode('[wc_reg_form_isokoma]');      
		?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
