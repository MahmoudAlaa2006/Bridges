/* ============================================================
   CareerPortal Candidate Dashboard — Main JavaScript
   This file handles common UI patterns: 
   - Sidebar collapse (desktop and mobile)
   - Header dropdown management
   - Centralized modal system (Vanilla JS)
   ============================================================ */

// ---- ELEMENT REFERENCES: Cached for performance ----
const sidebar       = document.getElementById('sidebar');
const mainContent   = document.getElementById('main-content');
const sidebarToggle = document.getElementById('sidebar-toggle');
const iconCollapse  = document.getElementById('icon-collapse');
const iconExpand    = document.getElementById('icon-expand');

/* ── SIDEBAR TOGGLE LOGIC ── 
   Collapses the sidebar to icon-only mode and expands it back.
   Synchronizes SVG icons and layout width via CSS classes.
*/
let sidebarCollapsed = false;

if (sidebarToggle) {
  sidebarToggle.addEventListener('click', function () {
    sidebarCollapsed = !sidebarCollapsed;

    if (sidebarCollapsed) {
      // COLLAPSE: Shrink sidebar width, hide labels, toggle expand icon
      sidebar.classList.add('collapsed');
      mainContent.classList.add('expanded');
      iconCollapse.classList.add('hidden');
      iconExpand.classList.remove('hidden');
    } else {
      // EXPAND: Restore width, show labels, toggle collapse icon
      sidebar.classList.remove('collapsed');
      mainContent.classList.remove('expanded');
      iconCollapse.classList.remove('hidden');
      iconExpand.classList.add('hidden');
    }
  });
}

/* ── DROPDOWN MANAGEMENT (NOTIFICATIONS & USER MENU) ── 
   Handles manual toggles and ensures only one dropdown is open at a time.
*/
const notifBtn      = document.getElementById('notif-btn');
const notifDropdown = document.getElementById('notif-dropdown');
const userBtn       = document.getElementById('user-btn');
const userDropdown  = document.getElementById('user-dropdown');

// Notifications Toggle
if (notifBtn && notifDropdown) {
  notifBtn.addEventListener('click', function (e) {
    e.stopPropagation(); // Stop propagation to prevent document 'click' from firing
    notifDropdown.classList.toggle('hidden');
    // Ensure User dropdown is closed
    if (userDropdown) userDropdown.classList.add('hidden');
  });
}

// User Profile Toggle
if (userBtn && userDropdown) {
  userBtn.addEventListener('click', function (e) {
    e.stopPropagation();
    userDropdown.classList.toggle('hidden');
    // Ensure Notifications dropdown is closed
    if (notifDropdown) notifDropdown.classList.add('hidden');
  });
}

/* ── GLOBAL CLICK LISTENER ── 
   Closes all active dropdowns when the user clicks anywhere outside 
   of the dropdown menus or their trigger buttons.
*/
document.addEventListener('click', function () {
  if (notifDropdown) notifDropdown.classList.add('hidden');
  if (userDropdown)  userDropdown.classList.add('hidden');
});

/* ── UNIVERSAL MODAL SYSTEM ── 
   A lightweight replacement for Bootstrap modals. 
   Works by injecting dynamic HTML strings into a single hidden panel.
*/

/**
 * OPENS THE MODAL
 * @param {string} content - The HTML markup to display inside the modal.
 */
function openModal(content) {
  const backdrop = document.getElementById('modal-backdrop');
  const panel    = document.getElementById('modal-panel');
  if (backdrop && panel) {
    panel.innerHTML = content;
    backdrop.classList.remove('hidden');
    // Add listener for accessibility and power users
    document.addEventListener('keydown', handleModalEsc);
  }
}

/**
 * CLOSES THE MODAL
 * Cleans up the DOM state and removes event listeners.
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
 * Enables users to dismiss modals with a standard keyboard shortcut.
 */
function handleModalEsc(e) {
  if (e.key === 'Escape') closeModal();
}

/**
 * BACKDROP CLICK HANDLER
 * Closes the modal when clicking on the dark blurred area surrounding the panel.
 */
const modalBackdrop = document.getElementById('modal-backdrop');
if (modalBackdrop) {
  modalBackdrop.addEventListener('click', function (e) {
    // Only close if the backdrop itself was clicked (not the modal panel)
    if (e.target === modalBackdrop) closeModal();
  });
}

