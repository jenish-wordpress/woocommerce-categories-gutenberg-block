=== Category Display for WooCommerce ===
Contributors: jenish dholakiya
Donate link: https://github.com/jenish-wordpress/woocommerce-categories-gutenberg-block
Tags: category grid, category slider, gutenberg, product categories, category display
Requires at least: 6.0
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Display WooCommerce product categories in beautiful grid or slider layouts. Native Gutenberg block with live editor preview.

== Description ==

**Category Display for WooCommerce** is a Gutenberg block plugin that lets you showcase product categories in responsive **grid** or **slider** layouts with advanced filtering and sorting options.

The block shows a **live preview inside the editor** — exactly as it will appear on the frontend — so you always know what your visitors will see.

### Key Features

* **Grid Layout** — Responsive grid with 1–6 columns
* **Slider Layout** — Touch-enabled carousel with navigation and pagination
* **Live Editor Preview** — See real categories directly in the block editor
* **Category Limit** — Show all or limit to a specific number
* **Sort Options** — Sort by name, count, ID, or slug
* **Order Control** — Ascending or descending
* **Product Count** — Show/hide product count per category
* **Hide Empty Categories** — Toggle categories with no products
* **Fully Responsive** — Mobile, tablet, and desktop optimised
* **Native Gutenberg** — No page builder required
* **Lightweight** — Swiper.js bundled locally, no CDN dependency
* **SEO Friendly** — Clean semantic HTML with lazy-loaded images
* **Translation Ready** — Fully internationalised (i18n)

### Customisation

CSS classes for custom styling:

* `.cat-display-block` — Main container
* `.cat-display-layout-grid` — Grid layout
* `.cat-display-layout-slider` — Slider layout
* `.cat-display-item` — Individual category card
* `.cat-display-title` — Category name
* `.cat-display-count` — Product count

== Installation ==

= Automatic =

1. Go to **Plugins → Add New** in your WordPress admin
2. Search for **Category Display for WooCommerce**
3. Click **Install Now**, then **Activate**

= Manual =

1. Download the plugin ZIP
2. Go to **Plugins → Add New → Upload Plugin**
3. Upload the ZIP and activate

= Requirements =

* WordPress 6.0+
* WooCommerce 6.0+
* PHP 7.4+

== Frequently Asked Questions ==

= Does this require WooCommerce? =

Yes, WooCommerce must be installed and active.

= Does it show a live preview in the editor? =

Yes. The block fetches your real categories and renders them inside the block editor exactly as they appear on the frontend.

= Can I use it in a slider layout? =

Yes. Switch to Slider in the block settings and configure columns (slides visible at once).

= Is Swiper loaded from a CDN? =

No. Swiper is bundled locally inside the plugin — no external requests.

= Can I display all categories? =

Yes. Toggle "Show All Categories" in the block settings.

= Is it translation ready? =

Yes, fully internationalised.

== Screenshots ==

1. Grid layout on the frontend
2. Slider layout with navigation arrows
3. Live category preview inside the block editor
4. Block settings panel
5. Mobile responsive display

== Changelog ==

= 1.0.0 =
* Initial release
* Grid layout (1–6 columns)
* Slider layout with Swiper.js (bundled locally)
* Live editor preview using real WooCommerce categories
* Sort, order, limit, count, and hide-empty controls
* Fully responsive
* Translation ready

== Upgrade Notice ==

= 1.0.0 =
Initial release.

== Third Party Libraries ==

**Swiper.js** — bundled locally inside `/assets/`
* Purpose: Slider / carousel functionality
* License: MIT
* Homepage: https://swiperjs.com

No data is sent to any external server. Swiper is served from the plugin's own asset folder.
