@extends('layouts.app')

@section('sidebar')
    @include('layouts.partials.interviewer_sidebar')
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

  <form action="{{ route('feedback.store', $interview->id) }}" method="POST" id="feedbackForm">
    @csrf
    <!-- Escalation state -->
    <input type="hidden" name="is_escalated" id="is_escalated_input" value="0">

    <div class="row justify-content-center">
      <div class="col-xl-8 col-lg-10">

        <!-- Candidate Header Card -->
        <div class="card mb-4" style="border-color: rgba(139,92,246,0.35);">
          <div class="card-body d-flex align-items-center gap-4">
            <div class="avatar-circle">{{ substr($interview->user->name, 0, 2) }}</div>
            <div>
              <h4 class="candidate-name mb-1">{{ $interview->user->name }}</h4>
              <p class="text-muted mb-0">
                {{ optional($interview->application->job)->title ?? 'Position' }} &nbsp;·&nbsp; 
                {{ $interview->get_date->format('M d, Y') }} &nbsp;·&nbsp; Technical Interview
              </p>
            </div>
          </div>
        </div>

        <!-- Interview Score -->
        <div class="card mb-4">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <h5 class="card-title mb-1">Interview Score</h5>
                <p class="text-muted small mb-0">Overall quantitative assessment (1–100)</p>
              </div>
              <input type="number" name="score" class="score-input" id="mainScore" value="85" min="1" max="100" required>
            </div>
          </div>
        </div>

        <!-- Overall Feedback -->
        <div class="card mb-4">
          <div class="card-body">
            <h5 class="card-title mb-3">Overall Feedback</h5>
            <textarea name="feedback_text" class="feedback-textarea" rows="6" required
              placeholder="Provide detailed notes on the candidate's performance, strengths, areas of improvement, and any other relevant observations..."></textarea>
            @error('feedback_text')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <!-- Actions -->
        <div class="d-flex justify-content-between align-items-center pb-4">
          <div class="d-flex gap-2">
            <a href="{{ route('interviewer.interviews') }}" class="btn btn-outline-secondary" style="border-radius: 12px; padding: 12px 24px; border: 1px solid rgba(255,255,255,0.1); color: #fff;">
              ← Back
            </a>
            <button type="button" class="btn-danger-custom" onclick="openEscalateModal()">
              ⚑ &nbsp;Escalate Red Flag
            </button>
          </div>
          <button type="submit" class="btn-primary-custom">
            Submit Feedback
          </button>
        </div>

      </div>
    </div>

    <!-- Escalate Modal -->
    <div class="modal-backdrop-custom" id="escalateBackdrop">
      <div class="modal-panel">
        <div class="modal-header-custom">
          <h5 class="modal-title-danger">⚑ Escalate Red Flag</h5>
          <button type="button" class="modal-close" onclick="closeEscalateModal(null)">✕</button>
        </div>
        <div class="modal-body-custom">
          <p class="text-muted small mb-3">
            Use this to flag a serious concern about this candidate. The escalation will be reviewed by HR management.
          </p>
          <div class="mb-3">
            <label class="form-label-custom">Escalation Reason <span style="color:#f87171;">*</span></label>
            <textarea name="escalation_reason" id="escalation_reason_textarea" class="custom-textarea" rows="5"
              placeholder="Describe the concern in detail — e.g. dishonesty, inappropriate behavior, misrepresentation of skills..."></textarea>
          </div>
        </div>
        <div class="modal-footer-custom">
          <button type="button" class="btn-outline-custom" onclick="closeEscalateModal(null)">Cancel</button>
          <button type="button" class="btn-danger-custom" onclick="confirmEscalation()">Confirm Escalation</button>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection

@push('scripts')
  <script src="{{ asset('js/feedback.js') }}"></script>
  <script>
    function confirmEscalation() {
        const reason = document.getElementById('escalation_reason_textarea').value;
        if (!reason || reason.length < 5) {
            alert('Please provide a valid reason for escalation.');
            return;
        }
        document.getElementById('is_escalated_input').value = '1';
        alert('Red flag marked. Please proceed to submit the feedback form.');
        closeEscalateModal();
    }
  </script>
@endpush