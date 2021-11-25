<?php
defined( 'ABSPATH' ) || exit;

$theme = wp_get_theme();

if ( ! empty( $theme['Name'] ) && ( strpos( $theme['Name'], 'WPC' ) !== false ) ) {
	return;
}

if ( ! class_exists( 'WPCleverNotice' ) ) {
	class WPCleverNotice {
		function __construct() {
			add_action( 'admin_notices', array( $this, 'admin_notice' ) );
			add_action( 'admin_init', array( $this, 'notice_ignore' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'notice_scripts' ) );
		}

		function notice_scripts() {
			wp_enqueue_style( 'wpclever-notice', WOOSW_URI . 'assets/css/notice.css' );
		}

		function admin_notice() {
			global $current_user, $current_screen;
			$user_id = $current_user->ID;

			if ( ! $current_screen || ! isset( $current_screen->base ) || ( strpos( $current_screen->base, 'wpclever' ) === false ) ) {
				return;
			}

	
		}

		function notice_ignore() {
			global $current_user;
			$user_id = $current_user->ID;

			if ( isset( $_GET['wpclever_wpcstore_ignore'] ) ) {
				if ( $_GET['wpclever_wpcstore_ignore'] == '1' ) {
					update_user_meta( $user_id, 'wpclever_wpcstore_ignore', 'true' );
				} else {
					delete_user_meta( $user_id, 'wpclever_wpcstore_ignore' );
				}
			}
		}
	}

	new WPCleverNotice();
}