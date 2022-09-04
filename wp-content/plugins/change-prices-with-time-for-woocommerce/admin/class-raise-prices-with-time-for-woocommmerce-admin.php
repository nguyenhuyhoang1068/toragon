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

	protected $prices = [];

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

	public function is_admin_screen( $hook ) {
		if ( 'woocommerce_page_wc-settings' !== $hook ) {
			return false;
		}

		if ( isset( $_GET['tab'] ) && $_GET['tab'] === 'rpt' ) {
			return true;
		}

		return false;
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook ) {

		if( ! $this->is_product_screen( $hook ) && ! $this->is_admin_screen( $hook ) ) {
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

		$rpt_array = array();
		$prices = RPT_WC_Meta::get( $post_id );
		$rpt_timestamps = RPT_WC_Meta::get( $post_id, '_rpt_timestamps' );

		if( ! is_array( $rpt_timestamps ) ) {
			$rpt_timestamps = array();
		}
		
		$offset = get_option('gmt_offset') * 3600;

		$count = 0;

 		$current_timestamp = time();

 		$local_timestamp = $current_timestamp + $offset;

 		// Unschedule everything before adding new?
		if ( $prices ) {
			foreach ( $prices as $datetime_price => $price ) {
				$date = new DateTime( $datetime_price );

				$timestamp = $date->getTimestamp();
				wp_unschedule_event( $timestamp - $offset, 'rpt_wc_increase_price', array( $post_id, $price ) );
				wp_unschedule_event( $timestamp, 'rpt_wc_increase_price', array( $post_id, $price ) );
			}
		}

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

	/**
	 * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
	 *
	 * @uses woocommerce_update_options()
	 * @uses self::get_settings()
	 * @since 1.0
	 */
	public function update_settings() {

		if ( empty( $_POST['_wcsnonce'] ) || ! wp_verify_nonce( $_POST['_wcsnonce'], 'wc_rpt_settings' ) ) {
			return;
		}

		$settings = self::get_settings();

		foreach ( $settings as $setting ) {
			if ( ! isset( $setting['id'], $setting['default'], $_POST[ $setting['id'] ] ) ) {
				continue;
			}

			// Set the setting to its default if no value has been submitted.
			if ( '' === wc_clean( $_POST[ $setting['id'] ] ) ) {
				$_POST[ $setting['id'] ] = $setting['default'];
			}
		}

		woocommerce_update_options( $settings );

		$saved_bulk_products_scheduled_events = get_option( 'rpt_bulk_product_events', array() );

		if ( $saved_bulk_products_scheduled_events ) {
		    foreach ( $saved_bulk_products_scheduled_events as $event ) {
			    wp_unschedule_event( $event['timestamp'], $event['hook'], $event['args'] );
		    }
        }

		$bulk_products = ! empty( $_POST['rpt_bulk_products'] ) ? $_POST['rpt_bulk_products'] : array();

		if ( $bulk_products ) {
			$bulk_products_scheduled_events = array();

			$offset = get_option('gmt_offset') * 3600;
			$count  = 0;
			$current_timestamp = time();
			$local_timestamp = $current_timestamp + $offset;

			foreach ( $bulk_products as $sale_points ) {
				if( ! $sale_points['date'] ) {
					continue;
				}

				if( ! $sale_points['product_ids'] ) {
					continue;
				}

				$date_array = explode('-', $sale_points['date'] );

				$time = isset( $sale_points['time'] ) ? $sale_points['time'] . ':00' : '00:00:00';

				// Moving from dd-mm-yy to yy-mm-dd
				$sale_points['date'] = $date_array[2] . '-' . $date_array[1] . '-' . $date_array[0];

				$rpt_array[ $sale_points['date'] . ' ' . $time ] = $sale_points['price'];

				$date = new DateTime( $sale_points['date'] . ' ' . $time );

				$timestamp = $date->getTimestamp();

				foreach ( $sale_points['product_ids'] as $product_id ) {
				    $product_id = absint( $product_id );
					// Let's unschedule it first just in case
					wp_unschedule_event( $timestamp - $offset, 'rpt_wc_increase_price', array( $product_id, $sale_points['price'] ) );

					wp_schedule_single_event( $timestamp - $offset, 'rpt_wc_increase_price', array( $product_id, $sale_points['price'] ) );

					$bulk_products_scheduled_events[] = array(
                        'timestamp' => $timestamp - $offset,
                        'hook'      => 'rpt_wc_increase_price',
                        'args'      => array(
                            $product_id,
	                        $sale_points['price']
                        ),
                    );
				}
			}

			update_option( 'rpt_bulk_product_events', $bulk_products_scheduled_events );
        }
	}

	/**
	 * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
	 *
	 * @uses woocommerce_admin_fields()
	 * @uses self::get_settings()
	 * @since 1.0
	 */
	public function settings_page() {
		woocommerce_admin_fields( self::get_settings() );
		wp_nonce_field( 'wc_rpt_settings', '_wcsnonce', false );
	}

	/**
	 * Get all the settings for the Subscriptions extension in the format required by the @see woocommerce_admin_fields() function.
	 *
	 * @return array Array of settings in the format required by the @see woocommerce_admin_fields() function.
	 * @since 1.0
	 */
	public static function get_settings() {

		return apply_filters( 'rpt_settings', array(

			array(
				'name'          => _x( 'Bulk Edit', 'option section heading', 'woocommerce-subscriptions' ),
				'type'          => 'title',
				'desc'          => '',
				'id'            =>'rpt_renewal_options',
			),

			array(
				'name'            => __( 'Products', 'woocommerce-subscriptions' ),
				'id'              => 'rpt_bulk_products',
				'type'            => 'rpt_bulk_edit',
			),

			array( 'type' => 'sectionend', 'id' => '_renewal_options' ),


		) );

	}


	/**
	 * Add the Subscriptions settings tab to the WooCommerce settings tabs array.
	 *
	 * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
	 * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
	 * @since 1.0
	 */
	public function add_settings_tab( $settings_tabs ) {

		$settings_tabs[ 'rpt' ] = __( 'Change Prices with Time', 'rpt' );

		return $settings_tabs;
	}


	public function buld_edit_field( $field ) {

		$prices     = get_option( 'rpt_bulk_products', [] ); //[];//RPT_WC_Meta::get( $product_object->get_id() );
		$apply_on_sale  = []; //RPT_WC_Meta::get( $product_object->get_id(), 'rpt_apply_sale' );
		$use_new_layout = []; //RPT_WC_Meta::get( $product_object->get_id(), 'rpt_new_layout' );
		$rpt_name      = 'rpt_bulk_products';
		// Hook into table to add input for products
		$field_name_layout = false;
		$field_name_sale = false;

        $rpt_prices = array();
        $this->prices = $prices;

        foreach ( $prices as $price ) {
            $rpt_prices[ $price['date'] . ' ' . $price['time'] . ':00' ] = $price['price'];
        }

        add_action( 'rpt_wc_table_th_start', array( $this, 'table_th_start' ) );
		add_action( 'rpt_wc_table_td_start', array( $this, 'table_td_start' ), 20, 2 );
        add_action( 'rpt_wc_table_td_template_start', array( $this, 'table_td_template_start' ) );
		?>
		<tr>
			<td colspan="2">
                <div style="background:white;padding: 20px;">
				<?php

				include 'partials/rpt-admin-prices.php';
				include_once 'partials/js-template.php';
				?>
                </div>
			</td>
		</tr>
		<?php
		remove_action( 'rpt_wc_table_th_start', array( $this, 'table_th_start' ) );

		// unHook into table to remove input for products
	}

	public function table_th_start(){
        ?>
        <th>
            <?php esc_html_e( 'Product', 'rpt' ); ?>
        </th>
        <?php
    }

    public function table_td_start( $count, $name ) {

	    $field_name =  $name . '[' . $count . '][product_ids][]';

	    $action = apply_filters( 'rtp_bulk_edit_products_search_ajax_action', 'woocommerce_json_search_products' );


	    ?>
        <td>
            <select class="wc-product-search" multiple="multiple" style="width: 50%;" name="<?php echo $field_name; ?>" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'woocommerce' ); ?>" data-action="<?php echo esc_attr( $action ); ?>">
                <?php
                    if ( isset( $this->prices[ $count ] ) ) {
                        $product_ids = ! empty( $this->prices[ $count ]['product_ids'] ) ? $this->prices[ $count ]['product_ids'] : [];
	                    foreach ( $product_ids as $product_id ) {
		                    $product = wc_get_product( $product_id );
		                    if ( is_object( $product ) ) {
			                    echo '<option value="' . esc_attr( $product_id ) . '"' . selected( true, true, false ) . '>' . esc_html( wp_strip_all_tags( $product->get_formatted_name() ) ) . '</option>';
		                    }
	                    }
                    }
                ?>
            </select>
        </td>
	    <?php
    }

    public function table_td_template_start() {
	    $this->table_td_start( '{{data.length}}', '{{data.name}}');
    }
}
