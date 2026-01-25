<?php
$info = get_query_var('info_stats');
$wrap = isset($info['wrap']) ? $info['wrap'] : 'max-w-7xl mx-auto px-6 max-w-global';
$title = isset($info['title']) ? $info['title'] : '';
$sub = isset($info['sub']) ? $info['sub'] : '';
$desc = isset($info['desc']) ? $info['desc'] : '';
$grid = isset($info['grid']) ? $info['grid'] : 'grid-cols-2 md:grid-cols-4';
$items = isset($info['items']) ? (array) $info['items'] : [];
$section_id = isset($info['id']) ? $info['id'] : ('info-stats-' . uniqid());
?>
<section id="<?php echo esc_attr($section_id); ?>" class="py-12 lg:py-16 bg-white">
  <div class="<?php echo esc_attr($wrap); ?> ace-info-stats">
    <header class="text-center">
      <?php if ($title !== ''): ?>
        <h2 class="text-3xl lg:text-4xl font-bold"><?php echo esc_html($title); ?></h2>
      <?php endif; ?>
      <?php if ($sub !== ''): ?>
        <p class="text-gray-500 mt-4 max-w-2xl mx-auto"><?php echo esc_html($sub); ?></p>
      <?php endif; ?>
    </header>
    <?php if (!empty($items)): ?>
      <div class="mt-8 grid gap-6 <?php echo esc_attr($grid); ?>">
        <?php foreach ($items as $item): ?>
          <?php
            $number = isset($item['number']) ? (string) $item['number'] : '0';
            $label  = isset($item['label']) ? (string) $item['label'] : '';
            $hl     = !empty($item['highlight']);
            $card   = 'border rounded-md p-6 text-center text-brand-accent bg-white hover:bg-brand-accent hover:text-white transition-all duration-300 shadow-sm';
            if ($hl) { $card = 'text-center border-transparent rounded-md p-6 bg-brand-accent text-white transition shadow-sm'; }
          ?>
          <article class="<?php echo esc_attr($card); ?>">
            <p class="text-3xl mb-2 lg:text-4xl font-bold">
              <span data-info-stat-target="<?php echo esc_attr($number); ?>">0</span>
            </p>
            <?php if ($label !== ''): ?>
              <p class="mt-0 mb-0 text-base uppercase tracking-wide"><?php echo esc_html($label); ?></p>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <?php if ($desc !== ''): ?>
      <div class="mt-8 text-left text-gray-700">
        <?php echo wp_kses_post($desc); ?>
      </div>
    <?php endif; ?>
  </div>
</section>
