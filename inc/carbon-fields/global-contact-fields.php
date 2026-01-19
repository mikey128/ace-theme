<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function () {
  Container::make('theme_options', 'Contact Form Settings')
    ->set_page_parent('options-general.php')
    ->add_fields([
      Field::make('checkbox', 'global_contact_enable_full_width', 'Full Width Section'),
      Field::make('checkbox', 'global_contact_hide_section', 'Hide Section'),
      Field::make('text', 'global_contact_heading', 'Heading')
        ->set_default_value('Talk to Your Dedicated LED Product Experts'),
      Field::make('textarea', 'global_contact_description', 'Intro Description')
        ->set_default_value('If you are looking for reliable, energy-efficient industrial lighting solutions, look no further than ACE LED Light. Contact us today to learn more about our products and services.'),
      Field::make('text', 'global_contact_subheading', 'Form Subheading')
        ->set_default_value('Submit Your Request'),
      Field::make('text', 'global_contact_button_text', 'Button Text')
        ->set_default_value('SEND MESSAGE'),
      Field::make('text', 'global_contact_privacy_note', 'Privacy Note')
        ->set_default_value('We respect your confidentiality and all information are protected.'),
    ]);
  
  Container::make('post_meta', 'Page Contact Form')
    ->where('post_type', '=', 'page')
    ->add_fields([
      Field::make('text', 'contact_section_id', 'Section ID')
        ->set_help_text('Used for on-page navigation, without #'),
      Field::make('checkbox', 'enable_full_width', 'Full Width Section'),
      Field::make('checkbox', 'hide_section', 'Hide Section'),
      Field::make('text', 'contact_heading', 'Heading'),
      Field::make('textarea', 'contact_description', 'Intro Description'),
      Field::make('text', 'contact_subheading', 'Form Subheading'),
      Field::make('text', 'contact_button_text', 'Button Text'),
      Field::make('text', 'contact_privacy_note', 'Privacy Note'),
    ]);
});
