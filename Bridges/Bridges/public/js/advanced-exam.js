// ============================================================
// exam-active.js — Exam page UI + post-submit result flow
//
// Depends on window globals injected by exam-template.blade.php:
//   window.EXAM_CSRF       → Laravel CSRF token
//   window.EXAM_GRADE_URL  → POST /exam/grade-result
//   window.EXAM_AVAIL_URL  → POST /exam/availability
//   window.EXAM_SCORE      → (optional) set by external grading system
// ============================================================

// ── State ────────────────────────────────────────────────────────────────────
var _windowCount = 1;           // current number of availability window rows
var _gradeResult  = null;       // saved grade response (for availability form)

// ── MCQ option selection (visual only) ───────────────────────────────────────
function selectOption(questionId, optionIndex) {
  var options = document.querySelectorAll('[data-question="' + questionId + '"] .exam-option');
  options.forEach(function (opt) {
    opt.classList.remove('selected');
    var r = opt.querySelector('input[type="radio"]');
    if (r) r.checked = false;
  });
  if (options[optionIndex]) {
    options[optionIndex].classList.add('selected');
    var sel = options[optionIndex].querySelector('input[type="radio"]');
    if (sel) sel.checked = true;
  }
}

// ── Step 1: Confirmation modal ────────────────────────────────────────────────
function confirmSubmit() {
  openModal(
    '<div class="p-4">' +
      '<div class="d-flex align-items-start justify-content-between gap-3 mb-3">' +
        '<h5 class="fw-semibold mb-0">Submit Exam?</h5>' +
        '<button onclick="closeModal()" class="btn-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>' +
      '</div>' +
      '<div class="rounded-3 p-3 mb-3 bg-primary-soft">' +
        '<p class="mb-0 text-primary-cp fw-medium" style="font-size:13px">Are you sure you want to submit your exam?</p>' +
        '<p class="mb-0 text-muted-cp mt-1" style="font-size:12px">Once submitted, you cannot change your answers.</p>' +
      '</div>' +
      '<div class="d-flex gap-2">' +
        '<button onclick="closeModal()" class="btn-cp btn-outline-cp flex-fill justify-content-center">Go Back</button>' +
        '<button onclick="submitExam()" class="btn-cp btn-primary-cp flex-fill justify-content-center">' +
          '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Submit Exam' +
        '</button>' +
      '</div>' +
    '</div>'
  );
}

// ── Step 2: POST exam score to backend ────────────────────────────────────────
function submitExam() {
  // Show loading state
  openModal(
    '<div class="p-4 text-center">' +
      '<div style="width:48px;height:48px;border:3px solid var(--border);border-top-color:var(--primary);border-radius:50%;animation:spin 0.8s linear infinite;margin:0 auto 16px"></div>' +
      '<p style="font-size:14px;font-weight:600;margin:0">Submitting your exam…</p>' +
      '<p class="text-muted-cp" style="font-size:12px;margin:4px 0 0">Please wait while we process your results.</p>' +
    '</div>'
  );

  var calculatedScore = 0;
  
  // Helper to check if an option is selected
  function isSelected(q, optIndex) {
    var opts = document.querySelectorAll('[data-question="' + q + '"] .exam-option');
    return opts[optIndex] && opts[optIndex].classList.contains('selected');
  }

  // Multiple Choice (20 points each)
  if (isSelected(1, 1)) calculatedScore += 20; // Closure
  if (isSelected(2, 2)) calculatedScore += 20; // useEffect
  if (isSelected(3, 1)) calculatedScore += 20; // useMemo

  // Written & Coding (just check if they typed something)
  var textareas = document.querySelectorAll('textarea');
  if (textareas[0] && textareas[0].value.trim().length > 10) calculatedScore += 15;
  if (textareas[1] && textareas[1].value.trim().length > 10) calculatedScore += 15;
  if (textareas[2] && textareas[2].value.trim().length > 10) calculatedScore += 10;

  var examScore = calculatedScore;

  var body = new FormData();
  body.append('_token',     window.EXAM_CSRF);
  body.append('exam_score', examScore);

  fetch(window.EXAM_GRADE_URL, {
    method:  'POST',
    headers: { 'X-CSRF-TOKEN': window.EXAM_CSRF, 'Accept': 'application/json' },
    body:    body
  })
  .then(function(res) { return res.json(); })
  .then(function(data) {
    if (data.success) {
      _gradeResult = data;
      showExamSubmittedNotification(data);
    } else {
      showExamError(data.error || 'Submission failed. Please try again.');
    }
  })
  .catch(function() {
    showExamError('Network error. Please check your connection and try again.');
  });
}

