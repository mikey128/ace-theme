<?php

function ace_get_editorial_label($post_id = null) {
  $post_id = $post_id ? (int) $post_id : (int) get_the_ID();
  if (!$post_id) {
    return '';
  }

  $terms = get_the_terms($post_id, 'category');
  if (is_array($terms) && !empty($terms)) {
    $term = $terms[0];
    if (is_object($term) && !empty($term->name)) {
      return (string) $term->name;
    }
  }

  $post_type = get_post_type($post_id);
  if (!$post_type) {
    return '';
  }

  $obj = get_post_type_object($post_type);
  if ($obj && isset($obj->labels) && isset($obj->labels->name)) {
    return (string) $obj->labels->name;
  }

  return (string) $post_type;
}

function ace_get_article_mid_media($post_id = null) {
  $post_id = $post_id ? (int) $post_id : (int) get_the_ID();
  if (!$post_id || !function_exists('carbon_get_post_meta')) {
    return null;
  }

  $rows = carbon_get_post_meta($post_id, 'article_mid_media');
  if (!is_array($rows) || empty($rows)) {
    return null;
  }

  $row = $rows[0];
  if (!is_array($row)) {
    return null;
  }

  $is_full = (bool) carbon_get_post_meta($post_id, 'enable_full_width_media');

  $image_id = isset($row['image']) ? (int) $row['image'] : 0;
  if ($image_id) {
    return [
      'type' => 'image',
      'full' => $is_full,
      'image_id' => $image_id,
    ];
  }

  $embed = isset($row['embed']) ? trim((string) $row['embed']) : '';
  if ($embed !== '') {
    return [
      'type' => 'embed',
      'full' => $is_full,
      'embed' => $embed,
    ];
  }

  return null;
}

function ace_get_related_articles($post_id, $limit = 3) {
  $post_id = (int) $post_id;
  $limit = (int) $limit;
  if (!$post_id || $limit < 1) {
    return [];
  }

  $post_type = get_post_type($post_id) ?: 'post';

  return get_posts([
    'post_type' => $post_type,
    'post_status' => 'publish',
    'posts_per_page' => $limit,
    'orderby' => 'date',
    'order' => 'DESC',
    'post__not_in' => [$post_id],
    'ignore_sticky_posts' => true,
    'no_found_rows' => true,
    'suppress_filters' => true,
  ]);
}

