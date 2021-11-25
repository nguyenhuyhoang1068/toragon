<?php 
/*
Template Name: General
*/
get_header(); ?>



	<div id="primary" class="content-area">
		<main id="main" class="site-main">
    <div class="container">
			<?php

			// Start the Loop.
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', 'page' );

			endwhile; // End the loop.
			?>
    </div>
		</main><!-- #main -->
	</div><!-- #primary -->




<?php get_footer(); ?>