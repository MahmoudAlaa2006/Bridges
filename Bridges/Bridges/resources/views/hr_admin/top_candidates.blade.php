@extends('layouts.app')


@section('sidebar')
    @include('layouts.partials.hr_admin_sidebar')
@endsection
@section('title', 'Top 10% — Senior Backend Developer')
@section('topbar-title', 'Top 10% – Senior Backend Developer')

<link rel="stylesheet" href="{{ asset('css/hr_admin.css') }}" />

@section('content')
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb" style="font-size:.82rem;background:none;padding:0;margin:0;">
      <li class="breadcrumb-item">
        <a href="{{ route('hr.jobs') }}" style="color:var(--muted);">Jobs</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('hr.all-candidates') }}" style="color:var(--muted);">All Candidates</a>
      </li>
      <li class="breadcrumb-item active" style="color:var(--primary);">Top 10%</li>
    </ol>
  </nav>

  <!-- Page heading -->
  <div class="d-flex align-items-start justify-content-between flex-wrap gap-3 mb-4">
    <div>
      <h1 class="page-section-title">
        <i class="bi bi-star-fill text-primary me-2"></i>Top 10%
      </h1>
      <p class="page-section-sub">Candidates scoring in the top 10% for "Senior Backend Developer".</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('hr.all-candidates') }}" class="btn-outline-cp">
        <i class="bi bi-people"></i> All Candidates
      </a>
      <a href="{{ route('hr.top-candidates') }}" class="btn-primary-cp">
        <i class="bi bi-star-fill"></i> Top 10%
      </a>
    </div>
  </div>

  <!-- Top Candidate Cards -->
  <div class="row g-3">
    @forelse($topCandidates as $index => $app)
      @php
        $candidate = $app->candidate;
        $initials = strtoupper(substr($candidate->first_name, 0, 1) . substr($candidate->last_name, 0, 1));
        $rank = $index + 1;
        $bgGradient = match($rank) {
          1 => 'linear-gradient(135deg,#f6d365,#fda085)',
          2 => 'linear-gradient(135deg,#d7e1ee,#c8daea)',
          3 => 'linear-gradient(135deg,#ffd5a0,#fec17a)',
          default => 'linear-gradient(135deg,#d1fae5,#a7f3d0)'
        };
        $color = match($rank) {
          1 => '#7a3a00',
          2 => '#4a5568',
          3 => '#7a4400',
          default => '#065f46'
        };
        $icon = match($rank) {
          1 => 'bi-trophy-fill',
          default => 'bi-award-fill'
        };
      @endphp
      <!-- Rank {{ $rank }} -->
      <div class="col-12 col-md-6 col-xl-4">
        <div class="cp-card h-100">
          <div class="cp-card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <span style="background:{{ $bgGradient }};color:{{ $color }};font-size:.75rem;font-weight:700;padding:4px 12px;border-radius:20px;">
                <i class="bi {{ $icon }} me-1"></i>Rank #{{ $rank }}
              </span>
              <span style="color:var(--primary);font-size:.75rem;font-weight:600;">
                <i class="bi bi-star-fill me-1"></i>Top 10%
              </span>
            </div>
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="av-init" style="width:52px;height:52px;font-size:1rem;flex-shrink:0;">{{ $initials }}</div>
              <div>
                <div style="font-weight:700;font-size:.95rem;">{{ $candidate->first_name }} {{ $candidate->last_name }}</div>
                <div style="font-size:.78rem;color:var(--muted);">{{ $candidate->email }}</div>
                <div style="font-size:.78rem;color:var(--muted);"><i class="bi bi-briefcase me-1"></i>{{ $candidate->age ? $candidate->age . ' years old' : 'Age not provided' }}</div>
              </div>
            </div>
            <div class="mb-3">
              <div class="d-flex justify-content-between mb-1" style="font-size:.78rem;">
                <span style="font-weight:500;">Overall Score</span>
                <span style="font-weight:700;color:var(--green);">{{ $app->match_score }} / 100</span>
              </div>
              <div class="score-bar">
                <div class="score-bar-fill" style="width:{{ $app->match_score }}%;background:var(--green);"></div>
              </div>
            </div>
            <div class="mb-3" style="font-size:.78rem;color:var(--muted);">
              <div class="d-flex justify-content-between mb-1"><span>Technical</span><span style="color:var(--fg);font-weight:600;">N/A</span></div>
              <div class="d-flex justify-content-between mb-1"><span>Problem Solving</span><span style="color:var(--fg);font-weight:600;">N/A</span></div>
              <div class="d-flex justify-content-between mb-1"><span>Communication</span><span style="color:var(--fg);font-weight:600;">N/A</span></div>
            </div>
            <div class="d-flex align-items-center justify-content-between">
              <span class="badge-stage bs-{{ strtolower($app->status) }}">{{ ucfirst($app->status) }}</span>
              <a href="{{ route('hr.candidates', $candidate->id) }}" class="btn-primary-cp btn-sm-cp">View Profile</a>
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12 text-center py-5 text-muted">No top candidates found.</div>
    @endforelse
  </div><!-- /row -->
@endsection
