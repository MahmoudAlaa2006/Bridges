@extends('layouts.app')

@section('sidebar')
    @include('layouts.partials.hr_employee_sidebar')
@endsection

@section('title', 'My Interviews')
@section('header-title', 'My Interviews')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/interviews.css') }}">
@endpush

@section('content')
  <div class="page-wrapper">
    <h1 class="page-title">My Interviews</h1>

    <div class="filter-tabs mb-4">
      <button class="filter-tab active" data-filter="all">All</button>
      <button class="filter-tab" data-filter="upcoming">Upcoming</button>
      <button class="filter-tab" data-filter="completed">Completed</button>
      <button class="filter-tab" data-filter="cancelled">Cancelled</button>
    </div>

    <div class="row g-4">
      <!-- Card 1 -->
      <div class="col-md-6 interview-item" data-status="upcoming">
        <div class="card h-100 interview-card" onclick="openModal('Alex Chen', 'May 10, 2026 | 10:00 AM', 'Technical', 'Upcoming')">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <h5 class="candidate-name">Alex Chen</h5>
              <span class="badge badge-upcoming">Upcoming</span>
            </div>
            <div class="interview-meta mb-3">May 10, 2026 &bull; 10:00 AM</div>
            <div class="d-flex flex-wrap gap-2 mb-3">
              <span class="meta-pill">HR: Sarah Johnson</span>
              <span class="meta-pill">Panel: Senior Dev Team</span>
              <span class="meta-pill">Type: Technical</span>
            </div>
            <p class="interview-desc">Full-stack React/Node.js role assessment. Focus on architecture.</p>
            <div class="card-actions" onclick="event.stopPropagation()">
              <a href="{{ route('hr_employee.brief') }}" class="btn btn-secondary">View Brief</a>
              <a href="{{ route('hr_employee.interview-session') }}" class="btn btn-primary">Create Session</a>
              <a href="{{ route('hr_employee.feedback') }}" class="btn btn-secondary">Feedback</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="col-md-6 interview-item" data-status="upcoming">
        <div class="card h-100 interview-card" onclick="openModal('Sara Liu', 'May 10, 2026 | 2:00 PM', 'Behavioral', 'Upcoming')">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <h5 class="candidate-name">Sara Liu</h5>
              <span class="badge badge-upcoming">Upcoming</span>
            </div>
            <div class="interview-meta mb-3">May 10, 2026 &bull; 2:00 PM</div>
            <div class="d-flex flex-wrap gap-2 mb-3">
              <span class="meta-pill">HR: Mark Davis</span>
              <span class="meta-pill">Panel: Product Team</span>
              <span class="meta-pill">Type: Behavioral</span>
            </div>
            <p class="interview-desc">Product Manager candidate final round. Leadership principles.</p>
            <div class="card-actions" onclick="event.stopPropagation()">
              <a href="{{ route('hr_employee.brief') }}" class="btn btn-secondary">View Brief</a>
              <a href="{{ route('hr_employee.interview-session') }}" class="btn btn-primary">Create Session</a>
              <a href="{{ route('hr_employee.feedback') }}" class="btn btn-secondary">Feedback</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="col-md-6 interview-item" data-status="upcoming">
        <div class="card h-100 interview-card" onclick="openModal('Mike Ross', 'May 12, 2026 | 9:30 AM', 'Technical', 'Upcoming')">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <h5 class="candidate-name">Mike Ross</h5>
              <span class="badge badge-upcoming">Upcoming</span>
            </div>
            <div class="interview-meta mb-3">May 12, 2026 &bull; 9:30 AM</div>
            <div class="d-flex flex-wrap gap-2 mb-3">
              <span class="meta-pill">HR: Emily Clark</span>
              <span class="meta-pill">Panel: Backend Team</span>
              <span class="meta-pill">Type: Technical</span>
            </div>
            <p class="interview-desc">Backend system design and algorithms round.</p>
            <div class="card-actions" onclick="event.stopPropagation()">
              <a href="{{ route('hr_employee.brief') }}" class="btn btn-secondary">View Brief</a>
              <a href="{{ route('hr_employee.interview-session') }}" class="btn btn-primary">Create Session</a>
              <a href="{{ route('hr_employee.feedback') }}" class="btn btn-secondary">Feedback</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Card 4 -->
      <div class="col-md-6 interview-item" data-status="completed">
        <div class="card h-100 interview-card" onclick="openModal('Olivia Brooks', 'May 5, 2026 | 11:00 AM', 'Technical', 'Completed')">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <h5 class="candidate-name">Olivia Brooks</h5>
              <span class="badge badge-completed">Completed</span>
            </div>
            <div class="interview-meta mb-3">May 5, 2026 &bull; 11:00 AM</div>
            <div class="d-flex flex-wrap gap-2 mb-3">
              <span class="meta-pill">HR: Sarah Johnson</span>
              <span class="meta-pill">Panel: Frontend Team</span>
              <span class="meta-pill">Type: Technical</span>
            </div>
            <p class="interview-desc">Frontend architecture and UI components discussion.</p>
            <div class="card-actions" onclick="event.stopPropagation()">
              <a href="{{ route('hr_employee.brief') }}" class="btn btn-secondary">View Brief</a>
              <button class="btn btn-secondary" disabled style="opacity: 0.5; cursor: not-allowed;">Create Session</button>
              <a href="{{ route('hr_employee.feedback') }}" class="btn btn-secondary">Feedback</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal-backdrop" id="modalBackdrop" style="display: none;"></div>
  <div class="custom-modal" id="detailsModal" style="display: none;">
    <div class="modal-header">
      <h5 class="modal-title" id="modalTitle">Interview Details</h5>
      <button class="btn-close-custom" onclick="closeModal()">&times;</button>
    </div>
    <div class="modal-body" id="modalBody">
      Loading...
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="closeModal()">Close</button>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('js/interviews.js') }}"></script>
@endpush