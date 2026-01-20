<?php
$hide = function_exists('carbon_get_the_post_meta') ? carbon_get_the_post_meta('home_industry_tabs_hide') : false;
if ($hide) { return; }
$full = function_exists('carbon_get_the_post_meta') ? carbon_get_the_post_meta('home_industry_tabs_full_width') : false;
$wrap = $full ? 'w-full px-6' : 'max-w-7xl mx-auto px-6 max-w-global';
$heading = function_exists('carbon_get_the_post_meta') ? (string) carbon_get_the_post_meta('home_industry_tabs_heading') : '';
$subheading = function_exists('carbon_get_the_post_meta') ? (string) carbon_get_the_post_meta('home_industry_tabs_subheading') : '';
$items = function_exists('carbon_get_the_post_meta') ? carbon_get_the_post_meta('home_industry_tabs_items') : [];
if (empty($items) || !is_array($items)) { return; }
$section_id = 'home-industry-tabs-' . uniqid();
?>
<section id="<?php echo esc_attr($section_id); ?>" class="py-12 sm:py-16 md:py-20 bg-white">
  <div class="<?php echo esc_attr($wrap); ?>">
    <header class="text-center max-w-4xl mx-auto mb-8 sm:mb-10">
      <?php if ($heading !== ''): ?>
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-semibold text-gray-900"><?php echo esc_html($heading); ?></h2>
      <?php endif; ?>
      <?php if ($subheading !== ''): ?>
        <div class="mt-3 text-sm sm:text-base text-gray-500"><?php echo wp_kses_post($subheading); ?></div>
      <?php endif; ?>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 items-start">
      <nav class="space-y-4" role="tablist" aria-orientation="vertical" id="<?php echo esc_attr($section_id); ?>-tabs">
        <?php foreach ($items as $index => $it): ?>
          <?php
            $title = isset($it['title']) ? (string) $it['title'] : '';
            $desc  = isset($it['description']) ? (string) $it['description'] : '';
            $icon  = isset($it['icon']) ? intval($it['icon']) : 0;
            $active = $index === 0;
          ?>
          <div data-card="<?php echo esc_attr($index); ?>" class="rounded-md border <?php echo $active ? 'bg-brand-accent text-white border-transparent' : 'bg-white border-gray-200'; ?>">
            <button type="button" data-tab="<?php echo esc_attr($index); ?>" class="w-full text-left px-5 py-4 flex items-center justify-between focus:outline-none">
              <span class="text-base sm:text-lg font-semibold"><?php echo esc_html($title); ?></span>
              <span class="ml-4 inline-flex h-8 w-8 items-center justify-center rounded-full <?php echo $active ? 'bg-white text-brand-accent' : 'bg-gray-100 text-gray-500'; ?>">
                <?php
                  if ($icon) {
                    echo wp_get_attachment_image($icon, 'thumbnail', false, ['class' => 'h-5 w-5 object-contain']);
                  } else {
                    echo '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13 3L4 14h6l-1 7 9-11h-6l1-7z"/></svg>';
                  }
                ?>
              </span>
            </button>
            <div class="overflow-hidden transition-all duration-300 ease-out" data-content="<?php echo esc_attr($index); ?>" style="max-height: 0px; opacity: 0;">
              <div class="px-5 pb-5">
                <div class="<?php echo $active ? 'text-white/90' : 'text-gray-700'; ?> text-sm sm:text-base leading-relaxed">
                  <?php echo wp_kses_post($desc); ?>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </nav>

      <div class="relative rounded-md overflow-hidden min-h-[220px] sm:min-h-[280px] md:min-h-[380px]" id="<?php echo esc_attr($section_id); ?>-images">
        <?php foreach ($items as $index => $it): ?>
          <?php $image = isset($it['image']) ? intval($it['image']) : 0; $active = $index === 0; ?>
          <figure data-image="<?php echo esc_attr($index); ?>" class="absolute inset-0 <?php echo $active ? 'opacity-100' : 'opacity-0'; ?> transition-opacity duration-300">
            <?php
              if ($image) {
                echo wp_get_attachment_image($image, 'large', false, ['class' => 'w-full h-full object-cover']);
              } else {
                echo '<div class="w-full h-full bg-gray-200"></div>';
              }
            ?>
          </figure>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <script>
  (function(){
    var section = document.getElementById('<?php echo esc_js($section_id); ?>');
    if(!section){return;}
    var buttons = section.querySelectorAll('button[data-tab]');
    var cards   = section.querySelectorAll('[data-card]');
    var contents = section.querySelectorAll('[data-content]');
    var images  = document.getElementById('<?php echo esc_js($section_id); ?>-images').querySelectorAll('[data-image]');
    function setActive(i){
      cards.forEach(function(c){
        var is = parseInt(c.getAttribute('data-card'),10) === i;
        c.classList.toggle('bg-brand-accent', is);
        c.classList.toggle('text-white', is);
        c.classList.toggle('border-transparent', is);
        c.classList.toggle('bg-white', !is);
        c.classList.toggle('text-gray-900', !is);
        c.classList.toggle('border-gray-200', !is);
        var iconWrap = c.querySelector('span.rounded-full');
        if(iconWrap){
          iconWrap.classList.toggle('bg-white', is);
          iconWrap.classList.toggle('text-brand-accent', is);
          iconWrap.classList.toggle('bg-gray-100', !is);
          iconWrap.classList.toggle('text-gray-500', !is);
        }
      });
      contents.forEach(function(ct){
        var is = parseInt(ct.getAttribute('data-content'),10) === i;
        if(is){
           ct.style.opacity = '1';
           ct.style.maxHeight = ct.scrollHeight + 'px';
        } else {
           ct.style.opacity = '0';
           ct.style.maxHeight = '0px';
        }
        
        // Update text color of the inner div
        var innerText = ct.querySelector('.text-sm');
        if(innerText){
          innerText.classList.toggle('text-white/90', is);
          innerText.classList.toggle('text-gray-700', !is);
        }
      });
      images.forEach(function(img){
        var is = parseInt(img.getAttribute('data-image'),10) === i;
        img.classList.toggle('opacity-100', is);
        img.classList.toggle('opacity-0', !is);
      });
    }
    
    // Initialize first tab
    // We can just call setActive(0) but we want to avoid transition on load if possible, 
    // or just let it run. Calling setActive(0) is cleanest.
    setActive(0);
    
    buttons.forEach(function(btn){
      btn.addEventListener('click', function(){
        var i = parseInt(btn.getAttribute('data-tab'),10);
        setActive(i);
      });
    });
  })();
  </script>
</section>