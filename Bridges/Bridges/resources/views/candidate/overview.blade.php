@extends('layouts.app')

@section('title', 'Dashboard — Bridges')
@section('header-title', 'Dashboard Overview')

@section('sidebar')
    @include('layouts.partials.candidate_sidebar')
@endsection

@section('content')

@php
  // ── Stage helpers ──────────────────────────────────────────────────────────
  // Stages in order: applied → technical_test → interview → offer
  $stageOrder = ['applied' => 0, 'technical_test' => 1, 'interview' => 2, 'offer' => 3];
  $userStage  = $currentStage ?? null;  // null means still in screening / exam

  // Map the user's DB stage to our pipeline step index
  // (null / technical_test = step 1 done, step 2 active)
  $activePipelineStep = match($userStage) {
      'interview' => 2,   // step 3 is active
      'offer'     => 3,   // step 4 is active
      'rejected'  => -1,  // rejected
      default     => 1,   // still in exam stage
  };

  // Is the interview stage done (offer)?
  $interviewDone = $userStage === 'offer';

  // Passed the exam?
  $passedExam = in_array($userStage, ['interview', 'offer']);
  $isRejected = $userStage === 'rejected';
@endphp

    {{-- Welcome --}}
    <div class="mb-4">
      <h2 class="section-title">Welcome{{ isset($candidateName) && $candidateName !== 'Candidate' ? ', ' . $candidateName : '' }}</h2>
      <p class="section-sub">
        @if ($activeApplication ?? null)
          Here is what is happening with your career journey today.
        @else
          Browse open positions and submit your application to get started.
        @endif
      </p>
    </div>

    {{-- ── DYNAMIC NOTIFICATION BANNER ──────────────────────────────────────── --}}
    @if ($userStage === 'offer')
      {{-- 🎉 Passed interview — in offer stage --}}
      <div class="cp-card p-4 mb-4 d-flex align-items-start gap-3"
           style="background:rgba(74,222,128,0.07);border:1px solid rgba(74,222,128,0.25)">
        <div style="width:44px;height:44px;border-radius:50%;background:rgba(74,222,128,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#4ade80" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
          </svg>
        </div>
        <div class="flex-grow-1">
          <p style="font-size:14px;font-weight:700;color:#4ade80;margin:0 0 4px">
            🎉 Congratulations — You Passed the Interview!
          </p>
          <p style="font-size:13px;color:#d1d5db;margin:0 0 8px;line-height:1.6">
            You have advanced to the <strong style="color:#fff">Offer Stage</strong>.
            Please check your offer details and let us know your decision.
          </p>
        </div>
      </div>

    @elseif ($userStage === 'interview')
      {{-- 🎉 Passed exam — in interview stage --}}
      <div class="cp-card p-4 mb-4 d-flex align-items-start gap-3"
           style="background:rgba(74,222,128,0.07);border:1px solid rgba(74,222,128,0.25)">
        <div style="width:44px;height:44px;border-radius:50%;background:rgba(74,222,128,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#4ade80" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
          </svg>
        </div>
        <div class="flex-grow-1">
          <p style="font-size:14px;font-weight:700;color:#4ade80;margin:0 0 4px">
            🎉 Congratulations — You Passed the Technical Exam!
          </p>
          <p style="font-size:13px;color:#d1d5db;margin:0 0 8px;line-height:1.6">
            You have advanced to the <strong style="color:#fff">Interview Stage</strong>.
            We will get in touch with you as soon as possible to schedule your interview.
          </p>
          @if (!$hasAvailability)
            <p style="font-size:13px;color:#fbbf24;margin:0 0 10px;line-height:1.6">
              <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="margin-right:4px;vertical-align:middle">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
              </svg>
              <strong style="color:#fbbf24">Action required:</strong> Please add your available time slots so we can schedule your interview.
            </p>
            <a href="{{ route('candidate.exam') }}" class="btn-cp btn-primary-cp" style="font-size:13px">
              <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
              </svg>
              Set My Availability
            </a>
          @else
            <p style="font-size:12px;color:#4ade80;margin:0">
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="margin-right:4px;vertical-align:middle">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
              </svg>
              Your availability windows are saved. We'll reach out soon.
            </p>
          @endif
        </div>
      </div>

    @elseif ($isRejected)
      {{-- ❌ Did not pass --}}
      <div class="cp-card p-4 mb-4 d-flex align-items-start gap-3"
           style="background:rgba(248,113,113,0.07);border:1px solid rgba(248,113,113,0.25)">
        <div style="width:44px;height:44px;border-radius:50%;background:rgba(248,113,113,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#f87171" stroke-width="2.5">
            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
          </svg>
        </div>
        <div>
          <p style="font-size:14px;font-weight:700;color:#f87171;margin:0 0 4px">
            Application Not Progressed
          </p>
          <p style="font-size:13px;color:#d1d5db;margin:0;line-height:1.6">
            Unfortunately your combined score did not reach the minimum threshold for this position.
            We encourage you to improve your skills and apply again in the future.
          </p>
        </div>
      </div>
    @endif

    @if ($activeApplication ?? null)
      {{-- ── ACTIVE APPLICATION PIPELINE ─────────────────────────────────────── --}}
      <div class="cp-card p-4 mb-4">
        <div class="d-flex align-items-start justify-content-between flex-wrap gap-3 mb-4">
          <div>
            <p class="text-muted-cp mb-1" style="font-size:12px;font-weight:500;text-transform:uppercase;letter-spacing:.05em">Active Application</p>
            <h3 style="font-size:18px;font-weight:700;margin:0">{{ $activeApplication->title }}</h3>
            <p class="text-muted-cp mt-1 mb-0" style="font-size:14px">
              {{ $activeApplication->department }}
              @if ($activeApplication->match_score)
                &nbsp;·&nbsp;
                <span style="color:var(--primary);font-weight:600">{{ $activeApplication->match_score }}% Match</span>
              @endif
            </p>
          </div>
          {{-- Dynamic stage badge --}}
          @if ($isRejected)
            <span class="cp-badge" style="background:rgba(248,113,113,0.1);color:#f87171;border:1px solid rgba(248,113,113,0.3)">Rejected</span>
          @elseif ($userStage === 'offer')
            <span class="cp-badge" style="background:rgba(74,222,128,0.1);color:#4ade80;border:1px solid rgba(74,222,128,0.3)">Offer Stage</span>
          @elseif ($userStage === 'interview')
            <span class="cp-badge" style="background:rgba(74,222,128,0.1);color:#4ade80;border:1px solid rgba(74,222,128,0.3)">Interview Stage</span>
          @else
            <span class="cp-badge badge-exam">Exam Stage</span>
          @endif
        </div>

        {{-- Pipeline progress --}}
        <div style="position:relative;padding:0 16px">
          <div class="d-flex justify-content-between" style="position:relative;z-index:1">

            {{-- Step 1: Applied (always done) --}}
            <div class="pipeline-step">
              <div class="step-circle done">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
              </div>
              <span class="step-label done">Applied</span>
            </div>

            <div class="pipeline-line done"></div>

            {{-- Step 2: Exam --}}
            <div class="pipeline-step">
              @if ($passedExam || $isRejected)
                <div class="step-circle {{ $isRejected ? '' : 'done' }}" style="{{ $isRejected ? 'background:rgba(248,113,113,0.15);border-color:rgba(248,113,113,0.4);color:#f87171' : '' }}">
                  @if ($passedExam)
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                  @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                  @endif
                </div>
              @else
                <div class="step-circle active">2</div>
              @endif
              <span class="step-label {{ $passedExam ? 'done' : ($isRejected ? '' : 'active') }}">Exam</span>
            </div>

            <div class="pipeline-line {{ $passedExam ? 'done' : '' }}"></div>

            {{-- Step 3: Interview --}}
            <div class="pipeline-step">
              @if ($interviewDone)
                <div class="step-circle done">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <span class="step-label done">Interview</span>
              @elseif ($userStage === 'interview')
                <div class="step-circle active">3</div>
                <span class="step-label active">Interview</span>
              @else
                <div class="step-circle">3</div>
                <span class="step-label">Interview</span>
              @endif
            </div>

            <div class="pipeline-line {{ $interviewDone ? 'done' : '' }}"></div>

            {{-- Step 4: Offer --}}
            <div class="pipeline-step">
              @if ($userStage === 'offer')
                <div class="step-circle active">4</div>
                <span class="step-label active">Offer</span>
              @else
                <div class="step-circle">4</div>
                <span class="step-label">Offer</span>
              @endif
            </div>

          </div>
        </div>

        {{-- Next steps info (stage-aware) --}}
        <div class="mt-4 p-3 rounded-3" style="background:rgba(var(--primary-rgb),0.06);border:1px solid rgba(var(--primary-rgb),0.15)">
          <p style="font-size:13px;color:#d1d5db;margin:0;line-height:1.7">
            @if ($isRejected)
              <strong style="color:#f87171">Application closed.</strong><br>
              We appreciate your time and effort. You are welcome to apply for other open positions.
            @elseif ($userStage === 'interview')
              <strong style="color:#fff">You are at the Interview Stage.</strong><br>
              Your technical exam has been passed. Our team will contact you to schedule your interview.
              Make sure your <strong style="color:var(--primary)">availability windows</strong> are up to date so we can find a time that works for everyone.
            @elseif ($userStage === 'offer')
              <strong style="color:#fff">Congratulations — an offer is on its way!</strong><br>
              You have passed all stages. Check your <strong style="color:var(--primary)">Offer</strong> page for details.
            @else
              <strong style="color:#fff">What happens next?</strong><br>
              You have passed the application screening. The next step is a
              <strong style="color:var(--primary)">technical assessment (Exam)</strong>.
              After that you will be invited for an <strong style="color:var(--primary)">interview</strong>,
              and if successful, you will receive an <strong style="color:var(--primary)">offer</strong>.
            @endif
          </p>
        </div>

        {{-- CTA buttons (stage-aware) --}}
        <div class="d-flex gap-2 mt-4">
          @if ($isRejected)
            <a href="{{ route('candidate.jobs') }}" class="btn-cp btn-primary-cp">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
              Browse Other Jobs
            </a>
          @elseif ($userStage === 'interview')
            @if (!$hasAvailability)
              <a href="{{ route('candidate.exam') }}" class="btn-cp btn-primary-cp">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Set My Availability
              </a>
            @endif
            <a href="{{ route('candidate.jobs') }}" class="btn-cp btn-outline-cp">Browse More Jobs</a>
          @elseif ($userStage === 'offer')
            <a href="{{ route('candidate.offer') }}" class="btn-cp btn-primary-cp">View Offer</a>
          @else
            <a href="{{ route('candidate.exam') }}" class="btn-cp btn-primary-cp">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
              Take Exam
            </a>
            <a href="{{ route('candidate.jobs') }}" class="btn-cp btn-outline-cp">Browse More Jobs</a>
          @endif
        </div>
      </div>

    @else
      {{-- ── EMPTY STATE — no application yet ────────────────────────────────── --}}
      <div class="cp-card p-5 text-center mb-4" style="border:2px dashed var(--border)">
        <div style="width:64px;height:64px;border-radius:50%;background:rgba(var(--primary-rgb),0.1);display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
          <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="var(--primary)" stroke-width="1.5">
            <rect x="2" y="7" width="20" height="14" rx="2"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/>
          </svg>
        </div>
        <h4 style="font-size:17px;font-weight:700;margin-bottom:8px">No Active Applications Yet</h4>
        <p class="text-muted-cp" style="font-size:14px;max-width:400px;margin:0 auto 24px;line-height:1.6">
          You have not applied to any positions yet. Browse open jobs, find the right fit, upload your CV, and submit your application.
        </p>
        <a href="{{ route('candidate.jobs') }}" class="btn-cp btn-primary-cp" style="justify-content:center">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
          Browse Open Positions
        </a>
      </div>

      {{-- Pipeline preview (greyed out) --}}
      <div class="cp-card p-4 mb-4" style="opacity:.45;pointer-events:none">
        <p class="text-muted-cp mb-3" style="font-size:12px;text-transform:uppercase;letter-spacing:.05em;font-weight:500">Your Future Pipeline</p>
        <div style="position:relative;padding:0 16px">
          <div class="d-flex justify-content-between" style="position:relative;z-index:1">
            <div class="pipeline-step"><div class="step-circle">1</div><span class="step-label">Applied</span></div>
            <div class="pipeline-line"></div>
            <div class="pipeline-step"><div class="step-circle">2</div><span class="step-label">Exam</span></div>
            <div class="pipeline-line"></div>
            <div class="pipeline-step"><div class="step-circle">3</div><span class="step-label">Interview</span></div>
            <div class="pipeline-line"></div>
            <div class="pipeline-step"><div class="step-circle">4</div><span class="step-label">Offer</span></div>
          </div>
        </div>
      </div>
    @endif

@endsection
