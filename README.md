# Almanzor for WordPress

WordPress plugin for [Almanzor](https://almanzor.cloud), by Almanzor Cloud OÜ. Shows your AI assistant on your site and imports your public pages into it through the [portal API](https://almanzor.cloud/docs/api).

**Setup guide:** [almanzor.cloud/integrations/wordpress](https://almanzor.cloud/integrations/wordpress)

## What it does

1. **Widget** — Loads `embed.js` on public pages once an agent slug is saved.
2. **Settings** — Agent slug, plus API key and agent ID for the admin actions, and optional widget and portal URLs (for staging).
3. **Connection test** — `GET /api/v1/agents/{id}` from the admin screen.
4. **Import** — Admin action that POSTs your public `home_url()` to `/api/v1/agents/{id}/ingest-url`.

```text
WordPress site
    → plugin (this repo)
        → widget.almanzor.cloud (embed.js)
        → almanzor.cloud (REST API)
```

## Requirements

- WordPress 6.3+
- PHP 8.0+

## Installation

Until the WordPress.org listing is live, download the ZIP from [Releases](https://github.com/Almanzor-Cloud/almanzor-wordpress/releases), then **Plugins → Add New → Upload Plugin**.

Coming from `almanzor-cloud` (1.0.x)? Deactivate and delete the old plugin first: both use the same settings, so install the new one and they stay, or re-enter them if you deleted the old one before installing.

## Configuration

1. In the [portal](https://almanzor.cloud/portal), open your assistant → **Channels → Widget → WordPress** and copy the slug.
2. In WordPress, go to **Settings → Almanzor** and save it. The widget now shows on your site.
3. For **Test connection** and **Import site content**, also add an API key (**Settings → API keys** in the portal) and the agent ID.

Settings are stored in the WordPress options table (`almanzor_cloud_settings`, a name kept from 1.0.x so they carry over).

## Build release ZIP

```sh
./scripts/build-zip.sh
# → dist/almanzor.zip
```

The ZIP root folder is `almanzor/`, as WordPress requires. Directory assets (banners, icon, screenshots) live in [`.wordpress-org/`](.wordpress-org/) and are not in the ZIP.

## Development

Plugin bootstrap: [`almanzor.php`](almanzor.php). Classes live under [`includes/`](includes/).

To publish on WordPress.org, see [WORDPRESS-ORG.md](WORDPRESS-ORG.md).

## License

GPL-2.0-or-later. See [LICENSE](LICENSE).
