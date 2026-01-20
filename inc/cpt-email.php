<?php
function ace_register_email_lead_cpt() {
  if (post_type_exists('email_lead')) return;
  register_post_type('email_lead', [
    'labels' => [
      'name' => 'Email Leads',
      'singular_name' => 'Email Lead',
      'menu_name' => 'Email Leads',
    ],
    'public' => false,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_icon' => 'dashicons-email-alt',
    'supports' => ['title'],
    'has_archive' => false,
    'show_in_rest' => false,
  ]);
}
add_action('init', 'ace_register_email_lead_cpt');

function ace_email_lead_admin_columns($columns) {
  $new = [
    'cb' => $columns['cb'],
    'title' => 'Email',
    'date' => 'Date',
  ];
  return $new;
}
add_filter('manage_edit-email_lead_columns', 'ace_email_lead_admin_columns');
