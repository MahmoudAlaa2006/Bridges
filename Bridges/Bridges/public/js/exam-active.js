// ============================================================
// exam-active.js — Exam page interactions and Timer
// ============================================================

let timeLeft = 45 * 60; // 45 minutes in seconds
let timerInterval = null;
let timerStarted = false;

document.addEventListener('DOMContentLoaded', function() {
  // Listen for first interaction to start timer
  document.addEventListener('click', triggerTimer, { once: true });
  document.addEventListener('keydown', triggerTimer, { once: true });
});

function triggerTimer() {
  if (!timerStarted) {
    timerStarted = true;
    startTimer();
  }
}

function startTimer() {
  const timerDisplay = document.querySelector('.exam-timer');
  if (!timerDisplay) return;

  timerInterval = setInterval(() => {
    timeLeft--;
    
    if (timeLeft <= 0) {
      clearInterval(timerInterval);
      timerDisplay.innerHTML = "00:00";
      timerDisplay.style.color = "var(--danger)";
      autoSubmitExam();
      return;
    }

    const minutes = Math.floor(timeLeft / 60);
    const seconds = timeLeft % 60;
    
    timerDisplay.innerHTML = 
      (minutes < 10 ? "0" : "") + minutes + ":" + 
      (seconds < 10 ? "0" : "") + seconds;

    if (timeLeft < 300) { // Red color for last 5 minutes
      timerDisplay.style.color = "#f87171";
    }
  }, 1000);
}

function autoSubmitExam() {
  alert("Time is up! Your exam will be submitted automatically.");
  submitExamFinal();
}

// ============================================================
// MCQ OPTION SELECTION
// When a user clicks an answer option, this function:
//   1. Removes the 'selected' highlight from all options in that question
//   2. Adds the 'selected' highlight to the clicked option
//   3. Checks the radio button visually
// This is purely visual — no answers are recorded anywhere.
// ============================================================
function selectOption(questionId, optionIndex) {
  // Find all answer buttons belonging to this question
  var options = document.querySelectorAll('[data-question="' + questionId + '"] .exam-option');

  // Remove selected state from every option in the group
  options.forEach(function (opt, i) {
    opt.classList.remove('selected');
    var radio = opt.querySelector('input[type="radio"]');
    if (radio) radio.checked = false;
  });

  // Apply selected state to the clicked option
  if (options[optionIndex]) {
    options[optionIndex].classList.add('selected');
    var selectedRadio = options[optionIndex].querySelector('input[type="radio"]');
    if (selectedRadio) selectedRadio.checked = true;
  }
}

// ============================================================
// SUBMIT EXAM MODAL
// When the user clicks "Submit Exam", show a confirmation
// modal before they proceed. This is a UI-only confirmation.
// ============================================================
function confirmSubmit() {
  openModal(
    '<div class="p-4">' +
      '<div class="d-flex align-items-start justify-content-between gap-3 mb-3">' +
        '<h5 class="fw-semibold mb-0">Submit Exam?</h5>' +
        '<button onclick="closeModal()" class="btn-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>' +
      '</div>' +
      '<div class="rounded-3 p-3 mb-3 bg-primary-soft">' +
        '<p class="mb-0 text-primary-cp fw-medium" style="font-size:13px">Are you sure you want to submit your exam?</p>' +
        '<p class="mb-0 text-muted-cp mt-1" style="font-size:12px">Once submitted, your answers will be graded immediately.</p>' +
      '</div>' +
      '<div class="d-flex gap-2">' +
        '<button onclick="closeModal()" class="btn-cp btn-outline-cp flex-fill justify-content-center">Go Back</button>' +
        '<button id="btn-submit-final" onclick="submitExamFinal()" class="btn-cp btn-primary-cp flex-fill justify-content-center">' +
          '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Confirm Submit' +
        '</button>' +
      '</div>' +
    '</div>'
  );
}

function submitExamFinal() {
  const btn = document.getElementById('btn-submit-final');
  if (btn) {
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Grading...';
  }

  const answers = {};
  document.querySelectorAll('.q-block').forEach(block => {
    const qId = block.getAttribute('data-question-db-id');
    const type = block.getAttribute('data-type');

    if (type === 'MCQ') {
      const selected = block.querySelector('.exam-option.selected');
      if (selected) {
        // Find index of selected option
        const options = Array.from(block.querySelectorAll('.exam-option'));
        answers[qId] = options.indexOf(selected);
      } else {
        answers[qId] = null;
      }
    } else if (type === 'WRITTEN') {
      answers[qId] = block.querySelector('textarea').value;
    } else if (type === 'CODE') {
      answers[qId] = block.querySelector('textarea').value;
    }
  });

  fetch(window.EXAM_GRADE_URL, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': window.EXAM_CSRF
    },
    body: JSON.stringify({ answers: answers })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      window.location.href = data.redirect;
    } else {
      alert('Error: ' + (data.error || 'Something went wrong'));
      if (btn) {
        btn.disabled = false;
        btn.innerHTML = 'Confirm Submit';
      }
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Failed to submit exam. Please check your connection.');
    if (btn) {
      btn.disabled = false;
      btn.innerHTML = 'Confirm Submit';
    }
  });
}
