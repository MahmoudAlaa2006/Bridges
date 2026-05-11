@extends('layouts.app')

@section('sidebar')
    @include('layouts.partials.hr_admin_sidebar')
@endsection
@section('title', 'John Smith — Candidate Profile')
@section('topbar-title', 'John Smith')

<link rel="stylesheet" href="{{ asset('css/hr_admin.css') }}" />

@section('head')
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
@endsection

@section('content')
  <!-- Back button -->
  <div class="mb-3">
    <button class="btn-ghost-cp" onclick="history.back()">
      <i class="bi bi-arrow-left"></i> Back
    </button>
  </div>

  <!-- ── CANDIDATE HEADER CARD ── -->
  <div class="cp-card mb-4">
    <div class="cp-card-body">
      <div class="d-flex align-items-start gap-4 flex-wrap">
        <div class="av-init" style="width:72px;height:72px;font-size:1.3rem;flex-shrink:0;">JS</div>
        <div class="flex-grow-1">
          <div class="d-flex align-items-center gap-3 flex-wrap mb-2">
            <h2 style="font-size:1.3rem;font-weight:700;margin:0;">John Smith</h2>
            <span class="badge-stage bs-interview">Interview</span>
          </div>
          <div class="d-flex flex-wrap gap-3" style="font-size:.83rem;color:var(--muted);">
            <span><i class="bi bi-envelope me-1"></i>john.smith@email.com</span>
            <span><i class="bi bi-telephone me-1"></i>+1 (555) 012-3456</span>
            <span><i class="bi bi-geo-alt me-1"></i>San Francisco, CA</span>
            <span><i class="bi bi-briefcase me-1"></i>6 years experience</span>
          </div>
        </div>
        <div class="text-end" style="flex-shrink:0;">
          <div style="font-size:2.5rem;font-weight:700;color:var(--primary);">92%</div>
          <div style="font-size:.78rem;color:var(--muted);">Overall Score</div>
        </div>
      </div>
    </div>
  </div>

  <!-- ── TWO COLUMN ROW: Scores + CV ── -->
  <div class="row g-3 mb-4">

    <!-- Assessment Scores -->
    <div class="col-12 col-lg-6">
      <div class="cp-card h-100">
        <div class="cp-card-header"><h2 class="cp-card-title">Assessment Scores</h2></div>
        <div class="cp-card-body">
          <div class="d-flex flex-column gap-2">

            <div class="list-row">
              <div class="d-flex align-items-center gap-3">
                <div class="stat-icon bg-primary-soft" style="width:36px;height:36px;border-radius:8px;">
                  <i class="bi bi-file-earmark-text text-primary"></i>
                </div>
                <div>
                  <div style="font-weight:500;font-size:.88rem;">System Score</div>
                  <div style="font-size:.75rem;color:var(--muted);">Application evaluation</div>
                </div>
              </div>
              <div style="font-size:1.4rem;font-weight:700;">92%</div>
            </div>

            <div class="list-row">
              <div class="d-flex align-items-center gap-3">
                <div class="stat-icon bg-accent-soft" style="width:36px;height:36px;border-radius:8px;">
                  <i class="bi bi-journal-check text-accent"></i>
                </div>
                <div>
                  <div style="font-weight:500;font-size:.88rem;">Exam Score</div>
                  <div style="font-size:.75rem;color:var(--muted);">Technical assessment</div>
                </div>
              </div>
              <div style="font-size:1.4rem;font-weight:700;">88%</div>
            </div>

            <div class="list-row">
              <div class="d-flex align-items-center gap-3">
                <div class="stat-icon bg-green-soft" style="width:36px;height:36px;border-radius:8px;">
                  <i class="bi bi-camera-video text-green"></i>
                </div>
                <div>
                  <div style="font-weight:500;font-size:.88rem;">Interview Score</div>
                  <div style="font-size:.75rem;color:var(--muted);">Panel evaluation</div>
                </div>
              </div>
              <div style="font-size:1.4rem;font-weight:700;">95%</div>
            </div>

            <div class="list-row" style="flex-direction:column;align-items:flex-start;gap:6px;">
              <div style="font-weight:500;font-size:.88rem;">Interview Feedback</div>
              <div style="font-size:.83rem;color:var(--muted);">Strong technical background. Excellent system design answers. Communication is clear and concise. Highly recommended for next round.</div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <!-- CV -->
    <div class="col-12 col-lg-6">
      <div class="cp-card h-100">
        <div class="cp-card-header"><h2 class="cp-card-title">Resume / CV</h2></div>
        <div class="cp-card-body">
          <div class="list-row mb-3">
            <div class="d-flex align-items-center gap-3">
              <div class="stat-icon bg-primary-soft" style="width:40px;height:40px;border-radius:8px;">
                <i class="bi bi-file-earmark-pdf-fill text-primary" style="font-size:1.2rem;"></i>
              </div>
              <div>
                <div style="font-weight:500;">john-smith-cv.pdf</div>
                <div style="font-size:.75rem;color:var(--muted);">PDF Document</div>
              </div>
            </div>
            <a href="#" class="btn-outline-cp btn-sm-cp">
              <i class="bi bi-download"></i> Download
            </a>
          </div>
          <div style="font-size:.83rem;color:var(--muted);">
            <i class="bi bi-calendar me-1"></i>Applied on 2024-01-16
          </div>
        </div>
      </div>
    </div>

  </div><!-- /two column -->

  <!-- ── COMPETENCY RADAR CHART ── -->
  <div class="cp-card">
    <div class="cp-card-header"><h2 class="cp-card-title">Competency Analysis</h2></div>
    <div class="cp-card-body">
      <div style="height:300px;position:relative;">
        <canvas id="radarChart"></canvas>
      </div>
      <div class="d-flex align-items-center justify-content-center gap-4 mt-3">
        <div class="radar-legend-item">
          <div class="legend-dot" style="background:var(--primary);"></div>
          Candidate Score
        </div>
        <div class="radar-legend-item">
          <div class="legend-dot" style="background:var(--accent);"></div>
          Required Level
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script src="{{ asset('js/hr_admin.js') }}"></script>
<script src="{{ asset('js/charts.js') }}"></script>
<script>
var RADAR_DATA = {
  labels:    ['Technical', 'Problem Solving', 'Communication', 'Leadership', 'Adaptability', 'Teamwork'],
  candidate: [95, 91, 88, 82, 90, 93],
  required:  [85, 80, 75, 70, 75, 80]
};
</script>
@endpush
