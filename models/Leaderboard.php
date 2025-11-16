<?php
/**
 * Leaderboard Model
 * Handles leaderboard-related database operations
 */

require_once __DIR__ . '/../includes/db.php';

class Leaderboard {
    /**
     * Get top users by total study time
     */
    public static function getTopUsers($limit = 10) {
        $db = getDB();
        $stmt = $db->prepare("
            SELECT u.id, u.username, u.email, COALESCE(SUM(s.duration_minutes), 0) as total_minutes
            FROM users u
            LEFT JOIN study_sessions s ON u.id = s.user_id
            GROUP BY u.id, u.username, u.email
            ORDER BY total_minutes DESC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
    
    /**
     * Get user's rank
     */
    public static function getUserRank($userId) {
        $db = getDB();
        
        // Get user's total time
        $stmt = $db->prepare("SELECT COALESCE(SUM(duration_minutes), 0) as total FROM study_sessions WHERE user_id = ?");
        $stmt->execute([$userId]);
        $userTotal = $stmt->fetch()['total'];
        
        // Count users with more time
        $stmt = $db->prepare("
            SELECT user_id, SUM(duration_minutes) as total
            FROM study_sessions
            WHERE user_id != ?
            GROUP BY user_id
            HAVING SUM(duration_minutes) > ?
        ");
        $stmt->execute([$userId, $userTotal]);
        $rank = count($stmt->fetchAll()) + 1;
        
        return $rank;
    }
    
    /**
     * Get user's position with surrounding users
     */
    public static function getUserPosition($userId) {
        $db = getDB();
        
        // Get user's total
        $stmt = $db->prepare("SELECT COALESCE(SUM(duration_minutes), 0) as total FROM study_sessions WHERE user_id = ?");
        $stmt->execute([$userId]);
        $userTotal = $stmt->fetch()['total'];
        
        // Get all users with totals
        $stmt = $db->prepare("
            SELECT u.id, u.username, u.email, COALESCE(SUM(s.duration_minutes), 0) as total_minutes
            FROM users u
            LEFT JOIN study_sessions s ON u.id = s.user_id
            GROUP BY u.id, u.username, u.email
            ORDER BY total_minutes DESC
        ");
        $stmt->execute();
        $allUsers = $stmt->fetchAll();
        
        $rank = 1;
        foreach ($allUsers as $user) {
            if ($user['id'] == $userId) {
                return ['rank' => $rank, 'total' => $userTotal];
            }
            $rank++;
        }
        
        return ['rank' => count($allUsers), 'total' => $userTotal];
    }
}

