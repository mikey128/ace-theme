<?php
/**
 * Image & Text Module Block Template
 *
 * @package Ace_Theme
 */

$heading = isset($fields['itm_heading']) ? $fields['itm_heading'] : '';
$image_id = isset($fields['itm_image']) ? $fields['itm_image'] : '';
$description = isset($fields['itm_description']) ? $fields['itm_description'] : '';
$layout = isset($fields['itm_layout']) ? $fields['itm_layout'] : '5_5';
$bg_color = isset($fields['itm_bg_color']) ? $fields['itm_bg_color'] : '';
$is_dark = !empty($fields['itm_is_dark']);
$full_width = !empty($fields['itm_full_width']);

$wrap_class = $full_width ? 'w-full' : 'max-w-7xl mx-auto px-6 max-w-global';

// Layout Classes
// Default to 50/50
$img_width_class = 'md:w-1/2';
$txt_width_class = 'md:w-1/2';

if ($layout === '6_4' || $layout === '3_2') {
    $img_width_class = 'md:w-3/5';
    $txt_width_class = 'md:w-2/5';
}

// Text Color Class
$text_color_class = $is_dark ? 'text-white' : 'text-gray-900';

// Background Style
$bg_style = $bg_color ? 'background-color: ' . esc_attr($bg_color) . ';' : '';

?>

<div class="<?php echo esc_attr($wrap_class); ?> py-12 lg:py-16">
    <div class="flex flex-col md:flex-row shadow-lg overflow-hidden ">
        
        <!-- Image Column -->
        <div class="w-full <?php echo esc_attr($img_width_class); ?> relative">
            <?php if ($image_id) : ?>
                <?php echo wp_get_attachment_image($image_id, 'full', false, ['class' => 'w-full h-auto block']); ?>
            <?php else : ?>
                <div class="min-h-[300px] bg-gray-200 flex items-center justify-center text-gray-400">
                    <span class="text-lg">No Image Selected</span>
                </div>
            <?php endif; ?>
        </div>

        <!-- Text Column -->
        <div class="w-full <?php echo esc_attr($txt_width_class); ?> p-8 lg:p-12 flex flex-col justify-center <?php echo esc_attr($text_color_class); ?>" style="<?php echo $bg_style; ?>">
            <?php if ($heading) : ?>
                <h3 class="text-2xl lg:text-3xl font-bold mb-4 <?php echo $is_dark ? 'text-white' : 'text-gray-900'; ?>">
                    <?php echo esc_html($heading); ?>
                </h3>
            <?php endif; ?>

            <?php if ($description) : ?>
                <div class="prose <?php echo $is_dark ? 'prose-invert' : ''; ?> max-w-none">
                    <?php echo apply_filters('the_content', $description); ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>
