
@section('content')

    <div class="mb-4">
      <h2 class="section-title">My Profile</h2>
      <p class="section-sub">Manage your personal information and application materials.</p>
    </div>

    <div class="row g-4">
      <!-- Left column: profile card + CV -->
      <div class="col-lg-4">

        <!-- Profile Card -->
        <div class="cp-card p-4 mb-3 text-center">
          <div style="width:80px;height:80px;border-radius:50%;background:var(--primary);color:var(--primary-fg);display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:700;margin:0 auto 16px">DS</div>
          <h3 style="font-size:18px;font-weight:700;margin:0 0 4px">Daniel Smith</h3>
          <p class="text-muted-cp" style="font-size:14px;margin:0 0 12px">Senior Software Engineer</p>
          <div class="d-flex justify-content-center gap-2 flex-wrap mb-3">
            <span class="cp-badge badge-blue">React</span>
            <span class="cp-badge badge-purple">TypeScript</span>
            <span class="cp-badge badge-green">Node.js</span>
          </div>
          <button onclick="openEditModal()" class="btn-cp btn-secondary-cp w-100 justify-content-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Edit Profile
          </button>
        </div>

        <!-- CV Upload -->
        <div class="cp-card p-4">
          <h4 style="font-size:14px;font-weight:600;margin-bottom:12px">Resume / CV</h4>
          <div class="d-flex align-items-center gap-3 mb-3 p-3" style="background:var(--secondary);border-radius:8px;border:1px solid var(--border)">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="color:var(--primary)"><path stroke-linecap="round" stroke-linejoin="round" d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            <div>
              <p style="font-size:13px;font-weight:600;margin:0">Daniel_Smith_Resume.pdf</p>
              <p class="text-muted-cp" style="font-size:11px;margin:0">Uploaded April 18, 2026 &nbsp;·&nbsp; 1.2 MB</p>
            </div>
          </div>
          <div class="upload-zone">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="color:var(--muted-fg);margin-bottom:8px"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path stroke-linecap="round" stroke-linejoin="round" d="M20.39 18.39A5 5 0 0018 9h-1.26A8 8 0 103 16.3"/></svg>
            <p style="font-size:13px;color:var(--muted-fg);margin:0">Drop a new CV here or <span style="color:var(--primary)">browse</span></p>
            <p class="text-muted-cp" style="font-size:11px;margin-top:4px">PDF, DOC up to 5 MB</p>
          </div>
        </div>
      </div>

      <!-- Right column: info sections -->
      <div class="col-lg-8">

        <!-- Personal Info -->
        <div class="cp-card p-4 mb-3">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 style="font-size:15px;font-weight:600;margin:0">Personal Information</h4>
          </div>
          <div class="row g-3">
            <div class="col-sm-6">
              <p class="cp-label" style="font-size:11px;text-transform:uppercase;letter-spacing:.05em;color:var(--muted-fg)">Full Name</p>
              <p style="font-size:14px;font-weight:500;margin:0">Daniel Smith</p>
            </div>
            <div class="col-sm-6">
              <p class="cp-label" style="font-size:11px;text-transform:uppercase;letter-spacing:.05em;color:var(--muted-fg)">Age</p>
              <p style="font-size:14px;font-weight:500;margin:0">28 years old</p>
            </div>
            <div class="col-sm-6">
              <p class="cp-label" style="font-size:11px;text-transform:uppercase;letter-spacing:.05em;color:var(--muted-fg)">Email</p>
              <p style="font-size:14px;font-weight:500;margin:0">daniel.smith@email.com</p>
            </div>
            <div class="col-sm-6">
              <p class="cp-label" style="font-size:11px;text-transform:uppercase;letter-spacing:.05em;color:var(--muted-fg)">Phone</p>
              <p style="font-size:14px;font-weight:500;margin:0">+1 (555) 123-4567</p>
            </div>
            <div class="col-sm-6">
              <p class="cp-label" style="font-size:11px;text-transform:uppercase;letter-spacing:.05em;color:var(--muted-fg)">Location</p>
              <p style="font-size:14px;font-weight:500;margin:0">San Francisco, CA, United States</p>
            </div>
            <div class="col-sm-6">
              <p class="cp-label" style="font-size:11px;text-transform:uppercase;letter-spacing:.05em;color:var(--muted-fg)">LinkedIn</p>
              <a href="#" style="font-size:14px;font-weight:500;color:var(--primary);text-decoration:none">linkedin.com/in/danielsmith</a>
            </div>
            <div class="col-sm-6">
              <p class="cp-label" style="font-size:11px;text-transform:uppercase;letter-spacing:.05em;color:var(--muted-fg)">Field</p>
              <p style="font-size:14px;font-weight:500;margin:0">Software Engineering</p>
            </div>
            <div class="col-sm-6">
              <p class="cp-label" style="font-size:11px;text-transform:uppercase;letter-spacing:.05em;color:var(--muted-fg)">Experience</p>
              <p style="font-size:14px;font-weight:500;margin:0">6 years</p>
            </div>
          </div>
        </div>

        <!-- About -->
        <div class="cp-card p-4 mb-3">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 style="font-size:15px;font-weight:600;margin:0">About Me</h4>
          </div>
          <p style="font-size:14px;line-height:1.65;color:#d1d5db;margin:0">Passionate full-stack developer with 6 years of expertise in React, TypeScript, and Node.js. I love building scalable applications and solving complex engineering problems. Previously at Google and Stripe, I bring a strong product mindset and a deep appreciation for developer experience.</p>
        </div>

        <!-- Skills -->
        <div class="cp-card p-4 mb-3">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 style="font-size:15px;font-weight:600;margin:0">Skills</h4>
          </div>
          <div class="d-flex flex-wrap gap-2">
            <span class="skill-chip">React</span>
            <span class="skill-chip">TypeScript</span>
            <span class="skill-chip">Node.js</span>
            <span class="skill-chip">GraphQL</span>
            <span class="skill-chip">Next.js</span>
            <span class="skill-chip">PostgreSQL</span>
            <span class="skill-chip">Docker</span>
            <span class="skill-chip">AWS</span>
            <span class="skill-chip">Git</span>
            <span class="skill-chip">REST APIs</span>
            <span class="skill-chip">Tailwind CSS</span>
            <span class="skill-chip">Figma</span>
          </div>
        </div>

        <!-- Work Experience -->
        <div class="cp-card p-4">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 style="font-size:15px;font-weight:600;margin:0">Work Experience</h4>
          </div>
          <div class="d-flex flex-column gap-3">
            <div class="d-flex gap-3" style="padding-bottom:16px;border-bottom:1px solid var(--border)">
              <div style="width:40px;height:40px;border-radius:8px;background:var(--secondary);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;flex-shrink:0">TC</div>
              <div>
                <p style="font-size:14px;font-weight:600;margin:0">Senior Frontend Engineer</p>
                <p class="text-muted-cp" style="font-size:13px;margin:2px 0">TechCorp Inc. &nbsp;·&nbsp; Jan 2022 – Present</p>
                <p style="font-size:13px;color:#d1d5db;margin-top:6px;line-height:1.5">Led a team of 4 engineers to redesign the core product UI, reducing load time by 40%. Architected a reusable design system used across 3 product lines.</p>
              </div>
            </div>
            <div class="d-flex gap-3" style="padding-bottom:16px;border-bottom:1px solid var(--border)">
              <div style="width:40px;height:40px;border-radius:8px;background:var(--secondary);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;flex-shrink:0">ST</div>
              <div>
                <p style="font-size:14px;font-weight:600;margin:0">Software Engineer</p>
                <p class="text-muted-cp" style="font-size:13px;margin:2px 0">Stripe &nbsp;·&nbsp; Mar 2020 – Dec 2021</p>
                <p style="font-size:13px;color:#d1d5db;margin-top:6px;line-height:1.5">Built and maintained dashboard components for Stripe's merchant portal. Worked closely with design to ship accessible, pixel-perfect interfaces.</p>
              </div>
            </div>
            <div class="d-flex gap-3">
              <div style="width:40px;height:40px;border-radius:8px;background:var(--secondary);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;flex-shrink:0">GG</div>
              <div>
                <p style="font-size:14px;font-weight:600;margin:0">Junior Developer</p>
                <p class="text-muted-cp" style="font-size:13px;margin:2px 0">Google &nbsp;·&nbsp; Jun 2018 – Feb 2020</p>
                <p style="font-size:13px;color:#d1d5db;margin-top:6px;line-height:1.5">Contributed to Google Workspace tooling. Gained deep experience in performance optimization and large-scale JavaScript applications.</p>
              </div>
            </div>
          </div>
        </div>

      </div>
