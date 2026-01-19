
<?php
$desc       = function_exists('carbon_get_theme_option') ? carbon_get_theme_option('footer_description') : '';
$socials    = function_exists('carbon_get_theme_option') ? carbon_get_theme_option('footer_socials') : [];
$prod_title = function_exists('carbon_get_theme_option') ? carbon_get_theme_option('footer_products_heading') : 'Products List';
$contact_t  = function_exists('carbon_get_theme_option') ? carbon_get_theme_option('footer_contact_heading') : 'Contact Us';
$phone      = function_exists('carbon_get_theme_option') ? carbon_get_theme_option('footer_phone') : '';
$tel        = function_exists('carbon_get_theme_option') ? carbon_get_theme_option('footer_tel') : '';
$email      = function_exists('carbon_get_theme_option') ? carbon_get_theme_option('footer_email') : '';
$whatsapp   = function_exists('carbon_get_theme_option') ? carbon_get_theme_option('footer_whatsapp') : '';
$address    = function_exists('carbon_get_theme_option') ? carbon_get_theme_option('footer_address') : '';
$copyright  = function_exists('carbon_get_theme_option') ? carbon_get_theme_option('footer_copyright') : '';
$additional_info = function_exists('carbon_get_theme_option') ? carbon_get_theme_option('additional_info') : '';
?>
<?php get_template_part('template-parts/global/contact-form'); ?>
<?php get_template_part('template-parts/global/email-capture'); ?>


