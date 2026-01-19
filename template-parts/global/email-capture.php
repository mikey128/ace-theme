<?php
$hide = function_exists('carbon_get_theme_option') ? carbon_get_theme_option('global_email_hide_section') : false;
if ($hide) { return; }
$full = function_exists('carbon_get_theme_option') ? carbon_get_theme_option('global_email_enable_full_width') : false;
$wrap = $full ? 'w-full px-6' : 'max-w-7xl mx-auto px-6 max-w-global';
$heading     = function_exists('carbon_get_theme_option') ? carbon_get_theme_option('global_email_heading') : '';
$description = function_exists('carbon_get_theme_option') ? carbon_get_theme_option('global_email_description') : '';
$button_text = function_exists('carbon_get_theme_option') ? carbon_get_theme_option('global_email_button_text') : 'Contact Us';
$section_id = 'global-email-capture-' . uniqid();
$result = isset($_GET['email_capture']) ? sanitize_text_field($_GET['email_capture']) : '';
$source_id = get_queried_object_id();
?>
<section id="<?php echo esc_attr($section_id); ?>" class="py-12 sm:py-16 md:py-20 bg-neutral-900">
  <div class="<?php echo esc_attr($wrap); ?>">
    <div class="max-w-4xl mx-auto text-center">
      <?php if (!empty($heading)) : ?>
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-semibold text-white">
          <?php echo esc_html($heading); ?>
        </h2>
      <?php endif; ?>
      <?php if (!empty($description)) : ?>
        <p class="mt-4 text-base sm:text-lg text-gray-300">
          <?php echo esc_html($description); ?>
        </p>
      <?php endif; ?>

      <?php if ($result === 'success') : ?>
        <div class="mt-4 inline-block rounded-md bg-green-500/20 px-4 py-2 text-sm text-green-200">
          Thank you! We will contact you soon.
        </div>
      <?php elseif ($result === 'invalid' || $result === 'error') : ?>
        <div class="mt-4 inline-block rounded-md bg-red-500/20 px-4 py-2 text-sm text-red-200">
          Please enter a valid email and try again.
        </div>
      <?php endif; ?>

      <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="mt-6 flex flex-col sm:flex-row items-stretch gap-3 sm:justify-center">
        <input type="hidden" name="action" value="ace_email_capture">
        <input type="hidden" name="source_post_id" value="<?php echo esc_attr($source_id); ?>">
        <?php wp_nonce_field('ace_email_capture', 'ace_email_nonce'); ?>
        <label class="sr-only" for="<?php echo esc_attr($section_id); ?>-email">Your email</label>
        <input id="<?php echo esc_attr($section_id); ?>-email" type="email" name="email" required
          class="w-full sm:w-80 md:w-96 rounded-md bg-neutral-800 text-white placeholder-gray-400 px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
          placeholder="Your email" />
        <button type="submit"
          class="inline-flex items-center justify-center rounded-md bg-brand-accent px-5 py-3 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-brand-accent">
          <?php echo esc_html($button_text); ?>
        </button>
      </form>
    </div>
  </div>
</section>

