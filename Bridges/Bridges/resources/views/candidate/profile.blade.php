@php use Illuminate\Support\Facades\Storage; @endphp
@extends('layouts.app')

@section('title', 'Profile — CareerPortal')
@section('header-title', 'My Profile')

@section('sidebar')
    @include('layouts.partials.candidate_sidebar')
@endsection

@section('header-actions-prefix')
<button class="btn-icon">
  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg>
</button>
@endsection

@section('content')
@php
  // ── Resolve values from new schema ────────────────────────────────────────
  $fn          = $user?->first_name    ?? '';
  $ln          = $user?->last_name     ?? '';
  $fullName    = trim("$fn $ln") ?: 'Your Name';
  $initials    = strtoupper(substr($fn,0,1) . substr($ln,0,1)) ?: 'YN';
  $email       = $user?->email         ?? '';
  $age         = $user?->age           ?? null;
  $role        = $user?->role          ?? '';
  $stage       = $user?->current_stage ?? null;

  // Stage label map
  $stageLabels = [
      'technical_test' => 'Technical Test',
      'interview'      => 'Interview',
      'offer'          => 'Offer',
      'rejected'       => 'Rejected',
  ];
  $stageColors = [
      'technical_test' => '#f59e0b',
      'interview'      => '#3b82f6',
      'offer'          => '#4ade80',
      'rejected'       => '#f87171',
  ];
@endphp

    <div class="mb-4">
      <h2 class="section-title">My Profile</h2>
      <p class="section-sub">Manage your personal information and application materials.</p>
    </div>

    {{-- Success flash --}}
    @if (session('saved'))
      <div class="mb-4 p-3 rounded-3 d-flex align-items-center gap-2"
           style="background:rgba(74,222,128,0.1);border:1px solid rgba(74,222,128,0.3);font-size:13px;color:#4ade80">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        Profile updated successfully.
      </div>
    @endif

    @if (!$user)
      {{-- No account yet --}}
      <div class="cp-card p-5 text-center mb-4" style="border:2px dashed var(--border)">
        <h4 style="font-size:16px;font-weight:700;margin-bottom:8px">No profile yet</h4>
        <p class="text-muted-cp" style="font-size:14px;max-width:380px;margin:0 auto 20px">
          Apply to a job first — your profile is created automatically from your application data.
        </p>
        <a href="{{ route('candidate.jobs') }}" class="btn-cp btn-primary-cp" style="justify-content:center">Browse Jobs</a>
      </div>
    @else

    <div class="row g-4">
      {{-- ── Left column ─────────────────────────────────────────────────── --}}
      <div class="col-lg-4">

        {{-- Profile card --}}
        <div class="cp-card p-4 mb-3 text-center">
          <div style="width:80px;height:80px;border-radius:50%;background:var(--primary);color:var(--primary-fg);
                      display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:700;margin:0 auto 16px">
            {{ $initials }}
          </div>
          <h3 style="font-size:18px;font-weight:700;margin:0 0 4px">{{ $fullName }}</h3>
          <p class="text-muted-cp" style="font-size:14px;margin:0 0 12px">{{ $role ?: 'Candidate' }}</p>

          {{-- Current stage badge --}}
          @if ($stage)
            <div class="mb-3">
              <span style="display:inline-flex;align-items:center;gap:5px;font-size:12px;font-weight:600;
                           color:{{ $stageColors[$stage] ?? '#a1a1aa' }};
                           background:{{ $stageColors[$stage] ?? '#a1a1aa' }}18;
                           border:1px solid {{ $stageColors[$stage] ?? '#a1a1aa' }}40;
                           border-radius:20px;padding:4px 12px">
                <span style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block"></span>
                {{ $stageLabels[$stage] ?? ucfirst($stage) }}
              </span>
            </div>
          @endif

          <button onclick="openEditModal()" class="btn-cp btn-secondary-cp w-100 justify-content-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
              <path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
            Edit Profile
          </button>
        </div>

        {{-- CV --}}
        <div class="cp-card p-4">
          <h4 style="font-size:14px;font-weight:600;margin-bottom:12px">Resume / CV</h4>
          @if ($cvPath)
            @php $cvUrl = Storage::disk('public')->url($cvPath); @endphp
            <a href="{{ $cvUrl }}" target="_blank" rel="noopener"
               class="d-flex align-items-center gap-3 mb-3 p-3 text-decoration-none"
               style="background:var(--secondary);border-radius:8px;border:1px solid var(--border);transition:border-color .2s"
               onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border)'">
              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="color:var(--primary);flex-shrink:0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
              </svg>
              <div class="flex-grow-1 overflow-hidden">
                <p style="font-size:13px;font-weight:600;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:#fff">{{ $cvFileName }}</p>
                @if ($cvUploadedAt)
                  <p class="text-muted-cp" style="font-size:11px;margin:0">Uploaded {{ $cvUploadedAt }}</p>
                @endif
              </div>
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:var(--primary);flex-shrink:0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
              </svg>
            </a>
            <p class="text-muted-cp mb-0" style="font-size:11px">Click the file above to preview. It updates each time you apply.</p>
          @else
            <div class="d-flex align-items-center gap-3 p-3" style="background:var(--secondary);border-radius:8px;border:1px solid var(--border)">
              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="color:var(--border)">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
              </svg>
              <div>
                <p style="font-size:13px;font-weight:600;margin:0;color:var(--muted-fg)">No CV uploaded yet</p>
                <p class="text-muted-cp" style="font-size:11px;margin:0">Apply to a job with a CV to see it here</p>
              </div>
            </div>
          @endif
        </div>

      </div>

      {{-- ── Right column ─────────────────────────────────────────────────── --}}
      <div class="col-lg-8">

        {{-- Personal Info --}}
        <div class="cp-card p-4 mb-3">
          <h4 style="font-size:15px;font-weight:600;margin-bottom:16px">Personal Information</h4>
          <div class="row g-3">
            <div class="col-sm-6">
              <p class="cp-label" style="font-size:11px;text-transform:uppercase;letter-spacing:.05em;color:var(--muted-fg)">Full Name</p>
              <p style="font-size:14px;font-weight:500;margin:0">{{ $fullName }}</p>
            </div>
            <div class="col-sm-6">
              <p class="cp-label" style="font-size:11px;text-transform:uppercase;letter-spacing:.05em;color:var(--muted-fg)">Email</p>
              <p style="font-size:14px;font-weight:500;margin:0">{{ $email ?: '—' }}</p>
            </div>
            <div class="col-sm-6">
              <p class="cp-label" style="font-size:11px;text-transform:uppercase;letter-spacing:.05em;color:var(--muted-fg)">Age</p>
              <p style="font-size:14px;font-weight:500;margin:0">{{ $age !== null ? $age . ' years old' : '—' }}</p>
            </div>
            <div class="col-sm-6">
              <p class="cp-label" style="font-size:11px;text-transform:uppercase;letter-spacing:.05em;color:var(--muted-fg)">Role</p>
              <p style="font-size:14px;font-weight:500;margin:0">{{ $role ?: '—' }}</p>
            </div>
            @if ($stage)
            <div class="col-sm-6">
              <p class="cp-label" style="font-size:11px;text-transform:uppercase;letter-spacing:.05em;color:var(--muted-fg)">Current Stage</p>
              <p style="font-size:14px;font-weight:500;margin:0;color:{{ $stageColors[$stage] ?? 'inherit' }}">
                {{ $stageLabels[$stage] ?? ucfirst($stage) }}
              </p>
            </div>
            @endif
          </div>
        </div>

      </div>
    </div>

    {{-- Hidden edit form template --}}
    <div id="edit-form-tpl" style="display:none">
      <div class="p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
          <h5 class="fw-semibold mb-0">Edit Profile</h5>
          <button onclick="closeModal()" class="btn-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
          </button>
        </div>
        <form id="profile-form" method="POST" action="{{ route('candidate.profile.update') }}">
