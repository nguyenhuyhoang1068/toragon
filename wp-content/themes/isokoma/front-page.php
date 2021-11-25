<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package isokoma
 */

get_header();
?>

<?php
	do_action('isokoma_new_product');
	do_action('isokoma_hot_product');
	do_action('isokoma_product_category');	
?>


<div class="contain">
	<div class="about-us">    
		<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();
				echo get_the_content();
			endwhile;
		?>
	</div>
</div>
<?php
get_footer();
?>