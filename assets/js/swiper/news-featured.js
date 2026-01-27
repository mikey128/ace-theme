;(function(){
  function init(){
    var containers = document.querySelectorAll('.js-news-featured-swiper');
    if (!containers.length || typeof Swiper === 'undefined') { return; }
    containers.forEach(function(el){
      var paginationEl = el.querySelector('.swiper-pagination');
      new Swiper(el, {
        slidesPerView: 1,
        spaceBetween: 16,
        centeredSlides: true,
        loop: true,
        speed: 600,
        observer: true,
        observeParents: true,
        pagination: {
          el: paginationEl,
          clickable: true
        },
        autoplay: {
          delay: 8000,
          disableOnInteraction: false,
          pauseOnMouseEnter: true
        }
      });
    });
  }
  if (document.readyState === 'complete' || document.readyState === 'interactive') {
    init();
  } else {
    document.addEventListener('DOMContentLoaded', init);
    window.addEventListener('load', init);
  }
})();
