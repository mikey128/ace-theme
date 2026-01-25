<?php
/**
 * Image Banner Block Template
 *
 * @package Ace_Theme
 */

$enable_full_width = !empty($fields['banner_full_width']);
$wrap = $enable_full_width ? 'w-full' : 'max-w-7xl mx-auto px-6 max-w-global';
$height_sel = isset($fields['banner_height']) ? $fields['banner_height'] : 'large';

$current_id = get_the_ID();
$featured_id = is_numeric($current_id) ? get_post_thumbnail_id($current_id) : 0;
$custom_id = isset($fields['banner_image']) ? (int) $fields['banner_image'] : 0;
$image_id = $custom_id > 0 ? $custom_id : $featured_id;

$custom_title = isset($fields['custom_title']) ? trim((string) $fields['custom_title']) : '';
$title = $custom_title !== '' ? $custom_title : get_the_title($current_id);

$alt = '';
if ($image_id) {
  $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
  if (!$alt) { $alt = $title ?: 'Banner'; }
}
?>

<section>
  <div class="<?php echo esc_attr($wrap); ?>">
    <figure class="relative overflow-hidden">
      <?php if ($image_id) : ?>
        <?php
          $src = wp_get_attachment_image_url($image_id, 'full');
        ?>
        <?php
          $img_class = 'w-full h-80 lg:h-96 object-cover block';
          if ($height_sel === 'medium') {
            $img_class = 'w-full h-64 lg:h-72 object-cover block';
          } elseif ($height_sel === 'small') {
            $img_class = 'w-full h-48 md:h-56 object-cover block';
          } elseif ($height_sel === 'natural') {
            $img_class = 'w-full h-auto block';
          }
        ?>
        <img src="<?php echo esc_url($src); ?>" alt="<?php echo esc_attr($alt); ?>" class="<?php echo esc_attr($img_class); ?>" />
      <?php else : ?>
        <?php
          $ph_class = 'w-full h-80 lg:h-96 bg-gray-200';
          if ($height_sel === 'medium') { $ph_class = 'w-full h-64 lg:h-72 bg-gray-200'; }
          elseif ($height_sel === 'small') { $ph_class = 'w-full h-48 md:h-56 bg-gray-200'; }
          elseif ($height_sel === 'natural') { $ph_class = 'w-full min-h-[300px] bg-gray-200'; }
        ?>
        <div class="<?php echo esc_attr($ph_class); ?>"></div>
      <?php endif; ?>

      <div class="absolute inset-0 bg-black/40"></div>
      <figcaption class="absolute inset-0 z-10 flex items-center justify-center">
        <?php if (!empty($title)) : ?>
          <h1 class="text-white text-xl sm:text-4xl lg:text-5xl font-semibold tracking-wide text-center">
            <?php echo esc_html($title); ?>
          </h1>
        <?php endif; ?>
      </figcaption>
    </figure>
  </div>
  <?php if (is_admin() && !$image_id) : ?>
    <div class="mt-3 text-sm text-slate-600">
      <?php echo esc_html__('No image found. Set a featured image or select a custom image.', 'ace-theme'); ?>
    </div>
  <?php endif; ?>
  </section>
