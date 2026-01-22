<?php
if (! function_exists('carbon_get_the_post_meta')) {
    return;
}

$hide_section = carbon_get_the_post_meta('applications_hide_section');

if ($hide_section) {
    return;
}
$full_width = carbon_get_the_post_meta('applications_full_width');
$wrapper_classes = $full_width
    ? 'w-full px-6'
    : 'max-w-7xl mx-auto px-6 max-w-global';
$applications = carbon_get_the_post_meta('product_applications');
if (empty($applications) || ! is_array($applications)) {
    return;
}

$section_title    = carbon_get_the_post_meta('applications_section_title');
$section_subtitle = carbon_get_the_post_meta('applications_section_subtitle');

$section_id_input = (string) carbon_get_the_post_meta('applications_section_id');
$section_id    = $section_id_input !== '' ? sanitize_title($section_id_input) : 'product-applications-' . get_the_ID();
?>

<section
    id="<?php echo esc_attr($section_id); ?>"
    class="py-10 sm:py-12 md:py-16 bg-white"
>
    <div class="<?php echo esc_attr($wrapper_classes); ?>">
        <header class="text-center max-w-5xl mx-auto">
            <?php if (! empty($section_title)) : ?>
                <h2 class="text-2xl mb-6 sm:text-3xl md:text-4xl font-semibold text-gray-900">
                    <?php echo esc_html($section_title); ?>
                </h2>
            <?php endif; ?>

            <?php if (! empty($section_subtitle)) : ?>
                <p class="mt-3 text-sm sm:text-base  text-gray-500">
                    <?php echo esc_html($section_subtitle); ?>
                </p>
            <?php endif; ?>
        </header>

        <nav
            class="mt-6 sm:mt-8 flex flex-wrap gap-2 sm:gap-3 justify-center"
            aria-label="<?php esc_attr_e('Product application tabs', 'ace-theme'); ?>"
        >
            <?php foreach ($applications as $index => $application) : ?>
                <?php
                $title = isset($application['application_title']) ? $application['application_title'] : '';
                $tab_id = $section_id . '-tab-' . ($index + 1);
                $state_classes = $index === 0
                    ? 'bg-brand-accent text-white border-blue-600 shadow-sm'
                    : 'bg-white text-gray-900 border-gray-200 hover:bg-gray-50';
               ?>

                <button
                    type="button"
                    id="<?php echo esc_attr($tab_id); ?>-button"
                    class="tab-button inline-flex items-center justify-center rounded-md px-5 sm:px-6 py-2.5 text-sm sm:text-base font-semibold border focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-blue-600 transition-colors <?php echo esc_attr($state_classes); ?>"
                    data-tab-target="<?php echo esc_attr($tab_id); ?>"
                    aria-controls="<?php echo esc_attr($tab_id); ?>"
                    aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                    role="tab"
                >
                    <span>
                        <?php echo esc_html($title); ?>
                    </span>
                </button>
            <?php endforeach; ?>
        </nav>

        <div
            class="mt-8 sm:mt-10"
            role="tablist"
            aria-live="polite"
        >
            <?php foreach ($applications as $index => $application) : ?>
                <?php
                $title       = isset($application['application_title']) ? $application['application_title'] : '';
                $description = isset($application['application_description']) ? $application['application_description'] : '';
                $image_id    = isset($application['application_image']) ? $application['application_image'] : 0;

                $tab_id = $section_id . '-tab-' . ($index + 1);
                $is_active = $index === 0;
                ?>

                <article
                    id="<?php echo esc_attr($tab_id); ?>"
                    class="tab-panel <?php echo $is_active ? '' : 'hidden'; ?>"
                    role="tabpanel"
                    aria-labelledby="<?php echo esc_attr($tab_id); ?>-button"
                >
                    <?php if ($image_id) : ?>
                        <figure class="overflow-hidden rounded-2xl sm:rounded-3xl bg-gray-100">
                            <?php
                            echo wp_get_attachment_image(
                                $image_id,
                                'large',
                                false,
                                [
                                    'class' => 'w-full h-auto object-cover',
                                    'loading' => 'lazy',
                                ]
                            );
                            ?>
                        </figure>
                    <?php endif; ?>

                    <?php if (! empty($description)) : ?>
                        <p class="mt-4 sm:mt-5 text-sm sm:text-base md:text-lg text-gray-600 text-center">
                            <?php echo esc_html($description); ?>
                        </p>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        (function () {
            var section = document.getElementById('<?php echo esc_js($section_id); ?>');
            if (!section) {
                return;
            }

            var buttons = section.querySelectorAll('.tab-button');
            var panels = section.querySelectorAll('.tab-panel');

            if (!buttons.length || !panels.length) {
                return;
            }

            function setActiveTab(targetId) {
                panels.forEach(function (panel) {
                    if (panel.id === targetId) {
                        panel.classList.remove('hidden');
                    } else {
                        panel.classList.add('hidden');
                    }
                });

                buttons.forEach(function (button) {
                    var buttonTarget = button.getAttribute('data-tab-target');
                    var isActive = buttonTarget === targetId;

                    button.setAttribute('aria-selected', isActive ? 'true' : 'false');

                    var activeClasses = ['bg-brand-accent', 'text-white', 'border-blue-600', 'shadow-sm'];
                    var inactiveClasses = ['bg-white', 'text-gray-900', 'border-gray-200', 'hover:bg-gray-50'];

                    if (isActive) {
                        activeClasses.forEach(function (cls) {
                            button.classList.add(cls);
                        });
                        inactiveClasses.forEach(function (cls) {
                            button.classList.remove(cls);
                        });
                    } else {
                        activeClasses.forEach(function (cls) {
                            button.classList.remove(cls);
                        });
                        inactiveClasses.forEach(function (cls) {
                            if (!button.classList.contains(cls)) {
                                button.classList.add(cls);
                            }
                        });
                    }
                });
            }

            buttons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var targetId = button.getAttribute('data-tab-target');
                    if (!targetId) {
                        return;
                    }
                    setActiveTab(targetId);
                });
            });
        })();
    </script>
</section>
