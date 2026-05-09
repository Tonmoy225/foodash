/* ============================================================
   FooDash Admin JS
   ============================================================ */

document.addEventListener('DOMContentLoaded', function () {

  // ── AUTO DISMISS ALERTS ──
  document.querySelectorAll('.alert').forEach(el => {
    setTimeout(() => {
      el.style.transition = 'opacity .4s';
      el.style.opacity = '0';
      setTimeout(() => el.remove(), 400);
    }, 4000);
  });

  // ── CONFIRM DELETES ──
  document.querySelectorAll('form[onsubmit]').forEach(form => {
    // Already handled inline
  });

  // ── SIDEBAR ACTIVE STATE ──
  const path = window.location.pathname;
  document.querySelectorAll('.sidebar-nav a').forEach(a => {
    if (a.getAttribute('href') === path) a.classList.add('active');
  });

});
