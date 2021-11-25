<?php
get_header();
?>
<div class="breadcrumbs-area">
    <div class="box-breadcrumb mobile deskstop">      
      <div class="banner-text text-center">
        <h2 class="mb-0"><?php _e('TIN TỨC', 'isokoma') ?></h2>
        <div class="d-none d-sm-block"><?php _e('Trang chủ', 'isokoma');  echo ' > ';  _e('Tin Tức', 'isokoma')  ?></div>
      </div>
      <img class="breadcrumb-icon mobile" src="<?php echo get_stylesheet_directory_uri()   ?>/images/icon-1.png" alt="">
			<img class="breadcrumb-icon desktop" src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_1.jpg" alt="">      
    </div>
</div>


<div class="container">
    <div class="col-sm-8 col-xs-12 offset-sm-2">
        <div id="primary" class="content-area-blog">
            <h1><?php echo get_the_title(); ?></h1>
            <main id="main" class="site-main">
                <?php if (has_post_thumbnail( $post->ID ) ): ?>
                    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
                    <div id="custom-image-thumb">
                        <img src="<?php echo $image[0]; ?>"  />
                    </div>
                <?php endif; ?>
                <span class="time">                    
                    <?php echo get_the_time( 'd' ); ?>/<?php echo get_the_time( 'm' ); ?>/<?php echo get_the_time( 'Y' );  ?>
                </span>                
                <?php echo get_the_content(); ?>            
            </main>
        </div>
    </div>
</div>

<?php
get_footer();
?>
