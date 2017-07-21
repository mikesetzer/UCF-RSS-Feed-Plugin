<?php
/**
 * Handles all feed related code.
 **/

if ( !class_exists( 'UCF_RSS_Feed' ) ) {

	class UCF_RSS_Feed {

		/**
		 * Fetches an RSS feed.
		 *
		 * @author Jo Dickson
		 * @since 1.0.0
		 * @param $args array | array of filtered arguments
		 * @return mixed | array of SimplePie objects, or false on failure
		 **/
		public static function get_feed( $args ) {
			$items = false;

			if ( !empty( $args['url'] ) ) {
				// Make sure requests to the specified URL are allowed.
				//
				// Note that we can't unset this later because we have to pass
				// the hook an anonymous function. This has the side effect of
				// allowing future requests to the given URL by other
				// functions/plugins.
				add_filter( 'http_request_host_is_external', function( $allow, $host, $url ) {
					$feed_host = parse_url( $args['url'], PHP_URL_HOST );
					if ( $feed_host === $host ) {
						$allow = true;
					}
					return $allow;
				}, 10, 3 );

				// Enforce expiration
				add_filter( 'wp_feed_cache_transient_lifetime', array( 'UCF_RSS_Common', 'get_cache_expiration' ) );

				$rss = fetch_feed( $args['url'] );

				// Reset expiration
				remove_filter( 'wp_feed_cache_transient_lifetime', array( 'UCF_RSS_Common', 'get_cache_expiration' ) );

				// Enforce limit and offset
				if ( ! is_wp_error( $rss ) ) {

					// Figure out how many total items there are, but limit it
					// to the specified 'limit'.
					$limit = $rss->get_item_quantity( $args['limit'] );

					// Build an array of all the items, starting with the
					// element at the specified 'offset'.
					$items = $rss->get_items( $args['offset'], $limit );

				}
			}
			else {
				$items = false;
			}

			return $items;
		}

	}

}
