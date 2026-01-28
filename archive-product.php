<?php
get_header();

$archive_title = __('Products', 'ace-theme');
$active_term_slug = '';
if (isset($_GET['category'])) {
  $active_term_slug = sanitize_title(wp_unslash($_GET['category']));
}
$active_term = null;
if ($active_term_slug !== '') {
  $term = get_term_by('slug', $active_term_slug, 'product_category');
  if ($term && ! is_wp_error($term)) {
    $active_term = $term;
  } else {
    $active_term_slug = '';
  }
}

$paged = max(1, (int) get_query_var('paged'));

$get_opt = function ($key, $default = false) {
  return function_exists('carbon_get_theme_option') ? carbon_get_theme_option($key) : $default;
};

?>
<main id="primary" class="min-h-[60vh]">
  test
<?php
// Hero
$hero_image = (string) $get_opt('product_archive_hero_image', '');
get_template_part('template-parts/product/archive-hero', null, [
  'archive_title' => $archive_title,
  'hero_image' => $hero_image,
  'enable_full_width' => (bool) $get_opt('product_archive_hero_enable_full_width', false),
  'hide_section' => (bool) $get_opt('product_archive_hero_hide_section', false),
]);

// Intro heading + description
get_template_part('template-parts/product/archive-heading', null, [
  'heading' => (string) $get_opt('product_archive_heading', ''),
  'description' => (string) $get_opt('product_archive_description', ''),
  'enable_full_width' => (bool) $get_opt('product_archive_intro_enable_full_width', false),
  'hide_section' => (bool) $get_opt('product_archive_intro_hide_section', false),
]);

// Main products section: nav + grid
get_template_part('template-parts/product/archive-main', null, [
  'active_term' => $active_term,
  'active_term_slug' => $active_term_slug,
  'paged' => $paged,
  'enable_full_width' => (bool) $get_opt('product_archive_main_enable_full_width', false),
  'hide_section' => (bool) $get_opt('product_archive_main_hide_section', false),
]);
?>
</main>
<?php
get_footer();
