@extends('layouts.app')

@section('sidebar')
    @include('layouts.partials.candidate_sidebar')
@endsection
@section('title', 'Technical Assessment — CareerPortal')
@section('header-title', 'Technical Assessment')

@section('header-actions-prefix')
@endsection

@section('content')

    {{-- JS config — injected by Blade so exam-active.js can POST to backend --}}
    <script>
      window.EXAM_CSRF      = '{{ csrf_token() }}';
      window.EXAM_GRADE_URL = '{{ route("candidate.exam.grade-result") }}';
      window.EXAM_AVAIL_URL = '{{ route("candidate.exam.availability") }}';
    </script>

    <!-- Sticky exam header -->
    <div class="exam-sticky">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
          <p style="font-size:12px;color:var(--muted-fg);margin:0">{{ $activeApplication->title ?? 'Technical Assessment' }}</p>
          <p style="font-size:14px;font-weight:600;margin:0">6 questions &nbsp;·&nbsp; Answer all to maximize your score</p>
        </div>
        <div class="d-flex align-items-center gap-4">
          <!-- Static timer display — in a real app this would count down -->
          <div class="text-center">
            <div class="exam-timer">45:00</div>
            <p class="text-muted-cp" style="font-size:11px;margin:0">Time Remaining</p>
          </div>
          <button onclick="confirmSubmit()" class="btn-cp btn-primary-cp">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            Submit Exam
          </button>
        </div>
      </div>
    </div>

    <!-- All questions in one scrollable page -->
    <div class="d-flex flex-column gap-4">
      @forelse($questions as $index => $q)
        @php
          $qNum = $index + 1;
          $type = null;
          if ($q->mcqQuestion) $type = 'MCQ';
          elseif ($q->writtenQuestion) $type = 'WRITTEN';
          elseif ($q->codeQuestion) $type = 'CODE';
        @endphp

        @if($type === 'MCQ')
          <div class="q-block" id="qblock-{{ $qNum }}" data-question-db-id="{{ $q->question_id }}" data-type="MCQ">
            <div class="d-flex align-items-center gap-2 mb-3">
              <span class="cp-badge badge-yellow">Multiple Choice</span>
              <span class="text-muted-cp" style="font-size:13px">{{ $q->points }} points</span>
            </div>
            <div class="d-flex align-items-start gap-3 mb-3">
              <span class="q-num" id="qnum-{{ $qNum }}">{{ $qNum }}</span>
              <div>
                <p style="font-size:14px;font-weight:600;margin:0 0 2px">{{ $q->text }}</p>
                <p class="text-muted-cp" style="font-size:12px;margin:0">Multiple Choice &nbsp;·&nbsp; {{ $q->topic }}</p>
              </div>
            </div>
            <div class="d-flex flex-column gap-2" data-question="{{ $qNum }}">
              @foreach($q->mcqQuestion->options as $i => $optText)
                <button class="exam-option" onclick="selectOption({{ $qNum }}, {{ $i }})">
                  <input type="radio" name="q{{ $qNum }}"> {{ $optText }}
                </button>
              @endforeach
            </div>
          </div>

        @elseif($type === 'WRITTEN')
          <div class="q-block" id="qblock-{{ $qNum }}" data-question-db-id="{{ $q->question_id }}" data-type="WRITTEN">
            <div class="d-flex align-items-center gap-2 mb-3">
              <span class="cp-badge badge-purple">Written</span>
              <span class="text-muted-cp" style="font-size:13px">{{ $q->points }} points</span>
            </div>
            <div class="d-flex align-items-start gap-3 mb-3">
              <span class="q-num" id="qnum-{{ $qNum }}">{{ $qNum }}</span>
              <div>
                <p style="font-size:14px;font-weight:600;margin:0 0 2px">{{ $q->text }}</p>
                <p class="text-muted-cp" style="font-size:12px;margin:0">Written Response &nbsp;·&nbsp; {{ $q->topic }}</p>
              </div>
            </div>
            <textarea class="cp-input" placeholder="Write your answer here…" rows="5" style="min-height:120px"></textarea>
          </div>

        @elseif($type === 'CODE')
          <div class="q-block" id="qblock-{{ $qNum }}" data-question-db-id="{{ $q->question_id }}" data-type="CODE">
            <div class="d-flex align-items-center gap-2 mb-3">
              <span class="cp-badge badge-blue">Coding</span>
              <span class="text-muted-cp" style="font-size:13px">{{ $q->points }} points</span>
            </div>
            <div class="d-flex align-items-start gap-3 mb-3">
              <span class="q-num" id="qnum-{{ $qNum }}">{{ $qNum }}</span>
              <div>
                <p style="font-size:14px;font-weight:600;margin:0 0 2px">{{ $q->text }}</p>
                <p class="text-muted-cp" style="font-size:12px;margin:0">Coding Task &nbsp;·&nbsp; {{ $q->topic }}</p>
              </div>
            </div>
            <textarea class="code-input" placeholder="// Write your solution here…" rows="8" style="min-height:200px;font-family:monospace"></textarea>
          </div>
        @endif
      @empty
        <div class="p-5 text-center cp-card">
          <p class="text-muted-cp">No dynamic questions found for this assessment. Please contact support.</p>
        </div>
      @endforelse
    </div>

      <!-- Submit button at bottom of page -->
      <div class="d-flex justify-content-end gap-3 pb-4">
        <!-- <a href="exam.html" class="btn-cp btn-outline-cp">Save &amp; Exit</a> -->
        <button onclick="confirmSubmit()" class="btn-cp btn-primary-cp">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
          Submit Exam
        </button>
      </div>

@endsection

@push('scripts')
<script>
    const EXAM_SUBMIT_URL = "{{ route('candidate.exam') }}";
</script>
<script src="{{ asset('js/exam-active.js') }}"></script>
@endpush

