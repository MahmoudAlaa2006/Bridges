@extends('layouts.app')

{{--
 * ============================================================================
 * HR Admin - Reports & Alerts View
 * ============================================================================
 * This view serves as the compliance and integrity hub of the application. 
 * It centralizes all system-generated alerts regarding candidate behavior 
 * and assessment performance.
 * 
 * Categories:
 * 1. Exam Integrity: Focus loss, tab switching, and window blurring detection.
 * 2. Answer Similarity: AI-flagged overlap with reference answers (plagiarism).
 * 3. Interview Red Flags: Escalations from human interviewers during live calls.
 --}}

@section('sidebar')
    @include('layouts.partials.hr_admin_sidebar')
@endsection

@section('title', 'Reports & Alerts')
@section('topbar-title', 'Reports & Alerts')

<!-- Specific dashboard styling -->
<link rel="stylesheet" href="{{ asset('css/hr_admin.css') }}" />

@section('content')
  <h1 class="page-section-title">Reports &amp; Alerts</h1>
  <p class="page-section-sub">Review and handle system-generated alerts</p>

  <!-- URGENT NOTIFICATION BANNER -->
  <div class="alert-urgent mb-4">
    <i class="bi bi-exclamation-triangle-fill text-red"></i>
    <span>3 urgent reports require your attention</span>
  </div>

  <!-- ====================================================
       SECTION 1 — Exam Integrity
       Tracks technical violations during assessments.
  ==================================================== -->
  <div class="cp-card mb-4">
    <div class="cp-card-header">
      <div class="d-flex align-items-center gap-3">
        <div class="stat-icon bg-red-soft" style="width:38px;height:38px;border-radius:9px;">
          <i class="bi bi-file-earmark-x-fill text-red"></i>
        </div>
        <div>
          <h2 class="cp-card-title mb-0">Exam Integrity Reports</h2>
          <div style="font-size:.78rem;color:var(--muted);">Candidates flagged for potential exam violations</div>
        </div>
      </div>
      <span class="badge-stage bs-rejected">2 Pending</span>
    </div>
    <div class="cp-card-body">
      <div class="d-flex flex-column gap-2">

        <!-- INTEGRITY ROW 1: Example for John Doe -->
        <div class="report-row">
          <div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
              <span style="font-weight:500;">John Doe</span>
              <span class="badge-stage bs-rejected">3 violations</span>
            </div>
            <div style="font-size:.78rem;color:var(--muted);margin-top:3px;">Backend Technical Assessment — Total focus loss: 3 min 15 sec</div>
          </div>
          <button class="btn-outline-cp btn-sm-cp" onclick="openIntegrityReportModal('John Doe', 'Backend Technical Assessment', [{time:'10:15:32', type:'Tab Switch', duration:'45 seconds'}, {time:'10:28:14', type:'Window Blur', duration:'2 minutes'}, {time:'10:45:01', type:'Tab Switch', duration:'30 seconds'}], '3 minutes 15 seconds')">
            <i class="bi bi-eye"></i> Review
          </button>
        </div>

        <!-- INTEGRITY ROW 2: Example for Emily Chen -->
        <div class="report-row">
          <div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
              <span style="font-weight:500;">Emily Chen</span>
              <span class="badge-stage bs-rejected">1 violation</span>
            </div>
            <div style="font-size:.78rem;color:var(--muted);margin-top:3px;">System Design Assessment — Total focus loss: 1 min</div>
          </div>
          <button class="btn-outline-cp btn-sm-cp" onclick="openIntegrityReportModal('Emily Chen', 'System Design Assessment', [{time:'11:03:45', type:'Window Blur', duration:'1 minute'}], '1 minute')">
            <i class="bi bi-eye"></i> Review
          </button>
        </div>

      </div>
    </div>
  </div>

  <!-- ====================================================
       SECTION 2 — Answer Similarity
       Tracks potential plagiarism against model answers.
  ==================================================== -->
  <div class="cp-card mb-4">
    <div class="cp-card-header">
      <div class="d-flex align-items-center gap-3">
        <div class="stat-icon bg-primary-soft" style="width:38px;height:38px;border-radius:9px;">
          <i class="bi bi-files text-primary"></i>
        </div>
        <div>
          <h2 class="cp-card-title mb-0">Answer Similarity Reports</h2>
          <div style="font-size:.78rem;color:var(--muted);">High-similarity answers flagged for review</div>
        </div>
      </div>
      <span class="badge-stage bs-exam">1 Pending</span>
    </div>
    <div class="cp-card-body">
      <div class="d-flex flex-column gap-2">

        <!-- SIMILARITY ROW: Side-by-side comparison triggered via modal -->
        <div class="report-row border-primary">
          <div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
              <span style="font-weight:500;">Alex Wilson</span>
              <span class="badge-stage bs-exam">94% match</span>
            </div>
            <div style="font-size:.78rem;color:var(--muted);margin-top:3px;">Backend Technical Assessment</div>
          </div>
          <button class="btn-outline-cp btn-sm-cp" onclick="openSimilarityReportModal('Alex Wilson', '94%', 'Explain the difference between REST and GraphQL APIs.', 'REST uses multiple endpoints with fixed data structures, while GraphQL uses a single endpoint with flexible queries. GraphQL allows clients to request exactly the data they need, reducing over-fetching and under-fetching problems common in REST APIs.', 'REST uses multiple endpoints with fixed data structures, while GraphQL uses a single endpoint with flexible queries that allow clients to request exactly the data they need, thus reducing over-fetching and under-fetching issues.')">
            <i class="bi bi-eye"></i> Review
          </button>
        </div>

      </div>
    </div>
  </div>

  <!-- ====================================================
       SECTION 3 — Interview Red Flags
       Tracks behavioral escalations from hiring managers.
  ==================================================== -->
  <div class="cp-card mb-4">
    <div class="cp-card-header">
      <div class="d-flex align-items-center gap-3">
        <div class="stat-icon bg-accent-soft" style="width:38px;height:38px;border-radius:9px;">
          <i class="bi bi-flag-fill text-accent"></i>
        </div>
        <div>
          <h2 class="cp-card-title mb-0">Interview Red Flag Escalations</h2>
          <div style="font-size:.78rem;color:var(--muted);">Behavioral concerns raised by interviewers</div>
        </div>
      </div>
      <span class="badge-stage bs-interview">1 Pending</span>
    </div>
    <div class="cp-card-body">
      <div class="d-flex flex-column gap-2">

        <!-- RED FLAG ROW: Escalated behavioral report -->
        <div class="report-row border-accent">
          <div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
              <span style="font-weight:500;">David Miller</span>
              <span class="badge-stage bs-interview">Score: 78%</span>
            </div>
            <div style="font-size:.78rem;color:var(--muted);margin-top:3px;">Escalated by: Sarah Johnson</div>
          </div>
          <button class="btn-outline-cp btn-sm-cp" onclick="openRedFlagModal('David Miller', '78%', 'Sarah Johnson', 'Candidate appeared to be reading from notes during the technical portion. Answers seemed rehearsed and when asked follow-up questions, struggled to elaborate.')">
            <i class="bi bi-eye"></i> Review
          </button>
        </div>

      </div>
    </div>
  </div>
