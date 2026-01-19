<?php
/**
 * Product Info Template Part
 * 
 * Displays the product model, title, tagline, and CTA.
 */

$model_number = carbon_get_the_post_meta('product_model');
$tagline = carbon_get_the_post_meta('tagline');
?>

<div class="flex flex-col justify-center">
  <p class="text-sm text-gray-500 mb-2">
    Model: <?php echo esc_html($model_number); ?>
  </p>

  <h1 class="text-3xl font-semibold mb-4">
    <?php the_title(); ?>
  </h1>

  <?php if ($tagline): ?>
    <p class="text-lg text-gray-600 mb-6">
      <?php echo esc_html($tagline); ?>
    </p>
  <?php endif; ?>

  <!-- CTA -->
  <a href="#download"
     class="inline-block w-fit px-6 py-3 rounded-lg bg-black text-white text-sm hover:bg-gray-800 transition">
    Download Datasheet
  </a>
</div>