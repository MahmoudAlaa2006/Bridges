<h1 class="page-title">@yield('header-title')</h1>
    <div class="header-actions">
      @yield('header-actions-prefix')

      <!-- Notifications dropdown -->
      <div class="header-dropdown-wrap">
        <button id="notif-btn" class="btn-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path stroke-linecap="round" stroke-linejoin="round" d="M13.73 21a2 2 0 01-3.46 0"/></svg>
          <span class="notif-count">3</span>
        </button>
        <div id="notif-dropdown" class="cp-dropdown notif-dropdown hidden">
          <div class="cp-dropdown-header">Notifications</div>
          <div class="notif-item d-flex gap-2">
            <div class="notif-dot mt-1"></div>
            <div>
              <div class="notif-item-title">Interview Scheduled</div>
              <div class="notif-item-msg">Your interview with TechCorp is scheduled for May 15 at 10:00 AM</div>
              <div class="notif-item-time">2 hours ago</div>
            </div>
          </div>
          <div class="notif-item d-flex gap-2">
            <div class="notif-dot mt-1"></div>
            <div>
              <div class="notif-item-title">Exam Reminder</div>
              <div class="notif-item-msg">Technical assessment for your application starts in 3 hours</div>
              <div class="notif-item-time">3 hours ago</div>
            </div>
          </div>
          <div class="notif-item read d-flex gap-2">
            <div class="notif-dot mt-1" style="background:var(--border)"></div>
            <div>
              <div class="notif-item-title">Application Update</div>
              <div class="notif-item-msg">Your application status has been updated to Exam</div>
              <div class="notif-item-time">1 day ago</div>
            </div>
          </div>
        </div>
      </div>

      <!-- User dropdown -->
      <div class="header-dropdown-wrap">
        <button id="user-btn" class="user-btn">
          <div class="user-avatar">DS</div>
          <span class="user-name d-none d-md-block">Daniel Smith</span>
        </button>
        <div id="user-dropdown" class="cp-dropdown hidden">
          <div class="cp-dropdown-header">My Account</div>
          <a href="{{ url('profile') }}" class="cp-dropdown-item">Profile</a>
          <a href="#" class="cp-dropdown-item">Settings</a>
          <div class="cp-dropdown-divider"></div>
          <button class="cp-dropdown-item danger">Log out</button>
        </div>
      </div>
    </div>