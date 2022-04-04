<?php
get_header(); 
?>
<div class="page-title text-center">
    <h2 class=""><?php _e('Kết quả tìm kiếm', 'isokoma');  ?></h2>
    <img src="https://toragon.vn/wp-content/uploads/2022/01/design-element.png" alt="toragon">
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
                            if (strlen($query) < 2 ){
                            ?>
                            <div class="warning">
                              <p style="color:white;">Vui lòng nhập 2 kí tự trở lên!</p>
                            </div>
                            <div class="search-box d-sm-none mb-3">
                              <?php get_search_form(); ?> 
                            </div>  
                            <?php                              
                            } else {
                                                                   
                            $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
                            $args = array(
                                'posts_per_page'   => 12,   
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
                            <div class="mb-3 search-text"><?php _e('Kết quả tìm kiếm cho từ khóa', 'isokoma'); ?> <b><?php echo $_GET['s']; ?></b></div>                          
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
                                                <div class="add-to-wl"><?php   
                                                  echo do_shortcode( '[woosw id="' . $product->get_id() . '"]');
                                                ?></div>
                                            </div>
                                        </div>
                                    <?php
                                    endwhile;
                                    
                                    ?>
                                  </div>
                                
                                
                              <?php
                              endif;
                              wp_reset_postdata();
                              ?>    
                              <?php } ?>            
                          <?php } else { ?>  
                            <div class="warning">
                              <p style="color:white;">Vui lòng nhập 2 kí tự trở lên!</p>
                            </div>
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