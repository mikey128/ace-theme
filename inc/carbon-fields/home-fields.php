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

  $industry = Container::make('post_meta', 'Industry Application Solutions');
  if ($front_page_id) {
    $industry->where('post_id', '=', $front_page_id);
  } else {
    $industry->where('post_type', '=', 'page');
  }
  $industry->add_fields([
    Field::make('checkbox', 'home_industry_tabs_full_width', 'Full Width Section'),
    Field::make('checkbox', 'home_industry_tabs_hide', 'Hide Section'),
    Field::make('text', 'home_industry_tabs_heading', 'Heading')->set_default_value('Industry Application Solutions'),
    Field::make('rich_text', 'home_industry_tabs_subheading', 'Subheading')->set_rows(6)->set_default_value("Achieve enhanced safety and efficiency with ACE LED Light's energy-efficient LED products tailored to diverse industrial applications."),
    Field::make('complex', 'home_industry_tabs_items', 'Tabs')
      ->set_layout('tabbed-horizontal')
      ->set_max(12)
      ->add_fields([
        Field::make('text', 'title', 'Tab Title'),
        Field::make('rich_text', 'description', 'Tab Description')->set_rows(10),
        Field::make('image', 'icon', 'Tab Icon')->set_value_type('id'),
        Field::make('image', 'image', 'Tab Image')->set_value_type('id'),
      ]),
  ]);

  // Company Profile
  $company = Container::make('post_meta', 'Company Profile');
  if ($front_page_id) {
    $company->where('post_id', '=', $front_page_id);
  } else {
    $company->where('post_type', '=', 'page');
  }
  $company->add_fields([
    Field::make('checkbox', 'home_company_full_width', 'Full Width Section'),
    Field::make('checkbox', 'home_company_hide', 'Hide Section'),
    Field::make('text', 'home_company_heading', 'Heading')->set_default_value('Meet ACE LED LIGHT'),
    Field::make('rich_text', 'home_company_description', 'Description')->set_rows(6),
    Field::make('text', 'home_company_btn_text', 'Button Text')->set_default_value('Read More'),
    Field::make('text', 'home_company_btn_link', 'Button Link'),
    Field::make('file', 'home_company_video', 'Video File')->set_type(['video']),
    Field::make('image', 'home_company_poster', 'Video Poster Image')->set_value_type('id'),
    Field::make('complex', 'home_company_stats', 'Statistics')
      ->set_layout('tabbed-horizontal')
      ->set_max(4)
      ->add_fields([
        Field::make('text', 'number', 'Number'),
        Field::make('text', 'suffix', 'Suffix (e.g. +)'),
        Field::make('text', 'label', 'Label'),
      ]),
  ]);

  // Our Advantages
  $advantages = Container::make('post_meta', 'Our Advantages');
  if ($front_page_id) {
    $advantages->where('post_id', '=', $front_page_id);
  } else {
    $advantages->where('post_type', '=', 'page');
  }
  $advantages->add_fields([
    Field::make('checkbox', 'home_advantages_full_width', 'Full Width Section'),
    Field::make('checkbox', 'home_advantages_hide', 'Hide Section'),
    Field::make('text', 'home_advantages_heading', 'Heading')->set_default_value('What Makes Us Your Top Choice'),
    Field::make('rich_text', 'home_advantages_subheading', 'Subheading')->set_rows(4),
    Field::make('image', 'home_advantages_bg_image', 'Background Image')->set_value_type('id'),
    Field::make('complex', 'home_advantages_items', 'Advantages')
      ->set_layout('tabbed-horizontal')
      ->set_max(6)
      ->add_fields([
        Field::make('text', 'serial', 'Serial Number (e.g. 01)'),
        Field::make('image', 'icon', 'Icon')->set_value_type('id'),
        Field::make('text', 'title', 'Title'),
        Field::make('textarea', 'description', 'Description')->set_rows(4),
      ]),
  ]);

  // Testimonials
  $testimonials = Container::make('post_meta', 'Testimonials');
  if ($front_page_id) {
    $testimonials->where('post_id', '=', $front_page_id);
  } else {
    $testimonials->where('post_type', '=', 'page');
  }
  $testimonials->add_fields([
    Field::make('checkbox', 'home_testimonials_full_width', 'Full Width Section'),
    Field::make('checkbox', 'home_testimonials_hide', 'Hide Section'),
    Field::make('text', 'home_testimonials_title', 'Heading'),
    Field::make('textarea', 'home_testimonials_description', 'Subheading')->set_rows(4),
    Field::make('complex', 'home_testimonials_items', 'Testimonials')
      ->set_layout('tabbed-horizontal')
      ->add_fields([
        Field::make('image', 'avatar', 'Avatar')->set_value_type('id'),
        Field::make('textarea', 'quote', 'Quote')->set_rows(5),
        Field::make('text', 'author_name', 'Author Name'),
        Field::make('text', 'author_title', 'Author Title'),
        Field::make('text', 'author_company', 'Author Company'),
      ]),
  ]);

  // Partners Marquee
  $partners = Container::make('post_meta', 'Partners Marquee');
  if ($front_page_id) {
    $partners->where('post_id', '=', $front_page_id);
  } else {
    $partners->where('post_type', '=', 'page');
  }
  $partners->add_fields([
    Field::make('checkbox', 'home_partners_full_width', 'Full Width Section'),
    Field::make('checkbox', 'home_partners_hide', 'Hide Section'),
    Field::make('text', 'home_partners_title', 'Heading'),
    Field::make('complex', 'home_partners_items', 'Partners')
      ->set_layout('tabbed-horizontal')
      ->add_fields([
        Field::make('image', 'logo', 'Logo')->set_value_type('id'),
        Field::make('text', 'name', 'Name'),
      ]),
  ]);

  // Recent News Articles
  $news = Container::make('post_meta', 'Recent News Articles');
  if ($front_page_id) {
    $news->where('post_id', '=', $front_page_id);
  } else {
    $news->where('post_type', '=', 'page');
  }
  $news->add_fields([
    Field::make('checkbox', 'home_news_full_width', 'Full Width Section'),
    Field::make('checkbox', 'home_news_hide', 'Hide Section'),
    Field::make('text', 'home_news_heading', 'Heading')->set_default_value('Recent News Articles'),
    Field::make('rich_text', 'home_news_subheading', 'Subheading')->set_rows(4),
    Field::make('text', 'home_news_count', 'Items Count')->set_help_text('Default 3')->set_default_value('3'),
    Field::make('association', 'home_news_category', 'Filter by Category')
      ->set_max(1)
      ->set_types([
        [
          'type' => 'term',
          'taxonomy' => 'category',
        ],
      ]),
  ]);
});
