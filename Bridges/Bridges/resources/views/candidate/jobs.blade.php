@extends('layouts.app')

@section('title', 'Browse Jobs — CareerPortal')
@section('header-title', 'Browse Jobs')

@section('sidebar')
    @include('layouts.partials.candidate_sidebar')
@endsection

@section('header-actions-prefix')
<div class="d-flex gap-2 align-items-center">
  <button class="btn-icon" onclick="document.getElementById('job-search-input').focus()" title="Search jobs">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg>
  </button>
  <button class="btn-icon" onclick="openCVUploadModal()" title="Upload CV for grading">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
  </button>
</div>
@endsection

@section('content')
    {{-- Header Section --}}
    <div class="mb-4">
      <h2 class="section-title">Browse Jobs</h2>
      <p class="section-sub">Discover open positions that match your skills and experience.</p>
    </div>

    {{-- CV Grade Card (if CV uploaded) --}}
    <div id="cv-grade-card" class="cp-card p-4 mb-4" style="display: none;">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3 flex-grow-1">
          <div class="cv-grade-badge" style="width:60px;height:60px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:bold;color:var(--primary-fg)">
            <span id="cv-grade-letter">—</span>
          </div>
          <div>
            <h6 class="mb-1" id="cv-grade-title">CV Grade: —</h6>
            <p class="text-muted-cp mb-0" style="font-size:13px">
              <span id="cv-grade-skills">0 skills found</span> • 
              <span id="cv-grade-experience">0 years exp</span>
            </p>
            <div id="cv-feedback-summary" style="font-size:12px;margin-top:6px"></div>
          </div>
        </div>
        <button class="btn-cp btn-secondary-cp btn-cp-sm" onclick="openCVUploadModal()">Update CV</button>
      </div>
    </div>

    {{-- Search & Filter Section --}}
    <div class="cp-card p-3 mb-4">
      <div class="row g-2 align-items-center flex-wrap">
        {{-- Search Input --}}
        <div class="col-12 col-md-6 col-lg-5">
          <div class="search-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg>
            <input id="job-search-input" class="cp-input search-input" placeholder="Search by title, company, or skill…" type="search" autocomplete="off">
          </div>
        </div>

        {{-- Location Filter --}}
        <div class="col-12 col-md-6 col-lg-2">
          <select id="location-filter" class="cp-input" onchange="applyFilters()">
            <option value="">All Locations</option>
            <option value="remote">Remote</option>
            <option value="hybrid">Hybrid</option>
            <option value="on-site">On-site</option>
          </select>
        </div>

        {{-- Level Filter --}}
        <div class="col-12 col-md-6 col-lg-2">
          <select id="level-filter" class="cp-input" onchange="applyFilters()">
            <option value="">All Levels</option>
            <option value="junior">Junior</option>
            <option value="mid-level">Mid-level</option>
            <option value="senior">Senior</option>
          </select>
        </div>

        {{-- Results Count --}}
        <div class="col-12 col-md-6 col-lg-3 text-center text-lg-end">
          <span id="job-results-count" class="text-muted-cp" style="font-size:13px">
            <span id="results-number">0</span> position<span id="results-plural">s</span> found
          </span>
        </div>
      </div>
    </div>

    {{-- Job Cards Grid — Responsive Layout --}}
    <div class="row g-3" id="jobs-grid">
      @php
        $locationBadge = ['Remote' => 'badge-remote', 'Hybrid' => 'badge-hybrid', 'On-site' => 'badge-onsite'];
        $levelBadge    = ['Junior' => 'badge-junior', 'Mid-level' => 'badge-mid', 'Senior' => 'badge-senior'];
      @endphp

      @foreach ($jobs as $job)
        @php
          $appStatus = $applicationMap[$job['jobId']] ?? null;
          $locClass  = $locationBadge[$job['location']] ?? 'badge-gray';
          $lvlClass  = $levelBadge[$job['level']] ?? 'badge-gray';
          $kwList    = is_string($job['keywords']) ? explode(' ', $job['keywords']) : (array) $job['keywords'];
          $safeTitle = addslashes($job['title']);
          $safeDept  = addslashes($job['department']);
          $safeSal   = addslashes($job['salaryRange']);
          $safeLoc   = addslashes($job['location']);
          $safeLvl   = addslashes($job['level']);
          $safeDesc  = addslashes($job['description']);
          $safeId    = $job['jobId'];
          $searchText = strtolower($job['title'] . ' ' . $job['department'] . ' ' . implode(' ', $kwList) . ' ' . $job['location'] . ' ' . $job['level']);
          $skillWeightsJson = json_encode($job['skillWeights'] ?? []);
        @endphp
        <div class="col-12 col-md-6 col-lg-6 job-card-col"
             data-job-id="{{ $safeId }}"
             data-location="{{ strtolower($job['location']) }}"
             data-level="{{ strtolower($job['level']) }}"
             data-text="{{ $searchText }}"
             data-skills='{{ $skillWeightsJson }}'>
          <div class="job-card">
            {{-- Job Header --}}
            <div class="d-flex align-items-start gap-3 mb-3">
              <div class="company-avatar">{{ strtoupper(substr($job['department'], 0, 2)) }}</div>
              <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start gap-2 flex-wrap">
                  <div class="flex-grow-1">
                    <h5 style="font-size:16px;font-weight:600;margin:0 0 4px">{{ $job['title'] }}</h5>
                    <p class="text-muted-cp" style="font-size:13px;margin:0">{{ $job['department'] }}</p>
                  </div>
                  <div class="d-flex gap-2 flex-wrap justify-content-end">
                    @if ($appStatus === 'rejected')
                      <span class="cp-badge" style="background:rgba(248,113,113,0.12);color:#f87171;border:1px solid rgba(248,113,113,0.3)">Rejected</span>
                    @elseif ($appStatus === 'applied')
                      <span class="cp-badge badge-exam">Applied</span>
                    @else
                      <span class="cp-badge badge-green">New</span>
                    @endif
                  </div>
                </div>
              </div>
            </div>

            {{-- Job Description --}}
            <p style="font-size:13px;color:#d1d5db;line-height:1.6;margin:12px 0">{{ $job['description'] }}</p>

            {{-- Badges --}}
            <div class="d-flex flex-wrap gap-2 mb-3">
              <span class="cp-badge {{ $locClass }}">{{ $job['location'] }}</span>
              <span class="cp-badge {{ $lvlClass }}">{{ $job['level'] }}</span>
              @foreach (array_slice($kwList, 0, 3) as $kw)
                @if ($kw)
                  <span class="cp-badge badge-blue">{{ $kw }}</span>
                @endif
              @endforeach
              @if (count($kwList) > 3)
                <span class="cp-badge badge-gray">+{{ count($kwList) - 3 }} more</span>
              @endif
            </div>

            {{-- Salary & Actions --}}
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
              <div>
                <p style="font-size:16px;font-weight:700;color:var(--primary);margin:0">{{ $job['salaryRange'] }}</p>
                <p class="text-muted-cp" style="font-size:12px;margin:0">Full-time</p>
              </div>
              <div class="d-flex gap-2 flex-wrap">
                <button
                  onclick="openJobModalWrapper(this, '{{ $safeDept }}','{{ $safeTitle }}','{{ $safeSal }}','{{ $safeLoc }}','{{ $safeLvl }}','{{ $safeDesc }}','{{ $safeId }}','{{ $appStatus ?? '' }}', {{ $hasActiveApplication ? 'true' : 'false' }})"
                  class="btn-cp btn-secondary-cp btn-cp-sm">
                  Details
                </button>

                @if ($appStatus === 'rejected')
                  <button class="btn-cp btn-cp-sm" disabled
                    style="background:rgba(248,113,113,0.1);border:1px solid rgba(248,113,113,0.3);color:#f87171;opacity:.7;cursor:not-allowed">
                    Rejected
                  </button>
                @elseif ($appStatus === 'applied')
                  <button class="btn-cp btn-primary-cp btn-cp-sm" disabled style="opacity:.55;cursor:not-allowed">
                    Applied
                  </button>
                @elseif ($hasActiveApplication)
                  <button class="btn-cp btn-primary-cp btn-cp-sm" disabled style="opacity:.4;cursor:not-allowed" title="You already have an active application in progress">
                    Apply
                  </button>
                @else
                  <button
                    id="apply-btn-{{ $safeId }}"
                    onclick="openApplyModal('{{ $safeDept }}','{{ $safeTitle }}','{{ $safeId }}')"
                    class="btn-cp btn-primary-cp btn-cp-sm">
                    Apply
                  </button>
                @endif
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    {{-- No Results Message --}}
    <div id="no-results-message" class="text-center py-5" style="display:none">
      <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:var(--border);margin-bottom:16px;opacity:0.5"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg>
      <p class="text-muted-cp">No jobs found matching your filters. Try adjusting your search criteria.</p>
    </div>

