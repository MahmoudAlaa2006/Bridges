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
            <div class="stat-value">5</div>
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
            <div class="stat-value">12</div>
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
            <div class="stat-value">3</div>
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

            <div class="activity-row urgent">
              <div>
                <div class="activity-title">Exam Integrity Violation</div>
                <div class="activity-desc">John Doe — Backend Technical Assessment, 3 violations</div>
              </div>
              <div class="activity-time">10 min ago</div>
            </div>

            <div class="activity-row">
              <div>
                <div class="activity-title">New Application</div>
                <div class="activity-desc">Emily Davis applied for Senior Backend Developer</div>
              </div>
              <div class="activity-time">1 hr ago</div>
            </div>

            <div class="activity-row">
              <div>
                <div class="activity-title">Requisition Submitted</div>
                <div class="activity-desc">Marketing Manager — requested by Jane Cooper</div>
              </div>
              <div class="activity-time">3 hr ago</div>
            </div>

            <div class="activity-row">
              <div>
                <div class="activity-title">Offer Sent</div>
                <div class="activity-desc">John Smith — Senior Backend Developer, $135,000</div>
              </div>
              <div class="activity-time">Yesterday</div>
            </div>

            <div class="activity-row">
              <div>
                <div class="activity-title">Interview Completed</div>
                <div class="activity-desc">Sarah Johnson — Product Manager round 2</div>
              </div>
              <div class="activity-time">Yesterday</div>
            </div>

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

            <div class="list-row">
              <div class="d-flex align-items-center gap-3">
                <div class="av-init" style="width:38px;height:38px;font-size:.8rem;">SJ</div>
                <div>
                  <div style="font-size:.875rem;font-weight:500;">Sarah Johnson</div>
                  <div style="font-size:.75rem;color:var(--muted);">Senior Backend Developer</div>
                </div>
              </div>
              <span class="badge-stage bs-pending">Pending</span>
            </div>

            <div class="list-row">
              <div class="d-flex align-items-center gap-3">
                <div class="av-init" style="width:38px;height:38px;font-size:.8rem;">RM</div>
                <div>
                  <div style="font-size:.875rem;font-weight:500;">Robert Martinez</div>
                  <div style="font-size:.75rem;color:var(--muted);">Product Manager</div>
                </div>
              </div>
              <span class="badge-stage bs-draft">Draft</span>
            </div>

          </div>
        </div>
      </div>
    </div>

  </div><!-- /bottom row -->
@endsection
