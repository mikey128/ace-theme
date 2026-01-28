<?php
function ace_register_product_cpt() {
  // Always re-register to ensure settings are current
  register_post_type('product', [
    'label' => 'Products',
    'labels' => [
      'name' => 'Products',
      'singular_name' => 'Product',
      'menu_name' => 'Products',
      'all_items' => 'All Products',
      'add_new' => 'Add New',
      'add_new_item' => 'Add New Product',
      'edit_item' => 'Edit Product',
      'view_item' => 'View Product',
      'view_items' => 'View Products',
    ],
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'has_archive' => true,
    'rewrite' => [
      'slug' => 'products',
      'with_front' => false,
      'feeds' => false,
      'pages' => true,
    ],
    'supports' => ['title','editor','thumbnail','excerpt','page-attributes'],
    'show_in_rest' => false,
    'menu_icon' => 'dashicons-products',
  ]);

  
  // Always re-register taxonomy
  register_taxonomy('product_category', ['product'], [
    'label' => 'Product Categories',
    'labels' => [
      'name' => 'Product Categories',
      'singular_name' => 'Product Category',
      'menu_name' => 'Categories',
    ],
    'public' => true,
    'publicly_queryable' => true,
    'hierarchical' => true,
    'show_ui' => true,
    'show_in_nav_menus' => true,
    'show_admin_column' => true,
    'show_in_rest' => false,
    'rewrite' => [
      'slug' => 'product-category',
      'with_front' => false,
      'hierarchical' => true,
    ],
  ]);
  register_taxonomy_for_object_type('product_category', 'product');
}
add_action('init', 'ace_register_product_cpt');


