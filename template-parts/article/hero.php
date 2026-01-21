<?php
$post_id = get_the_ID();
$featured_url = get_the_post_thumbnail_url($post_id, 'full');
$label = function_exists('ace_get_editorial_label') ? ace_get_editorial_label($post_id) : '';
?>

<?php if ($featured_url): ?>
  <section class="relative w-full">
    <figure class="relative w-full h-56 sm:h-72 lg:h-[26rem] overflow-hidden">
      <img src="<?php echo esc_url($featured_url); ?>" alt="" class="w-full h-full object-cover" loading="eager">
      <div class="absolute inset-0 bg-black/45"></div>
      <?php if ($label): ?>
        <figcaption class="absolute inset-0 flex items-center justify-center">
          <span class="text-white text-3xl sm:text-4xl font-semibold tracking-wide"><?php echo esc_html($label); ?></span>
        </figcaption>
      <?php endif; ?>
    </figure>
  </section>
<?php else: ?>
  <?php if ($label): ?>
    <section class="relative w-full">
      <div class="relative w-full h-40 sm:h-52 lg:h-[22rem] bg-neutral-900">
        <div class="absolute inset-0 bg-black/35"></div>
        <div class="absolute inset-0 flex items-center justify-center">
          <span class="text-white text-3xl sm:text-4xl font-semibold tracking-wide"><?php echo esc_html($label); ?></span>
        </div>
      </div>
    </section>
  <?php endif; ?>
<?php endif; ?>
