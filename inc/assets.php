<?php
function ace_assets() {
  // Enqueue Tailwind CSS with filemtime for cache busting
  $css_file = get_template_directory() . '/assets/css/style.css';
  $css_version = file_exists($css_file) ? filemtime($css_file) : '1.0.0';
  
  wp_enqueue_style('ace-style', get_template_directory_uri() . '/assets/css/style.css', [], $css_version);
  
  if (function_exists('carbon_get_theme_option')) {
    $gf = carbon_get_theme_option('global_google_fonts_url');
    if (!empty($gf)) {
      wp_enqueue_style('ace-google-fonts', esc_url($gf), [], null);
    }
    $primary   = carbon_get_theme_option('global_color_primary') ?: '#e11d48';
    $secondary = carbon_get_theme_option('global_color_secondary') ?: '#111827';
    $accent    = carbon_get_theme_option('global_color_accent') ?: '#2563eb';
    $bodySel   = carbon_get_theme_option('global_body_font') ?: 'system-ui';
    $headSel   = carbon_get_theme_option('global_heading_font') ?: 'inter';
    $bodyTrack = carbon_get_theme_option('global_body_letter_spacing') ?: '0';
    $headTrack = carbon_get_theme_option('global_heading_letter_spacing') ?: '-0.01em';
    $bodyFont  = function_exists('ace_get_font_stack') ? ace_get_font_stack($bodySel) : $bodySel;
    $headFont  = function_exists('ace_get_font_stack') ? ace_get_font_stack($headSel) : $headSel;
    $baseSize  = carbon_get_theme_option('global_base_font_size') ?: '16px';
  $containerW = carbon_get_theme_option('global_container_width') ?: '1200';

  $inline = ":root{--brand-primary:{$primary};--brand-secondary:{$secondary};--brand-accent:{$accent};--font-body:{$bodyFont};--font-heading:{$headFont};--base-font-size:{$baseSize};--letter-spacing-body:{$bodyTrack};--letter-spacing-heading:{$headTrack};--container-max-width:{$containerW}px;}
    body{font-family:var(--font-body);font-size:var(--base-font-size);letter-spacing:var(--letter-spacing-body);}
    h1,h2,h3,h4,h5,h6{font-family:var(--font-heading);letter-spacing:var(--letter-spacing-heading);}
    .text-brand-primary{color:var(--brand-primary)!important;}
    .bg-brand-primary{background-color:var(--brand-primary)!important;}
    .border-brand-primary{border-color:var(--brand-primary)!important;}
    .text-brand-accent{color:var(--brand-accent)!important;}
    .bg-brand-accent{background-color:var(--brand-accent)!important;}
    .hover\\:bg-brand-accent:hover{background-color:var(--brand-accent)!important;}
    .ring-brand-accent{--tw-ring-color:var(--brand-accent)!important;}
    .bg-brand-secondary{background-color:var(--brand-secondary);}
    .max-w-global{max-width:var(--container-max-width)!important;}";
  wp_add_inline_style('ace-style', $inline);
  }
  
  wp_enqueue_style('swiper', 'https://unpkg.com/swiper@11/swiper-bundle.min.css', [], '11');

  wp_enqueue_script('swiper', 'https://unpkg.com/swiper@11/swiper-bundle.min.js', [], '11', true);
  wp_enqueue_script('ace-main', get_template_directory_uri() . '/assets/js/main.js', [], null, true);
  
  $gallery_js = get_template_directory() . '/assets/js/swiper/product-gallery.js';
  $gallery_ver = file_exists($gallery_js) ? filemtime($gallery_js) : '1.0.0';
  wp_enqueue_script('ace-product-gallery', get_template_directory_uri() . '/assets/js/swiper/product-gallery.js', ['swiper'], $gallery_ver, true);
  
  $qnav_js = get_template_directory() . '/assets/js/modules/quick-product-nav.js';
  $qnav_ver = file_exists($qnav_js) ? filemtime($qnav_js) : '1.0.0';
  wp_enqueue_script('ace-quick-product-nav', get_template_directory_uri() . '/assets/js/modules/quick-product-nav.js', [], $qnav_ver, true);
  
  $sticky_js = get_template_directory() . '/assets/js/modules/sticky-header.js';
  $sticky_ver = file_exists($sticky_js) ? filemtime($sticky_js) : '1.0.0';
  wp_enqueue_script('ace-sticky-header', get_template_directory_uri() . '/assets/js/modules/sticky-header.js', [], $sticky_ver, true);

  $user_menu_js = get_template_directory() . '/assets/js/modules/user-menu.js';
  $user_menu_ver = file_exists($user_menu_js) ? filemtime($user_menu_js) : '1.0.0';
  wp_enqueue_script('ace-user-menu', get_template_directory_uri() . '/assets/js/modules/user-menu.js', [], $user_menu_ver, true);
}
add_action('wp_enqueue_scripts', 'ace_assets');