@endsection

@push('scripts')
<script>
// Opens the edit profile modal with a simple static form
// This is a UI-only interaction — no data is saved
function openEditModal() {
  openModal(
    '<div class="p-4">' +
      '<div class="d-flex align-items-center justify-content-between mb-3">' +
        '<h5 class="fw-semibold mb-0">Edit Profile</h5>' +
        '<button onclick="closeModal()" class="btn-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>' +
      '</div>' +
      '<div class="row g-3">' +
        '<div class="col-sm-6"><label class="cp-label">Full Name</label><input class="cp-input" value="Daniel Smith"></div>' +
        '<div class="col-sm-6"><label class="cp-label">Age</label><input class="cp-input" value="28"></div>' +
        '<div class="col-sm-6"><label class="cp-label">Email</label><input class="cp-input" value="daniel.smith@email.com"></div>' +
        '<div class="col-sm-6"><label class="cp-label">Phone</label><input class="cp-input" value="+1 (555) 123-4567"></div>' +
        '<div class="col-sm-6"><label class="cp-label">Field</label><input class="cp-input" value="Software Engineering"></div>' +
        '<div class="col-sm-6"><label class="cp-label">Years of Experience</label><input class="cp-input" value="6"></div>' +
        '<div class="col-12"><label class="cp-label">About Me</label><textarea class="cp-input">Passionate full-stack developer with 6 years of expertise in React, TypeScript, and Node.js.</textarea></div>' +
        '<div class="col-12"><label class="cp-label">LinkedIn</label><input class="cp-input" value="linkedin.com/in/danielsmith"></div>' +
      '</div>' +
      '<div class="d-flex gap-2 mt-3">' +
        '<button onclick="closeModal()" class="btn-cp btn-outline-cp flex-fill justify-content-center">Cancel</button>' +
        '<button onclick="closeModal()" class="btn-cp btn-primary-cp flex-fill justify-content-center">Save Changes</button>' +
      '</div>' +
    '</div>'
  );
}
</script>
@endpush
