 
<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function () {
  Container::make('post_meta', 'Page Video Modules')
    ->where('post_type', '=', 'page')
    ->add_fields([
      Field::make('complex', 'page_video_modules', 'Video Modules')
        ->set_layout('tabbed-horizontal')
        ->set_max(10)
        ->add_fields([
          Field::make('text', 'section_id', 'Section ID')
            ->set_help_text('Used for on-page navigation, without #'),
          Field::make('checkbox', 'enable_full_width', 'Full Width Section'),
          Field::make('checkbox', 'hide_section', 'Hide Section'),
          Field::make('text', 'video_title', 'Video Title'),
          Field::make('image', 'cover_image', 'Cover Image')->set_value_type('id'),
          Field::make('file', 'video_file', 'Video File')->set_type(['video']),
        ])
        ->set_header_template('
          <% if (video_title) { %>
            <%= video_title %>
          <% } else { %>
            Video #<%= $_index + 1 %>
          <% } %>
        '),
    ]);
});
