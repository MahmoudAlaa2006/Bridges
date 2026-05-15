@extends('layouts.app')

{{--
 * ============================================================================
 * HR Admin - Offers Management View
 * ============================================================================
 * This view provides a centralized interface for managing the final stage of 
 * the hiring funnel: issuing and tracking job offer letters.
 * 
 * Features:
 * - Tabbed filtering (All, Pending, Accepted, Declined).
 * - Actionable table rows for sending, editing, or revoking offers.
 * - Integration with the centralized modal system for offer creation.
 --}}

@section('sidebar')
    @include('layouts.partials.hr_admin_sidebar')
@endsection

@section('title', 'Offers Management')
@section('topbar-title', 'Offers Management')

<!-- Specific dashboard styling -->
<link rel="stylesheet" href="{{ asset('css/hr_admin.css') }}" />

@section('content')
  <!-- HEADER: Page context and description -->
  <h1 class="page-section-title">Offers Management</h1>
  <p class="page-section-sub">Review, edit, and send offer letters to candidates</p>

  <!-- PENDING OFFERS CARD: Lists candidates awaiting an official offer -->
  <div class="cp-card">
    <div class="cp-card-header">
      <div class="d-flex align-items-center gap-2">
        <h2 class="cp-card-title">Pending Offers</h2>
        <span class="badge-stage bs-pending">2</span>
      </div>
    </div>
    <div class="cp-card-body">
      <div class="d-flex flex-column gap-2">

        <!-- OFFER ROW 1: Example for Sarah Johnson -->
        <div class="list-row">
          <div class="d-flex align-items-center gap-3 flex-wrap">
            <!-- User Avatar Initials -->
            <div class="av-init" style="width:40px;height:40px;font-size:.8rem;flex-shrink:0;">SJ</div>
            <div>
              <div style="font-weight:500;">Sarah Johnson</div>
              <!-- Job metadata -->
              <div class="d-flex align-items-center gap-3 mt-1 flex-wrap" style="font-size:.78rem;color:var(--muted);">
                <span><i class="bi bi-briefcase me-1"></i>Senior Backend Developer</span>
                <span><i class="bi bi-building me-1"></i>Engineering</span>
                <span><i class="bi bi-currency-dollar"></i>$135,000</span>
              </div>
            </div>
          </div>
          <!-- Action Buttons for this specific offer -->
          <div class="d-flex align-items-center gap-2 flex-wrap">
            <span class="badge-stage bs-pending">Pending</span>
            <button class="btn-outline-cp btn-sm-cp"
                    onclick="openEditOfferModal('Sarah Johnson', 'Senior Backend Developer', '$135,000', '2024-03-01', 'Health insurance, 401k matching, Stock options, 20 days PTO', 'Remote work available. Signing bonus of $10,000 included.')">
              <i class="bi bi-pencil"></i> Edit
            </button>
            <button class="btn-outline-cp btn-sm-cp"
                    onclick="openViewOfferModal('Sarah Johnson', 'Senior Backend Developer', 'Engineering', '$135,000', 'March 1, 2024', 'Health insurance, 401k matching, Stock options, 20 days PTO', 'Remote work available. Signing bonus of $10,000 included.')">
              <i class="bi bi-eye"></i> View
            </button>
            <button class="btn-primary-cp btn-sm-cp" onclick="markSent(this)">
              <i class="bi bi-send"></i> Send
            </button>
          </div>
        </div>

        <!-- OFFER ROW 2: Example for Robert Martinez -->
        <div class="list-row">
          <div class="d-flex align-items-center gap-3 flex-wrap">
            <div class="av-init" style="width:40px;height:40px;font-size:.8rem;flex-shrink:0;">RM</div>
            <div>
              <div style="font-weight:500;">Robert Martinez</div>
              <div class="d-flex align-items-center gap-3 mt-1 flex-wrap" style="font-size:.78rem;color:var(--muted);">
                <span><i class="bi bi-briefcase me-1"></i>Product Manager</span>
                <span><i class="bi bi-building me-1"></i>Product</span>
                <span><i class="bi bi-currency-dollar"></i>$120,000</span>
              </div>
            </div>
          </div>
          <div class="d-flex align-items-center gap-2 flex-wrap">
            <span class="badge-stage bs-draft">Draft</span>
            <button class="btn-outline-cp btn-sm-cp"
                    onclick="openEditOfferModal('Robert Martinez', 'Product Manager', '$120,000', '2024-03-15', 'Health insurance, 401k matching, 15 days PTO', 'Hybrid work arrangement (3 days office, 2 days remote).')">
              <i class="bi bi-pencil"></i> Edit
            </button>
            <button class="btn-outline-cp btn-sm-cp"
                    onclick="openViewOfferModal('Robert Martinez', 'Product Manager', 'Product', '$120,000', 'March 15, 2024', 'Health insurance, 401k matching, 15 days PTO', 'Hybrid work arrangement (3 days office, 2 days remote).')">
              <i class="bi bi-eye"></i> View
            </button>
            <button class="btn-primary-cp btn-sm-cp" onclick="markSent(this)">
              <i class="bi bi-send"></i> Send
            </button>
          </div>
        </div>

      </div>
    </div>
  </div>
@endsection

@push('scripts')
<!-- Load HR Admin specific logic -->
<script src="{{ asset('js/hr_admin.js') }}"></script>
<script>
/**
 * ============================================================
 * JAVASCRIPT MODAL HANDLERS
 * ============================================================
 * These functions build and inject HTML into the shared modal panel.
 */

