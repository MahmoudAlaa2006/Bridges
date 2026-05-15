@extends('layouts.app')


@section('sidebar')
    @include('layouts.partials.hr_admin_sidebar')
@endsection
@section('title', 'Overview')
@section('topbar-title', 'Overview')

<link rel="stylesheet" href="{{ asset('css/hr_admin.css') }}" />

@section('content')
  <h1 class="page-section-title">Dashboard Overview</h1>
  <p class="page-section-sub">Welcome back! Here's what's happening today.</p>

  <!-- ── STAT CARDS ── -->
  <div class="row g-3 mb-4">

    <div class="col-12 col-sm-6 col-lg-4">
      <a href="{{ url('hr-admin/requisitions') }}" class="stat-card d-block">
        <div class="d-flex align-items-start justify-content-between">
          <div>
            <div class="stat-value">{{ $stats['pending_requisitions'] }}</div>
            <div class="stat-label">Pending Requisitions</div>
          </div>
          <div class="stat-icon bg-primary-soft">
            <i class="bi bi-clipboard-check-fill text-primary"></i>
          </div>
        </div>
      </a>
    </div>

    <div class="col-12 col-sm-6 col-lg-4">
      <a href="{{ url('hr-admin/jobs') }}" class="stat-card d-block">
        <div class="d-flex align-items-start justify-content-between">
          <div>
            <div class="stat-value">{{ $stats['active_jobs'] }}</div>
            <div class="stat-label">Active Jobs</div>
          </div>
          <div class="stat-icon bg-accent-soft">
            <i class="bi bi-briefcase-fill text-accent"></i>
          </div>
        </div>
      </a>
    </div>

    <div class="col-12 col-sm-6 col-lg-4">
      <a href="{{ url('hr-admin/reports') }}" class="stat-card d-block">
        <div class="d-flex align-items-start justify-content-between">
          <div>
            <div class="stat-value">{{ $stats['urgent_reports'] }}</div>
            <div class="stat-label">Urgent Reports</div>
          </div>
          <div class="stat-icon bg-red-soft">
            <i class="bi bi-exclamation-triangle-fill text-red"></i>
          </div>
        </div>
      </a>
    </div>

  </div><!-- /stat cards -->

  <!-- ── BOTTOM ROW ── -->
  <div class="row g-3">

    <!-- Recent Activity -->
    <div class="col-12 col-lg-7">
      <div class="cp-card h-100">
        <div class="cp-card-header">
          <h2 class="cp-card-title">Recent Activity</h2>
        </div>
        <div class="cp-card-body">
          <div class="d-flex flex-column gap-2">
            @forelse($recentActivity as $activity)
              <div class="activity-row">
                <div>
                  <div class="activity-title">Application Updated</div>
                  <div class="activity-desc">{{ $activity->candidate->first_name }} {{ $activity->candidate->last_name }} — {{ $activity->job->title }}, Status: {{ ucfirst($activity->status) }}</div>
                </div>
                <div class="activity-time">{{ $activity->updated_at->diffForHumans() }}</div>
              </div>
            @empty
              <div class="text-center py-4 text-muted">No recent activity.</div>
            @endforelse
          </div>
        </div>
      </div>
    </div>

    <!-- Pending Offers -->
    <div class="col-12 col-lg-5">
      <div class="cp-card h-100">
        <div class="cp-card-header">
          <h2 class="cp-card-title">Pending Offers</h2>
          <a href="{{ url('hr-admin/offers') }}" class="btn-ghost-cp btn-sm-cp">View all <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="cp-card-body">
          <div class="d-flex flex-column gap-2">
            @forelse($pendingOffers as $offer)
              @php
                $initials = strtoupper(substr($offer->candidate->first_name, 0, 1) . substr($offer->candidate->last_name, 0, 1));
              @endphp
              <div class="list-row">
                <div class="d-flex align-items-center gap-3">
                  <div class="av-init" style="width:38px;height:38px;font-size:.8rem;">{{ $initials }}</div>
                  <div>
                    <div style="font-size:.875rem;font-weight:500;">{{ $offer->candidate->first_name }} {{ $offer->candidate->last_name }}</div>
                    <div style="font-size:.75rem;color:var(--muted);">{{ $offer->job->title }}</div>
                  </div>
                </div>
                <span class="badge-stage bs-pending">Pending</span>
              </div>
            @empty
              <div class="text-center py-4 text-muted">No pending offers.</div>
            @endforelse
          </div>
        </div>
      </div>
    </div>

  </div><!-- /bottom row -->
@endsection
