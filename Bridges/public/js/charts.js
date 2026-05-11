/* ============================================================
   CareerPortal HR Dashboard — Charts
   Chart.js definitions. Uses design tokens from CSS vars.
   Safe to include on every page — each function guards itself.
   ============================================================ */

var CP = {
  primary:  '#f5c542',
  accent:   '#8b5cf6',
  green:    '#22c55e',
  red:      '#ef4444',
  blue:     '#3b82f6',
  muted:    '#9ca3af',
  border:   '#3d3555',
};

/* ── Candidate Competency Radar Chart ── */
function initRadarChart(labels, candidateScores, requiredScores) {
  var ctx = document.getElementById('radarChart');
  if (!ctx) return;

  new Chart(ctx, {
    type: 'radar',
    data: {
      labels: labels,
      datasets: [
        {
          label: 'Required',
          data: requiredScores,
          borderColor: CP.accent,
          backgroundColor: 'rgba(139,92,246,.2)',
          pointBackgroundColor: CP.accent,
          pointRadius: 3,
        },
        {
          label: 'Candidate',
          data: candidateScores,
          borderColor: CP.primary,
          backgroundColor: 'rgba(245,197,66,.35)',
          pointBackgroundColor: CP.primary,
          pointRadius: 3,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        r: {
          beginAtZero: true,
          max: 100,
          ticks: { display: false },
          grid:        { color: CP.border },
          angleLines:  { color: CP.border },
          pointLabels: { color: CP.muted, font: { size: 12 } },
        },
      },
      plugins: { legend: { display: false } },
    },
  });
}

/* Called after DOM is ready; guards itself if RADAR_DATA is not defined */
document.addEventListener('DOMContentLoaded', function () {
  if (typeof RADAR_DATA !== 'undefined') {
    initRadarChart(RADAR_DATA.labels, RADAR_DATA.candidate, RADAR_DATA.required);
  }
});
