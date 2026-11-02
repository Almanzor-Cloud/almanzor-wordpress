<?php
/**
 * Front-end widget embed.
 *
 * @package Almanzor
 */

if (!defined('ABSPATH')) {
    exit;
}

final class Almanzor_Embed {
    private const HANDLE = 'almanzor-widget';

    public static function init(): void {
        add_action('wp_enqueue_scripts', [self::class, 'enqueue_script']);
        add_filter('script_loader_tag', [self::class, 'add_agent_attribute'], 10, 2);
    }

    public static function enqueue_script(): void {
        $settings = Almanzor_Settings::get_settings();
        if (trim($settings['agent_slug'] ?? '') === '') {
            return;
        }

        $platform = rtrim($settings['platform_url'] ?? '', '/');
        if ($platform === '') {
            return;
        }

        wp_enqueue_script(
            self::HANDLE,
            $platform . '/embed.js',
            [],
            ALMANZOR_VERSION,
            ['in_footer' => true, 'strategy' => 'async']
        );
    }

    /** embed.js reads the assistant from this attribute of its own script tag. */
    public static function add_agent_attribute($tag, $handle) {
        if ($handle !== self::HANDLE) {
            return $tag;
        }

        $settings = Almanzor_Settings::get_settings();
        return str_replace(
            ' src=',
            ' data-agent-id="' . esc_attr(trim($settings['agent_slug'] ?? '')) . '" src=',
            $tag
        );
    }
}
