@extends('layouts.app')

@section('title', 'Exams — Bridges')
@section('header-title', 'Assessment')

@section('sidebar')
    @include('layouts.partials.candidate_sidebar')
@endsection
 
@section('header-actions-prefix')
<button class="btn-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg></button>
@endsection

@section('content')
    <div class="mb-4">
      <h2 class="section-title">Exams &amp; Assessments</h2>
      <p class="section-sub">Complete your technical assessment to advance to the interview stage.</p>
    </div>

    @php
      $stage = $currentStage ?? null;
      // Allow taking the exam if in technical_test, applied, or shortlisted stages
      $isReadyToTake = in_array($stage, ['technical_test', 'applied', 'shortlisted']) && $activeApplication;
      $hasPassed = in_array($stage, ['interview', 'offer', 'hired']);
    @endphp

    @if($isReadyToTake)
    {{-- ── ACTIVE: CV passed, exam available ─────────────────────────────── --}}
    <div class="cp-card p-4 mb-4 bg-primary-soft">
      <div class="d-flex align-items-center gap-3">
        <div class="stat-icon-wrap" style="background:rgba(245,197,66,0.2);color:var(--primary);width:44px;height:44px;flex-shrink:0">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
        </div>
        <div>
          <p style="font-size:14px;font-weight:600;margin:0">Your CV Passed the Screening!</p>
          <p class="text-muted-cp" style="font-size:13px;margin:0">You are now eligible to take the technical assessment below.</p>
        </div>
      </div>
    </div>

    {{-- Exam breakdown cards --}}
    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <div class="cp-card p-4 text-center">
          <div style="font-size:28px;font-weight:800;color:var(--primary);line-height:1">{{ $activeApplication->job->questionBanks->sum('points') ?? 0 }}</div>
          <p class="text-muted-cp mb-0" style="font-size:13px;margin-top:4px">Total Points</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="cp-card p-4 text-center">
          <div style="font-size:28px;font-weight:800;color:var(--primary);line-height:1">{{ $activeApplication->job->questionBanks->count() ?? 0 }}</div>
          <p class="text-muted-cp mb-0" style="font-size:13px;margin-top:4px">Questions</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="cp-card p-4 text-center">
          <div style="font-size:28px;font-weight:800;color:var(--primary);line-height:1">45</div>
          <p class="text-muted-cp mb-0" style="font-size:13px;margin-top:4px">Minutes</p>
        </div>
      </div>
    </div>

    {{-- Breakdown --}}
    <div class="cp-card p-4 mb-4">
      <h5 class="fw-semibold mb-3" style="font-size:15px">Exam Structure</h5>
      <div class="row g-3">
        <div class="col-md-4">
          <div class="p-3 rounded-3" style="background:var(--secondary)">
            <div class="d-flex justify-content-between mb-1"><span style="font-size:13px;color:var(--muted-fg)">Multiple Choice</span><span style="font-size:13px;font-weight:600">60 pts</span></div>
            <div class="cp-progress-track"><div class="cp-progress-bar" style="width:60%"></div></div>
            <p class="text-muted-cp mt-1 mb-0" style="font-size:11px">3 questions · 20 pts each</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-3 rounded-3" style="background:var(--secondary)">
            <div class="d-flex justify-content-between mb-1"><span style="font-size:13px;color:var(--muted-fg)">Written</span><span style="font-size:13px;font-weight:600">30 pts</span></div>
            <div class="cp-progress-track"><div class="cp-progress-bar accent" style="width:30%"></div></div>
            <p class="text-muted-cp mt-1 mb-0" style="font-size:11px">2 questions · 15 pts each</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-3 rounded-3" style="background:var(--secondary)">
            <div class="d-flex justify-content-between mb-1"><span style="font-size:13px;color:var(--muted-fg)">Coding</span><span style="font-size:13px;font-weight:600">10 pts</span></div>
            <div class="cp-progress-track"><div class="cp-progress-bar blue" style="width:10%"></div></div>
            <p class="text-muted-cp mt-1 mb-0" style="font-size:11px">1 question · 10 pts</p>
          </div>
        </div>
      </div>
    </div>

    {{-- Instructions --}}
    <div class="p-3 rounded-3 mb-4" style="background:var(--secondary);border:1px solid var(--border)">
      <p style="font-size:13px;font-weight:600;margin:0 0 10px">Before you begin:</p>
      <div class="d-flex flex-column gap-2">
        @foreach(['All questions are on one scrollable page — answer in any order.', 'A passing score is 70 out of 100.', 'Do not refresh or leave the page once the exam has started.'] as $tip)
        <div class="d-flex align-items-start gap-2" style="font-size:13px;color:#d1d5db">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:var(--primary);flex-shrink:0;margin-top:2px"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
          {{ $tip }}
        </div>
        @endforeach
      </div>
    </div>

    <div class="d-flex gap-2">
      <a href="{{ route('candidate.exam-template') }}" class="btn-cp btn-primary-cp">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
        Begin Assessment
      </a>
      <a href="{{ route('candidate.overview') }}" class="btn-cp btn-outline-cp">Back to Dashboard</a>
    </div>

    @elseif($hasPassed)
    {{-- ── PASSED: Show availability manager ─────────────────────────────── --}}
    <div class="cp-card p-4 mb-4" style="background:rgba(52,211,153,0.05); border:1px solid rgba(52,211,153,0.2)">
      <div class="d-flex align-items-center gap-3">
        <div class="stat-icon-wrap" style="background:rgba(52,211,153,0.15);color:#34d399;width:48px;height:48px;flex-shrink:0">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div>
          <h4 style="font-size:16px;font-weight:700;margin:0;color:#34d399">Assessment Successfully Completed</h4>
          <p class="text-muted-cp mt-1 mb-0" style="font-size:13px">You have passed the technical stage! Please ensure your availability is up to date.</p>
        </div>
      </div>
    </div>

    <div class="cp-card p-5 text-center mb-4">
      <div style="width:64px;height:64px;border-radius:50%;background:rgba(59,130,246,0.1);display:flex;align-items:center;justify-content:center;margin:0 auto 20px">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="#3b82f6" stroke-width="1.5">
          <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
      </div>
      <h4 style="font-size:18px;font-weight:700;margin-bottom:12px">Manage Interview Availability</h4>
      <p class="text-muted-cp" style="font-size:14px;max-width:480px;margin:0 auto 24px;line-height:1.6">
        Click the button below to view or update your available time slots for the upcoming interview. 
        Providing multiple windows helps us schedule you faster.
      </p>
      <button onclick="showUpdateAvailabilityModal()" class="btn-cp btn-primary-cp" style="margin: 0 auto">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Update Availability Slots
      </button>
    </div>

    @else
    {{-- ── EMPTY STATE ──────────────────────────────────────────────────── --}}
    <div class="cp-card p-5 text-center mb-4" style="border:2px dashed var(--border)">
      <div style="width:64px;height:64px;border-radius:50%;background:rgba(var(--primary-rgb),0.1);display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="var(--primary)" stroke-width="1.5">
          <rect x="2" y="7" width="20" height="14" rx="2"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/>
        </svg>
      </div>
      <h4 style="font-size:17px;font-weight:700;margin-bottom:8px">No Assessment Found</h4>
      <p class="text-muted-cp" style="font-size:14px;max-width:420px;margin:0 auto 24px;line-height:1.6">
        You do not have any technical assessments available at this time.
        Once you apply for a job and your CV passes the screening, your assessment will appear here.
      </p>
      <a href="{{ route('candidate.overview') }}" class="btn-cp btn-outline-cp" style="justify-content:center">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        Back to Dashboard
      </a>
    </div>

    {{-- Pipeline reminder --}}
    <div class="cp-card p-4" style="opacity:.45;pointer-events:none">
      <p class="text-muted-cp mb-3" style="font-size:12px;text-transform:uppercase;letter-spacing:.05em;font-weight:500">Your Pipeline</p>
      <div style="position:relative;padding:0 16px">
        <div class="d-flex justify-content-between" style="position:relative;z-index:1">
          <div class="pipeline-step"><div class="step-circle done"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></div><span class="step-label done">Applied</span></div>
          <div class="pipeline-line done"></div>
          <div class="pipeline-step"><div class="step-circle active">2</div><span class="step-label active">Exam</span></div>
          <div class="pipeline-line"></div>
          <div class="pipeline-step"><div class="step-circle">3</div><span class="step-label">Interview</span></div>
          <div class="pipeline-line"></div>
          <div class="pipeline-step"><div class="step-circle">4</div><span class="step-label">Offer</span></div>
        </div>
      </div>
    </div>
    @endif
