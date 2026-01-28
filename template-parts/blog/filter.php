<?php
// Category filter section.
$hide = ! empty($args['hide_section']);
if ($hide) { return; }

$full = ! empty($args['enable_full_width']);
$wrap = $full ? 'w-full px-6' : 'max-w-7xl mx-auto px-6 max-w-global';

$archive_url = isset($args['archive_url']) ? (string) $args['archive_url'] : '';
$active_slug = isset($args['active_term_slug']) ? (string) $args['active_term_slug'] : '';

$terms = get_terms([
  'taxonomy' => 'category',
  'hide_empty' => true,
]);

if (! is_array($terms) || empty($terms) || is_wp_error($terms) || $archive_url === '') { return; }

$btn_base = 'inline-flex items-center justify-center rounded border px-4 py-3 text-xs sm:text-base font-medium transition-colors';
$btn_inactive = 'border-gray-200 bg-white text-gray-700 hover:border-brand-accent hover:text-brand-accent';
$btn_active = 'border-brand-accent bg-brand-accent text-white';
?>
<section class="bg-white pt-12 pb-6">
  <div class="<?php echo esc_attr($wrap); ?>">
    <nav aria-label="<?php echo esc_attr__('News categories', 'ace-theme'); ?>" class="flex flex-wrap items-center justify-center gap-4">
      <a class="<?php echo esc_attr($btn_base . ' ' . ($active_slug === '' ? $btn_active : $btn_inactive)); ?>" href="<?php echo esc_url($archive_url); ?>">
        <?php echo esc_html__('All', 'ace-theme'); ?>
      </a>
      <?php foreach ($terms as $term) : ?>
        <?php
          $slug = isset($term->slug) ? (string) $term->slug : '';
          $is_active = ($slug !== '' && $slug === $active_slug);
          $url = get_term_link($term);
          if (is_wp_error($url)) { continue; }
        ?>
        <a class="<?php echo esc_attr($btn_base . ' ' . ($is_active ? $btn_active : $btn_inactive)); ?>" href="<?php echo esc_url($url); ?>">
          <?php echo esc_html($term->name); ?>
        </a>
      <?php endforeach; ?>
    </nav>
  </div>
</section>
