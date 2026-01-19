<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function () {
  Container::make('theme_options', 'User Module Settings')
    ->set_page_parent('options-general.php')
    ->add_fields([
      Field::make('checkbox', 'enable_frontend_registration', 'Enable Frontend Registration'),
      Field::make('text', 'redirect_login_success', 'Login Success Redirect URL')->set_attribute('type', 'url'),
      Field::make('text', 'redirect_register_success', 'Register Success Redirect URL')->set_attribute('type', 'url'),
      Field::make('text', 'redirect_logout', 'Logout Redirect URL')->set_attribute('type', 'url'),
    ]);

  Container::make('user_meta', 'Extra Profile')
    ->add_fields([
      Field::make('text', 'company', 'Company'),
      Field::make('text', 'telephone', 'Telephone'),
      Field::make('textarea', 'address', 'Address'),
    ]);
});

