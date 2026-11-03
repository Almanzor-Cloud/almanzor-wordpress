<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package Almanzor
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

delete_option('almanzor_settings');
