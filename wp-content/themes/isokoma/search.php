<?php
get_header(); 
?>
<div class="breadcrumbs-area">
    <div class="box-breadcrumb mobile deskstop">
        <div class="banner-text text-center">
            <h2 class="mb-0"><?php _e('Kết quả tìm kiếm', 'isokoma');  ?></h2>
            <div class="d-none d-sm-block"><?php _e('Trang chủ', 'isokoma'); ?> > <?php _e('Sản phẩm', 'isokoma'); ?></div>
        </div>
        <img class="breadcrumb-icon mobile" src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-1.png" alt="">
        <img class="breadcrumb-icon desktop" src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_1.jpg" alt="">
    </div>
</div>


<div class="container">
    <div class="product-category" id="product_search_content">
        <div class="row">
            <div class="col-12 col-sm-12 content-r">                
                <div id="primary" class="content-area">
                    <main id="main" class="site-main" role="main">
                                                   
                        <?php
                        //global $query_string;
                        //wp_parse_str($query_string, $search_args);  
                        $query = get_search_query();                         
                        $query = trim($query);                        
                        $query = preg_replace('/\s\s+/', ' ',$query);             
                      
                          if (!empty($_GET['s'])) {  
                            if (strlen($query) < 3 ){
                            ?>
                            <div class="search-box d-sm-none mb-3">
                              <?php get_search_form(); ?> 
                            </div>  
                            <?php                              
                            } else {
                                                                   
                            $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
                            $args = array(
                                'posts_per_page'   => 8,   
                                'paged'      => $paged,                       
                                'post_type' => array('product'),
                                'post_status' => 'publish',
                                's' => $_GET['s'],    
                                'orderby' => 'title',
                                'order'   => 'ASC',                              
                            );    						
                            $search_query = new WP_Query($args);                                                 
                            ?>   
                            <div class="search-box d-sm-none mb-3">
                              <?php get_search_form(); ?> 
                            </div>  
                            <div class="mb-3"><?php _e('Kết quả tìm kiếm cho từ khóa', 'isokoma'); ?> <b><?php echo $_GET['s']; ?></b></div>                          
                            <?php                            
                                $total_results = $search_query->found_posts ? $search_query->found_posts : 0;                                                                                                               
                            ?>
                              <div class="row">
                                <?php
                                if ($search_query->have_posts()) :
                                ?>
                                    <?php
                                    while ($search_query->have_posts()) :
                                        $search_query->the_post();
                                        global $product;
                                    ?>
                                        <div class="col-12 col-sm-3 p-item">
                                            <div class="card box-product">
                                                <div class="wrap-img">
                                                    <?php global $post;  ?>
                                                    <?php
                                                    $thumb_id = get_post_thumbnail_id();
                                                    $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'isokoma-banner-500', true);
                                                    $thumb_url = $thumb_url_array[0];
                                                    ?>                                                                                              
                                                    <a href="<?php echo get_permalink( $search_query->post->ID ) ?>" title="<?php echo esc_attr($search_query->post->post_title ? $search_query->post->post_title : $search_query->post->ID); ?>">		
                                                        <img src="<?php echo $thumb_url ?>"  />
                                                    </a>	
                                                </div>
                                                <div class="card-body">
                                                    <?php if ($product->single_add_to_cart_text() === 'Pre-Order')  : ?>
                                                        <div class="pre-order">
                                                            <?php echo 'Pre-Order' ; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    <h3 class="product-name">
                                                        <a href="<?php echo get_permalink($search_query->post->ID) ?>" title="<?php echo esc_attr($search_query->post->post_title ? $search_query->post->post_title : $search_query->post->ID); ?>"><?php the_title(); ?> </a>
                                                    </h3>
                                                    <p class="text-center txt-blur small">
                                                        <b><?php echo get_post_meta($search_query->post->ID, 'custom_text_field_size', TRUE); ?></b>
                                                    </p>
                                                    <p class="text-center txt-blur small">
                                                        <?php echo $product->get_price_html(); ?>
                                                    </p>
                                                    <?php
                                                        add_action( 'isokoma_single_product_out_of_stock', 'isokoma_out_of_stock',		10 );
                                                        do_action( 'isokoma_single_product_out_of_stock' );
                                                    ?>
                                                    <?php 								
                                                        wp_commerce_template_single_add_to_cart();								
                                                    ?>		
                                                </div>
                                                <?php   
                                                  echo do_shortcode( '[woosw id="' . $product->get_id() . '"]');
                                                ?>
                                            </div>
                                        </div>
                                    <?php
                                    endwhile;
                                    
                                    ?>
                                  </div>
                                
                                  <!-- /.row -->
                                  <nav class="woocommerce-pagination">
                                          <?php
                                          $total_pages = $search_query->max_num_pages;
                                          if($total_pages > 20) {
                                            $total_pages = 20;
                                          }
                                          $current_page = max(1, get_query_var('paged'));    
                                          if ($total_pages > 1){
                                              $pages = paginate_links( array(
                                                  'base'  => str_replace(10, '%#%', esc_url(get_pagenum_link( 10))),
                                                  'format'    => '/page/%#%',
                                                  'current'   => $current_page,
                                                  'total'     => $total_pages,
                                                  'type'      => 'array',
                                                  'show_all'  => false,
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
                              <?php } ?>            
                          <?php } else { ?>  
                            <div class="search-box d-sm-none mb-3">
                              <?php get_search_form(); ?> 
                            </div>       
                          <?php } ?>                      
                    </main><!-- #main -->
                </div>
            </div>
        </div>
    </div>
</div>


<?php
get_footer();
?>
<script>
  jQuery('button#close').one('click', function(e) {
    document.getElementById('min-character').innerHTML = "Nhập 3 ký tự trở lên";
  });
  // jQuery('button#close').click(function(){
  //   if(jQuery('#search-form').val() == ''){
  //     console.log("abc");
  //   }
  // });
</script>