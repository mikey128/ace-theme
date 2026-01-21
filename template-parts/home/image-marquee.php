<?php
$hide = carbon_get_the_post_meta('home_partners_hide');
if ($hide) { return; }
$items = carbon_get_the_post_meta('home_partners_items');
if (empty($items) || !is_array($items)) { return; }
$full = carbon_get_the_post_meta('home_partners_full_width');
$wrap = $full ? 'w-full px-6' : 'max-w-7xl mx-auto px-6 max-w-global';
$title = (string) carbon_get_the_post_meta('home_partners_title');
$section_id = 'home-partners-' . uniqid();
?>
<section id="<?php echo esc_attr($section_id); ?>" class="py-10 sm:py-12 bg-white">
  <div class="<?php echo esc_attr($wrap); ?>">
    <?php if ($title !== ''): ?>
      <header class="text-center mb-6 sm:mb-8">
        <h2 class="text-xl sm:text-2xl md:text-3xl font-semibold text-gray-900"><?php echo esc_html($title); ?></h2>
      </header>
    <?php endif; ?>
    <div class="relative -mx-6 sm:-mx-8 md:-mx-12">
      <div class="swiper w-full overflow-visible">
        <div class="swiper-wrapper items-center">
          <?php foreach ($items as $item): ?>
            <?php
              $logo_id = isset($item['logo']) ? (int) $item['logo'] : 0;
              $name = isset($item['name']) ? (string) $item['name'] : '';
              if (!$logo_id) { continue; }
            ?>
            <figure class="swiper-slide px-2 sm:px-3">
              <div class="h-20 sm:h-24 w-full rounded-xl bg-white ring-1 ring-black/5 shadow-sm flex items-center justify-center">
                <?php echo wp_get_attachment_image($logo_id, 'medium', false, ['class' => 'max-h-16 sm:max-h-20 w-auto object-contain', 'alt' => $name]); ?>
              </div>
            </figure>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var el = document.getElementById('<?php echo esc_js($section_id); ?>');
      if (!el) return;
      var swiperEl = el.querySelector('.swiper');
      if (!swiperEl || typeof Swiper === 'undefined') { window.addEventListener('load', function(){ if (typeof Swiper !== 'undefined') init(); }); } else { init(); }
      function init() {
        new Swiper(swiperEl, {
          slidesPerView: 2.5,
          spaceBetween: 12,
          loop: true,
          speed: 4000,
          autoplay: { delay: 0, disableOnInteraction: false, pauseOnMouseEnter: false },
          allowTouchMove: true,
          breakpoints: {
            640:  { slidesPerView: 3.5, spaceBetween: 14 },
            768:  { slidesPerView: 4.5, spaceBetween: 16 },
            1024: { slidesPerView: 6,   spaceBetween: 18 },
            1280: { slidesPerView: 7,   spaceBetween: 20 }
          }
        });
      }
    });
  </script>
  <style>
    #<?php echo esc_attr($section_id); ?> .swiper-wrapper { transition-timing-function: linear !important; }
  </style>
</section>