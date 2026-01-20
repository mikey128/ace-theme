
<?php

require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/assets.php';
require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/cpt-products.php';
require_once get_template_directory() . '/inc/carbon-fields/bootstrap.php';
require_once get_template_directory() . '/inc/carbon-fields/product-fields.php';
require_once get_template_directory() . '/inc/carbon-fields/home-fields.php';
require_once get_template_directory() . '/inc/carbon-fields/blocks.php';


$__global_email_fields = get_template_directory() . '/inc/carbon-fields/global-email-fields.php';
if (file_exists($__global_email_fields)) { require_once $__global_email_fields; }
$__global_contact_fields = get_template_directory() . '/inc/carbon-fields/global-contact-fields.php';
if (file_exists($__global_contact_fields)) { require_once $__global_contact_fields; }
$__global_media_fields = get_template_directory() . '/inc/carbon-fields/global-media-fields.php';
if (file_exists($__global_media_fields)) { require_once $__global_media_fields; }

$__user_fields = get_template_directory() . '/inc/carbon-fields/user-fields.php';
if (file_exists($__user_fields)) { require_once $__user_fields; }
$__footer_fields = get_template_directory() . '/inc/carbon-fields/footer-fields.php';
if (file_exists($__footer_fields)) { require_once $__footer_fields; }
require_once get_template_directory() . '/inc/carbon-fields/global-style.php';

require_once get_template_directory() . '/inc/patterns.php';
require_once get_template_directory() . '/inc/debug.php';
require_once get_template_directory() . '/inc/cpt-contact.php';
require_once get_template_directory() . '/inc/contact-form.php';
require_once get_template_directory() . '/inc/cpt-email.php';
require_once get_template_directory() . '/inc/email-capture.php';
require_once get_template_directory() . '/inc/auth.php';



add_filter('use_block_editor_for_post', function($use_block_editor, $post){
  $front_id = (int) get_option('page_on_front');
  if (is_object($post)) {
    if (get_post_type($post) === 'product') { return false; }
    if ($front_id && (int) $post->ID === $front_id) { return false; }
  }
  return $use_block_editor;
}, 10, 2);
// enable excerpts on pages and products
add_action('init', function() {
  add_post_type_support('page', 'excerpt');
  add_post_type_support('product', 'excerpt');
}, 11);

// force show excerpt meta box in Classic Editor
add_action('add_meta_boxes', function() {
  remove_meta_box('postexcerpt', 'page', 'normal');
  remove_meta_box('postexcerpt', 'product', 'normal');
  if (post_type_supports('page', 'excerpt')) {
    add_meta_box('postexcerpt', 'Excerpt', 'post_excerpt_meta_box', 'page', 'normal', 'core');
  }
  if (post_type_supports('product', 'excerpt')) {
    add_meta_box('postexcerpt', 'Product short description', 'post_excerpt_meta_box', 'product', 'normal', 'core');
  }
}, 0);
 
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
