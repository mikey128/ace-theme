<?php
function ace_handle_contact_form_submit() {
  $referer = wp_get_referer();
  $redirect = $referer ? $referer : home_url('/');

  if (!isset($_POST['ace_contact_nonce']) || !wp_verify_nonce($_POST['ace_contact_nonce'], 'ace_contact_submit')) {
    wp_safe_redirect(add_query_arg('contact', 'error', $redirect));
    exit;
  }

  $name    = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
  $tel     = isset($_POST['tel']) ? sanitize_text_field($_POST['tel']) : '';
  $email   = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
  $message = isset($_POST['message']) ? wp_kses_post($_POST['message']) : '';
  $source  = isset($_POST['source_post_id']) ? absint($_POST['source_post_id']) : 0;

  if ($name === '' || ($email === '' && $tel === '')) {
    wp_safe_redirect(add_query_arg('contact', 'invalid', $redirect));
    exit;
  }

  $title = $name;
  if ($email) {
    $title .= ' - ' . $email;
  } elseif ($tel) {
    $title .= ' - ' . $tel;
  }

  $post_id = wp_insert_post([
    'post_type'    => 'contact_message',
    'post_status'  => 'publish',
    'post_title'   => $title,
    'post_content' => $message,
  ], true);

  if (is_wp_error($post_id)) {
    wp_safe_redirect(add_query_arg('contact', 'error', $redirect));
    exit;
  }

  if ($email) {
    update_post_meta($post_id, 'contact_email', $email);
  }
  if ($tel) {
    update_post_meta($post_id, 'contact_tel', $tel);
  }
  update_post_meta($post_id, 'contact_name', $name);
  if ($source) {
    update_post_meta($post_id, 'source_post_id', $source);
  }
  update_post_meta($post_id, 'referrer_url', $referer ?: '');

  wp_safe_redirect(add_query_arg('contact', 'success', $redirect));
  exit;
}

add_action('admin_post_nopriv_ace_contact_submit', 'ace_handle_contact_form_submit');
add_action('admin_post_ace_contact_submit', 'ace_handle_contact_form_submit');

