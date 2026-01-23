(() => {
  const init = (root) => {
    const swiperEl = root.querySelector('.swiper');
    const paginationEl = root.querySelector('.swiper-pagination');
    if (!swiperEl || !paginationEl) return;
    const autoplayEnabled = root.getAttribute('data-autoplay') === '1';
    const perView = parseFloat(root.getAttribute('data-per-view') || '5');
    if (typeof Swiper === 'undefined') return;
    const sw = new Swiper(swiperEl, {
      slidesPerView: 1,
      spaceBetween: 16,
      pagination: { el: paginationEl, clickable: true },
      autoplay: autoplayEnabled ? { delay: 3000, disableOnInteraction: false, pauseOnMouseEnter: true } : false,
      observer: true,
      observeParents: true,
      speed: 600,
      loop: false,
      breakpoints: {
        640: { slidesPerView: 2, spaceBetween: 16 },
        768: { slidesPerView: 3, spaceBetween: 16 },
        1024: { slidesPerView: Math.max(2, perView), spaceBetween: 16 }
      }
    });
    root.querySelectorAll('.swiper-slide button[data-modal-src]').forEach((btn) => {
      btn.addEventListener('click', () => {
        const src = btn.getAttribute('data-modal-src');
        const modal = root.querySelector('.ace-image-modal');
        if (!modal) return;
        const img = modal.querySelector('img');
        img.setAttribute('src', src || '');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
      });
      btn.addEventListener('mouseenter', () => { if (autoplayEnabled && sw.autoplay) sw.autoplay.stop(); });
      btn.addEventListener('mouseleave', () => { if (autoplayEnabled && sw.autoplay) sw.autoplay.start(); });
    });
    const modal = root.querySelector('.ace-image-modal');
    if (modal) {
      const closeBtn = modal.querySelector('.js-modal-close');
      closeBtn && closeBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
      });
      modal.addEventListener('click', (e) => {
        if (e.target === modal) {
          modal.classList.add('hidden');
          modal.classList.remove('flex');
        }
      });
    }
  };
  const boot = () => {
    document.querySelectorAll('.ace-image-carousel').forEach(init);
  };
  if (document.readyState === 'complete' || document.readyState === 'interactive') {
    boot();
  } else {
    document.addEventListener('DOMContentLoaded', boot);
    window.addEventListener('load', boot);
  }
})();
