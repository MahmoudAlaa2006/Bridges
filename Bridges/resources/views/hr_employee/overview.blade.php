@extends('layouts.app')


@section('sidebar')
    @include('layouts.partials.hr_employee_sidebar')
@endsection

@section('title', 'Overview')
@section('header-title', 'Overview')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/hremployee.css') }}">
@endpush

@section('content')
  <div class="page-wrapper">
    <h1 class="mb-4 text-white">HR Dashboard</h1>
    
    <div class="card bg-card border-card mb-4">
      <div class="card-body">
        <h2 class="card-title text-white h4">Welcome back, Sarah!</h2>
        <p class="card-subtitle mb-0 text-muted">Here's your recruitment activity summary.</p>
      </div>
    </div>

    <div class="row mb-4 g-3">
      <div class="col-md-2 col-sm-6">
        <div class="card bg-card border-card h-100">
          <div class="card-body text-center">
            <div class="display-5 fw-bold text-white mb-2">12</div>
            <div class="small text-muted fw-medium text-uppercase">Submitted Requisitions</div>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-sm-6">
        <div class="card bg-card border-card h-100">
          <div class="card-body text-center">
            <div class="display-5 fw-bold text-success mb-2">8</div>
            <div class="small text-muted fw-medium text-uppercase">Approved</div>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-sm-6">
        <div class="card bg-card border-card h-100">
          <div class="card-body text-center">
            <div class="display-5 fw-bold text-danger mb-2">2</div>
            <div class="small text-muted fw-medium text-uppercase">Rejected</div>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="card bg-card border-card h-100">
          <div class="card-body text-center">
            <div class="display-5 fw-bold text-warning mb-2">2</div>
            <div class="small text-muted fw-medium text-uppercase">Pending Approval</div>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="card bg-card border-card h-100">
          <div class="card-body text-center">
            <div class="display-5 fw-bold text-info mb-2">6</div>
            <div class="small text-muted fw-medium text-uppercase">Active Interviews</div>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-lg-8">
        <div class="card bg-card border-card mb-4">
          <div class="card-body">
            <h3 class="card-title text-white h5 mb-4">Recruitment Pipeline</h3>
            <div class="d-flex align-items-center justify-content-between overflow-auto pb-2 pipeline-container">
              <div class="pipeline-stage flex-grow-1 text-center bg-input border-card rounded p-3">
                <div class="h3 text-white mb-1">45</div>
                <div class="small text-muted">Applied</div>
              </div>
              <div class="text-muted mx-3 fs-4">→</div>
              <div class="pipeline-stage flex-grow-1 text-center bg-input border-card rounded p-3">
                <div class="h3 text-white mb-1">18</div>
                <div class="small text-muted">Exam</div>
              </div>
              <div class="text-muted mx-3 fs-4">→</div>
              <div class="pipeline-stage flex-grow-1 text-center bg-input border-card rounded p-3">
                <div class="h3 text-white mb-1">6</div>
                <div class="small text-muted">Interview</div>
              </div>
              <div class="text-muted mx-3 fs-4">→</div>
              <div class="pipeline-stage flex-grow-1 text-center bg-input border-card rounded p-3">
                <div class="h3 text-white mb-1">2</div>
                <div class="small text-muted">Offers</div>
              </div>
            </div>
          </div>
        </div>

        <div class="card bg-card border-card">
          <div class="card-body">
            <h3 class="card-title text-white h5 mb-3">Recent Requisitions</h3>
            <div class="table-responsive">
              <table class="table table-borderless align-middle mb-0 custom-table">
                <thead>
                  <tr>
                    <th class="text-muted text-uppercase small fw-medium">Role</th>
                    <th class="text-muted text-uppercase small fw-medium">Date Submitted</th>
                    <th class="text-muted text-uppercase small fw-medium">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-white fw-medium">Senior Frontend Developer</td>
                    <td class="text-muted">Apr 28, 2026</td>
                    <td><span class="custom-badge badge-approved">Approved</span></td>
                  </tr>
                  <tr>
                    <td class="text-white fw-medium">Backend Engineer</td>
                    <td class="text-muted">May 1, 2026</td>
                    <td><span class="custom-badge badge-pending">Pending</span></td>
                  </tr>
                  <tr>
                    <td class="text-white fw-medium">Product Manager</td>
                    <td class="text-muted">Apr 25, 2026</td>
                    <td><span class="custom-badge badge-rejected">Rejected</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card bg-card border-card h-100">
          <div class="card-body">
            <h3 class="card-title text-white h5 mb-4">Notifications</h3>
            <div class="d-flex mb-3 alert-item">
              <div class="me-3 flex-shrink-0">
                <div class="rounded-circle d-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning" style="width: 40px; height: 40px;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                </div>
              </div>
              <div>
                <p class="text-white mb-1 small">Engineering department budget updated.</p>
                <span class="text-muted small">2 hours ago</span>
              </div>
            </div>
            <div class="d-flex alert-item">
              <div class="me-3 flex-shrink-0">
                <div class="rounded-circle d-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning" style="width: 40px; height: 40px;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                </div>
              </div>
              <div>
                <p class="text-white mb-1 small">2 interview feedback forms pending review.</p>
                <span class="text-muted small">5 hours ago</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('js/hremployee.js') }}"></script>
@endpush