/**
 * Add custom styles to WordPress Admin
 */
function ace_admin_styles() {
  ?>
  <style>
    /* 
     * Target Carbon Fields Meta Boxes in Gutenberg
     * ID format is usually #carbon_fields_container_{slug}
     */
    .edit-post-layout__metaboxes {
      /* Ensure the metabox area itself allows centering */
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .handle-order-higher,.handle-order-lower{
      display:none!important;
    }
    /* Target specific Carbon Fields containers */
    .carbon-box {
      width: 100%;
       min-width:1000px;
      /*
      max-width: 1000px;  
     
      margin: 20px 0 !important;
     */
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      background: #fff;
    }

    /* Adjust the inner padding to look more like a block */
    .carbon-box .postbox-header
    {
      background: #f9fafb;
      border-bottom: 1px solid #e5e7eb;
      border-radius: 8px 8px 0 0;
    }
  .carbon-box .postbox-header h2{
    padding-left:12px; font-size:16px!important;
  }
    /* Remove blue circle around toggle arrow */
    .carbon-box .handlediv {
      background: transparent !important;
      border: 0 !important;
      border-radius: 0 !important;
      box-shadow: none !important;
    }
    .carbon-box .handlediv:focus,
    .carbon-box .handlediv:hover,
    .carbon-box .handlediv:active {
      outline: none !important;
      box-shadow: none !important;
    }
    .carbon-box .handlediv .toggle-indicator:before {
      box-shadow: none !important;
    }

    /* Reduce the height of the main Gutenberg editor area */
    .block-editor-writing-flow {
     /* min-height: 40vh !important;
      padding-bottom: 20px;*/
    }
    
    /* Ensure the editor canvas doesn't force full height */
    .edit-post-visual-editor,
    .editor-styles-wrapper {
     /* min-height: auto !important;
      height: auto !important;
      max-height:80vh!important;
      */
    }
   .components-resizable-box__container .cf-file__inner{
      width:500px!important; height:500px!important;
    }
    .block-editor-block-list__block{
       
    }
  </style>
  <?php
}
add_action('admin_head', 'ace_admin_styles');

function ace_lock_carbon_metabox_order() {
  ?>
  <style>
    .postbox .hndle { cursor: default !important; }
  </style>
  <script>
    (function($){
      function killSortable(){
        $('.meta-box-sortables, #normal-sortables, #side-sortables, #advanced-sortables, .edit-post-layout__metaboxes').each(function(){
          var $el = $(this);
          try { if ($el.sortable('instance')) { $el.sortable('disable'); $el.sortable('destroy'); } } catch(e){}
        });
        $(document)
          .off('mousedown.aceNoDrag', '.postbox .hndle')
          .on('mousedown.aceNoDrag', '.postbox .hndle', function(e){
            e.preventDefault();
            e.stopImmediatePropagation();
          });
      }
      killSortable();
      $(window).on('load', killSortable);
      $(document).on('ajaxComplete', killSortable);
      if (window.wp && wp.data && wp.data.subscribe) { wp.data.subscribe(killSortable); }
      setInterval(killSortable, 1000);
    })(jQuery);
  </script>
  <?php
}

 
// add_action('admin_footer', 'ace_lock_carbon_metabox_order'); // disabled per request

/* disabled: reorder Carbon Fields meta boxes in Gutenberg */
function ace_order_product_metaboxes() {
  ?>
  <script>
    (function($){
      var order = [
        '#carbon_fields_container_product_gallery_info',
        '#carbon_fields_container_video_module',
        '#carbon_fields_container_product_features',
        '#carbon_fields_container_product_applications',
        '#carbon_fields_container_featured_part',
        '#carbon_fields_container_product_specs',
        '#carbon_fields_container_media_carousel'
      ];
      function reorder(){
        var area = document.querySelector('.edit-post-layout__metaboxes');
        if (!area) return;
        order.forEach(function(sel){
          var el = document.querySelector(sel);
          if (el) area.appendChild(el);
        });
      }
      reorder();
      $(window).on('load', reorder);
      $(document).on('ajaxComplete', reorder);
      if (window.wp && wp.data && wp.data.subscribe) { wp.data.subscribe(reorder); }
      setInterval(reorder, 1000);
    })(jQuery);
  </script>
  <?php
}
// add_action('admin_footer', 'ace_order_product_metaboxes'); // disabled per request

function ace_disable_metabox_drag() {
  ?>
  <script>
  jQuery(function($){
    var $areas = $('#normal-sortables, #side-sortables, #advanced-sortables, .edit-post-layout__metaboxes');
    $areas.each(function(){
      var $el = $(this);
      if ($el.data('uiSortable')) {
        try { $el.sortable('disable'); } catch(e){}
      }
    });
    $('.postbox .hndle').css('cursor','default');
  });
  </script>
  <?php
}
// add_action('admin_footer', 'ace_disable_metabox_drag');

