/* ============================================================
   CareerPortal HR Dashboard — Main JavaScript
   UI interactions only: sidebar, tabs, search, notifications.
   ============================================================ */

document.addEventListener('DOMContentLoaded', function () {

  /* ── SIDEBAR COLLAPSE (DESKTOP) ── 
     Toggles the 'collapsed' class on the sidebar to shrink it to icon-only view.
     The CSS handles the width transition and label visibility.
  */
  var sidebar      = document.getElementById('sidebar');
  var toggleBtn    = document.getElementById('sidebar-toggle');
  var mobileToggle = document.getElementById('mobile-sidebar-toggle');


  if (toggleBtn) {
    toggleBtn.addEventListener('click', function () {
      sidebar.classList.toggle('collapsed');
      // Update the toggle button icon based on the new state
      var icon = this.querySelector('i');
      if (icon) {
        icon.className = sidebar.classList.contains('collapsed')
          ? 'bi bi-chevron-right'
          : 'bi bi-chevron-left';
      }
    });
  }

  /* ── SIDEBAR TOGGLE (MOBILE) ── 
     Handles the sliding overlay sidebar for smaller screens. 
     Includes a dynamic backdrop to dim the background when the sidebar is open.
  */
  var backdrop = null;

  function openMobileSidebar() {
    sidebar.classList.add('mobile-open');
    if (!backdrop) {
      backdrop = document.createElement('div');
      backdrop.className = 'sidebar-backdrop';
      document.body.appendChild(backdrop);
      backdrop.addEventListener('click', closeMobileSidebar);
    }
    backdrop.style.display = 'block';
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
  }

  function closeMobileSidebar() {
    sidebar.classList.remove('mobile-open');
    if (backdrop) backdrop.style.display = 'none';
    document.body.style.overflow = ''; // Restore scrolling
  }

  if (mobileToggle) {
    mobileToggle.addEventListener('click', function () {
      if (sidebar.classList.contains('mobile-open')) {
        closeMobileSidebar();
      } else {
        openMobileSidebar();
      }
    });
  }

  /* ── NOTIFICATIONS PANEL TOGGLE ── 
     Toggles the visibility of the notification dropdown.
     Includes logic to close the panel when clicking outside.
  */
  var notifBtn   = document.getElementById('notif-btn');
  var notifPanel = document.getElementById('notif-panel');

  if (notifBtn && notifPanel) {
    notifBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      notifPanel.classList.toggle('open');
    });

    document.addEventListener('click', function (e) {
      if (!notifPanel.contains(e.target) && e.target !== notifBtn) {
        notifPanel.classList.remove('open');
      }
    });
  }

  /* ── TAB SWITCHING (GENERIC CP-TABS) ── 
     A reusable system for switching content sections without page reloads.
     Uses 'data-target' on tabs and 'data-tab' on panels to match elements.
  */
  document.querySelectorAll('.cp-tabs').forEach(function (tabGroup) {
    var tabs    = tabGroup.querySelectorAll('.cp-tab');
    var groupId = tabGroup.getAttribute('data-group');
    var panels  = groupId ? document.querySelectorAll('[data-panel="' + groupId + '"]') : [];

    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        // Clear active state from all tabs in this group
        tabs.forEach(function (t) { t.classList.remove('active'); });
        tab.classList.add('active');

        // Show/Hide corresponding content panels
        var target = tab.getAttribute('data-target');
        panels.forEach(function (p) {
          p.style.display = (p.getAttribute('data-tab') === target) ? '' : 'none';
        });
      });
    });
  });

  /* ── BOOTSTRAP TOOLTIPS ── 
     Initializes all elements flagged for native Bootstrap tooltips.
  */
  document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
    new bootstrap.Tooltip(el);
  });

});

/**
 * GLOBAL OPENMODAL FUNCTION
 * Uses the custom backdrop system instead of Bootstrap for consistency and performance.
 * Injects HTML into the universal modal panel and unhides the backdrop.
 */
function openModal(content) {
  const backdrop = document.getElementById('modal-backdrop');
  const panel    = document.getElementById('modal-panel');
  if (backdrop && panel) {
    panel.innerHTML = content;
    backdrop.classList.remove('hidden');
    // Enable closing with the 'Esc' key for accessibility
    document.addEventListener('keydown', handleModalEsc);
  }
}

/**
 * GLOBAL CLOSEMODAL FUNCTION
 * Hides the modal backdrop and clears the keyboard event listener.
 */
function closeModal() {
  const backdrop = document.getElementById('modal-backdrop');
  if (backdrop) {
    backdrop.classList.add('hidden');
    document.removeEventListener('keydown', handleModalEsc);
  }
}

/**
 * ESCAPE KEY HANDLER
 * Specifically closes the modal when the user hits the Escape key.
 */
function handleModalEsc(e) {
  if (e.key === 'Escape') closeModal();
}

/**
 * BACKDROP CLICK LISTENER
 * Allows users to close the modal by clicking anywhere in the dark area 
 * outside the central panel.
 */
document.addEventListener('DOMContentLoaded', function() {
  const modalBackdrop = document.getElementById('modal-backdrop');
  if (modalBackdrop) {
    modalBackdrop.addEventListener('click', function (e) {
      // Ensure the click was on the backdrop itself, not an inner element
      if (e.target === modalBackdrop) closeModal();
    });
  }
});



