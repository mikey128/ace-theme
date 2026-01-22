<?php
if (! function_exists('carbon_get_the_post_meta')) { return; }
$items = carbon_get_the_post_meta('page_video_modules');
if (!is_array($items) || empty($items)) { return; }
foreach ($items as $index => $item) {
  $hide = !empty($item['hide_section']);
  if ($hide) { continue; }
  $sid_input = isset($item['section_id']) ? trim((string)$item['section_id']) : '';
  $section_id = $sid_input !== '' ? sanitize_title($sid_input) : 'page-video-' . get_the_ID() . '-' . ($index + 1);
  $cover_val = isset($item['cover_image']) ? $item['cover_image'] : '';
  $video_val = isset($item['video_file']) ? $item['video_file'] : '';
  $cover_url = is_numeric($cover_val) ? wp_get_attachment_url((int)$cover_val) : (string)$cover_val;
  $video_url = is_numeric($video_val) ? wp_get_attachment_url((int)$video_val) : (string)$video_val;
  if ($cover_url === '' || $video_url === '') { continue; }
  $args = [
    'video_title' => isset($item['video_title']) ? (string)$item['video_title'] : '',
    'cover_url' => $cover_url,
    'video_url' => $video_url,
    'hide_section' => false,
    'enable_full_width' => !empty($item['enable_full_width']),
    'section_id' => $section_id,
  ];
  get_template_part('template-parts/page/custom-video', null, $args);
}
