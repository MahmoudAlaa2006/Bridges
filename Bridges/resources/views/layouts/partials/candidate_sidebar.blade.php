<!-- SIDEBAR HEADER: Branding and navigation collapse toggle -->
<div class="sidebar-header">
    <div class="d-flex align-items-center" style="gap:8px;overflow:hidden">
      <div class="logo-icon">CP</div>
      <span class="sidebar-brand">CareerPortal</span>
    </div>
    <!-- SIDEBAR TOGGLE: Shrinks the sidebar to icon-only mode. Managed by candidate.js -->
    <button id="sidebar-toggle" class="btn-icon">
      <svg id="icon-collapse" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
      <svg id="icon-expand" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="hidden"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
    </button>
</div>

<!-- CANDIDATE NAVIGATION: Primary links for the candidate journey -->
<nav class="sidebar-nav">
    <!-- OVERVIEW: Main dashboard landing -->
    <a href="{{ url('candidate/overview') }}" class="nav-item {{ request()->is('candidate/overview') ? 'active' : '' }}">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
      <span class="nav-label">Overview</span>
    </a>
    <!-- JOBS: Browsing available opportunities -->
    <a href="{{ url('candidate/jobs') }}" class="nav-item {{ request()->is('candidate/jobs') ? 'active' : '' }}">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
      <span class="nav-label">Browse Jobs</span>
    </a>
    <!-- EXAMS: Highlighting active or pending assessments (supports wildcard for active templates) -->
    <a href="{{ url('candidate/exam') }}" class="nav-item {{ request()->is('candidate/exam*') ? 'active' : '' }}">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
      <span class="nav-label">Exams</span>
    </a>
    <!-- INTERVIEWS: Personal interview schedule -->
    <a href="{{ url('candidate/interview') }}" class="nav-item {{ request()->is('candidate/interview') ? 'active' : '' }}">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.55-2.07A1 1 0 0121 8.82v6.36a1 1 0 01-1.45.89L15 14M3 8a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg>
      <span class="nav-label">Interview</span>
    </a>
    <!-- OFFERS: Reviewing and accepting job offers -->
    <a href="{{ url('candidate/offer') }}" class="nav-item {{ request()->is('candidate/offer') ? 'active' : '' }}">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/></svg>
      <span class="nav-label">Offers</span>
    </a>
    <!-- PROFILE: Personal account management -->
    <a href="{{ url('candidate/profile') }}" class="nav-item {{ request()->is('candidate/profile') ? 'active' : '' }}">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      <span class="nav-label">Profile</span>
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