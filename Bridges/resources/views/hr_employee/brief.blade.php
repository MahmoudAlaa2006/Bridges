@extends('layouts.app')

@section('sidebar')
    @include('layouts.partials.hr_employee_sidebar')
@endsection

@section('title', 'Candidate Brief — Bridges')
@section('header-title', 'Candidate Brief')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/brief.css') }}">
@endpush

@section('content')
<div class="page-wrapper">
  <!-- Page Header -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="page-title mb-1">Candidate Brief</h1>
      <p class="text-muted mb-0">Full profile for the scheduled interview</p>
    </div>
    <span class="status-badge badge-upcoming">Interview: May 10, 2026</span>
  </div>

  <div class="row g-4">

    <!-- LEFT COLUMN -->
    <div class="col-lg-7">

      <!-- Candidate Identity -->
      <div class="card mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center gap-4 mb-4">
            <div class="avatar-circle">AC</div>
            <div>
              <h2 class="candidate-name">Alex Chen</h2>
              <p class="text-muted mb-1">Age: 27 &nbsp;·&nbsp; 5 years of experience</p>
              <p class="text-muted mb-0">📍 San Francisco, CA &nbsp;·&nbsp; alex.chen@email.com</p>
            </div>
          </div>
          <div class="section-label">Skills</div>
          <div class="d-flex flex-wrap gap-2">
            <span class="skill-tag">React</span>
            <span class="skill-tag">TypeScript</span>
            <span class="skill-tag">Node.js</span>
            <span class="skill-tag">GraphQL</span>
            <span class="skill-tag">PostgreSQL</span>
            <span class="skill-tag">Docker</span>
            <span class="skill-tag">AWS</span>
          </div>
        </div>
      </div>

      <!-- Scores -->
      <div class="card mb-4">
        <div class="card-body">
          <h5 class="card-title mb-4">Assessment Scores</h5>
          <div class="mb-4">
            <div class="d-flex justify-content-between mb-2">
              <span class="score-label">Application Score</span>
              <span class="score-value">87 / 100</span>
            </div>
            <div class="progress-track">
              <div class="progress-fill" style="width: 87%; background: #f5c542;"></div>
            </div>
          </div>
          <div>
            <div class="d-flex justify-content-between mb-2">
              <span class="score-label">Exam Score</span>
              <span class="score-value" style="color:#4ade80;">91 / 100</span>
            </div>
            <div class="progress-track">
              <div class="progress-fill" style="width: 91%; background: #4ade80;"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Cover Letter -->
      <div class="card mb-4">
        <div class="card-body">
          <h5 class="card-title mb-3">Cover Letter Summary</h5>
          <p class="text-light-muted" style="line-height:1.7;">
            Passionate frontend developer with 5 years of experience building scalable React applications.
            Strong advocate for clean code and great user experiences. Looking for a challenging senior role
            where I can lead a team and architect frontend systems. Particularly excited about this opportunity
            due to the engineering culture and the focus on developer tooling.
          </p>
        </div>
      </div>

      <!-- Previous Roles -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title mb-4">Work History</h5>
          <div class="role-item mb-4">
            <div class="d-flex justify-content-between align-items-start mb-1">
              <div>
                <div class="role-title">Frontend Lead</div>
                <div class="role-company">Stripe</div>
              </div>
              <span class="role-period">2021 – 2024</span>
            </div>
            <p class="text-light-muted small mt-2 mb-0">Led a team of 4 frontend engineers, architected the merchant dashboard redesign. Reduced bundle size by 40% and improved Core Web Vitals scores.</p>
          </div>
          <div class="divider"></div>
          <div class="role-item mt-4">
            <div class="d-flex justify-content-between align-items-start mb-1">
              <div>
                <div class="role-title">React Developer</div>
                <div class="role-company">Airbnb</div>
              </div>
              <span class="role-period">2019 – 2021</span>
            </div>
            <p class="text-light-muted small mt-2 mb-0">Developed and maintained core booking flow components. Collaborated with design teams to implement the new design system using Storybook.</p>
          </div>
        </div>
      </div>

    </div>

    <!-- RIGHT COLUMN -->
    <div class="col-lg-5">

      <!-- Job Details -->
      <div class="card mb-4">
        <div class="card-body">
          <h5 class="card-title mb-4">Job Details</h5>
          <div class="detail-row">
            <span class="detail-label">Job Title</span>
            <span class="detail-value">Senior Frontend Developer</span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Type</span>
            <span class="detail-value">Full-time</span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Seniority</span>
            <span class="detail-value">Senior</span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Work Mode</span>
            <span class="detail-value">Hybrid</span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Salary Range</span>
            <span class="detail-value" style="color:#f5c542;">$110k – $145k</span>
          </div>
          <div class="mt-3">
            <div class="detail-label mb-2">Required Skills</div>
            <div class="d-flex flex-wrap gap-2">
              <span class="skill-tag-sm">React</span>
              <span class="skill-tag-sm">TypeScript</span>
              <span class="skill-tag-sm">CSS3</span>
              <span class="skill-tag-sm">REST APIs</span>
              <span class="skill-tag-sm">Testing</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Education -->
      <div class="card mb-4">
        <div class="card-body">
          <h5 class="card-title mb-4">Education</h5>
          <div class="d-flex gap-3 align-items-start">
            <div class="edu-icon">🎓</div>
            <div>
              <div class="role-title">B.Sc Computer Science</div>
              <div class="role-company">Massachusetts Institute of Technology</div>
              <div class="role-period">Graduated 2018</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Exam Breakdown -->
      <div class="card mb-4">
        <div class="card-body">
          <h5 class="card-title mb-4">Exam Performance Breakdown</h5>
          <div class="mb-3">
            <div class="d-flex justify-content-between mb-1">
              <span class="score-label">MCQ Section</span>
              <span class="score-value">38 / 40</span>
            </div>
            <div class="progress-track"><div class="progress-fill" style="width:95%;background:#8b5cf6;"></div></div>
          </div>
          <div class="mb-3">
            <div class="d-flex justify-content-between mb-1">
              <span class="score-label">Written Section</span>
              <span class="score-value">28 / 30</span>
            </div>
            <div class="progress-track"><div class="progress-fill" style="width:93%;background:#f5c542;"></div></div>
          </div>
          <div>
            <div class="d-flex justify-content-between mb-1">
              <span class="score-label">Coding Section</span>
              <span class="score-value">25 / 30</span>
            </div>
            <div class="progress-track"><div class="progress-fill" style="width:83%;background:#4ade80;"></div></div>
          </div>
        </div>
      </div>

      <!-- Interview Info -->
      <div class="card" style="border-color: rgba(245,197,66,0.3);">
        <div class="card-body">
          <h5 class="card-title mb-3">Interview Details</h5>
          <div class="detail-row">
            <span class="detail-label">Date</span>
            <span class="detail-value">May 10, 2026</span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Time</span>
            <span class="detail-value">10:00 AM</span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Type</span>
            <span class="detail-value">Technical</span>
          </div>
          <div class="detail-row">
            <span class="detail-label">HR Contact</span>
            <span class="detail-value">Sarah Johnson</span>
          </div>
          <div class="detail-row" style="border:none;">
            <span class="detail-label">Panel</span>
            <span class="detail-value">Senior Dev Team</span>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

@push('scripts')
  <script src="{{ asset('js/brief.js') }}"></script>
@endpush
