document.addEventListener('DOMContentLoaded', function () {
  var header = document.getElementById('site-header');
  if (!header) return;
  var placeholder = document.createElement('div');
  var sticky = false;
  var adminBar = document.getElementById('wpadminbar');
  function getAdminBarHeight() {
    var isMobile = window.innerWidth < 768;
    if (isMobile) return 0;
    return adminBar ? adminBar.offsetHeight : 0;
  }
  function setPlaceholder() {
    placeholder.style.height = header.offsetHeight + 'px';
  }
  function activate() {
    if (sticky) return;
    sticky = true;
    setPlaceholder();
    header.parentNode.insertBefore(placeholder, header.nextSibling);
    header.classList.add('fixed','left-0','right-0','opacity-0','-translate-y-full');
    header.style.top = getAdminBarHeight() + 'px';
    header.style.zIndex = '10000';
    requestAnimationFrame(function(){
      header.classList.remove('opacity-0','-translate-y-full');
      header.classList.add('opacity-100','translate-y-0','shadow-sm','bg-white');
    });
  }
  function deactivate() {
    if (!sticky) return;
    sticky = false;
    header.classList.remove('fixed','left-0','right-0','opacity-100','translate-y-0','shadow-sm');
    header.style.top = '';
    header.style.zIndex = '';
    if (placeholder.parentNode) placeholder.parentNode.removeChild(placeholder);
  }
  function onScroll() {
    var threshold = 120;
    if (window.scrollY > threshold) activate();
    else deactivate();
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', function(){
    if (sticky) setPlaceholder();
    if (sticky) header.style.top = getAdminBarHeight() + 'px';
  });
}); 
