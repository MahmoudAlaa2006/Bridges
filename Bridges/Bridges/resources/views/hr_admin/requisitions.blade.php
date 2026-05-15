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
        <span class="badge-stage bs-pending">{{ $requisitions->count() }}</span>
      </div>
    </div>
    <div class="cp-card-body">
      <div class="d-flex flex-column gap-2">
        @forelse($requisitions as $req)
          @php
            $reqRequirements = json_decode($req->requirements, true) ?? [];
            $reqBenefits = json_decode($req->benefits, true) ?? [];
          @endphp
          <div class="list-row req-row" id="row-{{ $req->requisition_id }}">
            <div class="flex-grow-1">
              <div class="d-flex align-items-center gap-3 flex-wrap">
                <span style="font-weight:500;">{{ $req->title }}</span>
                @php
                  $statusClass = match($req->status) {
                      'approved' => 'bs-offer',
                      'rejected' => 'bs-rejected',
                      default => 'bs-applied'
                  };
                @endphp
                <span class="badge-stage {{ $statusClass }}" style="font-size:.7rem;padding:2px 9px;border-radius:4px;">{{ strtoupper($req->status) }}</span>
              </div>
              <div class="d-flex align-items-center gap-3 mt-1 flex-wrap" style="font-size:.78rem;color:var(--muted);">
                <span><i class="bi bi-building me-1"></i>{{ $req->department }}</span>
                <span><i class="bi bi-people me-1"></i>1 position</span>
                <span><i class="bi bi-calendar me-1"></i>{{ $req->created_at->format('Y-m-d') }}</span>
              </div>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
              <button class="btn-outline-cp btn-sm-cp"
                      onclick="openRequisitionDetailsModal('{{ $req->requisition_id }}', 'REQ-{{ sprintf('%03d', $req->requisition_id) }}', '{{ addslashes($req->title) }}', '{{ addslashes($req->department) }}', '1 position', '{{ addslashes($req->salary_range ?? 'Negotiable') }}', '{{ $req->created_at->format('Y-m-d') }}', 'Full-time', '{{ addslashes($req->description) }}', {{ json_encode($reqRequirements) }}, 'Pending approval.', 'System', '{{ $req->status }}')">
                <i class="bi bi-eye"></i> View
              </button>
              
              @if($req->status === 'pending')
                <form action="{{ route('hr.requisitions.approve', $req->requisition_id) }}" method="POST" class="m-0">
                  @csrf
                  <button type="submit" class="btn-green-cp btn-sm-cp">
                    <i class="bi bi-check"></i> Approve
                  </button>
                </form>
                <button class="btn-red-cp btn-sm-cp" onclick="openRejectRequisitionModal('{{ $req->requisition_id }}')">
                  <i class="bi bi-x"></i> Reject
                </button>
              @endif
            </div>
          </div>
        @empty
          <div class="text-center py-4 text-muted">No pending requisitions.</div>
        @endforelse
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
function openRequisitionDetailsModal(dbId, id, title, dept, headcount, salary, submitted, typeLoc, desc, reqs, just, user, status) {
  let reqsHtml = '';
  if (Array.isArray(reqs)) {
    reqs.forEach(r => {
      reqsHtml += `<li>${r}</li>`;
    });
  }

  const html = `
    <div class="p-4">
      <div class="d-flex align-items-center justify-content-between gap-3 mb-4">
        <div>
          <h5 class="fw-bold mb-1">${title}</h5>
          <div class="text-muted-cp" style="font-size:.85rem;">${id} • ${dept}</div>
        </div>
        <button onclick="closeModal()" class="btn-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M18 6L6 18M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <div class="row g-4">
        <div class="col-md-7">
          <div class="mb-4">
            <label class="cp-label mb-2">Job Description</label>
            <div style="font-size:.9rem;line-height:1.6;color:var(--muted-fg);">${desc}</div>
          </div>
          <div>
            <label class="cp-label mb-2">Requirements</label>
            <ul class="ps-3 mb-0" style="font-size:.9rem;line-height:1.6;color:var(--muted-fg);">
              ${reqsHtml || '<li>No specific requirements listed</li>'}
            </ul>
          </div>
        </div>
        <div class="col-md-5">
          <div class="cp-card p-3 mb-3" style="background:rgba(255,255,255,0.03);">
            <div class="d-flex flex-column gap-3">
              <div>
                <div class="text-muted-cp" style="font-size:.75rem;text-transform:uppercase;letter-spacing:0.5px;">Salary Range</div>
                <div class="fw-medium">${salary}</div>
              </div>
              <div>
                <div class="text-muted-cp" style="font-size:.75rem;text-transform:uppercase;letter-spacing:0.5px;">Submitted On</div>
                <div class="fw-medium">${submitted}</div>
              </div>
            </div>
          </div>
          <div class="cp-card p-3" style="background:rgba(255,255,255,0.03);">
            <div class="text-muted-cp mb-2" style="font-size:.75rem;text-transform:uppercase;letter-spacing:0.5px;">Justification</div>
            <div style="font-size:.9rem;line-height:1.5;">${just}</div>
          </div>
        </div>
      </div>

      <div class="d-flex align-items-center justify-content-between mt-5 pt-3 border-top">
        <div style="font-size:.85rem;color:var(--muted);">Requested by: <span class="text-white fw-medium">${user}</span></div>
        <div class="d-flex gap-2">
          <button class="btn-outline-cp" onclick="closeModal()">Close</button>
          ${status === 'pending' ? `
            <button class="btn-red-cp" onclick="openRejectRequisitionModal('${dbId}')"><i class="bi bi-x"></i> Reject</button>
            <form action="/hr-admin/requisitions/${dbId}/approve" method="POST" style="margin:0;">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <button type="submit" class="btn-green-cp"><i class="bi bi-check-lg"></i> Approve & Publish</button>
            </form>
          ` : ''}
        </div>
      </div>
    </div>
  `;
  openModal(html);
}

function openRejectRequisitionModal(dbId) {
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

      <form action="/hr-admin/requisitions/${dbId}/reject" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <p class="text-muted-cp mb-4" style="font-size:.9rem;">
          Please provide a reason for rejecting this requisition. This feedback will be shared with the department head.
        </p>

        <div class="mb-4">
          <label class="cp-label mb-2">Rejection Reason</label>
          <textarea class="cp-input" name="reason" id="rejectionReason" rows="5"
                    placeholder="Enter detailed reason for rejection..." 
                    style="resize:vertical;"
                    oninput="document.getElementById('confirmRejectBtn').disabled = !this.value.trim()"></textarea>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
          <button type="button" class="btn-outline-cp" onclick="closeModal()">Cancel</button>
          <button type="submit" class="btn-red-cp" id="confirmRejectBtn" disabled>
            <i class="bi bi-x-circle"></i> Confirm Rejection
          </button>
        </div>
      </form>
    </div>
  `;
  openModal(html);
}
</script>
@endpush



