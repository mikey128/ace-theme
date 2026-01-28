<?php
$full = !empty($fields['rich_full_width']);
$wrap = $full ? 'w-full px-6' : 'max-w-7xl mx-auto px-6 max-w-global';
$heading = isset($fields['rich_heading']) ? (string) $fields['rich_heading'] : '';
$desc = isset($fields['rich_description']) ? (string) $fields['rich_description'] : '';
$image_id = isset($fields['rich_image']) ? intval($fields['rich_image']) : 0;
$btn_label = isset($fields['rich_button_label']) ? (string) $fields['rich_button_label'] : '';
$btn_link = isset($fields['rich_button_link']) ? (string) $fields['rich_button_link'] : '';
?>
<section class="py-12  md:py-12 bg-white">
  <div class="<?php echo esc_attr($wrap); ?>">
    <div class="text-center max-w-4xl mx-auto">
      <?php if ($heading !== ''): ?>
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-semibold text-gray-900"><?php echo esc_html($heading); ?></h2>
      <?php endif; ?>
      <?php if ($desc !== ''): ?>
        <div class="mt-4 text-gray-600 prose prose-lg mx-auto">
          <?php echo apply_filters('the_content', $desc); ?>
        </div>
      <?php endif; ?>
    </div>
   
      <?php if ($image_id): ?>
         <div class="mt-8 md:mt-10">
        <?php echo wp_get_attachment_image($image_id, 'full', false, ['class' => 'w-full h-auto rounded-md shadow-sm']); ?>
     
        
         </div>
      <?php endif; ?>
   
    <?php if ($btn_label !== '' && $btn_link !== ''): ?>
      <div class="mt-8 text-center">
        <a href="<?php echo esc_url($btn_link); ?>" class="inline-block px-6 py-3 bg-brand-accent text-white rounded-md hover:bg-brand-accent/90">
          <?php echo esc_html($btn_label); ?>
        </a>
      </div>
    <?php endif; ?>
  </div>
</section>
