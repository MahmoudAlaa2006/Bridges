@extends('layouts.app')

@section('sidebar')
    @include('layouts.partials.hr_employee_sidebar')
@endsection

@section('title', 'Job Requisitions')
@section('header-title', 'Job Requisitions')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/jobrequisitions.css') }}">
@endpush

@section('content')
  <div class="page-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
      <h1 class="text-white mb-0">Job Requisitions</h1>
      <a href="{{ route('hr_employee.job-requisition-details') }}" class="btn btn-warning custom-btn-primary fw-medium px-4">Create Job Requisition</a>
    </div>
    
    <div class="card bg-card border-card mb-4">
      <div class="card-body bg-card pt-4">
        <div class="row g-3">
          
          <!-- Card 1 -->
          <div class="col-12">
            <div class="card req-card bg-input border-card cursor-pointer" onclick="openReqModal('Senior Frontend Developer', 'Approved')">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <h4 class="h5 text-white mb-0">Senior Frontend Developer</h4>
                  <span class="custom-badge badge-approved">Approved</span>
                </div>
                <div class="d-flex flex-wrap gap-3 text-muted small">
                  <span><span class="text-white">Dept:</span> Engineering</span>
                  <span><span class="text-white">Date:</span> Apr 28, 2026</span>
                  <span><span class="text-white">Type:</span> Full-time</span>
                  <span><span class="text-white">Level:</span> Senior</span>
                  <span><span class="text-white">Salary:</span> $90k–$130k</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Card 2 -->
          <div class="col-12">
            <div class="card req-card bg-input border-card cursor-pointer" onclick="openReqModal('Backend Engineer (Python)', 'Pending')">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <h4 class="h5 text-white mb-0">Backend Engineer (Python)</h4>
                  <span class="custom-badge badge-pending">Pending</span>
                </div>
                <div class="d-flex flex-wrap gap-3 text-muted small">
                  <span><span class="text-white">Dept:</span> Engineering</span>
                  <span><span class="text-white">Date:</span> May 1, 2026</span>
                  <span><span class="text-white">Type:</span> Full-time</span>
                  <span><span class="text-white">Level:</span> Mid-level</span>
                  <span><span class="text-white">Salary:</span> $80k–$110k</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Card 3 -->
          <div class="col-12">
            <div class="card req-card bg-input border-card cursor-pointer" onclick="openReqModal('Product Manager', 'Rejected')">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <h4 class="h5 text-white mb-0">Product Manager</h4>
                  <span class="custom-badge badge-rejected">Rejected</span>
                </div>
                <div class="d-flex flex-wrap gap-3 text-muted small mb-3">
                  <span><span class="text-white">Dept:</span> Product</span>
                  <span><span class="text-white">Date:</span> Apr 25, 2026</span>
                  <span><span class="text-white">Type:</span> Full-time</span>
                  <span><span class="text-white">Level:</span> Senior</span>
                  <span><span class="text-white">Salary:</span> $95k–$140k</span>
                </div>
                <div class="alert alert-danger custom-alert d-flex justify-content-between align-items-center mb-0 p-3" role="alert" onclick="event.stopPropagation()">
                  <div>
                    <strong>Rejection Reason:</strong> Budget constraints for this quarter
                  </div>
                  <a href="{{ route('hr_employee.job-requisition-details') }}" class="btn btn-sm btn-outline-light">Resubmit</a>
                </div>
              </div>
            </div>
          </div>

          <!-- Card 4 -->
          <div class="col-12">
            <div class="card req-card bg-input border-card cursor-pointer" onclick="openReqModal('UX Designer', 'Pending')">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <h4 class="h5 text-white mb-0">UX Designer</h4>
                  <span class="custom-badge badge-pending">Pending</span>
                </div>
                <div class="d-flex flex-wrap gap-3 text-muted small">
                  <span><span class="text-white">Dept:</span> Design</span>
                  <span><span class="text-white">Date:</span> May 3, 2026</span>
                  <span><span class="text-white">Type:</span> Full-time</span>
                  <span><span class="text-white">Level:</span> Mid-level</span>
                  <span><span class="text-white">Salary:</span> $75k–$105k</span>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="reqModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content custom-modal">
        <div class="modal-header border-bottom border-card">
          <h5 class="modal-title text-white" id="reqModalTitle">Requisition Details</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-white">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 id="reqModalRole" class="mb-0">Role</h4>
            <span id="reqModalStatusBadge"></span>
          </div>
          <div class="row g-3 text-muted mb-4">
            <div class="col-sm-6">
              <div class="p-3 bg-input rounded border border-card">
                <small class="d-block mb-1">Department</small>
                <strong class="text-white">Engineering</strong>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="p-3 bg-input rounded border border-card">
                <small class="d-block mb-1">Level</small>
                <strong class="text-white">Senior</strong>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="p-3 bg-input rounded border border-card">
                <small class="d-block mb-1">Target Salary</small>
                <strong class="text-white">$90,000 - $130,000</strong>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="p-3 bg-input rounded border border-card">
                <small class="d-block mb-1">Type</small>
                <strong class="text-white">Full-time, Remote</strong>
              </div>
            </div>
          </div>
          <h5 class="text-white mb-2">Description</h5>
          <p class="text-muted small">We are looking for an experienced developer to join our team and build scalable web applications. You will be responsible for the architecture, development, and maintenance of our core product.</p>
        </div>
        <div class="modal-footer border-top border-card">
          <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('js/jobrequisitions.js') }}"></script>
@endpush