@endsection

@push('scripts')
<script>
const CSRF_TOKEN = '{{ csrf_token() }}';
// Seeded from server — true when the candidate already has an active application
window._hasActiveApplication = {{ $hasActiveApplication ? 'true' : 'false' }};
const APPLY_URL = '{{ route('candidate.jobs.apply') }}';
const CV_UPLOAD_URL = '{{ route('api.candidates.upload-cv', ['id' => 'CANDIDATE_ID']) }}';

// ============================================================
// FILTER & SEARCH FUNCTIONS
// ============================================================

/**
 * Apply all filters (search text, location, level)
 * Show/hide cards dynamically, update results count
 */
function applyFilters() {
  const query = document.getElementById('job-search-input').value.trim().toLowerCase();
  const location = document.getElementById('location-filter').value.toLowerCase();
  const level = document.getElementById('level-filter').value.toLowerCase();
  
  const cards = document.querySelectorAll('.job-card-col');
  let visible = 0;

  cards.forEach(function (col) {
    const text = (col.dataset.text || '').toLowerCase();
    const cardLocation = col.dataset.location || '';
    const cardLevel = col.dataset.level || '';
    
    // Text search
    let textMatch = !query || text.includes(query);
    
    // Location filter
    let locationMatch = !location || cardLocation === location;
    
    // Level filter
    let levelMatch = !level || cardLevel === level;
    
    // All conditions must match
    const shouldShow = textMatch && locationMatch && levelMatch;
    col.style.display = shouldShow ? '' : 'none';
    
    if (shouldShow) visible++;
  });

  // Update results counter
  updateResultsCounter(visible);
  
  // Show/hide "no results" message
  document.getElementById('no-results-message').style.display = visible === 0 ? 'block' : 'none';
}

/**
 * Update the results count display
 */
function updateResultsCounter(count) {
  document.getElementById('results-number').textContent = count;
  document.getElementById('results-plural').textContent = count !== 1 ? 's' : '';
}

// Event listeners for real-time filtering
document.getElementById('job-search-input').addEventListener('input', applyFilters);
document.getElementById('job-search-input').addEventListener('keydown', function(e) {
  if (e.key === 'Enter') applyFilters();
});

