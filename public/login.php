<?php
/**
 * Login Page
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../controllers/auth_controller.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header('Location: ' . BASE_URL . 'index.php');
    exit();
}

$pageTitle = 'Login';
include __DIR__ . '/includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <i class="bi bi-stopwatch display-1 text-primary"></i>
                    <h2 class="mt-3">Welcome to StudySprint</h2>
                    <p class="text-muted">Login to continue your study journey</p>
                </div>
                
                <form method="POST" action="">
                    <input type="hidden" name="action" value="login">
                    
                    <div class="mb-3">
                        <label for="identifier" class="form-label">Username or Email</label>
                        <input type="text" class="form-control" id="identifier" name="identifier" required autofocus>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </button>
                    </div>
                </form>
                
                <div class="text-center mt-4">
                    <p class="mb-0">Don't have an account? <a href="register.php">Register here</a></p>
                </div>
                
                <div class="alert alert-info mt-4">
                    <small><strong>Demo Users:</strong><br>
                    Username: john_doe, jane_smith, alex_chen<br>
                    Password: demo123</small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>

