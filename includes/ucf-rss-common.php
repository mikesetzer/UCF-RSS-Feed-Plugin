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

		/**
		 * Returns the cache expiration for RSS feeds.
		 *
		 * @author Jo Dickson
		 * @since 1.0.0
		 * @return int | expiration, in seconds
		 **/
		public static function get_cache_expiration() {
			return UCF_RSS_Config::get_option_or_default( 'cache_expiration' ) * HOUR_IN_SECONDS;
		}

		/**
		 * Tries to return a thumbnail within a SimplePie item, or the fallback
		 * image if available.
		 *
		 * @author Jo Dickson
		 * @since 1.0.0
		 * @param $item obj | SimplePie item obj
		 * @return mixed | img URL string, or false on failure
		 **/
		public static function get_simplepie_thumbnail_or_fallback( $item ) {
			$thumbnail = null;

			// Try to get a thumbnail from the SimplePie obj's enclosure
			if ( $enclosures = $item->get_enclosures() ) {
				foreach ( $enclosures as $enclosure ) {
					$media = $enclosure->get_thumbnail() ?: $enclosure->get_link();
					// Avoid Gravatars
					if ( $media && ( strpos( $media, 'gravatar' ) === false ) ) {
						$thumbnail = $media;
						break;
					}
				}
			}
			// If that fails, fetch the fallback
			if ( !$thumbnail ) {
				$attachment_id = UCF_RSS_Config::get_option_or_default( 'fallback_image' );
				if ( $attachment_id ) {
					$thumbnail = wp_get_attachment_url( $attachment_id );
				}
			}

			return $thumbnail;
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
