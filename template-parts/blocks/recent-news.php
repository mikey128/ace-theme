<?php
$wrap = isset($wrap) ? $wrap : 'max-w-7xl mx-auto px-6 max-w-global';
$heading = isset($heading) ? $heading : '';
$subheading = isset($subheading) ? $subheading : '';
$q = isset($q) ? $q : null;
$section_id = isset($section_id) ? $section_id : ('recent-news-block-' . uniqid());
?>
<section id="<?php echo esc_attr($section_id); ?>" class="py-12 sm:py-16 lg:py-20 bg-white">
  <div class="<?php echo esc_attr($wrap); ?>">
    <?php if ($heading !== '' || $subheading !== ''): ?>
      <header class="max-w-4xl mx-auto text-center mb-8 sm:mb-10 lg:mb-12">
        <?php if ($heading !== ''): ?>
          <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-neutral-900"><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>
        <?php if ($subheading !== ''): ?>
          <div class="mt-3 sm:mt-4 lg:mt-5 text-neutral-600 text-sm sm:text-base leading-relaxed">
            <?php echo wp_kses_post($subheading); ?>
          </div>
        <?php endif; ?>
      </header>
    <?php endif; ?>
    <?php if ($q && $q->have_posts()): ?>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <?php while ($q->have_posts()): $q->the_post(); ?>
          <?php
            $pid = get_the_ID();
            $thumb = get_the_post_thumbnail_url($pid, 'large');
            $date = get_the_date('', $pid);
            $title = get_the_title($pid);
            $url = get_permalink($pid);
            $excerpt = get_the_excerpt($pid);
            if (empty($excerpt)) {
              $excerpt = wp_trim_words(wp_strip_all_tags(get_post_field('post_content', $pid)), 40, '…');
            } else {
              $excerpt = wp_trim_words($excerpt, 40, '…');
            }
          ?>
          <article class="bg-white">
            <?php if ($thumb): ?>
              <a href="<?php echo esc_url($url); ?>" class="block overflow-hidden w-full">
                <img src="<?php echo esc_url($thumb); ?>" alt="" class="w-full h-56 md:h-60 object-cover hover:scale-[1.02] transition-transform duration-300" loading="lazy">
              </a>
            <?php endif; ?>
            <div class="py-4">
              <?php if ($date): ?>
                <p><span class="text-xs text-gray-600 border border-gray-600 rounded-full inline-block py-1 px-3"><?php echo esc_html($date); ?></span></p>
              <?php endif; ?>
              <h3 class="mt-2 text-base font-semibold text-gray-900 leading-snug">
                <a href="<?php echo esc_url($url); ?>" class="hover:underline"><?php echo esc_html($title); ?></a>
              </h3>
              <?php if ($excerpt): ?>
                <p class="mt-2 text-sm text-gray-600"><?php echo esc_html($excerpt); ?></p>
              <?php endif; ?>
              <a href="<?php echo esc_url($url); ?>" class="mt-2 inline-flex items-center text-sm font-semibold underline underline-offset-1 text-blue-600 hover:text-blue-700">
                Learn more
              </a>
            </div>
          </article>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    <?php else: ?>
      <?php if (is_admin()): ?>
        <p class="text-center text-sm text-neutral-500">No articles found.</p>
      <?php endif; ?>
    <?php endif; ?>
  </div>
  <?php if (isset($q) && $q instanceof WP_Query) { $q->reset_postdata(); } ?>
</section>
