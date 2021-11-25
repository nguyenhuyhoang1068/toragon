<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       ht
 * @since      1.0.0
 *
 * @package    Raise_Prices_With_Time_For_Woocommmerce
 * @subpackage Raise_Prices_With_Time_For_Woocommmerce/public
 */

use Simple_Product_Subscriptions\Product;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Raise_Prices_With_Time_For_Woocommmerce
 * @subpackage Raise_Prices_With_Time_For_Woocommmerce/public
 * @author     Igor Benić <i.benic@hotmail.com>
 */
class Raise_Prices_With_Time_For_Woocommmerce_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Add scheme data to cart items that can be purchased on a recurring basis.
	 *
	 * @param  array  $cart_item
	 * @param  int    $product_id
	 * @param  int    $variation_id
	 * @return array
	 */
	public function add_cart_item_data( $cart_item_key ) {

		$cart_contents = WC()->cart->get_cart_contents();
		if ( isset( $cart_contents[ $cart_item_key ] ) ) {
			$cart_contents[ $cart_item_key ]['rpt_price'] = $cart_contents[ $cart_item_key ]['data']->get_price();
		}

		WC()->cart->set_cart_contents($cart_contents);
	}

	/**
	 * Load saved session data of cart items that can be pruchased on a recurring basis.
	 *
	 * @param  array  $cart_item
	 * @param  array  $item_session_values
	 * @return array
	 */
	public function load_cart_item_data_from_session( $cart_item, $item_session_values ) {

		if ( isset( $item_session_values[ 'rpt_price' ] ) ) {
			$cart_item[ 'rpt_price' ] = $item_session_values[ 'rpt_price' ];
		}

		return $cart_item;
	}

	/**
	 * Inspect product-level/cart-level session data and apply subscription schemes on cart items as needed.
	 * Then, recalculate totals.
	 *
	 * @return void
	 */
	public function apply_prices_on_add_to_cart( $item_key, $product_id, $quantity, $variation_id, $variation, $item_data ) {
		$this->apply_prices( WC()->cart );
	}

	/**
	 * Inspect product-level/cart-level session data and apply prices to cart items as needed.
	 *
	 * @param  \WC_Cart  $cart
	 * @return void
	 */
	public function apply_prices( $cart ) {

		foreach ( $cart->cart_contents as $cart_item_key => $cart_item ) {

			if ( isset( $cart_item['rpt_price'] ) ) {
				// Convert the product object to a subscription, if needed.
				$cart->cart_contents[ $cart_item_key ] = $this->apply_price( $cart->cart_contents[ $cart_item_key ] );
			}

		}
	}

	/**
	 * Applies a saved price key to a cart item.
	 *
	 * @param  array  $cart_item
	 * @return array
	 */
	public function apply_price( $cart_item ) {

		$price = $this->get_price( $cart_item );

		if ( $price ) {
			$cart_item['data']->set_price( $price );
		}

		return apply_filters( 'rpt_cart_item_on_apply_price', $cart_item );
	}

	/**
	 * Get Price
	 *
	 * @param $cart_item
	 *
	 * @return integer|string|bool
	 */
	public function get_price( $cart_item ) {
		return isset( $cart_item[ 'rpt_price' ] ) ? $cart_item[ 'rpt_price' ] : false;
	}


	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		global $post;

		$enqueue = false;

		if ( $post && has_shortcode( $post->post_content, 'rpt_wc_countdown' ) ) {
			$enqueue = true;
		}

		if ( 'yes' === get_option( 'cpwt_show_countdown_on_shop_pages', 'no' ) && ( is_post_type_archive( 'product' ) || is_shop() ) ) {
			$enqueue = true;
		}

		if( is_singular( 'product' ) ) {
			$enqueue = true;
		}

		if ( ! $enqueue ) {
			return;
		}

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rpt-wc-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		global $post;

		$enqueue = false;

		if ( $post && has_shortcode( $post->post_content, 'rpt_wc_countdown' ) ) {
			$enqueue = true;
		}

		if ( 'yes' === get_option( 'cpwt_show_countdown_on_shop_pages', 'no' ) && ( is_post_type_archive( 'product' ) || is_shop() ) ) {
			$enqueue = true;
		}
		
		if( is_singular( 'product' ) ) {
			$enqueue = true;
		}

		if ( ! $enqueue ) {
			return;
		}

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rpt-wc-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register Shortcodes.
	 */
	public function register_shortcodes() {
		add_shortcode('rpt_wc_countdown', array( $this, 'shortcode_countdown' ) );
	}

	/**
	 * Show the Product Countdown in shortcode
	 */
	public function shortcode_countdown( $args ) {
		$atts = shortcode_atts( array(
			'id' => 0,
		), $args );

		ob_start();
		if ( absint( $atts['id'] ) ) {
			$product = wc_get_product( absint( $atts['id'] ) );
			if ( $product ) {
				$this->show_product_countdown( $product );
			}
		}

		return ob_get_clean();
	}

	/**
	 * The method that will be called on the CRON 
	 * @param  int $product_id 
	 * @param  int $price      
	 * @return void             
	 */
	public function rpt_increase_price_cron( $product_id, $price ) {
		$product = wc_get_product( $product_id );				
		if( $product ) {
			$apply_on_sale = RPT_WC_Meta::get( $product->get_id(), 'rpt_apply_sale' );
			
			if ( 'yes' === $apply_on_sale && $product->is_on_sale() ) {
				$product->set_sale_price( $price );
			} else {
				$product->set_regular_price( $price );
			}
			$product->save();
		}
	}

	/**
	 * Show the countdown for the single product.
	 */
	public function show_single_product_countdown() {
		global $product;

		$this->show_product_countdown( $product );
	}


	/**
	 * Show the Countdown
	 * @param \WC_Product $product Product Object.
	 *
	 * @return void 
	 */
	public function show_product_countdown( $product ) {
		$different_template = apply_filters( 'rpt_wc_product_countdown_html', null, $product );
		if ( $different_template !== null ) {
			echo $different_template;
			return;
		}

		$product_id     = $product->get_id();
		$rps_prices     = RPT_WC_Meta::get( $product_id );
		$rpt_timestamps = RPT_WC_Meta::get( $product_id, '_rpt_timestamps' );
		$rpt_timestamps = apply_filters( 'rpt_timestamps_for_countdown', $rpt_timestamps, $product_id );
		if( ! $rpt_timestamps ) {
			return;
		}
		
		$now    = current_time( 'timestamp' );
		$offset = get_option('gmt_offset') * 3600;
		$found_new_timestamp = false;
		foreach ( $rpt_timestamps as $timestamp ) {
			// We have a timestamp from future
			if( $now < $timestamp ) {
				$found_new_timestamp = $timestamp - $offset;
				break;
			}
		}

		$rps_prices = apply_filters( 'rpt_prices_for_countdown', $rps_prices, $product_id );
		$timestamps = array();
		if ( ! $rps_prices ) {
			return;
		}

		$new_layout = RPT_WC_Meta::get( $product_id, 'rpt_new_layout' );

		$now = time();
		foreach ( $rps_prices as $date => $price ) {
			$datetime = new DateTime( $date );

			$timestamp = $datetime->getTimestamp();

			$timestamp_offset = $timestamp - $offset;
			if ( $timestamp_offset < $now ) {
				continue;
			}
			$timestamps[ $timestamp_offset ] = wc_price( $price );			
		}

		ksort( $timestamps );

		if( $found_new_timestamp ) {
			$timestamp_with_offset = $found_new_timestamp;			
			echo '<div class="rpt-countdown-container ' . ( $new_layout ? 'new-layout' : '' ) . '" data-timestamps="' . esc_attr( wp_json_encode( $timestamps ) ) . '">';
				$show_only_countdown = apply_filters( 'rpt_wc_show_only_countdown', false );
				if( ! $show_only_countdown && ! $new_layout ) {
					echo '<p class="rpt-price-change-text">' . __( 'The price will change in:', 'rpt-wc' ) . '</p>';
				}
				echo '<div class="rpt-countdown ' . ( $new_layout ? 'new-layout' : '' ) . '" data-timestamp="' . $timestamp_with_offset . '" data-timezone="' . get_option('gmt_offset') . '"></div>';
				if ( $new_layout ) {
					$price = isset( $timestamps[ $found_new_timestamp ] ) ? $timestamps[ $found_new_timestamp ] : '';
					if ( $price ) {						
						echo '<div class="rpt-countdown-price">' . $price . '</div>';
					}
				}
			echo '</div>';
		}

	}

	/**
	 * Show product Countdown on loop item
	 */
	public function show_product_countdown_loop() {
		echo '<div class="rpt-loop-item">';
		$this->show_single_product_countdown();
		echo '</div>';
	}
}