// ============================================================
// CV UPLOAD & GRADING
// ============================================================

/**
 * Open CV upload modal (client-side only — stores file in window._pendingCV)
 * No backend call is made here. The file is uploaded when the candidate
 * actually submits a job application.
 */
function openCVUploadModal() {
  const alreadyHasCV = !!window._pendingCV;
  const modalContent = `
    <div class="p-4">
      <div class="d-flex align-items-center justify-content-between mb-4">
        <h5 class="fw-bold mb-0">${alreadyHasCV ? 'Update Your CV' : 'Upload Your CV'}</h5>
        <button onclick="closeModal()" class="btn-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
      </div>

      <p class="text-muted-cp mb-4" style="font-size:13px">
        Select your CV now so it's ready when you apply for a job. Supported formats: PDF, DOCX, TXT (max 5 MB).
        <br>Your CV will only be saved when you submit an application.
      </p>

      <div id="cv-upload-area" class="p-5 rounded-3 text-center" style="border:2px dashed var(--border);background:rgba(var(--primary-rgb),0.03);cursor:pointer;transition:all 0.3s">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:var(--primary);margin-bottom:12px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        <h6 class="mb-2">Drag &amp; Drop your CV here</h6>
        <p class="text-muted-cp mb-3" style="font-size:13px">or click to browse files</p>
        <input id="cv-file-input" type="file" accept=".pdf,.txt,.doc,.docx" style="display:none" onchange="handleCVUpload(event)">
        <button class="btn-cp btn-primary-cp btn-cp-sm" onclick="event.stopPropagation();document.getElementById('cv-file-input').click()">
          Choose File
        </button>
      </div>
      
      @if($hasActiveApplication)
      <div class="mt-4">
        <h6 class="fw-bold mb-2">CV from your active application</h6>
        <textarea readonly class="cp-input w-100" rows="6" style="background:var(--secondary);color:var(--muted-fg)">Alex Johnson
Senior Software Engineer
Experience: 5+ years
Skills: PHP, Laravel, JavaScript, React, MySQL

(This is the CV you used for your active application.)</textarea>
      </div>
      @endif

      <div id="cv-upload-result" style="display:none;margin-top:20px"></div>
    </div>
  `;

  openModal(modalContent);

  // Show current CV if already selected
  if (alreadyHasCV) {
    setTimeout(() => showCVReady(window._pendingCV), 50);
  }

  // Drag-and-drop
  setTimeout(() => {
    const uploadArea = document.getElementById('cv-upload-area');
    if (!uploadArea) return;
    uploadArea.addEventListener('dragover', e => {
      e.preventDefault();
      uploadArea.style.borderColor = 'var(--primary)';
      uploadArea.style.background  = 'rgba(var(--primary-rgb),0.1)';
    });
    uploadArea.addEventListener('dragleave', () => {
      uploadArea.style.borderColor = 'var(--border)';
      uploadArea.style.background  = 'rgba(var(--primary-rgb),0.03)';
    });
    uploadArea.addEventListener('drop', e => {
      e.preventDefault();
      uploadArea.style.borderColor = 'var(--border)';
      uploadArea.style.background  = 'rgba(var(--primary-rgb),0.03)';
      if (e.dataTransfer.files.length) handleCVFile(e.dataTransfer.files[0]);
    });
    uploadArea.addEventListener('click', () => document.getElementById('cv-file-input').click());
  }, 50);
}

/**
 * Called when the file input changes
 */
function handleCVUpload(event) {
  const file = event.target.files && event.target.files[0];
  if (file) handleCVFile(file);
}

/**
 * Validate the file, store it in window._pendingCV, and show the ready state.
 * No backend call — the file will be uploaded when the application is submitted.
 */
