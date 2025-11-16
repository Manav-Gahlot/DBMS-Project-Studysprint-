<?php
/**
 * Authentication Controller
 * Handles login, registration, and logout
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../models/User.php';

// Handle registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
    $username = sanitizeInput($_POST['username'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    // Validation
    if (empty($username) || empty($email) || empty($password)) {
        setFlashMessage('error', 'All fields are required');
        header('Location: ' . BASE_URL . 'public/register.php');
        exit();
    }
    
    if (!validateEmail($email)) {
        setFlashMessage('error', 'Invalid email address');
        header('Location: ' . BASE_URL . 'public/register.php');
        exit();
    }
    
    if (strlen($password) < 6) {
        setFlashMessage('error', 'Password must be at least 6 characters');
        header('Location: ' . BASE_URL . 'public/register.php');
        exit();
    }
    
    if ($password !== $confirmPassword) {
        setFlashMessage('error', 'Passwords do not match');
        header('Location: ' . BASE_URL . 'public/register.php');
        exit();
    }
    
    // Register user
    $result = User::register($username, $email, $password);
    if ($result['success']) {
        setFlashMessage('success', 'Registration successful! Please login.');
        header('Location: ' . BASE_URL . 'public/login.php');
    } else {
        setFlashMessage('error', $result['message']);
        header('Location: ' . BASE_URL . 'public/register.php');
    }
    exit();
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $identifier = sanitizeInput($_POST['identifier'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($identifier) || empty($password)) {
        setFlashMessage('error', 'Username/email and password are required');
        header('Location: ' . BASE_URL . 'public/login.php');
        exit();
    }
    
    $user = User::authenticate($identifier, $password);
    if ($user) {
        loginUser($user['id'], $user['username']);
        setFlashMessage('success', 'Welcome back, ' . $user['username'] . '!');
        header('Location: ' . BASE_URL . 'public/index.php');
    } else {
        setFlashMessage('error', 'Invalid username/email or password');
        header('Location: ' . BASE_URL . 'public/login.php');
    }
    exit();
}

// Handle logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logoutUser();
    setFlashMessage('success', 'You have been logged out successfully');
    header('Location: ' . BASE_URL . 'public/login.php');
    exit();
}

