<?php
function ace_register_product_cpt() {
  if (!post_type_exists('product')) {
    register_post_type('product', [
      'label' => 'Products',
      'public' => true,
      'has_archive' => true,
      'supports' => ['title','editor','thumbnail','excerpt','page-attributes'],
      'show_in_rest' => false,
    ]);
  }

  if (!taxonomy_exists('product_category')) {
    register_taxonomy('product_category', ['product'], [
      'label' => 'Product Categories',
      'public' => true,
      'hierarchical' => true,
      'show_ui' => true,
      'show_in_nav_menus' => true,
      'show_admin_column' => true,
      'show_in_rest' => false,
      'rewrite' => ['slug' => 'product-category'],
    ]);
    register_taxonomy_for_object_type('product_category', 'product');
  }
}
add_action('init', 'ace_register_product_cpt');


