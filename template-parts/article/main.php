<?php
$post_id = get_the_ID();
$mid_media = function_exists('ace_get_article_mid_media') ? ace_get_article_mid_media($post_id) : null;
?>

<article>
  <header class="space-y-3">
    <h1 class="text-3xl sm:text-4xl font-semibold text-gray-900 leading-tight"><?php the_title(); ?></h1>
    <p class="text-sm text-gray-500"><?php echo esc_html(get_the_date()); ?></p>
  </header>

  <?php if (is_array($mid_media) && !empty($mid_media['type'])): ?>
    <?php
    $media_wrap = !empty($mid_media['full']) ? 'mt-8' : 'mt-8 max-w-3xl';
    ?>
    <section class="<?php echo esc_attr($media_wrap); ?>">
      <?php if ($mid_media['type'] === 'image' && !empty($mid_media['image_id'])): ?>
        <?php echo wp_get_attachment_image((int) $mid_media['image_id'], 'large', false, ['class' => 'w-full h-auto rounded-2xl']); ?>
      <?php elseif ($mid_media['type'] === 'embed' && !empty($mid_media['embed'])): ?>
        <?php
        $embed_raw = (string) $mid_media['embed'];
        $embed_out = '';
        if (filter_var($embed_raw, FILTER_VALIDATE_URL)) {
          $embed_out = wp_oembed_get($embed_raw);
        }
        if (!$embed_out) {
          $embed_out = wp_kses($embed_raw, [
            'iframe' => [
              'src' => true,
              'width' => true,
              'height' => true,
              'frameborder' => true,
              'allow' => true,
              'allowfullscreen' => true,
              'referrerpolicy' => true,
              'loading' => true,
              'title' => true,
            ],
          ]);
        }
        ?>
        <?php if ($embed_out): ?>
          <div class="aspect-video w-full overflow-hidden rounded-2xl bg-black">
            <div class="w-full h-full [&_iframe]:w-full [&_iframe]:h-full">
              <?php echo $embed_out; ?>
            </div>
          </div>
        <?php endif; ?>
      <?php endif; ?>
    </section>
  <?php endif; ?>

  <section class="mt-8">
    <div class="prose max-w-none">
      <?php the_content(); ?>
    </div>
  </section>
</article>
