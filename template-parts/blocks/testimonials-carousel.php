<?php
/**
 * Testimonials Carousel Block Template
 * Used by Carbon Fields Block
 */

if (empty($items)) {
  return;
}
?>
<section id="<?php echo esc_attr($section_id); ?>" class="py-12   md:py-12 bg-white testimonials-section overflow-hidden">
  
  
  <div class="<?php echo esc_attr($wrap); ?>">
    <?php if ($title !== '' || $desc !== ''): ?>
      <header class="text-center max-w-3xl mx-auto mb-4 sm:mb-8 ">
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

    <div class="relative max-w-4xl mx-auto">
      <div class="swiper">
        <div class="swiper-wrapper pb-12 ">
          <?php foreach ($items as $item): ?>
            <?php
              $avatar_id    = isset($item['avatar']) ? (int) $item['avatar'] : 0;
              $quote        = isset($item['quote']) ? (string) $item['quote'] : '';
              $author_name  = isset($item['author_name']) ? (string) $item['author_name'] : '';
              $author_title = isset($item['author_title']) ? (string) $item['author_title'] : '';
              $author_company = isset($item['author_company']) ? (string) $item['author_company'] : '';
              $avatar_html  = $avatar_id ? wp_get_attachment_image($avatar_id, 'thumbnail', false, ['class' => 'w-full h-full rounded-full object-cover']) : '';
            ?>
            <article class="swiper-slide">
              <div class="testimonial-card bg-white rounded-2xl px-6 sm:px-6 pt-8 pb-10 text-center w-full h-full flex flex-col">
                <div class="flex-grow flex items-center justify-center">
                    <?php if ($quote !== ''): ?>
                    <blockquote class="text-base sm:text-lg font-semibold text-gray-800 leading-relaxed font-medium">
                        "<?php echo esc_html($quote); ?>"
                    </blockquote>
                    <?php endif; ?>
                </div>

                <div class="mt-6 sm:mt-8 flex items-center justify-center gap-4">
                  <?php if ($avatar_html !== ''): ?>
                    <div class="w-14 h-14 md:w-20 md:h-20 text-xl rounded-full overflow-hidden">
                      <?php echo $avatar_html; ?>
                    </div>
                  <?php endif; ?>
                  <div class="text-left">
                    <?php if ($author_name !== ''): ?>
                      <h4 class="text-base lg:text-xl font-bold text-gray-900"><?php echo esc_html($author_name); ?></h4>
                    <?php endif; ?>
                    <?php if ($author_title !== '' || $author_company !== ''): ?>
                      <p class="text-sm sm:text-base text-gray-600 mt-1">
                        <?php echo esc_html($author_title); ?>
                        <?php if ($author_title !== '' && $author_company !== ''): ?>
                          <span class="mx-1">·</span>
                        <?php endif; ?>
                        <?php if ($author_company !== ''): ?>
                          <span class="text-blue-600 font-medium"><?php echo esc_html($author_company); ?></span>
                        <?php endif; ?>
                      </p>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="swiper-pagination !static !mt-8" style="--swiper-pagination-color: #2563eb;"></div>
    </div>
  </div>


  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var section = document.getElementById('<?php echo esc_js($section_id); ?>');
      if (!section) return;
      var swiperEl = section.querySelector('.swiper');
      var paginationEl = section.querySelector('.swiper-pagination');

      var initSwiper = function () {
        if (typeof Swiper === 'undefined') { return; }
        var swiper = new Swiper(swiperEl, {
          slidesPerView: 1,
          centeredSlides: false,
          loop: false,
          watchSlidesProgress: true,
          observer: true,
          observeParents: true,
          spaceBetween: 0,
          speed: 600,
          grabCursor: true,
          pagination: { 
            el: paginationEl, 
            clickable: true 
          },
          breakpoints: {}
        });
      };

      window.addEventListener('load', initSwiper);
    });
  </script>
</section>
