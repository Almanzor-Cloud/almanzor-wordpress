# Almanzor Cloud for WordPress

Official WordPress plugin for [Almanzor Cloud](https://almanzor.cloud). Embed your AI assistant on your site and optionally sync public page content to your agent via the [portal API](https://almanzor.cloud/portal).

**Setup guide (marketing):** [almanzor.cloud/wordpress](https://almanzor.cloud/wordpress)

This repository (`almanzor-wordpress`) is the **WordPress integration**. It is not the marketing site, portal app, or chat runtime:

| Repo / product | Role |
| --- | --- |
| [almanzor-landing](https://github.com/Almanzor-Cloud/almanzor-landing) | Marketing site |
| [almanzor-cli](https://github.com/Almanzor-Cloud/almanzor-cli) | CLI tooling |
| **almanzor-wordpress** (this repo) | WordPress plugin |
| Portal / widget | Hosted at `almanzor.cloud` and `widget.almanzor.cloud` |

## What it does

1. **Embed** — Injects `embed.js` in the footer when an agent ID is configured.
2. **Settings** — API key, agent ID, and optional widget/portal base URLs (for staging).
3. **Connection test** — `GET /api/v1/agents/{id}` from the admin screen.
4. **Ingest** — Admin action to POST your public `home_url()` to `/api/v1/agents/{id}/ingest-url`.

```text
WordPress site
    → plugin (this repo)
        → widget.almanzor.cloud (embed.js)
        → almanzor.cloud (REST API)
```

## Requirements

- WordPress 6.0+
- PHP 8.0+

## Installation

**GitHub Release (recommended until WordPress.org listing is live)**

Download `almanzor-cloud.zip` from [Releases](https://github.com/Almanzor-Cloud/almanzor-wordpress/releases), then **Plugins → Add New → Upload Plugin**, or extract to `wp-content/plugins/almanzor-cloud/`.

**From git**

```sh
git clone https://github.com/Almanzor-Cloud/almanzor-wordpress.git almanzor-cloud
```

Place the folder at `wp-content/plugins/almanzor-cloud/` (rename the directory if you cloned as `almanzor-wordpress`).

**WordPress.org**

When approved, install from the plugin directory: search **Almanzor Cloud**. See [WORDPRESS-ORG.md](WORDPRESS-ORG.md) for the submission checklist.

## Configuration

1. In the [portal](https://almanzor.cloud/portal), create an API key (**Settings → API**) and note your agent UUID.
2. In WordPress, go to **Settings → Almanzor Cloud**.
3. Save API key and agent ID, then **Test connection**.
4. Optionally use **Ingest site content** to send your public site URL to the agent.

API keys are stored in the WordPress options table (`almanzor_cloud_settings`). They are not committed to this repository.

## Build release ZIP

```sh
chmod +x scripts/build-zip.sh
./scripts/build-zip.sh
# → dist/almanzor-cloud.zip
```

The ZIP root folder is `almanzor-cloud/`, as required by WordPress.

Directory listing assets for wordpress.org (banners, icon) live in [`.wordpress-org/`](.wordpress-org/) and are **not** included in the install ZIP.

## Development

```sh
docker run --rm -v "$PWD:/app" -w /app php:8.0-cli sh -c 'find . -name "*.php" -not -path "./vendor/*" -print0 | xargs -0 -n1 php -l'
```

Plugin bootstrap: [`almanzor-cloud.php`](almanzor-cloud.php). Classes live under [`includes/`](includes/).

## WordPress.org

See [WORDPRESS-ORG.md](WORDPRESS-ORG.md).

## License

GPL-2.0-or-later. See [LICENSE](LICENSE).
