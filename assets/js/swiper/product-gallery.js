document.addEventListener('DOMContentLoaded', () => {
  if (typeof Swiper === 'undefined') return;

  const galleries = document.querySelectorAll('.product-gallery');
  if (!galleries.length) return;

  galleries.forEach((gallery) => {
    const mainEl = gallery.querySelector('.product-gallery-main');
    const thumbsEl = gallery.querySelector('.product-gallery-thumbs');

    if (!mainEl || !thumbsEl) return;

    const thumbsSwiper = new Swiper(thumbsEl, {
      watchSlidesProgress: true,
      freeMode: true,
      slideToClickedSlide: true,
      spaceBetween: 12,
      slidesPerView: 3.2,
      breakpoints: {
        640: {
          slidesPerView: 4,
          spaceBetween: 16,
        },
        1024: {
          slidesPerView: 4,
          spaceBetween: 18,
        },
      },
    });

    void new Swiper(mainEl, {
      slidesPerView: 1,
      spaceBetween: 24,
      thumbs: {
        swiper: thumbsSwiper,
      },
      observer: true,
      observeParents: true,
    });
  });
});

