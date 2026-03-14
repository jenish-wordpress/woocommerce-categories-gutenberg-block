# Category Display for WooCommerce — Free Gutenberg Block Plugin

[![WordPress](https://img.shields.io/badge/WordPress-6.0%2B-blue?style=flat-square)](https://wordpress.org/plugins/category-display-for-woocommerce)
[![WooCommerce](https://img.shields.io/badge/WooCommerce-6.0%2B-96588a?style=flat-square)](https://woocommerce.com)
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?style=flat-square)](https://php.net)
[![License](https://img.shields.io/badge/License-GPL%20v2-green?style=flat-square)](https://www.gnu.org/licenses/gpl-2.0.html)
[![WordPress Plugin Version](https://img.shields.io/wordpress/plugin/v/category-display-for-woocommerce?style=flat-square&label=Version)](https://wordpress.org/plugins/category-display-for-woocommerce)
[![Active Installs](https://img.shields.io/wordpress/plugin/installs/category-display-for-woocommerce?style=flat-square)](https://wordpress.org/plugins/category-display-for-woocommerce)
[![Rating](https://img.shields.io/wordpress/plugin/rating/category-display-for-woocommerce?style=flat-square)](https://wordpress.org/plugins/category-display-for-woocommerce/reviews/)

**Category Display for WooCommerce** is a free, lightweight native Gutenberg block that displays WooCommerce product categories in a responsive grid or slider layout — no page builder required, with live editor preview.

🔗 [WordPress.org Plugin Page](https://wordpress.org/plugins/category-display-for-woocommerce)
&nbsp;|&nbsp;
📦 [Download Latest Release](https://github.com/jenish-wordpress/woocommerce-categories-gutenberg-block/releases)
&nbsp;|&nbsp;
🐛 [Report a Bug](https://github.com/jenish-wordpress/woocommerce-categories-gutenberg-block/issues)
&nbsp;|&nbsp;
💬 [Support Forum](https://wordpress.org/support/plugin/category-display-for-woocommerce)

---

## Table of Contents

- [Overview](#overview)
- [Screenshots](#screenshots)
- [Features](#features)
- [Installation](#installation)
- [How to Use](#how-to-use)
- [Development Setup](#development-setup)
- [CSS Classes](#css-classes-for-custom-styling)
- [Roadmap](#roadmap)
- [FAQ](#faq)
- [Contributing](#contributing)
- [Changelog](#changelog)
- [License](#license)

---

## Overview

Displaying WooCommerce product categories cleanly on a store homepage or landing page is one of the most common requirements — yet most available solutions either depend on a heavy page builder or sit behind a paid plan.

**Category Display for WooCommerce** solves this with a single native Gutenberg block. It plugs directly into the WordPress block editor, fetches your real WooCommerce `product_cat` terms via the REST API, and renders them as a live preview inside the editor — exactly as they appear on the frontend.

No Elementor. No Divi. No Pro upsell for basic features.

### Who Is This For?

- WooCommerce store owners who use the Gutenberg block editor
- WordPress developers building client stores without a page builder
- Developers looking for a clean, standards-compliant block plugin to extend

---

## Screenshots

| Grid Layout | Slider Layout | Live Editor Preview |
|:-----------:|:-------------:|:-------------------:|
| ![Grid Layout](assets/screenshot-1.png) | ![Slider Layout](assets/screenshot-2.png) 

---

## Features

### Layout & Display
| Feature | Details |
|---|---|
| Grid Layout | Responsive CSS grid, 1–6 columns, fluid breakpoints |
| Slider Layout | Touch-enabled carousel — Swiper.js v11, bundled locally |
| Live Editor Preview | Real `product_cat` terms rendered inside Gutenberg |
| Wide & Full Alignment | Native block alignment support |

### Category Controls
| Feature | Details |
|---|---|
| Category Limit | Show all or limit to 1–50 categories |
| Sort Options | Name, product count, term ID, or slug |
| Order Control | Ascending or descending |
| Product Count | Show or hide product count per category |
| Hide Empty | Toggle categories with zero products |

### Performance & Standards
| Feature | Details |
|---|---|
| No Page Builder | Native Gutenberg — works with any theme |
| Local Swiper Bundle | No CDN, no external network requests |
| Lazy Loading | `loading="lazy"` on all category images |
| PHPCS Compliant | Follows WordPress Coding Standards throughout |
| Escaped Output | All output properly escaped — secure by default |
| i18n Ready | Fully internationalised, `.pot` file included |
| Semantic HTML | Clean, accessible, SEO-friendly markup |

---

## Installation

### From WordPress.org (Recommended)

1. Go to **WordPress Admin → Plugins → Add New**
2. Search for **Category Display for WooCommerce**
3. Click **Install Now** then **Activate**
4. Open any page in the block editor, add the **Category Display** block

### Manual Installation

1. Download the latest ZIP from [Releases](https://github.com/jenish-wordpress/woocommerce-categories-gutenberg-block/releases)
2. Go to **WordPress Admin → Plugins → Add New → Upload Plugin**
3. Upload the ZIP and click **Activate**

### Requirements

| | Minimum |
|---|---|
| WordPress | 6.0 |
| WooCommerce | 6.0 |
| PHP | 7.4 |

---

## How to Use

1. Make sure WooCommerce is installed and you have at least one product category
2. Open any page or post in the Gutenberg block editor
3. Click **+** and search for **Category Display**
4. Insert the block — your live WooCommerce categories appear immediately
5. Use the **Settings panel** on the right to:
   - Switch between Grid and Slider layout
   - Set the number of columns (1–6)
   - Control how many categories to display
   - Change sort order and direction
   - Toggle product count and empty category visibility
6. Publish or update the page

---

## Development Setup

### Prerequisites

- Node.js 16+
- npm 8+
- A local WordPress install with WooCommerce active

### Clone & Build

```bash
# Clone the repository
git clone https://github.com/jenish-wordpress/woocommerce-categories-gutenberg-block.git

# Move into the plugin directory
cd woocommerce-categories-gutenberg-block

# Install dependencies
npm install

# Start development with hot reload
npm run start

# Build for production
npm run build
```

### Folder Structure

```
category-display-for-woocommerce/
│
├── assets/
│   ├── frontend.js               # Slider initialisation (vanilla JS, no jQuery)
│   ├── style.css                 # Extra frontend styles
│   ├── swiper-bundle.min.js      # Swiper.js v11 — bundled locally
│   └── swiper-bundle.min.css     # Swiper.js styles — bundled locally
│
├── build/                        # Compiled output — generated by npm run build
│   ├── block.json
│   ├── index.js
│   ├── index.css
│   ├── style-index.css
│   └── render.php
│
├── src/
│   ├── block.json                # Block metadata, attributes, supports
│   ├── index.js                  # Block registration entry point
│   ├── edit.js                   # Editor component with live REST API preview
│   ├── render.php                # PHP server-side render callback
│   ├── style.scss                # Frontend styles (compiled to build/)
│   └── editor.scss               # Editor-only styles
│
├── category-display-for-woocommerce.php    # Main plugin bootstrap file
├── readme.txt                              # WordPress.org readme
└── package.json
```

---

## CSS Classes for Custom Styling

Override these classes in your theme's `style.css` or via **Appearance → Customize → Additional CSS**:

```css
/* Main block wrapper */
.cat-display-block { }

/* Layout modifiers */
.cat-display-layout-grid   { }
.cat-display-layout-slider { }

/* Column count modifiers (1 through 6) */
.cat-display-cols-3 { }

/* Category card */
.cat-display-item   { }
.cat-display-image  { }
.cat-display-content { }
.cat-display-title  { }
.cat-display-count  { }
```

---

## Roadmap

The following features are planned for upcoming releases:

- [ ] Custom card color and background options
- [ ] Category image hover overlay with title
- [ ] Hand-pick specific categories to display
- [ ] Drag-and-drop custom category ordering
- [ ] Ajax-powered live category filtering
- [ ] Multiple slider skin options
- [ ] Pro version with advanced layouts

> Have a feature request? [Open an issue](https://github.com/jenish-wordpress/woocommerce-categories-gutenberg-block/issues) — community feedback shapes the roadmap.

---

## FAQ

**Does this plugin require WooCommerce?**
Yes. WooCommerce must be installed and activated for the block to display categories.

**Does it work with any WordPress theme?**
Yes. It is a native Gutenberg block and works with any theme that supports the block editor.

**Is Swiper.js loaded from a CDN?**
No. Swiper.js is bundled inside the plugin's `assets/` folder. No external network requests are made.

**Does it show a live preview in the editor?**
Yes. The block uses `@wordpress/core-data` to fetch real `product_cat` terms from the REST API and renders them live inside the editor.

**Can I display all categories without a limit?**
Yes. Toggle **Show All Categories** in the block settings panel.

**Will this affect my site's performance?**
No. Images use native lazy loading, Swiper is loaded locally, and the block outputs clean semantic HTML with no render-blocking resources.

---

## Contributing

Contributions are welcome. Please open an issue before submitting a pull request for major changes.

1. Fork the repository
2. Create a feature branch — `git checkout -b feature/your-feature-name`
3. Commit your changes — `git commit -m "Add: description of change"`
4. Push to your branch — `git push origin feature/your-feature-name`
5. Open a Pull Request against the `main` branch

Please follow [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/) for all PHP contributions.

---

## Support

| Channel | Link |
|---|---|
| Bug Reports | [GitHub Issues](https://github.com/jenish-wordpress/woocommerce-categories-gutenberg-block/issues) |
| General Questions | [WordPress.org Support Forum](https://wordpress.org/support/plugin/category-display-for-woocommerce) |
| Feature Requests | [GitHub Issues](https://github.com/jenish-wordpress/woocommerce-categories-gutenberg-block/issues) |
| Leave a Review | [WordPress.org Reviews](https://wordpress.org/support/plugin/category-display-for-woocommerce/reviews/#new-post) |

---

## Changelog

### 1.0.0 — March 2026

- Initial release
- Grid layout with 1–6 responsive columns
- Slider layout with Swiper.js v11 (bundled locally)
- Live Gutenberg editor preview via WordPress REST API
- Sort by name, count, ID, or slug — ascending or descending
- Show or hide product count per category
- Hide empty categories toggle
- Wide and full alignment support
- Fully responsive — mobile, tablet, desktop
- PHPCS compliant — WordPress Coding Standards throughout
- Translation ready with i18n support

---

## License

Licensed under the **GNU General Public License v2.0 or later**.
See [LICENSE](LICENSE) for the full license text.

---

## Author

**Jenish Dholakiya**

[![GitHub](https://img.shields.io/badge/GitHub-jenish--wordpress-181717?style=flat-square&logo=github)](https://github.com/jenish-wordpress)
[![WordPress.org](https://img.shields.io/badge/WordPress.org-Plugin%20Page-21759b?style=flat-square&logo=wordpress)](https://wordpress.org/plugins/category-display-for-woocommerce)

---

<p align="center">
  If this plugin saved you time, consider giving it a ⭐ on GitHub and a
  <a href="https://wordpress.org/support/plugin/category-display-for-woocommerce/reviews/#new-post">5-star review on WordPress.org</a>
  — it helps other store owners and developers find it.
</p>
