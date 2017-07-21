<?php

if ( !function_exists( 'ucf_rss_display_default_before' ) ) {

	function ucf_rss_display_default_before( $items, $args ) {
		ob_start();
	?>
		<!-- TODO -->
	<?php
		echo ob_get_clean();
	}

	add_action( 'ucf_rss_display_default_before', 'ucf_rss_display_default_before', 10, 2 );

}

if ( !function_exists( 'ucf_rss_display_default_title' ) ) {

	function ucf_rss_display_default_title( $items, $args ) {
		ob_start();
	?>
		<!-- TODO -->
	<?php
		echo ob_get_clean();
	}

	add_action( 'ucf_rss_display_default_title', 'ucf_rss_display_default_title', 10, 2 );

}

if ( !function_exists( 'ucf_rss_display_default' ) ) {

	function ucf_rss_display_default( $items, $args ) {
		ob_start();
	?>
		<!-- TODO -->
	<?php
		echo ob_get_clean();
	}

	add_action( 'ucf_rss_display_default', 'ucf_rss_display_default', 10, 2 );

}

if ( !function_exists( 'ucf_rss_display_default_after' ) ) {

	function ucf_rss_display_default_after( $items, $args ) {
		ob_start();
	?>
		<!-- TODO -->
	<?php
		echo ob_get_clean();
	}

	add_action( 'ucf_rss_display_default_after', 'ucf_rss_display_default_after', 10, 2 );

}
