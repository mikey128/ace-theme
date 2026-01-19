# ace-theme

A custom WordPress theme built on Carbon Fields for flexible content management.

## Requirements

- WordPress 5.0+
- PHP 7.4+
- Composer

## Installation

### 1. Clone the theme

Place this theme in your `wp-content/themes/` directory.

### 2. Install dependencies

Open a terminal in the theme directory and run:

```bash
composer install --no-dev
```

This will install Carbon Fields and other dependencies.

### 3. Activate the theme

Go to **WordPress Admin → Appearance → Themes** and activate the ACE Theme.

## Features

### Carbon Fields Gutenberg Blocks

This theme includes custom Gutenberg blocks built with Carbon Fields:

- **Product Gallery** - A responsive product image gallery with thumbnails, title, description, and CTAs

#### Using the Product Gallery Block

1. Edit any page or post in the Gutenberg editor
2. Click the "+" button to add a block
3. Search for "Product Gallery"
4. Add the block and configure it:
   - Add gallery images
   - Set product title and description
   - Add CTA button URLs and text
5. The block will render a beautiful product showcase with Swiper slider

### Custom Post Types

- **Products** - Custom post type for product management

### Custom Fields

Product posts include comprehensive custom fields for:
- Product specifications
- Technical details
- Gallery images
- Application scenarios
- Downloadable resources (datasheets, IES files, manuals)

## Development

### File Structure

```
ace-theme/
├── assets/
│   ├── css/
│   └── js/
│       └── swiper/
├── inc/
│   ├── carbon-fields/
│   │   ├── bootstrap.php    # Carbon Fields initialization
│   │   ├── blocks.php        # Gutenberg blocks
│   │   └── product-fields.php # Product custom fields
│   ├── assets.php            # Asset enqueuing
│   ├── cpt-products.php      # Custom post types
│   ├── helpers.php           # Helper functions
│   └── setup.php             # Theme setup
├── template-parts/
│   └── product/
├── vendor/                    # Composer dependencies (gitignored)
├── composer.json
├── functions.php
└── style.css
```

### Customization

#### Adding New Blocks

Edit `inc/carbon-fields/blocks.php` and add new blocks using the Carbon Fields Block API:

```php
Block::make(__('My Block', 'ace-theme'))
    ->add_fields([
        Field::make('text', 'my_field', __('My Field', 'ace-theme')),
    ])
    ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
        // Render your block
    });
```

#### Styling

- Main styles: `assets/css/style.css`
- Tailwind config: `tailwind/tailwind.config.js`
- Tailwind input: `tailwind/input.css`

## Troubleshooting

### Block not appearing in editor

1. Make sure Carbon Fields is installed: `composer install`
2. Clear WordPress cache
3. Refresh the Gutenberg editor (Ctrl+F5)
4. Check browser console for JavaScript errors

### Images not loading

Make sure the helper function `ace_image_url()` is available in `inc/helpers.php`.

## Credits

- Built with [Carbon Fields](https://carbonfields.net/)
- Slider powered by [Swiper](https://swiperjs.com/)
- Styled with [Tailwind CSS](https://tailwindcss.com/)

## License

This theme is proprietary and all rights are reserved.
