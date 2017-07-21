<?php
/**
 * Handles all feed related code.
 **/

if ( !class_exists( 'UCF_RSS_Feed' ) ) {

	class UCF_RSS_Feed {
		public static function get_feed( $args ) {
			// TODO enforce expiration

			// TODO filter args?
			$items = fetch_feed( $args['url'] );

			// TODO reset expiration

			// Enforce limit and offset
			// if ( $items ) {
				// TODO
			// }

			return $items;
		}


		// TODO update allowed hosts dynamically based on feed url
	}

}
