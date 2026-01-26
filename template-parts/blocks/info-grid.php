<?php
/**
 * Info Grid Block Template
 * 
 * Available variables:
 * $wrap        : Wrapper classes (width)
 * $heading     : Section heading
 * $subheading  : Section subheading
 * $alignment   : Text alignment (left, center, right)
 * $items       : Array of grid items
 * $section_id  : Unique ID for the section
 */

// Map alignment to class
$align_class = 'text-left';
if ($alignment === 'center') {
  $align_class = 'text-center';
} elseif ($alignment === 'right') {
  $align_class = 'text-right';
}

// Button alignment
$btn_align_class = '';
if ($alignment === 'center') {
  $btn_align_class = 'mx-auto';
} elseif ($alignment === 'right') {
  $btn_align_class = 'ml-auto';
}

$img_align_class = '';
if ($alignment === 'center') {
  $img_align_class = 'mx-auto';
} elseif ($alignment === 'right') {
  $img_align_class = 'ml-auto';
}

// Columns per row
$cols = isset($cols) ? (int) $cols : 4;
$grid = 'grid-cols-1';
if ($cols === 2) {
  $grid = 'grid-cols-1 md:grid-cols-2';
} elseif ($cols === 3) {
  $grid = 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3';
} elseif ($cols === 4) {
  $grid = 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4';
} elseif ($cols === 5) {
  $grid = 'grid-cols-1 md:grid-cols-2 lg:grid-cols-5';
} elseif ($cols === 6) {
  $grid = 'grid-cols-1 md:grid-cols-2 lg:grid-cols-6';
}
$bg_color = isset($fields['info_item_bg_color']) ? $fields['info_item_bg_color'] : '';
$is_dark = !empty($fields['info_item_is_dark']);
// Text Color Class
$text_color_class = $is_dark ? 'text-white' : 'text-gray-900';

// Background Style
$bg_style = $bg_color ? 'background-color: ' . esc_attr($bg_color) . ';' : '';
?>

<section id="<?php echo esc_attr($section_id); ?>" class="py-16 lg:py-24 bg-white">
  <div class="<?php echo esc_attr($wrap); ?>">
    
    <?php if ($heading || $subheading): ?>
      <header class="mb-12 <?php echo esc_attr($align_class); ?>">
        <?php if ($heading): ?>
          <h2 class="text-3xl lg:text-4xl font-bold mb-4 text-gray-900"><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>
        <?php if ($subheading): ?>
          <div class="text-gray-600 text-lg max-w-3xl <?php echo ($alignment === 'center' ? 'mx-auto' : ''); ?>">
            <?php echo wpautop(esc_html($subheading)); ?>
          </div>
        <?php endif; ?>
      </header>
    <?php endif; ?>

    <?php if (!empty($items)): ?>
      <div class="grid gap-8 <?php echo esc_attr($grid); ?>">
        <?php foreach ($items as $item): ?>
          <?php
            $img_id = isset($item['image']) ? $item['image'] : 0;
            $title = isset($item['title']) ? $item['title'] : '';
            $desc = isset($item['description']) ? $item['description'] : '';
            $btn_label = isset($item['button_label']) ? $item['button_label'] : '';
            $btn_link = isset($item['button_link']) ? $item['button_link'] : '';
          ?>
          <article class="flex flex-col p-6 rounded-md  <?php echo esc_attr($text_color_class); ?> <?php echo esc_attr($align_class); ?>" style="<?php echo esc_attr($bg_style); ?> <?php echo esc_attr($text_color_class); ?>">
            <?php if ($img_id): ?>
              <div class="mb-6 md:min-h-12" >
                <?php
                  $img_classes = 'max-w-full h-auto rounded-lg shadow-sm';
                  if (!empty($img_align_class)) { $img_classes .= ' ' . $img_align_class; }
                  echo wp_get_attachment_image($img_id, 'large', false, ['class' => $img_classes]);
                ?>
              </div>
            <?php endif; ?>
            
            <div class="flex-1">
              <?php if ($title): ?>
                <h3 class="text-xl font-bold mb-3 text-gray-900"><?php echo esc_html($title); ?></h3>
              <?php endif; ?>
              
              <?php if ($desc): ?>
                <div class="text-gray-600 mb-6">
                 <?php echo wp_kses_post($desc); ?>
                </div>
              <?php endif; ?>
            </div>
    
            <?php if ($btn_label && $btn_link): ?>
              <div class="mt-auto">
                <a href="<?php echo esc_url($btn_link); ?>" class="inline-block px-6 py-3 bg-brand-accent text-white font-medium rounded hover:bg-opacity-90 transition-colors <?php echo esc_attr($btn_align_class); ?>">
                  <?php echo esc_html($btn_label); ?>
                </a>
              </div>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </div>
</section>
