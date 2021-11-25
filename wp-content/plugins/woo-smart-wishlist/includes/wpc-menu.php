<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WPCleverMenu' ) ) {
	class WPCleverMenu {
		function __construct() {
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		}

		function admin_menu() {
			add_menu_page(
				'WPClever',
				'WPClever⚡',
				'manage_options',
				'wpclever',
				array( &$this, 'welcome_content' ),
				WPC_URI . 'assets/images/wpc-icon.svg',
				26
			);
			add_submenu_page( 'wpclever', 'About', 'About', 'manage_options', 'wpclever' );
		}

		function welcome_content() {
			?>
            <div class="wpclever_welcome_page wrap">
                <h1>WPClever | Make clever moves</h1>
                <div class="card">
                    <h2 class="title">About</h2>
                    <p>
                        We are a team of passionate developers of plugins for WordPress, whose aspiration is to bring
                        smart utilities and functionalities to life for WordPress users, especially for those on
                        WooCommerce platform.
                    </p>
                    
                </div>
                
            </div>
			<?php
		}
	}

	new WPCleverMenu();
}