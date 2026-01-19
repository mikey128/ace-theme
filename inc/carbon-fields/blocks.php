<?php
/**
 * Carbon Fields Gutenberg Blocks
 * 
 * How to use:
 * 1. Go to any page/post in Gutenberg editor
 * 2. Click the "+" button to add a block
 * 3. Search for "Product Gallery"
 * 4. Add the block and configure it using the right sidebar
 * 5. The block is now editable directly in Gutenberg!
 * 
 * This replaces the old template part approach and makes
 * content fully editable within the Gutenberg editor.
 */

use Carbon_Fields\Block;
use Carbon_Fields\Field;

// Register custom block category
add_filter('block_categories_all', function ($categories, $editor_context) {
  return $categories; // Do not add ACE category anywhere
}, 10, 2);

add_filter('allowed_block_types_all', function ($allowed_block_types, $block_editor_context) {
  $is_carbon_block = static function ($name) {
    return is_string($name) && strpos($name, 'carbon-fields/') === 0;
  };

  if (is_array($allowed_block_types)) {
    return array_values(array_filter($allowed_block_types, static function ($name) use ($is_carbon_block) {
      return ! $is_carbon_block($name);
    }));
  }

  if (! class_exists('WP_Block_Type_Registry')) {
    return $allowed_block_types;
  }

  $all = array_keys(WP_Block_Type_Registry::get_instance()->get_all_registered());
  return array_values(array_filter($all, static function ($name) use ($is_carbon_block) {
    return ! $is_carbon_block($name);
  }));
}, 10, 2);

add_action('carbon_fields_register_fields', function () {
  Block::make(__('Video Module', 'ace-theme'))
    ->set_mode('edit')
    ->set_preview_mode('live')
    ->add_fields([
      Field::make('text', 'video_title', __('Video Title', 'ace-theme'))
        ->set_help_text('Title of the video'),
      Field::make('image', 'cover_image', __('Cover Image', 'ace-theme'))
        ->set_value_type('url') // Return URL directly for easier use
        ->set_required(true),
      Field::make('file', 'video_file', __('Video File', 'ace-theme'))
        ->set_type(['video'])
        ->set_value_type('url') // Return URL directly
        ->set_required(true),
    ])
    ->set_description(__('A custom Video with rounded corners and play button.', 'ace-theme'))
    ->set_category('ace-blocks')
    ->set_icon('video-alt3')
    ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
      $title = $fields['video_title'] ?? '';
      $cover_url = $fields['cover_image'] ?? '';
      $video_url = $fields['video_file'] ?? '';

      if (empty($video_url) || empty($cover_url)) {
        if (is_admin()) {
           echo '<div class="p-4 border-2 border-dashed border-gray-300 text-center text-gray-500 rounded-lg">Please select a video and cover image.</div>';
        }
        return;
      }
      ?>
      <div class="ace-video-module relative w-full rounded-2xl overflow-hidden group aspect-video shadow-md bg-black">
        <video 
          class="w-full h-full object-cover" 
          src="<?php echo esc_url($video_url); ?>" 
          poster="<?php echo esc_url($cover_url); ?>"
          playsinline>
        </video>
        
        <div class="js-video-overlay absolute inset-0 bg-black/20 group-hover:bg-black/30 transition-colors duration-300 flex flex-col items-center justify-center cursor-pointer z-10">
          <?php if ($title): ?>
            <h3 class="text-white text-xl md:text-2xl font-bold mb-4 drop-shadow-md text-center px-4"><?php echo esc_html($title); ?></h3>
          <?php endif; ?>
          
          <div class="w-16 h-16 md:w-20 md:h-20 bg-brand-accent rounded-full flex items-center justify-center shadow-lg transform transition-transform duration-300 group-hover:scale-110 pointer-events-none">
            <svg class="w-6 h-6 md:w-8 md:h-8 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
              <path d="M8 5v14l11-7z" />
            </svg>
          </div>
        </div>
      </div>
      <?php
    });
});