// ── Step 3: Show Result & Availability Form ──────────────────────────────────────────
function showExamSubmittedNotification(data) {
  if (!data.passed) {
    // Failed state
    openModal(
      '<div class="p-4 text-center">' +
        '<div style="width:60px;height:60px;border-radius:50%;background:rgba(248,113,113,0.12);display:flex;align-items:center;justify-content:center;margin:0 auto 14px">' +
          '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="#f87171" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>' +
        '</div>' +
        '<h5 style="font-weight:700;color:#f87171;margin:0 0 6px">Assessment Not Passed</h5>' +
        '<p class="text-muted-cp" style="font-size:13px;margin:0 0 16px">Unfortunately, your score of ' + data.exam_score + ' did not meet the required threshold. We appreciate your time and effort.</p>' +
        '<a href="/overview" class="btn-cp btn-outline-cp w-100 justify-content-center">Return to Dashboard</a>' +
      '</div>'
    );
    return;
  }

  // Passed state -> show availability form
  _windowCount = 1;
  openModal(
    '<div class="p-4">' +
      '<div class="text-center mb-4">' +
        '<div style="width:56px;height:56px;border-radius:50%;background:rgba(52,211,153,0.12);display:flex;align-items:center;justify-content:center;margin:0 auto 12px">' +
          '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="#34d399" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>' +
        '</div>' +
        '<h5 style="font-weight:700;color:#34d399;margin:0 0 4px">Assessment Passed!</h5>' +
        '<p class="text-muted-cp" style="font-size:13px;margin:0">You scored ' + data.exam_score + '. Please provide your availability for the interview stage.</p>' +
      '</div>' +

      '<div class="p-3 mb-4 rounded-3" style="background:var(--secondary);border:1px solid var(--border)">' +
        '<div class="d-flex align-items-center justify-content-between mb-3">' +
          '<span style="font-size:13px;font-weight:600">Availability Windows</span>' +
          '<button onclick="addWindow()" class="btn-cp" style="font-size:12px;padding:4px 8px;background:var(--primary);color:#fff;border-radius:6px;border:none">' +
            '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Add Window' +
          '</button>' +
        '</div>' +
        '<div id="avail-windows">' + _windowRow(1) + '</div>' +
        '<p id="avail-error" style="color:#f87171;font-size:12px;margin:8px 0 0;display:none"></p>' +
      '</div>' +

      '<button onclick="submitAvailability()" class="btn-cp btn-primary-cp w-100 justify-content-center">' +
        'Submit Availability' +
      '</button>' +
    '</div>'
  );
}

function addWindow() {
  if (_windowCount >= 7) {
    _showAvailError("Maximum 7 availability windows allowed.");
    return;
  }
  _windowCount++;
  var container = document.getElementById('avail-windows');
  if (container) {
    container.insertAdjacentHTML('beforeend', _windowRow(_windowCount));
  }
}

function removeWindow(n) {
  var row = document.getElementById('window-row-' + n);
  if (row) row.remove();
}