@endsection

@push('scripts')
<script>
let windows = [];

function showUpdateAvailabilityModal() {
  const modal = document.getElementById('availability-modal');
  modal.classList.remove('hidden');
  renderWindows();
}

function closeAvailabilityModal() {
  document.getElementById('availability-modal').classList.add('hidden');
}

function addWindow() {
  if (windows.length >= 7) return;
  windows.push({
    date: new Date().toISOString().split('T')[0],
    start_time: '09:00',
    end_time: '10:00',
    time_zone: Intl.DateTimeFormat().resolvedOptions().timeZone
  });
  renderWindows();
}

function removeWindow(index) {
  windows.splice(index, 1);
  renderWindows();
}

function updateWindow(index, field, value) {
  windows[index][field] = value;
}

function renderWindows() {
  const container = document.getElementById('windows-container');
  if (windows.length === 0) {
    container.innerHTML = '<div class="text-center p-4 text-slate-500 text-sm">No slots added yet. Click "+" to add one.</div>';
    return;
  }
  
  container.innerHTML = windows.map((w, i) => `
    <div class="flex flex-wrap gap-2 items-end p-3 bg-slate-900/50 rounded-xl border border-slate-700/50 mb-2">
      <div class="flex-1 min-w-[120px]">
        <label class="text-[10px] text-slate-500 font-bold uppercase mb-1 block">Date</label>
        <input type="date" value="${w.date}" onchange="updateWindow(${i}, 'date', this.value)" class="w-full bg-slate-800 border border-slate-700 rounded-lg text-xs p-2 text-white">
      </div>
      <div class="flex-1 min-w-[80px]">
        <label class="text-[10px] text-slate-500 font-bold uppercase mb-1 block">Start</label>
        <input type="time" value="${w.start_time}" onchange="updateWindow(${i}, 'start_time', this.value)" class="w-full bg-slate-800 border border-slate-700 rounded-lg text-xs p-2 text-white">
      </div>
      <div class="flex-1 min-w-[80px]">
        <label class="text-[10px] text-slate-500 font-bold uppercase mb-1 block">End</label>
        <input type="time" value="${w.end_time}" onchange="updateWindow(${i}, 'end_time', this.value)" class="w-full bg-slate-800 border border-slate-700 rounded-lg text-xs p-2 text-white">
      </div>
      <div class="flex-1 min-w-[120px]">
        <label class="text-[10px] text-slate-500 font-bold uppercase mb-1 block">Time Zone</label>
        <select onchange="updateWindow(${i}, 'time_zone', this.value)" class="w-full bg-slate-800 border border-slate-700 rounded-lg text-[10px] p-2 text-white">
          <option value="UTC" ${w.time_zone === 'UTC' ? 'selected' : ''}>UTC</option>
          <option value="GMT" ${w.time_zone === 'GMT' ? 'selected' : ''}>GMT</option>
          <option value="EST" ${w.time_zone === 'EST' ? 'selected' : ''}>EST</option>
          <option value="PST" ${w.time_zone === 'PST' ? 'selected' : ''}>PST</option>
          <option value="CET" ${w.time_zone === 'CET' ? 'selected' : ''}>CET</option>
          <option value="IST" ${w.time_zone === 'IST' ? 'selected' : ''}>IST</option>
          <option value="${Intl.DateTimeFormat().resolvedOptions().timeZone}" selected>${Intl.DateTimeFormat().resolvedOptions().timeZone}</option>
        </select>
      </div>
      <button onclick="removeWindow(${i})" class="p-2 text-red-400 hover:bg-red-500/10 rounded-lg transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
      </button>
    </div>
  `).join('');
}

