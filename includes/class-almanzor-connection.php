<?php
/**
 * Portal connection test (admin).
 *
 * @package Almanzor
 */

if (!defined('ABSPATH')) {
    exit;
}

final class Almanzor_Connection {
    public static function init(): void {
        add_action('admin_init', [self::class, 'maybe_run_test']);
    }

    public static function maybe_run_test(): void {
        if (!is_admin() || !current_user_can('manage_options')) {
            return;
        }

        if (
            !isset($_POST['almanzor_action'])
            || sanitize_text_field(wp_unslash($_POST['almanzor_action'])) !== 'test_connection'
        ) {
            return;
        }

        if (
            !isset($_POST['almanzor_test_nonce'])
            || !wp_verify_nonce(
                sanitize_text_field(wp_unslash($_POST['almanzor_test_nonce'])),
                'almanzor_test_connection'
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
                'test_missing_config',
                esc_html__('Save an API key and agent ID before testing the connection.', 'almanzor'),
                'error'
            );
            return;
        }

        if ($portal === '') {
            add_settings_error(
                'almanzor',
                'test_missing_portal',
                esc_html__('Portal API URL is required.', 'almanzor'),
                'error'
            );
            return;
        }

        $endpoint = $portal . '/api/v1/agents/' . rawurlencode($agent_id);

        $response = wp_remote_get(
            $endpoint,
            [
                'timeout' => 30,
                'headers' => [
                    'Authorization' => 'Bearer ' . $api_key,
                    'Accept' => 'application/json',
                ],
            ]
        );

        if (is_wp_error($response)) {
            add_settings_error(
                'almanzor',
                'test_failed',
                esc_html($response->get_error_message()),
                'error'
            );
            return;
        }

        $code = wp_remote_retrieve_response_code($response);
        $raw_body = wp_remote_retrieve_body($response);
        $body = json_decode($raw_body, true);

        if ($code === 200 && is_array($body)) {
            $slug_hint = '';
            if (isset($body['agent']['slug']) && is_scalar($body['agent']['slug'])) {
                $slug_hint = ' ' . sprintf(
                    /* translators: %s: agent slug */
                    esc_html__('Embed slug: %s', 'almanzor'),
                    esc_html((string) $body['agent']['slug'])
                );
            }
            add_settings_error(
                'almanzor',
                'test_ok',
                esc_html__('Connection successful. Assistant found.', 'almanzor') . $slug_hint,
                'updated'
            );
            return;
        }

        if ($code === 401) {
            add_settings_error(
                'almanzor',
                'test_unauthorized',
                esc_html__('Invalid API key or insufficient access.', 'almanzor'),
                'error'
            );
            return;
        }

        if ($code === 404) {
            add_settings_error(
                'almanzor',
                'test_not_found',
                esc_html__('Agent not found. Check the agent ID.', 'almanzor'),
                'error'
            );
            return;
        }

        $message = esc_html__('Connection test failed.', 'almanzor');
        if (is_array($body) && isset($body['error']) && is_scalar($body['error'])) {
            $message = sanitize_text_field((string) $body['error']);
        }

        add_settings_error('almanzor', 'test_failed', $message, 'error');
    }
}
