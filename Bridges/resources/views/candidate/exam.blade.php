@extends('layouts.app')

@section('sidebar')
    @include('layouts.partials.candidate_sidebar')
@endsection
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
    </div> -->

    <!-- Exam Card -->
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
              <span class="cp-badge badge-exam">Pending</span>
              <span class="cp-badge badge-gray">6 Questions</span>
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
      <div class="row g-3 mb-4">
        <div class="col-md-4">
          <div class="p-3 rounded-3" style="background:var(--secondary)">
            <div class="d-flex justify-content-between mb-1"><span style="font-size:13px;color:var(--muted-fg)">Multiple Choice</span><span style="font-size:13px;font-weight:600">60 pts</span></div>
            <div class="cp-progress-track"><div class="cp-progress-bar" style="width:60%"></div></div>
            <p class="text-muted-cp mt-1 mb-0" style="font-size:11px">3 questions · 20 pts each</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-3 rounded-3" style="background:var(--secondary)">
            <div class="d-flex justify-content-between mb-1"><span style="font-size:13px;color:var(--muted-fg)">Written</span><span style="font-size:13px;font-weight:600">30 pts</span></div>
            <div class="cp-progress-track"><div class="cp-progress-bar accent" style="width:30%"></div></div>
            <p class="text-muted-cp mt-1 mb-0" style="font-size:11px">2 questions · 15 pts each</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-3 rounded-3" style="background:var(--secondary)">
            <div class="d-flex justify-content-between mb-1"><span style="font-size:13px;color:var(--muted-fg)">Coding</span><span style="font-size:13px;font-weight:600">10 pts</span></div>
            <div class="cp-progress-track"><div class="cp-progress-bar blue" style="width:10%"></div></div>
            <p class="text-muted-cp mt-1 mb-0" style="font-size:11px">1 question · 10 pts</p>
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

      <div class="d-flex gap-2">
        <a href="{{ route('candidate.exam-template') }}" class="btn-cp btn-primary-cp">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
          Begin Assessment
        </a>

        <a href="{{ route('candidate.overview') }}" class="btn-cp btn-outline-cp">Back to Dashboard</a>

      </div>
    </div>

@endsection
