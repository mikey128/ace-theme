<?php
/**
 * Custom Video Module Template Part
 * 
 * Displays a video module with a custom cover image and play button overlay.
 * Data is retrieved from Carbon Fields post meta.
 */

$video_title = carbon_get_the_post_meta('video_title');
$cover_val  = carbon_get_the_post_meta('cover_image');
$video_val  = carbon_get_the_post_meta('video_file');
$hide = carbon_get_the_post_meta('video_hide_section');
$full = carbon_get_the_post_meta('video_full_width');
$section_id = trim((string) carbon_get_the_post_meta('video_section_id'));

$cover_url = is_numeric($cover_val) ? wp_get_attachment_url((int)$cover_val) : $cover_val;
$video_url = is_numeric($video_val) ? wp_get_attachment_url((int)$video_val) : $video_val;

if ($hide) { return; }

// If no video or cover is set, return early (don't output anything)
if (empty($video_url) || empty($cover_url)) {
    return;
}

$section_id = $section_id !== '' ? sanitize_title($section_id) : 'product-video-' . get_the_ID();
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
