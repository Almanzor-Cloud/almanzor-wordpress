=== Almanzor Cloud ===
Contributors: almanzorcloud
Tags: chatbot, ai, customer support, live chat, almanzor
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 8.0
Stable tag: 1.0.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Official WordPress plugin for Almanzor Cloud — embed your AI assistant and sync public site content.

== Description ==

Connect your Almanzor Cloud account with an API key, add your agent ID, and load the official `embed.js` launcher on your site. Optionally ingest your public site URL into the agent knowledge base from **Settings → Almanzor Cloud**.

* Embeds the Almanzor widget on the front end
* Stores credentials in WordPress options (not in theme files)
* Ingests `home_url()` via the portal API when you choose **Ingest site content**
* Connection test against the portal API

[Almanzor Cloud](https://almanzor.cloud) · [WordPress setup guide](https://almanzor.cloud/wordpress) · [Portal](https://almanzor.cloud/portal) · [GitHub](https://github.com/Almanzor-Cloud/almanzor-wordpress)

== Installation ==

**From WordPress.org (when available)**

1. In your WordPress admin, go to **Plugins → Add New**
2. Search for **Almanzor Cloud**
3. Install and activate
4. Open **Settings → Almanzor Cloud** and add your API key, agent ID (UUID), and agent slug

**Manual install**

1. Download the release ZIP from [GitHub Releases](https://github.com/Almanzor-Cloud/almanzor-wordpress/releases) (folder inside must be `almanzor-cloud`)
2. Upload via **Plugins → Add New → Upload Plugin**, or extract to `wp-content/plugins/almanzor-cloud/`
3. Activate **Almanzor Cloud**
4. Open **Settings → Almanzor Cloud** and add your API key, agent ID (UUID), and agent slug

== Frequently Asked Questions ==

= Where do I get an API key? =

In the Almanzor portal under **Settings → API**.

= Where do I find my agent ID and slug? =

In the Almanzor portal, open your agent → **Share**. Copy the **Agent ID (UUID)** for API calls and the **slug** for the front-end widget (`data-agent-id`).

= Does the plugin send data outside my server? =

Yes. The front end loads `embed.js` from the configured widget host (default `widget.almanzor.cloud`). Ingest and connection test call the Almanzor portal API with your API key. See **Privacy** below.

= Does deactivating the plugin remove my settings? =

No. Settings are removed only when you **delete** (uninstall) the plugin.

== Screenshots ==

1. Settings screen with API key, agent ID, connection test, and ingest
2. Almanzor chat widget on a public page (after configuration)

== Privacy ==

This plugin stores your Almanzor API key and agent ID in the WordPress database (`wp_options`, option name `almanzor_cloud_settings`). Only site administrators with `manage_options` can view or change these values.

When configured, the plugin:

* Loads JavaScript from your **Widget URL** (default `https://widget.almanzor.cloud/embed.js`) on public pages so visitors can use the chat widget. Visitor messages are handled by Almanzor Cloud according to your portal settings and privacy policy.
* May send your site’s public URL (`home_url()`) to the portal when an administrator runs **Ingest site content**.
* May call `GET /api/v1/agents/{id}` when an administrator runs **Test connection**.

No telemetry or analytics are sent by this plugin beyond the above actions initiated from the WordPress admin or the embedded widget.

For Almanzor Cloud’s data practices, see [almanzor.cloud/privacy](https://almanzor.cloud/privacy).

== Changelog ==

= 1.0.2 =
* Fix the widget not loading: the script address had `embed.js` twice.
* Fix the portal address: connection test, content sync and portal links now use almanzor.cloud. Saved settings update automatically.

= 1.0.1 =
* Fix embed snippet (`data-agent-id` and agent slug). Add agent slug setting.

= 1.0.0 =
* Initial release: settings screen, widget embed, site ingest, and connection test.
