<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'CareerPortal')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- Bootstrap 5 — grid and utility classes -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <!-- CareerPortal custom dark theme -->
  <link rel="stylesheet" href="{{ asset('css/candidate.css') }}" />
  @stack('styles')
</head>
<body>

<!-- ============================================================
     SIDEBAR
     ============================================================ -->
<aside id="sidebar">
    @yield('sidebar')
</aside>

<!-- ============================================================
     MAIN CONTENT
     ============================================================ -->
<div id="main-content">

  <!-- Header -->
  <header class="app-header">
    @include('layouts.partials.navbar')
  </header>

  <!-- Page Content -->
  <main class="page-content">
    @yield('content')
  </main>
</div>

<!-- Modal -->
<div id="modal-backdrop" class="hidden">
  <div id="modal-panel"></div>
</div>

<!-- Global Reusable Modal (Bootstrap 5) -->
<div class="modal fade" id="globalModal" tabindex="-1" aria-labelledby="globalModalLabel" aria-hidden="true">
  <div class="modal-dialog" id="globalModalDialog">
    <div class="modal-content" id="globalModalContent">
      <!-- Content injected via JS -->
    </div>
  </div>
</div>

<!-- Hidden logout form — used by sidebar logout button -->
<form method="POST" action="{{ route('logout') }}" id="logout-form" style="display:none">
  @csrf
</form>

<!-- Bootstrap 5 JS bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Shared UI interactions -->
<script src="{{ asset('js/candidate.js') }}"></script>
@stack('scripts')
</body>
</html>
