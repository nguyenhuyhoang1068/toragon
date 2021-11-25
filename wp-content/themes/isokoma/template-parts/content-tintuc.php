<?php 
if ($post->ID  == 323) : ?>
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
  $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
  $args = array(
    'posts_per_page'      => 6,
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'paged'      => $paged, 
    'ignore_sticky_posts' => 1,
    'order'               => 'DESC',  
  );
?>
<div id="new_content" class="container">
	<div class="row">			
			<?php
			$loop = new WP_Query( $args );
			if ($loop->have_posts()) :
			while ( $loop->have_posts() ) : $loop->the_post(); 	 ?>				
				<div class="col-12 col-sm-4 new-item">
					<div class="card box-news">
						<div class="wrap-img">
							<?php global $post; ?>
							<?php 
								$thumb_id = get_post_thumbnail_id();
								$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'isokoma-banner-500', true);
								$thumb_url = $thumb_url_array[0];
							?>													
							<a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">		
								<img src="<?php echo $thumb_url ?>"  />
							</a>
						</div>
						<div class="card-body">				
              <h2>
                <a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">		
                  <?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>
                </a>
              </h2>
              <span class="des">
                <?php the_excerpt() ?>
              </span>	
              <span class="time"><?php echo get_the_date('d/m/Y',$loop->post->ID); ?></span>							
            </div>		
          </div>											
        </div>
      <?php endwhile; ?>
						
  </div>	
<nav class="woocommerce-pagination">
	<?php
	$total_pages = $loop->max_num_pages;
	$current_page = max(1, get_query_var('paged'));    
	if ($total_pages > 1){
		$pages = paginate_links( array(
			'base'  => str_replace(9999999999, '%#%', esc_url(get_pagenum_link( 9999999999))),
			'format'    => '/page/%#%',
			'current'   => $current_page,
			'total'     => $total_pages,
			'type'      => 'array',
			'show_all'  => true,
			'end_size'  => 2,
			'mid_size'  => 1,
			'prev_next' => true,
			'prev_text' => 'First',
			'next_text' => 'Last',
			'add_args'  => false,
			'add_fragment'  => ''
		));
		if(is_array($pages)){                                                
			$pagination = '<ul class="pagination justify-content-center box-pagination page-numbers">';
			foreach($pages as $page){
					$pagination .= '<li'. (strpos($page,'current')!== false ? ' class="active page-item" ':' class="page-item" ') .'>';                                                            
					if(strpos($page,'current')!== false){
							if(get_query_var( 'paged' )>1){
									$pagination .='<span aria-current="page" class="page-numbers current">'.get_query_var( 'paged' ).'</span>';
							}else{
									$pagination .= '<span aria-current="page" class="page-numbers current">'. 1 .'</span>';
							}       
					}else{
							$pagination .= str_replace('class="page-link"','',$page);
					}
					$pagination .='</li>';
			}
			// $pagination  .=   
			$pagination .= '</ul>';
			echo $pagination;
		}
	}                                        
	//isokoma_custom_pagination();
	?>
							
</nav>
<?php
endif;
wp_reset_postdata();
?>    
</div>
