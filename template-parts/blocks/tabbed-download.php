<?php
$full = !empty($fields['td_full_width']);
$wrap = $full ? 'w-full px-6' : 'max-w-7xl mx-auto px-6 max-w-global';
$heading = isset($fields['td_heading']) ? (string) $fields['td_heading'] : '';
$desc = isset($fields['td_description']) ? (string) $fields['td_description'] : '';
$tabs = isset($fields['td_tabs']) ? (array) $fields['td_tabs'] : [];
$items = isset($fields['td_items']) ? (array) $fields['td_items'] : [];
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
$section_id = 'tabbed-download-' . uniqid();
?>
<section id="<?php echo esc_attr($section_id); ?>" class="py-12 sm:py-16 md:py-20 bg-white">
  <div class="<?php echo esc_attr($wrap); ?> ace-tabbed-download">
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

    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
      <nav class="space-y-3 md:col-span-1" aria-orientation="vertical">
        <?php $first = true; foreach ($by_tab as $label => $_): ?>
          <button type="button" data-td-tab="<?php echo esc_attr($label); ?>" class="w-full text-left px-5 py-4 rounded-md border <?php echo $first ? 'bg-brand-accent text-white border-transparent' : 'bg-white text-gray-900 '; ?>">
            <span class="text-base sm:text-lg font-semibold"><?php echo esc_html($label); ?></span>
          </button>
          <?php $first = false; endforeach; ?>
      </nav>

      <div class="md:col-span-2">
        <?php $first = true; foreach ($by_tab as $label => $list): ?>
          <div data-td-panel="<?php echo esc_attr($label); ?>" class="<?php echo $first ? '' : 'hidden'; ?>">
            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
              <?php foreach ($list as $it): ?>
                <?php
                  $cover = isset($it['cover']) ? intval($it['cover']) : 0;
                  $title = isset($it['title']) ? (string)$it['title'] : '';
                  $dlimg = isset($it['download_image']) ? intval($it['download_image']) : 0;
                  $link = isset($it['download_link']) ? (string)$it['download_link'] : '';
                  $href = $link !== '' ? $link : ($dlimg ? wp_get_attachment_url($dlimg) : '');
                  $is_download = $link === '' && !empty($href);
                ?>
                <a <?php echo $href ? 'href="'.esc_url($href).'"' : ''; ?><?php echo $is_download ? ' download' : ''; ?> class="block overflow-hidden  bg-white  hover:shadow-md transition">
                  <div class="aspect-[4/3] bg-gray-100 flex items-center justify-center">
                    <?php
                      if ($cover) {
                        echo wp_get_attachment_image($cover, 'large', false, ['class' => 'w-full h-full object-cover']);
                      } else {
                        echo '<div class="w-full h-full bg-gray-200"></div>';
                      }
                    ?>
                  </div>
                  <?php if ($title !== ''): ?>
                    <div class="px-3 py-2 text-sm text-gray-800"><?php echo esc_html($title); ?></div>
                  <?php endif; ?>
                </a>
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
    var tabs = Array.from(root.querySelectorAll('[data-td-tab]'));
    var panels = Array.from(root.querySelectorAll('[data-td-panel]'));
    var ACTIVE = 'bg-brand-accent text-white border-transparent';
    var INACTIVE = 'bg-white text-gray-900 border-gray-200';
    var show = function(id){
      panels.forEach(function(p){ p.classList.toggle('hidden', p.getAttribute('data-td-panel') !== id); });
      tabs.forEach(function(b){
        var active = b.getAttribute('data-td-tab') === id;
        if(active){
          ACTIVE.split(' ').forEach(function(c){ b.classList.add(c); });
          INACTIVE.split(' ').forEach(function(c){ b.classList.remove(c); });
        }else{
          INACTIVE.split(' ').forEach(function(c){ b.classList.add(c); });
          ACTIVE.split(' ').forEach(function(c){ b.classList.remove(c); });
        }
      });
    };
    if(tabs.length){ show(tabs[0].getAttribute('data-td-tab')); }
    tabs.forEach(function(b){ b.addEventListener('click', function(){ show(b.getAttribute('data-td-tab')); }); });
  })();
  </script>
</section>
