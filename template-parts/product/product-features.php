<?php
$hide_section = carbon_get_the_post_meta('features_hide_section');
if ($hide_section) {
  return;
}

$features = carbon_get_the_post_meta('product_features');
if (!is_array($features) || empty($features)) {
  return;
}

$section_title = carbon_get_the_post_meta('features_section_title');
$full_width = carbon_get_the_post_meta('features_full_width');

$wrapper_classes = $full_width
  ? 'w-full px-6'
  : 'max-w-7xl mx-auto px-6 max-w-global';

$limited_features = array_slice($features, 0, 6);

$highlight_index = null;
foreach ($limited_features as $index => $feature) {
  if (!empty($feature['feature_highlighted'])) {
    $highlight_index = $index;
    break;
  }
}
if ($highlight_index === null && !empty($limited_features)) {
  $highlight_index = 0;
}
$section_id_input = (string) carbon_get_the_post_meta('features_section_id');
$section_id    = $section_id_input !== '' ? sanitize_title($section_id_input) : 'product-features-' . get_the_ID();
?>

<section id="<?php echo esc_attr($section_id); ?>"  class="product-features py-12 sm:py-16 lg:py-20 bg-white">
  <div class="<?php echo esc_attr($wrapper_classes); ?>">
    <?php if (!empty($section_title)) : ?>
      <header class="mb-8 sm:mb-10 lg:mb-12 text-center">
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold  text-neutral-900">
          <?php echo esc_html($section_title); ?>
        </h2>
      </header>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
      <?php foreach ($limited_features as $i => $feature) : ?>
        <?php
        $is_highlighted = ($highlight_index === $i);
        $card_classes = $is_highlighted
          ? 'bg-brand-accent text-white'
          : 'bg-neutral-100 text-neutral-900 hover:bg-brand-accent hover:text-white transition-all duration-300';
        // Note: Added hover and transition classes above

        $number = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
        $title = isset($feature['feature_title']) ? $feature['feature_title'] : '';
        $description = isset($feature['feature_description']) ? $feature['feature_description'] : '';
        ?>
        <article class="flex">
          <div class="flex flex-col h-full w-full rounded-lg p-6 sm:p-7 lg:p-8 <?php echo esc_attr($card_classes); ?>">
            <div class="text-4xl sm:text-5xl font-extrabold leading-none mb-4 opacity-80">
              <?php echo esc_html($number); ?>
            </div>
            <?php if ($title) : ?>
              <h3 class="text-base sm:text-lg font-semibold mb-2">
                <?php echo esc_html($title); ?>
              </h3>
            <?php endif; ?>
            <?php if ($description) : ?>
              <p class="text-sm sm:text-base leading-relaxed">
                <?php echo wp_kses_post($description); ?>                
              </p>
            <?php endif; ?>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
