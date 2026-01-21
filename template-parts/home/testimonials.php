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
<section id="<?php echo esc_attr($section_id); ?>" class="py-12 sm:py-16 md:py-20 bg-white home-testimonials-section overflow-hidden">
  <style>
    #<?php echo esc_attr($section_id); ?> .swiper {
      overflow: hidden;
    }
    #<?php echo esc_attr($section_id); ?> .swiper-slide {
      transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      transform: scale(0.85);
      opacity: 0.5;
      z-index: 1;
      height: auto;
    }
    #<?php echo esc_attr($section_id); ?> .swiper-slide.swiper-slide-active {
      transform: scale(1);
      opacity: 1;
      z-index: 20;
    }
    #<?php echo esc_attr($section_id); ?> .swiper-slide.swiper-slide-prev {
      z-index: 10;
      opacity: 0.8;
    }
    #<?php echo esc_attr($section_id); ?> .swiper-slide.swiper-slide-next {
      z-index: 10;
      opacity: 0.8;
    }
    
    @media (min-width: 768px) {
        #<?php echo esc_attr($section_id); ?> .swiper-slide.swiper-slide-prev {
            transform: translateX(40px) scale(0.85);
        }
        #<?php echo esc_attr($section_id); ?> .swiper-slide.swiper-slide-next {
            transform: translateX(-40px) scale(0.85);
        }
    }
    @media (min-width: 1024px) {
        #<?php echo esc_attr($section_id); ?> .swiper-slide.swiper-slide-prev {
            transform: translateX(60px) scale(0.85);
        }
        #<?php echo esc_attr($section_id); ?> .swiper-slide.swiper-slide-next {
            transform: translateX(-60px) scale(0.85);
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
        <div class="swiper-wrapper pb-12 pt-8">
          <?php foreach ($items as $item): ?>
            <?php
              $avatar_id    = isset($item['avatar']) ? (int) $item['avatar'] : 0;
              $quote        = isset($item['quote']) ? (string) $item['quote'] : '';
              $author_name  = isset($item['author_name']) ? (string) $item['author_name'] : '';
              $author_title = isset($item['author_title']) ? (string) $item['author_title'] : '';
              $author_company = isset($item['author_company']) ? (string) $item['author_company'] : '';
              $avatar_html  = $avatar_id ? wp_get_attachment_image($avatar_id, 'thumbnail', false, ['class' => 'w-16 h-16 md:w-20 md:h-20 rounded-full object-cover']) : '';
            ?>
            <!-- Adjusted widths for 3 items per view look -->
            <article class="swiper-slide ">
              <div class="testimonial-card relative bg-white rounded-2xl shadow-xl border border-gray-100 px-6 sm:px-8 pt-20 pb-10 text-center w-full h-full flex flex-col">
                <?php if ($avatar_html !== ''): ?>
                  <figure class="absolute -top-10 left-1/2 -translate-x-1/2 z-20">
                    <div class="w-20 h-20 md:w-24 md:h-24 rounded-full ring-4 ring-white shadow-lg overflow-hidden mx-auto bg-white">
                      <?php echo $avatar_html; ?>
                    </div>
                  </figure>
                <?php endif; ?>
                
                <div class="flex-grow flex items-center justify-center">
                    <?php if ($quote !== ''): ?>
                    <blockquote class="text-base sm:text-lg text-gray-800 leading-relaxed font-medium italic">
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
        new Swiper(swiperEl, {
          slidesPerView: 'auto',
          centeredSlides: true,
          loop: <?php echo count($items) > 2 ? 'true' : 'false'; ?>,
          spaceBetween: 20, // Mobile spacing
          speed: 600,
          grabCursor: true,
          pagination: { 
            el: paginationEl, 
            clickable: true 
          },
          breakpoints: {
            768: { 
              spaceBetween: 0 // Rely on CSS transform for overlap
            },         
            1024: {
              slidesPerView: 3,
              spaceBetween: 0,
            }
          }
        });
      };

      if (typeof Swiper !== 'undefined') { initSwiper(); }
      else { window.addEventListener('load', initSwiper); }
    });
  </script>
</section>
