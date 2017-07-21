<?php
/**
 * Handles uninstallation logic.
 **/
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}


require_once 'includes/ucf-rss-config.php';

// Delete options
UCF_RSS_Config::delete_configurable_options();
