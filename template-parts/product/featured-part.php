<?php
if (! function_exists('carbon_get_the_post_meta')) {
  return;
}

$hide = carbon_get_the_post_meta('hide_section');
if ($hide) {
  return;
}

$full = carbon_get_the_post_meta('enable_full_width');
$wrap = $full ? 'w-full px-6' : 'max-w-7xl mx-auto px-6 max-w-global';

$heading = carbon_get_the_post_meta('featured_heading');
$left_subtitle = carbon_get_the_post_meta('featured_left_subtitle');
$left_title = carbon_get_the_post_meta('featured_left_title');
$left_desc = carbon_get_the_post_meta('featured_left_description');
$right_image_id = (int) carbon_get_the_post_meta('featured_right_image');
$features = carbon_get_the_post_meta('featured_features');

if (empty($heading) && empty($left_title) && empty($right_image_id)) {
  return;
}

$sid_input = (string) carbon_get_the_post_meta('featured_section_id');
$sid = $sid_input !== '' ? sanitize_title($sid_input) : 'featured-part-' . get_the_ID();
?>
<section id="<?php echo esc_attr($sid); ?>" class="py-10 sm:py-12 md:py-16 bg-white">
  <div class="<?php echo esc_attr($wrap); ?>">
    <?php if (! empty($heading)) : ?>
      <header class="text-center mb-6 sm:mb-8 md:mb-10">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-semibold  text-gray-900">
          <?php echo esc_html($heading); ?>
        </h2>
      </header>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-10 items-center">
      <div>
        <?php if (! empty($left_subtitle)) : ?>
          <p class="text-brand-accent font-semibold text-sm sm:text-base mb-2">
            <?php echo esc_html($left_subtitle); ?>
          </p>
        <?php endif; ?>
        <?php if (! empty($left_title)) : ?>
          <h3 class="text-xl sm:text-2xl md:text-4xl font-bold text-brand-accent mb-4">
            <?php echo esc_html($left_title); ?>
          </h3>
        <?php endif; ?>
        <?php if (! empty($left_desc)) : ?>
          <div class="text-gray-700 text-sm sm:text-base leading-relaxed">
            <?php echo wp_kses_post(wpautop($left_desc)); ?>
          </div>
        <?php endif; ?>
      </div>
      <figure class="relative">
        <?php
        if ($right_image_id) {
          echo wp_get_attachment_image(
            $right_image_id,
            'large',
            false,
            [
              'class' => 'w-full h-auto object-contain hover:scale-[1.02] transition-transform duration-300',
              'loading' => 'lazy',
            ]
          );
        }
        ?>
      </figure>
    </div>

    <?php if (is_array($features) && ! empty($features)) : ?>
      <div class="mt-8 sm:mt-10 grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
        <?php foreach ($features as $f) : ?>
          <?php $text = isset($f['feature_text']) ? $f['feature_text'] : ''; ?>
          <?php if ($text === '') continue; ?>
          <article class="relative p-6 sm:p-7 lg:p-8  bg-brand-secondary rounded-lg p-5 sm:p-6 hover:bg-gray-100 transition-colors duration-300">
          
            <div class="text-gray-800 text-sm sm:text-base leading-relaxed"><?php echo wp_kses_post($text); ?></div>
            
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
