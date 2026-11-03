<?php
/**
 * Plugin Name: Almanzor
 * Plugin URI: https://almanzor.cloud/integrations/wordpress
 * Description: Add your Almanzor AI assistant to your site. It answers from your own content and cites the page.
 * Version: 1.1.1
 * Requires at least: 6.3
 * Requires PHP: 8.0
 * Author: Almanzor Cloud OÜ
 * Author URI: https://almanzor.cloud
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: almanzor
 *
 * @package Almanzor
 */

if (!defined('ABSPATH')) {
    exit;
}

define('ALMANZOR_VERSION', '1.1.1');
define('ALMANZOR_PLUGIN_FILE', __FILE__);

require_once __DIR__ . '/includes/class-almanzor-settings.php';
require_once __DIR__ . '/includes/class-almanzor-embed.php';
require_once __DIR__ . '/includes/class-almanzor-ingest.php';
require_once __DIR__ . '/includes/class-almanzor-connection.php';

add_action(
    'plugins_loaded',
    static function (): void {
        Almanzor_Settings::init();
        Almanzor_Embed::init();
        Almanzor_Ingest::init();
        Almanzor_Connection::init();
    }
);
