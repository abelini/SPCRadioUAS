function toggleSidebar() {
  document.getElementById('menu').classList.toggle('open');
}

document.addEventListener('click', function (e) {
  var menu = document.getElementById('menu');
  var toggle = document.querySelector('.mobile-menu-btn');
  if (menu.classList.contains('open') && !menu.contains(e.target) && !toggle.contains(e.target)) {
    menu.classList.remove('open');
  }
});

document.addEventListener('keydown', function (e) {
  if (e.key === 'Escape') {
    document.getElementById('menu').classList.remove('open');
  }
});
