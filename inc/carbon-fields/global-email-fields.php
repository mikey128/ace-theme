<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function () {
  Container::make('theme_options', 'Email Capture Settings')
    ->set_page_parent('options-general.php')
    ->add_fields([
      Field::make('checkbox', 'global_email_enable_full_width', 'Email Capture Full Width'),
      Field::make('checkbox', 'global_email_hide_section', 'Hide Email Capture'),
      Field::make('text', 'global_email_heading', 'Email Capture Heading')
        ->set_default_value('We Guarantee Complete Satisfaction, No Hassles, Competitive Prices!'),
      Field::make('textarea', 'global_email_description', 'Email Capture Description')
        ->set_default_value('Our team of expert sales advisers is eager to address your concerns and see how we can elevate your brand. Talk to us today and start a consultation!'),
      Field::make('text', 'global_email_button_text', 'Email Capture Button Text')
        ->set_default_value('Contact Us'),
    ]);
});

