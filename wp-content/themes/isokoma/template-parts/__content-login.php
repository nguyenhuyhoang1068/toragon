<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package isokoma
 */
?>



<div class="breadcrumbs-area">
  <div class="box-breadcrumb">
    <img src="<?php echo get_stylesheet_directory_uri()   ?>/images/product_banner_1.jpg" alt="image">
    <div class="banner-text text-center">
      <h2 class="mb-0"><?php the_title(); ?></h2>
      <div class="d-none d-sm-block"><?php do_action( 'isokoma_breadcrumb' ); ?></div>
    </div>
  </div>
</div>


<div id="user_login_content" class="container">
<h5 class="mt-5"><?php _e('ĐĂNG NHẬP'); ?></h5>
<div id="login-register-password">
	<?php global $user_ID, $user_identity; if (!$user_ID) { ?>
		<form method="post" action="<?php bloginfo('url') ?>/wp-login.php" class="mb-3">
        <div class="form-group">          
          <input type="text" name="log" value="" size="20" id="user_login" class="form-control shadow-none" placeholder="Tên đăng nhập"/>          
        </div>
				<div class="form-group">			
          <input type="password" name="pwd" value="" size="20" id="user_pass" class="form-control shadow-none" placeholder="Mật khẩu" />							
				</div>				
				<div class="login_fields">					
					<?php do_action('login_form'); ?>          
					<input type="submit" class="btn btn-secondary" name="user-submit" value="<?php _e('Đăng nhập'); ?>" class="user-submit" />
					<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
					<input type="hidden" name="user-cookie" value="1" />
				</div>
		</form>
	<?php } else { // is logged in ?>

	<div class="sidebox">
		<h3>Welcome, <?php echo $user_identity; ?></h3>
		<div class="usericon">
			<?php global $userdata; echo get_avatar($userdata->ID, 60); ?>
		</div>
		<div class="userinfo">
			<p>You&rsquo;re logged in as <strong><?php echo $user_identity; ?></strong></p>
			<p>
				<a href="<?php echo wp_logout_url('index.php'); ?>">Log out</a> | 
				<?php if (current_user_can('manage_options')) { 
					echo '<a href="' . admin_url() . '">' . __('Admin') . '</a>'; } else { 
					echo '<a href="' . admin_url() . 'profile.php">' . __('Profile') . '</a>'; } ?>
			</p>
		</div>
	</div>
	<?php } ?>
</div>
</div>
