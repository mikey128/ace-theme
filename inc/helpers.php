<?php
function ace_image_url($id, $size = 'large') {
  return $id ? wp_get_attachment_image_url($id, $size) : '';
}

if (!function_exists('carbon_get_the_post_meta')) {
  function carbon_get_the_post_meta($name, $type = null, $default = null) {
    if (function_exists('carbon_get_post_meta')) {
      return carbon_get_post_meta(get_the_ID(), $name, $type, $default);
    }
    return $default;
  }
}

function ace_hide_product_featured_image_html($html, $post_id, $post_thumbnail_id, $size, $attr) {
  if (get_post_type($post_id) === 'product') {
    return '';
  }
  return $html;
}
add_filter('post_thumbnail_html', 'ace_hide_product_featured_image_html', 10, 5);

