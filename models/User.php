<?php
/**
 * User Model
 * Handles user-related database operations
 */

require_once __DIR__ . '/../includes/db.php';

class User {
    /**
     * Register a new user
     */
    public static function register($username, $email, $password) {
        $db = getDB();
        
        // Check if username or email already exists
        $stmt = $db->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            return ['success' => false, 'message' => 'Username or email already exists'];
        }
        
        // Hash password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert user
        $stmt = $db->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
        if ($stmt->execute([$username, $email, $passwordHash])) {
            return ['success' => true, 'user_id' => $db->lastInsertId()];
        }
        
        return ['success' => false, 'message' => 'Registration failed'];
    }
    
    /**
     * Authenticate user
     */
    public static function authenticate($identifier, $password) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$identifier, $identifier]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password_hash'])) {
            return $user;
        }
        
        return false;
    }
    
    /**
     * Update password
     */
    public static function updatePassword($userId, $newPassword) {
        $db = getDB();
        $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $db->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        return $stmt->execute([$passwordHash, $userId]);
    }
    
    /**
     * Toggle dark mode
     */
    public static function toggleDarkMode($userId) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE users SET dark_mode = NOT dark_mode WHERE id = ?");
        return $stmt->execute([$userId]);
    }
    
    /**
     * Get dark mode preference
     */
    public static function getDarkMode($userId) {
        $db = getDB();
        $stmt = $db->prepare("SELECT dark_mode FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $result = $stmt->fetch();
        return $result['dark_mode'] ?? 0;
    }
}

