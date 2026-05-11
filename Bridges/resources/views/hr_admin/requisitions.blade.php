@extends('layouts.app')

{{--
 * ============================================================================
 * HR Admin - Job Requisitions View
 * ============================================================================
 * This page allows HR administrators to review and act upon internal hiring 
 * requests submitted by various department heads.
 * 
 * Features:
 * - Dynamic list of pending requisitions.
 * - Detailed modal view for job descriptions and justifications.
 * - Rejection workflow with feedback capture.
 --}}

@section('sidebar')
    @include('layouts.partials.hr_admin_sidebar')
@endsection

@section('title', 'Job Requisitions')
@section('topbar-title', 'Job Requisitions')

<!-- Specific dashboard styling -->
<link rel="stylesheet" href="{{ asset('css/hr_admin.css') }}" />

@section('content')
  <!-- HEADER: Page context and description -->
  <h1 class="page-section-title">Job Requisitions</h1>
  <p class="page-section-sub">Review and approve job requisitions from department heads</p>

  <!-- PENDING LIST CARD: Groups all current headcount requests -->
  <div class="cp-card">
    <div class="cp-card-header">
      <div class="d-flex align-items-center gap-2">
        <h2 class="cp-card-title">Pending Approval</h2>
        <!-- STATUS COUNTER: Real-time visual count of pending items -->
        <span class="badge-stage bs-pending">3</span>
      </div>
    </div>
    <div class="cp-card-body">
      <div class="d-flex flex-column gap-2">

        <!-- REQUISITION 1: Example of a Senior Backend Developer request -->
        <div class="list-row req-row" id="row-1">
          <div class="flex-grow-1">
            <div class="d-flex align-items-center gap-3 flex-wrap">
              <span style="font-weight:500;">Senior Backend Developer</span>
              <span class="badge-stage bs-applied" style="font-size:.7rem;padding:2px 9px;border-radius:4px;">REQ-001</span>
            </div>
            <!-- METADATA: Quick glance info about department and headcount -->
            <div class="d-flex align-items-center gap-3 mt-1 flex-wrap" style="font-size:.78rem;color:var(--muted);">
              <span><i class="bi bi-building me-1"></i>Engineering</span>
              <span><i class="bi bi-people me-1"></i>2 positions</span>
              <span><i class="bi bi-calendar me-1"></i>2024-01-15</span>
            </div>
          </div>
          <!-- ACTIONS: Controls for interacting with the requisition -->
          <div class="d-flex align-items-center gap-2 flex-wrap">
            <button class="btn-outline-cp btn-sm-cp"
                    onclick="openRequisitionDetailsModal('REQ-001', 'Senior Backend Developer', 'Engineering', '2 positions', '$120k – $150k', '2024-01-15', 'Full-time — Remote', 'We need experienced backend developers to scale our platform infrastructure and lead microservices architecture initiatives.', ['5+ years Node.js or Python experience', 'Strong SQL and NoSQL database knowledge', 'Experience with AWS or GCP', 'Microservices and REST API design'], 'Current team is at capacity. Q1 roadmap requires two additional senior engineers to meet delivery targets.', 'James Carter')">
              <i class="bi bi-eye"></i> View
            </button>
            <button class="btn-green-cp btn-sm-cp">
              <i class="bi bi-check"></i> Approve
            </button>
            <button class="btn-red-cp btn-sm-cp" onclick="openRejectRequisitionModal()">
              <i class="bi bi-x"></i> Reject
            </button>
          </div>
        </div>

        <!-- REQUISITION 2: Product Manager request -->
        <div class="list-row req-row" id="row-2">
          <div class="flex-grow-1">
            <div class="d-flex align-items-center gap-3 flex-wrap">
              <span style="font-weight:500;">Product Manager</span>
              <span class="badge-stage bs-applied" style="font-size:.7rem;padding:2px 9px;border-radius:4px;">REQ-002</span>
            </div>
            <div class="d-flex align-items-center gap-3 mt-1 flex-wrap" style="font-size:.78rem;color:var(--muted);">
              <span><i class="bi bi-building me-1"></i>Product</span>
              <span><i class="bi bi-people me-1"></i>1 position</span>
              <span><i class="bi bi-calendar me-1"></i>2024-01-16</span>
            </div>
          </div>
          <div class="d-flex align-items-center gap-2 flex-wrap">
            <button class="btn-outline-cp btn-sm-cp"
                    onclick="openRequisitionDetailsModal('REQ-002', 'Product Manager', 'Product', '1 position', '$110k – $135k', '2024-01-16', 'Full-time — Hybrid (New York)', 'Seeking a PM to own our consumer-facing product line, working closely with engineering and design teams.', ['4+ years product management experience', 'Strong analytical and communication skills', 'Experience with Agile / Scrum'], 'Expanding product team to support new vertical. Current PM bandwidth is insufficient for upcoming launch.', 'Linda Park')">
              <i class="bi bi-eye"></i> View
            </button>
            <button class="btn-green-cp btn-sm-cp">
              <i class="bi bi-check"></i> Approve
            </button>
            <button class="btn-red-cp btn-sm-cp" onclick="openRejectRequisitionModal()">
              <i class="bi bi-x"></i> Reject
            </button>
          </div>
        </div>

        <!-- REQUISITION 3: UX Designer request -->
        <div class="list-row req-row" id="row-3">
          <div class="flex-grow-1">
            <div class="d-flex align-items-center gap-3 flex-wrap">
              <span style="font-weight:500;">UX Designer</span>
              <span class="badge-stage bs-applied" style="font-size:.7rem;padding:2px 9px;border-radius:4px;">REQ-003</span>
            </div>
            <div class="d-flex align-items-center gap-3 mt-1 flex-wrap" style="font-size:.78rem;color:var(--muted);">
              <span><i class="bi bi-building me-1"></i>Design</span>
              <span><i class="bi bi-people me-1"></i>1 position</span>
              <span><i class="bi bi-calendar me-1"></i>2024-01-17</span>
            </div>
          </div>
          <div class="d-flex align-items-center gap-2 flex-wrap">
            <button class="btn-outline-cp btn-sm-cp"
                    onclick="openRequisitionDetailsModal('REQ-003', 'UX Designer', 'Design', '1 position', '$90k – $115k', '2024-01-17', 'Full-time — Remote', 'Looking for a UX Designer to improve our platform\'s user experience across web and mobile products.', ['3+ years UX/UI design experience', 'Proficiency in Figma', 'Strong portfolio of shipped products'], 'Design team lacks UX capacity to support three simultaneous product workstreams planned for Q2.', 'Maria Santos')">
              <i class="bi bi-eye"></i> View
            </button>
            <button class="btn-green-cp btn-sm-cp">
              <i class="bi bi-check"></i> Approve
            </button>
            <button class="btn-red-cp btn-sm-cp" onclick="openRejectRequisitionModal()">
              <i class="bi bi-x"></i> Reject
            </button>
          </div>
        </div>

      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
