# Almanzor Cloud for WordPress

Official WordPress plugin for [Almanzor Cloud](https://almanzor.cloud). Embed your AI assistant on your site and optionally sync public page content to your agent via the [portal API](https://portal.almanzor.cloud).

This repository (`almanzor-wordpress`) is the **WordPress integration**. It is not the marketing site, portal app, or chat runtime:

| Repo / product | Role |
| --- | --- |
| [almanzor-landing](https://github.com/Almanzor-Cloud/almanzor-landing) | Marketing site |
| [almanzor-cli](https://github.com/Almanzor-Cloud/almanzor-cli) | CLI tooling |
| **almanzor-wordpress** (this repo) | WordPress plugin |
| Portal / widget | Hosted at `portal.almanzor.cloud` and `widget.almanzor.cloud` |

## What it does

1. **Embed** — Injects `embed.js` in the footer when an agent ID is configured.
2. **Settings** — API key, agent ID, and optional widget/portal base URLs (for staging).
3. **Ingest** — Admin action to POST your public `home_url()` to `/api/v1/agents/{id}/ingest-url`.

```text
WordPress site
    → plugin (this repo)
        → widget.almanzor.cloud (embed.js)
        → portal.almanzor.cloud (REST API)
```

## Requirements

- WordPress 6.0+
- PHP 8.0+

## Installation

**From GitHub**

```sh
git clone https://github.com/Almanzor-Cloud/almanzor-wordpress.git
```

Copy the plugin folder into your site:

```text
wp-content/plugins/almanzor-cloud/
```

The folder name should match the plugin slug (`almanzor-cloud`). If you clone into `almanzor-wordpress`, rename the directory to `almanzor-cloud` or symlink it.

**From ZIP**

Download the repository as ZIP, extract, and place the contents in `wp-content/plugins/almanzor-cloud/`. Activate **Almanzor Cloud** in the WordPress admin.

## Configuration

1. In the [portal](https://portal.almanzor.cloud), create an API key (**Settings → API**) and note your agent UUID.
2. In WordPress, go to **Settings → Almanzor Cloud**.
3. Save API key and agent ID.
4. Optionally use **Ingest site content** to send your public site URL to the agent.

API keys are stored in the WordPress options table (`almanzor_cloud_settings`). They are not committed to this repository.

## Development

```sh
# Syntax check (requires Docker if PHP is not installed locally)
docker run --rm -v "$PWD:/app" -w /app php:8.0-cli sh -c 'find . -name "*.php" -not -path "./vendor/*" -print0 | xargs -0 -n1 php -l'
```

Plugin bootstrap: [`almanzor-cloud.php`](almanzor-cloud.php). Classes live under [`includes/`](includes/).

## License

GPL-2.0-or-later. See [LICENSE](LICENSE).
