@extends('layouts.app')

@section('sidebar')
    @include('layouts.partials.candidate_sidebar')
@endsection
@section('title', 'Offers — CareerPortal')
@section('header-title', 'Job Offers')

@section('header-actions-prefix')
<button class="btn-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg></button>
@endsection

@section('content')
    <div class="mb-4">
      <h2 class="section-title">Job Offers</h2>
      <p class="section-sub">Review and respond to your job offer.</p>
    </div>

    <!-- Congratulations banner -->
    <div class="cp-card p-3 mb-4 bg-primary-soft">
      <div class="d-flex align-items-center gap-3">
        <div class="stat-icon-wrap" style="background:rgba(245,197,66,0.2);color:var(--primary);width:40px;height:40px">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/></svg>
        </div>
        <div>
          <p style="font-size:14px;font-weight:600;margin:0">Congratulations! You received a job offer.</p>
          <p class="text-muted-cp" style="font-size:13px;margin:0">Review the details below and respond before the deadline.</p>
        </div>
      </div>
    </div>

    <!-- Offer stat cards -->
    <!-- <div class="row g-3 mb-4">
      <div class="col-md-4">
        <div class="stat-card cp-card">
          <div class="stat-icon-wrap" style="background:rgba(245,197,66,0.12);color:var(--primary)">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path stroke-linecap="round" stroke-linejoin="round" d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
          </div>
          <div><p style="font-size:22px;font-weight:700;margin:0;color:var(--primary)">$145,000</p><p class="text-muted-cp" style="font-size:13px;margin:0">Base Salary / Year</p></div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stat-card cp-card">
          <div class="stat-icon-wrap" style="background:rgba(34,197,94,0.12);color:#4ade80">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/></svg>
          </div>
          <div><p style="font-size:22px;font-weight:700;margin:0">$15,000</p><p class="text-muted-cp" style="font-size:13px;margin:0">Signing Bonus</p></div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stat-card cp-card">
          <div class="stat-icon-wrap" style="background:rgba(139,92,246,0.12);color:var(--accent)">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          </div>
          <div><p style="font-size:22px;font-weight:700;margin:0">June 1</p><p class="text-muted-cp" style="font-size:13px;margin:0">Start Date, 2026</p></div>
        </div>
      </div>
    </div> -->

    <!-- Offer Detail Card -->
    <div class="cp-card p-4 mb-4">
      <div class="row align-items-start g-4 mb-4">
        <div class="col-md-8">
          <div class="d-flex align-items-start gap-3">
            <div class="stat-icon-wrap" style="background:rgba(245,197,66,0.12);color:var(--primary);width:52px;height:52px;flex-shrink:0">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2M5 21H3"/></svg>
            </div>
            <div>
              <h3 style="font-size:17px;font-weight:700;margin:0 0 4px">Senior Frontend Developer</h3>
              <p class="text-muted-cp" style="font-size:13px;margin:0 0 10px">TechCorp Inc.</p>
              <div class="d-flex flex-wrap gap-2">
                <span class="cp-badge badge-green">Pending Decision</span>
                <span class="cp-badge badge-gray">Full-time</span>
                <span class="cp-badge badge-remote">Remote</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 text-md-end">
          <p style="font-size:24px;font-weight:700;color:var(--primary);margin:0">$145,000<span style="font-size:14px;color:var(--muted-fg)">/yr</span></p>
          <p style="font-size:13px;color:#4ade80;margin:2px 0">+ $15,000 signing bonus</p>
          <p style="font-size:13px;color:var(--accent);margin:0">+ 0.1% equity</p>
        </div>
      </div>

      <!-- Metadata row -->
      <div class="d-flex flex-wrap gap-4 mb-4 pb-4" style="border-bottom:1px solid var(--border)">
        <div class="info-row">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
          San Francisco, CA (Remote)
        </div>
        <div class="info-row">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          Start Date: June 1, 2026
        </div>
        <div class="info-row" style="color:var(--destructive)">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          Respond by May 20, 2026
        </div>
      </div>

      <!-- Benefits -->
      <div class="mb-4">
        <h4 style="font-size:14px;font-weight:600;margin-bottom:12px">Benefits Package</h4>
        <div class="row g-2">
          <div class="col-md-6">
            <div class="d-flex align-items-center gap-2" style="font-size:13px;color:#d1d5db">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:#4ade80;flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
              Health, dental, and vision insurance
            </div>
          </div>
          <div class="col-md-6">
            <div class="d-flex align-items-center gap-2" style="font-size:13px;color:#d1d5db">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:#4ade80;flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
              401(k) with 4% company match
            </div>
          </div>
          <div class="col-md-6">
            <div class="d-flex align-items-center gap-2" style="font-size:13px;color:#d1d5db">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:#4ade80;flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
              Unlimited PTO &amp; flexible hours
            </div>
          </div>
          <div class="col-md-6">
            <div class="d-flex align-items-center gap-2" style="font-size:13px;color:#d1d5db">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:#4ade80;flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
              Remote work flexibility
            </div>
          </div>
          <div class="col-md-6">
            <div class="d-flex align-items-center gap-2" style="font-size:13px;color:#d1d5db">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:#4ade80;flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
              $3,000 learning &amp; development budget
            </div>
          </div>
          <div class="col-md-6">
            <div class="d-flex align-items-center gap-2" style="font-size:13px;color:#d1d5db">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:#4ade80;flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
              $1,000 home office stipend
            </div>
          </div>
        </div>
      </div>

      <!-- Accept / Decline -->
      <div class="d-flex flex-wrap gap-2">
        <button onclick="openAcceptModal()" class="btn-cp btn-green-cp">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          Accept Offer
        </button>
        <button onclick="openDeclineModal()" class="btn-cp btn-outline-cp">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
          Decline
        </button>
        <button onclick="openOfferDetailModal()" class="btn-cp btn-secondary-cp">View Full Details</button>
      </div>
    </div>

