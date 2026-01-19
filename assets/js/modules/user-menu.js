document.addEventListener('DOMContentLoaded', function () {
  var btn = document.querySelector('.js-user-menu');
  var dropdown = document.querySelector('.js-user-dropdown');
  if (!btn || !dropdown) return;

  function close() {
    dropdown.classList.add('hidden');
  }
  function open() {
    dropdown.classList.remove('hidden');
  }
  btn.addEventListener('click', function (e) {
    e.preventDefault();
    if (dropdown.classList.contains('hidden')) open();
    else close();
  });
  document.addEventListener('click', function (e) {
    if (!dropdown.contains(e.target) && !btn.contains(e.target)) close();
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') close();
  });
});