function handleCVFile(file) {
  const validTypes = ['application/pdf', 'text/plain',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

  // Allow by extension too (some OS report blank MIME for .docx)
  const validExt = /\.(pdf|txt|doc|docx)$/i.test(file.name);

  if (!validTypes.includes(file.type) && !validExt) {
    alert('Invalid file type. Please upload a PDF, DOC, DOCX, or TXT file.');
    return;
  }
  if (file.size > 5242880) {
    alert('File is too large. Maximum size is 5 MB.');
    return;
  }

  window._pendingCV = file;
  showCVReady(file);
}

/**
 * Show the "CV ready" confirmation inside the upload modal
 */
function showCVReady(file) {
  const area   = document.getElementById('cv-upload-area');
  const result = document.getElementById('cv-upload-result');
  if (!result) return;

  if (area) area.style.display = 'none';
  result.style.display = 'block';
  result.innerHTML = `
    <div style="text-align:center;padding:20px;background:rgba(34,197,94,0.08);border-radius:12px">
      <div style="width:56px;height:56px;border-radius:50%;background:rgba(34,197,94,0.15);display:flex;align-items:center;justify-content:center;margin:0 auto 12px">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#4ade80" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
      </div>
      <h6 class="fw-bold mb-1">CV Ready</h6>
      <p class="text-muted-cp mb-3" style="font-size:13px">${file.name}</p>
      <p class="text-muted-cp mb-3" style="font-size:12px">Your CV will be uploaded when you submit a job application.</p>
      <div class="d-flex gap-2 justify-content-center">
        <button onclick="closeModal()" class="btn-cp btn-primary-cp btn-cp-sm" style="justify-content:center">Done</button>
        <button onclick="document.getElementById('cv-upload-area').style.display='';document.getElementById('cv-upload-result').style.display='none';" class="btn-cp btn-secondary-cp btn-cp-sm" style="justify-content:center">Change</button>
      </div>
    </div>
  `;
}

/**
 * Display CV grading results
 */
function displayCVGradeResult(data) {
  const progressDiv = document.getElementById('cv-upload-progress');
  const resultDiv = document.getElementById('cv-upload-result');
  
  progressDiv.style.display = 'none';
  resultDiv.style.display = 'block';
  
  if (data.success) {
    const grade = data.grade_letter || 'N/A';
    const skillsFound = data.skills_found || 0;
    const experience = data.years_experience || 0;
    
    resultDiv.innerHTML = `
      <div style="text-align:center;padding:20px;background:rgba(34,197,94,0.1);border-radius:12px;margin-bottom:16px">
        <div style="width:80px;height:80px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;font-size:32px;font-weight:bold;color:var(--primary-fg);margin:0 auto 16px">
          ${grade}
        </div>
        <h5 class="fw-bold mb-2">CV Grade: ${grade}</h5>
        <p class="text-muted-cp mb-0" style="font-size:13px">
          ${skillsFound} skills found • ${experience} years experience
        </p>
      </div>
      
      <div class="mb-4">
        <h6 class="fw-semibold mb-2">Extracted Skills</h6>
        <div style="display:flex;flex-wrap:wrap;gap:8px">
          ${data.extracted_skills.map(s => `<span class="cp-badge badge-blue">${s.name}</span>`).join('')}
        </div>
      </div>
      
      <div class="mb-4">
        <h6 class="fw-semibold mb-2">Feedback</h6>
        <ul style="margin:0;padding-left:18px;font-size:13px">
          ${data.feedback.map(f => `<li style="margin-bottom:6px;color:#d1d5db">${f}</li>`).join('')}
        </ul>
      </div>
      
      <div class="d-flex gap-2">
        <button onclick="closeModal(); displayCVGradeCard('${grade}', ${skillsFound}, ${experience})" class="btn-cp btn-primary-cp flex-fill justify-content-center">
          Done
        </button>
      </div>
    `;
    
    // Store CV grade in local display
    displayCVGradeCard(grade, skillsFound, experience, data.feedback);
  } else {
    showCVUploadError(data.message || 'Failed to process CV.');
  }
}

/**
 * Display CV grade in the main card
 */
function displayCVGradeCard(grade, skillsFound, experience, feedback) {
  const gradeCard = document.getElementById('cv-grade-card');
  document.getElementById('cv-grade-letter').textContent = grade;
  document.getElementById('cv-grade-title').textContent = `CV Grade: ${grade}`;
  document.getElementById('cv-grade-skills').textContent = skillsFound + ' skill' + (skillsFound !== 1 ? 's' : '') + ' found';
  document.getElementById('cv-grade-experience').textContent = experience + ' year' + (experience !== 1 ? 's' : '') + ' exp';
  
  if (feedback && feedback.length > 0) {
    document.getElementById('cv-feedback-summary').innerHTML = 
      '<span style="color:var(--primary)">' + feedback[0] + '</span>';
  }
  
  gradeCard.style.display = 'block';
}

/**
 * Show CV upload error
 */
function showCVUploadError(message) {
  const resultDiv = document.getElementById('cv-upload-result');
  const progressDiv = document.getElementById('cv-upload-progress');
  
  progressDiv.style.display = 'none';
  resultDiv.style.display = 'block';
  resultDiv.innerHTML = `
    <div style="padding:16px;background:rgba(239,68,68,0.1);border-radius:8px;border-left:4px solid #ef4444">
      <p class="text-muted-cp mb-0" style="font-size:13px;color:#fca5a5">
        <strong>Error:</strong> ${message}
      </p>
    </div>
    <button onclick="openCVUploadModal()" class="btn-cp btn-secondary-cp w-100 mt-3 justify-content-center">
      Try Again
    </button>
  `;
}

// ============================================================
// JOB DETAILS & APPLICATION MODALS
// ============================================================

/**
 * Open job details modal
 */
function openJobModal(company, title, salary, location, level, description, jobId, appStatus, hasActiveApp = false) {
  // If the user applied on this page visit, honour the runtime flag
  if (window._hasActiveApplication) hasActiveApp = true;
  // Build the bottom action button based on application status
  let actionBtn;
  if (appStatus === 'rejected') {
    actionBtn = `<button class="btn-cp btn-cp-sm flex-fill justify-content-center" disabled
      style="background:rgba(248,113,113,0.1);border:1px solid rgba(248,113,113,0.3);color:#f87171;opacity:.75;cursor:not-allowed">
      Rejected
    </button>`;
  } else if (appStatus === 'applied') {
    actionBtn = `<button class="btn-cp btn-primary-cp flex-fill justify-content-center" disabled style="opacity:.55;cursor:not-allowed">
      Applied
    </button>`;
  } else if (hasActiveApp) {
    actionBtn = `<button class="btn-cp btn-primary-cp flex-fill justify-content-center" disabled style="opacity:.4;cursor:not-allowed" title="You already have an active application in progress">
      Apply Now
    </button>`;
  } else {
    actionBtn = `<button id="detail-apply-btn" class="btn-cp btn-primary-cp flex-fill justify-content-center">Apply Now</button>`;
  }

  const content = `
    <div class="p-4">
      <div class="d-flex align-items-start justify-content-between gap-3 mb-4">
        <div>
          <h5 class="fw-bold mb-1">${title}</h5>
          <p class="text-muted-cp mb-0" style="font-size:13px">${company}</p>
        </div>
        <button onclick="closeModal()" class="btn-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
      </div>

      <div class="row g-2 mb-4">
        <div class="col-6">
          <div class="p-3 rounded-3" style="background:var(--secondary)">
            <p class="text-muted-cp mb-1" style="font-size:11px">Salary</p>
            <p class="fw-semibold mb-0 text-primary-cp" style="font-size:14px">${salary}</p>
          </div>
        </div>
        <div class="col-6">
          <div class="p-3 rounded-3" style="background:var(--secondary)">
            <p class="text-muted-cp mb-1" style="font-size:11px">Location</p>
            <p class="fw-semibold mb-0" style="font-size:14px">${location}</p>
          </div>
        </div>
        <div class="col-6">
          <div class="p-3 rounded-3" style="background:var(--secondary)">
            <p class="text-muted-cp mb-1" style="font-size:11px">Level</p>
            <p class="fw-semibold mb-0" style="font-size:14px">${level}</p>
          </div>
        </div>
        <div class="col-6">
          <div class="p-3 rounded-3" style="background:var(--secondary)">
            <p class="text-muted-cp mb-1" style="font-size:11px">Type</p>
            <p class="fw-semibold mb-0" style="font-size:14px">Full-time</p>
          </div>
        </div>
      </div>

      <h6 class="fw-semibold mb-2">About This Role</h6>
      <p style="font-size:14px;line-height:1.65;color:#d1d5db;margin-bottom:20px">${description}</p>

      <div class="d-flex gap-2">
        <button onclick="closeModal()" class="btn-cp btn-outline-cp flex-fill justify-content-center">Close</button>
        ${actionBtn}
      </div>
    </div>
  `;

  openModal(content);

  // Only wire up click if the Apply Now button exists
  const applyBtn = document.getElementById('detail-apply-btn');
  if (applyBtn) {
    applyBtn.addEventListener('click', function() {
      openApplyModal(company, title, jobId);
    });
  }
}

/**
 * Open application modal — reads skillWeights from the job card's data-skills attribute
 * and renders a proficiency selector for each required skill.
 */
function openApplyModal(company, title, jobId) {
  // Read skill weights from the job card DOM element
  const cardEl      = document.querySelector(`.job-card-col[data-job-id="${jobId}"]`);
  const skillWeights = cardEl ? JSON.parse(cardEl.dataset.skills || '{}') : {};
  const skillEntries = Object.entries(skillWeights); // [[skill, weight], ...]

  // Build skill selector HTML (weights hidden from candidate — only used server-side for scoring)
  const skillsHTML = skillEntries.length
    ? `<div class="mb-3">
        <label class="cp-label">Rate Your Proficiency in Each Required Skill</label>
        <p class="text-muted-cp mb-2" style="font-size:11px">Your selections are used to calculate your match score.</p>
        ${skillEntries.map(([skill]) => `
          <div class="d-flex align-items-center gap-2 mb-2">
            <span style="min-width:130px;font-size:13px;color:#d1d5db">${skill} <span style="color:#ef4444">*</span></span>
            <select class="cp-input skill-proficiency" data-skill="${skill}" style="flex:1;padding:6px 10px;font-size:13px">
              <option value="" disabled selected>— Select your level —</option>
              <option value="0.5">Beginner (50% match)</option>
              <option value="0.75">Intermediate (75% match)</option>
              <option value="1.0">Expert (100% match)</option>
            </select>
          </div>`).join('')}
      </div>`
    : '';

  const content = `
    <div class="p-4">
      <div class="d-flex align-items-center justify-content-between mb-4">
        <h5 class="fw-bold mb-0">Apply for ${title}</h5>
        <button onclick="closeModal()" class="btn-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
      </div>

      <p class="text-muted-cp mb-3" style="font-size:13px">
        Applying to <strong style="color:#fff">${company}</strong>
      </p>

      <div class="mb-3">
        <label class="cp-label">Full Name <span style="color:#ef4444">*</span></label>
        <input id="apply-name" class="cp-input" type="text" placeholder="e.g. Jane Smith" style="width:100%">
      </div>

      <div class="mb-3">
        <label class="cp-label">Email Address <span style="color:#ef4444">*</span></label>
        <input id="apply-email" class="cp-input" type="email" placeholder="e.g. jane@example.com" style="width:100%">
      </div>

      ${skillsHTML}

      <div class="mb-3">
        <label class="cp-label">Cover Letter <span class="text-muted-cp">(optional)</span></label>
        <textarea id="apply-cover" class="cp-input" rows="2" placeholder="Tell us why you are a great fit for this role…"></textarea>
      </div>

      <div class="mb-4">
        <label class="cp-label">Upload CV <span class="text-muted-cp">(PDF, DOCX or TXT · max 5 MB)</span></label>
        <div id="cv-drop-zone" class="p-3 rounded-3 text-center" style="border:2px dashed var(--border);background:rgba(var(--primary-rgb),0.03);cursor:pointer;transition:all 0.25s">
          <input id="apply-cv" type="file" accept=".pdf,.doc,.docx,.txt" style="display:none" onchange="previewCV(this)">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:var(--primary);margin-bottom:4px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
          <p id="cv-file-label" class="text-muted-cp mb-2" style="font-size:12px">Drag &amp; drop or click to browse</p>
          <button type="button" class="btn-cp btn-secondary-cp btn-cp-sm" onclick="event.stopPropagation();document.getElementById('apply-cv').click()">Choose File</button>
        </div>

      <div id="apply-error-msg" style="display:none;font-size:12px;color:#f87171;background:rgba(248,113,113,0.08);border:1px solid rgba(248,113,113,0.25);border-radius:8px;padding:8px 12px;margin-bottom:10px;line-height:1.6"></div>

      <div class="d-flex gap-2">
        <button onclick="closeModal()" class="btn-cp btn-outline-cp flex-fill justify-content-center">Cancel</button>
        <button id="submit-apply-btn" class="btn-cp btn-primary-cp flex-fill justify-content-center">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
          Submit Application
        </button>
      </div>
    </div>
  `;

  openModal(content);

  setTimeout(() => {
    // Submit button uses closure — no HTML escaping issues
    const submitBtn = document.getElementById('submit-apply-btn');
    if (submitBtn) submitBtn.addEventListener('click', () => submitApplication(company, title, jobId, skillWeights));

    // Pre-fill CV drop zone if user already selected one via the + button
    if (window._pendingCV) previewCVFile(window._pendingCV);

    // Drag-and-drop
    const zone = document.getElementById('cv-drop-zone');
    if (!zone) return;
    zone.addEventListener('dragover', e => { e.preventDefault(); zone.style.borderColor = 'var(--primary)'; });
    zone.addEventListener('dragleave', () => { zone.style.borderColor = 'var(--border)'; });
    zone.addEventListener('drop', e => {
      e.preventDefault();
      zone.style.borderColor = 'var(--border)';
      if (e.dataTransfer.files.length) previewCVFile(e.dataTransfer.files[0]);
    });
    zone.addEventListener('click', () => document.getElementById('apply-cv').click());
  }, 50);
}

/**
 * Show chosen CV filename in the drop zone and store the File object
 */
function previewCV(input) {
  if (input.files && input.files[0]) previewCVFile(input.files[0]);
}

function previewCVFile(file) {
  // Store so submitApplication() can read it
  window._pendingCV = file;

  const label = document.getElementById('cv-file-label');
  if (label) {
    label.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#4ade80" stroke-width="2" style="margin-right:4px"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>${file.name}`;
    label.style.color = '#4ade80';
  }
}

/**
 * Submit job application via multipart/form-data.
 * Full client-side validation: name, email, CV required, all skill levels required, no duplicate.
 */
function submitApplication(company, title, jobId, skillWeights) {
  const errorEl = document.getElementById('apply-error-msg');
  const showError = (msgs) => {
    if (!errorEl) return;
    errorEl.innerHTML = msgs.map(m => `• ${m}`).join('<br>');
    errorEl.style.display = 'block';
    errorEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  };
  const clearError = () => { if (errorEl) { errorEl.style.display = 'none'; errorEl.innerHTML = ''; } };
  clearError();

  const name  = (document.getElementById('apply-name')?.value  || '').trim();
  const email = (document.getElementById('apply-email')?.value || '').trim();
  const cvInput = document.getElementById('apply-cv');
  const cvFile  = (cvInput && cvInput.files[0]) ? cvInput.files[0] : (window._pendingCV || null);

  // ── Validation ───────────────────────────────────────────────────────────
  const errors = [];

  if (!name) errors.push('Full name is required.');
  if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))
    errors.push('A valid email address is required.');

  if (!cvFile)
    errors.push('Please upload your CV before submitting.');

  // Every skill dropdown must have a value selected (not the placeholder)
  const skillSelects = [...document.querySelectorAll('.skill-proficiency')];
  const unset = skillSelects.filter(s => !s.value || s.value === '');
  if (unset.length)
    errors.push(`Please select your proficiency level for: ${unset.map(s => s.dataset.skill).join(', ')}.`);

  if (errors.length) { showError(errors); return; }

  // ── Submit ───────────────────────────────────────────────────────────────
  const btn = document.getElementById('submit-apply-btn');
  const originalHTML = btn.innerHTML;
  btn.disabled = true;
  btn.innerHTML = '<span style="display:inline-block;width:14px;height:14px;border:2px solid currentColor;border-top-color:transparent;border-radius:50%;animation:spin 0.7s linear infinite;margin-right:6px"></span> Submitting…';

  const coverLetter = document.getElementById('apply-cover')?.value || '';

  const candidateSkills = {};
  skillSelects.forEach(sel => { candidateSkills[sel.dataset.skill] = parseFloat(sel.value); });

  const formData = new FormData();
  formData.append('_token',          CSRF_TOKEN);
  formData.append('job_id',          jobId);
  formData.append('job_title',       title);
  formData.append('company',         company);
  formData.append('applicant_name',  name);
  formData.append('applicant_email', email);
  formData.append('cover_letter',    coverLetter);
  formData.append('skill_weights',   JSON.stringify(skillWeights || {}));
  Object.entries(candidateSkills).forEach(([skill, val]) => formData.append(`skills[${skill}]`, val));
  if (cvFile) formData.append('cv', cvFile);

  fetch(APPLY_URL, {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' },
    body: formData,
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      showApplicationSuccess(company, title, jobId, data.cv_uploaded, data.match_score, data.grade_label, data.grade_color, data.rank, data.is_shortlisted, data.is_rejected, data.min_score, data.base_score, data.experience_bonus, data.experience_years);
    } else {
      btn.disabled = false;
      btn.innerHTML = originalHTML;
      showError([data.message || 'Could not submit your application. Please try again.']);
    }
  })
  .catch(() => {
    btn.disabled = false;
    btn.innerHTML = originalHTML;
    showError(['Network error. Please check your connection and try again.']);
  });
}

