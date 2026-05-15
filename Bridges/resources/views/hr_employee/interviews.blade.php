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
      @forelse($interviews as $interview)
        @php
            $candidate = $interview->user;
            $statusClass = $interview->status === 'scheduled' ? 'upcoming' : 'completed';
        @endphp
        <div class="col-md-6 interview-item" data-status="{{ $statusClass }}">
          <div class="card h-100 interview-card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <h5 class="candidate-name">{{ $candidate->name }}</h5>
                <span class="badge badge-{{ $statusClass }}">{{ ucfirst($interview->status) }}</span>
              </div>
              <div class="interview-meta mb-3">{{ $interview->get_date->format('M d, Y') }} &bull; {{ $interview->get_date->format('h:i A') }}</div>
              <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="meta-pill">Type: Technical</span>
                <span class="meta-pill">ID: #{{ $interview->id }}</span>
              </div>
              <p class="interview-desc">{{ $interview->content }}</p>
              <div class="card-actions">
                @if($interview->status === \App\Models\Interview::STATUS_SCHEDULED)
                    @php
                        $tz = $interview->slot->time_zone ?? config('app.timezone');
                        $slotDate = \Carbon\Carbon::parse($interview->slot->date)->format('Y-m-d');
                        $startTime = \Carbon\Carbon::parse($slotDate . ' ' . $interview->slot->start_time, $tz);
                        $endTime = \Carbon\Carbon::parse($slotDate . ' ' . $interview->slot->end_time, $tz);
                        $isActive = now()->between($startTime->subMinutes(5), $endTime);
                    @endphp

                    @if($isActive)
                        <a href="{{ route('session.show', ['interview' => $interview->id]) }}" class="btn btn-primary">Join Session</a>
                    @else
                        <button class="btn btn-secondary" disabled title="Available 5 mins before start until end time" style="opacity: 0.5; cursor: not-allowed;">Join Session</button>
                    @endif
                @endif
                
                @if($interview->status === \App\Models\Interview::STATUS_PENDING_FEEDBACK)
                    <a href="{{ route('feedback.create', ['interview' => $interview->id]) }}" class="btn btn-warning">Submit Feedback</a>
                @endif
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
            <div class="alert alert-info">No interviews currently requiring your attention.</div>
        </div>
      @endforelse
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