<footer class="bg-white border-t border-gray-200">
  <div class="max-w-7xl mx-auto px-6 max-w-global py-10">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <div>
        <div class="flex items-center">
          <?php if (function_exists('the_custom_logo') && has_custom_logo()) : ?>
            <?php the_custom_logo(); ?>
          <?php else : ?>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-2xl font-bold  text-red-600">
              <?php bloginfo('name'); ?>
            </a>
          <?php endif; ?>
        </div>

         <?php if ($desc): ?>
          <div class="mt-4 text-gray-700 max-w-md">
             <?php echo wp_kses_post($desc); ?>
          </div>
        <?php endif; ?>
 
        <?php if (is_array($socials) && !empty($socials)) : ?>
          <div class="mt-6 flex items-center gap-4">
            <?php foreach ($socials as $s): ?>
              <?php
                $net = isset($s['network']) ? $s['network'] : '';
                $url = isset($s['url']) ? $s['url'] : '';
              ?>
              <?php if (!empty($url)) : ?>
                <a href="<?php echo esc_url($url); ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-md text-gray-900 hover:bg-gray-50" target="_blank" rel="noopener">
                  <?php if ($net === 'facebook') : ?>
                    <svg viewBox="0 0 24 24" class="w-6 h-6" fill="currentColor" aria-hidden="true">
                      <path d="M22 12.06C22 6.48 17.52 2 11.94 2S2 6.48 2 12.06c0 5 3.66 9.14 8.44 9.95v-7.03H8.42v-2.92h2.02V9.84c0-2 1.2-3.11 3.03-3.11.88 0 1.81.16 1.81.16v1.99h-1.02c-1 0-1.31.63-1.31 1.28v1.54h2.23l-.36 2.92h-1.87v7.03C18.34 21.2 22 17.06 22 12.06z"></path>
                    </svg>
                  <?php elseif ($net === 'twitter') : ?>
                    <svg viewBox="0 0 24 24" class="w-6 h-6" fill="currentColor" aria-hidden="true">
                      <path d="M22.46 6c-.77.35-1.6.58-2.46.69a4.27 4.27 0 0 0 1.87-2.36 8.49 8.49 0 0 1-2.7 1.03A4.23 4.23 0 0 0 12 8.23c0 .33.04.65.11.96A12 12 0 0 1 3.15 5.1a4.23 4.23 0 0 0 1.31 5.64c-.67-.02-1.3-.21-1.85-.51v.05a4.23 4.23 0 0 0 3.39 4.15c-.32.09-.66.13-1 .13-.24 0-.48-.02-.71-.07a4.24 4.24 0 0 0 3.95 2.93A8.49 8.49 0 0 1 2 19.54a12 12 0 0 0 6.49 1.9c7.79 0 12.05-6.46 12.05-12.06l-.01-.55A8.6 8.6 0 0 0 24 6.5a8.38 8.38 0 0 1-2.54.7Z"></path>
                    </svg>
                  <?php elseif ($net === 'youtube') : ?>
                    <svg viewBox="0 0 24 24" class="w-6 h-6" fill="currentColor" aria-hidden="true">
                      <rect x="3" y="5" width="18" height="14" rx="3"></rect>
                      <path d="M10 9l5 3-5 3V9z"></path>
                    </svg>
                  <?php elseif ($net === 'instagram') : ?>
                    <svg viewBox="0 0 24 24" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                      <rect x="3" y="3" width="18" height="18" rx="5"></rect>
                      <circle cx="12" cy="12" r="4"></circle>
                      <circle cx="17.5" cy="6.5" r="1.5" fill="currentColor" stroke="none"></circle>
                    </svg>
                  <?php elseif ($net === 'linkedin') : ?>
                    <svg viewBox="0 0 24 24" class="w-6 h-6" fill="currentColor" aria-hidden="true">
                      <rect x="4" y="9" width="3" height="11" rx="0.5"></rect>
                      <circle cx="5.5" cy="6" r="1.5"></circle>
                      <path d="M10 9h3v1.5c.7-1 1.7-1.7 3.2-1.7 2.5 0 4.3 1.7 4.3 4.7V20h-3v-5c0-1.6-.9-2.6-2.2-2.6s-2.3 1-2.3 2.6V20h-3V9z"></path>
                    </svg>
                  <?php else : ?>
                    <svg viewBox="0 0 24 24" class="w-6 h-6" fill="currentColor" aria-hidden="true">
                      <path d="M12 17.27L18.18 21 16.54 13.97 22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21z"></path>
                    </svg>
                  <?php endif; ?>
                  <span class="sr-only"><?php echo esc_html(ucfirst($net)); ?></span>
                </a>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
        <div>
          <h3 class="text-lg font-semibold text-gray-900">
            <?php echo esc_html($prod_title); ?>
          </h3>
          <?php
            $product_menu_id = function_exists('carbon_get_theme_option') ? carbon_get_theme_option('footer_products_menu') : '';
            $menu_args = [
              'container'     => false,
              'fallback_cb'   => '__return_empty_string',
              'menu_class'    => 'mt-4 space-y-2',
              'items_wrap'    => '<ul class="%2$s">%3$s</ul>',
              'link_before'   => '',
              'link_after'    => '',
            ];

            if ( ! empty( $product_menu_id ) ) {
              $menu_args['menu'] = $product_menu_id;
            } else {
              $menu_args['theme_location'] = 'footer-products';
            }

            wp_nav_menu( $menu_args );
          ?>
        </div>
        <div>
          <h3 class="text-lg font-semibold text-gray-900">
            <?php echo esc_html($contact_t); ?>
          </h3>
          <ul class="mt-4 space-y-2 text-gray-800">
            <?php if (!empty($phone)) : ?>
              <li>Phone: <?php echo esc_html($phone); ?></li>
            <?php endif; ?>
            <?php if (!empty($tel)) : ?>
              <li>Tel: <?php echo esc_html($tel); ?></li>
            <?php endif; ?>
            <?php if (!empty($email)) : ?>
              <li>E-mail: <?php echo esc_html($email); ?></li>
            <?php endif; ?>
            <?php if (!empty($whatsapp)) : ?>
              <li>Whatsapp: <?php echo esc_html($whatsapp); ?></li>
            <?php endif; ?>
            <?php if (!empty($address)) : ?>
              <li>Add: <?php echo esc_html($address); ?></li>
            <?php endif; ?>
          </ul>
            <?php if ($additional_info): ?>
          <div class="mt-4 text-sm sm:text-base">
            <?php echo wp_kses_post($additional_info); ?>
          </div>
        <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="mt-10 border-t border-gray-200 pt-6">
      <p class="text-sm text-gray-600">
        <?php echo esc_html($copyright); ?>
      </p>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

