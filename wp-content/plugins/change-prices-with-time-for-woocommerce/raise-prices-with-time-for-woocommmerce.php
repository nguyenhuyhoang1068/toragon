<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.ibenic.com
 * @since             1.0.0
 * @package           Raise_Prices_With_Time_For_Woocommmerce
 *
 * @wordpress-plugin
 * Plugin Name:       Change Prices with Time for WooCommerce fix
 * Plugin URI:        https://wordpress.org/plugins/change-prices-with-time-for-woocommerce/
 * Description:       Increase the Product Price with Time and build scarcity
 * Version:           1.7.1
 * Author:            Igor Benić
 * Author URI:        https://www.ibenic.com/change-prices-with-time-for-woocommerce
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rpt-wc
 * Domain Path:       /languages
 * WC tested up to:   4.8.0
 * Tested up to:      5.6.0
 * 
 */
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}

if ( !function_exists( 'cpwtfw_fs' ) ) {
    // Create a helper function for easy SDK access.
    function cpwtfw_fs()
    {
        global  $cpwtfw_fs ;
        
        if ( !isset( $cpwtfw_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $cpwtfw_fs = fs_dynamic_init( array(
                'id'             => '3310',
                'slug'           => 'change-prices-with-time-for-woocommerce',
                'type'           => 'plugin',
                'public_key'     => 'pk_7831b7db8cfba74a8d836b255fb22',
                'is_premium'     => false,
                'premium_suffix' => 'Professional',
                'has_addons'     => false,
                'has_paid_plans' => true,
                'menu'           => array(
                'first-path' => 'plugins.php',
                'support'    => false,
            ),
                'is_live'        => true,
            ) );
        }
        
        return $cpwtfw_fs;
    }
    
    // Init Freemius.
    //cpwtfw_fs();
    // Signal that SDK was initiated.
    //do_action( 'cpwtfw_fs_loaded' );
}


if ( !function_exists( 'activate_raise_prices_with_time_for_woocommmerce' ) ) {
    /**
     * The code that runs during plugin activation.
     * This action is documented in includes/class-raise-prices-with-time-for-woocommmerce-activator.php
     */
    function activate_raise_prices_with_time_for_woocommmerce()
    {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-raise-prices-with-time-for-woocommmerce-activator.php';
        Raise_Prices_With_Time_For_Woocommmerce_Activator::activate();
    }
    
    register_activation_hook( __FILE__, 'activate_raise_prices_with_time_for_woocommmerce' );
}


if ( !function_exists( 'deactivate_raise_prices_with_time_for_woocommmerce' ) ) {
    /**
     * The code that runs during plugin deactivation.
     * This action is documented in includes/class-raise-prices-with-time-for-woocommmerce-deactivator.php
     */
    function deactivate_raise_prices_with_time_for_woocommmerce()
    {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-raise-prices-with-time-for-woocommmerce-deactivator.php';
        Raise_Prices_With_Time_For_Woocommmerce_Deactivator::deactivate();
    }
    
    register_deactivation_hook( __FILE__, 'deactivate_raise_prices_with_time_for_woocommmerce' );
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-raise-prices-with-time-for-woocommmerce.php';

//if ( !function_exists( 'rptwc_add_action_links' ) ) {
    //add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'rptwc_add_action_links' );
    /**
     * Adding Link for Documentation
     *
     * @param [type] $links
     *
     * @return array
     */
    // function rptwc_add_action_links( $links )
    // {
    //     $mylinks = array( '<a target="_blank" href="https://www.ibenic.com/change-prices-with-time-for-woocommerce">' . __( 'Documentation', 'rpt-wc' ) . '</a>' );
    //     if ( !defined( 'RPT_PREMIUM' ) || !RPT_PREMIUM || cpwtfw_fs()->is_not_paying() ) {
    //         $mylinks[] = '<a target="_blank" href="' . cpwtfw_fs()->get_upgrade_url() . '">' . __( 'Upgrade', 'rpt-wc' ) . '</a>';
    //     }
    //     return array_merge( $links, $mylinks );
    // }

//}


if ( !function_exists( 'run_raise_prices_with_time_for_woocommmerce' ) ) {
    /**
     * Begins execution of the plugin.
     *
     * Since everything within the plugin is registered via hooks,
     * then kicking off the plugin from this point in the file does
     * not affect the page life cycle.
     *
     * @since    1.0.0
     */
    function run_raise_prices_with_time_for_woocommmerce()
    {
        $plugin = new Raise_Prices_With_Time_For_Woocommmerce();
        $plugin->run();
    }
    
    run_raise_prices_with_time_for_woocommmerce();
}
