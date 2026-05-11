/**
 * NAVBAR BEHAVIOR
 * Handles dropdowns and topbar actions.
 */
document.addEventListener('DOMContentLoaded', function() {
    const userBtn = document.getElementById('user-btn');
    const userPill = document.querySelector('.user-pill');
    const userDropdown = document.getElementById('user-dropdown');

    const toggleBtn = userBtn || userPill;

    if (toggleBtn && userDropdown) {
        toggleBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('show');
        });
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function() {
        if (userDropdown && userDropdown.classList.contains('show')) {
            userDropdown.classList.remove('show');
        }
    });

    // Handle logout link if it exists in the dropdown
    const logoutLink = document.querySelector('.logout-link');
    if (logoutLink) {
        logoutLink.addEventListener('click', function(e) {
            e.preventDefault();
            const form = document.getElementById('logout-form');
            if (form) form.submit();
        });
    }
});
