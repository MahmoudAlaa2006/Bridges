@extends('layouts.app')

@section('title', 'Interview — Bridges')
@section('header-title', 'Scheduled Interviews')

@section('sidebar')
    @include('layouts.partials.candidate_sidebar')
@endsection

@section('content')
    <div class="mb-4">
      <h2 class="section-title">Scheduled Interviews</h2>
      <p class="section-sub">Your upcoming interviews and session links.</p>
    </div>

    @forelse($interviews as $interview)
    <div class="cp-card p-6 mb-4" style="border-left: 4px solid var(--primary)">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="d-flex align-items-center mb-2">
                    <span class="badge-cp bg-primary-cp text-white mr-2" style="font-size: 10px; padding: 2px 8px">LIVE SESSION</span>
                    <h3 class="font-bold" style="font-size: 18px">Interview with Bridges Panel</h3>
                </div>
                <p class="text-muted-cp text-sm mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:inline; margin-top:-2px" class="mr-1"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    {{ $interview->get_date->format('l, F jS \a\t H:i') }}
                </p>
                <div class="d-flex align-items-center text-xs text-muted-cp">
                    <span class="mr-3">Panel: {{ $interview->panels->count() }} members</span>
                    <span>Duration: 60 mins</span>
                </div>
            </div>
            
            @if(!$interview->is_finish)
                <a href="{{ route('session.show', $interview) }}" class="btn-cp btn-primary-cp px-6">
                    Join Session
                </a>
            @else
                <button disabled class="btn-cp btn-outline-cp" style="opacity: 0.5; cursor: not-allowed">
                    Completed
                </button>
            @endif
        </div>
    </div>
    @empty
        @if($availability && $availability->count() > 0)
            {{-- ── PENDING: Availability submitted, awaiting HR scheduling ── --}}
            <div class="cp-card p-6 mb-4" style="border-left: 4px solid var(--primary); background: rgba(245,197,66,0.05)">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge-cp bg-warning text-dark mr-2" style="font-size: 10px; padding: 2px 8px; background:#f5c542">WAITING FOR CONFIRMATION</span>
                            <h3 class="font-bold" style="font-size: 18px; color:#f5c542">Interview Scheduling in Progress</h3>
                        </div>
                        <p class="text-muted-cp text-sm mb-3">
                            You have submitted {{ $availability->count() }} availability slots. Our team is coordinating with the interviewers.
                        </p>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($availability->take(3) as $slot)
                                <div style="background:var(--secondary); padding:4px 10px; border-radius:8px; font-size:11px; border:1px solid var(--border)">
                                    {{ \Carbon\Carbon::parse($slot->date)->format('M d') }} @ {{ $slot->start_time }}
                                </div>
                            @endforeach
                            @if($availability->count() > 3)
                                <div style="font-size:11px; color:var(--muted-fg); align-self:center">+{{ $availability->count() - 3 }} more</div>
                            @endif
                        </div>
                    </div>
                    <div class="text-center" style="max-width: 150px">
                        <div style="font-size:24px; color:#f5c542">⌛</div>
                        <p style="font-size:10px; color:var(--muted-fg); margin-top:5px">We will notify you once a slot is finalized.</p>
                    </div>
                </div>
            </div>
        @else
            {{-- ── AVAILABILITY FORM ─────────────────────────────────────────── --}}
            <div class="cp-card p-5 mb-4" id="availability-form-card">
                <div class="mb-4">
                    <h3 style="font-size:17px;font-weight:700;margin-bottom:6px">📅 Submit Your Availability</h3>
                    <p class="text-muted-cp" style="font-size:13px;line-height:1.6">
                        You passed the technical exam — great work! Please add between <strong style="color:#fff">1 and 7</strong>
                        preferred interview slots below. Our team will confirm a time with you shortly.
                    </p>
                </div>

                <div id="window-list" style="display:flex;flex-direction:column;gap:12px"></div>

                <button type="button" id="add-window-btn" class="btn-cp btn-outline-cp mt-3"
                        style="font-size:13px;gap:6px">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add Time Slot
                </button>

                <div id="avail-error" style="display:none;margin-top:12px;padding:10px 14px;border-radius:8px;
                     background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);
                     color:#f87171;font-size:13px"></div>

                <div class="d-flex gap-3 mt-4 align-items-center">
                    <button type="button" id="save-avail-btn" class="btn-cp btn-primary-cp" style="font-size:14px">
                        Save Availability
                    </button>
                    <span id="avail-saving" style="display:none;font-size:12px;color:var(--muted-fg)">Saving…</span>
                </div>
            </div>

            {{-- Shown after successful submission (replaces the form) --}}
            <div id="avail-success-card" class="cp-card p-6 mb-4"
                 style="display:none;border-left:4px solid var(--primary);background:rgba(245,197,66,.05)">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="d-flex align-items-center mb-2">
                            <span style="font-size:10px;padding:2px 8px;background:#f5c542;color:#1a1625;
                                         border-radius:4px;font-weight:700;margin-right:8px">WAITING FOR CONFIRMATION</span>
                            <h3 style="font-size:18px;font-weight:700;color:#f5c542;margin:0">Interview Scheduling in Progress</h3>
                        </div>
                        <p class="text-muted-cp" style="font-size:13px;margin-bottom:0">
                            Your availability has been received. Our team will coordinate with the interviewers and confirm your slot soon.
                        </p>
                    </div>
                    <div class="text-center" style="max-width:140px">
                        <div style="font-size:28px">⌛</div>
                        <p style="font-size:10px;color:var(--muted-fg);margin-top:6px">We'll notify you once confirmed.</p>
                    </div>
                </div>
            </div>

            @push('scripts')
            <script>
            (function () {
            'use strict';

            /* ── constants ── */
            const MAX_WINDOWS = 7;
            const ROUTE = '{{ route("candidate.exam.availability") }}';
            const CSRF  = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

            /* ── DOM refs ── */
            const list     = document.getElementById('window-list');
            const addBtn   = document.getElementById('add-window-btn');
            const saveBtn  = document.getElementById('save-avail-btn');
            const errBox   = document.getElementById('avail-error');
            const saving   = document.getElementById('avail-saving');
            const formCard = document.getElementById('availability-form-card');
            const okCard   = document.getElementById('avail-success-card');

            /* Common IANA time zones (representative list) */
            const TZ_OPTIONS = [
                'Africa/Cairo','Africa/Nairobi','America/Chicago','America/Denver',
                'America/Los_Angeles','America/New_York','America/Sao_Paulo',
                'Asia/Baghdad','Asia/Bangkok','Asia/Dubai','Asia/Hong_Kong',
                'Asia/Jakarta','Asia/Karachi','Asia/Kolkata','Asia/Kuwait',
                'Asia/Manila','Asia/Riyadh','Asia/Seoul','Asia/Shanghai',
                'Asia/Singapore','Asia/Taipei','Asia/Tehran','Asia/Tokyo',
                'Atlantic/Azores','Australia/Melbourne','Australia/Sydney',
                'Europe/Amsterdam','Europe/Athens','Europe/Berlin','Europe/Brussels',
                'Europe/Helsinki','Europe/Istanbul','Europe/London','Europe/Madrid',
                'Europe/Moscow','Europe/Oslo','Europe/Paris','Europe/Rome',
                'Europe/Stockholm','Europe/Warsaw','Europe/Zurich',
                'Pacific/Auckland','Pacific/Honolulu','UTC'
            ];

            let count = 0;

            function tzOptions(selected) {
                return TZ_OPTIONS.map(tz =>
                    `<option value="${tz}"${tz === selected ? ' selected' : ''}>${tz.replace(/_/g,' ')}</option>`
                ).join('');
            }

            function addWindow() {
                if (count >= MAX_WINDOWS) return;
                count++;
                const localTz = Intl.DateTimeFormat().resolvedOptions().timeZone;
                const id = 'win-' + count;

                const row = document.createElement('div');
                row.id = id;
                row.style.cssText = 'background:var(--secondary);border:1px solid var(--border);border-radius:10px;padding:14px 16px;position:relative';
                row.innerHTML = `
                    <div style="font-size:11px;font-weight:600;color:var(--primary);text-transform:uppercase;
                                letter-spacing:.05em;margin-bottom:10px">Slot ${count}</div>
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr 2fr;gap:10px;align-items:end">
                        <div>
                            <label style="font-size:11px;color:var(--muted-fg);display:block;margin-bottom:4px">Date</label>
                            <input type="date" name="date" min="${new Date().toISOString().split('T')[0]}"
                                   style="width:100%;background:var(--bg);border:1px solid var(--border);border-radius:6px;
                                          padding:6px 10px;font-size:13px;color:#fff;outline:none" required>
                        </div>
                        <div>
                            <label style="font-size:11px;color:var(--muted-fg);display:block;margin-bottom:4px">Start Time</label>
                            <input type="time" name="start_time"
                                   style="width:100%;background:var(--bg);border:1px solid var(--border);border-radius:6px;
                                          padding:6px 10px;font-size:13px;color:#fff;outline:none" required>
                        </div>
                        <div>
                            <label style="font-size:11px;color:var(--muted-fg);display:block;margin-bottom:4px">End Time</label>
                            <input type="time" name="end_time"
                                   style="width:100%;background:var(--bg);border:1px solid var(--border);border-radius:6px;
                                          padding:6px 10px;font-size:13px;color:#fff;outline:none" required>
                        </div>
                        <div>
                            <label style="font-size:11px;color:var(--muted-fg);display:block;margin-bottom:4px">Time Zone</label>
                            <select name="time_zone"
                                    style="width:100%;background:var(--bg);border:1px solid var(--border);border-radius:6px;
                                           padding:6px 10px;font-size:13px;color:#fff;outline:none">
                                ${tzOptions(localTz)}
                            </select>
                        </div>
                    </div>
                    ${count > 1 ? `
                    <button type="button" onclick="removeWindow('${id}')"
                            style="position:absolute;top:10px;right:12px;background:none;border:none;
                                   color:var(--muted-fg);cursor:pointer;font-size:18px;line-height:1"
                            title="Remove slot">×</button>` : ''}
                `;
                list.appendChild(row);

                if (count >= MAX_WINDOWS) addBtn.style.display = 'none';
            }

            window.removeWindow = function(id) {
                const el = document.getElementById(id);
                if (el) { el.remove(); count--; }
                addBtn.style.display = '';
                // Re-number slot labels
                list.querySelectorAll('[id^="win-"]').forEach((row, i) => {
                    const lbl = row.querySelector('[style*="color:var(--primary)"]');
                    if (lbl) lbl.textContent = 'Slot ' + (i + 1);
                });
            };

            addBtn.addEventListener('click', addWindow);

            saveBtn.addEventListener('click', function () {
                errBox.style.display = 'none';

                const rows = list.querySelectorAll('[id^="win-"]');
                if (rows.length === 0) {
                    showError('Please add at least one availability slot.');
                    return;
                }

                const windows = [];
                let valid = true;

                rows.forEach(row => {
                    const date  = row.querySelector('[name="date"]').value;
                    const start = row.querySelector('[name="start_time"]').value;
                    const end   = row.querySelector('[name="end_time"]').value;
                    const tz    = row.querySelector('[name="time_zone"]').value;
                    if (!date || !start || !end) { valid = false; return; }
                    if (start >= end) { valid = false; showError('Start time must be before end time for all slots.'); return; }
                    windows.push({ date, start_time: start, end_time: end, time_zone: tz });
                });

                if (!valid) {
                    if (!errBox.textContent) showError('Please fill in all fields for every slot.');
                    return;
                }

                saveBtn.disabled = true;
                saving.style.display = '';

                fetch(ROUTE, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF
                    },
                    body: JSON.stringify({ windows })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        formCard.style.display = 'none';
                        okCard.style.display   = '';
                    } else {
                        showError(data.message || 'Something went wrong. Please try again.');
                        saveBtn.disabled = false;
                        saving.style.display = 'none';
                    }
                })
                .catch(() => {
                    showError('Network error. Please try again.');
                    saveBtn.disabled = false;
                    saving.style.display = 'none';
                });
            });

            function showError(msg) {
                errBox.textContent = msg;
                errBox.style.display = '';
            }

            // Start with one slot ready
            addWindow();
            })();
            </script>
            @endpush
        @endif

    @endforelse

    {{-- Pipeline reminder --}}
    <div class="cp-card p-4 mt-6" style="opacity:.6">
      <p class="text-muted-cp mb-3" style="font-size:12px;text-transform:uppercase;letter-spacing:.05em;font-weight:500">Your Pipeline</p>
      <div style="position:relative;padding:0 16px">
        <div class="d-flex justify-content-between" style="position:relative;z-index:1">
          <div class="pipeline-step"><div class="step-circle done"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg></div><span class="step-label done">Applied</span></div>
          <div class="pipeline-line done"></div>
          <div class="pipeline-step"><div class="step-circle done"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg></div><span class="step-label done">Exam</span></div>
          <div class="pipeline-line done"></div>
          <div class="pipeline-step"><div class="step-circle active">3</div><span class="step-label active">Interview</span></div>
          <div class="pipeline-line"></div>
          <div class="pipeline-step"><div class="step-circle">4</div><span class="step-label">Offer</span></div>
        </div>
      </div>
    </div>
@endsection
