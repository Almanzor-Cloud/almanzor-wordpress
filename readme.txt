=== Almanzor Cloud ===
Contributors: almanzorcloud
Tags: chatbot, ai, customer support, live chat, almanzor
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 8.0
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Official WordPress plugin for Almanzor Cloud — embed your AI assistant and sync public site content.

== Description ==

Connect your Almanzor Cloud account with an API key, add your agent ID, and load the official `embed.js` launcher on your site. Optionally ingest your public site URL into the agent knowledge base from **Settings → Almanzor Cloud**.

* Embeds the Almanzor widget on the front end
* Stores credentials in WordPress options (not in theme files)
* Ingests `home_url()` via the portal API when you choose **Ingest site content**

[Almanzor Cloud](https://almanzor.cloud) · [Portal](https://portal.almanzor.cloud) · [Documentation](https://github.com/Almanzor-Cloud/almanzor-wordpress)

== Installation ==

1. Copy this repository (or the release ZIP) into `wp-content/plugins/almanzor-cloud/`
2. Activate **Almanzor Cloud** on the Plugins screen
3. Open **Settings → Almanzor Cloud** and add your API key and agent ID

== Frequently Asked Questions ==

= Where do I get an API key? =

In the Almanzor portal under **Settings → API**.

= Where do I find my agent ID? =

In the Almanzor portal, open your agent and copy its ID (UUID).

= Does deactivating the plugin remove my settings? =

No. Settings are removed only when you **delete** (uninstall) the plugin.

== Changelog ==

= 1.0.0 =
* Initial release: settings screen, widget embed, and site ingest.
