<?php
/**
 * Admin settings.
 *
 * @package Almanzor
 */

if (!defined('ABSPATH')) {
    exit;
}

final class Almanzor_Settings {
    public const OPTION_KEY = 'almanzor_cloud_settings';
    public const SETTINGS_GROUP = 'almanzor_settings_group';
    public const MENU_SLUG = 'almanzor';

    private const PORTAL_URL = 'https://almanzor.cloud';
    private const DOCS_URL = 'https://almanzor.cloud/wordpress';
    private const DEFAULT_WIDGET_URL = 'https://widget.almanzor.cloud';

    public static function init(): void {
        add_action('admin_menu', [self::class, 'register_menu']);
        add_action('admin_init', [self::class, 'register_settings']);
    }

    public static function get_settings(): array {
        $defaults = [
            'api_key' => '',
            'agent_id' => '',
            'agent_slug' => '',
            'platform_url' => self::DEFAULT_WIDGET_URL,
            'portal_api_url' => self::PORTAL_URL,
        ];

        $stored = get_option(self::OPTION_KEY, []);
        if (!is_array($stored)) {
            return $defaults;
        }

        $settings = array_merge($defaults, $stored);

        // portal.almanzor.cloud no longer exists; saved settings may still point there.
        if (wp_parse_url($settings['portal_api_url'], PHP_URL_HOST) === 'portal.almanzor.cloud') {
            $settings['portal_api_url'] = self::PORTAL_URL;
        }

        return $settings;
    }

    public static function register_menu(): void {
        add_options_page(
            __('Almanzor', 'almanzor'),
            __('Almanzor', 'almanzor'),
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

        $platform = esc_url_raw($input['platform_url'] ?? self::DEFAULT_WIDGET_URL);
        $portal = esc_url_raw($input['portal_api_url'] ?? self::PORTAL_URL);

        if ($platform === '') {
            $platform = self::DEFAULT_WIDGET_URL;
        }
        if ($portal === '') {
            $portal = self::PORTAL_URL;
        }

        return [
            'api_key' => sanitize_text_field($input['api_key'] ?? ''),
            'agent_id' => sanitize_text_field($input['agent_id'] ?? ''),
            'agent_slug' => sanitize_text_field($input['agent_slug'] ?? ''),
            'platform_url' => $platform,
            'portal_api_url' => $portal,
        ];
    }

    public static function render_page(): void {
        if (!current_user_can('manage_options')) {
            return;
        }

        $settings = self::get_settings();
        $portal_settings_api = self::PORTAL_URL . '/portal/settings/api';
        ?>
        <div class="wrap">
            <h1><?php echo esc_html__('Almanzor', 'almanzor'); ?></h1>

            <p>
                <?php
                echo wp_kses_post(
                    sprintf(
                        /* translators: 1: docs URL, 2: portal URL */
                        __(
                            'Add your assistant to this site. <a href="%1$s">Setup guide</a> · <a href="%2$s" target="_blank" rel="noopener noreferrer">Open portal</a>',
                            'almanzor'
                        ),
                        esc_url(self::DOCS_URL),
                        esc_url(self::PORTAL_URL . '/portal')
                    )
                );
                ?>
            </p>
            <p class="description">
                <?php
                echo esc_html__(
                    'The chat widget loads embed.js from your configured Widget URL (default: widget.almanzor.cloud).',
                    'almanzor'
                );
                ?>
            </p>

            <form method="post" action="options.php">
                <?php settings_fields(self::SETTINGS_GROUP); ?>
                <table class="form-table" role="presentation">
                    <tr>
                        <th scope="row">
                            <label for="almanzor_api_key"><?php echo esc_html__('API key', 'almanzor'); ?></label>
                        </th>
                        <td>
                            <input
                                name="<?php echo esc_attr(self::OPTION_KEY); ?>[api_key]"
                                id="almanzor_api_key"
                                type="password"
                                class="regular-text"
                                value="<?php echo esc_attr($settings['api_key']); ?>"
                                autocomplete="off"
                            />
                            <p class="description">
                                <?php
                                echo wp_kses_post(
                                    sprintf(
                                        /* translators: %s: portal API settings URL */
                                        __(
                                            'Create an API key in the portal (<a href="%s" target="_blank" rel="noopener noreferrer">Settings → API keys</a>).',
                                            'almanzor'
                                        ),
                                        esc_url($portal_settings_api)
                                    )
                                );
                                ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="almanzor_agent_id"><?php echo esc_html__('Agent ID', 'almanzor'); ?></label>
                        </th>
                        <td>
                            <input
                                name="<?php echo esc_attr(self::OPTION_KEY); ?>[agent_id]"
                                id="almanzor_agent_id"
                                type="text"
                                class="regular-text"
                                value="<?php echo esc_attr($settings['agent_id']); ?>"
                            />
                            <p class="description">
                                <?php echo esc_html__('Only for the connection test and content sync. Copy it from Channels → Widget → WordPress in the portal.', 'almanzor'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="almanzor_agent_slug"><?php echo esc_html__('Agent slug', 'almanzor'); ?></label>
                        </th>
                        <td>
                            <input
                                name="<?php echo esc_attr(self::OPTION_KEY); ?>[agent_slug]"
                                id="almanzor_agent_slug"
                                type="text"
                                class="regular-text"
                                value="<?php echo esc_attr($settings['agent_slug']); ?>"
                                required
                            />
                            <p class="description">
                                <?php echo esc_html__('The only value the widget needs. Copy it from Channels → Widget → WordPress in the portal.', 'almanzor'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="almanzor_platform_url"><?php echo esc_html__('Widget URL', 'almanzor'); ?></label>
                        </th>
                        <td>
                            <input
                                name="<?php echo esc_attr(self::OPTION_KEY); ?>[platform_url]"
                                id="almanzor_platform_url"
                                type="url"
                                class="regular-text"
                                value="<?php echo esc_attr($settings['platform_url']); ?>"
                                required
                            />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="almanzor_portal_api_url"><?php echo esc_html__('Portal API URL', 'almanzor'); ?></label>
                        </th>
                        <td>
                            <input
                                name="<?php echo esc_attr(self::OPTION_KEY); ?>[portal_api_url]"
                                id="almanzor_portal_api_url"
                                type="url"
                                class="regular-text"
                                value="<?php echo esc_attr($settings['portal_api_url']); ?>"
                                required
                            />
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>

            <hr />
            <h2><?php echo esc_html__('Test connection', 'almanzor'); ?></h2>
            <p><?php echo esc_html__('Checks your API key and agent ID against Almanzor.', 'almanzor'); ?></p>
            <form method="post">
                <?php wp_nonce_field('almanzor_test_connection', 'almanzor_test_nonce'); ?>
                <input type="hidden" name="almanzor_action" value="test_connection" />
                <?php submit_button(__('Test connection', 'almanzor'), 'secondary'); ?>
            </form>

            <hr />
            <h2><?php echo esc_html__('Sync site content', 'almanzor'); ?></h2>
            <p>
                <?php echo esc_html__(
                    'Sends the public address of this site to Almanzor, which imports its pages into your assistant. Needs the API key and agent ID.',
                    'almanzor'
                ); ?>
            </p>
            <form method="post">
                <?php wp_nonce_field('almanzor_ingest', 'almanzor_ingest_nonce'); ?>
                <input type="hidden" name="almanzor_action" value="ingest_site" />
                <?php submit_button(__('Import site content', 'almanzor'), 'secondary'); ?>
            </form>
        </div>
        <?php
    }
}
