<?php
function ace_handle_email_capture_submit() {
  $referer = wp_get_referer();
  $redirect = $referer ? $referer : home_url('/');
  if (!isset($_POST['ace_email_nonce']) || !wp_verify_nonce($_POST['ace_email_nonce'], 'ace_email_capture')) {
    wp_safe_redirect(add_query_arg('email_capture', 'error', $redirect));
    exit;
  }
  $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
  $source = isset($_POST['source_post_id']) ? absint($_POST['source_post_id']) : 0;
  if ($email === '') {
    wp_safe_redirect(add_query_arg('email_capture', 'invalid', $redirect));
    exit;
  }
  $post_id = wp_insert_post([
    'post_type' => 'email_lead',
    'post_status' => 'publish',
    'post_title' => $email,
  ], true);
  if (is_wp_error($post_id)) {
    wp_safe_redirect(add_query_arg('email_capture', 'error', $redirect));
    exit;
  }
  if ($source) {
    update_post_meta($post_id, 'source_post_id', $source);
  }
  update_post_meta($post_id, 'referrer_url', $referer ?: '');
  wp_safe_redirect(add_query_arg('email_capture', 'success', $redirect));
  exit;
}
add_action('admin_post_nopriv_ace_email_capture', 'ace_handle_email_capture_submit');
add_action('admin_post_ace_email_capture', 'ace_handle_email_capture_submit');

