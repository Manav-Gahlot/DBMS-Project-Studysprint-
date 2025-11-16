/**
 * StudySprint Main JavaScript
 * Handles dark mode, flash messages, and general utilities
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize dark mode
    initDarkMode();
    
    // Handle flash messages with SweetAlert2
    handleFlashMessages();
    
    // Auto-hide alerts after 5 seconds
    autoHideAlerts();
    
    // Initialize tooltips
    initTooltips();
});

/**
 * Initialize dark mode from user preference
 */
function initDarkMode() {
    const body = document.body;
    const darkModeToggle = document.getElementById('darkModeToggle');
    
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', function() {
            // Toggle in database first
            toggleDarkModeInDB();
        });
    }
    
    // Update toggle button icon based on current theme
    updateDarkModeIcon();
}

/**
 * Toggle dark mode in database
 */
function toggleDarkModeInDB() {
    const formData = new FormData();
    formData.append('action', 'toggle_dark_mode');
    
    fetch(CONTROLLERS_URL + 'settings_controller.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Toggle UI
            toggleDarkModeUI();
        }
    })
    .catch(error => {
        console.error('Error toggling dark mode:', error);
        // Still toggle UI even if DB update fails
        toggleDarkModeUI();
    });
}

/**
 * Toggle dark mode UI
 */
function toggleDarkModeUI() {
    const body = document.body;
    const currentTheme = body.getAttribute('data-bs-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    body.setAttribute('data-bs-theme', newTheme);
    
    updateDarkModeIcon();
}

/**
 * Update dark mode toggle icon
 */
function updateDarkModeIcon() {
    const toggleBtn = document.getElementById('darkModeToggle');
    if (toggleBtn) {
        const icon = toggleBtn.querySelector('i');
        const currentTheme = document.body.getAttribute('data-bs-theme');
        if (currentTheme === 'dark') {
            icon.className = 'bi bi-sun';
        } else {
            icon.className = 'bi bi-moon-stars';
        }
    }
}

/**
 * Handle flash messages with SweetAlert2
 */
function handleFlashMessages() {
    // Check for flash messages in URL parameters (if needed)
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('message');
    const type = urlParams.get('type');
    
    if (message) {
        showAlert(type || 'info', message);
    }
}

/**
 * Show alert using SweetAlert2
 */
function showAlert(type, message, title = null) {
    const titles = {
        'success': 'Success!',
        'error': 'Error!',
        'warning': 'Warning!',
        'info': 'Info'
    };
    
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: type === 'error' ? 'error' : type,
            title: title || titles[type] || 'Notification',
            text: message,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    }
}

/**
 * Auto-hide Bootstrap alerts
 */
function autoHideAlerts() {
    const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
}

/**
 * Initialize Bootstrap tooltips
 */
function initTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

