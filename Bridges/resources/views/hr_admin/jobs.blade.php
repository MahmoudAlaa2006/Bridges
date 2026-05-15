@extends('layouts.app')

@section('sidebar')
    @include('layouts.partials.hr_admin_sidebar')
@endsection
@section('title', 'Published Jobs')
@section('topbar-title', 'Published Jobs')

<link rel="stylesheet" href="{{ asset('css/hr_admin.css') }}" />

@section('topbar-extras')
  <div class="ms-auto d-none d-md-block search-wrap" style="width:220px;">
    <i class="bi bi-search"></i>
    <input type="search" class="cp-input" placeholder="Search jobs..." id="jobSearch" />
  </div>
@endsection

@section('content')
  <h1 class="page-section-title">Published Jobs</h1>
  <p class="page-section-sub">Manage active job listings and view candidates</p>

  <!-- Search (mobile) -->
  <div class="d-md-none mb-3 search-wrap">
    <i class="bi bi-search"></i>
    <input type="search" class="cp-input" placeholder="Search jobs..." id="jobSearchMobile" />
  </div>

  <!-- Jobs List -->
  <div class="d-flex flex-column gap-3" id="jobsList">

    <!-- Job 1 -->
    <div class="cp-card job-item" data-title="Senior Backend Developer">
      <div class="cp-card-body">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
          <div>
            <div class="d-flex align-items-center gap-3 flex-wrap">
              <span style="font-size:1.05rem;font-weight:600;">Senior Backend Developer</span>
              <span class="badge-stage bs-applied" style="font-size:.7rem;padding:2px 9px;border-radius:4px;">JOB-001</span>
            </div>
            <div class="d-flex align-items-center gap-3 mt-2 flex-wrap" style="font-size:.82rem;color:var(--muted);">
              <span><i class="bi bi-building me-1"></i>Engineering</span>
              <span><i class="bi bi-geo-alt me-1"></i>Remote</span>
              <span>Full-time</span>
              <span>Posted: 2024-01-18</span>
            </div>
          </div>
          <div class="d-flex align-items-center gap-4">
            <div class="text-end">
              <div style="font-size:1.7rem;font-weight:700;">47</div>
              <div style="font-size:.75rem;color:var(--muted);">Applicants</div>
            </div>
            <a href="{{ route('hr.all-candidates') }}" class="btn-outline-cp"><i class="bi bi-eye"></i> View</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Job 2 -->
    <div class="cp-card job-item" data-title="Product Manager">
      <div class="cp-card-body">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
          <div>
            <div class="d-flex align-items-center gap-3 flex-wrap">
              <span style="font-size:1.05rem;font-weight:600;">Product Manager</span>
              <span class="badge-stage bs-applied" style="font-size:.7rem;padding:2px 9px;border-radius:4px;">JOB-002</span>
            </div>
            <div class="d-flex align-items-center gap-3 mt-2 flex-wrap" style="font-size:.82rem;color:var(--muted);">
              <span><i class="bi bi-building me-1"></i>Product</span>
              <span><i class="bi bi-geo-alt me-1"></i>New York (Hybrid)</span>
              <span>Full-time</span>
              <span>Posted: 2024-01-19</span>
            </div>
          </div>
          <div class="d-flex align-items-center gap-4">
            <div class="text-end">
              <div style="font-size:1.7rem;font-weight:700;">31</div>
              <div style="font-size:.75rem;color:var(--muted);">Applicants</div>
            </div>
            <a href="{{ route('hr.all-candidates') }}" class="btn-outline-cp"><i class="bi bi-eye"></i> View</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Job 3 -->
    <div class="cp-card job-item" data-title="UX Designer">
      <div class="cp-card-body">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
          <div>
            <div class="d-flex align-items-center gap-3 flex-wrap">
              <span style="font-size:1.05rem;font-weight:600;">UX Designer</span>
              <span class="badge-stage bs-applied" style="font-size:.7rem;padding:2px 9px;border-radius:4px;">JOB-003</span>
            </div>
            <div class="d-flex align-items-center gap-3 mt-2 flex-wrap" style="font-size:.82rem;color:var(--muted);">
              <span><i class="bi bi-building me-1"></i>Design</span>
              <span><i class="bi bi-geo-alt me-1"></i>Remote</span>
              <span>Full-time</span>
              <span>Posted: 2024-01-20</span>
            </div>
          </div>
          <div class="d-flex align-items-center gap-4">
            <div class="text-end">
              <div style="font-size:1.7rem;font-weight:700;">24</div>
              <div style="font-size:.75rem;color:var(--muted);">Applicants</div>
            </div>
            <a href="{{ route('hr.all-candidates') }}" class="btn-outline-cp"><i class="bi bi-eye"></i> View</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Job 4 -->
    <div class="cp-card job-item" data-title="DevOps Engineer">
      <div class="cp-card-body">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
          <div>
            <div class="d-flex align-items-center gap-3 flex-wrap">
              <span style="font-size:1.05rem;font-weight:600;">DevOps Engineer</span>
              <span class="badge-stage bs-applied" style="font-size:.7rem;padding:2px 9px;border-radius:4px;">JOB-004</span>
            </div>
            <div class="d-flex align-items-center gap-3 mt-2 flex-wrap" style="font-size:.82rem;color:var(--muted);">
              <span><i class="bi bi-building me-1"></i>Infrastructure</span>
              <span><i class="bi bi-geo-alt me-1"></i>Remote</span>
              <span>Full-time</span>
              <span>Posted: 2024-01-21</span>
            </div>
          </div>
          <div class="d-flex align-items-center gap-4">
            <div class="text-end">
              <div style="font-size:1.7rem;font-weight:700;">19</div>
              <div style="font-size:.75rem;color:var(--muted);">Applicants</div>
            </div>
            <a href="{{ url('hr-admin/candidates') }}" class="btn-outline-cp"><i class="bi bi-eye"></i> View</a>
          </div>
        </div>
      </div>
    </div>

  </div><!-- /jobsList -->

  <div id="noResults" class="text-center py-5 d-none">
    <i class="bi bi-search" style="font-size:2.5rem;color:var(--border);"></i>
    <p class="mt-3" style="color:var(--muted);">No jobs match your search.</p>
  </div>
@endsection

@push('scripts')
<script src="{{ asset('js/hr_admin.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var inputs   = [document.getElementById('jobSearch'), document.getElementById('jobSearchMobile')];
  var items    = document.querySelectorAll('.job-item');
  var noResult = document.getElementById('noResults');

  function applySearch(q) {
    q = (q || '').toLowerCase();
    var visible = 0;
    items.forEach(function (item) {
      var title = item.getAttribute('data-title').toLowerCase();
      var show  = !q || title.includes(q);
      item.style.display = show ? '' : 'none';
      if (show) visible++;
    });
    noResult.classList.toggle('d-none', visible > 0);
  }

  inputs.forEach(function (inp) {
    if (inp) inp.addEventListener('input', function () { applySearch(this.value); });
  });
});
</script>
@endpush
