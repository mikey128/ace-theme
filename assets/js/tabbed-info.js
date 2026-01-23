(() => {
  const ACTIVE = 'bg-brand-accent text-white border-transparent shadow-sm';
  const INACTIVE = 'bg-white text-gray-900 border-gray-300 hover:border-brand-accent hover:text-brand-accent';
  const init = (root) => {
    const btns = Array.from(root.querySelectorAll('[data-tab-target]'));
    const panels = Array.from(root.querySelectorAll('[data-tab-panel]'));
    if (!btns.length || !panels.length) return;
    const show = (id) => {
      panels.forEach((p) => {
        const active = p.getAttribute('data-tab-panel') === id;
        p.classList.toggle('hidden', !active);
      });
      btns.forEach((b) => {
        const active = b.getAttribute('data-tab-target') === id;
        if (active) {
          b.classList.add(...ACTIVE.split(' '));
          b.classList.remove(...INACTIVE.split(' '));
          b.setAttribute('aria-selected', 'true');
        } else {
          b.classList.add(...INACTIVE.split(' '));
          b.classList.remove(...ACTIVE.split(' '));
          b.setAttribute('aria-selected', 'false');
        }
      });
    };
    const firstId = btns[0].getAttribute('data-tab-target');
    show(firstId);
    btns.forEach((b) => {
      b.addEventListener('click', () => show(b.getAttribute('data-tab-target')));
    });
  };
  const boot = () => {
    document.querySelectorAll('.ace-tabbed-info').forEach(init);
  };
  if (document.readyState === 'complete' || document.readyState === 'interactive') {
    boot();
  } else {
    document.addEventListener('DOMContentLoaded', boot);
    window.addEventListener('load', boot);
  }
})();
