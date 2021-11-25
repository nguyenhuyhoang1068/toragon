<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       ht
 * @since      1.0.0
 *
 * @package    Raise_Prices_With_Time_For_Woocommmerce
 * @subpackage Raise_Prices_With_Time_For_Woocommmerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Raise_Prices_With_Time_For_Woocommmerce
 * @subpackage Raise_Prices_With_Time_For_Woocommmerce/admin
 * @author     Igor Benić <i.benic@hotmail.com>
 */
class Raise_Prices_With_Time_For_Woocommmerce_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Add Settings.
	 * @param $settings
	 * @param $section
	 *
	 * @return array
	 */
	public function add_settings( $settings, $section ) {

		if ( 'cpwt_section' !== $section ) {
			return $settings;
		}

		$settings = array(
			array(
				'title' => __( 'Change Prices with Time', 'woocommerce' ),
				'type'  => 'title',
				'desc'  => '',
				'id'    => 'cpwt_title',
			),
			array(
				'title'         => __( 'Show Countdown on Shop pages', 'woocommerce' ),
				'desc'          => __( 'Show the countdown even on archive and shop pages for each product. This will work for simple products.', 'woocommerce' ),
				'id'            => 'cpwt_show_countdown_on_shop_pages',
				'default'       => 'no',
				'type'          => 'checkbox',
				'checkboxgroup' => 'start',
			),
			array(
				'type' => 'sectionend',
				'id'   => 'cpwt_title',
			),
		);
		return $settings;
	}

	/**
	 * Add Settings Sections
	 * @param $sections
	 *
	 * @return array
	 */
	public function add_settings_section( $sections ) {
		$sections['cpwt_section'] = __( 'Change Prices with Time', 'rpt-wc' );
		return $sections;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( $hook ) {

		if( ! $this->is_product_screen( $hook ) ) {
			return;
		}

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Raise_Prices_With_Time_For_Woocommmerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Raise_Prices_With_Time_For_Woocommmerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rpt-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook ) {

		if( ! $this->is_product_screen( $hook ) ) {
			return;
		}
		
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rps_wc_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rps_wc_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script('jquery-ui-datepicker');
		 
		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rpt-admin.js', array( 'jquery' ), $this->version, true );
		
		wp_enqueue_script(  $this->plugin_name );
		//cpwtfw_fs()->get_upgrade_url()
	}

	private function is_product_screen( $hook ) {
		// We want our script to be loaded only on edit or new post
	 	if( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
	 		return false;
	 	}

		global $post;
	 	
	 	if( ! $post ) {
	 		return false;
	 	}

	 	// We want our script to be loaded only on a product type post
	 	if( 'product' != $post->post_type ) {
	 		return false;
	 	}

	 	return true;
	}

	/**
	 * Template for Prices
	 * @return void 
	 */
	public function wc_product_prices() {
		global $product_object;

		if( ! $product_object ) {
			return;
		}

		$rpt_prices     = RPT_WC_Meta::get( $product_object->get_id() );
		$apply_on_sale  = RPT_WC_Meta::get( $product_object->get_id(), 'rpt_apply_sale' );
		$use_new_layout = RPT_WC_Meta::get( $product_object->get_id(), 'rpt_new_layout' );
		$rpt_name      = 'rpt_wc';
		include 'partials/rpt-admin-prices.php';
		include_once 'partials/js-template.php';
	}

	/**
	 * Saving the Product Prices Data
	 * @param  int $post_id 
	 * @param  WP_Post $post    
	 * @return void          
	 */
	public function wc_product_save( $post_id, $post ) {

		//Get price original
		$product = wc_get_product( $post_id );
		
		$rpt_array = array();
		$rpt_timestamps = RPT_WC_Meta::get( $post_id, '_rpt_timestamps' );
		
		if( ! is_array( $rpt_timestamps ) ) {
			$rpt_timestamps = array();
		}
		
		$offset = get_option('gmt_offset') * 3600;

		$count = 0;

 		$current_timestamp = time();

 		$local_timestamp = $current_timestamp + $offset;
		echo $local_timestamp;
		if( isset( $_POST['rpt_wc'] ) ) {

			foreach ( $_POST['rpt_wc'] as $sale_points ) {

				if( ! $sale_points['date'] ) {
					continue;
				}

				$date_array = explode('-', $sale_points['date'] );

				$time = isset( $sale_points['time'] ) ? $sale_points['time'] . ':00' : '00:00:00';
				
				// Moving from dd-mm-yy to yy-mm-dd
				$sale_points['date'] = $date_array[2] . '-' . $date_array[1] . '-' . $date_array[0];
 
				$rpt_array[ $sale_points['date'] . ' ' . $time ] = $sale_points['price'];
				
				$date = new DateTime( $sale_points['date'] . ' ' . $time );

				$timestamp = $date->getTimestamp();

				if( isset( $rpt_timestamps[ $count ] ) && $rpt_timestamps[ $count ] != $timestamp ) {
					// We have something else, remove the previous timestamp
					wp_unschedule_event( $rpt_timestamps[ $count ] - $offset, 'rpt_wc_increase_price', array( $post_id, $sale_points['price'] ) );
				}

				// Let's unschedule it first just in case
				wp_unschedule_event( $timestamp - $offset, 'rpt_wc_increase_price', array( $post_id, $sale_points['price'] ) );
				
				wp_schedule_single_event( $timestamp - $offset, 'rpt_wc_increase_price', array( $post_id, $sale_points['price'] ) );
				
				$rpt_timestamps[ $count ] = $timestamp;
				$count++;
			}
		}

		// We have more saved then posted
		if( count( $rpt_timestamps ) > $count ) {
			$prices = RPT_WC_Meta::get( $post_id );
			for ( $i = $count; $i < count( $rpt_timestamps ); $i++ ) { 
				$date_time = new DateTime();

				$date_time->setTimestamp( $rpt_timestamps[ $i ] );

				$formatted_date = $date_time->format( 'Y-m-d H:i:s' );

				// Unschedule it
				if( isset( $prices[ $formatted_date ] ) ) {
					wp_unschedule_event( $rpt_timestamps[ $i ] - $offset, 'rpt_wc_increase_price', array( $post_id, $prices[ $formatted_date ] ) );
				}
				unset( $rpt_timestamps[ $count ] );
			}
		}

		// If not set, let's remove them after unscheduled.
		if( ! isset( $_POST['rpt_wc'] ) ) {
			RPT_WC_Meta::delete( $post_id );
		}

		if( $rpt_array ) {
			// Let's sort from first to last
			sort( $rpt_timestamps );

			RPT_WC_Meta::update( $post_id, $rpt_array );
			RPT_WC_Meta::update( $post_id, $rpt_timestamps, '_rpt_timestamps' );
			
		}

		if ( isset( $_POST['rpt_apply_sale'] ) ) {
			RPT_WC_Meta::update( $post_id, 'yes', 'rpt_apply_sale' );			
		} else {
			RPT_WC_Meta::delete( $post_id, 'rpt_apply_sale' );
		}

		if ( isset( $_POST['rpt_new_layout'] ) ) {
			RPT_WC_Meta::update( $post_id, 'yes', 'rpt_new_layout' );
		} else {
			RPT_WC_Meta::delete( $post_id, 'rpt_new_layout' );
		}
	}

}