/**
 * ============================================================
 * JAVASCRIPT MODAL HANDLERS
 * ============================================================
 * These functions build and inject HTML into the shared modal panel.
 */

/**
 * OPENS THE REQUISITION DETAILS MODAL
 * Dynamically constructs a comprehensive view of the hiring request.
 */
function openRequisitionDetailsModal(id, title, dept, headcount, salary, submitted, typeLoc, desc, reqs, just, user) {
  let reqsHtml = '';
  // Map requirement strings into list items
  reqs.forEach(r => {
    reqsHtml += `<li>${r}</li>`;
  });

  const html = `
    <div class="p-4">
      <!-- Header Area -->
      <div class="d-flex align-items-center justify-content-between gap-3 mb-4">
        <h5 class="fw-bold mb-0">${title} <span class="text-muted-cp" style="font-size:.85rem;font-weight:400;">#${id}</span></h5>
        <button onclick="closeModal()" class="btn-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M18 6L6 18M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <!-- Core Stats Grid -->
      <div class="row g-4 mb-4">
        <div class="col-6 col-md-3">
          <div style="font-size:.75rem;color:var(--muted);margin-bottom:4px;">Department</div>
          <div class="fw-semibold">${dept}</div>
        </div>
        <div class="col-6 col-md-3">
          <div style="font-size:.75rem;color:var(--muted);margin-bottom:4px;">Headcount</div>
          <div class="fw-semibold">${headcount}</div>
        </div>
        <div class="col-6 col-md-3">
          <div style="font-size:.75rem;color:var(--muted);margin-bottom:4px;">Salary Range</div>
          <div class="fw-semibold">${salary}</div>
        </div>
        <div class="col-6 col-md-3">
          <div style="font-size:.75rem;color:var(--muted);margin-bottom:4px;">Submitted</div>
          <div class="fw-semibold">${submitted}</div>
        </div>
      </div>

      <!-- Detailed Justification Card -->
      <div class="mb-4">
        <div class="fw-bold mb-2" style="font-size:.9rem;">Job Details & Justification</div>
        <div class="cp-card-p-0 border rounded p-3" style="background: rgba(255,255,255,0.02)">
          <div class="mb-3">
            <div style="font-size:.78rem;color:var(--muted);margin-bottom:4px;">Location & Type</div>
            <div style="font-size:.9rem;">${typeLoc}</div>
          </div>
          <div class="mb-3">
            <div style="font-size:.78rem;color:var(--muted);margin-bottom:4px;">Description</div>
            <div style="font-size:.9rem;line-height:1.5;">${desc}</div>
          </div>
          <div class="mb-3">
            <div style="font-size:.78rem;color:var(--muted);margin-bottom:4px;">Requirements</div>
            <ul class="mb-0" style="font-size:.9rem;padding-left:1.2rem;line-height:1.6;">${reqsHtml}</ul>
          </div>
          <div>
            <div style="font-size:.78rem;color:var(--muted);margin-bottom:4px;">Justification</div>
            <div style="font-size:.9rem;line-height:1.5;">${just}</div>
          </div>
        </div>
      </div>

      <!-- Modal Footer Actions -->
      <div class="d-flex align-items-center justify-content-between mt-5 pt-3 border-top">
        <div style="font-size:.85rem;color:var(--muted);">Requested by: <span class="text-white fw-medium">${user}</span></div>
        <div class="d-flex gap-2">
          <button class="btn-outline-cp" onclick="closeModal()">Close</button>
          <button class="btn-red-cp" onclick="openRejectRequisitionModal()"><i class="bi bi-x"></i> Reject</button>
          <button class="btn-green-cp" onclick="closeModal()"><i class="bi bi-check-lg"></i> Approve & Publish</button>
        </div>
      </div>
    </div>
  `;
  // Uses global openModal function from hr_admin.js
  openModal(html);
}