@endsection

@push('scripts')
<!-- Load universal HR admin logic -->
<script src="{{ asset('js/hr_admin.js') }}"></script>
<script>
/**
 * ============================================================
 * JAVASCRIPT MODAL HANDLERS
 * ============================================================
 */

/**
 * OPENS THE INTEGRITY REPORT MODAL
 * Generates a vertical timeline of specific exam violations.
 */
function openIntegrityReportModal(candidate, exam, violations, totalLoss) {
  let violationsHtml = '';
  violations.forEach(v => {
    violationsHtml += `
      <div class="list-row" style="padding:10px 14px;">
        <div class="d-flex align-items-center gap-3">
          <i class="bi bi-clock text-muted-cp"></i>
          <span style="font-size:.83rem;">${v.time}</span>
          <span class="badge-stage bs-rejected">${v.type}</span>
        </div>
        <span style="font-size:.8rem;color:var(--muted);">${v.duration}</span>
      </div>
    `;
  });

  const html = `
    <div class="p-4">
      <div class="d-flex align-items-center justify-content-between gap-3 mb-4">
        <h5 class="fw-bold mb-0">Exam Integrity Report</h5>
        <button onclick="closeModal()" class="btn-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M18 6L6 18M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <div class="row g-4 mb-4">
        <div class="col-6">
          <div style="font-size:.75rem;color:var(--muted);margin-bottom:4px;">Candidate</div>
          <div class="fw-semibold text-white">${candidate}</div>
        </div>
        <div class="col-6">
          <div style="font-size:.75rem;color:var(--muted);margin-bottom:4px;">Exam</div>
          <div class="fw-semibold text-white">${exam}</div>
        </div>
      </div>

      <div class="mb-4">
        <div class="fw-bold mb-2" style="font-size:.9rem;">Violations Timeline</div>
        <div class="d-flex flex-column gap-2 mb-3">
          ${violationsHtml}
        </div>
        <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.25);border-radius:8px;padding:12px 16px;font-size:.83rem;color:var(--red);">
          <i class="bi bi-exclamation-circle me-2"></i>Total focus loss time: <strong>${totalLoss}</strong>
        </div>
      </div>

      <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
        <button class="btn-outline-cp" onclick="closeModal()">Cancel</button>
        <button class="btn-red-cp" onclick="closeModal()"><i class="bi bi-x"></i> Reject (Score = 0)</button>
        <button class="btn-green-cp" onclick="closeModal()"><i class="bi bi-check"></i> Approve (Keep Score)</button>
      </div>
    </div>
  `;
  openModal(html);
}

