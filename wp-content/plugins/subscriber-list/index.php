<?php
/*
Plugin Name: Subscribe Forms
Plugin URI: https://patroids.com
Description: Add beautiful and elegant subscribe forms.
Author: Premio
Text Domain: subscribe-forms
Domain Path: /languages
Author URI: https://patroids.com
Version: 1.5.4
License: GplV2
*/


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



add_action('admin_menu', 'ytp_custom_menu_subscriber_pages');


function ytp_custom_menu_subscriber_pages() {	
  add_menu_page( 
    'Subscriber List', 
    'Subscriber List', 
    'edit_posts', 
    'ytp_subcriber_list', 
    'ytp_custom_pages', 
    'dashicons-media-spreadsheet' 
   );	
	
}

function ytp_custom_pages () {   
?>
  <div id="wpappp-popup-tab-content4" class="wpappp-popup-tab-content wrap">
        <h1>
          <?php 
            esc_html_e( 'Subscriber List', 'yewteepoint' ); 	
          ?>   
        </h1>        
        <p class="description"><strong>Subscriber's data is saved locally do make backup or export before uninstalling plugin</strong></p>
        <div>
            <table id="upc_subscriber_tab">
                <tr>
                    <td><strong>Download & Export All Subscriber to CSV file: </strong></td>
                    <td><a href="<?php echo plugins_url('includes/sytp_subscriber_list.php?download_file=sytp_subcribers_list.csv',__FILE__); ?>" class="wpappp_buton" id="wpappp_export_to_csv" value="Export to CSV" href="#">Download & Export to CSV</a></td>
                    <td><strong>Delete All Subscibers from Database: </strong></td>
                    <td><input type="button" class="wpappp_buton" id="sfba_delete_all_data" value="Delete All Data" /></td>
                </tr>
            </table>
        </div>
        <div>
            <?php
            global $wpdb;
            $table_name = $wpdb->prefix . "sfba_subscribers_lists";
            $result = $wpdb->get_results ( "SELECT * FROM ".$table_name );
            if( $result ) { ?>
                <table border="1" class="responstable">
                    <tr>
                        <th width="15%">ID</th>
                        <th width="15%">Name</th>
                        <th width="25%">Email</th>
                        <th width="20%">Date</th>
                        <th width="25%">Edit</th>
                    </tr>
                    <?php
                    foreach ( $result as $print ) { ?>
                        <tr>
                            <td><?php echo $print->id;?></td>
                            <td><?php echo $print->name;?></td>
                            <td><?php echo $print->email;?></td>
                            <td>
                                <?php
                                if ( $print->page_link ) : ?>                                    
                                    <?php echo $print->page_link;?>
                                    <img width="20" height="20" src="<?php echo esc_url(plugin_dir_url(__FILE__)."images/link_icon.png") ?>" />                                    
                                <?php endif;?>
                            </td>
                            <td><input type="button" data-delete="<?php echo $print->id;?>" class="upc_delete_entry wpappp_buton sfba_delete_entry" id="upc_delete_entry" value="Delete Record" style="margin:0 auto;display:block;"/>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else {
                ?><p style="font-size: 18px;font-weight: bold;margin: 0 auto;">No Subscriber Found!</p><?php
            }
            ?>
        </div>

    </div>

  
<?php
}


add_action('admin_enqueue_scripts',  'ytp_custom_menu_subscriber_style');
function ytp_custom_menu_subscriber_style() {  
  wp_enqueue_style('subscriber_style' , plugin_dir_url( __FILE__ ) . 'css/subscriber.css', array(), 'all' );	  
  //wp_enqueue_script( 'subscriber_script', plugin_dir_url( __FILE__ ) .'js/subscriber.js', array(), '3.0');  
}



function subscriber_ajax_load_scripts() {	
	wp_register_script( 'sfba-form-ajax', plugin_dir_url( __FILE__ ) . 'js/subscriber.js', array( 'jquery' ) );
	wp_localize_script( 'sfba-form-ajax', 'the_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ),'ajax_nonce' => wp_create_nonce('sfba') ) );		
	wp_enqueue_script( 'sfba-form-ajax');

}
add_action('wp_print_scripts', 'subscriber_ajax_load_scripts');


function sytp_delete_db_record(){
	
	check_ajax_referer( 'sfba', 'wpnonce' );
    $id = sanitize_text_field($_POST['id']);
    global $wpdb;
    $table  = $wpdb->prefix . 'sfba_subscribers_lists';
	$delete_sql = $wpdb->prepare("DELETE FROM {$table} WHERE id = %d",$id);
    $delete = $wpdb->query( $delete_sql );		

    wp_die();
}

add_action('wp_ajax_sfba_delete_db_record', 'sytp_delete_db_record');
add_action('wp_ajax_nopriv_sfba_delete_db_record', 'sytp_delete_db_record');



function sytp_delete_db_data(){
  global $wpdb;
check_ajax_referer( 'sfba', 'wpnonce' );
  $table  = $wpdb->prefix . 'sfba_subscribers_lists';
  $delete = $wpdb->query("TRUNCATE TABLE $table");
  wp_die();

}
add_action('wp_ajax_sfba_delete_db_data', 'sytp_delete_db_data');
add_action('wp_ajax_nopriv_sfba_delete_db_data', 'sytp_delete_db_data');

?>



 
