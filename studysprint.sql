-- StudySprint Database Schema
-- Created for XAMPP MySQL

CREATE DATABASE IF NOT EXISTS studysprint CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE studysprint;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    date_joined DATETIME DEFAULT CURRENT_TIMESTAMP,
    dark_mode TINYINT(1) DEFAULT 0,
    INDEX idx_username (username),
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Study sessions table
CREATE TABLE IF NOT EXISTS study_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    topic VARCHAR(255) NOT NULL,
    duration_minutes INT NOT NULL,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_timestamp (timestamp)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Goals table
CREATE TABLE IF NOT EXISTS goals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    goal_type ENUM('daily', 'weekly') NOT NULL,
    topic VARCHAR(255) NOT NULL,
    target_minutes INT NOT NULL,
    progress INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_goal_type (goal_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert demo users (password for both: 'demo123')
INSERT INTO users (username, email, password_hash) VALUES
('john_doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('jane_smith', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('alex_chen', 'alex@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insert demo study sessions
INSERT INTO study_sessions (user_id, topic, duration_minutes, timestamp) VALUES
(1, 'Mathematics - Calculus', 25, DATE_SUB(NOW(), INTERVAL 1 DAY)),
(1, 'Physics - Mechanics', 30, DATE_SUB(NOW(), INTERVAL 1 DAY)),
(1, 'Mathematics - Algebra', 25, NOW()),
(2, 'Computer Science - Algorithms', 45, DATE_SUB(NOW(), INTERVAL 2 DAY)),
(2, 'Computer Science - Data Structures', 30, DATE_SUB(NOW(), INTERVAL 1 DAY)),
(3, 'Chemistry - Organic Chemistry', 50, DATE_SUB(NOW(), INTERVAL 3 DAY)),
(3, 'Biology - Cell Biology', 25, DATE_SUB(NOW(), INTERVAL 2 DAY));

-- Insert demo goals
INSERT INTO goals (user_id, goal_type, topic, target_minutes, progress) VALUES
(1, 'daily', 'Mathematics', 120, 50),
(1, 'weekly', 'Physics', 300, 30),
(2, 'daily', 'Computer Science', 90, 75),
(2, 'weekly', 'Programming', 500, 150),
(3, 'daily', 'Chemistry', 60, 50),
(3, 'weekly', 'Biology', 200, 25);


