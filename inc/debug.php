<?php
/**
 * Debug helper - Add to footer to check if styles are enqueued
 */
function ace_debug_enqueued_styles() {
  if (!current_user_can('administrator') || !isset($_GET['debug'])) {
    return;
  }
  
  global $wp_styles;
  echo '<div style="position: fixed; bottom: 0; left: 0; right: 0; background: #000; color: #0f0; padding: 20px; font-family: monospace; font-size: 12px; z-index: 99999; max-height: 300px; overflow: auto;">';
  echo '<h3 style="color: #0f0; margin: 0 0 10px;">🔍 Enqueued Styles Debug (admin only, add ?debug to URL)</h3>';
  echo '<p style="margin: 5px 0;"><strong>Total Styles:</strong> ' . count($wp_styles->registered) . '</p>';
  
  echo '<h4 style="color: #ff0; margin: 10px 0 5px;">Looking for ace-style:</h4>';
  if (isset($wp_styles->registered['ace-style'])) {
    $style = $wp_styles->registered['ace-style'];
    echo '<p style="color: #0f0;">✅ ace-style IS registered</p>';
    echo '<p><strong>SRC:</strong> ' . esc_html($style->src) . '</p>';
    echo '<p><strong>Version:</strong> ' . esc_html($style->ver) . '</p>';
    echo '<p><strong>In queue:</strong> ' . (in_array('ace-style', $wp_styles->queue) ? 'YES ✅' : 'NO ❌') . '</p>';
  } else {
    echo '<p style="color: #f00;">❌ ace-style NOT registered!</p>';
  }
  
  echo '<h4 style="color: #ff0; margin: 10px 0 5px;">All Registered Styles:</h4>';
  echo '<ul style="margin: 0; padding-left: 20px;">';
  foreach ($wp_styles->registered as $handle => $style) {
    echo '<li>' . esc_html($handle) . ': ' . esc_html($style->src) . '</li>';
  }
  echo '</ul>';
  echo '</div>';
}
add_action('wp_footer', 'ace_debug_enqueued_styles', 9999);

