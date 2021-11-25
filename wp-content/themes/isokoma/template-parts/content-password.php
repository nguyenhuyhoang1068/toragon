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
if (( $post->ID  == 139) || ( $post->ID  == 12) || ( $post->ID  == 264)) : ?>
 <div class="breadcrumbs-area">
    <div class="box-breadcrumb mobile deskstop">      
      <div class="banner-text text-center">
        <h2 class="mb-0"><?php the_title(); ?></h2>
        <div class="d-none d-sm-block"><?php do_action( 'isokoma_breadcrumb' ); ?></div>
      </div>
      <img class="breadcrumb-icon mobile" src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-1.png" alt="">
			<img class="breadcrumb-icon desktop" src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_1.jpg" alt="">      
    </div>
  </div>
<?php endif ?>   


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	
	<div class="entry-content container">
		<?php
		  the_content();	
		?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
