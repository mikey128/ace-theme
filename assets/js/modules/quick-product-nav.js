document.addEventListener('DOMContentLoaded', function () {
  var sectionEl = document.querySelector('.quick-product-nav');
  if (!sectionEl) return;
  var navEl = sectionEl.querySelector('nav');
  if (!navEl) return;
  var header = document.getElementById('site-header') || document.querySelector('header');
  var adminBar = document.getElementById('wpadminbar');
  var placeholder = document.createElement('div');
  var fixed = false;
  var initialTop = sectionEl.getBoundingClientRect().top + window.pageYOffset;
  var initialHeight = sectionEl.offsetHeight;
  var fixY = initialTop + initialHeight;
  var unfixY = initialTop - headerOffset();
  var links = Array.prototype.slice.call(sectionEl.querySelectorAll('a[data-nav-link][href^="#"]'));
  var targets = links.map(function (a) {
    var id = a.getAttribute('href').replace('#','');
    return { id: id, el: document.getElementById(id), link: a };
  }).filter(function (t) { return t.el; });
  function adminBarHeight() {
    var isMobile = window.innerWidth < 768;
    if (isMobile) return 0;
    return adminBar ? adminBar.offsetHeight : 0;
  }
  function headerOffset() {
    var offset = 0;
    if (header) {
      var isSticky = header.classList.contains('fixed');
      offset += isSticky ? header.offsetHeight : 0;
    }
    offset += adminBarHeight();
    return offset;
  }
  function setPlaceholder() {
    placeholder.style.height = sectionEl.offsetHeight + 'px';
  }
  function fix() {
    if (fixed) return;
    fixed = true;
    setPlaceholder();
    sectionEl.parentNode.insertBefore(placeholder, sectionEl.nextSibling);
    sectionEl.style.position = 'fixed';
    sectionEl.style.left = '0';
    sectionEl.style.right = '0';
    sectionEl.style.top = headerOffset() + 'px';
    sectionEl.style.zIndex = '9999';
    sectionEl.classList.add('shadow-md','bg-white');
  }
  function unfix() {
    if (!fixed) return;
    fixed = false;
    sectionEl.style.position = '';
    sectionEl.style.left = '';
    sectionEl.style.right = '';
    sectionEl.style.top = '';
    sectionEl.style.zIndex = '';
    sectionEl.classList.remove('shadow-md','bg-white');
    if (placeholder.parentNode) placeholder.parentNode.removeChild(placeholder);
  }
  function setActive(id) {
    links.forEach(function (a) {
      if (a.getAttribute('href') === '#' + id) {
        a.classList.remove('text-gray-900', 'hover:text-brand-accent');
        a.classList.add('text-brand-accent');
      } else {
        a.classList.remove('text-brand-accent');
        a.classList.add('text-gray-900', 'hover:text-brand-accent');
      }
    });
  }
  // Initialize default styles on all links
  links.forEach(function (a) {
    a.classList.add('text-gray-900', 'hover:text-brand-accent');
  });
  function updateActive() {
    var navHeight = sectionEl.offsetHeight;
    var offset = headerOffset() + navHeight + 20; // Add extra buffer
    var scrollPos = window.scrollY + offset;
    
    var current = null;
    
    // Find the current section
    for (var i = 0; i < targets.length; i++) {
      var target = targets[i];
      var elTop = target.el.getBoundingClientRect().top + window.pageYOffset;
      var elBottom = elTop + target.el.offsetHeight;

      // Check if scroll position is within this section
      if (scrollPos >= elTop && scrollPos < elBottom) {
        current = target;
        break; 
      }
      
      // Fallback: if we are past the start of this section, it *might* be the one,
      // but we continue checking to find the *last* one we passed (closest to top)
      if (scrollPos >= elTop) {
        current = target;
      }
    }
    
    if (current) setActive(current.id);
    else if (targets.length && window.scrollY < targets[0].el.getBoundingClientRect().top) setActive(targets[0].id);
  }
  function onScroll() {
    var viewportTop = window.scrollY + headerOffset();
    if (!fixed && viewportTop >= fixY) {
      fix();
    }
    if (fixed && viewportTop < unfixY) {
      unfix();
    }
    updateActive();
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', function () {
    if (fixed) {
      setPlaceholder();
      sectionEl.style.top = headerOffset() + 'px';
    } else {
      initialTop = sectionEl.getBoundingClientRect().top + window.pageYOffset;
      initialHeight = sectionEl.offsetHeight;
      fixY = initialTop + initialHeight;
      unfixY = initialTop - headerOffset();
    }
    updateActive();
  });
  var links = navEl.querySelectorAll('a[href^="#"]');
  links.forEach(function (a) {
    a.addEventListener('click', function (e) {
      var href = a.getAttribute('href');
      var id = href.replace('#', '');
      var target = document.getElementById(id);
      if (!target) return;
      e.preventDefault();
      var y = target.getBoundingClientRect().top + window.pageYOffset - headerOffset() - sectionEl.offsetHeight;
      window.scrollTo({ top: y, behavior: 'smooth' });
    });
  });
  updateActive();
}); 
