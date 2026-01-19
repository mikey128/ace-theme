## Overview
Sets up a clean WordPress theme scaffold that matches your structure and balances performance with developer efficiency. Uses Tailwind for styling, Swiper for galleries, Carbon Fields for product meta, and CPT UI for registering the Product post type.

## Files to Add/Update
### inc/setup.php
- Adds theme supports: title-tag, post-thumbnails, menus
- Registers navigation menus

```php
<?php
function ace_setup() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  register_nav_menus([
    'primary' => 'Primary Menu',
  ]);
}
add_action('after_setup_theme', 'ace_setup');
```

### inc/assets.php
- Enqueues Tailwind-built CSS and JS
- Loads Swiper from CDN in footer, initializes per component

```php
<?php
function ace_assets() {
  wp_enqueue_style('ace-style', get_template_directory_uri() . '/assets/css/style.css', [], null);
  wp_enqueue_style('swiper', 'https://unpkg.com/swiper@11/swiper-bundle.min.css', [], '11');

  wp_enqueue_script('swiper', 'https://unpkg.com/swiper@11/swiper-bundle.min.js', [], '11', true);
  wp_enqueue_script('ace-main', get_template_directory_uri() . '/assets/js/main.js', [], null, true);
  wp_enqueue_script('ace-product-gallery', get_template_directory_uri() . '/assets/js/swiper/product-gallery.js', ['swiper'], null, true);
}
add_action('wp_enqueue_scripts', 'ace_assets');
```

### inc/carbon-fields/bootstrap.php
- Boots Carbon Fields per guideline

```php
<?php
use Carbon_Fields\Carbon_Fields;
add_action('after_setup_theme', function () { Carbon_Fields::boot(); });
```

### inc/carbon-fields/product-fields.php
- Defines product fields only (data schema). No layout logic.

```php
<?php
use Carbon_Fields\Container; use Carbon_Fields\Field;
add_action('carbon_fields_register_fields', function () {
  Container::make('post_meta', 'Product Specs')
    ->where('post_type', '=', 'product')
    ->add_fields([
      Field::make('text', 'product_model', 'Model Number'),
      Field::make('text', 'tagline', 'Tagline'),
      Field::make('image', 'main_image', 'Main Image'),
      Field::make('media_gallery', 'detail_gallery', 'Detail Gallery'),
      Field::make('complex', 'technical_specs', 'Technical Specifications')
        ->add_fields([
          Field::make('text', 'label', 'Label'),
          Field::make('text', 'spec_value', 'Value'),
        ]),
      Field::make('complex', 'optical_electrical', 'Optical & Electrical')
        ->add_fields([
          Field::make('text', 'item', 'Item'),
          Field::make('text', 'item_value', 'Value'),
        ]),
      Field::make('text', 'installation_type', 'Installation Type'),
      Field::make('text', 'housing_material', 'Housing Material'),
      Field::make('text', 'ip_rating', 'IP Rating'),
      Field::make('text', 'dimensions_text', 'Dimensions Text'),
      Field::make('image', 'dimension_image', 'Dimension Image'),
      Field::make('complex', 'application_scenarios', 'Application Scenarios')
        ->add_fields([
          Field::make('image', 'scene_image', 'Scene Image'),
          Field::make('text', 'scene_title', 'Title'),
          Field::make('textarea', 'scene_desc', 'Description'),
        ]),
      Field::make('file', 'datasheet_pdf', 'Datasheet (PDF)'),
      Field::make('file', 'ies_file', 'IES File'),
      Field::make('file', 'installation_manual', 'Installation Manual'),
    ]);
});
```

### inc/cpt-products.php (optional fallback)
- If CPT UI is not active, registers a basic ‘product’ CPT to keep dev efficient

```php
<?php
function ace_register_product_cpt() {
  if (post_type_exists('product')) return;
  register_post_type('product', [
    'label' => 'Products', 'public' => true, 'has_archive' => true,
    'supports' => ['title','editor','thumbnail'], 'show_in_rest' => true,
  ]);
}
add_action('init', 'ace_register_product_cpt');
```

### inc/helpers.php
- Small reusable helpers (formatting, safe URL retrieval)

```php
<?php
function ace_image_url($id, $size = 'large') {
  return $id ? wp_get_attachment_image_url($id, $size) : '';
}
```