/**
 * Show result modal after application submission.
 * Handles both acceptance (green) and rejection (red) outcomes.
 */
function showApplicationSuccess(company, title, jobId, cvUploaded, matchScore, gradeLabel, gradeColor, rank, isShortlisted, isRejected, minScore, baseScore, experienceBonus, experienceYears) {
  const panel = document.getElementById('modal-panel');
  if (!panel) return;

  // ── REJECTED ────────────────────────────────────────────────────────────
  if (isRejected) {
    const breakdownHTML = (experienceBonus > 0)
      ? `<div style="font-size:11px;color:var(--muted-fg);margin:6px 0 10px;line-height:1.8">
           Skills score: <strong style="color:#fff">${baseScore}%</strong><br>
           Experience bonus (${experienceYears} yr${experienceYears!==1?'s':''} × 2): <strong style="color:#f87171">+${experienceBonus}pts</strong><br>
           Final score: <strong style="color:#f87171">${matchScore}%</strong>
         </div>`
      : '';
    panel.innerHTML = `
      <div class="p-4 text-center">
        <div style="width:56px;height:56px;border-radius:50%;background:rgba(248,113,113,0.12);display:flex;align-items:center;justify-content:center;margin:0 auto 12px">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#f87171" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </div>
        <h5 style="font-weight:700;margin-bottom:6px;color:#f87171">Application Not Accepted</h5>
        <p class="text-muted-cp" style="font-size:13px;margin-bottom:10px">
          <strong style="color:#fff">${title}</strong> at <strong style="color:#fff">${company}</strong>
        </p>
        <div style="display:inline-flex;flex-direction:column;align-items:center;gap:4px;background:rgba(248,113,113,0.06);border:1px solid rgba(248,113,113,0.3);border-radius:12px;padding:14px 24px;margin-bottom:8px">
          <span style="font-size:28px;font-weight:800;color:#f87171;line-height:1">${matchScore}%</span>
          <span style="font-size:11px;color:#f87171;letter-spacing:.05em;text-transform:uppercase">${gradeLabel}</span>
          <span class="text-muted-cp" style="font-size:11px">Your Score</span>
        </div>
        ${breakdownHTML}
        <p class="text-muted-cp" style="font-size:12px;margin-bottom:16px">
          This position requires a minimum score of <strong style="color:#fff">${minScore}%</strong>.<br>
          Consider improving your skills and applying again in the future.
        </p>
        <button onclick="closeModal(); markJobApplied('${jobId}', true)" class="btn-cp" style="background:rgba(248,113,113,0.15);border:1px solid rgba(248,113,113,0.4);color:#f87171;min-width:120px;justify-content:center">Close</button>
      </div>
    `;
    setTimeout(() => { closeModal(); markJobApplied(jobId, true); }, 6000);
    return;
  }

  // ── ACCEPTED ────────────────────────────────────────────────────────────
  const cvNote = cvUploaded
    ? `<p style="font-size:12px;color:#4ade80;margin:4px 0 0"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="margin-right:4px"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>CV saved to your profile</p>`
    : '';

  const ordinal = n => n + (['st','nd','rd'][((n+90)%100-10)%10-1] || 'th');
  const rankNote = (rank && rank > 0)
    ? `<p style="font-size:12px;color:var(--muted-fg);margin:4px 0 0">You are ranked <strong style="color:#fff">${ordinal(rank)}</strong> among ${rank} applicant${rank !== 1 ? 's' : ''} for this role.</p>`
    : '';

  const shortlistBadge = isShortlisted
    ? `<span style="display:inline-flex;align-items:center;gap:4px;font-size:11px;font-weight:600;color:#4ade80;background:rgba(74,222,128,0.1);border:1px solid rgba(74,222,128,0.3);border-radius:20px;padding:3px 10px;margin-top:6px">
        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        Shortlisted
       </span>`
    : '';

  const scoreHTML = (matchScore !== undefined && matchScore !== null)
    ? `<div style="display:inline-flex;flex-direction:column;align-items:center;gap:4px;background:rgba(255,255,255,0.04);border:1px solid var(--border);border-radius:12px;padding:14px 24px;margin:12px 0 4px">
        <span style="font-size:32px;font-weight:800;color:${gradeColor || '#4ade80'};line-height:1">${matchScore}%</span>
        <span style="font-size:12px;font-weight:600;color:${gradeColor || '#4ade80'};letter-spacing:.05em;text-transform:uppercase">${gradeLabel || 'Match'}</span>
        <span class="text-muted-cp" style="font-size:11px">Match Score</span>
       </div>
       ${experienceBonus > 0
         ? `<p style="font-size:11px;color:var(--muted-fg);margin:4px 0 6px;line-height:1.7">
              Skills: <strong style="color:#fff">${baseScore}%</strong>
              &nbsp;+&nbsp;
              Experience (${experienceYears}yr${experienceYears!==1?'s':''} × 2):
              <strong style="color:#4ade80">+${experienceBonus}pts</strong>
            </p>`
         : ''}`
    : '';

  panel.innerHTML = `
    <div class="p-4 text-center">
      <div style="width:56px;height:56px;border-radius:50%;background:rgba(34,197,94,0.15);display:flex;align-items:center;justify-content:center;margin:0 auto 12px">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#4ade80" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
      </div>
      <h5 style="font-weight:700;margin-bottom:6px">Application Submitted!</h5>
      <p class="text-muted-cp" style="font-size:13px;margin-bottom:4px">
        <strong style="color:#fff">${title}</strong> at <strong style="color:#fff">${company}</strong>
      </p>
      ${cvNote}
      ${scoreHTML}
      ${rankNote}
      <div style="margin:8px 0 16px">${shortlistBadge}</div>
      <button onclick="closeModal(); markJobApplied('${jobId}', false)" class="btn-cp btn-primary-cp" style="min-width:120px;justify-content:center">Done</button>
    </div>
  `;

  setTimeout(() => { closeModal(); markJobApplied(jobId, false); }, 5000);
}

