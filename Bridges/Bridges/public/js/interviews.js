/* interviews.js — Bridges Recruitment System */

/* ── Tab Filtering ── */
var currentFilter = 'all';

function setFilter(tab) {
  currentFilter = tab;

  document.querySelectorAll('.filter-tab').forEach(function (t) {
    t.classList.remove('active');
  });
  document.querySelector('[data-tab="' + tab + '"]').classList.add('active');

  document.querySelectorAll('.interview-card').forEach(function (card) {
    var status = card.getAttribute('data-status');
    if (tab === 'all' || status === tab) {
      card.style.display = '';
    } else {
      card.style.display = 'none';
    }
  });

  var visible = document.querySelectorAll('.interview-card:not([style*="display: none"])').length;
  var emptyState = document.getElementById('emptyState');
  if (emptyState) {
    emptyState.style.display = visible === 0 ? '' : 'none';
  }
}

/* ── Modal ── */
var modalData = {
  'alex-chen': {
    name: 'Alex Chen',
    date: 'May 10, 2026', time: '10:00 AM',
    hr: 'Sarah Johnson', panel: 'Senior Dev Team',
    type: 'Technical', status: 'Upcoming',
    duration: '60 minutes',
    summary: 'Full-stack React/Node.js role assessment. Candidate scored 91% on the technical exam.',
    notes: 'Focus on system design and React performance optimizations.'
  },
  'sara-liu': {
    name: 'Sara Liu',
    date: 'May 10, 2026', time: '2:00 PM',
    hr: 'Mark Davis', panel: 'Product Team',
    type: 'Behavioral', status: 'Upcoming',
    duration: '45 minutes',
    summary: 'Product Manager candidate — final round behavioral interview.',
    notes: 'Use STAR method questions. Assess leadership and cross-functional communication.'
  },
  'mike-ross': {
    name: 'Mike Ross',
    date: 'May 12, 2026', time: '9:30 AM',
    hr: 'Emily Clark', panel: 'Backend Team',
    type: 'Technical', status: 'Upcoming',
    duration: '75 minutes',
    summary: 'Senior Python/Django backend engineer. Strong algorithms background.',
    notes: 'Prepare a system design question around distributed caching.'
  },
  'olivia-brooks': {
    name: 'Olivia Brooks',
    date: 'May 5, 2026', time: '11:00 AM',
    hr: 'Sarah Johnson', panel: 'Frontend Team',
    type: 'Technical', status: 'Completed',
    duration: '60 minutes',
    summary: 'React specialist for e-commerce platform. Feedback has been submitted.',
    notes: 'Candidate performed well overall. Recommendation: Hire.'
  }
};

function openModal(key) {
  var d = modalData[key];
  if (!d) return;

  var statusCls = d.status === 'Upcoming' ? 'badge-upcoming' : 'badge-completed';
  var typeCls   = d.type === 'Technical'  ? 'badge-technical' : 'badge-behavioral';

  document.getElementById('modalContent').innerHTML = [
    '<div class="modal-header-custom">',
    '  <div>',
    '    <h5 class="modal-title-text">' + d.name + '</h5>',
    '    <p class="text-muted small mb-0">Full interview details</p>',
    '  </div>',
    '  <button class="modal-close" onclick="closeModal()">✕</button>',
    '</div>',
    '<div class="modal-body-custom">',
    '  <div class="modal-info-grid mb-4">',
    '    <div class="modal-info-item"><span class="modal-info-label">Date</span><span class="modal-info-value">' + d.date + '</span></div>',
    '    <div class="modal-info-item"><span class="modal-info-label">Time</span><span class="modal-info-value">' + d.time + '</span></div>',
    '    <div class="modal-info-item"><span class="modal-info-label">Duration</span><span class="modal-info-value">' + d.duration + '</span></div>',
    '    <div class="modal-info-item"><span class="modal-info-label">HR Contact</span><span class="modal-info-value">' + d.hr + '</span></div>',
    '    <div class="modal-info-item"><span class="modal-info-label">Panel</span><span class="modal-info-value">' + d.panel + '</span></div>',
    '    <div class="modal-info-item"><span class="modal-info-label">Status</span><span class="status-badge ' + statusCls + '">' + d.status + '</span></div>',
    '    <div class="modal-info-item"><span class="modal-info-label">Type</span><span class="status-badge ' + typeCls + '">' + d.type + '</span></div>',
    '  </div>',
    '  <div class="mb-4">',
    '    <div class="modal-info-label mb-2">Summary</div>',
    '    <p class="text-light-muted mb-0">' + d.summary + '</p>',
    '  </div>',
    '  <div>',
    '    <div class="modal-info-label mb-2">Interviewer Notes</div>',
    '    <p class="text-light-muted mb-0">' + d.notes + '</p>',
    '  </div>',
    '</div>',
    '<div class="modal-footer-custom">',
    '  <a href="brief.html" class="btn-outline-custom">View Brief</a>',
    '  <a href="interview-session.html" class="btn-primary-custom">Open Session</a>',
    '</div>'
  ].join('');

  document.getElementById('interviewModal').style.display = 'flex';
  document.body.style.overflow = 'hidden';
}

function closeModal() {
  document.getElementById('interviewModal').style.display = 'none';
  document.body.style.overflow = '';
}

document.getElementById('interviewModal').addEventListener('click', function (e) {
  if (e.target === this) closeModal();
});

document.addEventListener('keydown', function (e) {
  if (e.key === 'Escape') closeModal();
});
