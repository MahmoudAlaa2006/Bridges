@extends('layouts.app')

@section('sidebar')
    @include('layouts.partials.candidate_sidebar')
@endsection
@section('title', 'Browse Jobs — CareerPortal')
@section('header-title', 'Browse Jobs')

@section('header-actions-prefix')
<button class="btn-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg></button>
@endsection

@section('content')
    <div class="mb-4">
      <h2 class="section-title">Browse Jobs</h2>
      <p class="section-sub">Discover open positions that match your skills and experience.</p>
    </div>

    <!-- Search and filters -->
    <div class="cp-card p-3 mb-4">
      <div class="row g-2 align-items-center">
        <div class="col-md-5">
          <div class="search-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg>
            <input class="cp-input search-input" placeholder="Search by title, company, or skill…" type="search">
          </div>
        </div>
        <!-- <div class="col-md-3">
          <select class="cp-input">
            <option>All locations</option>
            <option>Remote</option>
            <option>Hybrid</option>
            <option>On-site</option>
          </select>
        </div>
        <div class="col-md-2">
          <select class="cp-input">
            <option>All levels</option>
            <option>Junior</option>
            <option>Mid-level</option>
            <option>Senior</option>
          </select>
        </div> -->
        <div class="col-md-2">
          <button class="btn-cp btn-primary-cp w-100 justify-content-center">Search</button>
        </div>
      </div>
      <!-- <div class="d-flex gap-2 mt-2 flex-wrap">
        <span class="cp-badge badge-green" style="cursor:pointer">Remote</span>
        <span class="cp-badge badge-yellow" style="cursor:pointer">$100k+</span>
        <span class="cp-badge badge-purple" style="cursor:pointer">Senior</span>
        <span class="cp-badge badge-blue" style="cursor:pointer">React</span>
        <span class="cp-badge badge-gray" style="cursor:pointer">TypeScript</span>
      </div> -->
    </div>

    <!-- Results count -->
    <!-- <p class="text-muted-cp mb-3" style="font-size:13px">Showing <strong style="color:#fff">6</strong> positions matching your profile</p> -->

    <!-- Job Cards Grid -->
    <div class="row g-3">

      <!-- Job 1 -->
      <div class="col-lg-6">
        <div class="job-card">
          <div class="d-flex align-items-start gap-3">
            <div class="company-avatar" style="background:rgba(245,197,66,0.15);color:var(--primary)">TC</div>
            <div class="flex-grow-1">
              <div class="d-flex justify-content-between align-items-start gap-2">
                <div>
                  <h5 style="font-size:15px;font-weight:600;margin:0 0 2px">Senior Frontend Developer</h5>
                  <p class="text-muted-cp" style="font-size:13px;margin:0">TechCorp Inc.</p>
                </div>
                <span class="cp-badge badge-exam" style="white-space:nowrap">Applied</span>
              </div>
            </div>
          </div>
          <p style="font-size:13px;color:#d1d5db;line-height:1.5;margin:0">Build and maintain high-performance React applications serving 2M+ users. Lead architecture decisions and mentor junior engineers.</p>
          <div class="d-flex flex-wrap gap-2">
            <span class="cp-badge badge-remote">Remote</span>
            <span class="cp-badge badge-senior">Senior</span>
            <span class="cp-badge badge-blue">React</span>
            <span class="cp-badge badge-gray">TypeScript</span>
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p style="font-size:16px;font-weight:700;color:var(--primary);margin:0">$130k – $155k</p>
              <p class="text-muted-cp" style="font-size:12px;margin:0">+ equity &amp; benefits</p>
            </div>
            <div class="d-flex gap-2">
              <button onclick="openJobModal('TechCorp Inc.','Senior Frontend Developer','$130k – $155k','Remote','Senior','Build and maintain high-performance React applications serving 2M+ users. You will lead architecture decisions and mentor junior engineers on a team of 8.')" class="btn-cp btn-secondary-cp btn-cp-sm">Details</button>
              <button class="btn-cp btn-primary-cp btn-cp-sm" disabled style="opacity:.5;cursor:not-allowed">Applied</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Job 2 -->
      <div class="col-lg-6">
        <div class="job-card">
          <div class="d-flex align-items-start gap-3">
            <div class="company-avatar" style="background:rgba(139,92,246,0.15);color:var(--accent)">IL</div>
            <div class="flex-grow-1">
              <div class="d-flex justify-content-between align-items-start gap-2">
                <div>
                  <h5 style="font-size:15px;font-weight:600;margin:0 0 2px">Full Stack Engineer</h5>
                  <p class="text-muted-cp" style="font-size:13px;margin:0">Innovate Labs</p>
                </div>
              </div>
            </div>
          </div>
          <p style="font-size:13px;color:#d1d5db;line-height:1.5;margin:0">Join a fast-growing fintech startup and own features end-to-end. Work with React, Node.js, and PostgreSQL in a fully remote environment.</p>
          <div class="d-flex flex-wrap gap-2">
            <span class="cp-badge badge-remote">Remote</span>
            <span class="cp-badge badge-mid">Mid-level</span>
            <span class="cp-badge badge-blue">Node.js</span>
            <span class="cp-badge badge-gray">PostgreSQL</span>
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p style="font-size:16px;font-weight:700;color:var(--primary);margin:0">$110k – $130k</p>
              <p class="text-muted-cp" style="font-size:12px;margin:0">+ 0.05% equity</p>
            </div>
            <div class="d-flex gap-2">
              <button onclick="openJobModal('Innovate Labs','Full Stack Engineer','$110k – $130k','Remote','Mid-level','Own features end-to-end in a fast-growing fintech startup. You will work with React, Node.js, and PostgreSQL in a fully remote, async-first culture.')" class="btn-cp btn-secondary-cp btn-cp-sm">Details</button>
              <button onclick="openApplyModal('Innovate Labs','Full Stack Engineer')" class="btn-cp btn-primary-cp btn-cp-sm">Apply</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Job 3 -->
      <div class="col-lg-6">
        <div class="job-card">
          <div class="d-flex align-items-start gap-3">
            <div class="company-avatar" style="background:rgba(34,197,94,0.15);color:#4ade80">SC</div>
            <div class="flex-grow-1">
              <div class="d-flex justify-content-between align-items-start gap-2">
                <div>
                  <h5 style="font-size:15px;font-weight:600;margin:0 0 2px">React Developer</h5>
                  <p class="text-muted-cp" style="font-size:13px;margin:0">StartupCo</p>
                </div>
                <span class="cp-badge badge-green" style="white-space:nowrap">New</span>
              </div>
            </div>
          </div>
          <p style="font-size:13px;color:#d1d5db;line-height:1.5;margin:0">Be the 3rd frontend engineer at a seed-stage SaaS startup. Shape the product from day one and grow into a senior role within 12 months.</p>
          <div class="d-flex flex-wrap gap-2">
            <span class="cp-badge badge-remote">Remote</span>
            <span class="cp-badge badge-mid">Mid-level</span>
            <span class="cp-badge badge-blue">React</span>
            <span class="cp-badge badge-gray">Next.js</span>
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p style="font-size:16px;font-weight:700;color:var(--primary);margin:0">$90k – $115k</p>
              <p class="text-muted-cp" style="font-size:12px;margin:0">+ 0.2% equity</p>
            </div>
            <div class="d-flex gap-2">
              <button onclick="openJobModal('StartupCo','React Developer','$90k – $115k','Remote','Mid-level','Be the 3rd frontend engineer at a seed-stage SaaS startup. Shape the product from day one and grow into a senior role within 12 months.')" class="btn-cp btn-secondary-cp btn-cp-sm">Details</button>
              <button onclick="openApplyModal('StartupCo','React Developer')" class="btn-cp btn-primary-cp btn-cp-sm">Apply</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Job 4 -->
      <div class="col-lg-6">
        <div class="job-card">
          <div class="d-flex align-items-start gap-3">
            <div class="company-avatar" style="background:rgba(59,130,246,0.15);color:#60a5fa">DF</div>
            <div class="flex-grow-1">
              <h5 style="font-size:15px;font-weight:600;margin:0 0 2px">UI/UX Engineer</h5>
              <p class="text-muted-cp" style="font-size:13px;margin:0">DesignForward</p>
            </div>
          </div>
          <p style="font-size:13px;color:#d1d5db;line-height:1.5;margin:0">Bridge the gap between design and engineering. Work with Figma, React, and a world-class design team to deliver polished, accessible interfaces.</p>
          <div class="d-flex flex-wrap gap-2">
            <span class="cp-badge badge-hybrid">Hybrid</span>
            <span class="cp-badge badge-mid">Mid-level</span>
            <span class="cp-badge badge-blue">Figma</span>
            <span class="cp-badge badge-gray">React</span>
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p style="font-size:16px;font-weight:700;color:var(--primary);margin:0">$100k – $120k</p>
              <p class="text-muted-cp" style="font-size:12px;margin:0">San Francisco, CA</p>
            </div>
            <div class="d-flex gap-2">
              <button onclick="openJobModal('DesignForward','UI/UX Engineer','$100k – $120k','Hybrid — San Francisco','Mid-level','Bridge the gap between design and engineering. Work with Figma, React, and a world-class design team to deliver polished, accessible interfaces for millions of users.')" class="btn-cp btn-secondary-cp btn-cp-sm">Details</button>
              <button onclick="openApplyModal('DesignForward','UI/UX Engineer')" class="btn-cp btn-primary-cp btn-cp-sm">Apply</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Job 5 -->
      <div class="col-lg-6">
        <div class="job-card">
          <div class="d-flex align-items-start gap-3">
            <div class="company-avatar" style="background:rgba(245,197,66,0.12);color:var(--primary)">CB</div>
            <div class="flex-grow-1">
              <h5 style="font-size:15px;font-weight:600;margin:0 0 2px">Software Engineer — Frontend</h5>
              <p class="text-muted-cp" style="font-size:13px;margin:0">CloudBase</p>
            </div>
          </div>
          <p style="font-size:13px;color:#d1d5db;line-height:1.5;margin:0">Work on CloudBase's developer-facing dashboard used by 50,000+ companies. Own critical infrastructure and shape the future of cloud tooling.</p>
          <div class="d-flex flex-wrap gap-2">
            <span class="cp-badge badge-remote">Remote</span>
            <span class="cp-badge badge-senior">Senior</span>
            <span class="cp-badge badge-blue">React</span>
            <span class="cp-badge badge-gray">AWS</span>
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p style="font-size:16px;font-weight:700;color:var(--primary);margin:0">$120k – $145k</p>
              <p class="text-muted-cp" style="font-size:12px;margin:0">+ RSUs</p>
            </div>
            <div class="d-flex gap-2">
              <button onclick="openJobModal('CloudBase','Software Engineer — Frontend','$120k – $145k + RSUs','Remote','Senior','Work on CloudBase\'s developer-facing dashboard used by 50,000+ companies. You will own critical UI infrastructure and shape the future of cloud developer tooling.')" class="btn-cp btn-secondary-cp btn-cp-sm">Details</button>
              <button onclick="openApplyModal('CloudBase','Software Engineer — Frontend')" class="btn-cp btn-primary-cp btn-cp-sm">Apply</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Job 6 -->
      <div class="col-lg-6">
        <div class="job-card">
          <div class="d-flex align-items-start gap-3">
            <div class="company-avatar" style="background:rgba(139,92,246,0.15);color:var(--accent)">MT</div>
            <div class="flex-grow-1">
              <h5 style="font-size:15px;font-weight:600;margin:0 0 2px">Frontend Architect</h5>
              <p class="text-muted-cp" style="font-size:13px;margin:0">MegaTech</p>
            </div>
          </div>
          <p style="font-size:13px;color:#d1d5db;line-height:1.5;margin:0">Lead the front-end architecture for MegaTech's flagship product suite. Drive technical strategy, performance benchmarking, and platform decisions.</p>
          <div class="d-flex flex-wrap gap-2">
            <span class="cp-badge badge-remote">Remote</span>
            <span class="cp-badge badge-senior">Senior</span>
            <span class="cp-badge badge-blue">Architecture</span>
            <span class="cp-badge badge-gray">TypeScript</span>
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p style="font-size:16px;font-weight:700;color:var(--primary);margin:0">$150k – $175k</p>
              <p class="text-muted-cp" style="font-size:12px;margin:0">+ equity</p>
            </div>
            <div class="d-flex gap-2">
              <button onclick="openJobModal('MegaTech','Frontend Architect','$150k – $175k + equity','Remote','Senior','Lead the front-end architecture for MegaTech\'s flagship suite. Drive technical strategy, performance benchmarking, and platform decisions across a 20-person engineering org.')" class="btn-cp btn-secondary-cp btn-cp-sm">Details</button>
              <button onclick="openApplyModal('MegaTech','Frontend Architect')" class="btn-cp btn-primary-cp btn-cp-sm">Apply</button>
            </div>
          </div>
        </div>
      </div>

    </div>
