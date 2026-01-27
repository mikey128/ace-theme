<?php
use Carbon_Fields\Block;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function () {
  Block::make(__('Tabbed Download', 'ace-theme'))
    ->set_mode('edit')
    ->set_preview_mode('live')
    ->add_fields([
      Field::make('checkbox', 'td_full_width', __('Full Width', 'ace-theme')),
      Field::make('text', 'td_heading', __('Heading', 'ace-theme')),
      Field::make('rich_text', 'td_description', __('Description', 'ace-theme')),
      Field::make('complex', 'td_tabs', __('Tabs', 'ace-theme'))
        ->set_layout('tabbed-vertical')
        ->add_fields([
          Field::make('text', 'tab_label', __('Tab Label', 'ace-theme')),
        ])
        ->set_header_template('
          <% if (tab_label) { %>
            <%= tab_label %>
          <% } else { %>
            Tab #<%= $_index + 1 %>
          <% } %>
        ')
        ->set_min(1)
        ->set_max(12),
      Field::make('complex', 'td_items', __('Download Items', 'ace-theme'))
        ->set_layout('tabbed-vertical')
        ->add_fields([
          Field::make('text', 'parent_tab', __('Parent Tab', 'ace-theme')),
          Field::make('image', 'cover', __('Cover Image', 'ace-theme'))->set_value_type('id'),
          Field::make('text', 'title', __('Title', 'ace-theme')),
         Field::make('text', 'download_link', 'Link')->set_attribute('type', 'url')
        ])
        ->set_header_template('
          <% if (title && parent_tab) { %>
            <%= title %> — <%= parent_tab %>
          <% } else { %>
            Item #<%= $_index + 1 %>
          <% } %>
        ')
        ->set_min(0)
        ->set_max(60),
    ])
    ->set_description(__('Tabbed downloads with dynamic tabs and items', 'ace-theme'))
    ->set_category('ace-blocks')
    ->set_icon('download')
    ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
      include get_template_directory() . '/template-parts/blocks/tabbed-download.php';
    });
});
add_action('carbon_fields_register_fields', function () {
  Block::make(__('Tabbed FAQ', 'ace-theme'))
    ->set_mode('edit')
    ->set_preview_mode('live')
    ->add_fields([
      Field::make('checkbox', 'tf_full_width', __('Full Width', 'ace-theme')),
      Field::make('text', 'tf_heading', __('Heading', 'ace-theme')),
      Field::make('rich_text', 'tf_description', __('Description', 'ace-theme')),
      Field::make('complex', 'tf_tabs', __('Tabs', 'ace-theme'))
        ->set_layout('tabbed-vertical')
        ->add_fields([
          Field::make('text', 'tab_label', __('Tab Label', 'ace-theme')),
        ])
        ->set_header_template('
          <% if (tab_label) { %>
            <%= tab_label %>
          <% } else { %>
            Tab #<%= $_index + 1 %>
          <% } %>
        ')
        ->set_min(1)
        ->set_max(12),
      Field::make('complex', 'tf_items', __('FAQ Items', 'ace-theme'))
        ->set_layout('tabbed-vertical')
        ->add_fields([
          Field::make('text', 'parent_tab', __('Parent Tab', 'ace-theme')),
          Field::make('text', 'question', __('Question', 'ace-theme')),
          Field::make('rich_text', 'answer', __('Answer', 'ace-theme'))->set_rows(6),
        ])
        ->set_header_template('
          <% if (question && parent_tab) { %>
            <%= question %> — <%= parent_tab %>
          <% } else { %>
            Item #<%= $_index + 1 %>
          <% } %>
        ')
        ->set_min(0)
        ->set_max(60),
    ])
    ->set_description(__('Tabbed FAQ with accordion answers', 'ace-theme'))
    ->set_category('ace-blocks')
    ->set_icon('editor-help')
    ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
      include get_template_directory() . '/template-parts/blocks/tabbed-faq.php';
    });
});
