<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function () {
  Container::make('theme_options', 'Product Archive')
    ->set_page_parent('options-general.php')
    ->add_fields([
      Field::make('image', 'product_archive_hero_image', 'Hero: Background Image')->set_value_type('id'),
      
      Field::make('text', 'product_archive_heading', 'Heading')->set_default_value('Our Featured Product Line'),
      Field::make('textarea', 'product_archive_description', 'Description'),
       Field::make('separator', 'product_archive_sidebar_separator', 'Sidebar Settings'),
      Field::make('checkbox', 'product_archive_show_featured_category', 'Show Featured Category in Sidebar')
        ->set_help_text('Display a special "Featured Products" link at the top of the category list'),
      Field::make('select', 'product_archive_featured_category', 'Featured Category')
        ->set_help_text('Select which category to feature in the sidebar')
        ->add_options('ace_get_product_categories_for_select')
        ->set_conditional_logic([
          [
            'field' => 'product_archive_show_featured_category',
            'value' => true,
          ]
        ]),
      Field::make('text', 'product_archive_featured_label', 'Featured Category Label')
        ->set_default_value('Featured Products')
        ->set_help_text('Custom label for the featured category link')
        ->set_conditional_logic([
          [
            'field' => 'product_archive_show_featured_category',
            'value' => true,
          ]
        ]),
        Field::make('checkbox', 'product_archive_main_enable_full_width', 'Main: Full Width Section'),
      Field::make('checkbox', 'product_archive_main_hide_section', 'Main: Hide Section'), 
      Field::make('checkbox', 'product_archive_hero_enable_full_width', 'Hero: Full Width Section'),
      Field::make('checkbox', 'product_archive_hero_hide_section', 'Hero: Hide Section'),

      Field::make('checkbox', 'product_archive_intro_enable_full_width', 'Intro: Full Width Section'),
      Field::make('checkbox', 'product_archive_intro_hide_section', 'Intro: Hide Section'), 

  
     
    ]);
});

// Helper function to get product categories for select field
function ace_get_product_categories_for_select() {
  $options = ['' => '-- Select Category --'];
  
  $terms = get_terms([
    'taxonomy' => 'product_category',
    'hide_empty' => false,
    'parent' => 0,
  ]);
  
  if (!is_wp_error($terms) && !empty($terms)) {
    foreach ($terms as $term) {
      $options[$term->term_id] = $term->name;
    }
  }
  
  return $options;
}
