<?php
get_header();

// Debug: Check if template is loading
error_log('home.php is loading');
error_log('URL: ' . home_url('/news/'));
error_log('page_for_posts: ' . get_option('page_for_posts'));

$archive_title = __('News', 'ace-theme');

$active_term_slug = '';
if (isset($_GET['category'])) {
  $active_term_slug = sanitize_title(wp_unslash($_GET['category']));
}
$active_term = null;
if ($active_term_slug !== '') {
  $term = get_term_by('slug', $active_term_slug, 'category');
  if ($term && ! is_wp_error($term)) {
    $active_term = $term;
    $archive_title = $term->name;
  } else {
    $active_term_slug = '';
  }
}

$paged = max(1, (int) get_query_var('paged'));

// Build query args for featured posts
$featured_args = [
  'post_type' => 'post',
  'post_status' => 'publish',
  'posts_per_page' => 5,
  'no_found_rows' => true,
  'ignore_sticky_posts' => true,
  'meta_query' => [
    'relation' => 'OR',
    [
      'key' => 'is_featured',
      'value' => 'yes',
      'compare' => '=',
    ],
    [
      'key' => 'is_featured',
      'value' => '1',
      'compare' => '=',
    ],
  ],
];

// Only add tax_query if there's an active term
if ($active_term) {
  $featured_args['tax_query'] = [
    [
      'taxonomy' => 'category',
      'field' => 'term_id',
      'terms' => [(int) $active_term->term_id],
    ],
  ];
}

$featured_query = new WP_Query($featured_args);
$featured_ids = ! empty($featured_query->posts) ? wp_list_pluck($featured_query->posts, 'ID') : [];

// Build query args for grid posts
$grid_args = [
  'post_type' => 'post',
  'post_status' => 'publish',
  'posts_per_page' => (int) get_option('posts_per_page'),
  'paged' => $paged,
  'post__not_in' => $featured_ids,
  'ignore_sticky_posts' => true,
];

// Only add tax_query if there's an active term
if ($active_term) {
  $grid_args['tax_query'] = [
    [
      'taxonomy' => 'category',
      'field' => 'term_id',
      'terms' => [(int) $active_term->term_id],
    ],
  ];
}

$grid_query = new WP_Query($grid_args);

$get_opt = function ($key, $default = false) {
  return function_exists('carbon_get_theme_option') ? carbon_get_theme_option($key) : $default;
};

$posts_page_id = (int) get_option('page_for_posts');
$archive_url = $posts_page_id ? get_permalink($posts_page_id) : home_url('/news/');

?>
<main id="primary" class="min-h-[60vh]">
<?php
$hero_image = '';
if ($active_term && function_exists('carbon_get_term_meta')) {
  $hero_image = carbon_get_term_meta((int)$active_term->term_id, 'category_hero_image');
}
if ($hero_image === '' || $hero_image === null) {
  $hero_image = $get_opt('news_archive_hero_image', '');
}
get_template_part('template-parts/blog/hero', null, [
  'archive_title' => $archive_title,
  'description' => (string) $get_opt('news_archive_description', ''),
  'active_term' => $active_term,
  'hero_image' => $hero_image,
  'enable_full_width' => (bool) $get_opt('news_archive_hero_enable_full_width', false),
  'hide_section' => (bool) $get_opt('news_archive_hero_hide_section', false),
]);

get_template_part('template-parts/blog/filter', null, [
  'archive_url' => $archive_url,
  'active_term' => $active_term,
  'active_term_slug' => $active_term_slug,
  'enable_full_width' => (bool) $get_opt('news_archive_filter_enable_full_width', false),
  'hide_section' => (bool) $get_opt('news_archive_filter_hide_section', false),
]);

get_template_part('template-parts/blog/featured', null, [
  'query' => $featured_query,
  'active_term_slug' => $active_term_slug,
  'enable_full_width' => (bool) $get_opt('news_archive_featured_enable_full_width', false),
  'hide_section' => (bool) $get_opt('news_archive_featured_hide_section', false),
]);

get_template_part('template-parts/blog/grid', null, [
  'query' => $grid_query,
  'active_term_slug' => $active_term_slug,
  'enable_full_width' => (bool) $get_opt('news_archive_grid_enable_full_width', false),
  'hide_section' => (bool) $get_opt('news_archive_grid_hide_section', false),
]);

get_template_part('template-parts/global/contact-form');

wp_reset_postdata();
?>
</main>
<?php
get_footer();
