<?php
// Featured carousel section.
$hide = ! empty($args['hide_section']);
if ($hide) { return; }

$q = isset($args['query']) ? $args['query'] : null;
if (! ($q instanceof WP_Query) || ! $q->have_posts()) { return; }

$full = ! empty($args['enable_full_width']);
$wrap = $full ? 'w-full px-6' : 'max-w-7xl mx-auto px-6 max-w-global';
?>
<section class="  py-8 ">
  <div class="<?php echo esc_attr($wrap); ?>">
    <div class="swiper js-news-featured-swiper overflow-hidden">
      <div class="swiper-wrapper">
        <?php while ($q->have_posts()) : $q->the_post(); ?>
          <?php
            $post_id = get_the_ID();
            $permalink = get_permalink($post_id);
            $date = get_the_date('M j, Y', $post_id);
            $title = get_the_title($post_id);
            $excerpt = wp_trim_words(wp_strip_all_tags(get_the_excerpt($post_id)), 40);
          ?>
          <article class="swiper-slide">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-0 overflow-hidden">
              <a href="<?php echo esc_url($permalink); ?>" class="md:col-span-3 relative block min-h-[260px] md:min-h-[420px] bg-gray-100">
                <?php if (has_post_thumbnail($post_id)) : ?>
                  <?php echo get_the_post_thumbnail($post_id, 'large', ['class' => 'absolute inset-0 w-full h-full object-cover', 'loading' => 'lazy']); ?>
                <?php else : ?>
                  <div class="absolute inset-0 bg-gray-200"></div>
                <?php endif; ?>
              </a>
              <div class="md:col-span-2 bg-white p-6 sm:p-8 md:p-10 flex flex-col justify-center">
                <?php if ($date) : ?>
                  <div class="text-xs font-medium tracking-wide text-gray-500">
                    <?php echo esc_html($date); ?>
                  </div>
                <?php endif; ?>

                <?php if ($title) : ?>
                  <h2 class="mt-3 text-xl sm:text-2xl font-semibold text-gray-900 leading-tight line-clamp-2">
                    <a class="hover:underline underline-offset-4 decoration-2" href="<?php echo esc_url($permalink); ?>">
                      <?php echo esc_html($title); ?>
                    </a>
                  </h2>
                <?php endif; ?>

                <?php if ($excerpt) : ?>
                  <p class="mt-4 text-sm sm:text-base text-gray-600 leading-relaxed line-clamp-4">
                    <?php echo esc_html($excerpt); ?>
                  </p>
                <?php endif; ?>

                <div class="mt-6">
                  <a class="inline-flex items-center font-semibold text-brand-accent hover:underline decoration-2 underline-offset-4" href="<?php echo esc_url($permalink); ?>">
                    <span><?php echo esc_html__('Learn More', 'ace-theme'); ?></span>
                    <span class="ml-2" aria-hidden="true">→</span>
                  </a>
                </div>
              </div>
            </div>
          </article>
        <?php endwhile; ?>
      </div>
      <div class="swiper-pagination !static !mt-8"></div>
    </div>
  </div>
</section>
<?php wp_reset_postdata(); ?>
  <style>
    .swiper-pagination-bullet{
    width:80px; border-radius:0;  height:4px;
  } 
  </style>
