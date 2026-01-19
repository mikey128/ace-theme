<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function () {
  Container::make('theme_options', 'Global Style')
    ->set_page_parent('options-general.php')
    ->add_fields([
       Field::make('select', 'global_heading_font', 'Heading Font Family')
        ->set_options([
          'inherit' => 'Inherit',
          'system-ui' => 'System UI',
          'inter' => 'Inter',
          'roboto' => 'Roboto',
          'open-sans' => 'Open Sans',
          'lato' => 'Lato',
          'montserrat' => 'Montserrat',
          'poppins' => 'Poppins',
          'nunito' => 'Nunito',
          'source-sans' => 'Source Sans Pro',
          'noto-sans' => 'Noto Sans',
          'ubuntu' => 'Ubuntu',
          'merriweather' => 'Merriweather',
          'playfair' => 'Playfair Display',
          'georgia' => 'Georgia',
          'times' => 'Times New Roman',
          'arial' => 'Arial',
          'helvetica' => 'Helvetica',
          'tahoma' => 'Tahoma',
          'verdana' => 'Verdana',
        ])
        ->set_default_value('inter'),
      Field::make('select', 'global_body_font', 'Body Font Family')
        ->set_options([
          'inherit' => 'Inherit',
          'system-ui' => 'System UI',
          'inter' => 'Inter',
          'roboto' => 'Roboto',
          'open-sans' => 'Open Sans',
          'lato' => 'Lato',
          'montserrat' => 'Montserrat',
          'poppins' => 'Poppins',
          'nunito' => 'Nunito',
          'source-sans' => 'Source Sans Pro',
          'noto-sans' => 'Noto Sans',
          'ubuntu' => 'Ubuntu',
          'merriweather' => 'Merriweather',
          'playfair' => 'Playfair Display',
          'georgia' => 'Georgia',
          'times' => 'Times New Roman',
          'arial' => 'Arial',
          'helvetica' => 'Helvetica',
          'tahoma' => 'Tahoma',
          'verdana' => 'Verdana',
        ])
        ->set_default_value('system-ui'),
     
      Field::make('select', 'global_base_font_size', 'Base Font Size')
        ->set_options([
          '14px' => '14px',
          '16px' => '16px',
          '18px' => '18px',
        ])
        ->set_default_value('16px'),
       Field::make('select', 'global_heading_letter_spacing', 'Heading Letter Spacing')
        ->set_options([
          'normal' => 'Normal',         
          '-0.02em' => '-0.02em',
          '-0.01em' => '-0.01em',
          '0' => '0',
          '0.01em' => '0.01em',
          '0.02em' => '0.02em',
          '0.05em' => '0.05em',
          '0.08em' => '0.08em',
          '0.1em' => '0.1em',
        ])
        ->set_default_value('0.01em'),
      Field::make('select', 'global_body_letter_spacing', 'Body Letter Spacing')
        ->set_options([
          'normal' => 'Normal',
          '-0.02em' => '-0.02em',
          '-0.01em' => '-0.01em',
          '0' => '0',
          '0.01em' => '0.01em',
          '0.02em' => '0.02em',
          '0.05em' => '0.05em',
          '0.08em' => '0.08em',
          '0.1em' => '0.1em',
        ])
        ->set_default_value('0'),
    
      Field::make('text', 'global_container_width', 'Container Width (px)')
        ->set_attribute('type', 'number')
        ->set_default_value('1200')
        ->set_help_text('Global max-width for content wrappers.'),
      Field::make('text', 'global_google_fonts_url', 'Google Fonts CSS URL')
        ->set_help_text('Optional. Example: https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap'),
      Field::make('color', 'global_color_primary', 'Primary Color')->set_default_value('#e11d48'),
      Field::make('color', 'global_color_secondary', 'Secondary Color')->set_default_value('#111827'),
      Field::make('color', 'global_color_accent', 'Accent Color')->set_default_value('#2563eb'),
    ]);
});
