<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package Almanzor_Cloud
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

delete_option('almanzor_cloud_settings');
