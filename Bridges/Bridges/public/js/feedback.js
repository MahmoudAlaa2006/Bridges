/* feedback.js — Bridges Recruitment System */

/* ── Recommendation Card Selection ── */
function setRec(radio) {
  document.querySelectorAll('.rec-card').forEach(function (c) { c.classList.remove('selected'); });
  radio.closest('.rec-option').querySelector('.rec-card').classList.add('selected');
}

/* ── Escalate Modal ── */
function openEscalateModal() {
  document.getElementById('escalateBackdrop').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeEscalateModal(e) {
  if (e === null || e.target === document.getElementById('escalateBackdrop')) {
    document.getElementById('escalateBackdrop').classList.remove('open');
    document.body.style.overflow = '';
  }
}

document.addEventListener('keydown', function (e) {
  if (e.key === 'Escape') closeEscalateModal(null);
});
