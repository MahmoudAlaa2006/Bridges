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
    @forelse($jobs as $job)
      <div class="cp-card job-item" data-title="{{ $job->title }}">
        <div class="cp-card-body">
          <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
              <div class="d-flex align-items-center gap-3 flex-wrap">
                <span style="font-size:1.05rem;font-weight:600;">{{ $job->title }}</span>
                <span class="badge-stage bs-applied" style="font-size:.7rem;padding:2px 9px;border-radius:4px;">JOB-{{ sprintf('%03d', $job->job_id) }}</span>
              </div>
              <div class="d-flex align-items-center gap-3 mt-2 flex-wrap" style="font-size:.82rem;color:var(--muted);">
                <span><i class="bi bi-building me-1"></i>{{ $job->department }}</span>
                <span><i class="bi bi-geo-alt me-1"></i>{{ $job->location_type }}</span>
                <span>Full-time</span>
                <span>Posted: {{ $job->created_at->format('Y-m-d') }}</span>
              </div>
            </div>
            <div class="d-flex align-items-center gap-4">
              <div class="text-end">
                <div style="font-size:1.7rem;font-weight:700;">{{ $job->applications_count }}</div>
                <div style="font-size:.75rem;color:var(--muted);">Applicants</div>
              </div>
              <a href="{{ route('hr.all-candidates') }}" class="btn-outline-cp"><i class="bi bi-eye"></i> View</a>
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="cp-card">
        <div class="cp-card-body text-center py-5">
          <div class="mb-3"><i class="bi bi-briefcase" style="font-size: 3rem; color: var(--muted);"></i></div>
          <p class="text-muted">No published jobs found in the database.</p>
        </div>
      </div>
    @endforelse
  </div>


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