add_action('carbon_fields_register_fields', function () {
  Block::make(__('Product Gallery', 'ace-theme'))
    ->set_mode('edit') // Show edit interface immediately
    ->set_preview_mode('live') // Live preview
    ->add_fields([
      Field::make('text', 'product_title', __('Product Title', 'ace-theme'))
        ->set_help_text('Leave empty to use post title'),
      Field::make('textarea', 'product_description', __('Product Description', 'ace-theme'))
        ->set_rows(4),
      Field::make('media_gallery', 'gallery_images', __('Product Gallery Images', 'ace-theme'))
        ->set_type(['image'])
        ->set_required(true)
        ->set_help_text('Add product images for the gallery'),
      Field::make('text', 'cta_primary_url', __('Primary CTA URL', 'ace-theme'))
        ->set_attribute('type', 'url')
        ->set_help_text('e.g., link to case study'),
      Field::make('text', 'cta_primary_text', __('Primary CTA Text', 'ace-theme'))
        ->set_default_value('View case'),
      Field::make('text', 'cta_secondary_url', __('Secondary CTA URL', 'ace-theme'))
        ->set_attribute('type', 'url')
        ->set_help_text('e.g., link to contact form'),
      Field::make('text', 'cta_secondary_text', __('Secondary CTA Text', 'ace-theme'))
        ->set_default_value('Ask For Samples Or Customized Solutions'),
    ])
    ->set_description(__('A responsive product gallery with main slider, thumbnails, and CTAs', 'ace-theme'))
    ->set_category('ace-blocks', __('ACE Blocks', 'ace-theme'))
    ->set_icon('images-alt2')
    ->set_keywords([__('product', 'ace-theme'), __('gallery', 'ace-theme'), __('slider', 'ace-theme')])
    ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
      $gallery_ids = $fields['gallery_images'] ?? [];
      
      if (empty($gallery_ids) || !is_array($gallery_ids)) {
        if (is_admin()) {
          echo '<div style="padding: 20px; text-align: center; background: #f0f0f0; border: 2px dashed #ccc;">';
          echo '<p>' . esc_html__('⚠️ Please add images to the gallery', 'ace-theme') . '</p>';
          echo '</div>';
        }
        return;
      }

      $product_title = $fields['product_title'] ?? get_the_title();
      $product_description = $fields['product_description'] ?? '';
      $cta_primary_url = $fields['cta_primary_url'] ?? '';
      $cta_primary_text = $fields['cta_primary_text'] ?? __('View case', 'ace-theme');
      $cta_secondary_url = $fields['cta_secondary_url'] ?? '';
      $cta_secondary_text = $fields['cta_secondary_text'] ?? __('Ask For Samples Or Customized Solutions', 'ace-theme');

      // Generate unique ID for this block instance
      $block_id = 'product-gallery-' . uniqid();
      
      ?>
      <section class="product-gallery bg-neutral-900 text-white px-4 py-10 sm:py-14 lg:py-16">
        <div class="max-w-5xl mx-auto">
          <div class="flex flex-col items-center">
            <div class="w-full max-w-3xl">
              <div class="swiper <?php echo esc_attr($block_id); ?>-main product-gallery-main rounded-xl bg-neutral-800/60 p-6 sm:p-8 flex items-center justify-center">
                <div class="swiper-wrapper">
                  <?php foreach ($gallery_ids as $image_id): ?>
                    <?php
                    $image_url = wp_get_attachment_image_url($image_id, 'large');
                    if (!$image_url) {
                      continue;
                    }
                    $image_alt = trim(get_post_meta($image_id, '_wp_attachment_image_alt', true));
                    if ($image_alt === '') {
                      $image_alt = $product_title;
                    }
                    ?>
                    <figure class="swiper-slide flex items-center justify-center">
                      <img
                        src="<?php echo esc_url($image_url); ?>"
                        alt="<?php echo esc_attr($image_alt); ?>"
                        class="max-h-80 w-auto object-contain"
                        loading="lazy"
                      >
                    </figure>
                  <?php endforeach; ?>
                </div>
              </div>

              <div class="mt-6 sm:mt-8">
                <div class="swiper <?php echo esc_attr($block_id); ?>-thumbs product-gallery-thumbs">
                  <div class="swiper-wrapper">
                    <?php foreach ($gallery_ids as $image_id): ?>
                      <?php
                      $thumb_url = wp_get_attachment_image_url($image_id, 'medium');
                      if (!$thumb_url) {
                        continue;
                      }
                      $thumb_alt = trim(get_post_meta($image_id, '_wp_attachment_image_alt', true));
                      if ($thumb_alt === '') {
                        $thumb_alt = $product_title;
                      }
                      ?>
                      <button
                        type="button"
                        class="swiper-slide group focus:outline-none"
                      >
                        <div class="h-20 sm:h-24 w-full rounded-lg border border-transparent bg-neutral-800/80 flex items-center justify-center transition-colors group-[.swiper-slide-thumb-active]:border-blue-500">
                          <img
                            src="<?php echo esc_url($thumb_url); ?>"
                            alt="<?php echo esc_attr($thumb_alt); ?>"
                            class="max-h-16 w-auto object-contain"
                            loading="lazy"
                          >
                        </div>
                      </button>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="mt-10 sm:mt-12 text-center max-w-3xl">
              <?php if ($product_title): ?>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold ">
                  <?php echo esc_html($product_title); ?>
                </h2>
              <?php endif; ?>

              <?php if ($product_description): ?>
                <p class="mt-4 text-sm sm:text-base leading-relaxed text-neutral-200">
                  <?php echo esc_html($product_description); ?>
                </p>
              <?php endif; ?>

              <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-5">
                <?php if ($cta_primary_url): ?>
                  <a
                    href="<?php echo esc_url($cta_primary_url); ?>"
                    class="inline-flex items-center justify-center rounded-full bg-brand-accent px-7 py-3 text-sm sm:text-base font-semibold text-white shadow-sm transition-colors hover:bg-blue-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900"
                  >
                    <?php echo esc_html($cta_primary_text); ?>
                  </a>
                <?php endif; ?>

                <?php if ($cta_secondary_url): ?>
                  <a
                    href="<?php echo esc_url($cta_secondary_url); ?>"
                    class="inline-flex items-center justify-center rounded-full border border-white/40 bg-white text-xs sm:text-sm font-semibold text-neutral-900 px-6 py-3 shadow-sm transition-colors hover:bg-neutral-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900 text-center"
                  >
                    <?php echo esc_html($cta_secondary_text); ?>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </section>
      <?php
    });
});