/**
 * Mark a job card as applied or rejected
 */
function markJobApplied(jobId, isRejected = false) {
  // ── Update the card that was just applied to ──────────────────────────
  const applyBtn = document.getElementById('apply-btn-' + jobId);
  if (applyBtn) {
    applyBtn.disabled = true;
    applyBtn.textContent = isRejected ? 'Rejected' : 'Applied';

    if (isRejected) {
      applyBtn.style.background   = 'rgba(248,113,113,0.1)';
      applyBtn.style.borderColor  = 'rgba(248,113,113,0.3)';
      applyBtn.style.color        = '#f87171';
      applyBtn.style.opacity      = '1';
    } else {
      applyBtn.style.opacity = '0.55';
    }
    applyBtn.style.cursor = 'not-allowed';
    applyBtn.removeAttribute('onclick');
  }

  // ── Update badge in this card's header ───────────────────────────────
  const cardCol = document.querySelector(`.job-card-col[data-job-id="${jobId}"]`);
  if (cardCol) {
    const badgeContainer = cardCol.querySelector('.d-flex.gap-2.flex-wrap.justify-content-end');
    if (badgeContainer) {
      if (isRejected) {
        badgeContainer.innerHTML = '<span class="cp-badge" style="background:rgba(248,113,113,0.12);color:#f87171;border:1px solid rgba(248,113,113,0.3)">Rejected</span>';
      } else {
        badgeContainer.innerHTML = '<span class="cp-badge badge-exam">Applied</span>';
      }
    }
  }

  // ── Also update the Details button onclick to reflect the new status ────────
  const detailBtn = cardCol ? cardCol.querySelector('.btn-secondary-cp') : null;
  if (detailBtn) {
    // We update the appStatus and hasActiveApp arguments in the openJobModal call
    const currentOnclick = detailBtn.getAttribute('onclick');
    if (currentOnclick) {
      // Replace the appStatus (the 8th argument) and hasActiveApp (the 9th argument)
      // This is a bit brittle with string replacement, but since we know the structure:
      // openJobModal(..., 'jobId', 'appStatus', hasActiveApp)
      // We'll just replace the whole onclick with updated values
      const safeJobId = String(jobId);
      const newStatus = isRejected ? 'rejected' : 'applied';
      const hasActive = !isRejected;
      
      // We can't easily re-parse all arguments, so we'll just set a marker on the button
      detailBtn.dataset.appStatus = newStatus;
      detailBtn.dataset.hasActive = hasActive;
    }
  }

  // ── If accepted: lock ALL other Apply buttons ─────────────────────────
  // If rejected: the user is free to apply elsewhere — leave other buttons alone
  if (!isRejected) {
    document.querySelectorAll('.job-card-col').forEach(function (col) {
      const otherId = col.dataset.jobId;
      if (otherId === String(jobId)) return; // skip the one just applied to

      const otherBtn = document.getElementById('apply-btn-' + otherId);
      if (otherBtn && !otherBtn.disabled) {
        otherBtn.disabled = true;
        otherBtn.textContent = 'Apply';
        otherBtn.style.opacity    = '0.4';
        otherBtn.style.cursor     = 'not-allowed';
        otherBtn.title            = 'You already have an active application in progress';
        otherBtn.removeAttribute('onclick');
      }
      
      // Also update the hasActiveApp flag for other Details buttons
      const otherDetailBtn = col.querySelector('.btn-secondary-cp');
      if (otherDetailBtn) otherDetailBtn.dataset.hasActive = 'true';
    });

    // Keep track so openJobModal also shows locked state
    window._hasActiveApplication = true;
  }
}

