# sraik.com — front end on the Code Craft template

WordPress stays the backend (pages, posts, media, users, plugins). The public
pages are rendered by hand-written PHP templates that reproduce the purchased
**Code Craft** Framer template section by section. Only the fonts differ:
Bricolage Grotesque (Latin) and Anek Bangla (Bengali), self-hosted.

No theme files are touched. The whole system is one mu-plugin plus one folder,
and deleting the mu-plugin hands the site back to the active theme (Astra).

```
wp-content/
├── mu-plugins/
│   └── sraik-templates.php        ← loader (routes requests to the folder below)
└── sraik-templates/
    ├── inc/                       ← PHP: router, config, helpers, components, blog, FAQ, status monitor
    │   └── content/               ← all page COPY, one PHP array per page (edit words here)
    ├── templates/                 ← one file per page (home, features, blog, single, faq, legal …)
    ├── parts/                     ← head, nav, footer, CTA + per-page sections
    └── assets/
        ├── css/                   ← base.css (design system) + one stylesheet per page
        ├── js/                    ← site.js, aurora.js (hero shader), lenis.min.js, wap.js
        ├── fonts/                 ← Bricolage Grotesque, Anek Bangla, Geist Mono (woff2)
        ├── img/                   ← brand images (+ tpl/ for reused template illustrations)
        ├── player/                ← SRAIK Player (custom YouTube player)
        └── wa-proof/              ← WhatsApp screenshot wall (images live on the server only)
```

## Pages

| URL | Template file | Notes |
|---|---|---|
| `/` | `templates/home.php` | MATACE 3.0 — copy in `inc/content/home.php` |
| `/features/` | `templates/page-features.php` | Training details, `#curriculum`, `#live` |
| `/blog/`, `/blog/page/N/` | `templates/blog.php` | latest WordPress posts, automatic |
| any post | `templates/single.php` | any post published in wp-admin, automatic |
| category / tag / author / search | `templates/blog.php` | automatic |
| `/faq/` | `templates/page-faq.php` | all FAQs from `inc/content/faq.php` |
| `/about/` | `templates/page-about.php` | |
| `/support/` | `templates/page-support.php` | payment tutorial at `#payment-video` |
| `/changelog/` | `templates/page-changelog.php` | posts in category **changelog** |
| `/status/` | `templates/page-status.php` | live uptime monitor (WP-Cron) + posts in category **incidents** |
| `/privacy-policy/`, `/terms/`, `/refund-policy/` | `templates/page-legal.php` | |
| `/mbhsc/` | `templates/page-mbhsc.php` | Mission: Bypass HSC landing page |
| anything missing | `templates/404.php` | |

These URLs work **without** creating WordPress Pages (the router adds rewrite
rules and flushes them once by itself). If a Page with the same slug exists it is
simply shadowed. Every other URL (WooCommerce, Tutor LMS, other Pages) is still
rendered by the theme.

## Blog — nothing to configure

Write a post in **wp-admin → Posts → Add New**, set a featured image, publish.
It appears on `/blog/`, in the home page "From the blog" row and at its own URL,
in the template styling. Image order: featured image → first image in the post →
a neutral placeholder. Category = the post's (primary) category. Reading time is
computed. Posts in the categories `changelog` and `incidents` stay off the blog
and feed `/changelog/` and `/status/` instead.

## Deploying to Hostinger (hPanel → File Manager, or SFTP)

1. **Back up** the current `public_html/wp-content/sraik-templates/` folder and
   `public_html/wp-content/mu-plugins/sraik-templates.php` (rename the folder to
   `sraik-templates-old`, download a copy of the file).
2. **Keep your WhatsApp screenshots**: copy the images from
   `sraik-templates-old/assets/wa-proof/` (001.jpg, 002.jpg …, and any sub-folders).
3. Upload this repo's `wp-content/sraik-templates/` to `public_html/wp-content/`
   (whole folder) and `wp-content/mu-plugins/sraik-templates.php` to
   `public_html/wp-content/mu-plugins/` (replace the old file; leave the two
   Hostinger mu-plugins alone).
4. Put the screenshots from step 2 back into `sraik-templates/assets/wa-proof/`.
5. **LiteSpeed Cache → Purge All**, then **Cloudflare → Purge Everything**
   (CSS is inlined into each page, so a cached page carries its old CSS).
6. Visit `/`, `/features/`, `/blog/`, a post, `/faq/`, `/about/`, `/support/`,
   `/status/`, `/changelog/`, `/terms/`, `/mbhsc/`, and a made-up URL (404).

Rollback: delete the new `sraik-templates` folder, rename `sraik-templates-old`
back, restore the old mu-plugin file, purge caches.

The SRAIK Player lives in `sraik-templates/assets/player/`, exactly where the
old site loaded it from. If vip.sraik.com loads the player from its own copy,
copy the four `assets/player/*` files there as well.

### After deploying

* **Real cron for /status/** — WP-Cron only runs on visits. In hPanel → Advanced →
  Cron Jobs add (every 5 minutes):
  `wget -q -O - https://sraik.com/wp-cron.php?doing_wp_cron >/dev/null 2>&1`
* **Cloudflare**: don't cache `/status/` longer than ~5 minutes (the page sends
  `Cache-Control: max-age=60`).
* `/status/` says "Status check in progress" until the first checks have run.

## Publishing changelog entries and incidents

* **Changelog** — Posts → Add New → category **Changelog**. Title, optional
  excerpt, body = a short paragraph + a bullet list. Optional custom fields:
  `version` (e.g. `3.1`) and `label` (e.g. `Feature`); a tag like `v3.1` also
  sets the version.
* **Incident** — Posts → Add New → category **Incidents**. Excerpt = one-line
  summary; body = one Heading 3 per update ("Resolved · 14:48") followed by a
  paragraph, newest first. Custom fields: `severity` (`minor` / `major` /
  `maintenance`), `affected` (e.g. `vip.sraik.com · Payment gateway`),
  `duration` (e.g. `43 min`).

Both categories are kept off `/blog/` and the archives automatically.

## Editing

* Words: `inc/content/<page>.php` (plain PHP arrays, Bengali and English).
* Links, contact details, nav and footer menus, page titles/descriptions:
  `inc/config.php`.
* FAQs: `inc/content/faq.php` (used by `/faq/` and the six on the home page,
  chosen by id in `inc/content/home.php`).
* Offer countdown on the home hero: `hero → deadline` in `inc/content/home.php`
  (ISO date with `+06:00`; empty string hides the countdown).
* Colors, type scale, spacing: `assets/css/base.css` tokens at the top.

## Development

`tools/` holds dev-only scripts (not deployed): `npm i` then `npm run icons`
regenerates `inc/icons.php` from `tools/icons.json` (lucide icons);
`measure-wordmark.js` measures the footer wordmark.
