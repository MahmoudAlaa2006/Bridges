<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bridges — AI Recruitment System</title>
  <meta name="description" content="The AI-powered recruitment platform that automates every stage — from application to offer." />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Custom Styles -->
  <link rel="stylesheet" href="{{ asset('css/home.css') }}" />
</head>
<body>

  <!-- ============================================================
       TOP BAR
       ============================================================ -->
  <header id="topbar">
    <div class="container d-flex align-items-center justify-content-between">

      <!-- Brand -->
      <div class="d-flex align-items-center gap-2">
        <div class="brand-logo">
          <!-- Network / nodes icon -->
          <svg viewBox="0 0 24 24">
            <circle cx="12" cy="5"  r="2"/>
            <circle cx="5"  cy="19" r="2"/>
            <circle cx="19" cy="19" r="2"/>
            <line x1="12" y1="7"  x2="5"  y2="17"/>
            <line x1="12" y1="7"  x2="19" y2="17"/>
            <line x1="5"  y1="19" x2="19" y2="19"/>
          </svg>
        </div>
        <span class="brand-name">Bridges</span>
      </div>

      <!-- Auth Buttons -->
      <div class="d-flex align-items-center gap-3">
        @auth
            <a href="{{ url('/dashboard') }}" class="btn btn-login">Dashboard</a>
        @else
            @if (Route::has('login'))
                <a href="{{ route('login') }}" class="btn btn-login d-none d-sm-inline-block">Login</a>
            @endif
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-register">Register</a>
            @endif
        @endauth
      </div>

    </div>
  </header>


  <main style="padding-top: 64px;">

    <!-- ============================================================
         HERO SECTION
         ============================================================ -->
    <section id="hero">
      <div class="hero-glow"></div>

      <div class="container position-relative" style="z-index:1;">
        <div class="row align-items-center g-5">

          <!-- Left: Copy -->
          <div class="col-lg-6 fade-up">
            <div class="hero-badge">
              <span class="badge-dot"></span>
              The future of technical recruiting
            </div>

            <h1 class="hero-title">
              Hire Smarter.<br />
              <span class="highlight">Move Faster.</span>
            </h1>

            <p class="hero-subtitle">
              The AI-powered recruitment platform that automates every stage &mdash; from application to offer.
              Generate exams, conduct live coding sessions, and hire top talent without the manual overhead.
            </p>

            <div class="d-flex flex-column flex-sm-row gap-3">
              @auth
                  <a href="{{ url('/dashboard') }}" class="btn btn-cta-primary">
                    Go to Dashboard
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                      <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                    </svg>
                  </a>
              @else
                  @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-cta-primary">
                      Get Started Free
                      <!-- Arrow right icon -->
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                      </svg>
                    </a>
                  @endif
                  @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="btn btn-cta-secondary">Login to Dashboard</a>
                  @endif
              @endauth
            </div>
          </div>

          <!-- Right: Illustration -->
          <div class="col-lg-6 fade-up delay-2">
            <div class="hero-image-wrap">
              <div class="hero-image-glow"></div>
              <div class="hero-image-card">
                <img src="{{ asset('hero.jpg') }}" alt="AI Recruitment — team collaboration illustration" />
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>


    <!-- ============================================================
         FEATURES SECTION
         ============================================================ -->
    <section id="features">
      <div class="container">

        <!-- Heading -->
        <div class="text-center mb-5 fade-up">
          <p class="section-label">Platform Features</p>
          <h2 class="section-title">
            Everything You Need to <span class="accent">Hire Better</span>
          </h2>
          <p class="section-sub mx-auto">
            An end-to-end platform built for modern engineering teams.
          </p>
        </div>

        <!-- Cards Grid -->
        <div class="row g-4">

          <!-- Card 1 -->
          <div class="col-md-6 col-lg-4 fade-up delay-1">
            <div class="feature-card">
              <div class="feature-icon purple">
                <!-- Network icon -->
                <svg viewBox="0 0 24 24">
                  <circle cx="12" cy="5"  r="2"/><circle cx="5" cy="19" r="2"/><circle cx="19" cy="19" r="2"/>
                  <line x1="12" y1="7" x2="5" y2="17"/><line x1="12" y1="7" x2="19" y2="17"/><line x1="5" y1="19" x2="19" y2="19"/>
                </svg>
              </div>
              <h3 class="feature-title">Smart Recruitment Workflow</h3>
              <p class="feature-desc">Automated pipeline that moves candidates through each stage intelligently based on AI evaluation.</p>
            </div>
          </div>

          <!-- Card 2 -->
          <div class="col-md-6 col-lg-4 fade-up delay-2">
            <div class="feature-card">
              <div class="feature-icon yellow">
                <!-- Brain circuit icon -->
                <svg viewBox="0 0 24 24">
                  <path d="M12 5a3 3 0 1 0-5.997.125 4 4 0 0 0-2.526 5.77 4 4 0 0 0 .556 6.588A4 4 0 1 0 12 18Z"/>
                  <path d="M12 5a3 3 0 1 1 5.997.125 4 4 0 0 1 2.526 5.77 4 4 0 0 1-.556 6.588A4 4 0 1 1 12 18Z"/>
                  <path d="M15 13a4.5 4.5 0 0 1-3-4 4.5 4.5 0 0 1-3 4"/><path d="M17.599 6.5a3 3 0 0 0 .399-1.375"/><path d="M6.003 5.125A3 3 0 0 0 6.401 6.5"/><path d="M3.477 10.896a4 4 0 0 1 .585-.396"/><path d="M19.938 10.5a4 4 0 0 1 .585.396"/><path d="M6 18a4 4 0 0 1-1.967-.516"/><path d="M19.967 17.484A4 4 0 0 1 18 18"/>
                </svg>
              </div>
              <h3 class="feature-title">Automated Candidate Progression</h3>
              <p class="feature-desc">AI filters and advances the right candidates without manual review, saving hundreds of hours.</p>
            </div>
          </div>

          <!-- Card 3 -->
          <div class="col-md-6 col-lg-4 fade-up delay-3">
            <div class="feature-card">
              <div class="feature-icon purple">
                <!-- File code icon -->
                <svg viewBox="0 0 24 24">
                  <path d="M10 12.5 8 15l2 2.5"/><path d="m14 12.5 2 2.5-2 2.5"/>
                  <path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"/>
                </svg>
              </div>
              <h3 class="feature-title">Online Technical Exams</h3>
              <p class="feature-desc">Auto-generated MCQ, written, and coding assessments tailored specifically per role and seniority.</p>
            </div>
          </div>

          <!-- Card 4 -->
          <div class="col-md-6 col-lg-4 fade-up delay-1">
            <div class="feature-card">
              <div class="feature-icon yellow">
                <!-- Terminal icon -->
                <svg viewBox="0 0 24 24">
                  <rect width="20" height="16" x="2" y="4" rx="2"/>
                  <path d="m9 10-2 2 2 2"/><path d="m13 14 2-2-2-2"/><line x1="11" y1="14" x2="13" y2="14"/>
                </svg>
              </div>
              <h3 class="feature-title">Live Coding Interviews</h3>
              <p class="feature-desc">Integrated IDE for real-time collaborative coding sessions with candidates directly in the browser.</p>
            </div>
          </div>

          <!-- Card 5 -->
          <div class="col-md-6 col-lg-4 fade-up delay-2">
            <div class="feature-card">
              <div class="feature-icon purple">
                <!-- Line chart icon -->
                <svg viewBox="0 0 24 24">
                  <path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/>
                </svg>
              </div>
              <h3 class="feature-title">AI-Assisted HR Management</h3>
              <p class="feature-desc">Smart recommendations, analytics, and insights for your HR team to make data-driven decisions.</p>
            </div>
          </div>

          <!-- Card 6 -->
          <div class="col-md-6 col-lg-4 fade-up delay-3">
            <div class="feature-card">
              <div class="feature-icon yellow">
                <!-- Clipboard list icon -->
                <svg viewBox="0 0 24 24">
                  <rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                  <path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/>
                </svg>
              </div>
              <h3 class="feature-title">Job Application Tracking</h3>
              <p class="feature-desc">Real-time status updates for every application in your pipeline with automated candidate communication.</p>
            </div>
          </div>

        </div><!-- /row -->
      </div>
    </section>


    <!-- ============================================================
         HOW IT WORKS
         ============================================================ -->
    <section id="how-it-works">
      <div class="how-glow"></div>

      <div class="container position-relative" style="z-index:1;">

        <!-- Heading -->
        <div class="text-center mb-5 fade-up">
          <p class="section-label">The Process</p>
          <h2 class="section-title">Four Simple Steps</h2>
          <p class="section-sub mx-auto">A seamless experience for both recruiters and candidates.</p>
        </div>

        <!-- Steps -->
        <div class="row g-4 position-relative">
          <!-- Horizontal connector line (desktop only) -->
          <div class="d-none d-md-block position-absolute"
               style="top: 32px; left: calc(50%/4 + 12px); right: calc(50%/4 + 12px); height: 2px; background: var(--border); z-index: 0;"></div>

          <!-- Step 1 -->
          <div class="col-6 col-md-3 fade-up delay-1">
            <div class="step-card">
              <div class="step-number">01</div>
              <h4 class="step-title">Apply</h4>
              <p class="step-desc">Candidates browse and apply for open positions easily.</p>
            </div>
          </div>

          <!-- Step 2 -->
          <div class="col-6 col-md-3 fade-up delay-2">
            <div class="step-card">
              <div class="step-number">02</div>
              <h4 class="step-title">Take Exam</h4>
              <p class="step-desc">Auto-generated assessments filter qualified talent.</p>
            </div>
          </div>

          <!-- Step 3 -->
          <div class="col-6 col-md-3 fade-up delay-3">
            <div class="step-card">
              <div class="step-number">03</div>
              <h4 class="step-title">Attend Interview</h4>
              <p class="step-desc">Live coding sessions with your technical team.</p>
            </div>
          </div>

          <!-- Step 4 -->
          <div class="col-6 col-md-3 fade-up delay-4">
            <div class="step-card">
              <div class="step-number">04</div>
              <h4 class="step-title">Receive Offer</h4>
              <p class="step-desc">Successful candidates get offers through the platform.</p>
            </div>
          </div>

        </div>
      </div>
    </section>

  </main>


  <!-- ============================================================
       FOOTER
       ============================================================ -->
  <footer id="footer">
    <div class="container">

      <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-4 mb-4">

        <!-- Brand -->
        <div class="d-flex align-items-center gap-2">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#9333ea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="5"  r="2"/><circle cx="5"  cy="19" r="2"/><circle cx="19" cy="19" r="2"/>
            <line x1="12" y1="7"  x2="5"  y2="17"/><line x1="12" y1="7"  x2="19" y2="17"/><line x1="5"  y1="19" x2="19" y2="19"/>
          </svg>
          <span class="footer-brand">Bridges</span>
        </div>

        <!-- Tagline -->
        <p class="footer-tagline mb-0 text-center">
          The AI-powered recruitment platform for modern teams.
        </p>

        <!-- Links -->
        <div class="d-flex gap-4">
          <a href="#" class="footer-link">Privacy Policy</a>
          <a href="#" class="footer-link">Terms of Service</a>
          <a href="#" class="footer-link">Contact</a>
        </div>
      </div>

      <hr class="footer-divider" />

      <p class="footer-copy text-center mb-0">&copy; 2024 Bridges. All rights reserved.</p>

    </div>
  </footer>


  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom Script -->
  <script src="{{ asset('js/home.js') }}"></script>

</body>
</html>
