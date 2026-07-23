# Database

The database is not stored in GitHub because it contains private WordPress data:

- user accounts;
- WooCommerce customer data;
- website content;
- plugin configuration;
- private settings.

## Restore process

1. Install a clean WordPress instance locally.
2. Install required plugins listed in:


docs/plugins.md


3. Create a new database.
4. Import the SQL dump.
5. Update database credentials in:


wp-config.php


6. Update site URLs after import.

Example:

Replace:


https://old-site.com


with:


http://e-pharmacy.local


Use:

- Better Search Replace plugin
- WP-CLI search-replace command

7. Go to:


WordPress Admin → Settings → Permalinks


and click:


Save Changes


to refresh rewrite rules.

---

## Included data

The database contains:

- Gutenberg pages and blocks;
- WooCommerce products;
- Custom Post Types;
- Advanced Custom Fields (ACF) data;
- GeneratePress theme settings;
- GenerateBlocks layouts;
- plugin settings;
- WordPress menus;
- website options.

---

## Required after restore

Check:

- WooCommerce pages;
- payment and shipping settings;
- Rank Math SEO settings;
- image regeneration if required;
- cache regeneration with LiteSpeed Cache.