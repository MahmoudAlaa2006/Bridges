let reqModal;

document.addEventListener('DOMContentLoaded', () => {
  reqModal = new bootstrap.Modal(document.getElementById('reqModal'));
});

function openReqModal(role, status) {
  document.getElementById('reqModalRole').innerText = role;
  const badgeContainer = document.getElementById('reqModalStatusBadge');
  
  if (status === 'Approved') {
    badgeContainer.innerHTML = '<span class="custom-badge badge-approved">Approved</span>';
  } else if (status === 'Pending') {
    badgeContainer.innerHTML = '<span class="custom-badge badge-pending">Pending</span>';
  } else if (status === 'Rejected') {
    badgeContainer.innerHTML = '<span class="custom-badge badge-rejected">Rejected</span>';
  }
  
  reqModal.show();
}