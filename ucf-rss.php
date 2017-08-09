<?php
/*
Plugin Name: UCF RSS Feed Plugin
Description: Contains shortcode for displaying RSS feed data in posts.
Version: 2.0.0
Author: UCF Web Communications
License: GPL3
*/
if ( ! defined( 'WPINC' ) ) {
	die;
}


define( 'UCF_RSS__PLUGIN_FILE', __FILE__ );

require_once 'includes/ucf-rss-config.php';
require_once 'includes/ucf-rss-feed.php';
require_once 'includes/ucf-rss-common.php';
require_once 'includes/ucf-rss-shortcode.php';

require_once 'admin/ucf-rss-admin.php';

require_once 'layouts/rss-default.php';
require_once 'layouts/rss-thumbnail.php';


/**
 * Activation/deactivation hooks
 **/
if ( !function_exists( 'ucf_rss_plugin_activation' ) ) {
	function ucf_rss_plugin_activation() {
		return UCF_RSS_Config::add_configurable_options();
	}
}

if ( !function_exists( 'ucf_rss_plugin_deactivation' ) ) {
	function ucf_rss_plugin_deactivation() {
		return;
	}
}

register_activation_hook( UCF_RSS__PLUGIN_FILE, 'ucf_rss_plugin_activation' );
register_deactivation_hook( UCF_RSS__PLUGIN_FILE, 'ucf_rss_plugin_deactivation' );


/**
 * Plugin-dependent actions:
 **/
if ( ! function_exists( 'ucf_rss_init' ) ) {
	function ucf_rss_init() {
		// If the `WP-Shortcode-Interface` plugin is installed, add the shortcode
		// definitions.
		if ( class_exists( 'WP_SCIF_Config' ) ) {
			add_filter( 'wp_scif_add_shortcode', 'ucf_rss_shortcode_interface', 10, 1 );
		}
	}
	add_action( 'plugins_loaded', 'ucf_rss_init' );
}
