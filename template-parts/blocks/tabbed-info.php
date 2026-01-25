<?php
$wrap = isset($wrap) ? $wrap : 'max-w-7xl mx-auto px-6 max-w-global';
$title = isset($title) ? $title : '';
$sub = isset($sub) ? $sub : '';
$items = isset($items) ? (array) $items : [];
$section_id = isset($section_id) ? $section_id : ('tabbed-info-' . uniqid());
?>
<section id="<?php echo esc_attr($section_id); ?>" class="py-12 lg:py-16">
  <div class="<?php echo esc_attr($wrap); ?> ace-tabbed-info" data-section-id="<?php echo esc_attr($section_id); ?>">
    <header class="text-center">
      <?php if ($title !== ''): ?>
        <h2 class="text-3xl lg:text-4xl font-bold"><?php echo esc_html($title); ?></h2>
      <?php endif; ?>
      <?php if ($sub !== ''): ?>
        <p class="text-gray-500 mt-4 max-w-2xl mx-auto"><?php echo esc_html($sub); ?></p>
      <?php endif; ?>
    </header>
    <div class="mt-6 flex flex-wrap justify-center gap-3" role="tablist" aria-label="Tabbed Info">
      <?php foreach ($items as $i => $item): ?>
        <?php
          $label = isset($item['tab_label']) ? (string) $item['tab_label'] : ('Tab ' . ($i + 1));
          $tgt = $section_id . '-' . $i;
          $btn_base = 'px-4 py-2 rounded-md border transition';
          $btn_class = $i === 0 ? ($btn_base . ' bg-brand-accent text-white border-transparent shadow-sm') : ($btn_base . ' bg-white text-gray-900  hover:border-brand-accent hover:text-brand-accent');
        ?>
        <button type="button" class="<?php echo esc_attr($btn_class); ?>" data-tab-target="<?php echo esc_attr($tgt); ?>" role="tab" aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>">
          <?php echo esc_html($label); ?>
        </button>
      <?php endforeach; ?>
    </div>
    <div class="mt-8">
      <?php foreach ($items as $i => $item): ?>
        <?php
          $tgt = $section_id . '-' . $i;
          $img_id = isset($item['tab_image']) ? (int) $item['tab_image'] : 0;
          $img_html = $img_id ? wp_get_attachment_image($img_id, 'large', false, ['class' => 'w-full h-full object-cover']) : '';
          $content = isset($item['tab_content']) ? (string) $item['tab_content'] : '';
          $pos = isset($item['image_position']) ? (string) $item['image_position'] : 'second';
          $bg = isset($item['text_bg_color']) ? (string) $item['text_bg_color'] : '';
          $dark = !empty($item['text_bg_dark']);
          $img_order = $pos === 'first' ? 'md:order-1' : 'md:order-2';
          $text_order = $pos === 'first' ? 'md:order-2' : 'md:order-1';
          $text_class = $dark ? 'text-white' : 'text-gray-900';
          $panel_class = $i === 0 ? 'grid' : 'hidden grid';
        ?>
        <div class="<?php echo esc_attr($panel_class); ?> grid-cols-1 md:grid-cols-2 gap-6 items-center rounded-md overflow-hidden" data-tab-panel="<?php echo esc_attr($tgt); ?>" <?php if ($bg !== ''): ?>style="background-color: <?php echo esc_attr($bg); ?>;"<?php endif; ?> role="tabpanel">
          <figure class="<?php echo esc_attr($img_order); ?>">
            <?php echo $img_html; ?>
          </figure>
          <div class="<?php echo esc_attr($text_order); ?>">
            <div class="p-6 md:p-8 <?php echo esc_attr($text_class); ?>" >
              <?php echo wp_kses_post($content); ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
