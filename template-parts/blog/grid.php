<?php
// News grid section.
$hide = ! empty($args['hide_section']);
if ($hide) { return; }

$q = isset($args['query']) ? $args['query'] : null;
if (! ($q instanceof WP_Query)) { return; }

$full = ! empty($args['enable_full_width']);
$wrap = $full ? 'w-full px-6' : 'max-w-7xl mx-auto px-6 max-w-global';

$active_term_slug = isset($args['active_term_slug']) ? (string) $args['active_term_slug'] : '';

$current = max(1, (int) get_query_var('paged'));
$total = max(1, (int) $q->max_num_pages);

$page_url = function ($page) use ($active_term_slug) {
  $url = get_pagenum_link((int) $page);
  if ($active_term_slug !== '') {
    $url = add_query_arg('category', $active_term_slug, $url);
  }
  return $url;
};

$btn_base = 'inline-flex items-center justify-center min-w-10 h-10 rounded border px-3 text-sm font-medium transition-colors';
$btn_inactive = 'border-gray-200 bg-white text-gray-700 hover:border-brand-accent hover:text-brand-accent';
$btn_active = 'border-brand-accent bg-brand-accent text-white';
$btn_disabled = 'border-gray-100 bg-gray-50 text-gray-400 cursor-not-allowed';
?>
<section class="bg-white py-10 sm:py-12">
  <div class="<?php echo esc_attr($wrap); ?>">
    <?php if (! $q->have_posts()) : ?>
      <p class="text-center text-gray-600">
        <?php echo esc_html__('No news found.', 'ace-theme'); ?>
      </p>
    <?php else : ?>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php while ($q->have_posts()) : $q->the_post(); ?>
          <?php
            $post_id = get_the_ID();
            $permalink = get_permalink($post_id);
            $date = get_the_date('', $post_id);
            $title = get_the_title($post_id);
            $excerpt_raw = get_the_excerpt($post_id);
            if (empty($excerpt_raw)) {
              $excerpt_raw = wp_strip_all_tags(get_post_field('post_content', $post_id));
            }
            $excerpt = wp_trim_words($excerpt_raw, 40, '…');
            $thumb = get_the_post_thumbnail_url($post_id, 'large');
          ?>
          <article class="bg-white border border-gray-100 shadow-sm overflow-hidden">
            <?php if ($thumb) : ?>
              <a href="<?php echo esc_url($permalink); ?>" class="block overflow-hidden w-full">
                <img src="<?php echo esc_url($thumb); ?>" alt="" class="w-full h-56 md:h-60 object-cover hover:scale-[1.02] transition-transform duration-300" loading="lazy">
              </a>
            <?php else : ?>
              <a href="<?php echo esc_url($permalink); ?>" class="block w-full">
                <div class="w-full h-56 md:h-60 bg-gray-200"></div>
              </a>
            <?php endif; ?>
            <div class="p-5">
              <?php if ($date) : ?>
                <p><span class="text-xs text-gray-600 border border-gray-600 rounded-full inline-block py-1 px-3"><?php echo esc_html($date); ?></span></p>
              <?php endif; ?>

              <?php if ($title) : ?>
                <h3 class="mt-2 text-base font-semibold text-gray-900 leading-snug">
                  <a class="hover:underline" href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($title); ?></a>
                </h3>
              <?php endif; ?>

              <?php if ($excerpt) : ?>
                <p class="mt-2 text-sm text-gray-600">
                  <?php echo esc_html($excerpt); ?>
                </p>
              <?php endif; ?>

              <div class="mt-4">
                <a href="<?php echo esc_url($permalink); ?>" class="inline-flex items-center text-sm font-semibold underline underline-offset-1 text-blue-600 hover:text-blue-700">
                  <?php echo esc_html__('Learn more', 'ace-theme'); ?>
                </a> 
              </div>
            </div>
          </article>
        <?php endwhile; ?>
      </div>

      <?php if ($total > 1) : ?>
        <nav class="mt-10 flex items-center justify-center gap-2" aria-label="<?php echo esc_attr__('Pagination', 'ace-theme'); ?>">
          <?php if ($current > 1) : ?>
            <a class="<?php echo esc_attr($btn_base . ' ' . $btn_inactive); ?>" href="<?php echo esc_url($page_url($current - 1)); ?>">
              <?php echo esc_html__('Prev', 'ace-theme'); ?>
            </a>
          <?php else : ?>
            <span class="<?php echo esc_attr($btn_base . ' ' . $btn_disabled); ?>">
              <?php echo esc_html__('Prev', 'ace-theme'); ?>
            </span>
          <?php endif; ?>

          <?php
            $end_size = 1;
            $mid_size = 1;
            $dots = false;
            for ($n = 1; $n <= $total; $n++) {
              $is_edge = ($n <= $end_size) || ($n > $total - $end_size);
              $is_mid = (abs($n - $current) <= $mid_size);
              if ($is_edge || $is_mid) {
                $dots = true;
                $is_active = ($n === $current);
                if ($is_active) {
                  echo '<span class="' . esc_attr($btn_base . ' ' . $btn_active) . '">' . esc_html((string) $n) . '</span>';
                } else {
                  echo '<a class="' . esc_attr($btn_base . ' ' . $btn_inactive) . '" href="' . esc_url($page_url($n)) . '">' . esc_html((string) $n) . '</a>';
                }
              } elseif ($dots) {
                $dots = false;
                echo '<span class="px-2 text-gray-400">…</span>';
              }
            }
          ?>

          <?php if ($current < $total) : ?>
            <a class="<?php echo esc_attr($btn_base . ' ' . $btn_inactive); ?>" href="<?php echo esc_url($page_url($current + 1)); ?>">
              <?php echo esc_html__('Next', 'ace-theme'); ?>
            </a>
          <?php else : ?>
            <span class="<?php echo esc_attr($btn_base . ' ' . $btn_disabled); ?>">
              <?php echo esc_html__('Next', 'ace-theme'); ?>
            </span>
          <?php endif; ?>
        </nav>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</section>
<?php wp_reset_postdata(); ?>
