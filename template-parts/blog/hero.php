<?php
// Hero section.
$hide = ! empty($args['hide_section']);
if ($hide) { return; }

$full = ! empty($args['enable_full_width']);
$wrap = $full ? 'w-full px-6' : 'max-w-7xl mx-auto px-6 max-w-global';

$archive_title = isset($args['archive_title']) ? (string) $args['archive_title'] : '';
$description = isset($args['description']) ? (string) $args['description'] : '';
$active_term = isset($args['active_term']) ? $args['active_term'] : null;
$image_val = isset($args['hero_image']) ? $args['hero_image'] : '';
$image_url = is_numeric($image_val) ? wp_get_attachment_url((int) $image_val) : (string) $image_val;
?>
<?php if ($image_url !== ''): ?>
  <section class="relative w-full">
    <figure class="relative w-full h-56 sm:h-72 lg:h-[26rem] overflow-hidden">
      <img src="<?php echo esc_url($image_url); ?>" alt="" class="w-full h-full object-cover" loading="eager">
      <div class="absolute inset-0 bg-black/45"></div>
      <figcaption class="absolute inset-0 flex items-center">
        <div class="<?php echo esc_attr($wrap); ?> w-full">
          <div class="text-center max-w-3xl mx-auto text-white">
            <?php if ($archive_title !== '') : ?>
              <h1 class="text-2xl sm:text-3xl md:text-4xl font-semibold tracking-tight">
                <?php echo esc_html($archive_title); ?>
              </h1>
            <?php endif; ?>
            <?php if ($description !== '') : ?>
              <p class="mt-4 text-sm sm:text-base text-white/85 leading-relaxed">
                <?php echo esc_html($description); ?>
              </p>
            <?php endif; ?>
         
          </div>
        </div>
      </figcaption>
    </figure>
  </section>
<?php else: ?>
  <section class="bg-black text-white py-14 sm:py-16">
    <div class="<?php echo esc_attr($wrap); ?>">
      <header class="text-center max-w-3xl mx-auto">
        <?php if ($archive_title !== '') : ?>
          <h1 class="text-2xl sm:text-3xl md:text-4xl font-semibold tracking-tight">
            <?php echo esc_html($archive_title); ?>
          </h1>
        <?php endif; ?>
        <?php if ($description !== '') : ?>
          <p class="mt-4 text-sm sm:text-base text-white/75 leading-relaxed">
            <?php echo esc_html($description); ?>
          </p>
        <?php endif; ?>
        <?php if ($active_term && ! is_wp_error($active_term)) : ?>
          <div class="mt-6 flex items-center justify-center">
            <span class="inline-flex items-center rounded-full border border-white/20 px-3 py-1 text-xs font-medium text-white/90">
              <?php echo esc_html($active_term->name); ?>
            </span>
          </div>
        <?php endif; ?>
      </header>
    </div>
  </section>
<?php endif; ?>
