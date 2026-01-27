<?php
$full = !empty($fields['tf_full_width']);
$wrap = $full ? 'w-full px-6' : 'max-w-7xl mx-auto px-6 max-w-global';
$heading = isset($fields['tf_heading']) ? (string) $fields['tf_heading'] : '';
$desc = isset($fields['tf_description']) ? (string) $fields['tf_description'] : '';
$tabs = isset($fields['tf_tabs']) ? (array) $fields['tf_tabs'] : [];
$items = isset($fields['tf_items']) ? (array) $fields['tf_items'] : [];
if (empty($tabs)) { return; }
$by_tab = [];
foreach ($tabs as $t) {
  $label = isset($t['tab_label']) ? trim((string)$t['tab_label']) : '';
  if ($label === '') { continue; }
  $by_tab[$label] = [];
}
foreach ($items as $it) {
  $parent = isset($it['parent_tab']) ? trim((string)$it['parent_tab']) : '';
  if ($parent === '' || !isset($by_tab[$parent])) { continue; }
  $by_tab[$parent][] = $it;
}
$section_id = 'tabbed-faq-' . uniqid();
?>
<section id="<?php echo esc_attr($section_id); ?>" class="py-12 sm:py-16 md:py-20 bg-white">
  <div class="<?php echo esc_attr($wrap); ?> ace-tabbed-faq">
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

    <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-8 items-start">
      <nav class="space-y-3 md:col-span-1" aria-orientation="vertical">
        <?php $first = true; foreach ($by_tab as $label => $_): ?>
          <button type="button" data-faq-tab="<?php echo esc_attr($label); ?>" class="w-full text-left px-5 py-4 rounded-md border <?php echo $first ? 'bg-brand-accent text-white border-transparent' : 'bg-white text-gray-900 border-gray-200'; ?>">
            <span class="text-base sm:text-lg font-semibold"><?php echo esc_html($label); ?></span>
          </button>
          <?php $first = false; endforeach; ?>
      </nav>

      <div class="md:col-span-3">
        <?php $first = true; foreach ($by_tab as $label => $list): ?>
          <div data-faq-panel="<?php echo esc_attr($label); ?>" class="<?php echo $first ? '' : 'hidden'; ?>">
            <div class="divide-y divide-gray-200">
              <?php foreach ($list as $index => $it): ?>
                <?php
                  $q = isset($it['question']) ? (string)$it['question'] : '';
                  $a = isset($it['answer']) ? (string)$it['answer'] : '';
                  $row_id = $section_id . '-' . sanitize_title($label) . '-row-' . $index;
                ?>
                <article class="py-4">
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
                      <div class="text-gray-700 max-w-4xl text-base sm:text-lg leading-relaxed">
                        <?php echo apply_filters('the_content', $a); ?>
                      </div>
                    </div>
                  </div>
                </article>
              <?php endforeach; ?>
            </div>
          </div>
          <?php $first = false; endforeach; ?>
      </div>
    </div>
  </div>

  <script>
  (function(){
    var root = document.getElementById('<?php echo esc_js($section_id); ?>');
    if(!root) return;
    var tabs = Array.from(root.querySelectorAll('[data-faq-tab]'));
    var panels = Array.from(root.querySelectorAll('[data-faq-panel]'));
    var ACTIVE = 'bg-brand-accent text-white border-transparent';
    var INACTIVE = 'bg-white text-gray-900 border-gray-200';
    var show = function(id){
      panels.forEach(function(p){ p.classList.toggle('hidden', p.getAttribute('data-faq-panel') !== id); });
      tabs.forEach(function(b){
        var active = b.getAttribute('data-faq-tab') === id;
        if(active){
          ACTIVE.split(' ').forEach(function(c){ b.classList.add(c); });
          INACTIVE.split(' ').forEach(function(c){ b.classList.remove(c); });
        }else{
          INACTIVE.split(' ').forEach(function(c){ b.classList.add(c); });
          ACTIVE.split(' ').forEach(function(c){ b.classList.remove(c); });
        }
      });
    };
    if(tabs.length){ show(tabs[0].getAttribute('data-faq-tab')); }
    tabs.forEach(function(b){ b.addEventListener('click', function(){ show(b.getAttribute('data-faq-tab')); }); });

    // Accordion behavior per panel
    root.querySelectorAll('[data-faq-panel]').forEach(function(panel){
      panel.querySelectorAll('article').forEach(function(article){
        var btn = article.querySelector('button[data-faq-toggle]');
        var title = article.querySelector('h3');
        var icon = article.querySelector('[data-faq-icon]');
        if(!btn) return;
        btn.addEventListener('click', function(){
          var targetId = btn.getAttribute('aria-controls');
          var target = document.getElementById(targetId);
          if(!target) return;
          var expanded = btn.getAttribute('aria-expanded') === 'true';
          var isExpanding = !expanded;
          btn.setAttribute('aria-expanded', isExpanding ? 'true' : 'false');
          if(icon){ icon.style.transform = isExpanding ? 'rotate(45deg)' : 'rotate(0deg)'; }
          if(isExpanding){
            target.style.maxHeight = target.scrollHeight + 'px';
            target.style.opacity = '1';
          }else{
            target.style.maxHeight = '0';
            target.style.opacity = '0';
          }
        });
        if(title){
          title.setAttribute('role','button');
          title.setAttribute('tabindex','0');
          title.addEventListener('click', function(){ btn.click(); });
          title.addEventListener('keydown', function(e){
            if(e.key === 'Enter' || e.key === ' '){ e.preventDefault(); btn.click(); }
          });
        }
      });
    });
  })();
  </script>
</section>
