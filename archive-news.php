<?php
get_header();

$archive_url = get_post_type_archive_link('news');
$archive_title = post_type_archive_title('', false);

$active_term_slug = '';
if (isset($_GET['category'])) {
  $active_term_slug = sanitize_title(wp_unslash($_GET['category']));
}
$active_term = null;
if ($active_term_slug !== '') {
  $term = get_term_by('slug', $active_term_slug, 'category');
  if ($term && ! is_wp_error($term)) {
    $active_term = $term;
  } else {
    $active_term_slug = '';
  }
}

$paged = max(1, (int) get_query_var('paged'));

$tax_query = [];
if ($active_term) {
  $tax_query[] = [
    'taxonomy' => 'category',
    'field' => 'term_id',
    'terms' => [(int) $active_term->term_id],
  ];
}

$featured_query = new WP_Query([
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
  'tax_query' => $tax_query,
]);
$featured_ids = ! empty($featured_query->posts) ? wp_list_pluck($featured_query->posts, 'ID') : [];

$grid_query = new WP_Query([
  'post_type' => 'post',
  'post_status' => 'publish',
  'posts_per_page' => (int) get_option('posts_per_page'),
  'paged' => $paged,
  'post__not_in' => $featured_ids,
  'ignore_sticky_posts' => true,
  'tax_query' => $tax_query,
]);

if (! $grid_query->have_posts()) {
  $grid_query = new WP_Query([
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => (int) get_option('posts_per_page'),
    'paged' => $paged,
    'ignore_sticky_posts' => true,
  ]);
}

$get_opt = function ($key, $default = false) {
  return function_exists('carbon_get_theme_option') ? carbon_get_theme_option($key) : $default;
};

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
