<?php
/**
 * Settings Page
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../controllers/settings_controller.php';

requireLogin();

$userId = getCurrentUserId();
$darkMode = User::getDarkMode($userId);

$pageTitle = 'Settings';
include __DIR__ . '/includes/header.php';
?>

<div class="row mb-4">
    <div class="col-md-12">
        <h2><i class="bi bi-gear"></i> Settings</h2>
        <p class="text-muted">Manage your account settings and preferences</p>
    </div>
</div>

<div class="row">
    <!-- Change Password -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-key"></i> Change Password</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <input type="hidden" name="action" value="change_password">
                    
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required minlength="6">
                        <small class="text-muted">Must be at least 6 characters</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required minlength="6">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Preferences -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0"><i class="bi bi-palette"></i> Preferences</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Dark Mode</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="darkModeSwitch" <?php echo $darkMode ? 'checked' : ''; ?> onchange="toggleDarkMode()">
                        <label class="form-check-label" for="darkModeSwitch">
                            Enable dark mode
                        </label>
                    </div>
                </div>
                
                <div class="alert alert-info">
                    <small><i class="bi bi-info-circle"></i> Dark mode preference is saved automatically.</small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleDarkMode() {
    // Use the function from main.js if available
    if (typeof toggleDarkModeInDB === 'function') {
        toggleDarkModeInDB();
    } else {
        // Fallback if main.js not loaded
        const formData = new FormData();
        formData.append('action', 'toggle_dark_mode');
        
        fetch(CONTROLLERS_URL + 'settings_controller.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        });
    }
}
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>

