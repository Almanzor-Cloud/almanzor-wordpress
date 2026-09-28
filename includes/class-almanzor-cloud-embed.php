<?php
/**
 * Front-end widget embed.
 *
 * @package Almanzor_Cloud
 */

if (!defined('ABSPATH')) {
    exit;
}

final class Almanzor_Cloud_Embed {
    public static function init(): void {
        add_action('wp_footer', [self::class, 'render_embed_script'], 20);
    }

    public static function render_embed_script(): void {
        if (is_admin()) {
            return;
        }

        $settings = Almanzor_Cloud_Settings::get_settings();
        $agent_id = trim($settings['agent_id'] ?? '');
        if ($agent_id === '') {
            return;
        }

        $platform = rtrim($settings['platform_url'] ?? 'https://widget.almanzor.cloud', '/');
        if ($platform === '') {
            return;
        }

        printf(
            '<script src="%1$s/embed.js" async data-agent="%2$s" data-platform-url="%1$s"></script>' . "\n",
            esc_url($platform),
            esc_attr($agent_id)
        );
    }
}
