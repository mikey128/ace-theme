<?php

function ace_user_get_page_url($path) {
  $page = get_page_by_path($path);
  return $page ? get_permalink($page->ID) : home_url("/{$path}/");
}

function ace_user_redirect_url($type, $fallback = '') {
  $url = '';
  if (function_exists('carbon_get_theme_option')) {
    if ($type === 'login') {
      $url = carbon_get_theme_option('redirect_login_success');
    } elseif ($type === 'register') {
      $url = carbon_get_theme_option('redirect_register_success');
    } elseif ($type === 'logout') {
      $url = carbon_get_theme_option('redirect_logout');
    }
  }
  if (empty($url)) {
    if ($type === 'login' || $type === 'register') {
      $url = ace_user_get_page_url('account');
    } elseif ($type === 'logout') {
      $url = home_url('/');
    } else {
      $url = $fallback ?: home_url('/');
    }
  }
  return $url;
}

add_action('template_redirect', function () {
  if (is_admin()) return;
  $is_login    = is_page('login');
  $is_register = is_page('register');
  $is_account  = is_page('account');

  if ($is_account && !is_user_logged_in()) {
    $to = ace_user_get_page_url('login');
    $current = wp_unslash($_SERVER['REQUEST_URI'] ?? '');
    $redir = wp_validate_redirect($current, ace_user_get_page_url('account'));
    wp_safe_redirect(add_query_arg('redirect_to', rawurlencode($redir), $to));
    exit;
  }

  if (( $is_login || $is_register ) && is_user_logged_in()) {
    wp_safe_redirect(ace_user_get_page_url('account'));
    exit;
  }
});

add_action('admin_init', function () {
  if (is_user_logged_in() && is_admin() && !current_user_can('manage_options') && !wp_doing_ajax()) {
    global $pagenow;
    $action = isset($_REQUEST['action']) ? sanitize_key($_REQUEST['action']) : '';
    if ($pagenow === 'admin-post.php' && in_array($action, ['ace_logout','ace_login','ace_register','ace_email_capture','ace_contact_submit'], true)) {
      return;
    }
    wp_safe_redirect(home_url('/'));
    exit;
  }
});

function ace_login_enabled() {
  return true;
}

function ace_register_enabled() {
  $enabled_cf = function_exists('carbon_get_theme_option') ? (bool) carbon_get_theme_option('enable_frontend_registration') : true;
  $enabled_wp = (bool) get_option('users_can_register');
  return $enabled_cf && $enabled_wp;
}

function ace_handle_login() {
  if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'ace_login')) {
    wp_safe_redirect(add_query_arg('error', 'invalid_nonce', ace_user_get_page_url('login')));
    exit;
  }
  $username = isset($_POST['username']) ? sanitize_text_field($_POST['username']) : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';
  $remember = !empty($_POST['remember']);
  $redirect_to = isset($_POST['redirect_to']) ? $_POST['redirect_to'] : '';

  if ($username === '' || $password === '') {
    wp_safe_redirect(add_query_arg('error', 'missing_fields', ace_user_get_page_url('login')));
    exit;
  }
  if (is_email($username)) {
    $u = get_user_by('email', $username);
    if ($u) $username = $u->user_login;
  }
  $creds = [
    'user_login'    => $username,
    'user_password' => $password,
    'remember'      => $remember,
  ];
  $user = wp_signon($creds);
  if (is_wp_error($user)) {
    wp_safe_redirect(add_query_arg('error', 'auth_failed', ace_user_get_page_url('login')));
    exit;
  }
  $target = '';
  if (!empty($redirect_to)) {
    $target = wp_validate_redirect($redirect_to, '');
  }
  if (empty($target)) {
    $target = ace_user_redirect_url('login', '');
  }
  if (empty($target)) {
    $target = home_url('/');
  }
  wp_safe_redirect($target);
  exit;
}

function ace_handle_register() {
  if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'ace_register')) {
    wp_safe_redirect(add_query_arg('error', 'invalid_nonce', ace_user_get_page_url('register')));
    exit;
  }
  if (!ace_register_enabled()) {
    $reason = [];
    $enabled_cf = function_exists('carbon_get_theme_option') ? (bool) carbon_get_theme_option('enable_frontend_registration') : true;
    $enabled_wp = (bool) get_option('users_can_register');
    if (!$enabled_cf) $reason[] = 'cf';
    if (!$enabled_wp) $reason[] = 'wp';
    $qs = ['error' => 'disabled'];
    if (!empty($reason)) { $qs['reason'] = implode('_', $reason); }
    wp_safe_redirect(add_query_arg($qs, ace_user_get_page_url('register')));
    exit;
  }
  $username = isset($_POST['username']) ? sanitize_user($_POST['username']) : '';
  $email    = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';
  $company  = isset($_POST['company']) ? sanitize_text_field($_POST['company']) : '';
  $tel      = isset($_POST['telephone']) ? sanitize_text_field($_POST['telephone']) : '';
  $address  = isset($_POST['address']) ? sanitize_textarea_field($_POST['address']) : '';

  $errors = [];
  if ($username === '' || !validate_username($username)) $errors['username'] = 'invalid';
  if (username_exists($username)) $errors['username'] = 'exists';
  if ($email === '' || !is_email($email)) $errors['email'] = 'invalid';
  if (email_exists($email)) $errors['email'] = 'exists';
  if (empty($password) || strlen($password) < 8) $errors['password'] = 'weak';

  if (!empty($errors)) {
    $qs = [
      'prefill_username' => $username,
      'prefill_email'    => $email,
    ];
    foreach ($errors as $k => $v) { $qs["error_{$k}"] = $v; }
    wp_safe_redirect(add_query_arg($qs, ace_user_get_page_url('register')));
    exit;
  }

  $user_id = wp_insert_user([
    'user_login' => $username,
    'user_email' => $email,
    'user_pass'  => $password,
    'role'       => 'subscriber',
  ]);
  if (is_wp_error($user_id)) {
    wp_safe_redirect(add_query_arg('error', 'create_failed', ace_user_get_page_url('register')));
    exit;
  }
  if ($company !== '') update_user_meta($user_id, 'company', $company);
  if ($tel !== '') update_user_meta($user_id, 'telephone', $tel);
  if ($address !== '') update_user_meta($user_id, 'address', $address);

  wp_set_current_user($user_id);
  wp_set_auth_cookie($user_id, true);

  $target = ace_user_redirect_url('register', ace_user_get_page_url('account'));
  wp_safe_redirect($target);
  exit;
}

function ace_handle_logout() {
  if (!isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'ace_logout')) {
    wp_safe_redirect(home_url('/'));
    exit;
  }
  wp_logout();
  $target = ace_user_redirect_url('logout', home_url('/'));
  wp_safe_redirect($target);
  exit;
}

add_action('admin_post_nopriv_ace_login', 'ace_handle_login');
add_action('admin_post_ace_login', 'ace_handle_login');
add_action('admin_post_nopriv_ace_register', 'ace_handle_register');
add_action('admin_post_nopriv_ace_logout', 'ace_handle_logout');
add_action('admin_post_ace_logout', 'ace_handle_logout');
