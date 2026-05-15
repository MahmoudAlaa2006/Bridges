<!-- SIDEBAR BRAND AREA: Contains logo and collapse toggle -->
<div class="sidebar-brand">
    <div class="brand-inner">
      <div class="brand-icon-wrap"><span>CP</span></div>
      <span class="brand-name">CareerPortal</span>
    </div>
    <!-- SIDEBAR TOGGLE: Managed by hr_admin.js to shrink the sidebar width -->
    <button id="sidebar-toggle" class="brand-toggle">
      <i class="bi bi-chevron-left"></i>
    </button>
</div>

<!-- PRIMARY NAVIGATION: HR Admin specific routes -->
<nav class="sidebar-nav">
    <!-- OVERVIEW: General dashboard stats -->
    <a href="{{ url('hr-admin/overview') }}" class="nav-link {{ request()->is('hr-admin/overview') ? 'active' : '' }}">
      <i class="bi bi-grid-fill"></i>
      <span class="sidebar-label">Overview</span>
    </a>
    <!-- REQUISITIONS: Internal job requests -->
    <a href="{{ url('hr-admin/requisitions') }}" class="nav-link {{ request()->is('hr-admin/requisitions') ? 'active' : '' }}">
      <i class="bi bi-clipboard-check-fill"></i>
      <span class="sidebar-label">Job Requisitions</span>
    </a>
    <!-- JOBS: Published job openings -->
    <a href="{{ url('hr-admin/jobs') }}" class="nav-link {{ request()->is('hr-admin/jobs') ? 'active' : '' }}">
      <i class="bi bi-briefcase-fill"></i>
      <span class="sidebar-label">Jobs</span>
    </a>
    <!-- CANDIDATES: Application tracking -->
    <a href="{{ url('hr-admin/candidates') }}" class="nav-link {{ request()->is('hr-admin/candidates') ? 'active' : '' }}">
      <i class="bi bi-people-fill"></i>
      <span class="sidebar-label">Candidates</span>
    </a>
    <!-- OFFERS: Hiring and onboarding stage -->
    <a href="{{ url('hr-admin/offers') }}" class="nav-link {{ request()->is('hr-admin/offers') ? 'active' : '' }}">
      <i class="bi bi-gift-fill"></i>
      <span class="sidebar-label">Offers</span>
    </a>
    <!-- REPORTS: System logs and analytics -->
    <a href="{{ url('hr-admin/reports') }}" class="nav-link {{ request()->is('hr-admin/reports') ? 'active' : '' }}">
      <i class="bi bi-file-earmark-bar-graph-fill"></i>
      <span class="sidebar-label">Reports</span>
    </a>
    <!-- PROFILE: HR personal settings -->
    <a href="{{ url('hr-admin/profile') }}" class="nav-link {{ request()->is('hr-admin/profile') ? 'active' : '' }}">
      <i class="bi bi-person-circle"></i>
      <span class="sidebar-label">Profile</span>
    </a>
</nav>

<!-- SIDEBAR FOOTER: Settings and account termination -->
<div class="sidebar-footer">
    <a href="#" class="nav-item">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
      <span class="nav-label">Settings</span>
    </a>
    <!-- LOGOUT BUTTON: Triggers the hidden logout form in app.blade.php -->
    <button class="nav-item nav-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
      <span class="nav-label">Log out</span>
    </button>
</div>
