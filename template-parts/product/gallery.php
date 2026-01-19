<?php
$gallery_ids = carbon_get_the_post_meta('gallery_images');
$product_title = carbon_get_the_post_meta('product_title');
$product_description = carbon_get_the_post_meta('product_description');
$cta_primary_url = carbon_get_the_post_meta('cta_primary_url');
$cta_primary_text = carbon_get_the_post_meta('cta_primary_text');
$cta_secondary_url = carbon_get_the_post_meta('cta_secondary_url');
$cta_secondary_text = carbon_get_the_post_meta('cta_secondary_text');

if (!is_array($gallery_ids) || empty($gallery_ids)) {
  return;
}


$post_id = get_the_ID();
$block_id = 'product-gallery-' . uniqid();
$gallery_bg_color = carbon_get_the_post_meta('gallery_background_color');
$gallery_max_width = carbon_get_the_post_meta('gallery_max_width') ?: 'max-w-5xl';
?>

<section   class="product-gallery <?php echo $gallery_bg_color ? '' : 'bg-neutral-900'; ?> text-white px-4 py-6 sm:py-8 lg:py-10" <?php echo $gallery_bg_color ? 'style="background-color: ' . esc_attr($gallery_bg_color) . ';"' : ''; ?>>
  <div class="text-center">
    <div class="flex flex-col items-center <?php echo esc_attr($gallery_max_width); ?> mx-auto">
      <div class="w-full max-w-3xl">
        <div class="swiper <?php echo esc_attr($block_id); ?>-main product-gallery-main rounded-xl ">
          <div class="swiper-wrapper">
            <?php foreach ($gallery_ids as $image_id): ?>
              <?php
              $image_url = wp_get_attachment_image_url($image_id, 'large');
              if (!$image_url) {
                continue;
              }
              $image_alt = trim(get_post_meta($image_id, '_wp_attachment_image_alt', true));
              if ($image_alt === '') {
                $image_alt = $product_title ? $product_title : get_the_title($post_id);
              }
              ?>
              <figure class="swiper-slide flex items-center justify-center">
                <img
                  src="<?php echo esc_url($image_url); ?>"
                  alt="<?php echo esc_attr($image_alt); ?>"
                  class="w-full h-auto object-cover rounded-xl"
                  loading="lazy"
                >
              </figure>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="mt-4 mx-auto">
          <div class="swiper <?php echo esc_attr($block_id); ?>-thumbs product-gallery-thumbs">
            <div class="swiper-wrapper">
              <?php foreach ($gallery_ids as $image_id): ?>
                <?php
                $thumb_url = wp_get_attachment_image_url($image_id, 'medium');
                if (!$thumb_url) {
                  continue;
                }
                $thumb_alt = trim(get_post_meta($image_id, '_wp_attachment_image_alt', true));
                if ($thumb_alt === '') {
                  $thumb_alt = $product_title ? $product_title : get_the_title($post_id);
                }
                ?>
                <button
                  type="button"
                  class="swiper-slide focus:outline-none group"
                >
                  <div class="h-20 sm:h-24 w-full rounded-lg border border-transparent flex items-center justify-center opacity-60 hover:opacity-100 transition-colors transition-opacity overflow-hidden group-[.swiper-slide-thumb-active]:border-blue-500 group-[.swiper-slide-thumb-active]:opacity-100">
                    <img
                      src="<?php echo esc_url($thumb_url); ?>"
                      alt="<?php echo esc_attr($thumb_alt); ?>"
                      class="w-full h-full object-cover rounded-lg"
                      loading="lazy"
                    >
                  </div>
                </button>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>

  
    </div>
  <div class="mb-6 sm:mt-12 text-center max-w-5xl mx-auto">
        <?php if ($product_title): ?> 
          <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold ">
            <?php echo esc_html($product_title); ?>
          </h2>
        <?php else: ?>
          <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold ">
            <?php the_title(); ?>
          </h2>
        <?php endif; ?>

        <?php if ($product_description): ?>
          <div class="mt-4 text-sm sm:text-base leading-relaxed text-neutral-200">
            <?php echo wp_kses_post($product_description); ?>
          </div>
        <?php endif; ?>

        <div class="mt-8 mx-auto flex flex-col sm:flex-row rounded-md items-center justify-center gap-4 sm:gap-5">
          <?php if ($cta_primary_url): ?>
            <a
              href="<?php echo esc_url($cta_primary_url); ?>"
              class="inline-flex items-center justify-center rounded-md bg-brand-accent hover:bg-brand-accent ring-brand-accent px-7 py-3 text-sm sm:text-base font-semibold text-white shadow-sm transition-colors focus-visible:outline-none "
            >
              <?php echo esc_html($cta_primary_text ?: __('View case', 'ace-theme')); ?>
            </a>
          <?php endif; ?>

          <?php if ($cta_secondary_url): ?>
            <a
              href="<?php echo esc_url($cta_secondary_url); ?>"
              class="inline-flex items-center justify-center rounded-md border border-white/40 bg-white text-xs sm:text-sm font-semibold text-neutral-900 px-6 py-3 shadow-sm transition-colors hover:bg-neutral-100 focus-visible:outline-none text-center"
            >
              <?php echo esc_html($cta_secondary_text ?: __('Ask For Samples Or Customized Solutions', 'ace-theme')); ?>
            </a>
          <?php endif; ?>
        </div>
      </div>
  </div>
</section>

