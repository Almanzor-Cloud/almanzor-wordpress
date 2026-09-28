<?php
/**
 * Admin settings for Almanzor Cloud.
 *
 * @package Almanzor_Cloud
 */

if (!defined('ABSPATH')) {
    exit;
}

final class Almanzor_Cloud_Settings {
    public const OPTION_KEY = 'almanzor_cloud_settings';
    public const SETTINGS_GROUP = 'almanzor_cloud_settings_group';
    public const MENU_SLUG = 'almanzor-cloud';

    public static function init(): void {
        add_action('admin_menu', [self::class, 'register_menu']);
        add_action('admin_init', [self::class, 'register_settings']);
    }

    public static function get_settings(): array {
        $defaults = [
            'api_key' => '',
            'agent_id' => '',
            'platform_url' => 'https://widget.almanzor.cloud',
            'portal_api_url' => 'https://portal.almanzor.cloud',
        ];

        $stored = get_option(self::OPTION_KEY, []);
        if (!is_array($stored)) {
            return $defaults;
        }

        return array_merge($defaults, $stored);
    }

    public static function register_menu(): void {
        add_options_page(
            __('Almanzor Cloud', 'almanzor-cloud'),
            __('Almanzor Cloud', 'almanzor-cloud'),
            'manage_options',
            self::MENU_SLUG,
            [self::class, 'render_page']
        );
    }

    public static function register_settings(): void {
        register_setting(
            self::SETTINGS_GROUP,
            self::OPTION_KEY,
            [
                'type' => 'array',
                'sanitize_callback' => [self::class, 'sanitize'],
            ]
        );
    }

    public static function sanitize($input): array {
        if (!is_array($input)) {
            return self::get_settings();
        }

        return [
            'api_key' => sanitize_text_field($input['api_key'] ?? ''),
            'agent_id' => sanitize_text_field($input['agent_id'] ?? ''),
            'platform_url' => esc_url_raw($input['platform_url'] ?? 'https://widget.almanzor.cloud'),
            'portal_api_url' => esc_url_raw($input['portal_api_url'] ?? 'https://portal.almanzor.cloud'),
        ];
    }

    public static function render_page(): void {
        if (!current_user_can('manage_options')) {
            return;
        }

        $settings = self::get_settings();
        ?>
        <div class="wrap">
            <h1><?php echo esc_html__('Almanzor Cloud', 'almanzor-cloud'); ?></h1>
            <?php settings_errors('almanzor_cloud'); ?>
            <form method="post" action="options.php">
                <?php
                settings_fields(self::SETTINGS_GROUP);
                ?>
                <table class="form-table" role="presentation">
                    <tr>
                        <th scope="row">
                            <label for="almanzor_cloud_api_key"><?php echo esc_html__('API key', 'almanzor-cloud'); ?></label>
                        </th>
                        <td>
                            <input
                                name="<?php echo esc_attr(self::OPTION_KEY); ?>[api_key]"
                                id="almanzor_cloud_api_key"
                                type="password"
                                class="regular-text"
                                value="<?php echo esc_attr($settings['api_key']); ?>"
                                autocomplete="off"
                            />
                            <p class="description">
                                <?php echo esc_html__('Create an API key in the Almanzor portal (Settings → API).', 'almanzor-cloud'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="almanzor_cloud_agent_id"><?php echo esc_html__('Agent ID', 'almanzor-cloud'); ?></label>
                        </th>
                        <td>
                            <input
                                name="<?php echo esc_attr(self::OPTION_KEY); ?>[agent_id]"
                                id="almanzor_cloud_agent_id"
                                type="text"
                                class="regular-text"
                                value="<?php echo esc_attr($settings['agent_id']); ?>"
                            />
                            <p class="description">
                                <?php echo esc_html__('UUID of the agent to embed (from the portal).', 'almanzor-cloud'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="almanzor_cloud_platform_url"><?php echo esc_html__('Widget URL', 'almanzor-cloud'); ?></label>
                        </th>
                        <td>
                            <input
                                name="<?php echo esc_attr(self::OPTION_KEY); ?>[platform_url]"
                                id="almanzor_cloud_platform_url"
                                type="url"
                                class="regular-text"
                                value="<?php echo esc_attr($settings['platform_url']); ?>"
                            />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="almanzor_cloud_portal_api_url"><?php echo esc_html__('Portal API URL', 'almanzor-cloud'); ?></label>
                        </th>
                        <td>
                            <input
                                name="<?php echo esc_attr(self::OPTION_KEY); ?>[portal_api_url]"
                                id="almanzor_cloud_portal_api_url"
                                type="url"
                                class="regular-text"
                                value="<?php echo esc_attr($settings['portal_api_url']); ?>"
                            />
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
            <hr />
            <h2><?php echo esc_html__('Sync site content', 'almanzor-cloud'); ?></h2>
            <p>
                <?php echo esc_html__(
                    'Uses your public site URL to ingest content into the configured agent (requires API key and agent ID).',
                    'almanzor-cloud'
                ); ?>
            </p>
            <form method="post">
                <?php wp_nonce_field('almanzor_cloud_ingest', 'almanzor_cloud_ingest_nonce'); ?>
                <input type="hidden" name="almanzor_cloud_action" value="ingest_site" />
                <?php submit_button(__('Ingest site content', 'almanzor-cloud'), 'secondary'); ?>
            </form>
        </div>
        <?php
    }
}
