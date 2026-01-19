
<?php

require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/assets.php';
require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/cpt-products.php';
require_once get_template_directory() . '/inc/carbon-fields/bootstrap.php';
require_once get_template_directory() . '/inc/carbon-fields/product-fields.php';
require_once get_template_directory() . '/inc/carbon-fields/home-fields.php';
require_once get_template_directory() . '/inc/carbon-fields/blocks.php';
require_once get_template_directory() . '/inc/carbon-fields/global-style.php';
$__footer_fields = get_template_directory() . '/inc/carbon-fields/footer-fields.php';
if (file_exists($__footer_fields)) { require_once $__footer_fields; }
require_once get_template_directory() . '/inc/patterns.php';
require_once get_template_directory() . '/inc/debug.php';
require_once get_template_directory() . '/inc/cpt-contact.php';
require_once get_template_directory() . '/inc/contact-form.php';
require_once get_template_directory() . '/inc/cpt-email.php';
require_once get_template_directory() . '/inc/email-capture.php';




add_filter('use_block_editor_for_post', function($use_block_editor, $post){
    if (is_object($post) && get_post_type($post) === 'product') { return false; }
    return $use_block_editor;
  }, 10, 2);
  
  // Fix TinyMCE sync issue in Classic Editor for Carbon Fields
  add_action('admin_footer', function() {
    global $post_type;
    if ($post_type === 'product') {
      ?>
      <script type="text/javascript">
      jQuery(document).ready(function($) {
        console.log('Carbon Fields TinyMCE Sync Script Loaded');
        
        // Function to sync all TinyMCE editors
        function syncAllEditors() {
          console.log('Syncing all TinyMCE editors...');
          
          // Method 1: Use WordPress tinymce.triggerSave()
          if (typeof tinymce !== 'undefined' && typeof tinymce.triggerSave === 'function') {
            tinymce.triggerSave();
            console.log('tinymce.triggerSave() executed');
          }
          
          // Method 2: Loop through all editors and save individually
          if (typeof tinymce !== 'undefined' && tinymce.editors) {
            for (var i = 0; i < tinymce.editors.length; i++) {
              var editor = tinymce.editors[i];
              if (editor && !editor.isHidden()) {
                editor.save();
                console.log('Saved editor: ' + editor.id);
              }
            }
          }
          
          // Method 3: Force sync using native method
          if (typeof tinyMCE !== 'undefined') {
            tinyMCE.triggerSave();
            console.log('tinyMCE.triggerSave() executed');
          }
        }
        
        // Trigger on form submit (with capture phase)
        var form = document.getElementById('post');
        if (form) {
          form.addEventListener('submit', function(e) {
            console.log('Form submit detected');
            syncAllEditors();
          }, true);
        }
        
        // Trigger when Update/Publish button is clicked (before form submission)
        $('#publish, #save-post').on('mousedown', function() {
          console.log('Update/Publish button clicked');
          syncAllEditors();
        });
        
        // Also sync before WordPress autosave
        $(document).on('autosave-disable-buttons', function() {
          console.log('Autosave triggered');
          syncAllEditors();
        });
        
        // Backup: Sync every 5 seconds if editor is active
        setInterval(function() {
          if (typeof tinymce !== 'undefined' && tinymce.activeEditor) {
            tinymce.activeEditor.save();
          }
        }, 5000);
      });
      </script>
      <?php
    }
  });