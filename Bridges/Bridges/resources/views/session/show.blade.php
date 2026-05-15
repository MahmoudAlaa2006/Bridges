@extends('layouts.app')

@section('title', 'Interview Session — CareerPortal')

@push('styles')
<style>
    .session-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }
    .video-placeholder {
        width: 100%;
        aspect-ratio: 16/9;
        background: #111827;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        border: 2px solid #374151;
    }
    .participant-label {
        position: absolute;
        bottom: 1rem;
        left: 1rem;
        background: rgba(0,0,0,0.6);
        padding: 0.25rem 0.75rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
    }
    .timer-badge {
        background: rgba(245, 197, 66, 0.15);
        color: var(--primary);
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-weight: 700;
        font-variant-numeric: tabular-nums;
    }
    .sidebar-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 1rem;
        padding: 1.5rem;
    }
</style>
@endpush

@section('content')
<div class="session-container">
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 fw-bold mb-0">{{ $interview->application->job->title ?? 'Interview Session' }}</h1>
            <p class="text-muted mb-0">Candidate: {{ $interview->user->name }}</p>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div id="sessionTimer" class="timer-badge">00:00:00</div>
            @if(Auth::user()->role === 'interviewer' || Auth::user()->role === 'HR employee')
                <form action="{{ route('session.end', $interview->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to end this session? Redirecting to feedback page...')">
                    @csrf
                    <button type="submit" class="btn-cp btn-danger-cp">End Session</button>
                </form>
            @endif
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Content (Mock Video Area) -->
        <div class="col-lg-8">
            <div class="video-placeholder mb-4">
                <div class="text-center">
                    <div class="mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" class="text-muted">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.55-2.07A1 1 0 0121 8.82v6.36a1 1 0 01-1.45.89L15 14M3 8a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
                        </svg>
                    </div>
                    <p class="text-muted">Interview in Progress (Virtual Meeting Interface)</p>
                    <span class="badge bg-success">Connection Secured</span>
                </div>
                <div class="participant-label">{{ $interview->user->name }} (Candidate)</div>
            </div>

            <!-- Panel Info -->
            <div class="sidebar-card">
                <h5 class="fw-bold mb-3">Interview Panel</h5>
                <div class="row g-3">
                    @foreach($interview->panels as $panel)
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-sm" style="width:32px; height:32px; background:var(--secondary); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:12px">
                                    {{ substr($panel->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="mb-0 fw-semibold small">{{ $panel->user->name }}</p>
                                    <p class="text-muted mb-0" style="font-size:10px">{{ ucfirst($panel->user->role) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="col-lg-4">
            <!-- Details Card -->
            <div class="sidebar-card mb-4">
                <h5 class="fw-bold mb-3">Session Details</h5>
                <div class="mb-3">
                    <label class="text-muted small">Job Description</label>
                    <p class="small">{{ Str::limit($interview->application->job->description ?? 'N/A', 150) }}</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Notes</label>
                    <p class="small fst-italic">{{ $interview->presentation_notes ?? 'No specific notes for this session.' }}</p>
                </div>
            </div>

            <!-- Extension Card (Interviewer only) -->
            @if(Auth::user()->role === 'interviewer')
                <div class="sidebar-card">
                    <h5 class="fw-bold mb-3 text-warning">Time Management</h5>
                    <p class="small text-muted mb-3">Need more time? Request an extension from HR Admins.</p>
                    
                    <form action="{{ route('session.extend', $interview->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <select name="minutes" class="form-select bg-dark text-white border-secondary">
                                <option value="5">5 Minutes</option>
                                <option value="10">10 Minutes</option>
                                <option value="15">15 Minutes</option>
                                <option value="30">30 Minutes</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <textarea name="reason" class="form-control bg-dark text-white border-secondary" placeholder="Reason (optional)" rows="2"></textarea>
                        </div>
                        <button type="submit" class="btn-cp btn-primary-cp w-100">Request Extension</button>
                    </form>

                    <div class="mt-3">
                        <label class="text-muted small d-block mb-2">Request History</label>
                        @forelse($interview->extensionRequests as $req)
                            <div class="p-2 rounded mb-2" style="background:var(--secondary); font-size:11px">
                                <span class="fw-bold">{{ $req->requested_minutes }}m</span> - 
                                <span class="badge {{ $req->status === 'approved' ? 'bg-success' : ($req->status === 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                    {{ ucfirst($req->status) }}
                                </span>
                                <p class="mb-0 mt-1 text-muted">{{ $req->created_at->diffForHumans() }}</p>
                            </div>
                        @empty
                            <p class="text-muted small italic">No requests sent yet.</p>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Simple mock timer
    let seconds = 0;
    const timerElement = document.getElementById('sessionTimer');
    
    setInterval(() => {
        seconds++;
        let hrs = Math.floor(seconds / 3600);
        let mins = Math.floor((seconds - (hrs * 3600)) / 60);
        let secs = seconds % 60;
        
        timerElement.textContent = 
            (hrs < 10 ? '0' + hrs : hrs) + ':' + 
            (mins < 10 ? '0' + mins : mins) + ':' + 
            (secs < 10 ? '0' + secs : secs);
    }, 1000);
</script>
@endpush