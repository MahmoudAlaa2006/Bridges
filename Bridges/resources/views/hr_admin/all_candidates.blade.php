@extends('layouts.app')

@section('sidebar')
    @include('layouts.partials.hr_admin_sidebar')
@endsection
@section('title', 'All Candidates — Senior Backend Developer')
@section('topbar-title', 'Candidates – Senior Backend Developer')

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
      <li class="breadcrumb-item active" style="color:var(--fg);">Senior Backend Developer</li>
    </ol>
  </nav>

  <!-- Page heading -->
  <div class="d-flex align-items-start justify-content-between flex-wrap gap-3 mb-4">
    <div>
      <h1 class="page-section-title">All Candidates: Senior Backend Developer</h1>
      <p class="page-section-sub">All applicants for the "Senior Backend Developer" position.</p>
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

            <tr class="cand-row" data-stage="interview" data-name="John Smith">
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div class="av-init" style="width:32px;height:32px;font-size:.72rem;">JS</div>
                  <div>
                    <div style="font-weight:500;font-size:.87rem;">John Smith</div>
                    <div style="font-size:.75rem;color:var(--muted);">john@email.com</div>
                  </div>
                </div>
              </td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div class="score-bar" style="width:70px;"><div class="score-bar-fill" style="width:92%;background:var(--primary);"></div></div>
                  <span style="font-size:.85rem;font-weight:600;">92%</span>
                </div>
              </td>
              <td><span class="badge-stage bs-interview">Interview</span></td>
              <td style="color:var(--muted);font-size:.82rem;">2024-01-16</td>
              <td><i class="bi bi-star-fill" style="color:var(--primary);"></i></td>
              <td><a href="{{ route('hr.candidates') }}" class="btn-outline-cp btn-sm-cp"><i class="bi bi-eye"></i> View</a></td>
            </tr>

            <tr class="cand-row" data-stage="offer" data-name="Sarah Johnson">
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div class="av-init" style="width:32px;height:32px;font-size:.72rem;">SJ</div>
                  <div>
                    <div style="font-weight:500;font-size:.87rem;">Sarah Johnson</div>
                    <div style="font-size:.75rem;color:var(--muted);">sarah@email.com</div>
                  </div>
                </div>
              </td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div class="score-bar" style="width:70px;"><div class="score-bar-fill" style="width:89%;background:var(--primary);"></div></div>
                  <span style="font-size:.85rem;font-weight:600;">89%</span>
                </div>
              </td>
              <td><span class="badge-stage bs-offer">Offer</span></td>
              <td style="color:var(--muted);font-size:.82rem;">2024-01-16</td>
              <td><i class="bi bi-star-fill" style="color:var(--primary);"></i></td>
              <td><a href="{{ route('hr.candidates') }}" class="btn-outline-cp btn-sm-cp"><i class="bi bi-eye"></i> View</a></td>
            </tr>

            <tr class="cand-row" data-stage="exam" data-name="Mike Chen">
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div class="av-init" style="width:32px;height:32px;font-size:.72rem;">MC</div>
                  <div>
                    <div style="font-weight:500;font-size:.87rem;">Mike Chen</div>
                    <div style="font-size:.75rem;color:var(--muted);">mike@email.com</div>
                  </div>
                </div>
              </td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div class="score-bar" style="width:70px;"><div class="score-bar-fill" style="width:87%;background:var(--primary);"></div></div>
                  <span style="font-size:.85rem;font-weight:600;">87%</span>
                </div>
              </td>
              <td><span class="badge-stage bs-exam">Exam</span></td>
              <td style="color:var(--muted);font-size:.82rem;">2024-01-17</td>
              <td><i class="bi bi-star-fill" style="color:var(--primary);"></i></td>
              <td><a href="{{ route('hr.candidates') }}" class="btn-outline-cp btn-sm-cp"><i class="bi bi-eye"></i> View</a></td>
            </tr>

            <tr class="cand-row" data-stage="interview" data-name="Emily Davis">
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div class="av-init" style="width:32px;height:32px;font-size:.72rem;">ED</div>
                  <div>
                    <div style="font-weight:500;font-size:.87rem;">Emily Davis</div>
                    <div style="font-size:.75rem;color:var(--muted);">emily@email.com</div>
                  </div>
                </div>
              </td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div class="score-bar" style="width:70px;"><div class="score-bar-fill" style="width:85%;background:var(--primary);"></div></div>
                  <span style="font-size:.85rem;font-weight:600;">85%</span>
                </div>
              </td>
              <td><span class="badge-stage bs-interview">Interview</span></td>
              <td style="color:var(--muted);font-size:.82rem;">2024-01-17</td>
              <td><i class="bi bi-star-fill" style="color:var(--primary);"></i></td>
              <td><a href="{{ route('hr.candidates') }}" class="btn-outline-cp btn-sm-cp"><i class="bi bi-eye"></i> View</a></td>
            </tr>

            <tr class="cand-row" data-stage="applied" data-name="Alex Wilson">
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div class="av-init" style="width:32px;height:32px;font-size:.72rem;">AW</div>
                  <div>
                    <div style="font-weight:500;font-size:.87rem;">Alex Wilson</div>
                    <div style="font-size:.75rem;color:var(--muted);">alex@email.com</div>
                  </div>
                </div>
              </td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div class="score-bar" style="width:70px;"><div class="score-bar-fill" style="width:78%;background:var(--accent);"></div></div>
                  <span style="font-size:.85rem;font-weight:600;">78%</span>
                </div>
              </td>
              <td><span class="badge-stage bs-applied">Applied</span></td>
              <td style="color:var(--muted);font-size:.82rem;">2024-01-18</td>
              <td style="color:var(--muted);">—</td>
              <td><a href="{{ route('hr.candidates') }}" class="btn-outline-cp btn-sm-cp"><i class="bi bi-eye"></i> View</a></td>
            </tr>

            <tr class="cand-row" data-stage="rejected" data-name="Lisa Brown">
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div class="av-init" style="width:32px;height:32px;font-size:.72rem;background:rgba(239,68,68,.15);color:var(--red);">LB</div>
                  <div>
                    <div style="font-weight:500;font-size:.87rem;">Lisa Brown</div>
                    <div style="font-size:.75rem;color:var(--muted);">lisa@email.com</div>
                  </div>
                </div>
              </td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div class="score-bar" style="width:70px;"><div class="score-bar-fill" style="width:75%;background:var(--red);"></div></div>
                  <span style="font-size:.85rem;font-weight:600;">75%</span>
                </div>
              </td>
              <td><span class="badge-stage bs-rejected">Rejected</span></td>
              <td style="color:var(--muted);font-size:.82rem;">2024-01-18</td>
              <td style="color:var(--muted);">—</td>
              <td><a href="{{ route('hr.candidates') }}" class="btn-outline-cp btn-sm-cp"><i class="bi bi-eye"></i> View</a></td>
            </tr>

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
