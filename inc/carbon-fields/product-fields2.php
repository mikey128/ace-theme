<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function () {
  // Product Gallery Container
  Container::make('post_meta', 'Product Gallery Info')
    ->where('post_type', '=', 'product')
    ->add_fields([
      Field::make('text', 'gallery_section_id', 'Section ID')
        ->set_help_text('Used for on-page navigation, without #'),
      Field::make('color', 'gallery_background_color', 'Background Color')
        ->set_help_text('Select background color for the gallery section'),
      Field::make('select', 'gallery_max_width', 'Content Max Width')
        ->set_options([
          'max-w-xl' => 'Max Width XL',
          'max-w-2xl' => 'Max Width 2XL',
          'max-w-3xl' => 'Max Width 3XL',
          'max-w-4xl' => 'Max Width 4XL',
          'max-w-5xl' => 'Max Width 5XL',
          'max-w-6xl' => 'Max Width 6XL',
          'max-w-7xl' => 'Max Width 7XL',
        ])
        ->set_default_value('max-w-3xl'),
       Field::make('media_gallery', 'gallery_images', 'Product Gallery Images'),
      Field::make('text', 'product_title', 'Gallery Title')
        ->set_help_text('Leave empty to use the main product title'),
      Field::make('rich_text', 'product_description', 'Gallery Description')
        ->set_rows(8),     
      Field::make('textarea', 'product_short_description', 'Card Short Description')
        ->set_rows(4),
      Field::make('text', 'cta_primary_url', 'Primary CTA URL')
        ->set_attribute('type', 'url'),
      Field::make('text', 'cta_primary_text', 'Primary CTA Text')
        ->set_default_value('View case'),
      Field::make('text', 'cta_secondary_url', 'Secondary CTA URL')
        ->set_attribute('type', 'url'),
      Field::make('text', 'cta_secondary_text', 'Secondary CTA Text')
        ->set_default_value('Ask For Samples Or Customized Solutions'),
    ]);

  Container::make('post_meta', 'Quick Product Nav')
    ->where('post_type', '=', 'product')
    ->add_fields([
      Field::make('checkbox', 'quick_nav_full_width', 'Full Width Section'),
      Field::make('checkbox', 'quick_nav_hide_section', 'Hide Section'),
      Field::make('complex', 'quick_nav_items', 'Navigation Items')
        ->set_layout('tabbed-horizontal')
        ->add_fields([
          Field::make('text', 'nav_label', 'Label'),
          Field::make('text', 'target_id', 'Section ID'),
        ]),
    ]);

  // Video Module Container
  Container::make('post_meta', 'Video Module')
    ->where('post_type', '=', 'product')
    ->where('post_template', '!=', 'product-special.php')
    ->add_fields([
      Field::make('text', 'video_section_id', 'Section ID')
        ->set_help_text('Used for on-page navigation, without #'),
      Field::make('checkbox', 'video_full_width', 'Full Width Section'),
      Field::make('checkbox', 'video_hide_section', 'Hide Section'),    
      Field::make('text', 'video_title', 'Video Title')
        ->set_help_text('Title of the video'),
      Field::make('image', 'cover_image', 'Video Cover Image')
        ->set_value_type('url')
        ->set_required(false),
      Field::make('file', 'video_file', 'Video File')
        ->set_type(['video'])
        ->set_required(false),
    ]);
    
// product features container
  Container::make('post_meta', 'Product Features')
    ->where('post_type', '=', 'product')
    ->where('post_template', '!=', 'product-special.php')
    ->add_fields([
      Field::make('text', 'features_section_id', 'Section ID')
        ->set_help_text('Used for on-page navigation, without #'),
      Field::make('text', 'features_section_title', 'Features Section Title'),
      Field::make('checkbox', 'features_full_width', 'Full Width Section'),
      Field::make('checkbox', 'features_hide_section', 'Hide Features Section'),
      Field::make('complex', 'product_features', 'Product Features')
        ->set_layout('tabbed-horizontal')
        ->add_fields([
          Field::make('text', 'feature_title', 'Feature Title'),
          Field::make('rich_text', 'feature_description', 'Feature Description')
          ->set_rows(8),               
          Field::make('checkbox', 'feature_highlighted', 'Highlighted Feature'),
        ]),
    ]);
// product applications container
Container::make('post_meta', 'Product Applications')
    ->where('post_type', '=', 'product')
    ->where('post_template', '!=', 'product-special.php')
    ->add_fields([
        Field::make('text', 'applications_section_id', 'Section ID')
          ->set_help_text('Used for on-page navigation, without #'),
        Field::make('text', 'applications_section_title', 'Applications Section Title'),
        Field::make('text', 'applications_section_subtitle', 'Applications Section Subtitle'),

        Field::make('checkbox', 'features_full_width', 'Full Width Section'),
        Field::make('checkbox', 'features_hide_section', 'Hide Applications Section'),

        Field::make('complex', 'product_applications', 'Application Tabs')
            ->set_layout('tabbed-horizontal')
            ->add_fields([
                Field::make('text', 'application_title', 'Application Title'),
                Field::make('image', 'application_image', 'Application Image')
                    ->set_value_type('id'),
                Field::make('textarea', 'application_description', 'Application Description'),
            ]),
    ]);
      // Featured Part
  Container::make('post_meta', 'Featured Part')
    ->where('post_type', '=', 'product')
    ->add_fields([
     Field::make('text', 'featured_section_id', 'Section ID')
       ->set_help_text('Used for on-page navigation, without #'),
     Field::make('checkbox', 'enable_full_width', 'Full Width Section'),
      Field::make('checkbox', 'hide_section', 'Hide Section'),
      Field::make('text', 'featured_heading', 'Heading'),
      Field::make('text', 'featured_left_subtitle', 'Left Subtitle'),
      Field::make('text', 'featured_left_title', 'Left Title'),
      Field::make('rich_text', 'featured_left_description', 'Left Description'),
      Field::make('image', 'featured_right_image', 'Right Image')->set_value_type('id'),    
      Field::make('complex', 'featured_features', 'Feature Items')
        ->set_layout('tabbed-horizontal')
        ->add_fields([
          Field::make('rich_text', 'feature_text', 'Text')
           ->set_rows(8),   
        ]),
    ]);
  // Product Specs Container
  Container::make('post_meta', 'Product Specs')
    ->where('post_type', '=', 'product')
    ->where('post_template', '!=', 'product-special.php')
    ->add_fields([
      Field::make('text', 'spec_section_id', 'Section ID')
        ->set_help_text('Used for on-page navigation, without #'),
         Field::make('color', 'specs_background_color', 'Background Color')
        ->set_help_text('Select background color for the specs section'),
      Field::make('text', 'spec_title', 'Specs Title'),
      Field::make('image', 'main_image', 'Main Image'),    
      Field::make('complex', 'technical_specs', 'Technical Specifications')
       ->set_layout('tabbed-horizontal')
        ->add_fields([
          Field::make('text', 'label', 'Label'),
          Field::make('text', 'spec_value', 'Value'),
        ]),     
    ]);
  // Media Carousel Container
  Container::make('post_meta', 'Media Carousel')
    ->where('post_type', '=', 'product')
    ->add_fields([
      Field::make('text', 'media_carousel_section_id', 'Section ID')
        ->set_help_text('Used for on-page navigation, without #'),
      Field::make('text', 'media_carousel_title', 'Carousel Title'),
      Field::make('textarea', 'media_carousel_description', 'Carousel Description'),
      Field::make('checkbox', 'media_carousel_full_width', 'Full Width Section'),
      Field::make('checkbox', 'media_carousel_hide_section', 'Hide Media Carousel'),
      Field::make('complex', 'media_carousel_items', 'Carousel Items')
        ->set_layout('tabbed-horizontal')
        ->set_max(15)
        ->add_fields([
          Field::make('image', 'carousel_image', 'Image')->set_value_type('id'),
          Field::make('text', 'carousel_date', 'Date'),
          Field::make('text', 'carousel_title', 'Title'),
          Field::make('textarea', 'carousel_description', 'Description'),
          Field::make('text', 'carousel_link', 'Link')->set_attribute('type', 'url'),
          Field::make('checkbox', 'carousel_highlight', 'Highlight'),
        ]),
    ]);

  // Installation Design Container
  Container::make('post_meta', 'Installation Design')
    ->where('post_type', '=', 'product')
    ->add_fields([
      Field::make('text', 'installation_section_id', 'Section ID')
        ->set_help_text('Used for on-page navigation, without #'),
      Field::make('checkbox', 'enable_full_width', 'Full Width Section'),
      Field::make('checkbox', 'hide_section', 'Hide Section'),
      Field::make('text', 'installation_heading', 'Section Heading'),
      Field::make('select', 'installation_columns', 'Desktop Columns')
        ->set_options([
          '3' => '3',
          '4' => '4',
          '5' => '5',
          '6' => '6',
        ])
        ->set_default_value('4'),      
      Field::make('complex', 'installation_items', 'Items')
        ->set_layout('tabbed-horizontal')
        ->add_fields([
          Field::make('image', 'image', 'Image')->set_value_type('id'),
          Field::make('text', 'title', 'Title'),
          Field::make('textarea', 'description', 'Description'),
        ]),
    ]);

  Container::make('post_meta', 'Product Accessories')
    ->where('post_type', '=', 'product')
    ->add_fields([
      Field::make('text', 'accessories_section_id', 'Section ID')
        ->set_help_text('Used for on-page navigation, without #'),
      Field::make('checkbox', 'enable_full_width', 'Full Width Section'),
      Field::make('checkbox', 'hide_section', 'Hide Section'),
      Field::make('text', 'accessories_heading', 'Section Heading'),
      Field::make('select', 'accessories_columns', 'Desktop Columns')
        ->set_options([
          '3' => '3',
          '4' => '4',
          '5' => '5',
          '6' => '6',
        ])
        ->set_default_value('4'),
      Field::make('complex', 'accessories_items', 'Items')
        ->set_layout('tabbed-horizontal')
        ->add_fields([
          Field::make('image', 'image', 'Image')->set_value_type('id'),
          Field::make('text', 'title', 'Title'),
        ]),
    ]);

  Container::make('post_meta', 'Product Support')
    ->where('post_type', '=', 'product')
    ->add_fields([
      Field::make('text', 'support_section_id', 'Section ID')
        ->set_help_text('Used for on-page navigation, without #'),
      Field::make('checkbox', 'enable_full_width', 'Full Width Section'),
      Field::make('checkbox', 'hide_section', 'Hide Section'),
      Field::make('text', 'support_heading', 'Section Heading'),
      Field::make('complex', 'support_videos', 'Video Slides')
        ->set_layout('tabbed-horizontal')
        ->add_fields([
          Field::make('text', 'title', 'Title'),
          Field::make('image', 'cover_image', 'Cover Image')->set_value_type('id'),
          Field::make('file', 'video_file', 'Video File')->set_type(['video']),
        ]),
      Field::make('complex', 'support_documents', 'Document Slides')
        ->set_layout('tabbed-horizontal')
        ->add_fields([
          Field::make('image', 'cover_image', 'Cover Image')->set_value_type('id'),
          Field::make('text', 'title', 'Title'),
          Field::make('text', 'pdf_link', 'PDF Link')->set_attribute('type', 'url'),
        ]),
    ]);

  Container::make('post_meta', 'Product FAQ')
    ->where('post_type', '=', 'product')
    ->add_fields([
      Field::make('text', 'faq_section_id', 'Section ID')
        ->set_help_text('Used for on-page navigation, without #'),
      Field::make('checkbox', 'enable_full_width', 'Full Width Section'),
      Field::make('checkbox', 'hide_section', 'Hide Section'),
      Field::make('text', 'faq_heading', 'Section Heading'),
      Field::make('select', 'faq_max_width', 'Content Max Width')
        ->set_options([
          '3xl' => 'Max Width 3XL',
          '4xl' => 'Max Width 4XL',
          '5xl' => 'Max Width 5XL',
          '6xl' => 'Max Width 6XL',
          '7xl' => 'Max Width 7XL',
        ])
        ->set_default_value('6xl'),
      Field::make('complex', 'faq_items', 'FAQ Items')
        ->set_layout('tabbed-horizontal')
        ->add_fields([
          Field::make('text', 'question', 'Question'),
          Field::make('rich_text', 'answer', 'Answer')           
        ->set_rows(8),    
        ]),
    ]);

  Container::make('post_meta', 'Product Contact Form')
    ->where('post_type', '=', 'product')
    ->add_fields([
      Field::make('text', 'contact_section_id', 'Section ID')
        ->set_help_text('Used for on-page navigation, without #'),
      Field::make('checkbox', 'enable_full_width', 'Full Width Section'),
      Field::make('checkbox', 'hide_section', 'Hide Section'),
      Field::make('text', 'contact_heading', 'Heading')
        ->set_default_value('Talk to Your Dedicated LED Product Experts'),
      Field::make('textarea', 'contact_description', 'Intro Description')
        ->set_default_value('If you are looking for reliable, energy-efficient industrial lighting solutions, look no further than ACE LED Light. Contact us today to learn more about our products and services.'),
      Field::make('text', 'contact_subheading', 'Form Subheading')
        ->set_default_value('Submit Your Request'),
      Field::make('text', 'contact_button_text', 'Button Text')
        ->set_default_value('SEND MESSAGE'),
      Field::make('text', 'contact_privacy_note', 'Privacy Note')
        ->set_default_value('We respect your confidentiality and all information are protected.'),
    ]);

 
  

});

