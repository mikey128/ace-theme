<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function () {
  Container::make('theme_options', 'News Archive')
    ->set_page_parent('options-general.php')
    ->add_fields([
       Field::make('text', 'news_archive_description', 'Archive Description'),
      Field::make('image', 'news_archive_hero_image', 'Hero: Background Image')->set_value_type('id'),
      Field::make('checkbox', 'news_archive_hero_enable_full_width', 'Hero: Full Width Section'),
      Field::make('checkbox', 'news_archive_hero_hide_section', 'Hero: Hide Section'),     

      Field::make('checkbox', 'news_archive_filter_enable_full_width', 'Filter: Full Width Section'),
      Field::make('checkbox', 'news_archive_filter_hide_section', 'Filter: Hide Section'),

      Field::make('checkbox', 'news_archive_featured_enable_full_width', 'Featured: Full Width Section'),
      Field::make('checkbox', 'news_archive_featured_hide_section', 'Featured: Hide Section'),

      Field::make('checkbox', 'news_archive_grid_enable_full_width', 'Grid: Full Width Section'),
      Field::make('checkbox', 'news_archive_grid_hide_section', 'Grid: Hide Section'),
    ]);

  Container::make('term_meta', 'Category Settings')
    ->where('term_taxonomy', '=', 'category')
    ->add_fields([
      Field::make('image', 'category_hero_image', 'Hero Background Image')->set_value_type('id'),
    ]);

  Container::make('post_meta', 'News Settings')
    ->where('post_type', '=', 'news')
    ->add_fields([
      Field::make('checkbox', 'is_featured', 'Featured on News Archive'),
    ]);

  Container::make('post_meta', 'Post News Settings')
    ->where('post_type', '=', 'post')
    ->add_fields([
      Field::make('checkbox', 'is_featured', 'Featured on News Archive'),
    ]);
});
