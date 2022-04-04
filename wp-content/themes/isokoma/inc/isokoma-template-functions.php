<?php
function isokoma_featured_slider()
{

?>
	<?php if (class_exists('WooCommerce')) { ?>

		<div id="home_home_carousel" class="carousel slide" data-ride="carousel" data-interval="false">
			<ol class="carousel-indicators">
				<?php
				// Set the arguments for the query
				$args = array(
					'numberposts'    => -1, // -1 is for all
					'post_type'    => 'carousel', // or 'post', 'page'
				);
				// Get the posts
				$myposts = get_posts($args);
				// If there are posts
				if ($myposts) : ?>
					<?php
					// Loop the posts
					$x = 0;
					foreach ($myposts as $mypost) :
					?>
						<?php if ($x === 0) : ?>
							<li data-target="#home_home_carousel" data-slide-to="<?php echo $x; ?>" class="active"></li>
						<?php else : ?>
							<li data-target="#home_home_carousel" data-slide-to="<?php echo $x; ?>"></li>
						<?php endif; ?>
					<?php $x++;
					endforeach;
					wp_reset_postdata();
					?>
				<?php endif; ?>
			</ol>
			<div class="carousel-inner">
				<?php
				// Set the arguments for the query
				$args = array(
					'numberposts'    => -1, // -1 is for all
					'post_type'    => 'carousel', // or 'post', 'page'
				);
				// Get the posts
				$myposts = get_posts($args);
				// If there are posts
				if ($myposts) : ?>
					<?php
					// Loop the posts
					$i = 1;
					foreach ($myposts as $mypost) :
					?>
						<?php if ($i === 1) : ?>
							<div class="carousel-item active">
							<?php else : ?>
								<div class="carousel-item">
								<?php endif; ?>
								<?php if (get_post_meta($mypost->ID, '_url', true) !== '') : ?>
									<a href="<?php echo get_post_meta($mypost->ID, '_url', true); ?>" title="" target="_blank">
									<?php endif; ?>
									<?php if (get_post_meta($mypost->ID, '_mobile_banner', true) !== '') : ?>
										<div class="mobile">
											<img src="<?php echo get_post_meta($mypost->ID, '_mobile_banner', true); ?>" alt="">
										</div>
									<?php endif; ?>
									<?php if (get_the_post_thumbnail($mypost->ID, 'carousel_image') !== '') : ?>
										<div class="deskstop">
											<?php echo get_the_post_thumbnail($mypost->ID, 'carousel_image'); ?>
										</div>
									<?php endif; ?>
									<?php if (get_post_meta($mypost->ID, '_youtubeurl', true) !== '') : ?>
										<div class="deskstop">
											<iframe id="player" width="100%" src="https://www.youtube.com/embed/<?php echo get_post_meta($mypost->ID, '_youtubeurl', true); ?>?autoplay=0&showinfo=0&modestbranding=0&wmode=transparent&controls=0&color=white&rel=0&enablejsapi=0" frameborder="0" allowfullscreen></iframe>
										</div>
										<div class="mobile">
											<div class="embed-responsive embed-responsive-16by9">
												<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo get_post_meta($mypost->ID, '_youtubeurl', true); ?>?autoplay=0&showinfo=0&modestbranding=0&wmode=transparent&controls=0&color=white&rel=0&enablejsapi=0" frameborder="0" allowfullscreen></iframe>
											</div>
										</div>
									<?php endif; ?>
									<?php if (get_post_meta($mypost->ID, '_video_upload', true) !== '') : ?>

										<!--- New changes -->
										<?php /*
									<div class="mobile"><img src="<?php  echo bloginfo('url');  ?>/wp-content/uploads/2021/03/1.jpg"></div>
									<div class="deskstop"><img src="<?php  echo bloginfo('url');  ?>/wp-content/uploads/2021/03/1.jpg"></div>	
									*/ ?>
										<?php if (get_post_meta($mypost->ID, '_mobile_banner', true) == '') : ?>
											<div class="mobile"><img class="attachment-carousel_image" src="https://toragon.vn/wp-content/uploads/2022/01/2021-1.jpg"></div>
										<?php endif; ?>
										<?php if (get_the_post_thumbnail($mypost->ID, 'carousel_image') == '') : ?>
											<div class="deskstop"><img class="attachment-carousel_image" src="https://toragon.vn/wp-content/uploads/2022/01/2021-1.jpg"></div>
										<?php endif; ?>
										<p class="play-icon"><i class="fa fa-play-circle" style="font-size:130px;color:white"></i></p>
										<!--- New changes -->

										<video width="100%" controls class="banner-video">
											<source src="<?php echo get_post_meta($mypost->ID, '_video_upload', true); ?>" type="video/mp4">
										</video>
									<?php endif; ?>
									<?php if (get_post_meta($mypost->ID, '_url', true) !== '') : ?>
									</a>
								<?php endif; ?>
								</div>


							<?php $i++;
						endforeach;
						wp_reset_postdata();
							?>
						<?php endif; ?>
							</div>
							<a class="carousel-control-prev" href="#home_home_carousel" role="button" data-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="sr-only">Previous</span>
							</a>
							<a class="carousel-control-next" href="#home_home_carousel" role="button" data-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="sr-only">Next</span>
							</a>
			</div>
		</div>
<?php }
} ?>

