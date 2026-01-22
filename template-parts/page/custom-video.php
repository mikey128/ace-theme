<?php
$video_title = isset($args['video_title']) ? $args['video_title'] : '';
$cover_url = isset($args['cover_url']) ? $args['cover_url'] : '';
$video_url = isset($args['video_url']) ? $args['video_url'] : '';
$hide = !empty($args['hide_section']);
if ($hide) { return; }
if ($video_url === '' || $cover_url === '') { return; }
$sid_input = isset($args['section_id']) ? trim((string)$args['section_id']) : '';
$section_id = $sid_input !== '' ? sanitize_title($sid_input) : 'page-video-' . get_the_ID();
$full = !empty($args['enable_full_width']);
$wrap = $full ? 'w-full px-6' : 'max-w-7xl mx-auto px-6 max-w-global';
?>
<section id="<?php echo esc_attr($section_id); ?>" class="py-10 sm:py-12 md:py-14 bg-white">
  <div class="<?php echo esc_attr($wrap); ?>">
    <div class="ace-video-module relative w-full rounded-2xl overflow-hidden group aspect-video shadow-md bg-black">
      <video 
        class="w-full h-full object-cover" 
        src="<?php echo esc_url($video_url); ?>" 
        poster="<?php echo esc_url($cover_url); ?>"
        playsinline>
      </video>
      <div class="js-video-overlay absolute inset-0 bg-black/20 group-hover:bg-black/30 transition-colors duration-300 flex flex-col items-center justify-center cursor-pointer z-10">
        <?php if ($video_title): ?>
          <h3 class="text-white text-xl md:text-2xl font-bold mb-4 drop-shadow-md text-center px-4">
            <?php echo esc_html($video_title); ?>
          </h3>
        <?php endif; ?>
        <div class="w-16 h-16 md:w-20 md:h-20 lg:w-28 lg:h-28 bg-brand-accent rounded-full flex items-center justify-center shadow-lg transform transition-transform duration-300 group-hover:scale-110 pointer-events-none">
          <svg class="w-6 h-6 md:w-8 md:h-8 lg:w-16 lg:h-16 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
            <path d="M8 5v14l11-7z" />
          </svg>
        </div>
      </div>
    </div>
  </div>
</section>
