<?php

/**
 * Plugin Name: Stripe setting
 * Plugin URI: https://github.com/
 * Description: This plugin provides features setting Paypal and Stripe.
 * Author: thuytranthanhbd
 * Author URI: https://wordpress.org/
 * Text Domain: woo-pfp
 * Domain Path: /languages
 * Version: 1.6.1
 *
 * WC requires at least: 3.0
 * WC tested up to: 5.7.1
 *
 * License:     GPLv2+
 */

if (!defined('ABSPATH')) {
  exit;
}

define('WOO_PFP_DIR', plugin_dir_path(__FILE__));
define('WOO_PFP_URL', plugins_url('/', __FILE__));

/**
 * Start the instance
 */
new PfpViet();

/**
 * The main class of the plugin
 * @author thuytranthanhbd
 * @since 1.0
 */
class PfpViet
{
  /**
   * @var array The default settings for the whole plugin
   */
  static $default_settings = array(
    'vnd_paypal_standard'   =>
      array(
        'enabled'  => 'yes',
        'currency' => 'USD',
        'rate'     => '22770',
      ),
    'vnd_paypal_express_checkout' =>
      array(
        'enabled'  => 'yes',
        'currency' => 'USD',
        'rate'     => '22770',
      ),
    'vnd_stripe_fees' =>
      array(
        'enabled'  => 'yes',    
        'rate'     => '22770',
        'fixedfee' => '0.5', 
        'paypalfixedfee' => '2.2',               
      ),
    'vnd_paypal_fees' =>
      array(
        'enabled'  => 'yes',    
        'rate'     => '22770',  
      ),
  );
  /**
   * The properties to manage all classess under the "inc/" folder
   *   
   */
  protected $VND_PayPal_Standard;
  protected $Admin_Page;
  protected $VND_PayPal_Express_Checkout;

  /**
   * Setup class
   * @since 1.0
   */
  public function __construct()
  {
    add_action('init', array($this, 'init'));
  }

  /**
   * Throw a notice if woocommerce is NOT active
   */

  public function notice_if_not_woocommerce()
  {
    $class = 'notice notice-warning';

    $message = __('PFP is not running because WooCommerce is not active. Pls active both plugin', 'woo-pfp');

    printf('<div class="%1$s"><p><strong>%2$s</strong></p></div>', $class, $message);
  }

  /**
   * Run this method under the init action
   */
  public function init()
  {
    //Load the localization feature
    $this->i18n();

    if (class_exists('WooCommerce')) {
      $this->main();

      //Add setting link when the plugin is active
      add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'add_settings_link'));
    } else {
      // Throw a notice if WooCommerce is NOT active
      add_action('admin_notices', array($this, 'notice_if_not_woocommerce'));
    }
  }

  /**
   * Localize the plugin
   * @since 1.0
   */
  public function i18n()
  {
    load_plugin_textdomain('woo-pfp', false, basename(dirname(__FILE__)) . '/languages/');
  }

  /**
   * The main method to load the components
   */
  public function main()
  {
    if (is_admin()) {
      // Add the admin setting page
      include(WOO_PFP_DIR . 'inc/class-pfp-admin-page.php');
      $this->Admin_Page = new WooPfp_Admin_Page();
    }
    $settings = self::get_settings();
    include(WOO_PFP_DIR . 'inc/class-woopfp-currency.php');
    $this->Currency = new WooPfp_Currency();

    // Check if "Support VND for the PayPal Standard gateway" is enabled
    /*if (
      'yes' == $settings['vnd_paypal_standard']['enabled']
      and class_exists('WC_Gateway_Paypal')
      and 'VND' == get_woocommerce_currency()
    ) {
      include(WOO_PFP_DIR . 'inc/class-woopfp-vnd-paypal-standard.php');
      $this->VND_PayPal_Standard = new WooPfp_VND_PayPal_Standard(
        $settings['vnd_paypal_standard']['rate'],
        $settings['vnd_paypal_standard']['currency']
      );
    }*/

    // Check if "Support VND for the PayPal Express Checkout gateway" is enabled
    /*if (
      'yes' == $settings['vnd_paypal_express_checkout']['enabled']
      and class_exists('WC_Gateway_PPEC_Plugin')
      and 'VND' == get_woocommerce_currency()
    ) {
      include(WOO_PFP_DIR . 'inc/class-woopfp-vnd-paypal-express-checkout.php');
      $this->VND_PayPal_Express_Checkout = new WooPfp_VND_PayPal_Express_Checkout(
        $settings['vnd_paypal_express_checkout']['rate'],
        $settings['vnd_paypal_express_checkout']['currency']
      );
    }*/
  }

  /**
   * The wrapper method to get the settings of the plugin
   * @return array
   */
  static function get_settings()
  {
    $settings = get_option('woo-pfp', self::$default_settings);
    $settings = wp_parse_args($settings, self::$default_settings);

    return $settings;
  }


  /**
   * Add "Settings" link in the Plugins list page when the plugin is active
   *
   */
  public function add_settings_link($links)
  {
    $settings = array('<a href="' . admin_url('admin.php?page=woo-pfp') . '">' . __('Settings', 'woo-pfp') . '</a>');
    $links    = array_reverse(array_merge($links, $settings));

    return $links;
  }
}
