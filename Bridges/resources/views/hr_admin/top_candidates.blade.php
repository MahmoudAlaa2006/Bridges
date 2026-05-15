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

    <!-- Rank 1 -->
    <div class="col-12 col-md-6 col-xl-4">
      <div class="cp-card h-100">
        <div class="cp-card-body">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <span style="background:linear-gradient(135deg,#f6d365,#fda085);color:#7a3a00;font-size:.75rem;font-weight:700;padding:4px 12px;border-radius:20px;">
              <i class="bi bi-trophy-fill me-1"></i>Rank #1
            </span>
            <span style="color:var(--primary);font-size:.75rem;font-weight:600;">
              <i class="bi bi-star-fill me-1"></i>Top 10%
            </span>
          </div>
          <div class="d-flex align-items-center gap-3 mb-3">
            <div class="av-init" style="width:52px;height:52px;font-size:1rem;flex-shrink:0;">JS</div>
            <div>
              <div style="font-weight:700;font-size:.95rem;">John Smith</div>
              <div style="font-size:.78rem;color:var(--muted);">john@email.com</div>
              <div style="font-size:.78rem;color:var(--muted);"><i class="bi bi-briefcase me-1"></i>6 years experience</div>
            </div>
          </div>
          <div class="mb-3">
            <div class="d-flex justify-content-between mb-1" style="font-size:.78rem;">
              <span style="font-weight:500;">Overall Score</span>
              <span style="font-weight:700;color:var(--green);">92 / 100</span>
            </div>
            <div class="score-bar">
              <div class="score-bar-fill" style="width:92%;background:var(--green);"></div>
            </div>
          </div>
          <div class="mb-3" style="font-size:.78rem;color:var(--muted);">
            <div class="d-flex justify-content-between mb-1"><span>Technical</span><span style="color:var(--fg);font-weight:600;">95</span></div>
            <div class="d-flex justify-content-between mb-1"><span>Problem Solving</span><span style="color:var(--fg);font-weight:600;">91</span></div>
            <div class="d-flex justify-content-between mb-1"><span>Communication</span><span style="color:var(--fg);font-weight:600;">88</span></div>
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <span class="badge-stage bs-interview">Interview</span>
            <a href="{{ route('hr.candidates') }}" class="btn-primary-cp btn-sm-cp">View Profile</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Rank 2 -->
    <div class="col-12 col-md-6 col-xl-4">
      <div class="cp-card h-100">
        <div class="cp-card-body">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <span style="background:linear-gradient(135deg,#d7e1ee,#c8daea);color:#4a5568;font-size:.75rem;font-weight:700;padding:4px 12px;border-radius:20px;">
              <i class="bi bi-award-fill me-1"></i>Rank #2
            </span>
            <span style="color:var(--primary);font-size:.75rem;font-weight:600;">
              <i class="bi bi-star-fill me-1"></i>Top 10%
            </span>
          </div>
          <div class="d-flex align-items-center gap-3 mb-3">
            <div class="av-init" style="width:52px;height:52px;font-size:1rem;flex-shrink:0;">SJ</div>
            <div>
              <div style="font-weight:700;font-size:.95rem;">Sarah Johnson</div>
              <div style="font-size:.78rem;color:var(--muted);">sarah@email.com</div>
              <div style="font-size:.78rem;color:var(--muted);"><i class="bi bi-briefcase me-1"></i>5 years experience</div>
            </div>
          </div>
          <div class="mb-3">
            <div class="d-flex justify-content-between mb-1" style="font-size:.78rem;">
              <span style="font-weight:500;">Overall Score</span>
              <span style="font-weight:700;color:var(--green);">89 / 100</span>
            </div>
            <div class="score-bar">
              <div class="score-bar-fill" style="width:89%;background:var(--green);"></div>
            </div>
          </div>
          <div class="mb-3" style="font-size:.78rem;color:var(--muted);">
            <div class="d-flex justify-content-between mb-1"><span>Technical</span><span style="color:var(--fg);font-weight:600;">90</span></div>
            <div class="d-flex justify-content-between mb-1"><span>Problem Solving</span><span style="color:var(--fg);font-weight:600;">88</span></div>
            <div class="d-flex justify-content-between mb-1"><span>Communication</span><span style="color:var(--fg);font-weight:600;">92</span></div>
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <span class="badge-stage bs-offer">Offer</span>
            <a href="{{ route('hr.candidates') }}" class="btn-primary-cp btn-sm-cp">View Profile</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Rank 3 -->
    <div class="col-12 col-md-6 col-xl-4">
      <div class="cp-card h-100">
        <div class="cp-card-body">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <span style="background:linear-gradient(135deg,#ffd5a0,#fec17a);color:#7a4400;font-size:.75rem;font-weight:700;padding:4px 12px;border-radius:20px;">
              <i class="bi bi-award-fill me-1"></i>Rank #3
            </span>
            <span style="color:var(--primary);font-size:.75rem;font-weight:600;">
              <i class="bi bi-star-fill me-1"></i>Top 10%
            </span>
          </div>
          <div class="d-flex align-items-center gap-3 mb-3">
            <div class="av-init" style="width:52px;height:52px;font-size:1rem;flex-shrink:0;">MC</div>
            <div>
              <div style="font-weight:700;font-size:.95rem;">Mike Chen</div>
              <div style="font-size:.78rem;color:var(--muted);">mike@email.com</div>
              <div style="font-size:.78rem;color:var(--muted);"><i class="bi bi-briefcase me-1"></i>4 years experience</div>
            </div>
          </div>
          <div class="mb-3">
            <div class="d-flex justify-content-between mb-1" style="font-size:.78rem;">
              <span style="font-weight:500;">Overall Score</span>
              <span style="font-weight:700;color:var(--green);">87 / 100</span>
            </div>
            <div class="score-bar">
              <div class="score-bar-fill" style="width:87%;background:var(--green);"></div>
            </div>
          </div>
          <div class="mb-3" style="font-size:.78rem;color:var(--muted);">
            <div class="d-flex justify-content-between mb-1"><span>Technical</span><span style="color:var(--fg);font-weight:600;">89</span></div>
            <div class="d-flex justify-content-between mb-1"><span>Problem Solving</span><span style="color:var(--fg);font-weight:600;">86</span></div>
            <div class="d-flex justify-content-between mb-1"><span>Communication</span><span style="color:var(--fg);font-weight:600;">83</span></div>
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <span class="badge-stage bs-exam">Exam</span>
            <a href="{{ route('hr.candidates') }}" class="btn-primary-cp btn-sm-cp">View Profile</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Rank 4 -->
    <div class="col-12 col-md-6 col-xl-4">
      <div class="cp-card h-100">
        <div class="cp-card-body">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <span style="background:linear-gradient(135deg,#d1fae5,#a7f3d0);color:#065f46;font-size:.75rem;font-weight:700;padding:4px 12px;border-radius:20px;">
              <i class="bi bi-award-fill me-1"></i>Rank #4
            </span>
            <span style="color:var(--primary);font-size:.75rem;font-weight:600;">
              <i class="bi bi-star-fill me-1"></i>Top 10%
            </span>
          </div>
          <div class="d-flex align-items-center gap-3 mb-3">
            <div class="av-init" style="width:52px;height:52px;font-size:1rem;flex-shrink:0;">ED</div>
            <div>
              <div style="font-weight:700;font-size:.95rem;">Emily Davis</div>
              <div style="font-size:.78rem;color:var(--muted);">emily@email.com</div>
              <div style="font-size:.78rem;color:var(--muted);"><i class="bi bi-briefcase me-1"></i>7 years experience</div>
            </div>
          </div>
          <div class="mb-3">
            <div class="d-flex justify-content-between mb-1" style="font-size:.78rem;">
              <span style="font-weight:500;">Overall Score</span>
              <span style="font-weight:700;color:var(--green);">85 / 100</span>
            </div>
            <div class="score-bar">
              <div class="score-bar-fill" style="width:85%;background:var(--green);"></div>
            </div>
          </div>
          <div class="mb-3" style="font-size:.78rem;color:var(--muted);">
            <div class="d-flex justify-content-between mb-1"><span>Technical</span><span style="color:var(--fg);font-weight:600;">82</span></div>
            <div class="d-flex justify-content-between mb-1"><span>Problem Solving</span><span style="color:var(--fg);font-weight:600;">87</span></div>
            <div class="d-flex justify-content-between mb-1"><span>Communication</span><span style="color:var(--fg);font-weight:600;">90</span></div>
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <span class="badge-stage bs-interview">Interview</span>
            <a href="{{ route('hr.candidates') }}" class="btn-primary-cp btn-sm-cp">View Profile</a>
          </div>
        </div>
      </div>
    </div>

  </div><!-- /row -->
@endsection
