# WordPress.org submission checklist

Manual steps to list **Almanzor Cloud** in the official plugin directory. Cursor cannot submit on your behalf.

## Before you submit

1. **WordPress.org account** — Register at [wordpress.org](https://wordpress.org). The `Contributors:` field in `readme.txt` must match your username (currently `almanzorcloud`). Create that account or update `readme.txt`.
2. **Plugin Check** — Install [Plugin Check](https://wordpress.org/plugins/plugin-check/) on a test site and run it against this plugin.
3. **Test site** — WordPress 6.x, PHP 8.0+, activate plugin, save settings, run **Test connection**, confirm widget on front end, run **Ingest site content**.
4. **ZIP layout** — Build with `./scripts/build-zip.sh`. The archive must contain a single top-level folder `almanzor-cloud/` (not `almanzor-wordpress-main/`).

## Submit

1. Go to [Add your plugin](https://wordpress.org/plugins/developers/add/).
2. Upload `dist/almanzor-cloud.zip`.
3. Wait for email review (often several days to weeks). Respond to any feedback from the plugins team.

## After approval

WordPress.org provides an **SVN** repository:

```text
assets/          → banner and icon (from .wordpress-org/ in this GitHub repo)
trunk/           → current development copy of the plugin files
tags/1.0.0/      → frozen copy for each release
```

1. Copy plugin files to `trunk/`.
2. Copy `.wordpress-org/*` to SVN `assets/`.
3. Copy `trunk/` to `tags/1.0.0/` for version 1.0.0.
4. Set `Stable tag: 1.0.0` in `readme.txt` on trunk (already set).

## Update marketing links

When the plugin is live, replace GitHub-only install links with:

`https://wordpress.org/plugins/almanzor-cloud/`

(if WordPress assigns a different slug, use the URL they give you)

Update:

- [almanzor.cloud/wordpress](https://almanzor.cloud/wordpress)
- Portal **Share → WordPress** block
- This repo’s README

## Releases on GitHub

Keep tagging (`v1.0.0`, `v1.0.1`, …) and attaching `dist/almanzor-cloud.zip` for users who install from GitHub before or instead of WordPress.org.
