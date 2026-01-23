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
      $wrap = $width_sel === 'full' ? 'w-full' : ($width_sel === 'narrow' ? 'max-w-3xl mx-auto px-6' : 'max-w-7xl mx-auto px-6 max-w-global');
      $aspect = $width_sel === 'full' ? 'aspect-video md:aspect-[16/6]' : 'aspect-video';

      if (empty($video_url) || empty($cover_url)) {
        if (is_admin()) {
           echo '<div class="p-4 border-2 border-dashed border-gray-300 text-center text-gray-500 rounded-lg">Please select a video and cover image.</div>';
        }
        return;
      }
      ?>
      <div class="<?php echo esc_attr($wrap); ?>">
        <div class="ace-video-module relative w-full overflow-hidden group <?php echo esc_attr($aspect); ?> shadow-md bg-black">
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
 
add_action('carbon_fields_register_fields', function () {
  Block::make(__('Info Statistics', 'ace-theme'))
    ->set_mode('edit')
    ->set_preview_mode('live')
    ->add_fields([
      Field::make('checkbox', 'info_stats_full_width', __('Full Width', 'ace-theme')),
      Field::make('text', 'heading', __('Heading', 'ace-theme')),
      Field::make('text', 'subheading', __('Subheading', 'ace-theme')),
      Field::make('rich_text', 'description', __('Description', 'ace-theme')),
      Field::make('select', 'stats_columns', __('Columns', 'ace-theme'))
        ->set_options([
          '2' => __('2', 'ace-theme'),
          '3' => __('3', 'ace-theme'),
          '4' => __('4', 'ace-theme'),
          '5' => __('5', 'ace-theme'),
          '6' => __('6', 'ace-theme'),
        ])
        ->set_default_value('4'),
      Field::make('complex', 'statistics', __('Statistics', 'ace-theme'))
        ->set_layout('tabbed-vertical')
        ->add_fields([
          Field::make('text', 'number', __('Number', 'ace-theme')),
          Field::make('text', 'label', __('Label', 'ace-theme')),
          Field::make('checkbox', 'highlight', __('Highlight', 'ace-theme')),
        ])
        ->set_header_template('
          <% if (number && label) { %>
            <%= number %> — <%= label %>
          <% } else { %>
            Stat #<%= $_index + 1 %>
          <% } %>
        ')
        ->set_min(1)
        ->set_max(12),
    ])
    ->set_description(__('Statistics with animated numbers and optional highlight', 'ace-theme'))
    ->set_category('ace-blocks')
    ->set_icon('chart-bar')
    ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
      $wrap  = !empty($fields['info_stats_full_width']) ? 'w-full px-6' : 'max-w-7xl mx-auto px-6 max-w-global';
      $title = isset($fields['heading']) ? (string) $fields['heading'] : '';
      $sub   = isset($fields['subheading']) ? (string) $fields['subheading'] : '';
      $desc  = isset($fields['description']) ? (string) $fields['description'] : '';
      $cols  = isset($fields['stats_columns']) ? (int) $fields['stats_columns'] : 4;
      $items = isset($fields['statistics']) ? (array) $fields['statistics'] : [];
      $grid  = 'grid-cols-2';
      if ($cols === 3) { $grid = 'grid-cols-2 md:grid-cols-3'; }
      elseif ($cols === 4) { $grid = 'grid-cols-2 md:grid-cols-4'; }
      elseif ($cols === 5) { $grid = 'grid-cols-2 md:grid-cols-3 lg:grid-cols-5'; }
      elseif ($cols === 6) { $grid = 'grid-cols-2 md:grid-cols-3 lg:grid-cols-6'; }
      if (!is_admin()) { wp_enqueue_script('ace-info-stats'); }
      $section_id = 'info-stats-' . uniqid();
      set_query_var('info_stats', [
        'wrap' => $wrap,
        'title' => $title,
        'sub' => $sub,
        'desc' => $desc,
        'grid' => $grid,
        'items' => $items,
        'id' => $section_id,
      ]);
      include get_template_directory() . '/template-parts/blocks/info-stats.php';
    });
});
 