@endsection

@push('scripts')
<script>
// Opens a job details modal showing the full job description
// All data is passed as parameters — no dynamic fetching
function openJobModal(company, title, salary, location, level, description) {
  openModal(
    '<div class="p-4">' +
      '<div class="d-flex align-items-start justify-content-between gap-3 mb-3">' +
        '<div><h5 class="fw-bold mb-1">' + title + '</h5><p class="text-muted-cp mb-0" style="font-size:13px">' + company + '</p></div>' +
        '<button onclick="closeModal()" class="btn-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>' +
      '</div>' +
      '<div class="row g-2 mb-3">' +
        '<div class="col-6"><div class="p-2 rounded-3" style="background:var(--secondary)"><p class="text-muted-cp mb-0" style="font-size:11px">Salary</p><p class="fw-semibold mb-0 text-primary-cp" style="font-size:13px">' + salary + '</p></div></div>' +
        '<div class="col-6"><div class="p-2 rounded-3" style="background:var(--secondary)"><p class="text-muted-cp mb-0" style="font-size:11px">Location</p><p class="fw-semibold mb-0" style="font-size:13px">' + location + '</p></div></div>' +
        '<div class="col-6"><div class="p-2 rounded-3" style="background:var(--secondary)"><p class="text-muted-cp mb-0" style="font-size:11px">Level</p><p class="fw-semibold mb-0" style="font-size:13px">' + level + '</p></div></div>' +
        '<div class="col-6"><div class="p-2 rounded-3" style="background:var(--secondary)"><p class="text-muted-cp mb-0" style="font-size:11px">Type</p><p class="fw-semibold mb-0" style="font-size:13px">Full-time</p></div></div>' +
      '</div>' +
      '<p style="font-size:14px;line-height:1.65;color:#d1d5db;margin-bottom:16px">' + description + '</p>' +
      '<div class="d-flex gap-2">' +
        '<button onclick="closeModal()" class="btn-cp btn-outline-cp flex-fill justify-content-center">Close</button>' +
        '<button onclick="closeModal()" class="btn-cp btn-primary-cp flex-fill justify-content-center">Apply Now</button>' +
      '</div>' +
    '</div>'
  );
}

