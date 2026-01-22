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

// Register custom block category (always show first)

add_filter('block_categories_all', function ($categories, $editor_context) {
  $ace = [
    'slug'  => 'ace-blocks',
    'title' => __('Custom ACE Blocks', 'ace-theme'),
  ];
  $categories = array_values(array_filter($categories, function ($cat) {
    return !isset($cat['slug']) || $cat['slug'] !== 'ace-blocks';
  }));
  array_unshift($categories, $ace);
  return $categories;
}, 999, 2);

// Fallback for older WordPress (<5.8)

add_filter('block_categories', function ($categories, $post) {
  $ace = [
    'slug'  => 'ace-blocks',
    'title' => __('Custom ACE Blocks', 'ace-theme'),
  ];
  $categories = array_values(array_filter($categories, function ($cat) {
    return !isset($cat['slug']) || $cat['slug'] !== 'ace-blocks';
  }));
  array_unshift($categories, $ace);
  return $categories;
}, 999, 2);

// Ensure no external filter is blocking custom blocks
add_filter('allowed_block_types_all', function ($allowed_block_types, $block_editor_context) {
  return true; // allow all blocks
}, 1, 2);

add_action('carbon_fields_register_fields', function () {
  Block::make(__('Custom Video', 'ace-theme'))
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
      Field::make('select', 'layout_width', __('Layout Width', 'ace-theme'))
        ->set_options([
          'full'      => __('Full Width', 'ace-theme'),
          'container' => __('Container Width', 'ace-theme'),
          'narrow'    => __('Narrow', 'ace-theme'),
        ])
        ->set_default_value('container'),
    ])
    ->set_description(__('A custom Video with rounded corners and play button.', 'ace-theme'))
    ->set_category('ace-blocks')
    ->set_icon('video-alt3')
    ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
      $title = $fields['video_title'] ?? '';
      $cover_url = $fields['cover_image'] ?? '';
      $video_url = $fields['video_file'] ?? '';
      $width_sel = $fields['layout_width'] ?? 'container';
      $wrap = $width_sel === 'full' ? 'w-full px-6' : ($width_sel === 'narrow' ? 'max-w-3xl mx-auto px-6' : 'max-w-7xl mx-auto px-6 max-w-global');

      if (empty($video_url) || empty($cover_url)) {
        if (is_admin()) {
           echo '<div class="p-4 border-2 border-dashed border-gray-300 text-center text-gray-500 rounded-lg">Please select a video and cover image.</div>';
        }
        return;
      }
      ?>
      <div class="<?php echo esc_attr($wrap); ?>">
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
      </div>
      <?php
    });
});

add_action('carbon_fields_register_fields', function () {
  Block::make(__('Media Carousel', 'ace-theme'))
    ->set_mode('edit')
    ->set_preview_mode('live')
    ->add_fields([
      Field::make('select', 'media_width', __('Layout Width', 'ace-theme'))
        ->set_options([
          'full'      => __('Full Width', 'ace-theme'),
          'container' => __('Container Width', 'ace-theme'),
          'narrow'    => __('Narrow', 'ace-theme'),
        ])
        ->set_default_value('container'),
    ])
    ->set_description(__('Renders Media Carousel from Carbon Fields product meta.', 'ace-theme'))
    ->set_category('ace-blocks')
    ->set_icon('images-alt')
    ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
      $width_sel = $fields['media_width'] ?? 'container';
      $wrap = $width_sel === 'full' ? 'w-full px-6' : ($width_sel === 'narrow' ? 'max-w-3xl mx-auto px-6' : 'max-w-7xl mx-auto px-6 max-w-global');
      if (is_admin()) {
        echo '<div style="padding: 14px 16px; border: 1px dashed #cbd5e1; border-radius: 8px; color: #475569; background: #f8fafc;">' . esc_html__('Media Carousel (uses Carbon Fields product meta).', 'ace-theme') . '</div>';
        return;
      }
      echo '<div class="' . esc_attr($wrap) . '">';
      get_template_part('template-parts/product/media-carousel');
      echo '</div>';
    });
});

add_action('carbon_fields_register_fields', function () {
  Block::make(__('Testimonials Carousel', 'ace-theme'))
    ->set_mode('edit')
    ->set_preview_mode('live')
    ->add_fields([
      Field::make('text', 'testimonials_title', __('Section Title', 'ace-theme'))
        ->set_default_value('What Our Customers Say'),
      Field::make('textarea', 'testimonials_description', __('Section Description', 'ace-theme'))
        ->set_rows(3),
      Field::make('checkbox', 'testimonials_full_width', __('Full Width', 'ace-theme'))
        ->set_help_text('Enable full width layout'),
      Field::make('select', 'testimonials_width', __('Layout Width', 'ace-theme'))
        ->set_options([
          'full'      => __('Full Width', 'ace-theme'),
          'container' => __('Container Width', 'ace-theme'),
          'narrow'    => __('Narrow', 'ace-theme'),
        ])
        ->set_default_value('container'),
      Field::make('complex', 'testimonials_items', __('Testimonials', 'ace-theme'))
        ->set_layout('tabbed-vertical')
        ->add_fields([
          Field::make('image', 'avatar', __('Avatar Image', 'ace-theme'))
            ->set_value_type('id')
            ->set_help_text('Upload customer avatar'),
          Field::make('textarea', 'quote', __('Testimonial Quote', 'ace-theme'))
            ->set_required(true)
            ->set_rows(4),
          Field::make('text', 'author_name', __('Author Name', 'ace-theme'))
            ->set_required(true),
          Field::make('text', 'author_title', __('Author Title/Position', 'ace-theme')),
          Field::make('text', 'author_company', __('Company Name', 'ace-theme')),
        ])
        ->set_header_template('
          <% if (author_name) { %>
            <%= author_name %>
          <% } else { %>
            Testimonial #<%= $_index + 1 %>
          <% } %>
        ')
        ->set_min(1)
        ->set_max(10)
    ])
    ->set_description(__('A responsive testimonial carousel with overlapping cards', 'ace-theme'))
    ->set_category('ace-blocks')
    ->set_icon('testimonial')
    ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
      $title = $fields['testimonials_title'] ?? '';
      $desc = $fields['testimonials_description'] ?? '';
      $full = $fields['testimonials_full_width'] ?? false;
      $items = $fields['testimonials_items'] ?? [];
      $width_sel = $fields['testimonials_width'] ?? 'container';
      $wrap = $width_sel === 'full' ? 'w-full px-6' : ($width_sel === 'narrow' ? 'max-w-3xl mx-auto px-6' : 'max-w-7xl mx-auto px-6 max-w-global');

      if (empty($items)) {
        if (is_admin()) {
          echo '<div style="padding: 14px 16px; border: 1px dashed #cbd5e1; border-radius: 8px; color: #475569; background: #f8fafc;">' . esc_html__('Add testimonials to display the carousel', 'ace-theme') . '</div>';
        }
        return;
      }

      $section_id = 'testimonials-block-' . uniqid();
      
      // Include the testimonials template
      include(get_template_directory() . '/template-parts/blocks/testimonials-carousel.php');
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

