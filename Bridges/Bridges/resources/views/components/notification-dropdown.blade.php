<div class="header-dropdown-wrap">
  <button id="notif-btn" class="btn-icon" onclick="toggleDropdown('notif-dropdown')">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path stroke-linecap="round" stroke-linejoin="round" d="M13.73 21a2 2 0 01-3.46 0"/></svg>
    @if ($unreadCount > 0)
      <span class="notif-count" id="notif-badge">{{ $unreadCount }}</span>
    @endif
  </button>
  <div id="notif-dropdown" class="cp-dropdown notif-dropdown">
    <div class="cp-dropdown-header">Notifications</div>
    @forelse ($notifItems as $notif)
      <div class="notif-item {{ $notif['dot'] ? 'unread' : 'read' }} d-flex gap-2" 
           @if(isset($notif['onclick'])) onclick="{{ $notif['onclick'] }}" style="cursor:pointer" @endif>
        <div class="notif-dot mt-1" style="{{ $notif['dot'] ? '' : 'background:var(--border)' }}"></div>
        <div>
          <div class="notif-item-title">{{ $notif['title'] }}</div>
          <div class="notif-item-msg">{{ $notif['msg'] }}</div>
        </div>
      </div>
    @empty
      <div class="notif-item read d-flex gap-2">
        <div class="notif-dot mt-1" style="background:var(--border)"></div>
        <div>
          <div class="notif-item-title">No notifications</div>
          <div class="notif-item-msg">Apply to a job to get started.</div>
        </div>
      </div>
    @endforelse
  </div>
</div>