<?php
function retailer_featured_slider()
{
?>
	<?php if (class_exists('WooCommerce')) { ?>
		<?php


		//elseif($meta_key == "total_sales"):
		$args = array(
			'post_type' => 'product',
			'meta_key' => 'total_sales',
			'orderby' => 'meta_value_num',
			'posts_per_page' => 7
		);


		$auto_scroll = 'true';

		?>
		<h2 class="section-title">Sản phẩm nổi bật</h2>
		<div id="slider" class="flexslider" data-slide="<?php echo esc_html($auto_scroll); ?>">
			<ul class="slides">
				<?php
				$loop = new WP_Query($args);
				while ($loop->have_posts()) : $loop->the_post();
					global $product;	 ?>

					<li class="product-slider">
						<div class="banner-product-image">
							<?php global $post;
							woocommerce_show_product_sale_flash($post, $product); ?>
							<?php
							$thumb_id = get_post_thumbnail_id();
							$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'isokoma-banner-1000', true);
							$thumb_url = $thumb_url_array[0];
							?>

							<?php if (has_post_thumbnail($loop->post->ID)) echo '<div style="background-image: url(' . $thumb_url . '); position: absolute; top: 0px; width: 100%; height: 100%; background-position: center center; background-repeat: no-repeat; right: 0px; background-size: cover;"></div>';
							else echo '<img src="' . woocommerce_placeholder_img_src() . '" alt="Placeholder" width="1000px" height="1000px" />'; ?>
						</div>
						<div class="banner-product-details">
							<h3><?php the_title(); ?></h3>
							<p class="price"><?php echo $product->get_price_html(); ?></p>

							<a href="<?php echo get_permalink($loop->post->ID) ?>" class="button" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>"><?php _e('View Product', 'isokoma'); ?></a>
						</div>
						<div class="clearfix"></div>
					</li>
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>
			</ul>
		</div>
		<div id="carousel" class="flexslider">
			<ul class="slides">
				<?php
				$loop = new WP_Query($args);
				while ($loop->have_posts()) : $loop->the_post();
					global $product;	 ?>

					<li class="product-slider">
						<?php if (has_post_thumbnail($loop->post->ID)) echo get_the_post_thumbnail($loop->post->ID, 'isokoma-thumb-400');
						else echo '<img src="' . woocommerce_placeholder_img_src() . '" alt="Placeholder" width="400px" height="400px" />'; ?>
						<span class="overlay"></span>
					</li>
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>
			</ul>
		</div>
<?php 	}
} ?>

