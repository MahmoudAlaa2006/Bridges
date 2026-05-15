// ============================================================
// exam-active.js — Exam page UI interactions only
// This file handles visual feedback for answer selection.
// No score calculation, no data storage, no timer logic.
// ============================================================

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
        '<p class="mb-0 text-muted-cp mt-1" style="font-size:12px">Once submitted, you cannot change your answers.</p>' +
      '</div>' +
      '<div class="d-flex gap-2">' +
        '<button onclick="closeModal()" class="btn-cp btn-outline-cp flex-fill justify-content-center">Go Back</button>' +
        '<a href="exam.html" class="btn-cp btn-primary-cp flex-fill justify-content-center">' +
          '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Submit Exam' +
        '</a>' +
      '</div>' +
    '</div>'
  );
}
