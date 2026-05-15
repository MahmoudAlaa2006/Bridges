@extends('layouts.app')

@section('title', 'Offers — Bridges')
@section('header-title', 'Job Offers')

@section('header-actions-prefix')
<button class="btn-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg></button>
@endsection

@section('sidebar')
    @include('layouts.partials.candidate_sidebar')
@endsection

@section('content')
    <div class="mb-4">
      <h2 class="section-title">Job Offers</h2>
      <p class="section-sub">Your offers will appear here once HR extends one to you.</p>
    </div>

    @php
      $stage = $currentStage ?? null;
      $isUnlocked = ($stage === 'offer');
    @endphp

    @if(!$isUnlocked)
    {{-- ── LOCKED STATE ────────────────────────────────────────────────── --}}
    <div class="cp-card p-5 text-center mb-4" style="border:2px dashed var(--border)">
      <div style="width:64px;height:64px;border-radius:50%;background:rgba(var(--primary-rgb),0.1);display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="var(--primary)" stroke-width="1.5">
          <rect x="2" y="7" width="20" height="14" rx="2"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/>
        </svg>
      </div>
      <h4 style="font-size:17px;font-weight:700;margin-bottom:8px">No Offers Available</h4>
      <p class="text-muted-cp" style="font-size:14px;max-width:420px;margin:0 auto 24px;line-height:1.6">
        You have not reached the final stage yet. 
        Complete your interview process first to become eligible for a job offer.
      </p>
      <a href="{{ route('candidate.interview') }}" class="btn-cp btn-primary-cp" style="justify-content:center">
        Go to Interviews
      </a>
    </div>

    {{-- Pipeline reminder (Locked) --}}
    <div class="cp-card p-4" style="opacity:.45;pointer-events:none">
      <p class="text-muted-cp mb-3" style="font-size:12px;text-transform:uppercase;letter-spacing:.05em;font-weight:500">Your Pipeline</p>
      <div style="position:relative;padding:0 16px">
        <div class="d-flex justify-content-between" style="position:relative;z-index:1">
          <div class="pipeline-step"><div class="step-circle done"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></div><span class="step-label done">Applied</span></div>
          <div class="pipeline-line done"></div>
          <div class="pipeline-step"><div class="step-circle done"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></div><span class="step-label done">Exam</span></div>
          <div class="pipeline-line done"></div>
          <div class="pipeline-step"><div class="step-circle done"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></div><span class="step-label done">Interview</span></div>
          <div class="pipeline-line done"></div>
          <div class="pipeline-step"><div class="step-circle active">4</div><span class="step-label active">Offer</span></div>
        </div>
      </div>
    </div>

    @else
    {{-- ── ACTIVE OFFER STATE ───────────────────────────────────────────── --}}
    <div class="cp-card p-0 overflow-hidden mb-4" style="border: 1px solid var(--primary)">
      <div class="p-4 d-flex align-items-center justify-content-between" style="background: rgba(245,197,66,0.05); border-bottom: 1px solid var(--border)">
        <div class="d-flex align-items-center gap-3">
            <div class="stat-icon-wrap" style="background: rgba(245,197,66,0.15); color: var(--primary); width: 48px; height: 48px">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h4 style="font-size: 18px; font-weight: 700; margin: 0">Job Offer Received!</h4>
                <p class="text-muted-cp mt-1 mb-0" style="font-size: 13px">Congratulations! We'd love to have you on the team.</p>
            </div>
        </div>
        <span class="cp-badge badge-offer">New Offer</span>
      </div>
      
      <div class="p-4">
        <div class="row g-4">
            <div class="col-md-7">
                <h5 style="font-size: 15px; font-weight: 600; margin-bottom: 16px">Offer Summary</h5>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex justify-content-between">
                        <span style="color: var(--muted-fg); font-size: 13px">Position</span>
                        <span style="font-size: 13px; font-weight: 600">{{ $activeApplication->title ?? 'Software Engineer' }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span style="color: var(--muted-fg); font-size: 13px">Base Salary</span>
                        <span style="font-size: 13px; font-weight: 600">$85,000 / year</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span style="color: var(--muted-fg); font-size: 13px">Start Date</span>
                        <span style="font-size: 13px; font-weight: 600">June 1st, 2026</span>
                    </div>
                </div>
            </div>
            <div class="col-md-5 d-flex flex-column justify-content-end">
                <div class="d-grid gap-2">
                    <a href="#" class="btn-cp btn-primary-cp w-100 justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Download Offer Letter (PDF)
                    </a>
                    <button class="btn-cp btn-outline-cp w-100 justify-content-center">Accept Offer</button>
                </div>
            </div>
        </div>
      </div>
    </div>

    {{-- Pipeline reminder (Unlocked) --}}
    <div class="cp-card p-4" style="opacity:.45;pointer-events:none">
      <p class="text-muted-cp mb-3" style="font-size:12px;text-transform:uppercase;letter-spacing:.05em;font-weight:500">Your Pipeline</p>
      <div style="position:relative;padding:0 16px">
        <div class="d-flex justify-content-between" style="position:relative;z-index:1">
          <div class="pipeline-step"><div class="step-circle done"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></div><span class="step-label done">Applied</span></div>
          <div class="pipeline-line done"></div>
          <div class="pipeline-step"><div class="step-circle done"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></div><span class="step-label done">Exam</span></div>
          <div class="pipeline-line done"></div>
          <div class="pipeline-step"><div class="step-circle done"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></div><span class="step-label done">Interview</span></div>
          <div class="pipeline-line done"></div>
          <div class="pipeline-step"><div class="step-circle active">4</div><span class="step-label active">Offer</span></div>
        </div>
      </div>
    </div>
    @endif

@endsection
