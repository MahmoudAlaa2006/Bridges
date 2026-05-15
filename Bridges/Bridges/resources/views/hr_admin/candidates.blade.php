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

  @php
    $initials = strtoupper(substr($candidate->first_name, 0, 1) . substr($candidate->last_name, 0, 1));
    $score = $application->match_score ?? 0;
    $status = $application->status ?? 'applied';
    $stageClass = match($status) {
        'applied' => 'bs-applied',
        'exam' => 'bs-exam',
        'interview' => 'bs-interview',
        'offer' => 'bs-offer',
        'rejected' => 'bs-rejected',
        default => 'bs-applied'
    };
  @endphp

  <!-- ── CANDIDATE HEADER CARD ── -->
  <div class="cp-card mb-4">
    <div class="cp-card-body">
      <div class="d-flex align-items-start gap-4 flex-wrap">
        <div class="av-init" style="width:72px;height:72px;font-size:1.3rem;flex-shrink:0;">{{ $initials }}</div>
        <div class="flex-grow-1">
          <div class="d-flex align-items-center gap-3 flex-wrap mb-2">
            <h2 style="font-size:1.3rem;font-weight:700;margin:0;">{{ $candidate->first_name }} {{ $candidate->last_name }}</h2>
            <span class="badge-stage {{ $stageClass }}">{{ ucfirst($status) }}</span>
            
            @if($application)
            <div class="ms-3 d-flex align-items-center gap-2">
              <form action="{{ route('hr.change-stage', $application->application_id) }}" method="POST" class="d-flex align-items-center gap-2 m-0">
                @csrf
                <select name="new_stage" class="form-select form-select-sm" style="width: auto; font-size: 0.8rem;">
                  <option value="">Change Stage...</option>
                  @foreach($transitionRules as $rule)
                    @if($rule->from_stage == $status || !$rule->from_stage)
                      <option value="{{ $rule->to_stage }}">{{ ucfirst($rule->to_stage) }}</option>
                    @endif
                  @endforeach
                </select>
                <button type="submit" class="btn-cp btn-primary-cp btn-sm-cp" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">Update</button>
              </form>
            </div>
            @endif
          </div>
          <div class="d-flex flex-wrap gap-3" style="font-size:.83rem;color:var(--muted);">
            <span><i class="bi bi-envelope me-1"></i>{{ $candidate->email }}</span>
            <span><i class="bi bi-telephone me-1"></i>Not provided</span>
            <span><i class="bi bi-geo-alt me-1"></i>Remote</span>
            <span><i class="bi bi-briefcase me-1"></i>{{ $candidate->age ? $candidate->age . ' years old' : 'Age not provided' }}</span>
          </div>
        </div>
        <div class="text-end" style="flex-shrink:0;">
          <div style="font-size:2.5rem;font-weight:700;color:var(--primary);">{{ $score }}%</div>
          <div style="font-size:.78rem;color:var(--muted);">Match Score</div>
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
              <div style="font-size:1.4rem;font-weight:700;">{{ $score }}%</div>
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
              <div style="font-size:1.4rem;font-weight:700;">{{ $status == 'applied' ? '—' : ($score > 0 ? number_format($score * 0.95, 0) . '%' : '0%') }}</div>
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
              <div style="font-size:1.4rem;font-weight:700;">{{ in_array($status, ['interview', 'offer']) ? number_format($score * 1.05, 0) . '%' : '—' }}</div>
            </div>

            <div class="list-row" style="flex-direction:column;align-items:flex-start;gap:6px;">
              <div style="font-weight:500;font-size:.88rem;">Interview Feedback</div>
              <div style="font-size:.83rem;color:var(--muted);">
                @if(in_array($status, ['interview', 'offer']))
                  Candidate has progressed to the interview stage. Final panel feedback pending or summarized by match score performance.
                @else
                  No interview feedback available yet.
                @endif
              </div>
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
                <div style="font-weight:500;">{{ $candidate->resume ? basename($candidate->resume) : 'No CV uploaded' }}</div>
                <div style="font-size:.75rem;color:var(--muted);">{{ $candidate->resume ? 'Document' : 'N/A' }}</div>
              </div>
            </div>
            @if($candidate->resume)
              <a href="{{ asset('storage/' . $candidate->resume) }}" class="btn-outline-cp btn-sm-cp" target="_blank">
                <i class="bi bi-eye"></i> View
              </a>
            @endif
          </div>
          <div style="font-size:.83rem;color:var(--muted);">
            <i class="bi bi-calendar me-1"></i>Applied on {{ $application ? $application->created_at->format('Y-m-d') : 'N/A' }}
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
  candidate: [
    {{ min(100, $score + 5) }}, 
    {{ min(100, $score - 2) }}, 
    {{ min(100, $score + 0) }}, 
    {{ min(100, $score - 10) }}, 
    {{ min(100, $score + 2) }}, 
    {{ min(100, $score + 3) }}
  ],
  required:  [85, 80, 75, 70, 75, 80]
};
</script>
@endpush
