@extends('layouts.app')

{{--
 * ============================================================================
 * Candidate - Overview / Landing View
 * ============================================================================
 * The primary entry point for candidates. It focuses on the current state of 
 * their "Active Application" to ensure the most important task is prominent.
 * 
 * Features:
 * - Personalized welcome message.
 * - Application Stepper: Visualizes progress from Applied to Offer.
 * - Immediate Action Button: Directs the candidate to the pending assessment.
 --}}

@section('sidebar')
    @include('layouts.partials.candidate_sidebar')
@endsection

@section('title', 'Dashboard — CareerPortal')
@section('header-title', 'Dashboard Overview')

@section('content')

    <!-- WELCOME HEADER: Greets the user and sets the page context -->
    <div class="mb-4">
      <h2 class="section-title">Welcome back, Daniel</h2>
      <p class="section-sub">Here is what is happening with your career journey today.</p>
    </div>

    <!-- ACTIVE APPLICATION TRACKER: 
         The core component of the landing page. It summarizes the most recent
         hiring process the candidate is involved in.
    -->
    <div class="cp-card p-4 mb-4">
      <div class="d-flex align-items-start justify-content-between flex-wrap gap-3 mb-4">
        <div>
          <p class="text-muted-cp mb-1" style="font-size:12px;font-weight:500;text-transform:uppercase;letter-spacing:.05em">Active Application</p>
          <h3 style="font-size:18px;font-weight:700;margin:0">Senior Frontend Developer</h3>
          <p class="text-muted-cp mt-1 mb-0" style="font-size:14px">TechCorp Inc. &nbsp;·&nbsp; Applied April 20, 2026</p>
        </div>
        <span class="cp-badge badge-exam">Exam Stage</span>
      </div>

      <!-- PIPELINE PIPELINE STEPPER: 
           A visual representation of the recruitment funnel. 
           Uses 'done', 'active', and 'pending' states to show progress.
      -->
      <div style="position:relative;padding:0 16px">
        <div class="d-flex justify-content-between" style="position:relative;z-index:1">
          <!-- Step 1: Applied (COMPLETED) -->
          <div class="pipeline-step">
            <div class="step-circle done">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
            <span class="step-label done">Applied</span>
          </div>
          <!-- Connector line (COMPLETED) -->
          <div class="pipeline-line done"></div>
          
          <!-- Step 2: Exam (CURRENTLY ACTIVE) -->
          <div class="pipeline-step">
            <div class="step-circle active">2</div>
            <span class="step-label active">Exam</span>
          </div>
          <!-- Connector line (PENDING) -->
          <div class="pipeline-line"></div>
          
          <!-- Step 3: Interview (FUTURE) -->
          <div class="pipeline-step">
            <div class="step-circle">3</div>
            <span class="step-label">Interview</span>
          </div>
          <!-- Connector line (PENDING) -->
          <div class="pipeline-line"></div>
          
          <!-- Step 4: Offer (FINAL GOAL) -->
          <div class="pipeline-step">
            <div class="step-circle">4</div>
            <span class="step-label">Offer</span>
          </div>
        </div>
      </div>

      <!-- CALL TO ACTION (CTA): 
           Context-aware buttons that change based on the current pipeline stage.
      -->
      <div class="d-flex gap-2 mt-4">
        <a href="{{ route('candidate.exam') }}" class="btn-cp btn-primary-cp">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
          Take Exam
        </a>
        <a href="{{ route('candidate.jobs') }}" class="btn-cp btn-outline-cp">Browse More Jobs</a>
      </div>
    </div>

    <div class="row g-3">
      <!-- NOTE: Statistics, Recent Activity, and Profile Completion sections 
           are currently commented out for a focused "Active Application" experience 
           but remain in the source for future data-driven integration.
      -->
    </div>

@endsection