add_action('carbon_fields_register_fields', function () {
  Block::make(__('Quick Product Nav', 'ace-theme'))
    ->set_mode('edit')
    ->set_preview_mode('live')
    ->set_description(__('Quick navigation for product sections', 'ace-theme'))
    ->set_category('ace-blocks')
    ->set_icon('menu')
    ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
      if (is_admin()) {
        echo '<div style="padding: 14px 16px; border: 1px dashed #cbd5e1; border-radius: 8px; color: #475569; background: #f8fafc;">Quick Product Nav</div>';
        return;
      }
      get_template_part('template-parts/product/quick-product-nav');
    });
});

add_action('carbon_fields_register_fields', function () {
  Block::make(__('Product Features', 'ace-theme'))
    ->set_mode('edit')
    ->set_preview_mode('live')
    ->set_description(__('Renders Product Features from Carbon Fields product meta.', 'ace-theme'))
    ->set_category('ace-blocks')
    ->set_icon('index-card')
    ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
      if (is_admin()) {
        echo '<div style="padding: 14px 16px; border: 1px dashed #cbd5e1; border-radius: 8px; color: #475569; background: #f8fafc;">' . esc_html__('Product Features (uses Carbon Fields product meta).', 'ace-theme') . '</div>';
        return;
      }

      get_template_part('template-parts/product/product-features');
    });
});

add_action('carbon_fields_register_fields', function () {
  Block::make(__('Product Applications', 'ace-theme'))
    ->set_mode('edit')
    ->set_preview_mode('live')
    ->set_description(__('Renders Product Applications from Carbon Fields product meta.', 'ace-theme'))
    ->set_category('ace-blocks')
    ->set_icon('screenoptions')
    ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
      if (is_admin()) {
        echo '<div style="padding: 14px 16px; border: 1px dashed #cbd5e1; border-radius: 8px; color: #475569; background: #f8fafc;">' . esc_html__('Product Applications (uses Carbon Fields product meta).', 'ace-theme') . '</div>';
        return;
      }

      get_template_part('template-parts/product/product-applications');
    });
});

add_action('carbon_fields_register_fields', function () {
  Block::make(__('Product Specs', 'ace-theme'))
    ->set_mode('edit')
    ->set_preview_mode('live')
    ->set_description(__('Renders Product Specs from Carbon Fields product meta.', 'ace-theme'))
    ->set_category('ace-blocks')
    ->set_icon('excerpt-view')
    ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
      if (is_admin()) {
        echo '<div style="padding: 14px 16px; border: 1px dashed #cbd5e1; border-radius: 8px; color: #475569; background: #f8fafc;">' . esc_html__('Product Specs (uses Carbon Fields product meta).', 'ace-theme') . '</div>';
        return;
      }

      get_template_part('template-parts/product/product-specs');
    });
});

add_action('carbon_fields_register_fields', function () {
  Block::make(__('Media Carousel', 'ace-theme'))
    ->set_mode('edit')
    ->set_preview_mode('live')
    ->set_description(__('Renders Media Carousel from Carbon Fields product meta.', 'ace-theme'))
    ->set_category('ace-blocks')
    ->set_icon('images-alt')
    ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
      if (is_admin()) {
        echo '<div style="padding: 14px 16px; border: 1px dashed #cbd5e1; border-radius: 8px; color: #475569; background: #f8fafc;">' . esc_html__('Media Carousel (uses Carbon Fields product meta).', 'ace-theme') . '</div>';
        return;
      }

      get_template_part('template-parts/product/media-carousel');
    });
});

/**
 * Register Product Patterns
 */
add_action('init', function () {
  if (!function_exists('register_block_pattern_category')) {
    return;
  }

  // Register "Product" category in Patterns tab
  register_block_pattern_category(
    'ace-product',
    ['label' => __('Product', 'ace-theme')]
  );

  // Register Product Gallery Pattern
  register_block_pattern(
    'ace-theme/product-gallery',
    [
      'title'       => __('Product Gallery', 'ace-theme'),
      'description' => __('A pre-configured product gallery module', 'ace-theme'),
      'categories'  => ['ace-product'],
      'content'     => '<!-- wp:carbon-fields/product-gallery /-->',
    ]
  );
});

