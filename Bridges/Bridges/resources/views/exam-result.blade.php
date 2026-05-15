@extends('layouts.app')

@section('title', 'Exam Result — CareerPortal')
@section('header-title', 'Exam Result')

@section('content')

    {{-- ── Flash messages ─────────────────────────────────────────────────── --}}
    @if(session('success'))
    <div class="cp-card p-3 mb-4" style="background:rgba(34,197,94,0.12);border:1px solid rgba(34,197,94,0.3)">
      <p style="margin:0;color:#4ade80;font-weight:600">{{ session('success') }}</p>
    </div>
    @endif

    @if(session('info'))
    <div class="cp-card p-3 mb-4" style="background:rgba(245,197,66,0.12);border:1px solid rgba(245,197,66,0.3)">
      <p style="margin:0;color:var(--primary);font-weight:600">{{ session('info') }}</p>
    </div>
    @endif

    {{-- ── Score Overview Card ─────────────────────────────────────────────── --}}
    <div class="cp-card p-4 mb-4">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
        <div>
          <h2 style="font-size:20px;font-weight:700;margin:0 0 4px">Exam Results</h2>
          <p class="text-muted-cp" style="font-size:13px;margin:0">
            Submitted {{ $submission->submitted_at?->format('M d, Y \a\t h:i A') ?? 'N/A' }}
          </p>
        </div>
        <div class="text-center">
          <div style="font-size:48px;font-weight:800;color:{{ $percentage >= 70 ? '#4ade80' : '#ef4444' }}">
            {{ $grade }}
          </div>
          <p class="text-muted-cp" style="font-size:12px;margin:0">Grade</p>
        </div>
      </div>

      {{-- Score bar --}}
      <div class="p-3 rounded-3 mb-4" style="background:var(--secondary)">
        <div class="d-flex justify-content-between mb-2">
          <span style="font-size:14px;font-weight:600">Total Score</span>
          <span style="font-size:14px;font-weight:700;color:{{ $percentage >= 70 ? '#4ade80' : '#ef4444' }}">
            {{ $submission->total_score }} / {{ $submission->max_score }} ({{ $percentage }}%)
          </span>
        </div>
        <div class="cp-progress-track" style="height:12px">
          <div class="cp-progress-bar" style="width:{{ $percentage }}%;{{ $percentage >= 70 ? '' : 'background:#ef4444' }}"></div>
        </div>
        <p class="text-muted-cp mt-2 mb-0" style="font-size:12px">
          @if($percentage >= 70)
            ✅ You passed! Minimum passing score is 70%.
          @else
            ❌ You did not pass. Minimum passing score is 70%.
          @endif
        </p>
      </div>

      {{-- Section breakdown --}}
      <div class="row g-3">
        <div class="col-md-4">
          <div class="p-3 rounded-3" style="background:var(--secondary)">
            <div class="d-flex justify-content-between mb-1">
              <span style="font-size:13px;color:var(--muted-fg)">Multiple Choice</span>
              <span style="font-size:13px;font-weight:600">{{ $submission->mcq_score }} pts</span>
            </div>
            <p class="text-muted-cp mb-0" style="font-size:11px">{{ $mcqAnswers->count() }} questions · Auto-graded</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-3 rounded-3" style="background:var(--secondary)">
            <div class="d-flex justify-content-between mb-1">
              <span style="font-size:13px;color:var(--muted-fg)">Written</span>
              <span style="font-size:13px;font-weight:600">{{ $submission->written_score }} pts</span>
            </div>
            <p class="text-muted-cp mb-0" style="font-size:11px">{{ $writtenAnswers->count() }} questions · Keyword-graded</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-3 rounded-3" style="background:var(--secondary)">
            <div class="d-flex justify-content-between mb-1">
              <span style="font-size:13px;color:var(--muted-fg)">Coding</span>
              <span style="font-size:13px;font-weight:600">{{ $submission->code_score }} pts</span>
            </div>
            <p class="text-muted-cp mb-0" style="font-size:11px">{{ $codeAnswers->count() }} questions · Pending review</p>
          </div>
        </div>
      </div>
    </div>

    {{-- ── MCQ Answers Detail ─────────────────────────────────────────────── --}}
    @if($mcqAnswers->count() > 0)
    <div class="cp-card p-4 mb-4">
      <div class="d-flex align-items-center gap-2 mb-3">
        <span class="cp-badge badge-yellow">Multiple Choice</span>
        <span class="text-muted-cp" style="font-size:13px">{{ $mcqAnswers->where('is_correct', true)->count() }}/{{ $mcqAnswers->count() }} correct</span>
      </div>
      <div class="d-flex flex-column gap-3">
        @foreach($mcqAnswers as $i => $answer)
        <div class="p-3 rounded-3" style="background:var(--secondary);border-left:3px solid {{ $answer->is_correct ? '#4ade80' : '#ef4444' }}">
          <div class="d-flex justify-content-between mb-1">
            <span style="font-size:13px;font-weight:600">Question {{ $i + 1 }}</span>
            <span style="font-size:13px;font-weight:600;color:{{ $answer->is_correct ? '#4ade80' : '#ef4444' }}">
              {{ $answer->points_awarded }}/{{ $answer->points_possible }} pts
              {{ $answer->is_correct ? '✓' : '✗' }}
            </span>
          </div>
          <p class="text-muted-cp mb-0" style="font-size:12px">
            Your answer: <strong>{{ $answer->answer_option ?? 'No answer' }}</strong>
          </p>
        </div>
        @endforeach
      </div>
    </div>
    @endif

    {{-- ── Written Answers Detail ─────────────────────────────────────────── --}}
    @if($writtenAnswers->count() > 0)
    <div class="cp-card p-4 mb-4">
      <div class="d-flex align-items-center gap-2 mb-3">
        <span class="cp-badge badge-purple">Written</span>
        <span class="text-muted-cp" style="font-size:13px">Keyword-based grading</span>
      </div>
      <div class="d-flex flex-column gap-3">
        @foreach($writtenAnswers as $i => $answer)
        <div class="p-3 rounded-3" style="background:var(--secondary)">
          <div class="d-flex justify-content-between mb-1">
            <span style="font-size:13px;font-weight:600">Question {{ $mcqAnswers->count() + $i + 1 }}</span>
            <span style="font-size:13px;font-weight:600;color:var(--primary)">
              {{ $answer->points_awarded }}/{{ $answer->points_possible }} pts
            </span>
          </div>
          <p class="text-muted-cp mb-0" style="font-size:12px;white-space:pre-wrap">{{ Str::limit($answer->answer_text ?? 'No answer', 200) }}</p>
        </div>
        @endforeach
      </div>
    </div>
    @endif

    {{-- ── Code Answers Detail ────────────────────────────────────────────── --}}
    @if($codeAnswers->count() > 0)
    <div class="cp-card p-4 mb-4">
      <div class="d-flex align-items-center gap-2 mb-3">
        <span class="cp-badge badge-blue">Coding</span>
        <span class="text-muted-cp" style="font-size:13px">Pending manual review</span>
      </div>
      <div class="d-flex flex-column gap-3">
        @foreach($codeAnswers as $i => $answer)
        <div class="p-3 rounded-3" style="background:var(--secondary)">
          <div class="d-flex justify-content-between mb-1">
            <span style="font-size:13px;font-weight:600">Question {{ $mcqAnswers->count() + $writtenAnswers->count() + $i + 1 }}</span>
            <span class="cp-badge badge-gray">Pending Review</span>
          </div>
          <pre style="font-size:12px;color:#a5f3fc;background:#1a1a2e;padding:12px;border-radius:8px;margin:8px 0 0;overflow-x:auto;white-space:pre-wrap">{{ $answer->answer_text ?? '// No code submitted' }}</pre>
        </div>
        @endforeach
      </div>
    </div>
    @endif

    {{-- Back button --}}
    <div class="d-flex gap-2 mb-4">
      <a href="{{ route('exam') }}" class="btn-cp btn-outline-cp">Back to Assessments</a>
    </div>

@endsection
