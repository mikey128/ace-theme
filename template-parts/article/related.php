<?php
$post_id = get_the_ID();
$items = function_exists('ace_get_related_articles') ? ace_get_related_articles($post_id, 3) : [];
$label = function_exists('ace_get_editorial_label') ? ace_get_editorial_label($post_id) : '';
$heading = $label ? ('Latest ' . $label) : 'Latest Articles';
?>

<?php if (!empty($items)): ?>
  <section class="lg:sticky lg:top-28">
    <div >
      <h2 class="text-lg font-semibold text-gray-900"><?php echo esc_html($heading); ?></h2>
      <div class="mt-5 space-y-6">
        <?php foreach ($items as $p): ?>
          <?php
          $thumb = get_the_post_thumbnail_url($p->ID, 'large');
          $date = get_the_date('', $p->ID);
          $title = get_the_title($p->ID);
          $excerpt = wp_trim_words(get_the_excerpt($p->ID), 18);
          $url = get_permalink($p->ID);
          ?>
          <article class="overflow-hidden">
            <?php if ($thumb): ?>
              <a href="<?php echo esc_url($url); ?>" class="block">
                <img src="<?php echo esc_url($thumb); ?>" alt="" class="w-full h-60 object-cover" loading="lazy">
              </a>
            <?php endif; ?>
            <div class="py-4">
              <?php if ($date): ?>
                <p ><span class="text-xs text-gray-600 border border-gray-600 rounded-full display-inline-block py-1 px-3"><?php echo esc_html($date); ?></span></p>
              <?php endif; ?>
              <h3 class="mt-1 mb-2 text-base font-semibold text-gray-900 leading-snug">
                <a href="<?php echo esc_url($url); ?>" class="hover:underline"><?php echo esc_html($title); ?></a>
              </h3>
              <?php if ($excerpt): ?>
                <p class="text-sm text-gray-600 mb-1 "><?php echo esc_html($excerpt); ?></p>
              <?php endif; ?>
              <a href="<?php echo esc_url($url); ?>" class="inline-flex items-center text-sm font-semibold underline underline-offset-1 text-blue-600 hover:text-blue-700">
                Learn more
              </a>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>
