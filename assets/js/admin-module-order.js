/**
 * Module Order - Drag & Drop Reordering for Carbon Fields Meta Boxes
 * Makes product module meta boxes sortable and saves order automatically
 */
(function($) {
  'use strict';

  // Module ID to key mapping
  const MODULE_MAP = {
    'carbon_fields_container_product_gallery_info': 'gallery',
    'carbon_fields_container_video_module': 'video',
    'carbon_fields_container_product_features': 'features',
    'carbon_fields_container_product_applications': 'applications',
    'carbon_fields_container_product_specs': 'specs',
    'carbon_fields_container_media_carousel': 'carousel'
  };

  /**
   * Initialize sortable functionality
   */
  function initModuleOrdering() {
    // Wait for DOM to be fully loaded
    if (!$('#poststuff').length) {
      setTimeout(initModuleOrdering, 100);
      return;
    }

    const $metaboxArea = $('#poststuff .metabox-holder');
    
    if (!$metaboxArea.length) {
      return;
    }

    // Make meta boxes sortable
    $metaboxArea.sortable({
      items: '.postbox.carbon-box',
      handle: '.postbox-header, .hndle',
      cursor: 'move',
      axis: 'y',
      tolerance: 'pointer',
      opacity: 0.8,
      placeholder: 'sortable-placeholder',
      forcePlaceholderSize: true,
      
      // Visual feedback on start
      start: function(event, ui) {
        ui.item.css('box-shadow', '0 10px 25px rgba(0, 0, 0, 0.2)');
        ui.placeholder.css({
          'background': '#e3f2fd',
          'border': '2px dashed #2196f3',
          'border-radius': '8px',
          'visibility': 'visible',
          'height': ui.item.outerHeight() + 'px'
        });
      },
      
      // Remove visual feedback on stop
      stop: function(event, ui) {
        ui.item.css('box-shadow', '');
      },
      
      // Update order when sorting stops
      update: function(event, ui) {
        updateModuleOrder();
      }
    });

    // Add visual indicator to meta box headers
    $('.postbox.carbon-box .postbox-header, .postbox.carbon-box .hndle').css({
      'cursor': 'move',
      'user-select': 'none'
    }).attr('title', 'Drag to reorder');

    // Add draggable icon to headers
    $('.postbox.carbon-box .postbox-header h2, .postbox.carbon-box .hndle').each(function() {
      if (!$(this).find('.dashicons-move').length) {
        $(this).prepend('<span class="dashicons dashicons-move" style="margin-right: 8px; color: #a0a5aa;"></span>');
      }
    });

    console.log('Module ordering initialized');
  }

  /**
   * Get current module order from DOM
   */
  function getCurrentOrder() {
    const order = [];
    
    $('.postbox.carbon-box').each(function() {
      const id = $(this).attr('id');
      const moduleKey = MODULE_MAP[id];
      
      if (moduleKey) {
        order.push(moduleKey);
      }
    });
    
    return order.join(',');
  }

  /**
   * Update the module_order field
   */
  function updateModuleOrder() {
    const newOrder = getCurrentOrder();
    
    // Find the hidden module_order input field
    const $orderField = $('input[name="_module_order"]');
    
    if ($orderField.length) {
      $orderField.val(newOrder);
      $orderField.trigger('change');
      
      console.log('Module order updated:', newOrder);
      
      // Show visual confirmation
      showSaveNotice();
    } else {
      console.warn('Module order field not found');
    }
  }

  /**
   * Show a temporary save notice
   */
  function showSaveNotice() {
    // Remove existing notice
    $('.ace-order-notice').remove();
    
    // Create notice
    const $notice = $('<div class="ace-order-notice" style="position: fixed; top: 32px; right: 20px; background: #00a32a; color: white; padding: 12px 20px; border-radius: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 999999; font-size: 13px;">Order updated. Remember to save the product.</div>');
    
    $('body').append($notice);
    
    // Fade out after 3 seconds
    setTimeout(function() {
      $notice.fadeOut(400, function() {
        $(this).remove();
      });
    }, 3000);
  }

  /**
   * Initialize on document ready
   */
  $(document).ready(function() {
    // Check if we're on a product edit page
    const $body = $('body');
    
    if ($body.hasClass('post-type-product') && ($body.hasClass('post-php') || $body.hasClass('post-new-php'))) {
      initModuleOrdering();
    }
  });

  /**
   * Re-initialize after Gutenberg loads
   */
  if (typeof wp !== 'undefined' && wp.domReady) {
    wp.domReady(function() {
      // Give Gutenberg time to render
      setTimeout(initModuleOrdering, 500);
    });
  }

})(jQuery);
