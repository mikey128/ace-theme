<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function () {
  $front_page_id = get_option('page_on_front');
  $container = Container::make('post_meta', 'Page Media Carousel');
  if ($front_page_id) {
    $container->where('post_id', '=', $front_page_id);
  } else {
    $container->where('post_type', '=', 'page');
  }
  $container->add_fields([
      Field::make('text', 'media_carousel_section_id', 'Section ID')
        ->set_help_text('Used for on-page navigation, without #'),
      Field::make('text', 'media_carousel_title', 'Carousel Title'),
      Field::make('textarea', 'media_carousel_description', 'Carousel Description'),
      Field::make('checkbox', 'media_carousel_full_width', 'Full Width Section'),
      Field::make('checkbox', 'media_carousel_hide_section', 'Hide Media Carousel'),
      Field::make('complex', 'media_carousel_items', 'Carousel Items')
        ->set_layout('tabbed-horizontal')
        ->set_max(15)
        ->add_fields([
          Field::make('image', 'carousel_image', 'Image')->set_value_type('id'),
          Field::make('text', 'carousel_date', 'Date'),
          Field::make('text', 'carousel_title', 'Title'),
          Field::make('textarea', 'carousel_description', 'Description'),
          Field::make('text', 'carousel_link', 'Link')->set_attribute('type', 'url'),
          Field::make('checkbox', 'carousel_highlight', 'Highlight'),
        ]),
    ]);
});