async function submitAvailability() {
  if (windows.length === 0) {
    alert('Please add at least one availability slot.');
    return;
  }

  const btn = document.getElementById('submit-avail-btn');
  btn.disabled = true;
  btn.innerText = 'Saving...';

  try {
    const response = await fetch("{{ route('candidate.exam.availability') }}", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ windows })
    });

    const data = await response.json();
    if (data.success) {
      alert('Availability saved successfully!');
      location.reload();
    } else {
      alert('Error: ' + (data.error || 'Failed to save availability.'));
    }
  } catch (err) {
    alert('Failed to connect to server.');
  } finally {
    btn.disabled = false;
    btn.innerText = 'Submit Availability';
  }
}
</script>

<!-- Modal Template -->
<div id="availability-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm hidden">
  <div class="bg-slate-800 border border-slate-700 w-full max-w-xl rounded-3xl overflow-hidden shadow-2xl">
    <div class="p-6 border-b border-slate-700 flex justify-between items-center">
      <div>
        <h3 class="text-xl font-bold text-white">Your Availability</h3>
        <p class="text-slate-400 text-xs mt-1">Provide up to 7 preferred time slots for your interview.</p>
      </div>
      <button onclick="closeAvailabilityModal()" class="text-slate-500 hover:text-white transition-all">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
      </button>
    </div>
    <div class="p-6">
      <div id="windows-container" class="max-h-[300px] overflow-y-auto mb-4">
        <!-- Windows injected here -->
      </div>
      <button onclick="addWindow()" class="w-full py-3 border-2 border-dashed border-slate-700 rounded-2xl text-slate-500 hover:border-blue-500/50 hover:text-blue-400 transition-all flex items-center justify-center gap-2 font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        Add Time Slot
      </button>
    </div>
    <div class="p-6 bg-slate-800/50 border-t border-slate-700 flex justify-end gap-3">
      <button onclick="closeAvailabilityModal()" class="px-6 py-2.5 rounded-xl text-slate-400 hover:text-white font-bold transition-all">Cancel</button>
      <button id="submit-avail-btn" onclick="submitAvailability()" class="px-8 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold transition-all shadow-lg shadow-blue-600/20">
        Submit Availability
      </button>
    </div>
  </div>
</div>
@endpush
