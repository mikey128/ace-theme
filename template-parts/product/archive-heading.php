<?php
$hide = ! empty($args['hide_section']);
if ($hide) { return; }
$full = ! empty($args['enable_full_width']);
$wrap = $full ? 'w-full px-6' : 'max-w-7xl mx-auto px-6 max-w-global';
$heading = isset($args['heading']) ? (string) $args['heading'] : '';
$description = isset($args['description']) ? (string) $args['description'] : '';
?>
<section class="bg-white py-10 sm:py-12 md:py-16">
  <div class="<?php echo esc_attr($wrap); ?>">
    <header class="max-w-3xl mx-auto text-center">
      <?php if ($heading !== ''): ?>
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-semibold text-gray-900">
          <?php echo esc_html($heading); ?>
        </h2>
      <?php endif; ?>
      <?php if ($description !== ''): ?>
        <p class="mt-4 text-sm sm:text-base text-gray-600 leading-relaxed">
          <?php echo esc_html($description); ?>
        </p>
      <?php endif; ?>
    </header>
  </div>
</section>
