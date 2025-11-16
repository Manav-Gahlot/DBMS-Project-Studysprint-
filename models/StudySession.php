<?php
/**
 * Study Session Model
 * Handles study session-related database operations
 */

require_once __DIR__ . '/../includes/db.php';

class StudySession {
    /**
     * Log a study session
     */
    public static function logSession($userId, $topic, $durationMinutes) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO study_sessions (user_id, topic, duration_minutes, timestamp) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$userId, $topic, $durationMinutes]);
    }
    
    /**
     * Get user's total study time
     */
    public static function getTotalTime($userId) {
        $db = getDB();
        $stmt = $db->prepare("SELECT SUM(duration_minutes) as total FROM study_sessions WHERE user_id = ?");
        $stmt->execute([$userId]);
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }
    
    /**
     * Get daily study time for a date range
     */
    public static function getDailyTime($userId, $startDate, $endDate) {
        $db = getDB();
        $stmt = $db->prepare("
            SELECT DATE(timestamp) as date, SUM(duration_minutes) as total_minutes 
            FROM study_sessions 
            WHERE user_id = ? AND DATE(timestamp) BETWEEN ? AND ?
            GROUP BY DATE(timestamp)
            ORDER BY date
        ");
        $stmt->execute([$userId, $startDate, $endDate]);
        return $stmt->fetchAll();
    }
    
    /**
     * Get weekly study time
     */
    public static function getWeeklyTime($userId, $weekStart) {
        $db = getDB();
        $weekEnd = date('Y-m-d', strtotime($weekStart . ' +6 days'));
        $stmt = $db->prepare("
            SELECT SUM(duration_minutes) as total 
            FROM study_sessions 
            WHERE user_id = ? AND DATE(timestamp) BETWEEN ? AND ?
        ");
        $stmt->execute([$userId, $weekStart, $weekEnd]);
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }
    
    /**
     * Get sessions by topic
     */
    public static function getSessionsByTopic($userId, $limit = 10) {
        $db = getDB();
        $stmt = $db->prepare("
            SELECT topic, SUM(duration_minutes) as total 
            FROM study_sessions 
            WHERE user_id = ? 
            GROUP BY topic 
            ORDER BY total DESC 
            LIMIT ?
        ");
        $stmt->execute([$userId, $limit]);
        return $stmt->fetchAll();
    }
    
    /**
     * Get recent sessions
     */
    public static function getRecentSessions($userId, $limit = 10) {
        $db = getDB();
        $stmt = $db->prepare("
            SELECT topic, duration_minutes, timestamp FROM study_sessions 
            WHERE user_id = ? 
            ORDER BY timestamp DESC 
            LIMIT ?
        ");
        $stmt->execute([$userId, $limit]);
        return $stmt->fetchAll();
    }
    
    /**
     * Get all sessions for CSV export
     */
    public static function getAllSessions($userId) {
        $db = getDB();
        $stmt = $db->prepare("
            SELECT topic, duration_minutes, timestamp 
            FROM study_sessions 
            WHERE user_id = ? 
            ORDER BY timestamp DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}



