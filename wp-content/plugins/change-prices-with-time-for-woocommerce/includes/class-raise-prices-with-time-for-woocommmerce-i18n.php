<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       ht
 * @since      1.0.0
 *
 * @package    Raise_Prices_With_Time_For_Woocommmerce
 * @subpackage Raise_Prices_With_Time_For_Woocommmerce/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Raise_Prices_With_Time_For_Woocommmerce
 * @subpackage Raise_Prices_With_Time_For_Woocommmerce/includes
 * @author     Igor Benić <i.benic@hotmail.com>
 */
class Raise_Prices_With_Time_For_Woocommmerce_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'rpt-wc',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
