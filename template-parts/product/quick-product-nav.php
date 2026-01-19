<?php
if (! function_exists('carbon_get_the_post_meta')) { return; }
$hide = carbon_get_the_post_meta('quick_nav_hide_section');
if ($hide) { return; }
$full = carbon_get_the_post_meta('quick_nav_full_width');
$wrap = $full ? 'w-full px-4 sm:px-6' : 'max-w-7xl mx-auto px-4 sm:px-6 max-w-global';
$items = carbon_get_the_post_meta('quick_nav_items');
if (empty($items) || !is_array($items)) { return; }
$section_id = 'quick-product-nav-' . get_the_ID();
?>
<section id="<?php echo esc_attr($section_id); ?>" class="quick-product-nav bg-white shadow-sm">
  <div class="<?php echo esc_attr($wrap); ?>">
    <nav class="relative w-full transition-transform duration-200 ease-out" data-sticky-nav>
      <ul class="flex items-center gap-6 overflow-x-auto whitespace-nowrap py-3 border-b border-gray-200">
        <?php foreach ($items as $item): ?>
          <?php
            $label = isset($item['nav_label']) ? $item['nav_label'] : '';
            $target = isset($item['target_id']) ? ltrim($item['target_id'], '#') : '';
            if ($label === '' || $target === '') { continue; }
          ?>
          <li>
            <a href="<?php echo esc_url('#' . $target); ?>" class="text-sm p-2 inline-block sm:text-base font-semibold transition-colors" data-nav-link>
              <?php echo esc_html($label); ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>
  </div>
</section>
