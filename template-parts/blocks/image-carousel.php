<?php
$wrap = isset($wrap) ? $wrap : 'max-w-7xl mx-auto px-6 max-w-global';
$heading = isset($heading) ? $heading : '';
$sub = isset($sub) ? $sub : '';
$items = isset($items) ? (array) $items : [];
$autoplay = isset($autoplay) ? (bool) $autoplay : false;
$per_view = isset($per_view) ? (int) $per_view : 5;
$section_id = isset($section_id) ? $section_id : ('image-carousel-' . uniqid());
?>
<section id="<?php echo esc_attr($section_id); ?>" class="py-12 sm:py-16 lg:py-20 bg-white">
  <div class="<?php echo esc_attr($wrap); ?> ace-image-carousel" data-autoplay="<?php echo $autoplay ? '1' : '0'; ?>" data-per-view="<?php echo esc_attr($per_view); ?>">
    <header class="text-center">
      <?php if ($heading !== ''): ?>
        <h2 class="text-3xl lg:text-4xl font-bold"><?php echo esc_html($heading); ?></h2>
      <?php endif; ?>
      <?php if ($sub !== ''): ?>
        <p class="text-gray-500 mt-4 max-w-2xl mx-auto"><?php echo esc_html($sub); ?></p>
      <?php endif; ?>
    </header>
    <div class="mt-6 relative">
      <div class="swiper">
        <div class="swiper-wrapper">
          <?php foreach ($items as $item): ?>
            <?php
              $img_id = isset($item['img']) ? (int) $item['img'] : 0;
              $alt = isset($item['alt']) ? (string) $item['alt'] : '';
              $html = $img_id ? wp_get_attachment_image($img_id, 'large', false, ['class' => 'w-full h-full object-contain']) : '';
              $src = $img_id ? wp_get_attachment_image_url($img_id, 'full') : '';
            ?>
            <div class="swiper-slide">
              <figure class="bg-brand-secondary rounded-md overflow-hidden  hover:shadow transition group">
                <button type="button" class="block w-full h-full p-2" data-modal-src="<?php echo esc_url($src); ?>" aria-label="Open image">
                  <?php echo $html; ?>
                 <?php echo !empty($alt) ? '<h3 class="text-center mt-2">' . esc_html($alt) . '</h3>' : ''; ?>
                </button>
              </figure>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="swiper-pagination !static !mt-6"></div>
    </div>
    <div class="ace-image-modal fixed inset-0 hidden bg-black/70 items-center justify-center z-50">
      <div class="relative max-w-5xl w-full p-4">
        <button type="button" class="absolute -top-5 -right-4 p-2 rounded-full bg-white/50 hover:bg-white/100 text-black shadow js-modal-close" aria-label="Close">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18.3 5.71 12 12.01 5.7 5.7 4.29 7.11 10.59 13.41 4.29 19.71 5.7 21.12 12 14.82 18.3 21.12 19.71 19.71 13.41 13.41 19.71 7.11z"/></svg>
        </button>
        <img  class="block mx-auto max-h-[80vh] w-auto object-contain bg-white rounded" src="" alt="">
      </div>
    </div>
  </div>
</section>
