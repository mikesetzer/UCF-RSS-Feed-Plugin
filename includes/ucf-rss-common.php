<?php
/**
 * Place common functions here.
 **/

if ( !class_exists( 'UCF_RSS_Common' ) ) {

	class UCF_RSS_Common {
		public static function display_feed( $items, $layout='default', $args=array() ) {
			ob_start();

			// Before
			$layout_before = ucf_rss_display_default_before( '', $items, $args );
			if ( has_filter( 'ucf_rss_display_' . $layout . '_before' ) ) {
				$layout_before = apply_filters( 'ucf_rss_display_' . $layout . '_before', $layout_before, $items, $args );
			}
			echo $layout_before;

			// Title
			$layout_title = ucf_rss_display_default_title( '', $items, $args );
			if ( has_filter( 'ucf_rss_display_' . $layout . '_title' ) ) {
				$layout_title = apply_filters( 'ucf_rss_display_' . $layout . '_title', $layout_title, $items, $args );
			}
			echo $layout_title;

			// Main content/loop
			$layout_content = ucf_rss_display_default( '', $items, $args );
			if ( has_filter( 'ucf_rss_display_' . $layout ) ) {
				$layout_content = apply_filters( 'ucf_rss_display_' . $layout, $layout_content, $items, $args );
			}
			echo $layout_content;

			// After
			$layout_after = ucf_rss_display_default_after( '', $items, $args );
			if ( has_filter( 'ucf_rss_display_' . $layout . '_after' ) ) {
				$layout_after = apply_filters( 'ucf_rss_display_' . $layout . '_after', $layout_after, $items, $args );
			}
			echo $layout_after;

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

		/**
		 * Returns a sanitized SimplePie item URL.
		 *
		 * @author Jo Dickson
		 * @since 1.0.0
		 * @param $item obj | SimplePie item obj
		 * @return string | item URL string
		 **/
		public static function get_simplepie_url( $item ) {
			return esc_url( $item->get_permalink() );
		}

		/**
		 * Returns a sanitized SimplePie item title. Applies texturization.
		 *
		 * @author Jo Dickson
		 * @since 1.0.0
		 * @param $item obj | SimplePie item obj
		 * @return string | item title string
		 **/
		public static function get_simplepie_title( $item ) {
			return wptexturize( sanitize_text_field( $item->get_title() ) );
		}

		/**
		 * Returns a sanitized SimplePie item description. Applies
		 * texturization and a word limit of 55.
		 *
		 * @author Jo Dickson
		 * @since 1.0.0
		 * @param $item obj | SimplePie item obj
		 * @return string | item description string
		 **/
		public static function get_simplepie_description( $item ) {
			$desc = preg_replace( '/<a [^>]+>(Continue Reading|Read more).*?<\/a>/i', '', trim( $item->get_description() ) );
			return wp_trim_words( wptexturize( strip_shortcodes( strip_tags( $desc, '<p><a><br>' ) ) ), 55, '&hellip;' );
		}
	}

}

if ( ! function_exists( 'ucf_rss_enqueue_assets' ) ) {
	function ucf_rss_enqueue_assets() {
		$plugin_data   = get_plugin_data( UCF_RSS__PLUGIN_FILE, false, false );
		$version       = $plugin_data['Version'];

		// CSS
		$include_css = UCF_RSS_Config::get_option_or_default( 'include_css' );
		$css_deps    = apply_filters( 'ucf_rss_style_deps', array() );

		if ( $include_css ) {
			wp_enqueue_style( 'ucf_rss_css', plugins_url( 'static/css/ucf-rss.min.css', UCF_RSS__PLUGIN_FILE ), $css_deps, $version, 'screen' );
		}
	}

	add_action( 'wp_enqueue_scripts', 'ucf_rss_enqueue_assets' );
}
