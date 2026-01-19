<?php
// Media Carousel render template (Tailwind + Swiper)
// Requirements: Carbon Fields data, Tailwind for styling, Swiper.js for slider

if (! function_exists('carbon_get_the_post_meta')) {
    return;
}

// Section-level toggles
$hide_section   = carbon_get_the_post_meta('media_carousel_hide_section');
if ($hide_section) {
    return; // Do not render if hidden
}

// Fetch items
$items = carbon_get_the_post_meta('media_carousel_items');
if (empty($items) || ! is_array($items)) {
    return;
}

// Wrapper width logic
$full_width = carbon_get_the_post_meta('media_carousel_full_width');
$wrapper_classes = $full_width ? 'w-full' : 'max-w-7xl mx-auto';

// Title / description
$section_title       = carbon_get_the_post_meta('media_carousel_title');
$section_description = carbon_get_the_post_meta('media_carousel_description');
$section_id_input    = (string) carbon_get_the_post_meta('media_carousel_section_id');
$section_id          = $section_id_input !== '' ? sanitize_title($section_id_input) : 'media-carousel-' . get_the_ID();

?>

<section id="<?php echo esc_attr($section_id); ?>" class="media-carousel py-10 sm:py-12 md:py-10 bg-white">
    <div class="<?php echo esc_attr($wrapper_classes); ?> px-4 sm:px-6 md:px-8 lg:px-12">
        <?php if (! empty($section_title) || ! empty($section_description)) : ?>
            <header class="text-center max-w-3xl mx-auto">
                <?php if (! empty($section_title)) : ?>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-semibold text-gray-900">
                        <?php echo esc_html($section_title); ?>
                    </h2>
                <?php endif; ?>
                <?php if (! empty($section_description)) : ?>
                    <p class="mt-3 text-sm sm:text-base md:text-lg text-gray-600">
                        <?php echo esc_html($section_description); ?>
                    </p>
                <?php endif; ?>
            </header>
        <?php endif; ?>

        <!-- Swiper container -->
        <div class="mt-8 sm:mt-10 relative group -mx-4 sm:-mx-6 md:-mx-8 lg:-mx-12">
            <div class="swiper overflow-visible relative list-none p-0 z-10">
                <div class="swiper-wrapper relative w-full h-full z-10 flex transition-transform box-content">
                    <?php foreach ($items as $item) : ?>
                        <?php
                        $image_id    = isset($item['carousel_image']) ? (int) $item['carousel_image'] : 0;
                        $date_text   = isset($item['carousel_date']) ? $item['carousel_date'] : '';
                        $title       = isset($item['carousel_title']) ? $item['carousel_title'] : '';
                        $desc        = isset($item['carousel_description']) ? $item['carousel_description'] : '';
                        $link        = isset($item['carousel_link']) ? $item['carousel_link'] : '';
                        ?>

                     
                        <article class="swiper-slide shrink-0 w-full h-full relative transition-transform">                           
                            <div class="grid grid-cols-1 md:grid-cols-5 md:gap-0 h-full min-h-[500px] overflow-hidden bg-white shadow-sm border border-gray-100 md:border-none">
                     
                                <figure class="md:col-span-3 relative h-full min-h-[300px] md:min-h-[500px]">
                                    <?php
                                    if ($image_id) {
                                        echo wp_get_attachment_image(
                                            $image_id,
                                            'large',
                                            false,
                                            [
                                                'class'   => 'absolute inset-0 w-full h-full object-cover',
                                                'loading' => 'lazy',
                                            ]
                                        );
                                    } else {
                                        echo '<div class="absolute inset-0 bg-gray-200"></div>';
                                    }
                                    ?>
                                </figure>

                                <aside class="md:col-span-2 bg-brand-accent text-white p-6 sm:p-8 md:p-10 flex flex-col justify-center h-full min-h-[200px]">
                                    <div class="w-full max-w-full overflow-hidden">
                                        <?php if (! empty($date_text)) : ?>
                                            <div class="inline-block px-3 py-1 mb-4 border border-white/30 text-xs font-medium tracking-wide whitespace-nowrap">
                                                <?php echo esc_html($date_text); ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (! empty($title)) : ?>
                                            <h3 class="text-xl sm:text-2xl font-bold leading-tight mb-4 line-clamp-2">
                                                <?php echo esc_html($title); ?>
                                            </h3>
                                        <?php endif; ?>

                                        <?php if (! empty($desc)) : ?>
                                            <div class="text-white/90 text-sm sm:text-base leading-relaxed mb-6 line-clamp-3 md:line-clamp-4 overflow-hidden">
                                                <?php echo wpautop(esc_html($desc)); ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (! empty($link)) : ?>
                                            <a href="<?php echo esc_url($link); ?>" class="inline-flex items-center text-white font-semibold hover:underline decoration-2 underline-offset-4 group-link mt-auto">
                                                <span class="mr-2">Learn More</span>
                                                <span class="transform transition-transform group-link-hover:translate-x-1">→</span>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </aside>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Pagination -->
            <div class="swiper-pagination !static !mt-8" style="--swiper-pagination-color: #2563eb;"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var section = document.getElementById('<?php echo esc_js($section_id); ?>');
            if (!section) return;

            var swiperEl = section.querySelector('.swiper');
            var paginationEl = section.querySelector('.swiper-pagination');

            // Wait for Swiper to be available
            var initSwiper = function() {
                if (typeof Swiper === 'undefined') {
                    console.warn('Swiper not loaded yet');
                    return;
                }

                new Swiper(swiperEl, {
                    slidesPerView: 1.2, // Show partial next slide on mobile (1.2 = 1 full + 0.2 of next)
                    spaceBetween: 16,
                    centeredSlides: true, // Center the active slide, showing partial content on both sides
                    loop: true, // Loop enabled for continuous sliding
                 
                    speed: 600,
                    observer: true,
                    observeParents: true,
                    pagination: {
                        el: paginationEl,
                        clickable: true,
                    },
                   breakpoints: {
                        640: { 
                            slidesPerView: 1.25, // Show partial next slide
                            spaceBetween: 20 
                        },
                        768: { 
                            slidesPerView: 1.3, // Show partial next slide
                            spaceBetween: 15
                        },
                        1024: { 
                            slidesPerView: 1.35, // Show more of next slide on larger screens
                            spaceBetween: 20
                        },
                        1280: { 
                            slidesPerView: 1.5, // Show even more of next slide
                            spaceBetween: 25 
                        }
                    },
                    autoplay: {
                        delay: 10000,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true
                    },
                    on: {
                        slideChange: function() {                         
                            this.slides.forEach(slide => {
                                slide.style.height = 'auto';
                            });
                        }
                    }
                });
            };

            // Try initializing immediately, or fallback to window load
            if (typeof Swiper !== 'undefined') {
                initSwiper();
            } else {
                window.addEventListener('load', initSwiper);
            }
        });
    </script>
</section>
