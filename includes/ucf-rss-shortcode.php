<?php
/**
 * Handles the registration of the UCF RSS Feed Shortcode
 **/

if ( !function_exists( 'sc_ucf_rss' ) ) {

	function sc_ucf_rss( $atts, $content='' ) {
		$atts = shortcode_atts( UCF_RSS_Config::get_shortcode_atts(), $atts, 'rss-feed' );
		$items = UCF_RSS_Feed::get_feed( $atts );

		ob_start();

		echo UCF_RSS_Common::display_feed( $items, $atts['layout'], $atts );

		return ob_get_clean(); // Shortcode must *return*!  Do not echo the result!
	}

	add_shortcode( 'rss-feed', 'sc_ucf_rss' );

}

if ( ! function_exists( 'ucf_rss_shortcode_interface' ) ) {
	function ucf_rss_shortcode_interface( $shortcodes ) {
		$settings = array(
			'command' => 'rss-feed',
			'name'    => 'UCF RSS Feed',
			'desc'    => 'Displays items from an RSS feed.',
			'fields'  => UCF_RSS_Config::get_wp_scif_fields(),
			'content' => false,
			'preview' => true
		);

		$shortcodes[] = $settings;

		return $shortcodes;
	}
}
