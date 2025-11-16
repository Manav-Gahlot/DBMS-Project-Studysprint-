<?php
/**
 * Settings Controller
 * Handles user settings (password change, dark mode)
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../models/User.php';

requireLogin();

// Toggle dark mode
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'toggle_dark_mode') {
    $userId = getCurrentUserId();
    User::toggleDarkMode($userId);
    echo json_encode(['success' => true]);
    exit();
}

// Change password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'change_password') {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $userId = getCurrentUserId();
    
    // Validation
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        setFlashMessage('error', 'All password fields are required');
        header('Location: ' . BASE_URL . 'public/settings.php');
        exit();
    }
    
    if (strlen($newPassword) < 6) {
        setFlashMessage('error', 'New password must be at least 6 characters');
        header('Location: ' . BASE_URL . 'public/settings.php');
        exit();
    }
    
    if ($newPassword !== $confirmPassword) {
        setFlashMessage('error', 'New passwords do not match');
        header('Location: ' . BASE_URL . 'public/settings.php');
        exit();
    }
    
    // Verify current password
    $user = User::authenticate(getCurrentUsername(), $currentPassword);
    if (!$user) {
        setFlashMessage('error', 'Current password is incorrect');
        header('Location: ' . BASE_URL . 'public/settings.php');
        exit();
    }
    
    // Update password
    if (User::updatePassword($userId, $newPassword)) {
        setFlashMessage('success', 'Password changed successfully');
    } else {
        setFlashMessage('error', 'Failed to change password');
    }
    header('Location: ' . BASE_URL . 'public/settings.php');
    exit();
}