<?php
function isokoma_new_product_slider()
{
	/**
	 * Display Slider
	 * @since  1.0.0
	 * @return void
	 */
?>

	<?php if (class_exists('WooCommerce')) { ?>
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
					'terms'    => array('hots'),
					'field'    => 'slug',
				),
			),
		);

		$auto_scroll = 'true';

		?>
		<div class="slider-products hot-products">
			<div class="container">
				<div class="info">
					<h2 class="text-center"><?php _e('Sản phẩm nổi bật', 'isokoma'); ?></h2>
					<p class="text-center"><?php _e('Những sản phẩm đặc biệt <nobr>của cửa hàng</nobr>', 'isokoma'); ?></p>
					<img src="https://toragon.vn/wp-content/uploads/2022/01/design-element.png" alt="toragon">
				</div>
				<div class="carousel-wrapper">
					<div class="flexslider carousel">
						<ul class="slides">
							<?php
							$loop = new WP_Query($args);
							while ($loop->have_posts()) : $loop->the_post();
								global $product;	 ?>
								<li>
									<div class="card box-product">
										<div class="wrap-img">
											<?php global $post;  ?>
											<?php
											$thumb_id = get_post_thumbnail_id();
											$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'isokoma-banner-500', true);
											$thumb_url = $thumb_url_array[0];
											?>
											<a href="<?php echo get_permalink($loop->post->ID) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
												<img src="<?php echo $thumb_url ?>" />
											</a>
										</div>
										<div class="card-body">
											<?php if ($product->single_add_to_cart_text() === 'Pre-Order') : ?>
												<div class="pre-order">
													<?php echo 'Pre-Order'; ?>
												</div>
											<?php endif; ?>
											<h3 class="product-name">
												<a href="<?php echo get_permalink($loop->post->ID) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>"><?php the_title(); ?> </a>
											</h3>
											<p class="text-center txt-blur small">
												<b><?php echo get_post_meta($loop->post->ID, 'custom_text_field_size', TRUE); ?></b>
											</p>
											<p class="text-center txt-blur small">
												<?php echo $product->get_price_html(); ?>
											</p>
											<?php
											add_action('isokoma_single_product_out_of_stock', 'isokoma_out_of_stock',		10);
											do_action('isokoma_single_product_out_of_stock');
											?>
											<?php
											wp_commerce_template_single_add_to_cart();
											?>
										</div>
										<div class="add-to-wl"><?php
										echo do_shortcode('[woosw id="' . $product->get_id() . '"]');
										?></div>
									</div>
								</li>
							<?php endwhile; ?>
							<?php wp_reset_query(); ?>
						</ul>
					</div>
				</div>

			</div>
		</div>
<?php 	}
} ?>



<?php
function isokoma_hot_product_slider()
{
	/**
	 * Display Slider
	 * @since  1.0.0
	 * @return void
	 */
?>

	<?php if (class_exists('WooCommerce')) { ?>
		<?php



		// $args = array(
		// 	'post_type' => 'product',
		// 	'meta_key' => 'total_sales',
		// 	'orderby' => 'meta_value_num',
		// 	'posts_per_page' => 8
		// );
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
		<div class="slider-products news-products">
			<div class="container">
				<div class="info">
					<h2 class="text-center"><?php _e('Sản phẩm mới', 'isokoma'); ?></h2>
					<p class="text-center"><?php _e('Liên tục cập nhật các mặt hàng mới', 'isokoma'); ?></p>
					<img src="https://toragon.vn/wp-content/uploads/2022/01/design-element.png" alt="toragon">

				</div>
				<div class="carousel-wrapper">
					<div class="flexslider2 carousel">
						<ul class="slides">
							<?php
							$loop = new WP_Query($args);
							while ($loop->have_posts()) : $loop->the_post();
								global $product;	 ?>
								<li>
									<div class="card box-product">
										<div class="wrap-img">
											<?php global $post; ?>
											<?php
											$thumb_id = get_post_thumbnail_id();
											$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'isokoma-banner-500', true);
											$thumb_url = $thumb_url_array[0];
											?>
											<a href="<?php echo get_permalink($loop->post->ID) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
												<img src="<?php echo $thumb_url ?>" />
											</a>
										</div>
										<div class="card-body">
											<?php if ($product->single_add_to_cart_text() === 'Pre-Order') : ?>
												<div class="pre-order">
													<?php echo 'Pre-Order'; ?>
												</div>
											<?php endif; ?>
											<h3 class="product-name">
												<a href="<?php echo get_permalink($loop->post->ID) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
													<?php the_title(); ?>
												</a>
											</h3>
											<p class="text-center txt-blur small">
												<b><?php echo get_post_meta($loop->post->ID, 'custom_text_field_size', TRUE); ?></b>
											</p>
											<p class="text-center txt-blur small">
												<?php echo $product->get_price_html(); ?>
											</p>
											<?php
											add_action('isokoma_single_product_quantity_action', 'isokoma_out_of_stock',		10);
											do_action('isokoma_single_product_quantity_action');
											?>
											<?php
											wp_commerce_template_single_add_to_cart();
											?>
										</div>
										<div class="add-to-wl"><?php
										echo do_shortcode('[woosw id="' . $product->get_id() . '"]');
										?></div>
									</div>
								</li>
							<?php endwhile; ?>
							<?php wp_reset_query(); ?>
						</ul>
					</div>

				</div>


			</div>
		</div>

<?php 	}
} ?>




