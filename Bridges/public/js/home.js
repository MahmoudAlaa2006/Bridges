/* ============================================================
   BRIDGES — AI Recruitment System | script.js
   ============================================================ */

/* ── Intersection Observer: fade-up animations ── */
(function () {
  const observer = new IntersectionObserver(
    function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.12 }
  );

  document.querySelectorAll('.fade-up').forEach(function (el) {
    observer.observe(el);
  });
})();

/* ── Topbar shadow on scroll ── */
(function () {
  var topbar = document.getElementById('topbar');
  window.addEventListener('scroll', function () {
    if (window.scrollY > 10) {
      topbar.style.boxShadow = '0 4px 24px rgba(0,0,0,0.4)';
    } else {
      topbar.style.boxShadow = 'none';
    }
  });
})();
