/* interview-session.js — Bridges Recruitment System */

/* ── Countdown Timer ── */
var totalSeconds = 60 * 60;
var timerEl = document.getElementById('timer');

function updateTimer() {
  if (totalSeconds <= 0) {
    timerEl.textContent = '00:00';
    timerEl.className = 'timer-display danger';
    return;
  }
  totalSeconds--;
  var m = Math.floor(totalSeconds / 60);
  var s = totalSeconds % 60;
  timerEl.textContent = String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');

  if (totalSeconds <= 300) {
    timerEl.className = 'timer-display danger';
  } else if (totalSeconds <= 600) {
    timerEl.className = 'timer-display warning';
  } else {
    timerEl.className = 'timer-display';
  }
}

setInterval(updateTimer, 1000);

/* ── Extension Modal ── */
function openExtensionModal() {
  document.getElementById('extensionBackdrop').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeExtensionModal(e) {
  if (e === null || e.target === document.getElementById('extensionBackdrop')) {
    document.getElementById('extensionBackdrop').classList.remove('open');
    document.body.style.overflow = '';
  }
}

document.addEventListener('keydown', function (e) {
  if (e.key === 'Escape') closeExtensionModal(null);
});

/* ── Run Code (UI only) ── */
document.querySelector('.btn-run').addEventListener('click', function () {
  var output = document.getElementById('outputContent');
  output.style.color = '#4ade80';
  output.textContent = '✓  Code executed successfully. Output: [0, 1]';
});
