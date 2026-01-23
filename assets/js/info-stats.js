(() => {
  const parseTarget = (raw) => {
    const s = String(raw || '0').trim();
    const suffixPlus = s.endsWith('+');
    const numeric = parseInt(s.replace(/[^\d]/g, ''), 10) || 0;
    return { numeric, suffixPlus };
  };

  const animateNumber = (el, target, suffixPlus) => {
    const duration = 1200;
    const start = performance.now();
    const from = 0;
    const step = (now) => {
      const p = Math.min((now - start) / duration, 1);
      const val = Math.round(from + (target - from) * p);
      el.textContent = val.toLocaleString() + (p === 1 && suffixPlus ? '+' : '');
      if (p < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (!entry.isIntersecting) return;
      const el = entry.target;
      if (el.__infoStatsAnimated) return;
      el.__infoStatsAnimated = true;
      const data = parseTarget(el.getAttribute('data-info-stat-target'));
      animateNumber(el, data.numeric, data.suffixPlus);
      observer.unobserve(el);
    });
  }, { threshold: 0.3 });

  const initRoot = (root) => {
    const els = root.querySelectorAll('[data-info-stat-target]');
    els.forEach((el) => observer.observe(el));
  };

  const boot = () => {
    document.querySelectorAll('.ace-info-stats').forEach(initRoot);
  };

  if (document.readyState === 'complete' || document.readyState === 'interactive') {
    boot();
  } else {
    document.addEventListener('DOMContentLoaded', boot);
    window.addEventListener('load', boot);
  }
})();
