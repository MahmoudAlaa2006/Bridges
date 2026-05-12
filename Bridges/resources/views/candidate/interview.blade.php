@extends('layouts.app')

@section('sidebar')
    @include('layouts.partials.candidate_sidebar')
@endsection
@section('title', 'Interview — CareerPortal')
@section('header-title', 'Scheduled Interviews')

@section('header-actions-prefix')
<button class="btn-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg></button>
@endsection

@section('content')
    <div class="mb-4">
      <h2 class="section-title">Scheduled Interviews</h2>
      <p class="section-sub">Prepare for your upcoming interview and review details.</p>
    </div>

    <!-- Application context banner -->
    <div class="cp-card p-3 mb-4 bg-primary-soft">
      <div class="d-flex align-items-center gap-3">
        <div class="stat-icon-wrap" style="background:rgba(245,197,66,0.2);color:var(--primary);width:40px;height:40px">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
        </div>
        <div>
          <p style="font-size:14px;font-weight:600;margin:0">Application: Senior Frontend Developer</p>
          <!-- <p class="text-muted-cp" style="font-size:13px;margin:0">TechCorp Inc. &nbsp;·&nbsp; Exam Score: 82 / 100</p> -->
        </div>
      </div>
    </div>

    <!-- Stats row -->
    <!-- <div class="row g-3 mb-4">
      <div class="col-md-4">
        <div class="stat-card cp-card">
          <div class="stat-icon-wrap" style="background:rgba(245,197,66,0.12);color:var(--primary)"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
          <div><p style="font-size:26px;font-weight:700;margin:0">1</p><p class="text-muted-cp" style="font-size:13px;margin:0">Upcoming</p></div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stat-card cp-card">
          <div class="stat-icon-wrap" style="background:rgba(34,197,94,0.12);color:#4ade80"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.55-2.07A1 1 0 0121 8.82v6.36a1 1 0 01-1.45.89L15 14M3 8a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg></div>
          <div><p style="font-size:26px;font-weight:700;margin:0">0</p><p class="text-muted-cp" style="font-size:13px;margin:0">Completed</p></div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stat-card cp-card">
          <div class="stat-icon-wrap" style="background:rgba(139,92,246,0.12);color:var(--accent)"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2M5 21H3"/></svg></div>
          <div><p style="font-size:26px;font-weight:700;margin:0">In Progress</p><p class="text-muted-cp" style="font-size:13px;margin:0">Application Status</p></div>
        </div>
      </div>
    </div> -->

    <!-- Upcoming Interviews Section -->
    <div class="mb-3">
      <h3 style="font-size:16px;font-weight:600;margin-bottom:12px">My Interviews</h3>
      @forelse($interviews as $interview)
        @php
            $application = $interview->application;
            $job = $application ? $application->job : null;
            $visiblePanels = $interview->panels->filter(fn($p) => $p->user->interviewer_type !== 'shadow');
        @endphp
        <div class="cp-card p-4 cp-card-hover mb-3" style="cursor:pointer" 
             onclick="openInterviewModal({{ json_encode([
                 'title' => $job ? $job->title : 'Interview',
                 'date' => $interview->get_date->format('M d, Y'),
                 'time' => $interview->get_date->format('h:i A'),
                 'duration' => '60 minutes',
                 'status' => ucfirst($interview->status),
                 'notes' => $interview->presentation_notes,
                 'panel' => $visiblePanels->map(fn($p) => [
                     'name' => $p->user->name,
                     'role' => $p->user->role
                 ])->values()
             ]) }})">
          <div class="row align-items-start g-4">
            <div class="col-md-8">
              <div class="d-flex align-items-start gap-3">
                <div class="stat-icon-wrap" style="background:rgba(245,197,66,0.12);color:var(--primary);width:48px;height:48px;flex-shrink:0">
                  <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2M5 21H3"/></svg>
                </div>
                <div>
                  <h4 style="font-size:16px;font-weight:700;margin:0 0 4px">{{ $job ? $job->title : 'Interview Session' }}</h4>
                  <div class="d-flex flex-wrap gap-2">
                    <span class="cp-badge badge-blue">Technical</span>
                    <span class="cp-badge badge-purple">Video Call</span>
                    <span class="cp-badge badge-exam">{{ ucfirst($interview->status) }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 text-md-end">
              <div class="info-row justify-content-md-end mb-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:var(--primary)"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <span style="font-weight:600">{{ $interview->get_date->format('M d, Y') }}</span>
              </div>
              <div class="info-row justify-content-md-end mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <span>{{ $interview->get_date->format('h:i A') }} &nbsp;(60 minutes)</span>
              </div>
              <button onclick="event.stopPropagation(); this.parentElement.parentElement.parentElement.click()" class="btn-cp btn-primary-cp btn-cp-sm">
                View Details
              </button>
            </div>
          </div>

          @if($interview->presentation_notes)
          <div class="mt-3 p-3 rounded-3" style="background:var(--secondary)">
            <p style="font-size:11px;color:var(--muted-fg);margin:0 0 4px;font-weight:500;text-transform:uppercase;letter-spacing:.04em">Presentation Notes</p>
            <p style="font-size:13px;color:#d1d5db;margin:0">{{ $interview->presentation_notes }}</p>
          </div>
          @endif

          <div class="mt-3">
            @if($interview->status === \App\Models\Interview::STATUS_SCHEDULED)
                @php
                    $tz = $interview->slot->time_zone ?? config('app.timezone');
                    $slotDate = \Carbon\Carbon::parse($interview->slot->date)->format('Y-m-d');
                    $startTime = \Carbon\Carbon::parse($slotDate . ' ' . $interview->slot->start_time, $tz);
                    $endTime = \Carbon\Carbon::parse($slotDate . ' ' . $interview->slot->end_time, $tz);
                    $isActive = now()->between($startTime->subMinutes(5), $endTime);
                @endphp
                
                @if($isActive)
                    <a href="{{ route('session.show', ['interview' => $interview->id]) }}" class="btn-cp btn-primary-cp btn-cp-sm" style="text-decoration:none">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.55-2.07A1 1 0 0121 8.82v6.36a1 1 0 01-1.45.89L15 14M3 8a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg>
                      Join Session
                    </a>
                @else
                    <button class="btn-cp btn-secondary-cp btn-cp-sm" disabled title="Available 5 mins before start until end time" style="opacity:0.6; cursor:not-allowed">
                      Join Session (Available soon)
                    </button>
                @endif
            @else
                <span style="font-size:13px;color:var(--muted-fg);display:inline-flex;align-items:center;gap:6px">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.55-2.07A1 1 0 0121 8.82v6.36a1 1 0 01-1.45.89L15 14M3 8a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg>
                  Session {{ ucfirst($interview->status) }}
                </span>
            @endif
          </div>
        </div>
      @empty
        <div class="cp-card p-4 text-center">
            <p class="text-muted-cp mb-0">No scheduled interviews yet.</p>
        </div>
      @endforelse
    </div>

    <!-- Preparation checklist -->
    <!-- <div class="cp-card p-4">
      <h4 style="font-size:15px;font-weight:600;margin-bottom:16px">Interview Preparation Checklist</h4>
      <div class="d-flex flex-column gap-2">
        <label class="d-flex align-items-center gap-3" style="cursor:pointer;font-size:14px;color:#d1d5db">
          <input type="checkbox" checked style="accent-color:var(--primary);width:16px;height:16px">
          Review your resume and be ready to walk through each role
        </label>
        <label class="d-flex align-items-center gap-3" style="cursor:pointer;font-size:14px;color:#d1d5db">
          <input type="checkbox" checked style="accent-color:var(--primary);width:16px;height:16px">
          Prepare 2–3 examples of complex problems you have solved
        </label>
        <label class="d-flex align-items-center gap-3" style="cursor:pointer;font-size:14px;color:#d1d5db">
          <input type="checkbox" style="accent-color:var(--primary);width:16px;height:16px">
          Study React performance optimization patterns
        </label>
        <label class="d-flex align-items-center gap-3" style="cursor:pointer;font-size:14px;color:#d1d5db">
          <input type="checkbox" style="accent-color:var(--primary);width:16px;height:16px">
          Review system design fundamentals (scalability, caching, databases)
        </label>
        <label class="d-flex align-items-center gap-3" style="cursor:pointer;font-size:14px;color:#d1d5db">
          <input type="checkbox" style="accent-color:var(--primary);width:16px;height:16px">
          Read TechCorp's engineering blog and recent product announcements
        </label>
        <label class="d-flex align-items-center gap-3" style="cursor:pointer;font-size:14px;color:#d1d5db">
          <input type="checkbox" style="accent-color:var(--primary);width:16px;height:16px">
          Test your camera, microphone, and internet connection
        </label>
        <label class="d-flex align-items-center gap-3" style="cursor:pointer;font-size:14px;color:#d1d5db">
          <input type="checkbox" style="accent-color:var(--primary);width:16px;height:16px">
          Prepare thoughtful questions to ask the interviewers
        </label>
      </div> -->
    </div>

@endsection

@push('scripts')
<script>
// Opens the interview detail modal with full information
// This is a UI-only modal — no data manipulation
function openInterviewModal(data) {
  let panelHtml = '';
  data.panel.forEach(member => {
    let initials = member.name.split(' ').map(n => n[0]).join('');
    panelHtml += `
      <div class="d-flex align-items-center gap-2">
        <div style="width:32px;height:32px;border-radius:50%;background:var(--secondary);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600">${initials}</div>
        <div>
          <p style="font-size:13px;font-weight:500;margin:0">${member.name}</p>
          <p class="text-muted-cp" style="font-size:12px;margin:0">${member.role}</p>
        </div>
      </div>`;
  });

  openModal(
    '<div class="p-4">' +
      '<div class="d-flex align-items-start justify-content-between gap-3 mb-3">' +
        '<div><h5 class="fw-bold mb-1">' + data.title + '</h5><p class="text-muted-cp mb-0" style="font-size:13px">CareerPortal Scheduling</p></div>' +
        '<button onclick="closeModal()" class="btn-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>' +
      '</div>' +
      '<div class="d-flex gap-2 mb-3"><span class="cp-badge badge-blue">Technical</span><span class="cp-badge badge-purple">Video Call</span><span class="cp-badge badge-exam">' + data.status + '</span></div>' +
      '<div class="row g-2 mb-3">' +
        '<div class="col-6"><div class="p-2 rounded-3" style="background:var(--secondary)"><p class="text-muted-cp mb-0" style="font-size:11px">Date</p><p class="fw-semibold mb-0" style="font-size:13px">' + data.date + '</p></div></div>' +
        '<div class="col-6"><div class="p-2 rounded-3" style="background:var(--secondary)"><p class="text-muted-cp mb-0" style="font-size:11px">Time</p><p class="fw-semibold mb-0" style="font-size:13px">' + data.time + '</p></div></div>' +
        '<div class="col-6"><div class="p-2 rounded-3" style="background:var(--secondary)"><p class="text-muted-cp mb-0" style="font-size:11px">Duration</p><p class="fw-semibold mb-0" style="font-size:13px">' + data.duration + '</p></div></div>' +
        '<div class="col-6"><div class="p-2 rounded-3" style="background:var(--secondary)"><p class="text-muted-cp mb-0" style="font-size:11px">Format</p><p class="fw-semibold mb-0" style="font-size:13px">Video Call</p></div></div>' +
      '</div>' +
      '<p style="font-size:13px;font-weight:600;margin-bottom:8px">Interviewers</p>' +
      '<div class="d-flex flex-column gap-2 mb-3">' + panelHtml + '</div>' +
      (data.notes ? '<div class="p-3 rounded-3 mb-3" style="background:var(--secondary)"><p style="font-size:12px;color:var(--muted-fg);margin-bottom:4px">Preparation Notes</p><p style="font-size:13px;margin:0;color:#d1d5db">' + data.notes + '</p></div>' : '') +
      '<button class="btn-cp btn-primary-cp w-100 justify-content-center" disabled>' +
        '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.55-2.07A1 1 0 0121 8.82v6.36a1 1 0 01-1.45.89L15 14M3 8a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg>' +
        ' Join Meeting (Available soon)' +
      '</button>' +
    '</div>'
  );
}
</script>
@endpush
