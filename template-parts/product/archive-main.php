<?php
$hide = ! empty($args['hide_section']);
if ($hide) { return; }

// Get the query from args
$q = isset($args['query']) ? $args['query'] : null;
if (! ($q instanceof WP_Query)) { 
  // Fallback: create a basic query if none provided
  $q = new WP_Query([
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => (int) get_option('posts_per_page', 12),
    'paged' => max(1, (int) get_query_var('paged')),
  ]);
}

$full = ! empty($args['enable_full_width']);
$wrap = $full ? 'w-full px-6' : 'max-w-7xl mx-auto px-6 max-w-global';
$active_slug = isset($args['active_term_slug']) ? (string) $args['active_term_slug'] : '';
if ($active_slug === '' && isset($_GET['category'])) {
  $active_slug = sanitize_title(wp_unslash($_GET['category']));
}

$terms = get_terms([
  'taxonomy' => 'product_category',
  'hide_empty' => false,
  'parent' => 0,
]);

// Get featured category settings
$get_opt = function ($key, $default = false) {
  return function_exists('carbon_get_theme_option') ? carbon_get_theme_option($key) : $default;
};

$show_featured = (bool) $get_opt('product_archive_show_featured_category', false);
$featured_cat_id = (int) $get_opt('product_archive_featured_category', 0);
$featured_label = (string) $get_opt('product_archive_featured_label', 'Featured Products');

$featured_term = null;
$featured_products = [];

