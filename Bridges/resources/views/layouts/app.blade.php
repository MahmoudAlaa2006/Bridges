<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Modular Dashboard Assets -->
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">

    @auth
        @php $userRole = strtolower(auth()->user()->role); @endphp
        @if($userRole === 'candidate')
            <link rel="stylesheet" href="{{ asset('css/candidate.css') }}">
        @endif
        @if($userRole === 'hr admin')
            <link rel="stylesheet" href="{{ asset('css/hr_admin.css') }}">
        @endif
    @endauth

    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    
    <aside id="sidebar">
        @yield('sidebar')
    </aside>

    <div id="main-content">
        <header class="app-header" id="topbar">
            <div class="d-flex align-items-center gap-3 flex-grow-1">
                <!-- Mobile Toggle -->
                <button class="icon-btn mobile-sidebar-toggle d-lg-none">
                    <i class="bi bi-list"></i>
                </button>
                
                <h1 class="page-title topbar-title">
                    @hasSection('header-title')
                        @yield('header-title')
                    @else
                        @yield('topbar-title', 'Dashboard')
                    @endif
                </h1>
            </div>

            <div class="header-actions">
                <div class="header-dropdown-wrap">
                    @auth
                        <button id="user-btn" class="user-pill">
                            <div class="avatar">
                                {{ substr(auth()->user()->first_name ?? 'U', 0, 1) }}{{ substr(auth()->user()->last_name ?? '', 0, 1) }}
                            </div>
                            <span class="user-name d-none d-sm-inline">{{ auth()->user()->first_name ?? 'User' }} {{ auth()->user()->last_name ?? '' }}</span>
                        </button>
                        
                        <!-- User Dropdown Menu -->
                        <div id="user-dropdown" class="cp-dropdown">
                            <div class="cp-dropdown-header">
                                {{ auth()->user()->email }}
                            </div>
                            <a href="{{ route('profile') }}" class="cp-dropdown-item">
                                <i class="bi bi-person me-2"></i> My Profile
                            </a>
                            <div class="cp-dropdown-divider"></div>
                            <button type="button" class="cp-dropdown-item danger logout-link">
                                <i class="bi bi-box-arrow-right me-2"></i> Log Out
                            </button>
                        </div>
                    @endauth
                </div>
            </div>
        </header>

        <main class="page-content page-body">
            @if(isset($slot))
                {{ $slot }}
            @else
                @yield('content')
            @endif
        </main>
    </div>

    <div id="modal-backdrop" class="hidden">
        <div id="modal-panel"></div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Modular Dashboard Scripts -->
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>

    @auth
        @if($userRole === 'candidate')
            <script src="{{ asset('js/candidate.js') }}"></script>
        @endif
        @if($userRole === 'hr admin')
            <script src="{{ asset('js/hr_admin.js') }}"></script>
        @endif
    @endauth

    @stack('scripts')
</body>
</html>
