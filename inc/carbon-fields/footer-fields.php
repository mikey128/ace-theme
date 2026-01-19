<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function () {
  Container::make('theme_options', 'Footer Settings')
    ->set_page_parent('options-general.php')
    ->add_fields([
      Field::make('rich_text', 'footer_description', 'Footer Description')
        ->set_default_value('For more than a decade, ACE has manufactured lighting products with the highest technology and quality standards, focused on energy saving solutions.'),
      Field::make('complex', 'footer_socials', 'Social Links')
        ->set_layout('tabbed-horizontal')
        ->add_fields([
          Field::make('select', 'network', 'Network')->set_options([
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'youtube' => 'YouTube',
            'instagram' => 'Instagram',
            'linkedin' => 'LinkedIn',
          ])->set_default_value('facebook'),
          Field::make('text', 'url', 'Profile URL')->set_attribute('type', 'url'),
        ]),
      Field::make('text', 'footer_products_heading', 'Products Heading')->set_default_value('Products List'),
      Field::make('select', 'footer_products_menu', 'Products Menu')
        ->set_options(function () {
          $menus = wp_get_nav_menus();
          $options = ['' => 'Select Menu'];
          if (!empty($menus) && !is_wp_error($menus)) {
            foreach ($menus as $menu) {
              $options[$menu->term_id] = $menu->name;
            }
          }
          return $options;
        }),
      Field::make('text', 'footer_contact_heading', 'Contact Heading')->set_default_value('Contact Us'),
      Field::make('text', 'footer_phone', 'Phone'),
      Field::make('text', 'footer_tel', 'Tel'),
      Field::make('text', 'footer_email', 'E-mail'),
      Field::make('text', 'footer_whatsapp', 'Whatsapp'),
      Field::make('text', 'footer_address', 'Address'),
      Field::make('rich_text', 'additional_info', 'Additional Information')
        ->set_rows(8),   
      Field::make('text', 'footer_copyright', 'Copyright Text')->set_default_value('Copyright Notice © ACE LED Light All Right Reserved and by Legal Protection'),
    ]);
});