/**
 * Enhanced openJobModal wrapper that reads dynamic dataset values
 */
function openJobModalWrapper(btn, company, title, salary, location, level, description, jobId, appStatus, hasActiveApp) {
  // Prefer data attributes if they've been updated dynamically
  const dynamicStatus = btn.dataset.appStatus || appStatus;
  const dynamicActive = (btn.dataset.hasActive === 'true') || (btn.dataset.hasActive === 'false' ? false : hasActiveApp);
  
  openJobModal(company, title, salary, location, level, description, jobId, dynamicStatus, dynamicActive);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
  updateResultsCounter(document.querySelectorAll('.job-card-col').length);
});
</script>

<style>
@keyframes spin { to { transform: rotate(360deg); } }
.search-input::placeholder { color: var(--border); }
.cp-input { background: var(--secondary); border: 1px solid var(--border); color: #fff; }
.cp-input:focus { border-color: var(--primary); outline: none; }
.job-card { padding: 20px; border-radius: 12px; background: rgba(255,255,255,0.02); border: 1px solid var(--border); transition: all 0.3s; }
.job-card:hover { background: rgba(255,255,255,0.04); border-color: var(--primary); }
@media (max-width: 768px) {
  .job-card { padding: 16px; }
  .btn-cp-sm { padding: 8px 12px; font-size: 12px; }
  .col-md-6 { flex: 0 0 100%; max-width: 100%; }
}
</style>
@endpush
