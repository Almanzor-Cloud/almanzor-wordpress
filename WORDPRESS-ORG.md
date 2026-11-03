# Publishing on WordPress.org

Only the account owner can do steps 1, 3 and 4.

## Submit

1. **Account:** create `almanzorcloud` on [wordpress.org](https://login.wordpress.org/register). `Contributors:` in `readme.txt` must match it.
2. **ZIP:** run `./scripts/build-zip.sh`. It must contain a single top-level folder, `almanzor/`.
3. **Plugin Check:** on a test site, install [Plugin Check](https://wordpress.org/plugins/plugin-check/) and run it on the plugin. Fix any errors.
4. **Upload:** send `dist/almanzor.zip` at [Add your plugin](https://wordpress.org/plugins/developers/add/). The form shows the slug it will get (`almanzor`), and it can't be changed after approval. If you need a different one, ask the review team in your reply, before approval.
5. **Review:** answer the plugins team's emails.

## After approval

WordPress.org gives you an SVN repository:

```text
assets/      → banners, icon and screenshots, from .wordpress-org/
trunk/       → the plugin files, from the ZIP
tags/1.1.1/  → frozen copy of each release
```

Copy the files, then `svn add` and `svn commit`. `Stable tag:` in `readme.txt` must match the tag.

## Then update the links

Replace the GitHub download with `https://wordpress.org/plugins/almanzor/` in:

- `lib/marketing/pages-copy.ts` in almanzor-portal (the page at /integrations/wordpress)
- `components/portal/agents/channels/wordpress-plugin-steps.tsx` in almanzor-portal
- This repo's README

## Releases on GitHub

Keep tagging (`v1.1.1`, …) and attaching the ZIP for anyone who installs from there.
