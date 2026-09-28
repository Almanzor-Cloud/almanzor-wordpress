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
        $agent_slug = trim($settings['agent_slug'] ?? '');
        if ($agent_slug === '') {
            return;
        }

        $platform = rtrim($settings['platform_url'] ?? 'https://widget.almanzor.cloud', '/');
        if ($platform === '') {
            return;
        }

        printf(
            '<script src="%1$s/embed.js" async defer data-agent-id="%2$s"></script>' . "\n",
            esc_url($platform . '/embed.js'),
            esc_attr($agent_slug)
        );
    }
}
