<?php
if (! function_exists('carbon_get_the_post_meta')) { return; }

$hide = carbon_get_the_post_meta('faq_hide_section');
if ($hide === null || $hide === '') { $hide = carbon_get_the_post_meta('hide_section'); }
if ($hide) { return; }

$full = carbon_get_the_post_meta('faq_enable_full_width');
if ($full === null || $full === '') { $full = carbon_get_the_post_meta('enable_full_width'); }
$wrap = $full ? 'w-full px-6' : 'max-w-7xl mx-auto px-6 max-w-global';

$heading = carbon_get_the_post_meta('faq_heading');
$max_w   = carbon_get_the_post_meta('faq_max_width');
$items   = carbon_get_the_post_meta('faq_items');

if (empty($items) || !is_array($items)) { return; }

$allowed = ['3xl','4xl','5xl','6xl','7xl'];
$max_w   = in_array($max_w, $allowed, true) ? $max_w : '6xl';
$content_wrap = 'max-w-' . $max_w . ' mx-auto';

$section_id_input = (string) carbon_get_the_post_meta('faq_section_id');
$section_id = $section_id_input !== '' ? sanitize_title($section_id_input) : 'product-faq-' . get_the_ID();
?>
<section id="<?php echo esc_attr($section_id); ?>" class="py-12 sm:py-16 md:py-20 bg-white">
  <div class="<?php echo esc_attr($wrap); ?>">
    <?php if (!empty($heading)) : ?>
      <header class="<?php echo esc_attr($content_wrap); ?> text-center mb-8 sm:mb-10">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-semibold  text-gray-900">
          <?php echo esc_html($heading); ?>
        </h2>
      </header>
    <?php endif; ?>

    <div class="<?php echo esc_attr($content_wrap); ?> divide-y divide-gray-200">
      <?php foreach ($items as $index => $item): ?>
        <?php
          $q = isset($item['question']) ? $item['question'] : '';
          $a = isset($item['answer']) ? $item['answer'] : '';
          $row_id = $section_id . '-row-' . $index;
        ?>
        <article class="py-6 sm:py-8">
          <div class="flex items-start justify-between gap-6">
            <h3 class="text-md sm:text-xl font-semibold text-gray-900 cursor-pointer">
              <?php echo esc_html($q); ?>
            </h3>
            <button
              type="button"
              class="flex-shrink-0 inline-flex items-center justify-center w-9 h-9 text-gray-800 hover:bg-gray-50 transition-all duration-200"
              aria-controls="<?php echo esc_attr($row_id); ?>"
              aria-expanded="false"
              data-faq-toggle
            >
              <span class="text-4xl leading-none transition-transform duration-300 ease-in-out" data-faq-icon>+</span>
            </button>
          </div>
          <div 
            id="<?php echo esc_attr($row_id); ?>" 
            class="overflow-hidden transition-all duration-300 ease-in-out"
            style="max-height: 0; opacity: 0;"
            data-faq-content
          >
            <div class="mt-3">
              <p class="text-gray-700 max-w-4xl text-base sm:text-lg leading-relaxed">              
                  <?php echo wp_kses_post($a); ?>
              </p>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var section = document.getElementById('<?php echo esc_js($section_id); ?>');
      if (!section) return;
      section.querySelectorAll('article').forEach(function(article) {
        var btn = article.querySelector('button[data-faq-toggle]');
        var title = article.querySelector('h3');
        var icon = article.querySelector('[data-faq-icon]');
        if (!btn) return;
        
        btn.addEventListener('click', function() {
          var targetId = btn.getAttribute('aria-controls');
          var target = document.getElementById(targetId);
          if (!target) return;
          
          var expanded = btn.getAttribute('aria-expanded') === 'true';
          var isExpanding = !expanded;
          
          // Update aria-expanded
          btn.setAttribute('aria-expanded', isExpanding ? 'true' : 'false');
          
          // Rotate icon
          if (icon) {
            icon.style.transform = isExpanding ? 'rotate(45deg)' : 'rotate(0deg)';
          }
          
          if (isExpanding) {
            // Expand: set max-height to scrollHeight and opacity to 1
            target.style.maxHeight = target.scrollHeight + 'px';
            target.style.opacity = '1';
          } else {
            // Collapse: set max-height to 0 and opacity to 0
            target.style.maxHeight = '0';
            target.style.opacity = '0';
          }
        });
        
        if (title) {
          title.setAttribute('role', 'button');
          title.setAttribute('tabindex', '0');
          title.addEventListener('click', function() { btn.click(); });
          title.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
              e.preventDefault();
              btn.click();
            }
          });
        }
      });
    });
  </script>
</section>
