<?php
$hide = function_exists('carbon_get_the_post_meta') ? carbon_get_the_post_meta('home_testimonials_hide') : false;
if ($hide) { return; }

$items = function_exists('carbon_get_the_post_meta') ? carbon_get_the_post_meta('home_testimonials_items') : [];
if (empty($items) || !is_array($items)) { return; }

$full = carbon_get_the_post_meta('home_testimonials_full_width');
$wrap = $full ? 'w-full px-6' : 'max-w-7xl mx-auto px-6 max-w-global';

$title = (string) carbon_get_the_post_meta('home_testimonials_title');
$desc  = (string) carbon_get_the_post_meta('home_testimonials_description');
$section_id = 'home-testimonials-' . uniqid();
?>
<section id="<?php echo esc_attr($section_id); ?>" class="py-12 sm:py-16 md:py-20 bg-white">
  <div class="<?php echo esc_attr($wrap); ?>">
    <?php if ($title !== '' || $desc !== ''): ?>
      <header class="text-center max-w-3xl mx-auto">
        <?php if ($title !== ''): ?>
          <h2 class="text-2xl sm:text-3xl md:text-4xl font-semibold text-gray-900">
            <?php echo esc_html($title); ?>
          </h2>
        <?php endif; ?>
        <?php if ($desc !== ''): ?>
          <p class="mt-3 text-sm sm:text-base md:text-lg text-gray-600">
            <?php echo esc_html($desc); ?>
          </p>
        <?php endif; ?>
      </header>
    <?php endif; ?>

    <div class="mt-10 relative -mx-6 sm:-mx-8 md:-mx-12 lg:-mx-16">
      <div class="swiper w-full overflow-visible relative">
        <div class="swiper-wrapper items-stretch box-content">
          <?php foreach ($items as $item): ?>
            <?php
              $avatar_id    = isset($item['avatar']) ? (int) $item['avatar'] : 0;
              $quote        = isset($item['quote']) ? (string) $item['quote'] : '';
              $author_name  = isset($item['author_name']) ? (string) $item['author_name'] : '';
              $author_title = isset($item['author_title']) ? (string) $item['author_title'] : '';
              $author_company = isset($item['author_company']) ? (string) $item['author_company'] : '';
              $avatar_html  = $avatar_id ? wp_get_attachment_image($avatar_id, 'thumbnail', false, ['class' => 'w-16 h-16 md:w-20 md:h-20 rounded-full object-cover']) : '';
            ?>
            <article class="swiper-slide flex justify-center px-1">
              <div class="testimonial-card relative bg-white rounded-2xl shadow-md px-6 sm:px-8 pt-16 pb-12 text-center max-w-2xl w-full">
                <?php if ($avatar_html !== ''): ?>
                  <figure class="absolute -top-12 left-1/2 -translate-x-1/2 z-20">
                    <div class="w-20 h-20 md:w-24 md:h-24 rounded-full ring-4 ring-white shadow-md overflow-hidden mx-auto">
                      <?php echo $avatar_html; ?>
                    </div>
                  </figure>
                <?php endif; ?>
                <?php if ($quote !== ''): ?>
                  <blockquote class="text-lg sm:text-xl md:text-2xl text-gray-800 leading-relaxed">
                    <?php echo esc_html($quote); ?>
                  </blockquote>
                <?php endif; ?>
                <div class="mt-6">
                  <?php if ($author_name !== ''): ?>
                    <p class="text-base sm:text-lg font-semibold text-gray-900"><?php echo esc_html($author_name); ?></p>
                  <?php endif; ?>
                  <?php if ($author_title !== '' || $author_company !== ''): ?>
                    <p class="text-sm sm:text-base text-gray-500">
                      <?php echo esc_html($author_title); ?>
                      <?php if ($author_company !== ''): ?>
                        <span class="text-blue-600 font-medium">@<?php echo esc_html($author_company); ?></span>
                      <?php endif; ?>
                    </p>
                  <?php endif; ?>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="swiper-pagination !static !mt-8" style="--swiper-pagination-color: #2563eb;"></div>
    </div>
  </div>

  <style>
    #<?php echo esc_attr($section_id); ?> .swiper-slide .testimonial-card {
      transform: scale(0.96);
      opacity: 0.55;
      transition: transform .4s ease, opacity .4s ease;
    }
    #<?php echo esc_attr($section_id); ?> .swiper-slide-active .testimonial-card {
      transform: scale(1);
      opacity: 1;
    }
    #<?php echo esc_attr($section_id); ?> .swiper-slide-prev .testimonial-card,
    #<?php echo esc_attr($section_id); ?> .swiper-slide-next .testimonial-card {
      opacity: 0.4;
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var section = document.getElementById('<?php echo esc_js($section_id); ?>');
      if (!section) return;
      var swiperEl = section.querySelector('.swiper');
      var paginationEl = section.querySelector('.swiper-pagination');

      var initSwiper = function () {
        if (typeof Swiper === 'undefined') { return; }
        new Swiper(swiperEl, {
          slidesPerView: 1.2,
          centeredSlides: true,
          loop: <?php echo count($items) > 1 ? 'true' : 'false'; ?>,
          spaceBetween: 16,
          speed: 600,
          observer: true,
          observeParents: true,
          pagination: { el: paginationEl, clickable: true },
          breakpoints: {
            640:  { slidesPerView: 1.25, spaceBetween: 18 },
            768:  { slidesPerView: 1.3,  spaceBetween: 20 },
            1024: { slidesPerView: 1.35, spaceBetween: 22 },
            1280: { slidesPerView: 1.45, spaceBetween: 24 }
          }
        });
      };

      if (typeof Swiper !== 'undefined') { initSwiper(); }
      else { window.addEventListener('load', initSwiper); }
    });
  </script>
</section>