### template-parts/product/card.php
- Product card using Tailwind only

```php
<article class="group">
  <a href="<?php the_permalink(); ?>" class="block">
    <img src="<?php the_post_thumbnail_url('large'); ?>" class="aspect-square object-cover rounded-lg" alt="">
    <h3 class="mt-3 text-sm font-medium"><?php the_title(); ?></h3>
  </a>
</article>
```

### template-parts/product/gallery.php
- Swiper-based gallery using Carbon Fields gallery IDs

```php
<?php $ids = carbon_get_the_post_meta('detail_gallery'); ?>
<?php if ($ids): ?>
<div class="swiper product-gallery-swiper">
  <div class="swiper-wrapper">
    <?php foreach ($ids as $id): $url = ace_image_url($id, 'large'); ?>
      <div class="swiper-slide">
        <img src="<?php echo esc_url($url); ?>" class="w-full rounded-lg" alt="">
      </div>
    <?php endforeach; ?>
  </div>
  <div class="swiper-pagination"></div>
  <div class="swiper-button-prev"></div>
  <div class="swiper-button-next"></div>
</div>
<?php endif; ?>
```

### template-parts/product/specs.php
- Table of technical specs

```php
<?php $specs = carbon_get_the_post_meta('technical_specs'); ?>
<?php if ($specs): ?>
<table class="w-full text-sm border border-gray-200">
  <tbody>
    <?php foreach ($specs as $row): ?>
      <tr class="border-b">
        <td class="px-4 py-3 bg-gray-50 w-1/3 font-medium"><?php echo esc_html($row['label']); ?></td>
        <td class="px-4 py-3"><?php echo esc_html($row['spec_value']); ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>
```

### assets/js/main.js

```js
document.addEventListener('DOMContentLoaded', () => {
  // global init hooks if needed
});
```

### assets/js/swiper/product-gallery.js

```js
document.addEventListener('DOMContentLoaded', () => {
  const el = document.querySelector('.product-gallery-swiper');
  if (!el) return;
  /* global Swiper */
  new Swiper(el, {
    loop: true,
    slidesPerView: 1,
    spaceBetween: 16,
    pagination: { el: '.swiper-pagination', clickable: true },
    navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
  });
});
```

### tailwind/input.css

```css
@tailwind base;
@tailwind components;
@tailwind utilities;
```

### tailwind/tailwind.config.js
- Scans theme PHP and JS files

```js
module.exports = {
  content: [
    './*.php',
    './**/*.php',
    './assets/js/**/*.js'
  ],
  theme: { extend: {} },
  plugins: []
}
```

### style.css (theme header)

```css
/*
Theme Name: ACE Theme
Theme URI: https://example.com
Author: ACE
Version: 1.0.0
Text Domain: ace-theme
*/
```

### functions.php (wire everything together)
- Requires inc files; matches guideline

```php
<?php
require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/assets.php';
require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/cpt-products.php';
require_once get_template_directory() . '/inc/carbon-fields/bootstrap.php';
require_once get_template_directory() . '/inc/carbon-fields/product-fields.php';
```

### index.php

```php
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <main class="max-w-7xl mx-auto px-4 py-12">
    <?php if (have_posts()): while (have_posts()): the_post(); ?>
      <article class="prose max-w-none">
        <h1 class="text-3xl font-semibold mb-4"><?php the_title(); ?></h1>
        <?php the_content(); ?>
      </article>
    <?php endwhile; endif; ?>
  </main>
  <?php wp_footer(); ?>
</body>
</html>
```

## Usage Notes
- CPT UI plugin should register the `product` post type; the fallback in `inc/cpt-products.php` keeps dev flow smooth if CPT UI isn’t active.
- Carbon Fields only defines data; templates render UI.
- Tailwind classes only; no inline styles.
- Swiper initialization is isolated per component.

## Performance & Efficiency Balance
- Minimal, clear code first; optimize when a real bottleneck is measured.
- Enqueue assets via wp_enqueue_*, load JS in footer.
- Avoid heavy logic in templates; put non-trivial logic in helpers.

## Next Steps
- Confirm and I will generate these files in your theme, wire them, and provide a basic single-product template that composes the product gallery and specs parts.
