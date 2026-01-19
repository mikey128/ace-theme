<?php
/**
 * Template Name: Test Tailwind CSS
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  
  <!-- Debug: Check if CSS is loaded -->
  <div style="background: yellow; padding: 20px; margin: 20px;">
    <h1>🔍 Tailwind CSS Debug Test</h1>
    <p><strong>Inline style (should have yellow background)</strong></p>
  </div>

  <!-- Test Tailwind Classes -->
  <div class="bg-brand-accent text-white p-8 m-4">
    <h2 class="text-3xl font-bold mb-4">If you see a BLUE background and WHITE text, Tailwind is working!</h2>
    <p class="text-lg">This box should be blue with white text and padding.</p>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-12 bg-gray-100">
    <h3 class="text-2xl font-semibold mb-6">Tailwind Utility Classes Test</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-red-500 text-white p-6 rounded-lg">Red Box</div>
      <div class="bg-green-500 text-white p-6 rounded-lg">Green Box</div>
      <div class="bg-purple-500 text-white p-6 rounded-lg">Purple Box</div>
    </div>
  </div>

  <!-- Debug Info -->
  <div class="max-w-7xl mx-auto px-4 py-8">
    <h4 class="text-xl font-bold mb-4">Debug Information:</h4>
    <div class="bg-white p-4 border border-gray-300 rounded">
      <p><strong>Theme Directory:</strong> <?php echo get_template_directory_uri(); ?></p>
      <p><strong>CSS File URL:</strong> <?php echo get_template_directory_uri(); ?>/assets/css/style.css</p>
      <p><strong>CSS File Exists:</strong> <?php echo file_exists(get_template_directory() . '/assets/css/style.css') ? '✅ YES' : '❌ NO'; ?></p>
      <p><strong>CSS File Size:</strong> <?php 
        $css_file = get_template_directory() . '/assets/css/style.css';
        echo file_exists($css_file) ? round(filesize($css_file) / 1024, 2) . ' KB' : 'N/A';
      ?></p>
      <p><strong>wp_head() called:</strong> ✅ YES (you can see this page)</p>
    </div>
  </div>

  <?php wp_footer(); ?>
</body>
</html>

