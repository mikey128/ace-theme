<?php
/**
 * Testimonials Carousel Block Template
 * Used by Carbon Fields Block
 */

if (empty($items)) {
  return;
}
?>
<section id="<?php echo esc_attr($section_id); ?>" class="py-12 sm:py-16 md:py-20 bg-white home-testimonials-section overflow-hidden">
  <style>
    #<?php echo esc_attr($section_id); ?> .swiper {
      overflow: hidden;
      padding: 2rem 0 0;
    }
    #<?php echo esc_attr($section_id); ?> .swiper-slide {
      width: 85vw;
      max-width: 28rem;
      transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      transform: scale(0.85);
      opacity: 0.4;
      z-index: 1;
      height: auto;
    }
    #<?php echo esc_attr($section_id); ?> .swiper-slide.swiper-slide-active {
      transform: scale(1.05);
      opacity: 1;
      z-index: 20;
    }
    #<?php echo esc_attr($section_id); ?> .swiper-slide.swiper-slide-prev {
      z-index: 10;
      opacity: 0.5;
      transform: scale(0.88);
    }
    #<?php echo esc_attr($section_id); ?> .swiper-slide.swiper-slide-next {
      z-index: 10;
      opacity: 0.5;
      transform: scale(0.88);
    }
    
    @media (min-width: 640px) {
      #<?php echo esc_attr($section_id); ?> .swiper-slide {
        width: 70vw;
        max-width: 30rem;
      }
    }
    
    @media (min-width: 768px) {
      #<?php echo esc_attr($section_id); ?> .swiper-slide {
        width: 50vw;
        max-width: 32rem;
      }
      #<?php echo esc_attr($section_id); ?> .swiper-slide.swiper-slide-prev {
        transform: translateX(30px) scale(0.88);
        opacity: 0.5;
      }
      #<?php echo esc_attr($section_id); ?> .swiper-slide.swiper-slide-next {
        transform: translateX(-30px) scale(0.88);
        opacity: 0.5;
      }
      #<?php echo esc_attr($section_id); ?> .swiper-slide.swiper-slide-active {
        transform: scale(1.1);
      }
    }
    @media (min-width: 1024px) {
      #<?php echo esc_attr($section_id); ?> .swiper-slide {
        width: 33.333%;
        max-width: 35rem;
      }
      #<?php echo esc_attr($section_id); ?> .swiper-slide.swiper-slide-prev {
        transform: translateX(50px) scale(0.9);
      }
      #<?php echo esc_attr($section_id); ?> .swiper-slide.swiper-slide-next {
        transform: translateX(-50px) scale(0.9);
      }
      #<?php echo esc_attr($section_id); ?> .swiper-slide.swiper-slide-active {
        transform: scale(1.15);
      }
    }
  </style>
  
  <div class="<?php echo esc_attr($wrap); ?>">
    <?php if ($title !== '' || $desc !== ''): ?>
      <header class="text-center max-w-3xl mx-auto mb-10 sm:mb-12 md:mb-16">
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

    <div class="relative">
      <div class="swiper">
        <div class="swiper-wrapper pb-12 pt-16">
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
              <div class="testimonial-card relative bg-white rounded-2xl shadow-xl border border-gray-100 px-6 sm:px-6 pt-20 pb-6 text-center w-full h-full flex flex-col">
                <?php if ($avatar_html !== ''): ?>
                  <figure class="absolute -top-10 left-1/2 -translate-x-1/2 z-20">
                    <div class="w-20 h-20 md:w-24 md:h-24 rounded-full overflow-hidden mx-auto bg-white">
                      <?php echo $avatar_html; ?>
                    </div>
                  </figure>
                <?php endif; ?>
                
                <div class="flex-grow flex items-center justify-center">
                    <?php if ($quote !== ''): ?>
                    <blockquote class="text-base sm:text-md text-gray-800 leading-relaxed font-medium">
                        "<?php echo esc_html($quote); ?>"
                    </blockquote>
                    <?php endif; ?>
                </div>

                <div class="mt-6 sm:mt-8">
                  <?php if ($author_name !== ''): ?>
                    <p class="text-base sm:text-lg font-bold text-gray-900"><?php echo esc_html($author_name); ?></p>
                  <?php endif; ?>
                  <?php if ($author_title !== '' || $author_company !== ''): ?>
                    <p class="text-sm text-gray-600 mt-1">
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
          centeredSlides: true,
          initialSlide: 1,
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
          breakpoints: {
            640: {
              slidesPerView: 1.5,
              spaceBetween: 0
            },
            768: { 
              slidesPerView: 2,
              spaceBetween: 0
            },         
            1024: {
              slidesPerView: 3,
              spaceBetween: 0
            }
          },
          on: {
            init: function (sw) {
              sw.updateSize();
              sw.updateSlides();
              sw.slideTo(1, 0, false);
            }
          }
        });
      };

      window.addEventListener('load', initSwiper);
    });
  </script>
</section>
