<?php
$hide = ! empty($args['hide_section']);
if ($hide) { return; }
$full = ! empty($args['enable_full_width']);
$wrap = $full ? 'w-full px-6' : 'max-w-7xl mx-auto px-6 max-w-global';
$title = isset($args['archive_title']) ? (string) $args['archive_title'] : '';
$img = isset($args['hero_image']) ? $args['hero_image'] : '';
$img_url = is_numeric($img) ? wp_get_attachment_url((int)$img) : (string)$img;
?>
<?php if ($img_url !== ''): ?>
  <section class="relative w-full">
    <figure class="relative w-full h-56 sm:h-72 lg:h-[26rem] overflow-hidden">
      <img src="<?php echo esc_url($img_url); ?>" alt="" class="w-full h-full object-cover" loading="eager">
      <div class="absolute inset-0 bg-black/45"></div>
      <figcaption class="absolute inset-0 flex items-center">
        <div class="<?php echo esc_attr($wrap); ?> w-full">
          <div class="text-center max-w-3xl mx-auto text-white">
            <?php if ($title !== ''): ?>
              <h1 class="text-2xl sm:text-3xl md:text-4xl font-semibold tracking-tight"><?php echo esc_html($title); ?></h1>
            <?php endif; ?>
          </div>
        </div>
      </figcaption>
    </figure>
  </section>
<?php else: ?>
  <section class="bg-black text-white py-14 sm:py-16">
    <div class="<?php echo esc_attr($wrap); ?>">
      <?php if ($title !== ''): ?>
        <h1 class="text-center text-2xl sm:text-3xl md:text-4xl font-semibold tracking-tight"><?php echo esc_html($title); ?></h1>
      <?php endif; ?>
    </div>
  </section>
<?php endif; ?>
