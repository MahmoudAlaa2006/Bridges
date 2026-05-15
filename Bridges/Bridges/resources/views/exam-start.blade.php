@extends('layouts.app')

@section('title', 'Technical Assessment — CareerPortal')
@section('header-title', 'Technical Assessment')

@section('content')

    {{-- ── Sticky exam header ──────────────────────────────────────────────── --}}
    <div class="exam-sticky">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
          <p style="font-size:12px;color:var(--muted-fg);margin:0">Assessment #{{ $assessment->id }}</p>
          <p style="font-size:14px;font-weight:600;margin:0">{{ $totalQuestions }} questions &nbsp;·&nbsp; Answer all to maximize your score</p>
        </div>
        <div class="d-flex align-items-center gap-4">
          {{-- Focus-loss counter --}}
          <div class="text-center">
            <div id="proctor-badge" class="proctor-badge">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
              </svg>
              <span id="proctor-count">0 / 5</span>
            </div>
            <p class="text-muted-cp" style="font-size:11px;margin:0">Focus Warnings</p>
          </div>

          {{-- Timer --}}
          <div class="text-center">
            <div class="exam-timer" id="exam-timer">{{ str_pad($timeLimit, 2, '0', STR_PAD_LEFT) }}:00</div>
            <p class="text-muted-cp" style="font-size:11px;margin:0">Time Remaining</p>
          </div>
          <button type="button" onclick="confirmSubmit()" class="btn-cp btn-primary-cp">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            Submit Exam
          </button>
        </div>
      </div>
    </div>

    {{-- ── Flag banner (hidden until threshold exceeded) ───────────────────── --}}
    <div id="proctor-flag-banner" class="proctor-flag-banner" style="display:none">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
      </svg>
      <span>Your exam has been flagged due to excessive focus loss. This will be reviewed by the HR team.</span>
    </div>

    {{-- ── Main exam form ───────────────────────────────────────────────────── --}}
    {{-- All inputs live inside ONE <form> so a single submit sends everything --}}
    <form id="exam-form"
          method="POST"
          action="{{ route('exam.submit', $assessment->id) }}">
      @csrf

      {{-- Pass the exact question IDs shown in this exam so grading only scores these --}}
      @foreach($mcqQuestions as $q)
        <input type="hidden" name="shown_questions[]" value="{{ $q->question_id }}">
      @endforeach
      @foreach($writtenQuestions as $q)
        <input type="hidden" name="shown_questions[]" value="{{ $q->question_id }}">
      @endforeach
      @foreach($codeQuestions as $q)
        <input type="hidden" name="shown_questions[]" value="{{ $q->question_id }}">
      @endforeach

      <div class="d-flex flex-column gap-4">

        @php $qNumber = 1; @endphp

        {{-- ════════════════════════════════════════════════════════════
             SECTION: MULTIPLE CHOICE
             ════════════════════════════════════════════════════════════ --}}
        @if($mcqQuestions->count() > 0)
        <div>
          <div class="d-flex align-items-center gap-2 mb-3">
            <span class="cp-badge badge-yellow">Multiple Choice</span>
            <span class="text-muted-cp" style="font-size:13px">
              {{ $mcqQuestions->count() }} questions · 20 pts each · {{ $mcqQuestions->sum('points') }} pts total
            </span>
          </div>

          <div class="d-flex flex-column gap-3">
            @foreach($mcqQuestions as $mcq)
            <div class="q-block" id="qblock-{{ $qNumber }}">
              <div class="d-flex align-items-start gap-3 mb-3">
                <span class="q-num" id="qnum-{{ $qNumber }}">{{ $qNumber }}</span>
                <div>
                  <p style="font-size:14px;font-weight:600;margin:0 0 2px">{{ $mcq->text }}</p>
                  <p class="text-muted-cp" style="font-size:12px;margin:0">Multiple Choice &nbsp;·&nbsp; {{ $mcq->points }} points</p>
                </div>
              </div>

              {{-- Each button click checks the hidden radio input AND highlights the row --}}
              <div class="d-flex flex-column gap-2" data-question="{{ $qNumber }}">
                @foreach(['A' => $mcq->option_a, 'B' => $mcq->option_b, 'C' => $mcq->option_c, 'D' => $mcq->option_d] as $letter => $label)
                <label class="exam-option" id="opt-{{ $qNumber }}-{{ $letter }}">
                  <input type="radio"
                         name="q{{ $mcq->question_id }}"
                         value="{{ $letter }}"
                         onchange="highlightOption({{ $qNumber }}, '{{ $letter }}')">
                  <span class="option-letter">{{ $letter }}</span>
                  {{ $label }}
                </label>
                @endforeach
              </div>
            </div>
            @php $qNumber++; @endphp
            @endforeach
          </div>
        </div>
        @endif

        {{-- ════════════════════════════════════════════════════════════
             SECTION: WRITTEN
             ════════════════════════════════════════════════════════════ --}}
        @if($writtenQuestions->count() > 0)
        <div>
          <div class="d-flex align-items-center gap-2 mb-3">
            <span class="cp-badge badge-purple">Written</span>
            <span class="text-muted-cp" style="font-size:13px">
              {{ $writtenQuestions->count() }} questions · 15 pts each · {{ $writtenQuestions->sum('points') }} pts total
            </span>
          </div>

          <div class="d-flex flex-column gap-3">
            @foreach($writtenQuestions as $written)
            <div class="q-block" id="qblock-{{ $qNumber }}">
              <div class="d-flex align-items-start gap-3 mb-3">
                <span class="q-num" id="qnum-{{ $qNumber }}">{{ $qNumber }}</span>
                <div>
                  <p style="font-size:14px;font-weight:600;margin:0 0 2px">{{ $written->text }}</p>
                  <p class="text-muted-cp" style="font-size:12px;margin:0">Written Response &nbsp;·&nbsp; {{ $written->points }} points &nbsp;·&nbsp; Minimum 50 characters</p>
                </div>
              </div>
              <textarea class="cp-input"
                        name="q{{ $written->question_id }}"
                        placeholder="Write your answer here…"
                        rows="5"
                        style="min-height:120px"
                        minlength="50"></textarea>
              <p class="text-muted-cp mt-1 mb-0" style="font-size:11px">Clear, well-structured answers are preferred. No word limit.</p>
            </div>
            @php $qNumber++; @endphp
            @endforeach
          </div>
        </div>
        @endif

        {{-- ════════════════════════════════════════════════════════════
             SECTION: CODING
             ════════════════════════════════════════════════════════════ --}}
        @if($codeQuestions->count() > 0)
        <div>
          <div class="d-flex align-items-center gap-2 mb-3">
            <span class="cp-badge badge-blue">Coding</span>
            <span class="text-muted-cp" style="font-size:13px">
              {{ $codeQuestions->count() }} questions · 10 pts each · {{ $codeQuestions->sum('points') }} pts total
            </span>
          </div>

          @foreach($codeQuestions as $code)
          <div class="q-block" id="qblock-{{ $qNumber }}">
            <div class="d-flex align-items-start gap-3 mb-3">
              <span class="q-num" id="qnum-{{ $qNumber }}">{{ $qNumber }}</span>
              <div>
                <p style="font-size:14px;font-weight:600;margin:0 0 2px">{{ $code->text }}</p>
                <p class="text-muted-cp" style="font-size:12px;margin:0">Coding ({{ $code->language }}) &nbsp;·&nbsp; {{ $code->points }} points</p>
              </div>
            </div>
            <textarea class="code-input"
                      name="q{{ $code->question_id }}"
                      placeholder="// Write your solution here"></textarea>
            <p class="text-muted-cp mt-1 mb-0" style="font-size:11px">Write your code in {{ $code->language }}.</p>
          </div>
          @php $qNumber++; @endphp
          @endforeach
        </div>
        @endif

        {{-- Submit button at bottom of page --}}
        <div class="d-flex justify-content-end gap-3 pb-4">
          <button type="button" onclick="confirmSubmit()" class="btn-cp btn-primary-cp">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            Submit Exam
          </button>
        </div>

      </div><!-- /.d-flex.flex-column -->
    </form><!-- /#exam-form -->

