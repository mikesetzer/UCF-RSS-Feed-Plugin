<?php
/**
 * Place common functions here.
 **/

if ( !class_exists( 'UCF_RSS_Common' ) ) {

	class UCF_RSS_Common {
		public static function display_feed( $items, $layout='default', $args=array() ) {
			ob_start();

			if ( has_action( 'ucf_rss_display_' . $layout . '_before' ) ) {
				do_action( 'ucf_rss_display_' . $layout . '_before', $items, $args );
			}

			if ( has_action( 'ucf_rss_display_' . $layout . '_title' ) ) {
				do_action( 'ucf_rss_display_' . $layout . '_title', $items, $args );
			}

			if ( has_action( 'ucf_rss_display_' . $layout  ) ) {
				do_action( 'ucf_rss_display_' . $layout, $items, $args );
			}

			if ( has_action( 'ucf_rss_display_' . $layout . '_after' ) ) {
				do_action( 'ucf_rss_display_' . $layout . '_after', $items, $args );
			}

			return ob_get_clean();
		}
	}

}

if ( ! function_exists( 'ucf_rss_enqueue_assets' ) ) {
	function ucf_rss_enqueue_assets() {
		// CSS
		$include_css = UCF_RSS_Config::get_option_or_default( 'include_css' );
		$css_deps = apply_filters( 'ucf_rss_style_deps', array() );

		if ( $include_css ) {
			wp_enqueue_style( 'ucf_rss_css', plugins_url( 'static/css/ucf-rss.min.css', UCF_RSS__PLUGIN_FILE ), $css_deps, false, 'screen' );
		}
	}

	add_action( 'wp_enqueue_scripts', 'ucf_rss_enqueue_assets' );
}
