@extends('layouts.app')

@section('sidebar')
    @include('layouts.partials.interviewer_sidebar')
@endsection

@section('title', 'Interview Session — Bridges')
@section('header-title', 'Interview Session')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/interviewsession.css') }}">
@endpush

@section('content')
<!-- Session Top Bar -->
<div class="session-topbar">
  <div class="session-info">
    <div class="session-avatar">{{ substr($interview->user->name, 0, 2) }}</div>
    <div>
      <div class="session-candidate">{{ $interview->user->name }}</div>
      <div class="session-role">{{ $interview->application->job->title ?? 'Position' }} &nbsp;·&nbsp; Technical Interview</div>
    </div>
  </div>
  <div class="session-controls">
    <div class="timer-block">
      <div class="timer-display" id="timer">--:--</div>
    </div>
    @if(Auth::user()->role === 'interviewer')
    <button class="btn-extend" onclick="openExtensionModal()">Request Extension</button>
    <form action="{{ route('session.end', $interview->id) }}" method="POST" class="d-inline" onsubmit="return confirm('End session and go to feedback?')">
        @csrf
        <button type="submit" class="btn-primary-custom" style="background:#ef4444; border:none; margin-left:10px;">End Session</button>
    </form>
    @endif
  </div>
</div>

<!-- Main Session Layout -->
<div class="session-layout">

  <!-- LEFT: Problem + Info -->
  <div class="panel-left">

    <!-- Problem Statement (Placeholder remains but I could make it dynamic if Brief had it) -->
    <div class="panel-section">
      <div class="panel-section-header">
        <span class="panel-section-icon">📄</span>
        Interview Brief / Problem
      </div>
      <p class="problem-text" style="white-space: pre-line;">
        {{ $interview->brief->content ?? 'No specific problem statement provided in the brief.' }}
      </p>
    </div>

    <!-- Participants -->
    <div class="panel-section">
      <div class="panel-section-header">
        <span class="panel-section-icon">👥</span>
        Participants
      </div>
      @foreach($interview->panels as $panel)
      <div class="participant-item">
        <div class="participant-avatar" style="background:#f5c542; color:#1a1625;">{{ substr($panel->user->name, 0, 2) }}</div>
        <div class="participant-info">
          <div class="participant-name">{{ $panel->user->name }}</div>
          <div class="participant-role">{{ ucfirst($panel->user->role) }}</div>
        </div>
        <span class="participant-badge interviewer-badge">{{ $panel->user->interviewer_type ?? 'Staff' }}</span>
      </div>
      @endforeach
      <div class="participant-item">
        <div class="participant-avatar" style="background:#8b5cf6; color:#fff;">{{ substr($interview->user->name, 0, 2) }}</div>
        <div class="participant-info">
          <div class="participant-name">{{ $interview->user->name }}</div>
          <div class="participant-role">Candidate</div>
        </div>
        <span class="participant-badge candidate-badge">Candidate</span>
      </div>
    </div>

    <!-- Session Info -->
    <div class="panel-section">
      <div class="panel-section-header">
        <span class="panel-section-icon">ℹ️</span>
        Session Info
      </div>
      <div class="info-row"><span class="info-label">Slot Date</span><span class="info-value">{{ $interview->get_date->format('M d, Y') }}</span></div>
      <div class="info-row"><span class="info-label">Start Time</span><span class="info-value">{{ \Carbon\Carbon::parse($interview->slot->start_time)->format('h:i A') }}</span></div>
      <div class="info-row" style="border:none;"><span class="info-label">Timezone</span><span class="info-value">{{ $interview->slot->time_zone }}</span></div>
    </div>

  </div>

  <!-- RIGHT: Code Editor -->
  <div class="panel-right">
    <!-- Editor Toolbar -->
    <div class="editor-toolbar">
      <div class="d-flex align-items-center gap-3">
        <select class="lang-select" id="langSelect">
          <option>JavaScript</option>
          <option>Python</option>
          <option>Java</option>
        </select>
        <span class="editor-label">Collaborative Editor</span>
      </div>
      <div class="d-flex align-items-center gap-2">
        <button class="btn-run" onclick="alert('Simulation: Running code...')">▶ Run Code</button>
      </div>
    </div>

    <textarea class="code-editor" id="codeEditor" spellcheck="false" placeholder="Candidate will write code here..."></textarea>

    <!-- Output Panel -->
    <div class="output-panel">
      <div class="output-header">Console Output</div>
      <div class="output-content" id="outputContent">Console ready. Waiting for execution...</div>
    </div>
  </div>
</div>

<!-- Time Extension Modal -->
<div class="modal-backdrop-custom" id="extensionBackdrop">
  <div class="modal-panel">
    <form action="{{ route('session.extend', $interview->id) }}" method="POST">
        @csrf
        <div class="modal-header-custom">
          <h5 class="modal-title-text">Request Time Extension</h5>
          <button type="button" class="modal-close" onclick="closeExtensionModal(null)">✕</button>
        </div>
        <div class="modal-body-custom">
          <p class="text-muted small mb-4">Submit a request to extend the current session. The HR Admin will be notified for approval.</p>
          <div class="mb-4">
            <label class="form-label-custom">Extension Time (minutes) <span style="color:#f87171;">*</span></label>
            <input type="number" name="minutes" class="custom-input" value="15" min="5" max="30" required>
          </div>
          <div class="mb-2">
            <label class="form-label-custom">Reason <span style="color:#f87171;">*</span></label>
            <textarea name="reason" class="custom-textarea" rows="4" required placeholder="Explain why additional time is needed..."></textarea>
          </div>
        </div>
        <div class="modal-footer-custom">
          <button type="button" class="btn-outline-custom" onclick="closeExtensionModal(null)">Cancel</button>
          <button type="submit" class="btn-primary-custom">Submit Request</button>
        </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
  <script src="{{ asset('js/interviewsession.js') }}"></script>
  <script>
    // TIMER LOGIC
    let secondsLeft = Math.floor(parseFloat({{ $secondsRemaining }}));
    const timerDisplay = document.getElementById('timer');

    function updateTimer() {
        if (secondsLeft <= 0) {
            timerDisplay.innerText = "00.00";
            timerDisplay.style.color = "#ef4444";
            return;
        }

        const mins = Math.floor(secondsLeft / 60);
        const secs = Math.floor(secondsLeft % 60);
        timerDisplay.innerText = `${mins.toString().padStart(2, '0')}.${secs.toString().padStart(2, '0')}`;
        
        if (secondsLeft < 300) { // Red if < 5 mins
            timerDisplay.style.color = "#ef4444";
        }
        
        secondsLeft--;
    }

    setInterval(updateTimer, 1000);
    updateTimer();

    // Modal Helpers
    function openExtensionModal() {
        document.getElementById('extensionBackdrop').classList.add('open');
    }
    function closeExtensionModal() {
        document.getElementById('extensionBackdrop').classList.remove('open');
    }
  </script>
@endpush
