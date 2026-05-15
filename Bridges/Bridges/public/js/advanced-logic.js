// ============================================================
// main.js — Shared UI interactions for all CareerPortal pages
// This file handles: sidebar toggle, dropdowns, modal open/close
// No data manipulation or application logic here.
// ============================================================

// ---- Element references ----
const sidebar     = document.getElementById('sidebar');
const mainContent = document.getElementById('main-content');
const sidebarToggle = document.getElementById('sidebar-toggle');
const iconCollapse  = document.getElementById('icon-collapse');
const iconExpand    = document.getElementById('icon-expand');

// ============================================================
// SIDEBAR TOGGLE
// Collapses the sidebar to icon-only mode and expands it back.
// The CSS handles the width transition via the 'collapsed' class.
// ============================================================
let sidebarCollapsed = false;

if (sidebarToggle) {
  sidebarToggle.addEventListener('click', function () {
    sidebarCollapsed = !sidebarCollapsed;

    if (sidebarCollapsed) {
      // Collapse sidebar: shrink width, hide labels, show expand icon
      sidebar.classList.add('collapsed');
      mainContent.classList.add('expanded');
      iconCollapse.classList.add('hidden');
      iconExpand.classList.remove('hidden');
    } else {
      // Expand sidebar: restore width, show labels, show collapse icon
      sidebar.classList.remove('collapsed');
      mainContent.classList.remove('expanded');
      iconCollapse.classList.remove('hidden');
      iconExpand.classList.add('hidden');
    }
  });
}

// Dropdowns and notifications are now handled by the centralized listener in app.blade.php

// ============================================================
// MODAL OPEN / CLOSE
// openModal(htmlString) — injects HTML into the panel and shows it
// closeModal()          — hides the modal
// ============================================================
function openModal(content) {
  const backdrop = document.getElementById('modal-backdrop');
  const panel    = document.getElementById('modal-panel');
  if (backdrop && panel) {
    panel.innerHTML = content;
    backdrop.classList.remove('hidden');
    // Allow closing with the Escape key
    document.addEventListener('keydown', handleModalEsc);
  }
}

function closeModal() {
  const backdrop = document.getElementById('modal-backdrop');
  if (backdrop) {
    backdrop.classList.add('hidden');
    document.removeEventListener('keydown', handleModalEsc);
  }
}

// Close modal when the Escape key is pressed
function handleModalEsc(e) {
  if (e.key === 'Escape') closeModal();
}

// Close modal when clicking the dark backdrop (outside the panel)
const modalBackdrop = document.getElementById('modal-backdrop');
if (modalBackdrop) {
  modalBackdrop.addEventListener('click', function (e) {
    if (e.target === modalBackdrop) closeModal();
  });
}