@endsection

@push('scripts')
<script>
// Opens the accept offer confirmation modal — UI only
function openAcceptModal() {
  openModal(
    '<div class="p-4 text-center">' +
      '<div style="width:64px;height:64px;border-radius:50%;background:rgba(34,197,94,0.12);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;color:#4ade80">' +
        '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>' +
      '</div>' +
      '<h5 class="fw-bold mb-2">Accept This Offer?</h5>' +
      '<p class="text-muted-cp mb-3" style="font-size:13px">You are about to accept the offer for <strong style="color:#fff">Senior Frontend Developer</strong> at <strong style="color:#fff">TechCorp Inc.</strong></p>' +
      '<div class="p-3 rounded-3 mb-4 bg-green-soft text-start">' +
        '<p style="font-size:13px;color:#4ade80;margin:0">By accepting, you confirm your start date of <strong>June 1, 2026</strong>. The HR team will contact you with onboarding details.</p>' +
      '</div>' +
      '<div class="d-flex gap-2">' +
        '<button onclick="closeModal()" class="btn-cp btn-outline-cp flex-fill justify-content-center">Cancel</button>' +
        '<button onclick="closeModal()" class="btn-cp btn-green-cp flex-fill justify-content-center">Confirm Acceptance</button>' +
      '</div>' +
    '</div>'
  );
}

// Opens the decline offer modal — UI only
function openDeclineModal() {
  openModal(
    '<div class="p-4">' +
      '<div class="d-flex align-items-center justify-content-between mb-3">' +
        '<h5 class="fw-bold mb-0">Decline This Offer</h5>' +
        '<button onclick="closeModal()" class="btn-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>' +
      '</div>' +
      '<div class="mb-3"><label class="cp-label">Reason for declining <span class="text-muted-cp">(optional)</span></label><select class="cp-input"><option value="">Select a reason…</option><option>Accepted another offer</option><option>Compensation does not meet expectations</option><option>Location or remote policy does not fit</option><option>Role does not align with career goals</option><option>Other</option></select></div>' +
      '<div class="mb-3"><label class="cp-label">Additional comments <span class="text-muted-cp">(optional)</span></label><textarea class="cp-input" placeholder="Any additional feedback for the team…"></textarea></div>' +
      '<div class="d-flex gap-2">' +
        '<button onclick="closeModal()" class="btn-cp btn-outline-cp flex-fill justify-content-center">Cancel</button>' +
        '<button onclick="closeModal()" class="btn-cp btn-danger-cp flex-fill justify-content-center">Decline Offer</button>' +
      '</div>' +
    '</div>'
  );
}

// Opens the full offer details modal — UI only
function openOfferDetailModal() {
  openModal(
    '<div class="p-4">' +
      '<div class="d-flex align-items-start justify-content-between gap-3 mb-3">' +
        '<div><h5 class="fw-bold mb-1">Full Offer Details</h5><p class="text-muted-cp mb-0" style="font-size:13px">TechCorp Inc. — Senior Frontend Developer</p></div>' +
        '<button onclick="closeModal()" class="btn-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>' +
      '</div>' +
      '<div class="row g-2 mb-3">' +
        '<div class="col-6"><div class="p-2 rounded-3" style="background:var(--secondary)"><p class="text-muted-cp mb-0" style="font-size:11px">Base Salary</p><p class="fw-bold mb-0 text-primary-cp">$145,000/yr</p></div></div>' +
        '<div class="col-6"><div class="p-2 rounded-3" style="background:var(--secondary)"><p class="text-muted-cp mb-0" style="font-size:11px">Signing Bonus</p><p class="fw-bold mb-0">$15,000</p></div></div>' +
        '<div class="col-6"><div class="p-2 rounded-3" style="background:var(--secondary)"><p class="text-muted-cp mb-0" style="font-size:11px">Equity</p><p class="fw-bold mb-0">0.1% over 4 years</p></div></div>' +
        '<div class="col-6"><div class="p-2 rounded-3" style="background:var(--secondary)"><p class="text-muted-cp mb-0" style="font-size:11px">Start Date</p><p class="fw-bold mb-0">June 1, 2026</p></div></div>' +
        '<div class="col-6"><div class="p-2 rounded-3" style="background:var(--secondary)"><p class="text-muted-cp mb-0" style="font-size:11px">Work Type</p><p class="fw-bold mb-0">Remote (US)</p></div></div>' +
        '<div class="col-6"><div class="p-2 rounded-3" style="background:var(--secondary)"><p class="text-muted-cp mb-0" style="font-size:11px">Deadline</p><p class="fw-bold mb-0" style="color:var(--destructive)">May 20, 2026</p></div></div>' +
      '</div>' +
      '<div class="d-flex gap-2">' +
        '<button onclick="closeModal();openAcceptModal()" class="btn-cp btn-green-cp flex-fill justify-content-center">Accept Offer</button>' +
        '<button onclick="closeModal();openDeclineModal()" class="btn-cp btn-outline-cp flex-fill justify-content-center">Decline</button>' +
      '</div>' +
    '</div>'
  );
}
</script>
@endpush
