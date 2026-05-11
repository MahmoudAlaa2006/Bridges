@extends('layouts.app')

@section('sidebar')
    @include('layouts.partials.hr_employee_sidebar')
@endsection

@section('title', 'Interview Feedback')
@section('header-title', 'Interview Feedback')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/feedback.css') }}">
@endpush

@section('content')
<div class="page-wrapper">
  <!-- Page Header -->
  <div class="mb-4">
    <h1 class="page-title mb-1">Interview Feedback</h1>
    <p class="text-muted mb-0">Submit your evaluation for the completed interview session</p>
  </div>

  <div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">

      <!-- Candidate Header Card -->
      <div class="card mb-4" style="border-color: rgba(139,92,246,0.35);">
        <div class="card-body d-flex align-items-center gap-4">
          <div class="avatar-circle">AC</div>
          <div>
            <h4 class="candidate-name mb-1">Alex Chen</h4>
            <p class="text-muted mb-0">Senior Frontend Developer &nbsp;·&nbsp; May 10, 2026 &nbsp;·&nbsp; Technical Interview</p>
          </div>
        </div>
      </div>

      <!-- Interview Score -->
      <div class="card mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <h5 class="card-title mb-1">Interview Score</h5>
              <p class="text-muted small mb-0">Overall quantitative assessment (0–100)</p>
            </div>
            <input type="number" class="score-input" id="mainScore" value="85" min="0" max="100">
          </div>
        </div>
      </div>

      <!-- Recommendation -->
      <div class="card mb-4">
        <div class="card-body">
          <h5 class="card-title mb-4">Recommendation</h5>
          <div class="row g-3">
            <div class="col-3">
              <label class="rec-option" id="rec-strong-reject">
                <input type="radio" name="recommendation" value="strong_reject" onchange="setRec(this)">
                <div class="rec-card">
                  <div class="rec-icon" style="color:#ef4444;">!!</div>
                  <div class="rec-label">Strong No Hire</div>
                </div>
              </label>
            </div>
            <div class="col-3">
              <label class="rec-option" id="rec-reject">
                <input type="radio" name="recommendation" value="reject" onchange="setRec(this)">
                <div class="rec-card">
                  <div class="rec-icon" style="color:#f87171;">✕</div>
                  <div class="rec-label">No Hire</div>
                </div>
              </label>
            </div>
            <div class="col-3">
              <label class="rec-option" id="rec-hire">
                <input type="radio" name="recommendation" value="hire" checked onchange="setRec(this)">
                <div class="rec-card selected">
                  <div class="rec-icon" style="color:#f5c542;">✓</div>
                  <div class="rec-label">Hire</div>
                </div>
              </label>
            </div>
            <div class="col-3">
              <label class="rec-option" id="rec-strong-hire">
                <input type="radio" name="recommendation" value="strong_hire" onchange="setRec(this)">
                <div class="rec-card">
                  <div class="rec-icon" style="color:#4ade80;">★</div>
                  <div class="rec-label">Strong Hire</div>
                </div>
              </label>
            </div>
          </div>
        </div>
      </div>

      <!-- Overall Feedback -->
      <div class="card mb-4">
        <div class="card-body">
          <h5 class="card-title mb-3">Overall Feedback</h5>
          <textarea class="feedback-textarea" rows="6"
            placeholder="Provide detailed notes on the candidate's performance, strengths, areas of improvement, and any other relevant observations..."></textarea>
        </div>
      </div>

      <!-- Actions -->
      <div class="d-flex justify-content-between align-items-center pb-4">
        <button class="btn-danger-custom" onclick="openEscalateModal()">
          ⚑ &nbsp;Escalate Red Flag
        </button>
        <button class="btn-primary-custom">
          Submit Feedback
        </button>
      </div>

    </div>
  </div>
</div>

<!-- Escalate Modal -->
<div class="modal-backdrop-custom" id="escalateBackdrop" onclick="closeEscalateModal(event)">
  <div class="modal-panel">
    <div class="modal-header-custom">
      <h5 class="modal-title-danger">⚑ Escalate Red Flag</h5>
      <button class="modal-close" onclick="closeEscalateModal(null)">✕</button>
    </div>
    <div class="modal-body-custom">
      <p class="text-muted small mb-3">
        Use this to flag a serious concern about this candidate. The escalation will be reviewed by HR management.
      </p>
      <div class="mb-3">
        <label class="form-label-custom">Escalation Reason <span style="color:#f87171;">*</span></label>
        <textarea class="custom-textarea" rows="5"
          placeholder="Describe the concern in detail — e.g. dishonesty, inappropriate behavior, misrepresentation of skills..."></textarea>
      </div>
    </div>
    <div class="modal-footer-custom">
      <button class="btn-outline-custom" onclick="closeEscalateModal(null)">Cancel</button>
      <button class="btn-danger-custom" onclick="closeEscalateModal(null)">Submit Escalation</button>
    </div>
  </div>
</div>
@endsection

@push('scripts')
  <script src="{{ asset('js/feedback.js') }}"></script>
@endpush