add_action('carbon_fields_register_fields', function () {
  Block::make(__('Tabbed Info', 'ace-theme'))
    ->set_mode('edit')
    ->set_preview_mode('live')
    ->add_fields([
      Field::make('checkbox', 'tabbed_enable_full_width', __('Full Width', 'ace-theme')),
      Field::make('text', 'tabbed_heading', __('Heading', 'ace-theme')),
      Field::make('text', 'tabbed_subheading', __('Subheading', 'ace-theme')),
      Field::make('complex', 'tabbed_items', __('Tabs', 'ace-theme'))
        ->set_layout('tabbed-vertical')
        ->add_fields([
          Field::make('text', 'tab_label', __('Tab Label', 'ace-theme')),
          Field::make('image', 'tab_image', __('Image', 'ace-theme'))->set_value_type('id'),
          Field::make('rich_text', 'tab_content', __('Content', 'ace-theme')),
          Field::make('select', 'image_position', __('Image Position', 'ace-theme'))
            ->set_options([
              'first'  => __('Image First', 'ace-theme'),
              'second' => __('Image Second', 'ace-theme'),
            ])->set_default_value('second'),
          Field::make('color', 'text_bg_color', __('Text Background', 'ace-theme')),
          Field::make('checkbox', 'text_bg_dark', __('Dark Background (white text)', 'ace-theme')),
        ])
        ->set_header_template('
          <% if (tab_label) { %>
            <%= tab_label %>
          <% } else { %>
            Tab #<%= $_index + 1 %>
          <% } %>
        ')
        ->set_min(1)
        ->set_max(10),
    ])
    ->set_description(__('Tabbed content with image/text layout options', 'ace-theme'))
    ->set_category('ace-blocks')
    ->set_icon('welcome-widgets-menus')
    ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
      $wrap = !empty($fields['tabbed_enable_full_width']) ? 'w-full px-6' : 'max-w-7xl mx-auto px-6 max-w-global';
      $title = isset($fields['tabbed_heading']) ? (string) $fields['tabbed_heading'] : '';
      $sub   = isset($fields['tabbed_subheading']) ? (string) $fields['tabbed_subheading'] : '';
      $items = isset($fields['tabbed_items']) ? (array) $fields['tabbed_items'] : [];
      if (empty($items)) {
        if (is_admin()) {
          echo '<div class="p-4 border-2 border-dashed border-gray-300 text-center text-gray-500 rounded-lg">Add tabs to render Tabbed Info.</div>';
        }
        return;
      }
      if (!is_admin()) { wp_enqueue_script('ace-tabbed-info'); }
      $section_id = 'tabbed-info-' . uniqid();
      include get_template_directory() . '/template-parts/blocks/tabbed-info.php';
    });
});
 
add_action('carbon_fields_register_fields', function () {
  Block::make(__('Recent News', 'ace-theme'))
    ->set_mode('edit')
    ->set_preview_mode('live')
    ->add_fields([
      Field::make('checkbox', 'recent_full_width', __('Full Width', 'ace-theme')),
      Field::make('text', 'recent_heading', __('Heading', 'ace-theme')),
      Field::make('rich_text', 'recent_subheading', __('Subheading', 'ace-theme')),
      Field::make('select', 'recent_count', __('Posts Count', 'ace-theme'))
        ->set_options([
          '3' => __('3', 'ace-theme'),
          '6' => __('6', 'ace-theme'),
          '9' => __('9', 'ace-theme'),
        ])->set_default_value('3'),
      Field::make('association', 'recent_category', __('Category', 'ace-theme'))
        ->set_types([
          ['type' => 'term', 'taxonomy' => 'category'],
        ]),
    ])
    ->set_description(__('Recent news grid from blog posts', 'ace-theme'))
    ->set_category('ace-blocks')
    ->set_icon('admin-post')
    ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
      $wrap = !empty($fields['recent_full_width']) ? 'w-full px-6' : 'max-w-7xl mx-auto px-6 max-w-global';
      $heading = isset($fields['recent_heading']) ? (string) $fields['recent_heading'] : '';
      $subheading = isset($fields['recent_subheading']) ? (string) $fields['recent_subheading'] : '';
      $count = isset($fields['recent_count']) ? (int) $fields['recent_count'] : 3;
      if ($count < 1) { $count = 3; }
      $assoc = isset($fields['recent_category']) ? (array) $fields['recent_category'] : [];
      $cat_id = 0;
      if (!empty($assoc)) {
        $first = $assoc[0];
        if (is_array($first) && isset($first['id'])) { $cat_id = (int) $first['id']; }
      }
      $args = [
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => $count,
        'orderby' => 'date',
        'order' => 'DESC',
        'ignore_sticky_posts' => true,
        'no_found_rows' => true,
      ];
      if ($cat_id > 0) { $args['cat'] = $cat_id; }
      $q = new WP_Query($args);
      $section_id = 'recent-news-block-' . uniqid();
      include get_template_directory() . '/template-parts/blocks/recent-news.php';
    });
});
 