/**
 * OPENS THE EDIT OFFER MODAL
 * Provides a form-like interface to modify the parameters of a draft offer.
 */
function openEditOfferModal(candidate, position, salary, startDate, benefits, notes) {
  const html = `
    <div class="p-4">
      <div class="d-flex align-items-center justify-content-between gap-3 mb-4">
        <h5 class="fw-bold mb-0">Edit Offer Letter</h5>
        <button onclick="closeModal()" class="btn-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M18 6L6 18M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <div class="mb-3">
        <label class="cp-label mb-2">Candidate</label>
        <div class="fw-semibold text-white">${candidate}</div>
      </div>

      <div class="mb-3">
        <label class="cp-label mb-2">Position</label>
        <input type="text" class="cp-input" value="${position}" />
      </div>

      <div class="row g-3 mb-3">
        <div class="col-6">
          <label class="cp-label mb-2">Salary</label>
          <input type="text" class="cp-input" value="${salary}" />
        </div>
        <div class="col-6">
          <label class="cp-label mb-2">Start Date</label>
          <input type="date" class="cp-input" value="${startDate}" />
        </div>
      </div>

      <div class="mb-3">
        <label class="cp-label mb-2">Benefits</label>
        <textarea class="cp-input" rows="3" style="resize:vertical;">${benefits}</textarea>
      </div>

      <div class="mb-4">
        <label class="cp-label mb-2">Additional Notes</label>
        <textarea class="cp-input" rows="2" style="resize:vertical;">${notes}</textarea>
      </div>

      <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
        <button class="btn-outline-cp" onclick="closeModal()">Cancel</button>
        <button class="btn-primary-cp" onclick="closeModal()"><i class="bi bi-check-lg"></i> Save Changes</button>
      </div>
    </div>
  `;
  openModal(html);
}

/**
 * OPENS THE VIEW OFFER MODAL
 * Generates a branded, formatted preview of the employment agreement.
 */
function openViewOfferModal(candidate, position, department, salary, startDate, benefits, notes) {
  const html = `
    <div class="p-4">
      <div class="d-flex align-items-center justify-content-between gap-3 mb-4">
        <h5 class="fw-bold mb-0">Offer Letter Preview</h5>
        <button onclick="closeModal()" class="btn-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M18 6L6 18M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <div class="border rounded p-4 mb-4" style="background: rgba(255,255,255,0.02); position: relative; overflow: hidden;">
        <!-- Watermark/Stamp effect for a premium feel -->
        <div style="position: absolute; top: 20px; right: 20px; opacity: 0.1; transform: rotate(15deg); font-weight: 900; font-size: 2rem;">OFFER</div>
        
        <!-- Document Header -->
        <div class="text-center mb-4 pb-3 border-bottom border-secondary">
          <div class="fw-bold text-uppercase tracking-wider mb-1" style="font-size: 1.1rem; color: var(--accent);">Employment Agreement</div>
          <div class="text-muted-cp" style="font-size: .8rem;">CareerPortal Inc. — Global Talent Acquisition</div>
        </div>

        <div class="mb-4">
          <p class="mb-2">Dear <span class="fw-bold text-white">${candidate}</span>,</p>
          <p class="text-muted-cp" style="font-size: .9rem; line-height: 1.6;">
            We are excited to formally extend an offer for you to join the CareerPortal team as 
            <span class="text-white fw-medium">${position}</span> within our <span class="text-white fw-medium">${department}</span> department.
          </p>
        </div>

        <!-- Key Offer Terms Grid -->
        <div class="row g-4 mb-4">
          <div class="col-6">
            <div style="font-size:.7rem; text-transform: uppercase; color:var(--muted); margin-bottom: 4px;">Annual Base Salary</div>
            <div class="fw-bold text-white" style="font-size: 1.1rem;">${salary}</div>
          </div>
          <div class="col-6">
            <div style="font-size:.7rem; text-transform: uppercase; color:var(--muted); margin-bottom: 4px;">Target Start Date</div>
            <div class="fw-bold text-white" style="font-size: 1.1rem;">${startDate}</div>
          </div>
        </div>

        <div class="mb-4">
          <div style="font-size:.75rem; color:var(--muted); margin-bottom: 6px;">Total Rewards & Benefits</div>
          <div class="text-white" style="font-size: .88rem; line-height: 1.5;">${benefits}</div>
        </div>

        <div>
          <div style="font-size:.75rem; color:var(--muted); margin-bottom: 6px;">Special Provisions</div>
          <div class="text-white italic" style="font-size: .88rem; line-height: 1.5; font-style: italic;">"${notes}"</div>
        </div>
      </div>

      <div class="d-flex justify-content-end gap-2">
        <button class="btn-outline-cp" onclick="closeModal()">Close</button>
        <button class="btn-primary-cp" onclick="closeModal()"><i class="bi bi-send-fill"></i> Send Offer to Candidate</button>
      </div>
    </div>
  `;
  openModal(html);
}


/**
 * MARK OFFER AS SENT (UI-ONLY)
 * Updates the row state immediately for better user experience.
 */
function markSent(btn) {
  var row   = btn.closest('.list-row');
  var badge = row.querySelector('.badge-stage');
  if (badge) { badge.className = 'badge-stage bs-sent'; badge.textContent = 'Sent'; }
  btn.disabled = true;
  btn.innerHTML = '<i class="bi bi-check"></i> Sent';
}
</script>
@endpush

