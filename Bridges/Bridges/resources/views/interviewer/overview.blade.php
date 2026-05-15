@extends('layouts.app')


@section('sidebar')
    @include('layouts.partials.interviewer_sidebar')
@endsection

@section('title', 'Overview')
@section('header-title', 'Overview')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/intervieweroverview.css') }}">
@endpush

@section('content')
  <div class="page-wrapper">
    <h1 class="page-title">Dashboard Overview</h1>
    
    <div class="alert-yellow">
      2 new briefs are awaiting your review
    </div>

    <div class="card">
      <div class="card-body">
        <div class="card-title">Welcome back, James!</div>
        <div class="card-subtitle">Here's your activity summary.</div>
      </div>
    </div>

    <div class="row g-4 mb-4">
      <div class="col-md-3">
        <div class="card h-100 mb-0 stat-card">
          <div class="card-body">
            <div class="stat-number">8</div>
            <div class="stat-label">Assigned Interviews</div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card h-100 mb-0 stat-card">
          <div class="card-body">
            <div class="stat-number">3</div>
            <div class="stat-label">Upcoming This Week</div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card h-100 mb-0 stat-card">
          <div class="card-body">
            <div class="stat-number">2</div>
            <div class="stat-label">New Briefs</div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card h-100 mb-0 stat-card">
          <div class="card-body">
            <div class="stat-number">24</div>
            <div class="stat-label">Completed</div>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-lg-8">
        <div class="card h-100 mb-0">
          <div class="card-body" style="padding: 0;">
            <div style="padding: 20px; border-bottom: 1px solid #3d3555;">
              <div class="card-title mb-0">Recent Interviews</div>
            </div>
            <table>
              <thead>
                <tr>
                  <th>Candidate</th>
                  <th>Date & Time</th>
                  <th>Type</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Alex Chen</td>
                  <td>Tomorrow 10:00 AM</td>
                  <td>Technical</td>
                  <td><span class="badge badge-upcoming">Upcoming</span></td>
                </tr>
                <tr>
                  <td>Sara Liu</td>
                  <td>Today 2:00 PM</td>
                  <td>Behavioral</td>
                  <td><span class="badge badge-upcoming">Upcoming</span></td>
                </tr>
                <tr>
                  <td>Mike Ross</td>
                  <td>May 12 9:30 AM</td>
                  <td>Technical</td>
                  <td><span class="badge badge-upcoming">Upcoming</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card h-100 mb-0">
          <div class="card-body">
            <div class="card-title">Activity Feed</div>
            <ul class="activity-list">
              <li>
                <span class="text-white">Interview scheduled</span>
                <span class="text-muted d-block small">Alex Chen - Tomorrow</span>
              </li>
              <li>
                <span class="text-white">Brief reviewed</span>
                <span class="text-muted d-block small">Sara Liu - Today</span>
              </li>
              <li>
                <span class="text-white">Feedback submitted</span>
                <span class="text-muted d-block small">Olivia Brooks - Yesterday</span>
              </li>
              <li>
                <span class="text-white">Session completed</span>
                <span class="text-muted d-block small">Olivia Brooks - Yesterday</span>
              </li>
              <li>
                <span class="text-white">New brief assigned</span>
                <span class="text-muted d-block small">Mike Ross - May 12</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('js/intervieweroverview.js') }}"></script>
@endpush