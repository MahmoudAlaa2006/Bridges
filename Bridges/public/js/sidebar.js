/**
 * SIDEBAR BEHAVIOR
 * Handles sidebar collapse, mobile toggle, and active state persistence if needed.
 */
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const topbar = document.getElementById('topbar');
    const brandToggle = document.querySelector('.brand-toggle');

    // Sidebar Collapse Toggle (Desktop)
    if (brandToggle && sidebar) {
        brandToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            
            if (mainContent) {
                mainContent.classList.toggle('expanded');
            }
            
            // Dispatch event for other components to adjust (like charts)
            window.dispatchEvent(new Event('resize'));
        });
    }

    // Mobile Sidebar Toggle
    const mobileToggle = document.querySelector('.mobile-sidebar-toggle');
    if (mobileToggle && sidebar) {
        mobileToggle.addEventListener('click', function() {
            sidebar.classList.toggle('mobile-open');
            
            // Create backdrop if it doesn't exist
            let backdrop = document.querySelector('.sidebar-backdrop');
            if (!backdrop) {
                backdrop = document.createElement('div');
                backdrop.className = 'sidebar-backdrop';
                document.body.appendChild(backdrop);
                
                backdrop.addEventListener('click', function() {
                    sidebar.classList.remove('mobile-open');
                    backdrop.remove();
                });
            } else {
                backdrop.remove();
            }
        });
    }
});