/**
 * OPENS THE SIMILARITY REPORT MODAL
 * Provides a side-by-side comparison of candidate vs. reference answers.
 */
function openSimilarityReportModal(candidate, score, question, candidateAns, referenceAns) {
  const html = `
    <div class="p-4">
      <div class="d-flex align-items-center justify-content-between gap-3 mb-4">
        <h5 class="fw-bold mb-0">Answer Similarity Report</h5>
        <button onclick="closeModal()" class="btn-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M18 6L6 18M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <div class="row g-4 mb-4">
        <div class="col-6">
          <div style="font-size:.75rem;color:var(--muted);margin-bottom:4px;">Candidate</div>
          <div class="fw-semibold text-white">${candidate}</div>
        </div>
        <div class="col-6">
          <div style="font-size:.75rem;color:var(--muted);margin-bottom:4px;">Similarity Score</div>
          <span class="badge-stage bs-exam" style="font-size:.9rem;padding:4px 14px;">${score}</span>
        </div>
      </div>

      <div class="mb-4">
        <div style="font-size:.8rem;color:var(--muted);margin-bottom:6px;">Question</div>
        <div class="border rounded p-3 mb-4" style="background: rgba(255,255,255,0.02); font-size:.88rem;">
          ${question}
        </div>
        
        <!-- Side-by-Side Comparison -->
        <div class="row g-4">
          <div class="col-md-6">
            <div style="font-size:.8rem;color:var(--muted);margin-bottom:6px;">Candidate Answer</div>
            <div class="border rounded p-3 text-white" style="background: rgba(239,68,68,0.05); border-color: rgba(239,68,68,0.2) !important; font-size:.83rem; line-height: 1.6;">
              ${candidateAns}
            </div>
          </div>
          <div class="col-md-6">
            <div style="font-size:.8rem;color:var(--muted);margin-bottom:6px;">Reference Answer</div>
            <div class="border rounded p-3 text-white" style="background: rgba(255,255,255,0.02); font-size:.83rem; line-height: 1.6;">
              ${referenceAns}
            </div>
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
        <button class="btn-outline-cp" onclick="closeModal()">Cancel</button>
        <button class="btn-red-cp" onclick="closeModal()"><i class="bi bi-x"></i> Reject (Score = 0)</button>
        <button class="btn-green-cp" onclick="closeModal()"><i class="bi bi-check"></i> Approve (Keep Score)</button>
      </div>
    </div>
  `;
  openModal(html);
}

/**
 * OPENS THE RED FLAG MODAL
 * Displays behavioral concerns and allows for manual score reduction.
 */
function openRedFlagModal(candidate, score, escalatedBy, reason) {
  const html = `
    <div class="p-4">
      <div class="d-flex align-items-center justify-content-between gap-3 mb-4">
        <h5 class="fw-bold mb-0">Interview Red Flag Review</h5>
        <button onclick="closeModal()" class="btn-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M18 6L6 18M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <div class="row g-4 mb-4">
        <div class="col-6">
          <div style="font-size:.75rem;color:var(--muted);margin-bottom:4px;">Candidate</div>
          <div class="fw-semibold text-white">${candidate}</div>
        </div>
        <div class="col-6">
          <div style="font-size:.75rem;color:var(--muted);margin-bottom:4px;">Current Score</div>
          <div class="fw-semibold text-white">${score}</div>
        </div>
      </div>

      <div class="mb-4">
        <div style="font-size:.8rem;color:var(--muted);margin-bottom:4px;">Escalated By</div>
        <div class="text-white fw-medium mb-3">${escalatedBy}</div>
        
        <div style="font-size:.8rem;color:var(--muted);margin-bottom:6px;">Escalation Reason</div>
        <div class="border rounded p-3 mb-4 text-white" style="background: rgba(255,255,255,0.02); font-size:.88rem; line-height: 1.6;">
          ${reason}
        </div>

        <!-- Corrective Action Area -->
        <div class="bg-dark-cp p-3 rounded border">
          <label class="cp-label mb-2" for="scoreReduction">Action: Score Reduction</label>
          <div class="d-flex gap-2">
            <input type="number" class="cp-input" id="scoreReduction" min="0" max="${parseInt(score)}" placeholder="Enter points to deduct" />
            <button class="btn-primary-cp px-4" onclick="closeModal()">Apply</button>
          </div>
          <p class="mt-2 mb-0" style="font-size:.75rem; color:var(--muted);">Reduction will be logged and applicant will be notified of updated status.</p>
        </div>
      </div>

      <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
        <button class="btn-outline-cp" onclick="closeModal()">Cancel</button>
        <button class="btn-outline-cp" onclick="closeModal()">Ignore Flag</button>
      </div>
    </div>
  `;
  openModal(html);
}

</script>
@endpush

