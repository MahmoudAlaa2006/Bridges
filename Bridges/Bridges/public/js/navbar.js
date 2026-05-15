/**
 * NAVBAR BEHAVIOR
 * Handles dropdowns and topbar actions.
 */
document.addEventListener('DOMContentLoaded', function() {
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
