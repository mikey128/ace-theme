<?php
function ace_register_contact_message_cpt() {
  if (post_type_exists('contact_message')) return;
  register_post_type('contact_message', [
    'labels' => [
      'name'               => 'Contact Messages',
      'singular_name'      => 'Contact Message',
      'menu_name'          => 'Contact Messages',
      'add_new'            => 'Add New',
      'add_new_item'       => 'Add New Message',
      'edit_item'          => 'Edit Message',
      'new_item'           => 'New Message',
      'view_item'          => 'View Message',
      'search_items'       => 'Search Messages',
      'not_found'          => 'No messages found',
      'not_found_in_trash' => 'No messages found in Trash',
    ],
    'public'        => false,
    'show_ui'       => true,
    'show_in_menu'  => true,
    'menu_icon'     => 'dashicons-email',
    'supports'      => ['title','editor'],
    'has_archive'   => false,
    'show_in_rest'  => false,
    'capability_type' => 'post',
  ]);
}
add_action('init', 'ace_register_contact_message_cpt');

function ace_contact_message_admin_columns($columns) {
  $new = [
    'cb'            => $columns['cb'],
    'title'         => 'Name',
    'sender_email'  => 'Email',
    'sender_tel'    => 'Tel/Whatsapp',
    'date'          => 'Date',
  ];
  return $new;
}
add_filter('manage_edit-contact_message_columns', 'ace_contact_message_admin_columns');

function ace_contact_message_custom_column($column, $post_id) {
  if ($column === 'sender_email') {
    echo esc_html(get_post_meta($post_id, 'contact_email', true));
  } elseif ($column === 'sender_tel') {
    echo esc_html(get_post_meta($post_id, 'contact_tel', true));
  }
}
add_action('manage_contact_message_posts_custom_column', 'ace_contact_message_custom_column', 10, 2);

