=== Almanzor ===
Contributors: almanzorcloud
Tags: chatbot, ai, ai assistant, customer support, chat
Requires at least: 6.3
Tested up to: 7.1
Requires PHP: 8.0
Stable tag: 1.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add an AI assistant to your site that answers from your own content, cites the page and says when it doesn't know.

== Description ==

Almanzor is an AI assistant that answers your visitors from your own content: your website, your docs and your files. Each answer cites the page it came from. When the answer isn't in your content, it says so, and you see that question in your portal so you know what to write next.

This plugin connects your WordPress site to your Almanzor account:

* Shows the chat widget on your public pages
* Imports your site's pages into your assistant from the WordPress admin
* Tests the connection to your account

You need an Almanzor account. New accounts get a 14-day trial with no card, then a paid plan. See [pricing](https://almanzor.cloud/pricing).

== External services ==

This plugin relies on Almanzor, a third-party service run by Almanzor Cloud OÜ, to provide the assistant.

* **Widget:** once you've saved an agent slug, every public page loads `embed.js` from `widget.almanzor.cloud` (or the Widget URL you set). Visitors' browsers connect to that service, and what they type in the chat is sent to it.
* **Connection test:** when an administrator clicks **Test connection**, your API key and agent ID are sent to `almanzor.cloud`.
* **Content import:** when an administrator clicks **Import site content**, your API key, agent ID and your site's public address are sent to `almanzor.cloud`, which then reads your public pages.

Nothing is sent to `almanzor.cloud` from the admin until an administrator clicks one of those buttons.

Service terms: [Terms of use](https://almanzor.cloud/terms) · [Privacy policy](https://almanzor.cloud/privacy)

== Installation ==

1. In your WordPress admin, go to **Plugins → Add New**, search for **Almanzor**, install and activate it
2. Go to **Settings → Almanzor**
3. In the [Almanzor portal](https://almanzor.cloud/portal), open your assistant and go to **Channels → Widget → WordPress**
4. Copy the agent slug into the plugin and save. The widget now shows on your site
5. Add your site's domain to the assistant's authorized domains in the portal, if it isn't there yet

To test the connection and import your site from WordPress, also add an API key (**Settings → API keys** in the portal) and the agent ID.

== Frequently Asked Questions ==

= Do I need an Almanzor account? =

Yes. The plugin connects your site to your account, where you create the assistant and choose what it knows.

= Which values does the widget need? =

Only the agent slug. The API key and agent ID are for the connection test and content import.

= Is my content used to train AI models? =

No. Your content and conversations are used only to run your assistants and provide the service. See the [privacy policy](https://almanzor.cloud/privacy).

= Does deactivating the plugin remove my settings? =

No. Settings are removed only when you delete the plugin.

== Screenshots ==

1. The plugin's settings screen in the WordPress admin
2. The Almanzor widget on a WordPress site

== Privacy ==

This plugin stores your API key, agent ID and agent slug in the WordPress database (option `almanzor_cloud_settings`), visible to administrators. It adds no analytics of its own. See **External services** for what is sent and when.

== Changelog ==

= 1.1.0 =
* Renamed to Almanzor.
* The widget only needs the agent slug.
* The widget script now loads through the WordPress script system. Requires WordPress 6.3.
* Fix notices showing twice in the settings screen.

= 1.0.2 =
* Fix the widget not loading: the script address had `embed.js` twice.
* Fix the portal address: connection test, content sync and portal links now use almanzor.cloud. Saved settings update automatically.

= 1.0.1 =
* Fix embed snippet (`data-agent-id` and agent slug). Add agent slug setting.

= 1.0.0 =
* Initial release: settings screen, widget embed, site ingest, and connection test.
