<?php
/**
 * Bootstrap Carbon Fields
 * 
 * Carbon Fields is installed via Composer in the theme.
 * This ensures we have full control over the version and dependencies.
 */

// Load Composer autoloader
$autoload_path = get_template_directory() . '/vendor/autoload.php';

if (file_exists($autoload_path)) {
  require_once $autoload_path;
}

use Carbon_Fields\Carbon_Fields;

add_action('after_setup_theme', function () {
  // Check if Carbon Fields class is available
  if (!class_exists(Carbon_Fields::class)) {
    // Show admin notice if Carbon Fields is missing
    add_action('admin_notices', function () {
      echo '<div class="notice notice-error"><p>';
      echo '<strong>ACE Theme:</strong> Carbon Fields is not installed. ';
      echo 'Please run <code>composer install</code> in the theme directory.';
      echo '</p></div>';
    });
    return;
  }
  
  // Boot Carbon Fields
  Carbon_Fields::boot();
  
  // Enable Gutenberg support
  if (function_exists('add_theme_support')) {
    add_theme_support('align-wide');
  }
}, 1); // Priority 1 to boot early


