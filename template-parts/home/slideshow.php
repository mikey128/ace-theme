<?php
$hide_section = carbon_get_the_post_meta('home_slideshow_hide');
if ($hide_section) {
  return;
}
$slides = carbon_get_the_post_meta('home_slideshow_slides');
if (!is_array($slides) || empty($slides)) {
  return;
}
$full_width = carbon_get_the_post_meta('home_slideshow_full_width');
$wrapper_classes = $full_width ? 'w-full px-6' : 'max-w-7xl mx-auto px-6 max-w-global';
$id = 'home-slideshow-' . uniqid();
function ace_hex_to_rgb($hex) {
  $hex = str_replace('#', '', $hex);
  if (strlen($hex) === 3) {
    $r = hexdec(str_repeat(substr($hex, 0, 1), 2));
    $g = hexdec(str_repeat(substr($hex, 1, 1), 2));
    $b = hexdec(str_repeat(substr($hex, 2, 1), 2));
  } else {
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
  }
  return [$r, $g, $b];
}
?>
<section class="relative w-full bg-black">
  <div class="swiper <?php echo esc_attr($id); ?>">
    <div class="swiper-wrapper">
      <?php foreach ($slides as $slide): ?>
        <?php
          $title = isset($slide['title']) ? $slide['title'] : '';
          $description = isset($slide['description']) ? $slide['description'] : '';
          $img_id = isset($slide['background_image']) ? intval($slide['background_image']) : 0;
          
          $video_val = isset($slide['background_video']) ? $slide['background_video'] : '';
          $video_url = '';
          if ( is_numeric( $video_val ) ) {
              $video_url = wp_get_attachment_url( $video_val );
          } else {
              $video_url = $video_val;
          }

          $overlay_color = isset($slide['overlay_color']) ? $slide['overlay_color'] : '#000000';
          $overlay_opacity = isset($slide['overlay_opacity']) ? intval($slide['overlay_opacity']) : 40;
          $button1_text = isset($slide['button1_text']) ? $slide['button1_text'] : '';
          $button1_link = isset($slide['button1_link']) ? $slide['button1_link'] : '';
          $button2_text = isset($slide['button2_text']) ? $slide['button2_text'] : '';
          $button2_link = isset($slide['button2_link']) ? $slide['button2_link'] : '';
          $img_url = $img_id ? wp_get_attachment_image_url($img_id, 'full') : '';
          $rgb = ace_hex_to_rgb($overlay_color);
          $alpha = max(0, min(1, $overlay_opacity / 100));
          $overlay_style = 'background-color: rgba(' . $rgb[0] . ',' . $rgb[1] . ',' . $rgb[2] . ',' . $alpha . ');';
        ?>
        <div class="swiper-slide relative">
          <div class="relative w-full h-[60vh] min-h-[460px] sm:min-h-[520px] md:min-h-[640px] overflow-hidden">
            <?php if ($video_url): ?>
              <video class="absolute inset-0 w-full h-full object-cover" src="<?php echo esc_url($video_url); ?>" autoplay muted loop playsinline></video>
            <?php elseif ($img_url): ?>
              <img class="absolute inset-0 w-full h-full object-cover" src="<?php echo esc_url($img_url); ?>" alt="">
            <?php endif; ?>
            <div class="absolute inset-0" style="<?php echo esc_attr($overlay_style); ?>"></div>
            <div class="relative z-10 flex items-center justify-center w-full h-full py-12">
              <div class="<?php echo esc_attr($wrapper_classes); ?> h-full flex flex-col items-center justify-center text-center">
                <?php if ($title): ?>
                  <h2 class="text-white text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold "><?php echo esc_html($title); ?></h2>
                <?php endif; ?>
                <?php if ($description): ?>
                  <p class="mt-4 text-white/85 text-sm sm:text-base md:text-lg"><?php echo esc_html($description); ?></p>
                <?php endif; ?>
                <div class="mt-16 flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-5">
                  <?php if ($button1_link && $button1_text): ?>
                    <a href="<?php echo esc_url($button1_link); ?>" class="inline-flex items-center justify-center rounded-full bg-brand-accent px-7 py-3 text-sm sm:text-base font-semibold text-white shadow-sm transition-colors hover:bg-blue-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                      <?php echo esc_html($button1_text); ?>
                    </a>
                  <?php endif; ?>
                  <?php if ($button2_link && $button2_text): ?>
                    <a href="<?php echo esc_url($button2_link); ?>" class="inline-flex items-center justify-center rounded-full border border-white/40 bg-white text-xs sm:text-sm font-semibold text-neutral-900 px-6 py-3 shadow-sm transition-colors hover:bg-neutral-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                      <?php echo esc_html($button2_text); ?>
                    </a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
        <div class="swiper-pagination slideshow-pagination mb-4"></div>
        <!--
        <div class="flex items-center justify-center gap-3 mt-3">
          <button type="button" class="swiper-button-prev inline-flex items-center justify-center rounded-full border border-white/40 bg-white/80 text-neutral-900 px-4 py-2 text-sm font-semibold shadow-sm transition-colors hover:bg-white">Prev</button>
          <button type="button" class="swiper-button-next inline-flex items-center justify-center rounded-full border border-white/40 bg-white/80 text-neutral-900 px-4 py-2 text-sm font-semibold shadow-sm transition-colors hover:bg-white">Next</button>
        </div>
                  -->
  </div>
  <style>
    .swiper-pagination-bullet{
    width:80px; border-radius:0;  height:4px;
  } 
  </style>
  <script>
    document.addEventListener('DOMContentLoaded', function(){
      if (window.Swiper) {
        new Swiper('.<?php echo esc_js($id); ?>', {
          loop: true,
          effect: 'fade',
          autoplay: { delay: 5000 },
          speed: 600,
          pagination: {
          el: document.querySelector('.<?php echo esc_js($id); ?> .slideshow-pagination'),
          clickable: true
        },
        navigation: {
          nextEl: '.<?php echo esc_js($id); ?> .swiper-button-next',
          prevEl: '.<?php echo esc_js($id); ?> .swiper-button-prev'
        }
        });
      }
    });
  </script>
</section>
