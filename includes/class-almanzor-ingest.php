<?php
/**
 * Imports the site's pages into the assistant, from the admin.
 *
 * @package Almanzor
 */

if (!defined('ABSPATH')) {
    exit;
}

final class Almanzor_Ingest {
    public static function init(): void {
        add_action('admin_init', [self::class, 'maybe_run_ingest']);
    }

    public static function maybe_run_ingest(): void {
        if (!is_admin() || !current_user_can('manage_options')) {
            return;
        }

        if (
            !isset($_POST['almanzor_action'])
            || sanitize_text_field(wp_unslash($_POST['almanzor_action'])) !== 'ingest_site'
        ) {
            return;
        }

        if (
            !isset($_POST['almanzor_ingest_nonce'])
            || !wp_verify_nonce(
                sanitize_text_field(wp_unslash($_POST['almanzor_ingest_nonce'])),
                'almanzor_ingest'
            )
        ) {
            return;
        }

        $settings = Almanzor_Settings::get_settings();
        $api_key = trim($settings['api_key'] ?? '');
        $agent_id = trim($settings['agent_id'] ?? '');
        $portal = rtrim($settings['portal_api_url'] ?? 'https://almanzor.cloud', '/');

        if ($api_key === '' || $agent_id === '') {
            add_settings_error(
                'almanzor',
                'missing_config',
                esc_html__('Configure API key and agent ID first.', 'almanzor'),
                'error'
            );
            return;
        }

        $site_url = home_url('/');
        $endpoint = $portal . '/api/v1/agents/' . rawurlencode($agent_id) . '/ingest-url';

        $response = wp_remote_post(
            $endpoint,
            [
                'timeout' => 90,
                'headers' => [
                    'Authorization' => 'Bearer ' . $api_key,
                    'Content-Type' => 'application/json',
                ],
                'body' => wp_json_encode(['url' => $site_url]),
            ]
        );

        if (is_wp_error($response)) {
            add_settings_error(
                'almanzor',
                'ingest_failed',
                esc_html($response->get_error_message()),
                'error'
            );
            return;
        }

        $code = wp_remote_retrieve_response_code($response);
        $raw_body = wp_remote_retrieve_body($response);
        $body = json_decode($raw_body, true);

        if ($code < 200 || $code >= 300) {
            $message = esc_html__('Import failed.', 'almanzor');
            if (is_array($body) && isset($body['error']) && is_scalar($body['error'])) {
                $message = sanitize_text_field((string) $body['error']);
            }
            add_settings_error('almanzor', 'ingest_failed', $message, 'error');
            return;
        }

        add_settings_error(
            'almanzor',
            'ingest_ok',
            esc_html__('Site content imported.', 'almanzor'),
            'updated'
        );
    }
}
