

<?php 
if (( $post->ID  == 199) || ( $post->ID  == 12) || ( $post->ID  == 2)) : ?>
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






 

	<?php


	$args = array(
    'posts_per_page'      => 9,
    'post_type'           => 'product',
    'post_status'         => 'publish',
    'ignore_sticky_posts' => 1,
    'order'               => 'DESC',
    'tax_query'           => array(      
			array(
					'taxonomy' => 'product_tag',
					'terms'    => array('news'),
					'field'    => 'slug',
			),      
    ),   
	);

?>

<div id="product_productnew_content" class="container">
	<div class="row">			
			<?php
			$loop = new WP_Query( $args );
			while ( $loop->have_posts() ) : $loop->the_post(); global $product;	 ?>				
				<div class="col-12 col-sm-3 p-item">
					<div class="card box-product">
						<div class="wrap-img">
							<?php global $post; ?>
							<?php 
								$thumb_id = get_post_thumbnail_id();
								$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'isokoma-banner-500', true);
								$thumb_url = $thumb_url_array[0];
							?>						
							<?php 
								echo '<img src="'.$thumb_url.'"  />'; 
							?>	
						</div>
						<div class="card-body">						
							<?php if ( get_post_meta($loop->post->ID, 'custom_text_field_pre_order', true) ) : ?>			
								<div class="pre-order">
									<?php echo get_post_meta($loop->post->ID, 'custom_text_field_pre_order', TRUE); ?>
								</div>
							<?php endif; ?>			
							<h3 class="product-name">
							<a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
								<?php the_title(); ?>
							</a>
              </h3>
							<?php if ( get_post_meta($loop->post->ID, 'custom_text_field_size', true) ) : ?>			
							<p class="text-center txt-blur small">
								<b><?php echo get_post_meta($loop->post->ID, 'custom_text_field_size', TRUE); ?></b>
							</p>
							<?php endif; ?>	
							<p class="text-center txt-blur small">
								<?php echo $product->get_price_html(); ?>
							</p>							
							<div class="text-danger text-center">								
								<a href="<?php   site_url('/my-account'); ?>">
								<?php  _e('Đăng nhập để đặt hàng'); ?>							
								</a>
							</div>
						</div>
					</div>											
          </div>
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>			
  </div>											
</div>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	
	<div class="entry-content container">
		<?php
		  the_content();	
		?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->






 

	<?php


	$args = array(
    'posts_per_page'      => 9,
    'post_type'           => 'product',
    'post_status'         => 'publish',
    'ignore_sticky_posts' => 1,
    'order'               => 'DESC',
    'tax_query'           => array(      
			array(
					'taxonomy' => 'product_tag',
					'terms'    => array('news'),
					'field'    => 'slug',
			),      
    ),   
	);

?>

<div id="product_productnew_content" class="container">
	<div class="row">			
			<?php
			$loop = new WP_Query( $args );
			while ( $loop->have_posts() ) : $loop->the_post(); global $product;	 ?>				
				<div class="col-12 col-sm-3 p-item">
					<div class="card box-product">
						<div class="wrap-img">
							<?php global $post; ?>
							<?php 
								$thumb_id = get_post_thumbnail_id();
								$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'isokoma-banner-500', true);
								$thumb_url = $thumb_url_array[0];
							?>						
							<?php 
								echo '<img src="'.$thumb_url.'"  />'; 
							?>	
						</div>
						<div class="card-body">						
							<?php if ( get_post_meta($loop->post->ID, 'custom_text_field_pre_order', true) ) : ?>			
								<div class="pre-order">
									<?php echo get_post_meta($loop->post->ID, 'custom_text_field_pre_order', TRUE); ?>
								</div>
							<?php endif; ?>			
							<h3 class="product-name">
							<a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
								<?php the_title(); ?>
							</a>
              </h3>
							<?php if ( get_post_meta($loop->post->ID, 'custom_text_field_size', true) ) : ?>			
							<p class="text-center txt-blur small">
								<b><?php echo get_post_meta($loop->post->ID, 'custom_text_field_size', TRUE); ?></b>
							</p>
							<?php endif; ?>	
							<p class="text-center txt-blur small">
								<?php echo $product->get_price_html(); ?>
							</p>							
							<div class="text-danger text-center">								
								<a href="<?php   echo site_url('/my-account'); ?>">
								<?php echo _e('Đăng nhập để đặt hàng'); ?>							
								</a>
							</div>
						</div>
					</div>											
          </div>
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>			
  </div>											
</div>
