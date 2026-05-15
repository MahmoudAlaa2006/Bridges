@extends('layouts.app')

@section('sidebar')
    @include('layouts.partials.hr_admin_sidebar')
@endsection
@section('title', 'All Candidates')
@section('topbar-title', 'Candidates')

<link rel="stylesheet" href="{{ asset('css/hr_admin.css') }}" />

@section('topbar-extras')
  <div class="ms-auto d-none d-md-block search-wrap" style="width:220px;">
    <i class="bi bi-search"></i>
    <input type="search" class="cp-input" placeholder="Search candidates..." id="candSearch" />
  </div>
@endsection

@section('content')
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb" style="font-size:.82rem;background:none;padding:0;margin:0;">
      <li class="breadcrumb-item">
        <a href="{{ route('hr.jobs') }}" style="color:var(--muted);">Jobs</a>
      </li>
      <li class="breadcrumb-item active" style="color:var(--fg);">All Positions</li>
    </ol>
  </nav>

  <!-- Page heading -->
  <div class="d-flex align-items-start justify-content-between flex-wrap gap-3 mb-4">
    <div>
      <h1 class="page-section-title">All Candidates</h1>
      <p class="page-section-sub">All applicants across all active job postings.</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('hr.all-candidates') }}" class="btn-primary-cp">All Candidates</a>
      <a href="{{ route('hr.top-candidates') }}" class="btn-outline-cp">
        <i class="bi bi-star-fill" style="color:var(--primary);"></i> Top 10%
      </a>
    </div>
  </div>

  <!-- Candidates Card / Table -->
  <div class="cp-card">
    <div class="cp-card-header">
      <h2 class="cp-card-title">Candidate List</h2>
      <select class="cp-input" id="stageFilter" style="width:auto;padding:6px 12px;">
        <option value="">All Stages</option>
        <option value="applied">Applied</option>
        <option value="exam">Exam</option>
        <option value="interview">Interview</option>
        <option value="offer">Offer</option>
        <option value="rejected">Rejected</option>
      </select>
    </div>
    <div class="cp-card-body no-pad">
      <div class="table-responsive">
        <table class="cp-table">
          <thead>
            <tr>
              <th>Candidate</th>
              <th>Score</th>
              <th>Stage</th>
              <th>Applied</th>
              <th>Top 10%</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="candidateTableBody">
            @forelse($candidates as $app)
              @php
                $user = $app->candidate;
                $initials = collect(explode(' ', $user->first_name . ' ' . $user->last_name))->map(fn($n) => substr($n, 0, 1))->take(2)->implode('');
                $score = $app->match_score ?? 0;
                $scoreColor = $score >= 80 ? 'var(--primary)' : ($score >= 60 ? 'var(--accent)' : 'var(--red)');
                $statusColorClass = 'bs-' . strtolower($app->status);
                $isTop = $score >= 85; // Simple proxy for top 10%
              @endphp
              <tr class="cand-row" data-stage="{{ strtolower($app->status) }}" data-name="{{ $user->first_name }} {{ $user->last_name }}">
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="av-init" style="width:32px;height:32px;font-size:.72rem;">{{ strtoupper($initials) }}</div>
                    <div>
                      <div style="font-weight:500;font-size:.87rem;">{{ $user->first_name }} {{ $user->last_name }}</div>
                      <div style="font-size:.75rem;color:var(--muted);">{{ $user->email }}</div>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="score-bar" style="width:70px;"><div class="score-bar-fill" style="width:{{ $score }}%;background:{{ $scoreColor }};"></div></div>
                    <span style="font-size:.85rem;font-weight:600;">{{ number_format($score, 0) }}%</span>
                  </div>
                </td>
                <td><span class="badge-stage {{ $statusColorClass }}">{{ ucfirst($app->status) }}</span></td>
                <td style="color:var(--muted);font-size:.82rem;">{{ $app->created_at->format('Y-m-d') }}</td>
                <td>
                  @if($isTop)
                    <i class="bi bi-star-fill" style="color:var(--primary);"></i>
                  @else
                    <span style="color:var(--muted);">—</span>
                  @endif
                </td>
                <td><a href="{{ route('hr.candidates', $user->id) }}" class="btn-outline-cp btn-sm-cp"><i class="bi bi-eye"></i> View</a></td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center py-4 text-muted">No candidates found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script src="{{ asset('js/hr_admin.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var stageFilter = document.getElementById('stageFilter');
  var candSearch  = document.getElementById('candSearch');
  var rows        = document.querySelectorAll('.cand-row');

  function filterRows() {
    var stage = stageFilter ? stageFilter.value.toLowerCase() : '';
    var q     = candSearch  ? candSearch.value.toLowerCase()  : '';
    rows.forEach(function (row) {
      var rs = (row.getAttribute('data-stage') || '').toLowerCase();
      var rn = (row.getAttribute('data-name')  || '').toLowerCase();
      var ok = (!stage || rs === stage) && (!q || rn.includes(q));
      row.style.display = ok ? '' : 'none';
    });
  }

  if (stageFilter) stageFilter.addEventListener('change', filterRows);
  if (candSearch)  candSearch.addEventListener('input',  filterRows);
});
</script>
@endpush
