<?php
if (! function_exists('carbon_get_the_post_meta')) { return; }

$hide = carbon_get_the_post_meta('contact_hide_section');
if ($hide === null || $hide === '') { $hide = carbon_get_the_post_meta('hide_section'); }
if ($hide) { return; }

$full = carbon_get_the_post_meta('contact_enable_full_width');
if ($full === null) { $full = carbon_get_the_post_meta('enable_full_width'); }
if ($full === null && function_exists('carbon_get_theme_option')) {
  $full = carbon_get_theme_option('global_contact_enable_full_width');
}
$wrap = $full ? 'w-full px-6' : 'max-w-7xl mx-auto px-6 max-w-global';

$heading     = carbon_get_the_post_meta('contact_heading');
if (empty($heading) && function_exists('carbon_get_theme_option')) {
  $heading = carbon_get_theme_option('global_contact_heading');
}
$description = carbon_get_the_post_meta('contact_description');
if (empty($description) && function_exists('carbon_get_theme_option')) {
  $description = carbon_get_theme_option('global_contact_description');
}
$subheading  = carbon_get_the_post_meta('contact_subheading');
if (empty($subheading) && function_exists('carbon_get_theme_option')) {
  $subheading = carbon_get_theme_option('global_contact_subheading');
}
$button_text = carbon_get_the_post_meta('contact_button_text');
if (empty($button_text) && function_exists('carbon_get_theme_option')) {
  $button_text = carbon_get_theme_option('global_contact_button_text');
}
$privacy_note = carbon_get_the_post_meta('contact_privacy_note');
if (empty($privacy_note) && function_exists('carbon_get_theme_option')) {
  $privacy_note = carbon_get_theme_option('global_contact_privacy_note');
}

$section_id_input = (string) carbon_get_the_post_meta('contact_section_id');
$section_id = $section_id_input !== '' ? sanitize_title($section_id_input) : 'global-contact-form';
$result     = isset($_GET['contact']) ? sanitize_text_field($_GET['contact']) : '';
?>
<section id="<?php echo esc_attr($section_id); ?>" class="py-12 sm:py-16 md:py-20 bg-brand-accent">
  <div class="<?php echo esc_attr($wrap); ?>">
    <div class="mx-auto text-white">
      <?php if (!empty($heading) || !empty($description)) : ?>
        <header class="max-w-4xl mb-8 sm:mb-10">
          <?php if (!empty($heading)) : ?>
            <h2 class="text-3xl sm:text-4xl  font-semibold ">
              <?php echo esc_html($heading); ?>
            </h2>
          <?php endif; ?>
          <?php if (!empty($description)) : ?>
            <p class="mt-4 text-base  text-blue-100">
              <?php echo esc_html($description); ?>
            </p>
          <?php endif; ?>
        </header>
      <?php endif; ?>

      <?php if (!empty($subheading)) : ?>
        <h3 class="text-lg sm:text-xl md:text-2xl font-semibold mb-4">
          <?php echo esc_html($subheading); ?>
        </h3>
      <?php endif; ?>

      <?php if ($result === 'success') : ?>
        <div class="mb-4 rounded-md bg-white/10 px-4 py-3 text-sm">
          Your message has been sent successfully.
        </div>
      <?php elseif ($result === 'invalid' || $result === 'error') : ?>
        <div class="mb-4 rounded-md bg-red-500/20 px-4 py-3 text-sm">
          Please provide valid contact details and try again.
        </div>
      <?php endif; ?>

      <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="space-y-6">
        <input type="hidden" name="action" value="ace_contact_submit">
        <input type="hidden" name="source_post_id" value="<?php echo esc_attr(get_queried_object_id()); ?>">
        <?php wp_nonce_field('ace_contact_submit', 'ace_contact_nonce'); ?>

        <label class="block">
          <span class="sr-only">Your Name</span>
          <input type="text" name="name" required
            class="w-full rounded-md bg-white text-gray-900 placeholder-gray-400 px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-white"
            placeholder="Your Name:" />
        </label>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <label class="block">
            <span class="sr-only">Your Tel/Whatsapp</span>
            <input type="text" name="tel"
              class="w-full rounded-md bg-white text-gray-900 placeholder-gray-400 px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-white"
              placeholder="Your Tel/Whatsapp:" />
          </label>
          <label class="block">
            <span class="sr-only">Email</span>
            <input type="email" name="email"
              class="w-full rounded-md bg-white text-gray-900 placeholder-gray-400 px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-white"
              placeholder="Email:" />
          </label>
        </div>

        <label class="block">
          <span class="sr-only">Message</span>
          <textarea name="message" rows="5"
            class="w-full rounded-md bg-white text-gray-900 placeholder-gray-400 px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-white"
            placeholder="Message:"></textarea>
        </label>

        <?php if (!empty($privacy_note)) : ?>
          <p class="text-sm text-blue-100">
            <?php echo esc_html($privacy_note); ?>
          </p>
        <?php endif; ?>

        <button type="submit"
          class="inline-flex items-center justify-center rounded-md bg-white px-6 py-4 text-sm font-semibold text-brand-accent  shadow-sm transition-colors hover:bg-blue-50">
          <?php echo esc_html(!empty($button_text) ? $button_text : 'SEND MESSAGE'); ?>
        </button>
      </form>
    </div>
  </div>
</section>