if ($show_featured && $featured_cat_id > 0) {
  $featured_term = get_term($featured_cat_id, 'product_category');
  if (is_wp_error($featured_term)) {
    $featured_term = null;
  } else {
    // Get products from the featured category
    $featured_query = new WP_Query([
      'post_type' => 'product',
      'post_status' => 'publish',
      'posts_per_page' => -1, // Get all products
      'orderby' => 'menu_order title',
      'order' => 'ASC',
      'tax_query' => [
        [
          'taxonomy' => 'product_category',
          'field' => 'term_id',
          'terms' => [(int) $featured_term->term_id],
        ],
      ],
    ]);
    
    if ($featured_query->have_posts()) {
      while ($featured_query->have_posts()) {
        $featured_query->the_post();
        $featured_products[] = [
          'id' => get_the_ID(),
          'title' => get_the_title(),
          'url' => get_permalink(),
        ];
      }
      wp_reset_postdata();
    }
  }
}
?>
<section class="bg-white py-10 sm:py-8 md:py-12">
  <div class="<?php echo esc_attr($wrap); ?>">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
      <aside class="lg:col-span-3">
        <div class="rounded-lg border border-gray-200 overflow-hidden">
          <div class="bg-blue-600 text-white font-semibold px-4 py-3">Featured Products</div>
          <nav class="divide-y divide-gray-100">
            <?php
              $base_url = get_post_type_archive_link('product');
              $link = function($slug) use ($base_url) {
                return $slug !== '' ? add_query_arg('category', $slug, $base_url) : $base_url;
              };
            ?>
        
            
            <?php if (!empty($featured_products)): ?>
              <!-- Featured Products (individual product links) -->
              <?php foreach ($featured_products as $featured_product): ?>
                <?php
                  // Check if current product is being viewed
                  global $post;
                  $is_current = (is_singular('product') && isset($post) && $post->ID === $featured_product['id']);
                  $product_classes = $is_current
                    ? 'bg-blue-50 text-blue-600 font-medium'
                    : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600';
                ?>
                <a class="block px-4 py-3 text-sm transition-colors <?php echo esc_attr($product_classes); ?>" href="<?php echo esc_url($featured_product['url']); ?>">
                   
                  <?php echo esc_html($featured_product['title']); ?>
                </a>
              <?php endforeach; ?>
            <?php endif; ?>
            
            <!-- Regular Categories -->
            <?php if (!is_wp_error($terms) && !empty($terms)) : foreach ($terms as $term) : ?>
              <?php 
                // Skip if this is the featured category (already shown above)
                if ($featured_term && $term->term_id === $featured_term->term_id) {
                  continue;
                }
                $is_active = ($active_slug === (string)$term->slug); 
              ?>
              <a class="block px-4 py-3 text-sm hover:text-blue-600 <?php echo $is_active ? 'text-blue-600 font-medium' : 'text-gray-700'; ?>" href="<?php echo esc_url($link($term->slug)); ?>">
                <span class="mr-2">›</span><?php echo esc_html($term->name); ?>
              </a>
            <?php endforeach; endif; ?>
          </nav>
        </div>
      </aside>
      <div class="lg:col-span-9">
        <?php if (! $q->have_posts()) : ?>
          <p class="text-gray-600"><?php echo esc_html__('No products found.', 'ace-theme'); ?></p>
        <?php else : ?>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php while ($q->have_posts()) : $q->the_post(); ?>
              <?php
                $pid = get_the_ID();
                $thumb = get_the_post_thumbnail_url($pid, 'large');
                $title = get_the_title($pid);
                $url = get_permalink($pid);
                $excerpt = get_the_excerpt($pid);
                if (empty($excerpt)) {
                  $excerpt = wp_trim_words(wp_strip_all_tags(get_post_field('post_content', $pid)), 24, '…');
                } else {
                  $excerpt = wp_trim_words($excerpt, 24, '…');
                }
              ?>
              <article class="rounded-sm bg-brand-secondary hover:bg-gray-100 transition-colors duration-300 shadow-sm p-4">
                <?php if ($thumb): ?>
                  <a href="<?php echo esc_url($url); ?>" class="block overflow-hidden w-full">
                    <img src="<?php echo esc_url($thumb); ?>" alt="" class="w-full aspect-square object-cover hover:scale-[1.02] transition-transform duration-300" loading="lazy">
                  </a>
                <?php endif; ?>
                <div class="pt-4 px-2">
                  <h3 class="text-base font-semibold text-gray-900 leading-snug">
                    <a class="hover:underline" href="<?php echo esc_url($url); ?>"><?php echo esc_html($title); ?></a>
                  </h3>
                  <?php if ($excerpt): ?>
                    <p class="mt-2 text-sm text-gray-600 mb-0"><?php echo esc_html($excerpt); ?></p>
                  <?php endif; ?>
                
                </div>
              </article>
            <?php endwhile; ?>
          </div>
          <?php
            // Custom pagination for custom query
            $current = max(1, (int) get_query_var('paged'));
            $total = max(1, (int) $q->max_num_pages);
            
            if ($total > 1) {
              $base_url = get_post_type_archive_link('product');
              if ($active_slug !== '') {
                $base_url = add_query_arg('category', $active_slug, $base_url);
              }
              
              echo '<nav class="mt-8 flex items-center justify-center gap-2" aria-label="' . esc_attr__('Pagination', 'ace-theme') . '">';
              
              // Previous button
              if ($current > 1) {
                $prev_url = $current > 2 ? add_query_arg('paged', $current - 1, $base_url) : $base_url;
                echo '<a href="' . esc_url($prev_url) . '" class="inline-flex items-center justify-center min-w-10 h-10 rounded border border-gray-200 bg-white text-gray-700 hover:border-blue-600 hover:text-blue-600 px-3 text-sm font-medium transition-colors">' . esc_html__('Prev', 'ace-theme') . '</a>';
              } else {
                echo '<span class="inline-flex items-center justify-center min-w-10 h-10 rounded border border-gray-100 bg-gray-50 text-gray-400 cursor-not-allowed px-3 text-sm font-medium">' . esc_html__('Prev', 'ace-theme') . '</span>';
              }
              
              // Page numbers
              $end_size = 1;
              $mid_size = 1;
              $dots = false;
              for ($n = 1; $n <= $total; $n++) {
                $is_edge = ($n <= $end_size) || ($n > $total - $end_size);
                $is_mid = (abs($n - $current) <= $mid_size);
                if ($is_edge || $is_mid) {
                  $dots = true;
                  $is_active = ($n === $current);
                  $page_url = $n > 1 ? add_query_arg('paged', $n, $base_url) : $base_url;
                  if ($is_active) {
                    echo '<span class="inline-flex items-center justify-center min-w-10 h-10 rounded border border-blue-600 bg-blue-600 text-white px-3 text-sm font-medium">' . esc_html((string) $n) . '</span>';
                  } else {
                    echo '<a href="' . esc_url($page_url) . '" class="inline-flex items-center justify-center min-w-10 h-10 rounded border border-gray-200 bg-white text-gray-700 hover:border-blue-600 hover:text-blue-600 px-3 text-sm font-medium transition-colors">' . esc_html((string) $n) . '</a>';
                  }
                } elseif ($dots) {
                  $dots = false;
                  echo '<span class="px-2 text-gray-400">…</span>';
                }
              }
              
              // Next button
              if ($current < $total) {
                $next_url = add_query_arg('paged', $current + 1, $base_url);
                echo '<a href="' . esc_url($next_url) . '" class="inline-flex items-center justify-center min-w-10 h-10 rounded border border-gray-200 bg-white text-gray-700 hover:border-blue-600 hover:text-blue-600 px-3 text-sm font-medium transition-colors">' . esc_html__('Next', 'ace-theme') . '</a>';
              } else {
                echo '<span class="inline-flex items-center justify-center min-w-10 h-10 rounded border border-gray-100 bg-gray-50 text-gray-400 cursor-not-allowed px-3 text-sm font-medium">' . esc_html__('Next', 'ace-theme') . '</span>';
              }
              
              echo '</nav>';
            }
          ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
