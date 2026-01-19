<?php
if (! function_exists('carbon_get_the_post_meta')) {
    return;
}

$specs = carbon_get_the_post_meta('technical_specs');

if (empty($specs) || ! is_array($specs)) {
    return;
}

$section_title = carbon_get_the_post_meta('spec_title');

if (empty($section_title)) {
    $section_title = carbon_get_the_post_meta('spec_section_title');
}

if (empty($section_title)) {
    $section_title = carbon_get_the_post_meta('specs_section_title');
}

if (empty($section_title)) {
    $section_title = get_the_title();
}

$section_id_input = (string) carbon_get_the_post_meta('spec_section_id');
$section_id    = $section_id_input !== '' ? sanitize_title($section_id_input) : 'product-specs-' . get_the_ID();

$specs_bg_color = carbon_get_the_post_meta('specs_background_color');

?>

<section
    id="<?php echo esc_attr($section_id); ?>"
    class="py-10 sm:py-12 md:py-16 <?php echo $specs_bg_color ? '' : 'bg-white'; ?>"
    <?php echo $specs_bg_color ? 'style="background-color: ' . esc_attr($specs_bg_color) . ';"' : ''; ?>
>
    <div class="max-w-7xl mx-auto px-6 max-w-global">
        <header class="text-center max-w-2xl mx-auto">
            <?php if (! empty($section_title)) : ?>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-semibold  text-gray-900">
                    <?php echo esc_html($section_title); ?>
                </h2>
            <?php endif; ?>
        </header>

        <?php
        $rows = array_chunk($specs, 4);
        ?>

        <div class="mt-8 sm:mt-10 space-y-6 sm:space-y-8 md:space-y-10">
            <?php foreach ($rows as $row_index => $row_specs) : ?>
                <div class="border-b border-dashed border-gray-300 pb-6 sm:pb-8 md:pb-10">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-y-6 sm:gap-y-8 md:gap-y-10 gap-x-8">
                        <?php foreach ($row_specs as $spec) : ?>
                            <?php
                            $label = isset($spec['label']) ? $spec['label'] : '';
                            $value = isset($spec['spec_value']) ? $spec['spec_value'] : '';

                            if ($label === '' && $value === '') {
                                continue;
                            }
                            ?>

                            <div>
                                <?php if ($label !== '') : ?>
                                    <dt class="text-sm sm:text-base font-semibold text-gray-900">
                                        <?php echo esc_html($label); ?>
                                    </dt>
                                <?php endif; ?>

                                <?php if ($value !== '') : ?>
                                    <dd class="mt-2 text-sm sm:text-base text-gray-700 leading-relaxed">
                                        <?php echo esc_html($value); ?>
                                    </dd>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </dl>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
