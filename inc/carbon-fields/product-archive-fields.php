<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function () {
  Container::make('theme_options', 'Product Archive')
    ->set_page_parent('options-general.php')
    ->add_fields([
      Field::make('image', 'product_archive_hero_image', 'Hero: Background Image')->set_value_type('id'),
      Field::make('checkbox', 'product_archive_hero_enable_full_width', 'Hero: Full Width Section'),
      Field::make('checkbox', 'product_archive_hero_hide_section', 'Hero: Hide Section'),

      Field::make('text', 'product_archive_heading', 'Heading')->set_default_value('Our Featured Product Line'),
      Field::make('textarea', 'product_archive_description', 'Description'),
      Field::make('checkbox', 'product_archive_intro_enable_full_width', 'Intro: Full Width Section'),
      Field::make('checkbox', 'product_archive_intro_hide_section', 'Intro: Hide Section'),

      Field::make('checkbox', 'product_archive_main_enable_full_width', 'Main: Full Width Section'),
      Field::make('checkbox', 'product_archive_main_hide_section', 'Main: Hide Section'),
    ]);
});

