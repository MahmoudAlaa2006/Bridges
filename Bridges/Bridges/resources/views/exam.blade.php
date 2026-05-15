@extends('layouts.app')

@section('title', 'Exams — CareerPortal')
@section('header-title', 'Exams & Assessments')

@section('header-actions-prefix')
<button class="btn-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg></button>
@endsection

@section('content')
    <div class="mb-4">
      <h2 class="section-title">Exams &amp; Assessments</h2>
      <p class="section-sub">Complete your technical assessment to advance to the interview stage.</p>
    </div>

    <!-- Active application context banner -->
    <div class="cp-card p-3 mb-4 bg-primary-soft">
      <div class="d-flex align-items-center gap-3">
        <div class="stat-icon-wrap" style="background:rgba(245,197,66,0.2);color:var(--primary);width:40px;height:40px">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
        </div>
        <div>
          <p style="font-size:14px;font-weight:600;margin:0">Current Application: Senior Frontend Developer</p>
          <p class="text-muted-cp" style="font-size:13px;margin:0">Applied April 20, 2026</p>
        </div>
      </div>
    </div>

    <!-- Stats row -->
    <!-- <div class="row g-3 mb-4">
      <div class="col-md-4">
        <div class="stat-card cp-card">
          <div class="stat-icon-wrap" style="background:rgba(245,197,66,0.12);color:var(--primary)"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
          <div><p style="font-size:26px;font-weight:700;margin:0">1</p><p class="text-muted-cp" style="font-size:13px;margin:0">Pending Exam</p></div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stat-card cp-card">
          <div class="stat-icon-wrap" style="background:rgba(34,197,94,0.12);color:#4ade80"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
          <div><p style="font-size:26px;font-weight:700;margin:0">0</p><p class="text-muted-cp" style="font-size:13px;margin:0">Completed</p></div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stat-card cp-card">
          <div class="stat-icon-wrap" style="background:rgba(139,92,246,0.12);color:var(--accent)"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
          <div><p style="font-size:26px;font-weight:700;margin:0">60 min</p><p class="text-muted-cp" style="font-size:13px;margin:0">Time Allowed</p></div>
        </div>
      </div>


    <!-- Exam Card -->
    @foreach($assessments as $assessment)


    <div class="cp-card p-4 mb-3">
      <div class="d-flex align-items-start justify-content-between flex-wrap gap-3 mb-4">
        <div class="d-flex align-items-start gap-3">
          <div class="stat-icon-wrap" style="background:rgba(245,197,66,0.12);color:var(--primary);width:52px;height:52px">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
          </div>
          <div>
            <h3 style="font-size:17px;font-weight:700;margin:0 0 4px">Technical Assessment</h3>
            <p class="text-muted-cp" style="font-size:13px;margin:0">Senior Frontend Developer </p>
            <div class="d-flex flex-wrap gap-2 mt-2">
              <span class="cp-badge badge-exam">{{$assessment->status}}</span>
              <span class="cp-badge badge-gray">{{ $assessment->MCQ_Count + $assessment->Code_Count + $assessment->Written_Count }} Questions</span>
              <span class="cp-badge badge-blue">60 Minutes</span>
            </div>
          </div>
        </div>


        <!-- <div style="text-align:right">
          <p class="text-muted-cp" style="font-size:12px;margin:0">Deadline</p>
          <p style="font-size:14px;font-weight:600;color:var(--primary);margin:0">May 10, 2026</p>
        </div> -->
      </div>

      <!-- Score breakdown -->
      @php
        $mcqPts = $assessment->MCQ_Count * 20;
        $writtenPts = $assessment->Written_Count * 15;
        $codePts = $assessment->Code_Count * 10;
        $totalPts = $mcqPts + $writtenPts + $codePts;
        $mcqPct = $totalPts > 0 ? round(($mcqPts / $totalPts) * 100) : 0;
        $writtenPct = $totalPts > 0 ? round(($writtenPts / $totalPts) * 100) : 0;
        $codePct = $totalPts > 0 ? round(($codePts / $totalPts) * 100) : 0;
      @endphp
      <div class="row g-3 mb-4">
        <div class="col-md-4">
          <div class="p-3 rounded-3" style="background:var(--secondary)">
            <div class="d-flex justify-content-between mb-1"><span style="font-size:13px;color:var(--muted-fg)">Multiple Choice</span><span style="font-size:13px;font-weight:600">{{ $mcqPts }} pts</span></div>
            <div class="cp-progress-track"><div class="cp-progress-bar" style="width:{{ $mcqPct }}%"></div></div>
            <p class="text-muted-cp mt-1 mb-0" style="font-size:11px">{{ $assessment->MCQ_Count }} questions · 20 pts each</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-3 rounded-3" style="background:var(--secondary)">
            <div class="d-flex justify-content-between mb-1"><span style="font-size:13px;color:var(--muted-fg)">Written</span><span style="font-size:13px;font-weight:600">{{ $writtenPts }} pts</span></div>
            <div class="cp-progress-track"><div class="cp-progress-bar accent" style="width:{{ $writtenPct }}%"></div></div>
            <p class="text-muted-cp mt-1 mb-0" style="font-size:11px">{{ $assessment->Written_Count }} questions · 15 pts each</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-3 rounded-3" style="background:var(--secondary)">
            <div class="d-flex justify-content-between mb-1"><span style="font-size:13px;color:var(--muted-fg)">Coding</span><span style="font-size:13px;font-weight:600">{{ $codePts }} pts</span></div>
            <div class="cp-progress-track"><div class="cp-progress-bar blue" style="width:{{ $codePct }}%"></div></div>
            <p class="text-muted-cp mt-1 mb-0" style="font-size:11px">{{ $assessment->Code_Count }} question · 10 pts each</p>
          </div>
        </div>
      </div>

      <!-- Instructions -->
      <div class="p-3 rounded-3 mb-4" style="background:var(--secondary);border:1px solid var(--border)">
        <p style="font-size:13px;font-weight:600;margin:0 0 10px">Before you begin:</p>
        <div class="d-flex flex-column gap-2">
          <div class="d-flex align-items-start gap-2" style="font-size:13px;color:#d1d5db">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:var(--primary);flex-shrink:0;margin-top:2px"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            The exam is 60 minutes. The timer starts when you click Begin.
          </div>
          <div class="d-flex align-items-start gap-2" style="font-size:13px;color:#d1d5db">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:var(--primary);flex-shrink:0;margin-top:2px"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            All questions are on one scrollable page — answer them in any order.
          </div>
          <div class="d-flex align-items-start gap-2" style="font-size:13px;color:#d1d5db">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:var(--primary);flex-shrink:0;margin-top:2px"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            A passing score is 70 out of 100.
          </div>
          <div class="d-flex align-items-start gap-2" style="font-size:13px;color:#d1d5db">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:var(--primary);flex-shrink:0;margin-top:2px"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            Do not refresh or leave the page once the exam has started.
          </div>
          <div class="d-flex align-items-start gap-2" style="font-size:13px;color:#d1d5db">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:var(--primary);flex-shrink:0;margin-top:2px"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            Use your own code for the coding question — plagiarism detection is enabled.
          </div>
        </div>
      </div>

      @if($assessment->status === 'COOLDOWN' && isset($coolDownInfo[$assessment->id]) && !$coolDownInfo[$assessment->id]['eligible'])
        {{-- ── Cool-Down Warning ──────────────────────────────────────────── --}}
        <div class="p-3 rounded-3 mb-3" style="background:rgba(239,68,68,0.10);border:1px solid rgba(239,68,68,0.3)">
          <div class="d-flex align-items-start gap-3">
            <div style="flex-shrink:0;margin-top:2px">
              <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#ef4444" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
              </svg>
            </div>
            <div>
              <p style="font-size:14px;font-weight:700;color:#ef4444;margin:0 0 4px">Cool-Down Period Active</p>
              <p style="font-size:13px;color:#d1d5db;margin:0 0 6px">
                You cannot retake this exam yet. You must wait <strong>6 months</strong> after your last submission.
              </p>
              <p style="font-size:13px;margin:0">
                <span style="color:var(--muted-fg)">Next eligible date:</span>
                <strong style="color:var(--primary)">{{ $coolDownInfo[$assessment->id]['next_eligible_date']->format('M d, Y') }}</strong>
              </p>
              <p style="font-size:12px;color:var(--muted-fg);margin:4px 0 0">
                Last submitted: {{ $coolDownInfo[$assessment->id]['last_submitted_at']->format('M d, Y \a\t h:i A') }}
              </p>
            </div>
          </div>
        </div>

        <div class="d-flex gap-2">
          <button disabled class="btn-cp btn-primary-cp" style="opacity:0.4;cursor:not-allowed">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
            Begin Assessment
          </button>
          <a href="overview.html" class="btn-cp btn-outline-cp">Back to Dashboard</a>
        </div>
      @else
        <div class="d-flex gap-2">
          <a href="{{ route('exam.start', $assessment->id) }}" class="btn-cp btn-primary-cp">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
            Begin Assessment
          </a>
          <a href="overview.html" class="btn-cp btn-outline-cp">Back to Dashboard</a>
        </div>
      @endif
    </div>
    @endforeach

    {{-- ── Flash message for cool-down redirect ──────────────────────────── --}}
    @if(session('cooldown_error'))
    <div class="p-3 rounded-3 mt-3" style="background:rgba(239,68,68,0.10);border:1px solid rgba(239,68,68,0.3);position:fixed;bottom:24px;right:24px;z-index:999;max-width:420px;animation:slideUp .3s ease">
      <div class="d-flex align-items-start gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#ef4444" stroke-width="2" style="flex-shrink:0;margin-top:2px">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
        </svg>
        <p style="font-size:13px;color:#fca5a5;margin:0">{{ session('cooldown_error') }}</p>
      </div>
    </div>
    @endif

@endsection

@push('scripts')
<style>
  @keyframes slideUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
  }
</style>
@endpush

