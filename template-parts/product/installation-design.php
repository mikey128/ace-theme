<?php
if (! function_exists('carbon_get_the_post_meta')) { return; }

$hide = carbon_get_the_post_meta('hide_section');
if ($hide) { return; }

$full = carbon_get_the_post_meta('enable_full_width');
$wrap = $full ? 'w-full px-6' : 'max-w-7xl mx-auto px-6 max-w-global';

$heading = carbon_get_the_post_meta('installation_heading');
$columns = (int) carbon_get_the_post_meta('installation_columns');
$items   = carbon_get_the_post_meta('installation_items');

$columns = ($columns >= 3 && $columns <= 6) ? $columns : 4;
$gridMap = [
  3 => 'grid-cols-1 sm:grid-cols-2 md:grid-cols-3',
  4 => 'grid-cols-1 sm:grid-cols-2 md:grid-cols-4',
  5 => 'grid-cols-2 sm:grid-cols-3 md:grid-cols-5',
  6 => 'grid-cols-2 sm:grid-cols-3 md:grid-cols-6',
];
$gridCols = $gridMap[$columns];

if (empty($items) || !is_array($items)) { return; }

$sid_input = (string) carbon_get_the_post_meta('installation_section_id');
$sid = $sid_input !== '' ? sanitize_title($sid_input) : 'installation-design-' . get_the_ID();
?>
<section id="<?php echo esc_attr($sid); ?>" class="py-10 sm:py-12 md:py-16 bg-white">
  <div class="<?php echo esc_attr($wrap); ?>">
    <?php if (!empty($heading)) : ?>
      <header class="text-center mb-8">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-semibold  text-gray-900">
          <?php echo esc_html($heading); ?>
        </h2>
      </header>
    <?php endif; ?>

    <div class="grid <?php echo esc_attr($gridCols); ?> gap-6 sm:gap-8">
      <?php foreach ($items as $item): ?>
        <?php
          $image_id = isset($item['image']) ? (int) $item['image'] : 0;
          $title    = isset($item['title']) ? $item['title'] : '';
          $desc     = isset($item['description']) ? $item['description'] : '';
        ?>
        <article class="text-center">
          <figure class="mx-auto mb-4 flex items-center justify-center bg-white w-full hover:scale-[1.02] transition-transform duration-300">
            <?php
            if ($image_id) {
              echo wp_get_attachment_image($image_id, 'medium', false, [
                'class' => 'w-auto object-contain',
                'loading' => 'lazy',
              ]);
            }
            ?>
          </figure>

          <?php if ($title !== ''): ?>
            <h3 class="text-base sm:text-lg font-semibold text-gray-900">
              <?php echo esc_html($title); ?>
            </h3>
          <?php endif; ?>

          <?php if ($desc !== ''): ?>
            <p class="mt-2 text-sm text-gray-700 leading-relaxed">
              <?php echo esc_html($desc); ?>
            </p>
          <?php endif; ?>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>