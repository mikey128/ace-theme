<?php
$hide_section = carbon_get_the_post_meta('home_featured_products_hide');
if ($hide_section) { return; }
$items = carbon_get_the_post_meta('home_featured_products_items');
// Removed early return: allow dynamic products via association even when manual items are empty
$full_width = carbon_get_the_post_meta('home_featured_products_full_width');
$wrapper_classes = $full_width ? 'w-full px-6' : 'max-w-7xl mx-auto px-6 max-w-global';
$section_id = 'home-featured-products-' . uniqid();
$heading = (string) carbon_get_the_post_meta('home_featured_products_heading');
$subheading = (string) carbon_get_the_post_meta('home_featured_products_subheading');
$cols = (int) carbon_get_the_post_meta('home_featured_products_columns');
if ($cols < 2 || $cols > 4) { $cols = 3; }
$grid_class = $cols === 2 ? 'md:grid-cols-2' : ($cols === 4 ? 'md:grid-cols-4' : 'md:grid-cols-3');
$selected = carbon_get_the_post_meta('home_featured_products_selected');
$message_title = (string) carbon_get_the_post_meta('home_featured_message_title');
$message_desc = (string) carbon_get_the_post_meta('home_featured_message_description');
$message_btn_text = (string) carbon_get_the_post_meta('home_featured_message_button_text');
$message_btn_link = (string) carbon_get_the_post_meta('home_featured_message_button_link');
?>
<section id="<?php echo esc_attr($section_id); ?>" class="py-12 sm:py-16 lg:py-20 bg-white">
  <div class="<?php echo esc_attr($wrapper_classes); ?>">
    <?php if ($heading !== ''): ?>
      <header class="max-w-4xl mx-auto text-center mb-8 sm:mb-10 lg:mb-12">
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-neutral-900"><?php echo esc_html($heading); ?></h2>
        <?php if ($subheading !== ''): ?>
          <div class="mt-3 sm:mt-4 lg:mt-5 text-neutral-600 text-sm sm:text-base leading-relaxed">
            <?php echo wp_kses_post($subheading); ?>
          </div>
        <?php endif; ?>
      </header>
    <?php endif; ?>
    <div class="grid grid-cols-1 <?php echo esc_attr($grid_class); ?> gap-6 sm:gap-7 lg:gap-8">
      <?php
        $product_ids = is_array($selected) ? array_values(array_filter(array_map(function($it){
          return isset($it['id']) ? intval($it['id']) : 0;
        }, $selected))) : [];
      ?>
      <?php if (!empty($product_ids)): ?>
        <?php foreach ($product_ids as $pid): ?>
          <?php
            $img_url = get_the_post_thumbnail_url($pid, 'large');
            $title = get_the_title($pid);
            $link = get_permalink($pid);
            $desc = (string) carbon_get_post_meta($pid, 'product_short_description');
            if ($desc === '') {
              $excerpt = get_the_excerpt($pid);
              if (!empty($excerpt)) {
                $desc = $excerpt;
              } else {
                $desc = wp_trim_words(wp_strip_all_tags(get_post_field('post_content', $pid)), 24, '…');
              }
            }
            $thumbs = carbon_get_post_meta($pid, 'gallery_images');
            $thumbs = is_array($thumbs) ? $thumbs : [];
          ?>
          <article class="rounded-sm bg-brand-secondary hover:bg-gray-100 transition-colors duration-300 shadow-sm p-5 sm:p-6">
            <figure class="w-full">
              <?php if ($img_url): ?>
                <a href="<?php echo esc_url($link); ?>" class="block">
                  <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($title); ?>" class="w-full h-44 sm:h-52 lg:h-60 object-contain" />
                </a>
              <?php endif; ?>
            </figure>
            <?php if (!empty($thumbs)): ?>
              <div class="mt-3 -mx-3 px-3 sm:hidden overflow-x-auto">
                <div class="flex gap-3">
                  <?php foreach ($thumbs as $tid): ?>
                    <?php $tu = wp_get_attachment_image_url(intval($tid), 'thumbnail'); ?>
                    <?php if ($tu): ?>
                      <img src="<?php echo esc_url($tu); ?>" alt="" class="h-14 w-14 object-cover rounded-lg flex-shrink-0" />
                    <?php endif; ?>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php endif; ?>
            <div class="mt-4 text-center">
              <?php if ($title !== ''): ?>
                <h3 class="text-base sm:text-lg font-bold text-neutral-900">
                  <a href="<?php echo esc_url($link); ?>" class="hover:text-brand-accent transition-colors">
                    <?php echo esc_html($title); ?>
                  </a>
                </h3>
              <?php endif; ?>
              <?php if ($desc !== ''): ?>
                <p class="mt-2 text-sm sm:text-base text-neutral-600"><?php echo wp_kses_post($desc); ?></p>
              <?php endif; ?>
            </div>
          </article>
        <?php endforeach; ?>
      <?php else: ?>
        <?php
          $q = new WP_Query([
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => 6,
            'orderby' => 'date',
            'order' => 'DESC',
          ]);
        ?>
        <?php if ($q->have_posts()): ?>
          <?php while ($q->have_posts()): $q->the_post(); ?>
            <?php
              $pid = get_the_ID();
              $img_url = get_the_post_thumbnail_url($pid, 'large');
              $title = get_the_title($pid);
              $link = get_permalink($pid);
              $desc = (string) carbon_get_post_meta($pid, 'product_short_description');
              if ($desc === '') {
                $excerpt = get_the_excerpt($pid);
                if (!empty($excerpt)) {
                  $desc = $excerpt;
                } else {
                  $desc = wp_trim_words(wp_strip_all_tags(get_post_field('post_content', $pid)), 24, '…');
                }
              }
              $thumbs = carbon_get_post_meta($pid, 'gallery_images');
              $thumbs = is_array($thumbs) ? $thumbs : [];
            ?>
            <article class="rounded-sm bg-brand-secondary hover:bg-gray-100 transition-colors duration-300 shadow-sm p-5 sm:p-6">
              <figure class="w-full">
                <?php if ($img_url): ?>
                  <a href="<?php echo esc_url($link); ?>" class="block">
                    <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($title); ?>" class="w-full h-44 sm:h-52 lg:h-60 object-contain" />
                  </a>
                <?php endif; ?>
              </figure>
              <?php if (!empty($thumbs)): ?>
                <div class="mt-3 -mx-3 px-3 sm:hidden overflow-x-auto">
                  <div class="flex gap-3">
                    <?php foreach ($thumbs as $tid): ?>
                      <?php $tu = wp_get_attachment_image_url(intval($tid), 'thumbnail'); ?>
                      <?php if ($tu): ?>
                        <img src="<?php echo esc_url($tu); ?>" alt="" class="h-14 w-14 object-cover rounded-lg flex-shrink-0" />
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </div>
                </div>
              <?php endif; ?>
              <div class="mt-4 text-center">
                <?php if ($title !== ''): ?>
                  <h3 class="text-base sm:text-lg font-bold text-neutral-900">
                    <a href="<?php echo esc_url($link); ?>" class="hover:text-brand-accent transition-colors">
                      <?php echo esc_html($title); ?>
                    </a>
                  </h3>
                <?php endif; ?>
                <?php if ($desc !== ''): ?>
                  <p class="mt-2 text-sm sm:text-base text-neutral-600"><?php echo wp_kses_post($desc); ?></p>
                <?php endif; ?>
              </div>
            </article>
          <?php endwhile; wp_reset_postdata(); ?>
        <?php endif; ?>
      <?php endif; ?>
      <?php if ($message_title !== '' || $message_desc !== '' || $message_btn_text !== ''): ?>
        <aside class="md:col-span-2  bg-brand-accent text-white py-6 px-12  flex flex-col justify-center">
          <div>
            <?php if ($message_title !== ''): ?>
              <h3 class="text-lg sm:text-xl lg:text-2xl font-bold"><?php echo esc_html($message_title); ?></h3>
            <?php endif; ?>
            <?php if ($message_desc !== ''): ?>
              <div class="mt-3 text-sm sm:text-base text-white/90 leading-relaxed">
                <?php echo wp_kses_post($message_desc); ?>
              </div>
            <?php endif; ?>
          </div>
          <?php if ($message_btn_text !== ''): ?>
            <div class="mt-5">
              <a href="<?php echo esc_url($message_btn_link); ?>" class="inline-flex items-center justify-center rounded-full bg-white px-5 py-3 text-sm font-semibold text-neutral-900 shadow-sm transition-colors hover:bg-neutral-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                <?php echo esc_html($message_btn_text); ?>
              </a>
            </div>
          <?php endif; ?>
        </aside>
      <?php endif; ?>
    </div>
  </div>
</section>
