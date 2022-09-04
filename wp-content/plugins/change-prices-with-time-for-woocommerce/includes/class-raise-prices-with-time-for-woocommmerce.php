<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       ht
 * @since      1.0.0
 *
 * @package    Raise_Prices_With_Time_For_Woocommmerce
 * @subpackage Raise_Prices_With_Time_For_Woocommmerce/includes
 */


if ( ! class_exists( 'Raise_Prices_With_Time_For_Woocommmerce' ) ) {
	/**
	 * The core plugin class.
	 *
	 * This is used to define internationalization, admin-specific hooks, and
	 * public-facing site hooks.
	 *
	 * Also maintains the unique identifier of this plugin as well as the current
	 * version of the plugin.
	 *
	 * @since      1.0.0
	 * @package    Raise_Prices_With_Time_For_Woocommmerce
	 * @subpackage Raise_Prices_With_Time_For_Woocommmerce/includes
	 * @author     Igor Benić <i.benic@hotmail.com>
	 */
	class Raise_Prices_With_Time_For_Woocommmerce {

		/**
		 * The loader that's responsible for maintaining and registering all hooks that power
		 * the plugin.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      Raise_Prices_With_Time_For_Woocommmerce_Loader $loader Maintains and registers all hooks for the plugin.
		 */
		protected $loader;

		/**
		 * The unique identifier of this plugin.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      string $plugin_name The string used to uniquely identify this plugin.
		 */
		protected $plugin_name;

		/**
		 * The current version of the plugin.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      string $version The current version of the plugin.
		 */
		protected $version;

		/**
		 * Define the core functionality of the plugin.
		 *
		 * Set the plugin name and the plugin version that can be used throughout the plugin.
		 * Load the dependencies, define the locale, and set the hooks for the admin area and
		 * the public-facing side of the site.
		 *
		 * @since    1.0.0
		 */
		public function __construct() {

			$this->plugin_name = 'raise-prices-with-time-for-woocommmerce';
			$this->version     = '1.8.2';

			$this->load_dependencies();
			$this->set_locale();
			$this->define_admin_hooks();
			$this->define_public_hooks();

		}

		/**
		 * Load the required dependencies for this plugin.
		 *
		 * Include the following files that make up the plugin:
		 *
		 * - Raise_Prices_With_Time_For_Woocommmerce_Loader. Orchestrates the hooks of the plugin.
		 * - Raise_Prices_With_Time_For_Woocommmerce_i18n. Defines internationalization functionality.
		 * - Raise_Prices_With_Time_For_Woocommmerce_Admin. Defines all hooks for the admin area.
		 * - Raise_Prices_With_Time_For_Woocommmerce_Public. Defines all hooks for the public side of the site.
		 *
		 * Create an instance of the loader which will be used to register the hooks
		 * with WordPress.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function load_dependencies() {

			/**
			 * The class responsible for orchestrating the actions and filters of the
			 * core plugin.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-raise-prices-with-time-for-woocommmerce-loader.php';

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rpt-meta.php';

			/**
			 * The class responsible for defining internationalization functionality
			 * of the plugin.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-raise-prices-with-time-for-woocommmerce-i18n.php';

			/**
			 * The class responsible for defining all actions that occur in the admin area.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-raise-prices-with-time-for-woocommmerce-admin.php';

			/**
			 * The class responsible for defining all actions that occur in the public-facing
			 * side of the site.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-raise-prices-with-time-for-woocommmerce-public.php';

			$this->loader = new Raise_Prices_With_Time_For_Woocommmerce_Loader();
		}

		/**
		 * Define the locale for this plugin for internationalization.
		 *
		 * Uses the Raise_Prices_With_Time_For_Woocommmerce_i18n class in order to set the domain and to register the hook
		 * with WordPress.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function set_locale() {

			$plugin_i18n = new Raise_Prices_With_Time_For_Woocommmerce_i18n();

			$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

		}

		/**
		 * Register all of the hooks related to the admin area functionality
		 * of the plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function define_admin_hooks() {

			$plugin_admin = new Raise_Prices_With_Time_For_Woocommmerce_Admin( $this->get_plugin_name(), $this->get_version() );

			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
			$this->loader->add_action( 'woocommerce_product_options_pricing', $plugin_admin, 'wc_product_prices' );
			$this->loader->add_action( 'woocommerce_process_product_meta', $plugin_admin, 'wc_product_save', 99, 2 );
			$this->loader->add_action( 'woocommerce_settings_rpt', $plugin_admin, 'settings_page' );
			$this->loader->add_action( 'woocommerce_update_options_rpt', $plugin_admin, 'update_settings' );
			$this->loader->add_action( 'woocommerce_admin_field_rpt_bulk_edit', $plugin_admin, 'buld_edit_field' );


			$this->loader->add_filter( 'woocommerce_settings_tabs_array', $plugin_admin, 'add_settings_tab', 50 );
			$this->loader->add_filter('woocommerce_get_sections_products', $plugin_admin, 'add_settings_section' );
			$this->loader->add_filter( 'woocommerce_get_settings_products', $plugin_admin, 'add_settings', 20, 2 );
		}


		/**
		 * Register all of the hooks related to the public-facing functionality
		 * of the plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function define_public_hooks() {

			$plugin_public = new Raise_Prices_With_Time_For_Woocommmerce_Public( $this->get_plugin_name(), $this->get_version() );

			$this->loader->add_action( 'init', $plugin_public, 'register_shortcodes' );
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
			$this->loader->add_action( 'rpt_wc_increase_price', $plugin_public, 'rpt_increase_price_cron', 10, 2 );
			$this->loader->add_action( 'woocommerce_cart_loaded_from_session', $plugin_public, 'apply_prices', 99 );
			$this->loader->add_action( 'woocommerce_add_to_cart', $plugin_public, 'apply_prices_on_add_to_cart', 19, 6 );

			$this->loader->add_filter( 'woocommerce_single_product_summary', $plugin_public, 'show_single_product_countdown', 11 );
			$this->loader->add_filter( 'woocommerce_add_to_cart', $plugin_public, 'add_cart_item_data', 99 );
			$this->loader->add_filter( 'woocommerce_get_cart_item_from_session', $plugin_public, 'load_cart_item_data_from_session', 5, 2 );

			$this->loader->add_filter( 'get_post_metadata', $plugin_public, 'filter_bulk_data', 20, 4 );

			if ( 'yes' === get_option( 'cpwt_show_countdown_on_shop_pages', 'no' ) ) {
				$this->loader->add_action( 'woocommerce_after_shop_loop_item', $plugin_public, 'show_product_countdown_loop', 10 );
			}
		}

		/**
		 * Run the loader to execute all of the hooks with WordPress.
		 *
		 * @since    1.0.0
		 */
		public function run() {
			$this->loader->run();
		}

		/**
		 * The name of the plugin used to uniquely identify it within the context of
		 * WordPress and to define internationalization functionality.
		 *
		 * @since     1.0.0
		 * @return    string    The name of the plugin.
		 */
		public function get_plugin_name() {
			return $this->plugin_name;
		}

		/**
		 * The reference to the class that orchestrates the hooks with the plugin.
		 *
		 * @since     1.0.0
		 * @return    Raise_Prices_With_Time_For_Woocommmerce_Loader    Orchestrates the hooks of the plugin.
		 */
		public function get_loader() {
			return $this->loader;
		}

		/**
		 * Retrieve the version number of the plugin.
		 *
		 * @since     1.0.0
		 * @return    string    The version number of the plugin.
		 */
		public function get_version() {
			return $this->version;
		}

	}
}
