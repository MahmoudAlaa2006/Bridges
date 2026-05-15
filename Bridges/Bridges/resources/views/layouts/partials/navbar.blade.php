<h1 class="page-title">@yield('header-title')</h1>
<div class="header-actions">
  @yield('header-actions-prefix')

  {{-- ── Notifications Bell ── --}}
  <div class="header-dropdown-wrap">
    <button id="notif-btn" class="btn-icon" title="Notifications">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="M13.73 21a2 2 0 01-3.46 0"/>
      </svg>
      <span class="notif-count" id="notif-badge" style="display:none">0</span>
    </button>

    <div id="notif-dropdown" class="cp-dropdown notif-dropdown hidden">
      <div class="cp-dropdown-header d-flex align-items-center justify-content-between">
        <span>Notifications</span>
        <button id="notif-mark-all"
          style="font-size:11px;color:var(--primary);background:none;border:none;cursor:pointer;padding:0;line-height:1">
          Mark all read
        </button>
      </div>
      <div id="notif-list" style="max-height:320px;overflow-y:auto">
        <div style="padding:20px;text-align:center;color:var(--muted-fg);font-size:13px">Loading…</div>
      </div>
    </div>
  </div>

  {{-- ── User Menu ── --}}
  <div class="header-dropdown-wrap">
    <button id="user-btn" class="user-btn">
      <div class="user-avatar">{{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 2)) }}</div>
      <span class="user-name d-none d-md-block">{{ auth()->user()?->name ?? 'User' }}</span>
    </button>

    <div id="user-dropdown" class="cp-dropdown hidden">
      <div class="cp-dropdown-header">My Account</div>
      <a href="{{ url('profile') }}" class="cp-dropdown-item">Profile</a>
      <div class="cp-dropdown-divider"></div>
      <form method="POST" action="{{ route('logout') }}" style="margin:0">
        @csrf
        <button type="submit" class="cp-dropdown-item danger" style="width:100%;text-align:left">Log out</button>
      </form>
    </div>
  </div>
</div>

<script>
/* ============================================================
   Navbar — Dropdowns + Live Notifications
   Self-contained IIFE; runs after DOM is ready.
   ============================================================ */
(function () {
  'use strict';

  /* ── helpers ── */
  const $  = id => document.getElementById(id);
  const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

  function escHtml(str) {
    return String(str ?? '')
      .replace(/&/g, '&amp;').replace(/</g, '&lt;')
      .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
  }

  function timeAgo(dateStr) {
    if (!dateStr) return '';
    const s = Math.floor((Date.now() - new Date(dateStr).getTime()) / 1000);
    if (s < 60)    return 'just now';
    if (s < 3600)  return Math.floor(s / 60)  + 'm ago';
    if (s < 86400) return Math.floor(s / 3600) + 'h ago';
    return Math.floor(s / 86400) + 'd ago';
  }

  /* ── dropdown toggle ── */
  function setupDropdown(btnId, dropdownId) {
    const btn  = $(btnId);
    const drop = $(dropdownId);
    if (!btn || !drop) return;

    btn.addEventListener('click', function (e) {
      e.stopPropagation();
      const wasHidden = drop.classList.contains('hidden');
      // close all dropdowns first
      document.querySelectorAll('.cp-dropdown').forEach(d => d.classList.add('hidden'));
      if (wasHidden) drop.classList.remove('hidden');
    });
  }

  // Close any open dropdown when clicking outside
  document.addEventListener('click', () => {
    document.querySelectorAll('.cp-dropdown').forEach(d => d.classList.add('hidden'));
  });

  // Prevent clicks inside a dropdown from bubbling to document
  document.querySelectorAll('.cp-dropdown').forEach(d => {
    d.addEventListener('click', e => e.stopPropagation());
  });

  /* ── setup both dropdowns ── */
  setupDropdown('notif-btn', 'notif-dropdown');
  setupDropdown('user-btn',  'user-dropdown');

  /* ── notification state ── */
  const badge   = $('notif-badge');
  const list    = $('notif-list');
  const markAll = $('notif-mark-all');
  let   loaded  = false;

  /* fetch unread count on page load (show badge) */
  fetch('{{ route("notifications.unread-count") }}', {
    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
  })
  .then(r => r.ok ? r.json() : { count: 0 })
  .then(data => {
    if (data.count > 0) {
      badge.textContent = data.count > 9 ? '9+' : data.count;
      badge.style.display = '';
    }
  })
  .catch(() => {});

  /* load notifications when bell opens (once per page load) */
  $('notif-btn').addEventListener('click', () => {
    if (loaded) return;
    loaded = true;

    fetch('{{ route("notifications.list") }}', {
      headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
    })
    .then(r => r.ok ? r.json() : [])
    .then(items => {
      renderNotifications(items);
      doMarkAllRead();            // auto-mark as read on open
    })
    .catch(() => {
      list.innerHTML = '<div style="padding:16px;text-align:center;color:var(--muted-fg);font-size:13px">Could not load notifications.</div>';
    });
  });

  /* "Mark all read" button */
  if (markAll) {
    markAll.addEventListener('click', e => {
      e.stopPropagation();
      doMarkAllRead();
    });
  }

  function renderNotifications(items) {
    if (!items || items.length === 0) {
      list.innerHTML = '<div style="padding:20px;text-align:center;color:var(--muted-fg);font-size:13px">No notifications yet.</div>';
      return;
    }

    list.innerHTML = items.map(n => {
      const unread = !n.read_at;
      return `
        <div class="notif-item d-flex gap-2${unread ? '' : ' read'}">
          <div class="notif-dot mt-1"${unread ? '' : ' style="background:var(--border)"'}></div>
          <div style="flex:1;min-width:0">
            <div class="notif-item-title">${escHtml(n.subject || 'Notification')}</div>
            <div class="notif-item-msg">${escHtml(n.message || '')}</div>
            <div class="notif-item-time">${timeAgo(n.created_at)}</div>
          </div>
        </div>`;
    }).join('');
  }

  function doMarkAllRead() {
    fetch('{{ route("notifications.mark-read") }}', {
      method: 'POST',
      headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
    })
    .then(r => r.ok ? r.json() : null)
    .then(() => {
      /* hide badge */
      badge.style.display = 'none';
      /* visually mark items as read */
      list.querySelectorAll('.notif-dot').forEach(d => d.style.background = 'var(--border)');
      list.querySelectorAll('.notif-item').forEach(i => i.classList.add('read'));
    })
    .catch(() => {});
  }

})();
</script>