add_action('carbon_fields_register_fields', function () {
  Block::make(__('Image Carousel', 'ace-theme'))
    ->set_mode('edit')
    ->set_preview_mode('live')
    ->add_fields([
      Field::make('checkbox', 'image_carousel_full_width', __('Full Width', 'ace-theme')),
      Field::make('checkbox', 'imgc_autoplay', __('Enable Autoplay', 'ace-theme')),
      Field::make('text', 'imgc_heading', __('Heading', 'ace-theme')),
      Field::make('textarea', 'imgc_subheading', __('Subheading', 'ace-theme'))->set_rows(3),     
      Field::make('select', 'imgc_per_view', __('Images Per View (Desktop)', 'ace-theme'))
        ->set_options([
          '2' => __('2', 'ace-theme'),
          '3' => __('3', 'ace-theme'),
          '4' => __('4', 'ace-theme'),
          '5' => __('5', 'ace-theme'),
          '6' => __('6', 'ace-theme'),
          '7' => __('7', 'ace-theme'),
          '8' => __('8', 'ace-theme'),
        ])->set_default_value('6'),
      Field::make('complex', 'imgc_items', __('Images', 'ace-theme'))
        ->set_layout('tabbed-vertical')
        ->add_fields([
          Field::make('image', 'img', __('Image', 'ace-theme'))->set_value_type('id'),
          Field::make('text', 'alt', __('title', 'ace-theme')),
        ])
        ->set_header_template('
          <% if (alt) { %>
            <%= alt %>
          <% } else { %>
            Image #<%= $_index + 1 %>
          <% } %>
        ')
        ->set_min(1)
        ->set_max(20),
    ])
    ->set_description(__('Swiper image carousel with hover pause and modal', 'ace-theme'))
    ->set_category('ace-blocks')
    ->set_icon('images-alt2')
    ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
      $wrap = !empty($fields['image_carousel_full_width']) ? 'w-full px-6' : 'max-w-7xl mx-auto px-6 max-w-global';
      $heading = isset($fields['imgc_heading']) ? (string) $fields['imgc_heading'] : '';
      $sub = isset($fields['imgc_subheading']) ? (string) $fields['imgc_subheading'] : '';
      $items = isset($fields['imgc_items']) ? (array) $fields['imgc_items'] : [];
      $autoplay = !empty($fields['imgc_autoplay']);
      $per_view = isset($fields['imgc_per_view']) ? (int) $fields['imgc_per_view'] : 5;
      if (empty($items)) {
        if (is_admin()) {
          echo '<div class="p-4 border-2 border-dashed border-gray-300 text-center text-gray-500 rounded-lg">Add images to render the carousel.</div>';
        }
        return;
      }
      if (!is_admin()) { wp_enqueue_script('ace-image-carousel'); }
      $section_id = 'image-carousel-' . uniqid();
      include get_template_directory() . '/template-parts/blocks/image-carousel.php';
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

