<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package isokoma
 */
?>

<div class="page-title text-center">
    <h2><?php the_title(); ?></h2>
    <img src="https://toragon.vn/wp-content/uploads/2022/01/design-element.png" alt="toragon">
  </div>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	
	<div class="entry-content container">
		<?php
		  the_content();	
		?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
