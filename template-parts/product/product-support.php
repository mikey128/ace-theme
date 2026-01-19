<?php
if (! function_exists('carbon_get_the_post_meta')) { return; }

$hide = carbon_get_the_post_meta('hide_section');
if ($hide) { return; }

$full = carbon_get_the_post_meta('enable_full_width');
$wrap = $full ? 'w-full px-6' : 'max-w-7xl mx-auto px-6 max-w-global';

$heading   = carbon_get_the_post_meta('support_heading');
$videos    = carbon_get_the_post_meta('support_videos');
$documents = carbon_get_the_post_meta('support_documents');

if ((!is_array($videos) || empty($videos)) && (!is_array($documents) || empty($documents))) { return; }

$section_id_input = (string) carbon_get_the_post_meta('support_section_id');
$section_id    = $section_id_input !== '' ? sanitize_title($section_id_input) : 'product-support-' . get_the_ID();
?>
<section id="<?php echo esc_attr($section_id); ?>" class="py-10 sm:py-12 md:py-16 bg-white">
  <div class="<?php echo esc_attr($wrap); ?>">
    <?php if (!empty($heading)) : ?>
      <header class="text-center mb-8">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-semibold text-gray-900">
          <?php echo esc_html($heading); ?>
        </h2>
      </header>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 sm:gap-8">
      <div class="md:col-span-2">
        <?php if (is_array($videos) && !empty($videos)) : ?>
          <div class="relative group">
            <div class="swiper js-support-left">
              <div class="swiper-wrapper">
                <?php foreach ($videos as $v): ?>
                  <?php
                    $title = isset($v['title']) ? $v['title'] : '';
                    $cover_id = isset($v['cover_image']) ? (int) $v['cover_image'] : 0;
                    $video_val = isset($v['video_file']) ? $v['video_file'] : '';
                    $video_url = is_numeric($video_val) ? wp_get_attachment_url((int)$video_val) : $video_val;
                  ?>
                  <article class="swiper-slide">
                    <div class="bg-gray-100 overflow-hidden">
                      <div class="relative group  w-full h-80 sm:h-96 md:h-[380px] ">
                        <?php if ($video_url) : ?>
                          <video
                            src="<?php echo esc_url($video_url); ?>"
                            <?php if ($cover_id) : ?>
                              poster="<?php echo esc_url(wp_get_attachment_image_url($cover_id, 'large')); ?>"
                            <?php endif; ?>
                            class="w-full h-full object-cover transform transition duration-300 ease-out hover:scale-[1.02] group-hover:scale-[1.02] cursor-pointer"
                             preload="metadata"
                          ></video>
                          <button type="button" class="js-play absolute inset-0 flex items-center justify-center">
                            <span class="relative inline-flex items-center justify-center w-16 h-16 sm:w-18 sm:h-18 rounded-full bg-brand-accent text-white shadow-md transform transition group-hover:scale-105 hover:scale-105">
                              <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M8 5v14l11-7-11-7z"></path>
                              </svg>
                              <span class="absolute inset-0 rounded-full ring-4 ring-blue-300/40"></span>
                            </span>
                          </button>
                        <?php else : ?>
                          <figure class="w-full h-64 sm:h-72 md:h-80 flex items-center justify-center overflow-hidden">
                            <?php
                              if ($cover_id) {
                                echo wp_get_attachment_image($cover_id, 'large', false, [
                                  'class' => 'w-full h-full object-cover transform transition duration-300 ease-out hover:scale-[1.02]',
                                  'loading' => 'lazy',
                                ]);
                              }
                            ?>
                          </figure>
                        <?php endif; ?>
                        <?php if ($title !== ''): ?>
                          <div class="absolute top-0 left-0 right-0 p-4">
                            <span class="inline-block bg-white/50 text-black text-base font-semibold px-3 py-2">
                              <?php echo esc_html($title); ?>
                            </span>
                          </div>
                        <?php endif; ?>
                      </div>
                    </div>
                  </article>
                <?php endforeach; ?>
              </div>
            </div>
            <div class="swiper-pagination js-support-left-pagination !static !mt-4"></div>
          
          </div>
        <?php endif; ?>
      </div>

      <div class="md:col-span-3">
        <?php if (is_array($documents) && !empty($documents)) : ?>
          <div class="swiper js-support-right">
            <div class="swiper-wrapper">
              <?php foreach ($documents as $d): ?>
                <?php
                  $cover_id = isset($d['cover_image']) ? (int) $d['cover_image'] : 0;
                  $title    = isset($d['title']) ? $d['title'] : '';
                  $pdf      = isset($d['pdf_link']) ? $d['pdf_link'] : '';
                ?>
                <article class="swiper-slide">
                  <div class="overflow-hidden">
                    <a href="<?php echo esc_url($pdf); ?>" target="_blank" rel="noopener" class="block group">
                      <figure class="relative w-full h-80 sm:h-96 md:h-[380px] flex items-center justify-center overflow-hidden">
                        <?php
                          if ($cover_id) {
                            echo wp_get_attachment_image($cover_id, 'large', false, [
                              'class' => 'w-full h-full transform transition duration-300 ease-out group-hover:scale-[1.02]',
                              'loading' => 'lazy',
                            ]);
                          }
                        ?>
                      </figure>
                      <div class="py-4">
                        <?php if ($title !== ''): ?>
                          <h3 class="text-sm sm:text-base font-semibold text-gray-900">
                            <?php echo esc_html($title); ?>
                          </h3>
                        <?php endif; ?>
                      </div>
                    </a>
                  </div>
                </article>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="swiper-pagination js-support-right-pagination !static !mt-4"></div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/80 js-video-modal">
    <div class="w-full max-w-4xl px-6 relative">
      <button type="button" class="absolute -top-5 -right-4 p-2 rounded-full bg-white/50 hover:bg-white/100 text-black shadow js-modal-close" aria-label="Close">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18.3 5.71 12 12.01 5.7 5.7 4.29 7.11 10.59 13.41 4.29 19.71 5.7 21.12 12 14.82 18.3 21.12 19.71 19.71 13.41 13.41 19.71 7.11z"/></svg>
      </button>
      <video class="w-full h-auto rounded-lg js-modal-video" controls preload="auto"></video>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var section = document.getElementById('<?php echo esc_js($section_id); ?>');
      if (!section || typeof Swiper === 'undefined') return;

      var leftSwiper = new Swiper(section.querySelector('.js-support-left'), {
        slidesPerView: 1,
        spaceBetween: 16,
        loop: true,
        speed: 600,
        pagination: {
          el: section.querySelector('.js-support-left-pagination'),
          clickable: true
        },
        navigation: {}
      });

      var rightSwiper = new Swiper(section.querySelector('.js-support-right'), {
        slidesPerView: 1,
        spaceBetween: 16,
        loop: false,
        speed: 600,
        breakpoints: {
          768: { slidesPerView: 2, spaceBetween: 10 },
          1024:{ slidesPerView: 2, spaceBetween: 20 }
        },
        pagination: {
          el: section.querySelector('.js-support-right-pagination'),
          clickable: true
        }
      });

      var modal = section.querySelector('.js-video-modal');
      var modalVideo = section.querySelector('.js-modal-video');
      var closeBtn = section.querySelector('.js-modal-close');

      function openModal(src) {
        if (!src) return;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modalVideo.src = src;
        modalVideo.play();
      }
      function closeModal() {
        modalVideo.pause();
        modalVideo.removeAttribute('src');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
      }
      closeBtn.addEventListener('click', function(e){ e.preventDefault(); closeModal(); });
      modal.addEventListener('click', function(e){ if (e.target === modal) closeModal(); });
      document.addEventListener('keydown', function(e){ if (e.key === 'Escape') closeModal(); });

      section.querySelectorAll('.js-play').forEach(function(btn){
        btn.addEventListener('click', function(e){
          e.preventDefault();
          var video = btn.parentElement.querySelector('video');
          if (video) openModal(video.currentSrc || video.src);
        });
      });
      section.querySelectorAll('video').forEach(function(vid){
        vid.addEventListener('click', function(){
          var src = vid.currentSrc || vid.src;
          if (src) openModal(src);
        });
      });
    });
  </script>
</section>
