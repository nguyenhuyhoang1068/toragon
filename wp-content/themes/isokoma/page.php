<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package citysquare
 */

get_header();
?>
	<?php 
		$parent = get_the_title($post->post_parent);
		//$ancestors = apply_filters( "the_title", get_the_title( end ( get_post_ancestors( $post->ID ) ) ) );
		global $wp;
		$current_url = home_url( add_query_arg( array(), $wp->request ) );
	?>
	<div class="isokoma_content">

		<?php
		while ( have_posts() ) :
			the_post();      
			if($pagename == 'gioi-thieu'){
				get_template_part( 'template-parts/content', 'about' );
			}elseif($pagename == 'tin-tuc'){
				get_template_part( 'template-parts/content', 'tintuc' );
			}elseif($pagename == 'hang-moi'){
				get_template_part( 'template-parts/content', 'productnew' );
			}elseif($pagename == 'san-pham'){
				get_template_part( 'template-parts/content', 'productall' );				
			}elseif($pagename == 'lien-he'){
				get_template_part( 'template-parts/content', 'contact' );				
			}elseif($pagename == 'my-account'){
				get_template_part( 'template-parts/content', 'login' );				
			}elseif($pagename == 'register'){
				get_template_part( 'template-parts/content', 'register' );				
			}elseif($pagename == 'password'){
				get_template_part( 'template-parts/content', 'password' );				
			} elseif(( $pagename == 'dieu-khoan-va-dieu-le') || ($pagename == 'chinh-sach-bao-mat') || ($pagename == 'cau-hoi-thuong-gap')) {
				get_template_part( 'template-parts/content', 'dieukhoanvadieule' );				
			} else { ?>
			<div id="entry-content-backend">			
			<?php
				the_content();							
			?>
			</div><!-- .entry-content -->
      
			<?php	
			}			
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>		

	</div><!-- #primary -->

<?php
get_footer();