@endsection

@push('scripts')
{{-- Proctor configuration --}}
<script>
  window.EXAM_CONFIG = {
    submissionId: {{ $submission->id }},
    logEventUrl:  "{{ route('exam.monitor.log') }}",
    csrfToken:    "{{ csrf_token() }}"
  };
</script>
<script src="{{ asset('js/exam-proctor.js') }}"></script>
<script>
// ── MCQ option highlight ─────────────────────────────────────────────────────
function highlightOption(qNum, selected) {
  // Remove active class from all options in this question
  document.querySelectorAll(`[id^="opt-${qNum}-"]`).forEach(el => {
    el.classList.remove('exam-option--selected');
  });
  // Add active class to selected
  const el = document.getElementById(`opt-${qNum}-${selected}`);
  if (el) el.classList.add('exam-option--selected');
}

// ── Countdown timer ──────────────────────────────────────────────────────────
(function () {
  let totalSeconds = {{ $timeLimit }} * 60;
  const timerEl = document.getElementById('exam-timer');

  const interval = setInterval(() => {
    totalSeconds--;
    if (totalSeconds <= 0) {
      clearInterval(interval);
      timerEl.textContent = '00:00';
      timerEl.style.color = 'var(--danger, #e53e3e)';
      // Auto-submit when time runs out
      document.getElementById('exam-form').submit();
      return;
    }

    const m = Math.floor(totalSeconds / 60).toString().padStart(2, '0');
    const s = (totalSeconds % 60).toString().padStart(2, '0');
    timerEl.textContent = `${m}:${s}`;

    // Turn red in last 5 minutes
    if (totalSeconds <= 300) {
      timerEl.style.color = 'var(--danger, #e53e3e)';
    }
  }, 1000);
})();

// ── Confirm-and-submit dialog ────────────────────────────────────────────────
function confirmSubmit() {
  if (confirm('Are you sure you want to submit your exam? You cannot change your answers after submission.')) {
    document.getElementById('exam-form').submit();
  }
}
</script>
@endpush
