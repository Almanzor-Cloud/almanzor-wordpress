<?php
/**
 * Plugin Name: Almanzor Cloud
 * Plugin URI: https://github.com/Almanzor-Cloud/almanzor-wordpress
 * Description: Official WordPress integration for Almanzor Cloud — embed your AI assistant and sync public site content.
 * Version: 1.0.2
 * Requires at least: 6.0
 * Requires PHP: 8.0
 * Author: Almanzor Cloud
 * Author URI: https://almanzor.cloud
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: almanzor-cloud
 *
 * @package Almanzor_Cloud
 */

if (!defined('ABSPATH')) {
    exit;
}

define('ALMANZOR_CLOUD_VERSION', '1.0.2');
define('ALMANZOR_CLOUD_PLUGIN_FILE', __FILE__);

require_once __DIR__ . '/includes/class-almanzor-cloud-settings.php';
require_once __DIR__ . '/includes/class-almanzor-cloud-embed.php';
require_once __DIR__ . '/includes/class-almanzor-cloud-ingest.php';
require_once __DIR__ . '/includes/class-almanzor-cloud-connection.php';

add_action(
    'init',
    static function (): void {
        load_plugin_textdomain(
            'almanzor-cloud',
            false,
            dirname(plugin_basename(ALMANZOR_CLOUD_PLUGIN_FILE)) . '/languages'
        );
    }
);

add_action(
    'plugins_loaded',
    static function (): void {
        Almanzor_Cloud_Settings::init();
        Almanzor_Cloud_Embed::init();
        Almanzor_Cloud_Ingest::init();
        Almanzor_Cloud_Connection::init();
    }
);