// Opens a simple application confirmation modal
// UI-only: shows a form, no submission logic
function openApplyModal(company, title) {
  openModal(
    '<div class="p-4">' +
      '<div class="d-flex align-items-center justify-content-between mb-3">' +
        '<h5 class="fw-bold mb-0">Apply for ' + title + '</h5>' +
        '<button onclick="closeModal()" class="btn-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>' +
      '</div>' +
      '<p class="text-muted-cp mb-3" style="font-size:13px">Applying to <strong style="color:#fff">' + company + '</strong></p>' +
      '<div class="mb-3"><label class="cp-label">Cover Letter <span class="text-muted-cp">(optional)</span></label><textarea class="cp-input" placeholder="Tell us why you are a great fit for this role…"></textarea></div>' +
      '<div class="mb-3"><label class="cp-label">Resume</label><div class="d-flex align-items-center gap-2 p-2 rounded-3" style="background:var(--secondary);border:1px solid var(--border)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:var(--primary)"><path stroke-linecap="round" stroke-linejoin="round" d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg><span style="font-size:13px">Daniel_Smith_Resume.pdf</span></div></div>' +
      '<div class="d-flex gap-2">' +
        '<button onclick="closeModal()" class="btn-cp btn-outline-cp flex-fill justify-content-center">Cancel</button>' +
        '<button onclick="closeModal()" class="btn-cp btn-primary-cp flex-fill justify-content-center">Submit Application</button>' +
      '</div>' +
    '</div>'
  );
}
</script>
@endpush
