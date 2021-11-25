<?php
/**
 * Add meta box
 *
 * @param post $post The post object
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/add_meta_boxes
 */
function hyperlink_add_meta_boxes( $post ){
	add_meta_box( 'hyperlink_meta_box', __( 'Carousel', 'hyperlink_metabox' ), 'hyperlink_build_meta_box', 'carousel', 'normal', 'low' );
}

add_action( 'add_meta_boxes', 'hyperlink_add_meta_boxes' );
/**
 * Build custom field meta box
 *
 * @param post $post The post object
 */
function hyperlink_build_meta_box( $post ){
	// make sure the form request comes from WordPress
	wp_nonce_field( basename( __FILE__ ), 'hyperlink_meta_box_nonce' );
	$post_type = get_post_type();
    $date = get_post_meta( $post->ID, '_date', true );
	$url = get_post_meta( $post->ID, '_url', true );
	$mobile_banner = get_post_meta( $post->ID, '_mobile_banner', true );
  $video_upload = get_post_meta( $post->ID, '_video_upload', true );
  $youtubeurl = get_post_meta( $post->ID, '_youtubeurl', true );
  if($post_type == 'carousel'){
	?>
		 <p>
			<label for="url"><?php _e( 'URL', 'hyperlink_metabox' ); ?></label>
			<br>
			<input type="text" name="url"  class="meta-url large-text" value="<?php echo $url; ?>">
    </p>   
    <p>
			<label for="mobile_banner"><?php _e( 'Banner', 'hyperlink_metabox' ); ?></label>
			<br>
      <input type="text" name="mobile_banner"  class="meta-mobile_banner regular-text" value="<?php echo $mobile_banner; ?>">
      <input type="button" class="button url-upload" value="Browse">
      <div class="image-preview"><img src="<?php echo $mobile_banner; ?>" style="max-width: 400px;"></div>
    </p>  

    <p>
			<label for="url"><?php _e( 'Youtube ID', 'hyperlink_metabox' ); ?></label>
			<br>
			<input type="text" name="youtubeurl"  class="meta-url large-text" value="<?php echo $youtubeurl; ?>">
    </p>   
    <p>
			<label for="video_upload"><?php _e( 'Video Upload', 'hyperlink_metabox' ); ?></label>
			<br>
      <input type="text" name="video_upload"  class="meta-video_upload regular-text" value="<?php echo $video_upload; ?>">
      <input type="button" class="button url-upload-video" value="Browse">      
    </p>  
    <script>
        jQuery(document).ready(function($) {
          // Instantiates the variable that holds the media library frame.
          var meta_url_frame;
          var meta_video_frame;
          // Runs when the pdf button is clicked.
          $('.url-upload').on('click',function(e) {
            e.preventDefault();
            // Get preview pane

            var meta_image_preview = $(this)
              .parent()
              .parent()
              .children('.image-preview')
           
            var meta_url = $(this)
              .parent()
              .children('.meta-mobile_banner')

            // If the frame already exists, re-open it.
            if (meta_url_frame) {
              meta_url_frame = null;
            }

            // Sets up the media library frame
            meta_url_frame = wp.media({
              title: 'URL',
              button: {
                text: 'Select',
              },
              multiple: false
            })
            // Runs when an pdf is selected.
            meta_url_frame.on('select', function() {
              // Grabs the attachment selection and creates a JSON representation of the model.
              var media_attachment = meta_url_frame
                .state()
                .get('selection')
                .first()
                .toJSON()
              // Sends the attachment URL to our custom pdf input field.
              meta_url.val(media_attachment.url.replace(/https?:\/\/[^\/]+/i, ""))
              meta_image_preview.children('img').attr('src', media_attachment.url.replace(/https?:\/\/[^\/]+/i, ""))
            })
            // Opens the media library frame.
            meta_url_frame.open()
          })

          $('.url-upload-video').on('click',function(e) {
            e.preventDefault();
            // Get preview pane

            var meta_image_preview = $(this)
              .parent()
              .parent()
              .children('.image-preview')
           
            var meta_url = $(this)
              .parent()
              .children('.meta-video_upload')

            // If the frame already exists, re-open it.
            if (meta_video_frame) {
              meta_video_frame = null;
            }

            // Sets up the media library frame
            meta_video_frame = wp.media({
              title: 'URL',
              button: {
                text: 'Select',
              },
              multiple: false
            })
            // Runs when an pdf is selected.
            meta_video_frame.on('select', function() {
              // Grabs the attachment selection and creates a JSON representation of the model.
              var media_attachment = meta_video_frame
                .state()
                .get('selection')
                .first()
                .toJSON()
              // Sends the attachment URL to our custom pdf input field.
              meta_url.val(media_attachment.url.replace(/https?:\/\/[^\/]+/i, ""))
              meta_image_preview.children('img').attr('src', media_attachment.url.replace(/https?:\/\/[^\/]+/i, ""))
            })
            // Opens the media library frame.
            meta_video_frame.open()
          })

        })
    </script>
	<?php } ?>
	
	<?php
	}

/**
 * Store custom field meta box data
 *
 * @param int $post_id The post ID.
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/save_post
 */

function hyperlink_save_meta_box_data( $post_id ){
	// verify meta box nonce
	if ( !isset( $_POST['hyperlink_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['hyperlink_meta_box_nonce'], basename( __FILE__ ) ) ){
		return;
	}
	// return if autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
		

		if ( isset( $_REQUEST['url'] ) ) {
			update_post_meta( $post_id, '_url', sanitize_text_field( $_POST['url'] ) );
    }
    
    if ( isset( $_REQUEST['mobile_banner'] ) ) {
			update_post_meta( $post_id, '_mobile_banner', sanitize_text_field( $_POST['mobile_banner'] ) );
		}

    if ( isset( $_REQUEST['youtubeurl'] ) ) {
			update_post_meta( $post_id, '_youtubeurl', sanitize_text_field( $_POST['youtubeurl'] ) );
    }
    
    if ( isset( $_REQUEST['video_upload'] ) ) {
			update_post_meta( $post_id, '_video_upload', sanitize_text_field( $_POST['video_upload'] ) );
		}
	}
  // Check the user's permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ){
		return;
	}
		
	// store custom fields values
	if ( isset( $_REQUEST['url'] ) ) {
		update_post_meta( $post_id, '_url', sanitize_text_field( $_POST['url'] ) );
  }
  // store custom fields values
	if ( isset( $_REQUEST['mobile_banner'] ) ) {
		update_post_meta( $post_id, '_mobile_banner', sanitize_text_field( $_POST['mobile_banner'] ) );
	}

  // store custom fields values
	if ( isset( $_REQUEST['youtubeurl'] ) ) {
		update_post_meta( $post_id, '_youtubeurl', sanitize_text_field( $_POST['youtubeurl'] ) );
  }
  // store custom fields values
	if ( isset( $_REQUEST['video_upload'] ) ) {
		update_post_meta( $post_id, '_video_upload', sanitize_text_field( $_POST['video_upload'] ) );
	}

}
add_action( 'save_post', 'hyperlink_save_meta_box_data' );