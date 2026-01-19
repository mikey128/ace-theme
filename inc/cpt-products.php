<?php
function ace_register_product_cpt() {
  if (post_type_exists('product')) return;
  register_post_type('product', [
    'label' => 'Products',
    'public' => true,
    'has_archive' => true,
    'supports' => ['title','editor','thumbnail','page-attributes'],
    'show_in_rest' => false,
  ]);
}
add_action('init', 'ace_register_product_cpt');


