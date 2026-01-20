<?php
/**
 * Company Profile Module
 */

$hide = carbon_get_the_post_meta('home_company_hide');
$full_width = carbon_get_the_post_meta('home_company_full_width');
$heading = carbon_get_the_post_meta('home_company_heading');
$description = carbon_get_the_post_meta('home_company_description');
$btn_text = carbon_get_the_post_meta('home_company_btn_text');
$btn_link = carbon_get_the_post_meta('home_company_btn_link');
$video_id = carbon_get_the_post_meta('home_company_video');
$poster_id = carbon_get_the_post_meta('home_company_poster');
$stats = carbon_get_the_post_meta('home_company_stats');

if ($hide) {
    return;
}

$poster_url = $poster_id ? wp_get_attachment_image_url($poster_id, 'full') : '';
$video_url = $video_id ? wp_get_attachment_url($video_id) : '';

$wrapper_class = $full_width ? 'w-full' : 'max-w-global mx-auto';
?>

<section class="my-8 lg:my-8 bg-brand-secondary company-profile-section">
    <div class="<?php echo esc_attr($wrapper_class); ?>">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">
            
            <!-- Left Column: Video/Image & Stats -->
            <div class="relative group overflow-hidden shadow-lg">
                <!-- Poster Image -->
                <div class="aspect-[4/3] w-full relative overflow-hidden bg-gray-100 cursor-pointer js-company-video-trigger">
                    <?php if ($poster_url): ?>
                        <img src="<?php echo esc_url($poster_url); ?>" alt="<?php echo esc_attr($heading); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <?php endif; ?>
                    
                    <!-- Play Button Overlay -->
                    <div class="absolute inset-0 flex items-center justify-center z-10 pointer-events-none">
                        <div class="w-16 h-16 md:w-20 md:h-20 bg-brand-accent rounded-full flex items-center justify-center shadow-lg transform transition-transform duration-300 group-hover:scale-105">
                            <svg class="w-6 h-6 md:w-8 md:h-8 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Overlay Gradient for better text visibility -->
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition-colors duration-300"></div>
                </div>

                <!-- Stats Overlay (Right Side on Desktop, Bottom on Mobile) -->
                <?php if (!empty($stats)): ?>
                    <div class="relative w-full grid grid-cols-2 gap-px bg-white/10 lg:bg-transparent lg:gap-[20px] lg:absolute lg:top-0 lg:bottom-0 lg:right-0 lg:w-auto lg:flex lg:flex-col lg:justify-center z-20 lg:pointer-events-none">
                        <?php foreach ($stats as $index => $stat): ?>
                            <div class="bg-gray-900 lg:bg-black/60 lg:backdrop-blur-sm text-white p-4 lg:py-6 lg:px-8 border-none lg:border-none flex flex-col items-center lg:items-end justify-center min-w-[80px]">
                                <div class="text-2xl md:text-3xl font-bold leading-tight mb-1 flex items-baseline">
                                    <span class="js-counter" data-target="<?php echo esc_attr($stat['number']); ?>">0</span>
                                    <?php if (!empty($stat['suffix'])): ?>
                                        <span class="text-white ml-0.5"><?php echo esc_html($stat['suffix']); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="text-xs md:text-sm text-white/80 font-medium text-center lg:text-right uppercase tracking-wide">
                                    <?php echo esc_html($stat['label']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Column: Content -->
            <div class="flex flex-col items-start text-left px-4 max-w-xl">
                <?php if ($heading): ?>
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                        <?php echo esc_html($heading); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($description): ?>
                    <div class="prose prose-lg text-gray-600 mb-8 max-w-none [&_p]:mb-6">
                        <?php echo apply_filters('the_content', $description); ?>
                    </div>
                <?php endif; ?>

                <?php if ($btn_text && $btn_link): ?>
                    <a href="<?php echo esc_url($btn_link); ?>" class="inline-flex items-center justify-center px-8 py-3 text-base font-medium text-white bg-brand-accent rounded hover:bg-brand-accent/90 transition-colors duration-300 shadow-md">
                        <?php echo esc_html($btn_text); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Video Modal -->
    <?php if ($video_url): ?>
        <div id="company-video-modal" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/80">
            <div class="w-full max-w-4xl px-6 relative">
                <button type="button" class="js-close-video absolute -top-5 -right-4 p-2 rounded-full bg-white/50 hover:bg-white/100 text-black shadow" aria-label="Close">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18.3 5.71 12 12.01 5.7 5.7 4.29 7.11 10.59 13.41 4.29 19.71 5.7 21.12 12 14.82 18.3 21.12 19.71 19.71 13.41 13.41 19.71 7.11z"/></svg>
                </button>
                <video class="w-full h-auto rounded-lg" controls playsinline>
                    <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const section = document.querySelector('.company-profile-section');
            if (!section) return;

            // Video Modal Logic
            const trigger = section.querySelector('.js-company-video-trigger');
            const modal = document.getElementById('company-video-modal');
            const closeBtn = modal ? modal.querySelector('.js-close-video') : null;
            const video = modal ? modal.querySelector('video') : null;

            if (trigger && modal && video) {
                const openModal = () => {
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    video.play();
                };

                const closeModal = () => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    video.pause();
                    video.currentTime = 0;
                };

                trigger.addEventListener('click', openModal);
                closeBtn.addEventListener('click', closeModal);
                
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) closeModal();
                });

                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                        closeModal();
                    }
                });
            }

            // Number Counter Animation
            const counters = section.querySelectorAll('.js-counter');
            
            const animateCounter = (counter) => {
                const raw = counter.getAttribute('data-target');
                const target = parseInt(raw.replace(/[^0-9]/g, '')); // Strip non-numeric chars
                if (isNaN(target)) return;
                
                const duration = 2000; // ms
                const start = 0;
                const startTime = performance.now();
                
                const update = (currentTime) => {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    
                    // Easing function (easeOutExpo)
                    const ease = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
                    
                    const current = Math.floor(start + (target - start) * ease);
                    counter.innerText = current;
                    
                    if (progress < 1) {
                        requestAnimationFrame(update);
                    } else {
                        counter.innerText = target;
                    }
                };
                
                requestAnimationFrame(update);
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const counter = entry.target;
                        animateCounter(counter);
                        observer.unobserve(counter);
                    }
                });
            }, { threshold: 0.5 });

            counters.forEach(counter => observer.observe(counter));
        });
        </script>
    <?php endif; ?>
</section>