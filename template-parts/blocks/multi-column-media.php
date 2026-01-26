<?php
/**
 * Multi Column Media Block Template
 * Used by Carbon Fields Block
 * Based on our-advantages.php but without background image
 */

if (empty($items)) {
  return;
}
?>
<section class="relative py-16 lg:py-24 bg-white overflow-hidden">
    <div class="<?php echo esc_attr($wrapper_classes); ?> relative z-10">
        <!-- Header -->
        <div class="text-center mb-12 lg:mb-16">
            <?php if ($heading): ?>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4"><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>
            <?php if ($subheading): ?>
                <div class="text-gray-600 max-w-3xl mx-auto prose prose-lg">
                    <?php echo apply_filters('the_content', $subheading); ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($items as $item): ?>
                <?php
                $serial = isset($item['serial']) ? (string) $item['serial'] : '';
                $icon_id = isset($item['icon']) ? (int) $item['icon'] : 0;
                $title = isset($item['title']) ? (string) $item['title'] : '';
                $description = isset($item['description']) ? (string) $item['description'] : '';
                $icon_url = $icon_id ? wp_get_attachment_image_url($icon_id, 'thumbnail') : '';
                ?>
                <div class="group relative h-48 bg-brand-secondary group-hover:bg-brand-accent rounded-md shadow-sm overflow-hidden transition-all duration-300">
                    <!-- Default State (Icon + Title) -->
                    <div class="absolute inset-0 flex flex-col items-center justify-center p-6 text-center z-10 bg-brand-secondary shadow-sm">
                        <!-- Serial Number (Watermark style) -->
                        <?php if ($serial): ?>
                            <span class="absolute top-4 left-6 text-6xl font-bold text-gray-200 select-none"><?php echo esc_html($serial); ?></span>
                        <?php endif; ?>
                        
                        <!-- Icon -->
                        <?php if ($icon_url): ?>
                            <div class="relative w-24 h-24 mb-6 rounded-full bg-brand-secondary flex items-center justify-center text-brand-accent transition-transform duration-300 group-hover:scale-110">
                                <img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($title); ?>" class="w-12 h-12 object-contain" />
                            </div>
                        <?php endif; ?>
                        
                        <!-- Title -->
                        <?php if ($title): ?>
                            <h3 class="relative text-lg font-bold text-gray-900"><?php echo esc_html($title); ?></h3>
                        <?php endif; ?>
                    </div>

                    <!-- Hover State (Description) -->
                    <div class="absolute inset-0 bg-brand-accent p-4 flex flex-col justify-center items-start text-left z-20 transform translate-y-full transition-transform duration-500 ease-out group-hover:translate-y-0">
                        <!-- Serial Number (White on Blue) -->
                        <?php if ($serial): ?>
                            <span class="text-6xl font-bold text-white/20 mb-4 block leading-none"><?php echo esc_html($serial); ?></span>
                        <?php endif; ?>
                        
                        <!-- Description -->
                        <?php if ($description): ?>
                            <p class="text-white text-base leading-relaxed">
                                <?php echo esc_html($description); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
