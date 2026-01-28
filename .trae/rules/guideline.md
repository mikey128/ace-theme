---
alwaysApply: false
---
Project: ace-theme (WordPress + Tailwind + Carbon Fields + Swiper)

Theme:
- Folder: ace-theme, Slug: ace_theme, Text Domain: ace-theme
- Functions prefixed with ace_
- Each file has a single responsibility

Structure:
- assets/: js/, images/, fonts/
- inc/: setup.php, assets.php, cpt-products.php, helpers.php, carbon-fields/ (bootstrap.php, product-fields.php, theme-options.php, blocks/)
- template-parts/product/: card.php, gallery.php, specs.php
- tailwind/: input.css, tailwind.config.js
- functions.php, index.php, style.css

Carbon Fields:
- Installed via Composer/plugin, do not bundle core
- Bootstrap: inc/carbon-fields/bootstrap.php → Carbon_Fields::boot()
- All registrations in inc/carbon-fields/
- Fields (product-fields.php): text, rich_text, select, complex, media, media_gallery, association
- Forbidden: layout logic or repeated display labels in templates
- Templates access via carbon_get_post_meta()
- Reusable layouts → Carbon Fields blocks (inc/carbon-fields/blocks/)

Tailwind:
- Utility classes only, mobile-first
- Purge enabled
- No unnecessary custom CSS

JavaScript & Swiper:
- Vanilla JS, modular, no global pollution
- One Swiper instance per component, no inline config

Templates:
- Render only, no business logic
- Loops: simple control, escaping, direct output
- Complex or reusable logic → helpers.php
- Optimize for clarity; micro-optimizations only if measured bottleneck

Performance:
- Lazy-load images, avoid blocking JS
- wp_enqueue_* for all assets
- Server-side rendering preferred for product data

Security:
- Escape output (esc_html, esc_attr, esc_url)
- Sanitize Carbon Fields input
- Never trust frontend data

Dev Workflow:
- Small, composable functions
- No anonymous functions in templates
- Prioritize maintainability and clarity over premature optimization