<?php
function isokoma_product_categories()
{
	/**
	 * Display Slider
	 * @since  1.0.0
	 * @return void
	 */
?>

	<?php if (class_exists('WooCommerce')) { ?>
		<div class="product-categories">
			<div id="home_home_category" class="container">
				<div class="row">
					<?php



					// $woocommerce_category_id = get_queried_object_id();
					// $args = array(
					// 		'parent' => $woocommerce_category_id
					// );
					// $terms = get_terms( 'product_cat', $args );
					// if ( $terms ) {
					// 		echo '<ul class="woocommerce-categories">';
					// 		foreach ( $terms as $term ) {
					// 				echo '<li class="woocommerce-product-category-page">';
					// 					woocommerce_subcategory_thumbnail( $term );
					// 				echo '<h2>';
					// 				echo '<a href="' .  esc_url( get_term_link( $term ) ) . '" class="' . $term->slug . '">';
					// 				echo $term->name;
					// 				echo '</a>';
					// 				echo '</h2>';
					// 				echo '</li>';
					// 		}
					// 		echo '</ul>';
					// }

					$taxonomy     = 'product_cat';
					$orderby      = 'name';
					$show_count   = 0;      // 1 for yes, 0 for no
					$pad_counts   = 0;      // 1 for yes, 0 for no
					$hierarchical = 1;      // 1 for yes, 0 for no  
					$title        = '';
					$empty        = 0;

					$args = array(
						'taxonomy'     => $taxonomy,
						'orderby'      => $orderby,
						'show_count'   => $show_count,
						'pad_counts'   => $pad_counts,
						'hierarchical' => $hierarchical,
						'title_li'     => $title,
						'hide_empty'   => $empty
					);
					$all_categories = get_categories($args);
					?>
					<?php
					foreach ($all_categories as $cat) {
						if ($cat->category_parent == 0) {
							$thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
							$image_url = wp_get_attachment_url($thumbnail_id);
					?>
							<div class="col-12 col-sm-4">
								<div class="card">

									<div class="card-img">
										<h5 class="card-title"><?php echo $cat->name; ?></h5>
										<p class="card-text txt-blur"><?php _e('Danh mục', 'isokoma'); ?></p>
										<img class="card-img-top" src="<?php echo $image_url; ?>" alt="">
										<a href="<?php echo get_term_link($cat->slug, 'product_cat'); ?>"><?php _e('XEM', 'isokoma'); ?> </a>
									</div>
								</div>
							</div>
					<?php
						}
					}
					?>
				</div>
			</div>
		</div>

<?php 	}
} ?>




<?php
function isokoma_product_page_new()
{
	/**
	 * Display Slider
	 * @since  1.0.0
	 * @return void
	 */
?>

	<?php if (class_exists('WooCommerce')) { ?>
		<?php



		// $args = array(
		// 	'post_type' => 'product',
		// 	'meta_key' => 'total_sales',
		// 	'orderby' => 'meta_value_num',
		// 	'posts_per_page' => 8
		// );
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
		<div id="home_home_category" class="container">
			<div class="row">
				<?php
				$taxonomy     = 'product_cat';
				$orderby      = 'title';
				$show_count   = 0;      // 1 for yes, 0 for no
				$pad_counts   = 0;      // 1 for yes, 0 for no
				$hierarchical = 0;      // 1 for yes, 0 for no  
				$title        = '';
				$empty        = 0;
				$order 			  =  'ASC';

				$args = array(
					'taxonomy'     => $taxonomy,
					'hierarchical' => $hierarchical,
					'title_li'     => $title,
					'hide_empty'   => $empty,
					'order'        => $order
				);
				$all_categories = get_categories($args);
				foreach ($all_categories as $cat) {
					if ($cat->category_parent == 0) {
						$thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
						$image_url = wp_get_attachment_url($thumbnail_id);
				?>
						<div class="col-12 col-sm-4">
							<div class="card">
								<img class="card-img-top" src="<?php echo $image_url; ?>" alt="">
								<div class="card-img-overlay">
									<h5 class="card-title"><?php echo $cat->name; ?></h5>
									<p class="card-text txt-blur">Danh mục</p>
									<a href="<?php echo get_term_link($cat->slug, 'product_cat'); ?>">XEM <i class="fas fa-chevron-circle-right" aria-hidden="true"></i></a>
								</div>
							</div>
						</div>
				<?php
					}
				}
				?>
			</div>
		</div>
<?php 	}
} ?>