/**
 * OPENS THE REJECTION FEEDBACK MODAL
 * Prompts the HR admin for a reason before finalize rejection.
 */
function openRejectRequisitionModal() {
  const html = `
    <div class="p-4">
      <div class="d-flex align-items-center justify-content-between gap-3 mb-4">
        <h5 class="fw-bold mb-0">Reject Requisition</h5>
        <button onclick="closeModal()" class="btn-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M18 6L6 18M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <p class="text-muted-cp mb-4" style="font-size:.9rem;">
        Please provide a reason for rejecting this requisition. This feedback will be shared with the department head.
      </p>

      <!-- Input for rejection feedback -->
      <div class="mb-4">
        <label class="cp-label mb-2">Rejection Reason</label>
        <textarea class="cp-input" id="rejectionReason" rows="5"
                  placeholder="Enter detailed reason for rejection..." 
                  style="resize:vertical;"
                  oninput="document.getElementById('confirmRejectBtn').disabled = !this.value.trim()"></textarea>
      </div>

      <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
        <button class="btn-outline-cp" onclick="closeModal()">Cancel</button>
        <button class="btn-red-cp" id="confirmRejectBtn" disabled onclick="closeModal()">
          <i class="bi bi-x-circle"></i> Confirm Rejection
        </button>
      </div>
    </div>
  `;
  openModal(html);
}

</script>
@endpush