function submitAvailability() {
  var rows = document.querySelectorAll('.avail-window-row');
  var windows = [];
  var tz = Intl.DateTimeFormat().resolvedOptions().timeZone || 'UTC';
  
  for (var i = 0; i < rows.length; i++) {
    var dateVal = rows[i].querySelector('.w-date').value;
    var startVal = rows[i].querySelector('.w-start').value;
    var endVal = rows[i].querySelector('.w-end').value;
    
    if (!dateVal || !startVal || !endVal) {
      _showAvailError("Please fill out all fields in your availability windows.");
      return;
    }
    windows.push({
      date: dateVal,
      start_time: startVal,
      end_time: endVal,
      time_zone: tz
    });
  }

  // Update button state
  var btn = document.querySelector('button[onclick="submitAvailability()"]');
  if (btn) btn.innerHTML = 'Submitting...';

  fetch(window.EXAM_AVAIL_URL, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': window.EXAM_CSRF,
      'Accept': 'application/json'
    },
    body: JSON.stringify({ windows: windows })
  })
  .then(function(res) { return res.json(); })
  .then(function(data) {
    if (data.success) {
      openModal(
        '<div class="p-4 text-center">' +
          '<div style="width:60px;height:60px;border-radius:50%;background:rgba(59,130,246,0.12);display:flex;align-items:center;justify-content:center;margin:0 auto 14px">' +
            '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="#60a5fa" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>' +
          '</div>' +
          '<h5 style="font-weight:700;color:#60a5fa;margin:0 0 6px">All Set!</h5>' +
          '<p class="text-muted-cp" style="font-size:13px;margin:0 0 16px">' + data.message + '</p>' +
          '<a href="/overview" class="btn-cp btn-primary-cp w-100 justify-content-center">Go to Dashboard</a>' +
        '</div>'
      );
    } else {
      _showAvailError(data.message || data.error || 'Failed to submit availability.');
      if (btn) btn.innerHTML = 'Submit Availability';
    }
  })
  .catch(function(e) {
    _showAvailError('Network error. Please try again.');
    if (btn) btn.innerHTML = 'Submit Availability';
  });
}

// ── Helpers ───────────────────────────────────────────────────────────────────
function _scorePill(label, value, color) {
  return '<div style="background:rgba(255,255,255,0.04);border:1px solid var(--border);border-radius:10px;padding:10px 6px">' +
    '<div style="font-size:20px;font-weight:800;color:' + color + ';line-height:1">' + value + '</div>' +
    '<div class="text-muted-cp" style="font-size:11px;margin-top:3px">' + label + '</div>' +
  '</div>';
}

function _windowRow(n) {
  var today = new Date().toISOString().split('T')[0];
  return '<div class="avail-window-row d-flex align-items-center gap-2 mb-2" id="window-row-' + n + '">' +
    '<input type="date" class="cp-input w-date" style="flex:2;min-width:0" min="' + today + '" required>' +
    '<input type="time" class="cp-input w-start" style="flex:1;min-width:0" placeholder="Start" required>' +
    '<input type="time" class="cp-input w-end"   style="flex:1;min-width:0" placeholder="End"   required>' +
    (n > 1
      ? '<button onclick="removeWindow(' + n + ')" class="btn-icon" title="Remove" style="flex-shrink:0">' +
          '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#f87171" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>' +
        '</button>'
      : '<div style="width:32px;flex-shrink:0"></div>'
    ) +
  '</div>';
}

function _showAvailError(msg) {
  var el = document.getElementById('avail-error');
  if (el) { el.style.display = 'block'; el.textContent = msg; }
}

function showExamError(msg) {
  openModal(
    '<div class="p-4 text-center">' +
      '<p style="color:#f87171;font-weight:600;margin:0 0 12px">Submission Error</p>' +
      '<p class="text-muted-cp" style="font-size:13px;margin:0 0 16px">' + msg + '</p>' +
      '<button onclick="closeModal()" class="btn-cp btn-outline-cp w-100 justify-content-center">Close</button>' +
    '</div>'
  );
}
