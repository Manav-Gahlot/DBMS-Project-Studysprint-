<?php
/**
 * StudySprint Configuration File
 * Database connection and application settings
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_PORT', '3306'); // MySQL port (default: 3306, change if your MySQL uses a different port)
define('DB_NAME', 'studysprint');
define('DB_USER', 'root');
define('DB_PASS', ''); // Default XAMPP password (empty)

// Application settings
define('APP_NAME', 'StudySprint');

// Auto-detect BASE_URL based on script location
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$script = $_SERVER['SCRIPT_NAME'];

// Determine if we're in public folder or root
if (strpos($script, '/public/') !== false) {
    // Script is in public folder
    $path = str_replace('/public', '', dirname($script));
} else {
    // Script might be in root or elsewhere
    $path = dirname($script);
}

$path = rtrim($path, '/') . '/';
define('BASE_URL', $protocol . '://' . $host . $path);
define('BASE_PATH', __DIR__ . '/');
define('ASSETS_URL', BASE_URL . 'assets/');
define('CONTROLLERS_URL', BASE_URL . 'controllers/');

// Session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Set to 1 if using HTTPS
session_start();

// Timezone
date_default_timezone_set('UTC');

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session timeout (30 minutes of inactivity)
define('SESSION_TIMEOUT', 1800); // 30 minutes in seconds

