<?php
/**
 * Handles admin actions
 **/
if ( ! class_exists( 'UCF_RSS_Admin' ) ) {
	class UCF_RSS_Admin {
		public static function enqueue_admin_scripts() {
			if ( is_admin() ) {
				if ( function_exists( 'wp_enqueue_media' ) ) {
					wp_enqueue_media();
				} else {
					wp_enqueue_style( 'thickbox' );
					wp_enqueue_script( 'media-upload' );
					wp_enqueue_script( 'thickbox' );
					wp_enqueue_media();
				}
				wp_enqueue_script( 'ucf-rss-admin', plugins_url( 'static/js/ucf-rss-admin.min.js', UCF_RSS__PLUGIN_FILE ), array(), null, true );
			}
		}
	}
	add_action( 'admin_enqueue_scripts', array( 'UCF_RSS_Admin', 'enqueue_admin_scripts' ) );
}
?>
