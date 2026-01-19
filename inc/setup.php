<?php
if (!defined('ACE_LOGO_WIDTH')) {
  define('ACE_LOGO_WIDTH', 160);
}
if (!defined('ACE_LOGO_HEIGHT')) {
  define('ACE_LOGO_HEIGHT', 48);
}

function ace_setup() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('custom-logo', [
    'height' => ACE_LOGO_HEIGHT,
    'width' => ACE_LOGO_WIDTH,
    'flex-height' => true,
    'flex-width' => true,
  ]);
  register_nav_menus([
    'primary' => 'Primary Menu',
    'footer-products' => 'Footer Products',
  ]);
}
add_action('after_setup_theme', 'ace_setup');