@php
  $saved = session('saved');
@endphp
          @csrf
          <div class="row g-3">
            <div class="col-sm-6">
              <label class="cp-label">First Name</label>
              <input class="cp-input" name="first_name" value="{{ e($fn) }}" placeholder="First name">
            </div>
            <div class="col-sm-6">
              <label class="cp-label">Last Name</label>
              <input class="cp-input" name="last_name" value="{{ e($ln) }}" placeholder="Last name">
            </div>
            <div class="col-sm-6">
              <label class="cp-label">Email</label>
              <input class="cp-input" name="email" type="email" value="{{ e($email) }}" placeholder="you@email.com">
            </div>
            <div class="col-sm-6">
              <label class="cp-label">Age</label>
              <input class="cp-input" name="age" type="number" min="16" max="100"
                     value="{{ $age ?? '' }}" placeholder="28">
            </div>
          </div>
          <div class="d-flex gap-2 mt-4">
            <button type="button" onclick="closeModal()" class="btn-cp btn-outline-cp flex-fill justify-content-center">
              Cancel
            </button>
            <button type="submit" class="btn-cp btn-primary-cp flex-fill justify-content-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
              </svg>
              Save Changes
            </button>
          </div>
        </form>
      </div>
    </div>
    @endif

@endsection

@push('scripts')
<script>
function openEditModal() {
  const tpl = document.getElementById('edit-form-tpl');
  if (!tpl) return;
  openModal(tpl.innerHTML);
}
</script>
@endpush
