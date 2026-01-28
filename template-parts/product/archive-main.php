<?php
$hide = ! empty($args['hide_section']);
if ($hide) { return; }
$full = ! empty($args['enable_full_width']);
$wrap = $full ? 'w-full px-6' : 'max-w-7xl mx-auto px-6 max-w-global';
$active_term = isset($args['active_term']) ? $args['active_term'] : null;
$active_slug = isset($args['active_term_slug']) ? (string)$args['active_term_slug'] : '';
$paged = isset($args['paged']) ? max(1, (int)$args['paged']) : max(1, (int)get_query_var('paged'));

$terms = get_terms([
  'taxonomy' => 'product_category',
  'hide_empty' => false,
  'parent' => 0,
]);

$query_args = [
  'post_type' => 'product',
  'post_status' => 'publish',
  'posts_per_page' => (int) get_option('posts_per_page'),
  'paged' => $paged,
  'ignore_sticky_posts' => true,
];
if ($active_term && !is_wp_error($active_term)) {
  $query_args['tax_query'] = [[
    'taxonomy' => 'product_category',
    'field' => 'term_id',
    'terms' => [(int) $active_term->term_id],
  ]];
}
$q = new WP_Query($query_args);
?>
<section class="bg-white py-10 sm:py-12 md:py-16">
  <div class="<?php echo esc_attr($wrap); ?>">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
      <aside class="lg:col-span-3">
        <div class="rounded-lg border border-gray-200 overflow-hidden">
          <div class="bg-blue-600 text-white font-semibold px-4 py-3">Product List</div>
          <nav class="divide-y divide-gray-100">
            <?php
              $base_url = get_post_type_archive_link('product');
              $link = function($slug) use ($base_url) {
                return $slug !== '' ? add_query_arg('category', $slug, $base_url) : $base_url;
              };
            ?>
            <a class="block px-4 py-3 text-sm <?php echo $active_slug === '' ? 'text-blue-600 font-medium' : 'text-gray-700'; ?>" href="<?php echo esc_url($link('')); ?>">All Products</a>
            <?php if (!is_wp_error($terms) && !empty($terms)) : foreach ($terms as $term) : ?>
              <?php $is_active = ($active_slug === (string)$term->slug); ?>
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
              <article class="bg-white border border-gray-100 rounded-lg shadow-sm overflow-hidden">
                <?php if ($thumb): ?>
                  <a href="<?php echo esc_url($url); ?>" class="block overflow-hidden w-full">
                    <img src="<?php echo esc_url($thumb); ?>" alt="" class="w-full h-48 object-cover hover:scale-[1.02] transition-transform duration-300" loading="lazy">
                  </a>
                <?php endif; ?>
                <div class="p-5">
                  <h3 class="text-base font-semibold text-gray-900 leading-snug">
                    <a class="hover:underline" href="<?php echo esc_url($url); ?>"><?php echo esc_html($title); ?></a>
                  </h3>
                  <?php if ($excerpt): ?>
                    <p class="mt-2 text-sm text-gray-600"><?php echo esc_html($excerpt); ?></p>
                  <?php endif; ?>
                  <a href="<?php echo esc_url($url); ?>" class="mt-3 inline-flex items-center text-sm font-semibold underline underline-offset-1 text-blue-600 hover:text-blue-700">
                    <?php echo esc_html__('Learn more', 'ace-theme'); ?>
                  </a>
                </div>
              </article>
            <?php endwhile; ?>
          </div>
          <?php
            $current = max(1, (int) get_query_var('paged'));
            $total = max(1, (int) $q->max_num_pages);
            if ($total > 1) :
              $page_url = function ($page) use ($active_slug) {
                $url = get_pagenum_link((int) $page);
                if ($active_slug !== '') { $url = add_query_arg('category', $active_slug, $url); }
                return $url;
              };
          ?>
            <nav class="mt-10 flex items-center justify-center gap-2" aria-label="<?php echo esc_attr__('Pagination', 'ace-theme'); ?>">
              <?php if ($current > 1) : ?>
                <a class="inline-flex items-center justify-center min-w-10 h-10 rounded border px-3 text-sm font-medium border-gray-200 bg-white text-gray-700 hover:border-blue-600 hover:text-blue-600" href="<?php echo esc_url($page_url($current - 1)); ?>"><?php echo esc_html__('Prev', 'ace-theme'); ?></a>
              <?php else : ?>
                <span class="inline-flex items-center justify-center min-w-10 h-10 rounded border px-3 text-sm font-medium border-gray-100 bg-gray-50 text-gray-400 cursor-not-allowed"><?php echo esc_html__('Prev', 'ace-theme'); ?></span>
              <?php endif; ?>
              <?php
                $end_size = 1; $mid_size = 1; $dots = false;
                for ($n = 1; $n <= $total; $n++) {
                  $is_edge = ($n <= $end_size) || ($n > $total - $end_size);
                  $is_mid  = (abs($n - $current) <= $mid_size);
                  if ($is_edge || $is_mid) {
                    $dots = true;
                    $is_active = ($n === $current);
                    if ($is_active) {
                      echo '<span class="inline-flex items-center justify-center min-w-10 h-10 rounded border px-3 text-sm font-medium border-blue-600 bg-blue-600 text-white">' . esc_html((string)$n) . '</span>';
                    } else {
                      echo '<a class="inline-flex items-center justify-center min-w-10 h-10 rounded border px-3 text-sm font-medium border-gray-200 bg-white text-gray-700 hover:border-blue-600 hover:text-blue-600" href="' . esc_url($page_url($n)) . '">' . esc_html((string)$n) . '</a>';
                    }
                  } elseif ($dots) {
                    $dots = false;
                    echo '<span class="px-2 text-gray-400">…</span>';
                  }
                }
              ?>
              <?php if ($current < $total) : ?>
                <a class="inline-flex items-center justify-center min-w-10 h-10 rounded border px-3 text-sm font-medium border-gray-200 bg-white text-gray-700 hover:border-blue-600 hover:text-blue-600" href="<?php echo esc_url($page_url($current + 1)); ?>"><?php echo esc_html__('Next', 'ace-theme'); ?></a>
              <?php else : ?>
                <span class="inline-flex items-center justify-center min-w-10 h-10 rounded border px-3 text-sm font-medium border-gray-100 bg-gray-50 text-gray-400 cursor-not-allowed"><?php echo esc_html__('Next', 'ace-theme'); ?></span>
              <?php endif; ?>
            </nav>
          <?php endif; wp_reset_postdata(); ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
