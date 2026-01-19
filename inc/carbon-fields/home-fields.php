<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;
//slideshow
add_action('carbon_fields_register_fields', function () {
  $front_page_id = get_option('page_on_front');
  $slideshow = Container::make('post_meta', 'Homepage Slideshow');
  if ($front_page_id) {
    $slideshow->where('post_id', '=', $front_page_id);
  } else {
    $slideshow->where('post_type', '=', 'page');
  }
  $slideshow->add_fields([
    Field::make('checkbox', 'home_slideshow_full_width', 'Full Width'),
    Field::make('checkbox', 'home_slideshow_hide', 'Hide Section'),
    Field::make('complex', 'home_slideshow_slides', 'Slides')
      ->set_layout('tabbed-horizontal')
      ->set_max(10)
      ->add_fields([
        Field::make('text', 'title', 'Slide Title'),
        Field::make('textarea', 'description', 'Slide Description'),
        Field::make('image', 'background_image', 'Background Image')->set_value_type('id'),
        Field::make('file', 'background_video', 'Background Video')->set_type(['video']),
        Field::make('color', 'overlay_color', 'Overlay Color')->set_default_value('#000000'),
        Field::make('text', 'overlay_opacity', 'Overlay Opacity')->set_attribute('type', 'range')->set_attribute('min', 0)->set_attribute('max', 100)->set_default_value(40),
        Field::make('text', 'button1_text', 'Button 1 Text')->set_default_value('View case'),
        Field::make('text', 'button1_link', 'Button 1 Link')->set_attribute('type', 'url'),
        Field::make('text', 'button2_text', 'Button 2 Text')->set_default_value('Ask For Samples Or Customized Solutions'),
        Field::make('text', 'button2_link', 'Button 2 Link')->set_attribute('type', 'url'),
      ]),
  ]);
  // featured products
  $featured = Container::make('post_meta', 'Featured Products');
  if ($front_page_id) {
    $featured->where('post_id', '=', $front_page_id);
  } else {
    $featured->where('post_type', '=', 'page');
  }
  $featured->add_fields([
    Field::make('checkbox', 'home_featured_products_full_width', 'Full Width'),
    Field::make('checkbox', 'home_featured_products_hide', 'Hide Section'),
    Field::make('text', 'home_featured_products_heading', 'Heading'),
    Field::make('rich_text', 'home_featured_products_subheading', 'Subheading')->set_rows(6),
    Field::make('association', 'home_featured_products_selected', 'Select Products')
      ->set_max(8)
      ->set_types([
        [
          'type' => 'post',
          'post_type' => 'product',
        ],
      ]),
    Field::make('select', 'home_featured_products_columns', 'Desktop Columns')
      ->set_options([
        '2' => '2',
        '3' => '3',
        '4' => '4',
      ])->set_default_value('3'),
    Field::make('text', 'home_featured_message_title', 'Message Box Title'),
    Field::make('rich_text', 'home_featured_message_description', 'Message Box Description')->set_rows(6),
    Field::make('text', 'home_featured_message_button_text', 'Message Button Text')->set_default_value('Ask For Samples Or Customized Solutions'),
    Field::make('text', 'home_featured_message_button_link', 'Message Button Link')->set_attribute('type', 'url'),
  ]);
});
