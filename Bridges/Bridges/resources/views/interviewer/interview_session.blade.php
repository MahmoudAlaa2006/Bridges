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
    <div class="session-avatar">AC</div>
    <div>
      <div class="session-candidate">Alex Chen</div>
      <div class="session-role">Senior Frontend Developer &nbsp;·&nbsp; Technical Interview</div>
    </div>
  </div>
  <div class="session-controls">
    <div class="timer-block">
      <span class="timer-label">Time Remaining</span>
      <div class="timer-display" id="timer">60:00</div>
    </div>
    <button class="btn-extend" onclick="openExtensionModal()">Request Extension</button>
  </div>
</div>

<!-- Main Session Layout -->
<div class="session-layout">

  <!-- LEFT: Problem + Info -->
  <div class="panel-left">

    <!-- Problem Statement -->
    <div class="panel-section">
      <div class="panel-section-header">
        <span class="panel-section-icon">📄</span>
        Problem Statement
        <span class="difficulty-badge">Easy</span>
      </div>
      <h5 class="problem-title">Two Sum</h5>
      <p class="problem-text">
        Given an array of integers <code class="inline-code">nums</code> and an integer <code class="inline-code">target</code>,
        return <em>indices</em> of the two numbers such that they add up to <code class="inline-code">target</code>.
      </p>
      <p class="problem-text">
        You may assume that each input would have <strong>exactly one solution</strong>, and you may not use the same element twice.
        You can return the answer in any order.
      </p>
      <div class="example-block">
        <div class="example-label">Example 1</div>
        <code class="example-code">
          Input:  nums = [2, 7, 11, 15], target = 9<br>
          Output: [0, 1]<br>
          <span style="color:#6b7280;">// nums[0] + nums[1] = 2 + 7 = 9</span>
        </code>
      </div>
      <div class="example-block">
        <div class="example-label">Example 2</div>
        <code class="example-code">
          Input:  nums = [3, 2, 4], target = 6<br>
          Output: [1, 2]
        </code>
      </div>
      <div class="constraints-block">
        <div class="constraints-label">Constraints</div>
        <ul class="constraints-list">
          <li>2 ≤ nums.length ≤ 10⁴</li>
          <li>-10⁹ ≤ nums[i] ≤ 10⁹</li>
          <li>Only one valid answer exists</li>
        </ul>
      </div>
    </div>

    <!-- Participants -->
    <div class="panel-section">
      <div class="panel-section-header">
        <span class="panel-section-icon">👥</span>
        Participants
      </div>
      <div class="participant-item">
        <div class="participant-avatar" style="background:#f5c542; color:#1a1625;">JS</div>
        <div class="participant-info">
          <div class="participant-name">James Scott</div>
          <div class="participant-role">Interviewer</div>
        </div>
        <span class="participant-badge interviewer-badge">Interviewer</span>
      </div>
      <div class="participant-item">
        <div class="participant-avatar" style="background:#8b5cf6; color:#fff;">AC</div>
        <div class="participant-info">
          <div class="participant-name">Alex Chen</div>
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
      <div class="info-row"><span class="info-label">Duration</span><span class="info-value">60 minutes</span></div>
      <div class="info-row"><span class="info-label">Date</span><span class="info-value">May 10, 2026</span></div>
      <div class="info-row"><span class="info-label">Time</span><span class="info-value">10:00 AM</span></div>
      <div class="info-row" style="border:none;"><span class="info-label">HR Contact</span><span class="info-value">Sarah Johnson</span></div>
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
          <option>C++</option>
          <option>Go</option>
        </select>
        <span class="editor-label">Code Editor</span>
      </div>
      <div class="d-flex align-items-center gap-2">
        <button class="btn-run">▶ Run Code</button>
      </div>
    </div>

    <!-- Code Textarea -->
    <textarea class="code-editor" id="codeEditor" spellcheck="false">/**
 * @param {number[]} nums
 * @param {number} target
 * @return {number[]}
 */
function twoSum(nums, target) {
    // Write your solution here
    
}</textarea>

    <!-- Output Panel -->
    <div class="output-panel">
      <div class="output-header">Output</div>
      <div class="output-content" id="outputContent">Run your code to see the output here.</div>
    </div>

  </div>

</div>

<!-- Time Extension Modal -->
<div class="modal-backdrop-custom" id="extensionBackdrop" onclick="closeExtensionModal(event)">
  <div class="modal-panel">
    <div class="modal-header-custom">
      <h5 class="modal-title-text">Request Time Extension</h5>
      <button class="modal-close" onclick="closeExtensionModal(null)">✕</button>
    </div>
    <div class="modal-body-custom">
      <p class="text-muted small mb-4">Submit a request to extend the current session. The HR manager will be notified.</p>
      <div class="mb-4">
        <label class="form-label-custom">Extension Time (minutes) <span style="color:#f87171;">*</span></label>
        <input type="number" class="custom-input" value="15" min="5" max="30" placeholder="e.g. 15">
      </div>
      <div class="mb-2">
        <label class="form-label-custom">Reason <span style="color:#f87171;">*</span></label>
        <textarea class="custom-textarea" rows="4"
          placeholder="Explain why additional time is needed..."></textarea>
      </div>
    </div>
    <div class="modal-footer-custom">
      <button class="btn-outline-custom" onclick="closeExtensionModal(null)">Cancel</button>
      <button class="btn-primary-custom" onclick="closeExtensionModal(null)">Submit Request</button>
    </div>
  </div>
</div>
@endsection

@push('scripts')
  <script src="{{ asset('js/interviewsession.js') }}"></script>
@endpush
