<?php
/**
 * Goal Model
 * Handles goal-related database operations
 */

require_once __DIR__ . '/../includes/db.php';

class Goal {
    /**
     * Create a new goal
     */
    public static function create($userId, $goalType, $topic, $targetMinutes) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO goals (user_id, goal_type, topic, target_minutes, progress) VALUES (?, ?, ?, ?, 0)");
        return $stmt->execute([$userId, $goalType, $topic, $targetMinutes]);
    }
    
    /**
     * Get all goals for a user
     */
    public static function getAll($userId) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM goals WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Get goal by ID
     */
    public static function getById($goalId, $userId) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM goals WHERE id = ? AND user_id = ?");
        $stmt->execute([$goalId, $userId]);
        return $stmt->fetch();
    }
    
    /**
     * Update goal
     */
    public static function update($goalId, $userId, $goalType, $topic, $targetMinutes, $progress) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE goals SET goal_type = ?, topic = ?, target_minutes = ?, progress = ? WHERE id = ? AND user_id = ?");
        return $stmt->execute([$goalType, $topic, $targetMinutes, $progress, $goalId, $userId]);
    }
    
    /**
     * Delete goal
     */
    public static function delete($goalId, $userId) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM goals WHERE id = ? AND user_id = ?");
        return $stmt->execute([$goalId, $userId]);
    }
    
    /**
     * Update goal progress
     */
    public static function updateProgress($goalId, $userId, $progress) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE goals SET progress = ? WHERE id = ? AND user_id = ?");
        return $stmt->execute([$progress, $goalId, $userId]);
    }
    
    /**
     * Get goals by type
     */
    public static function getByType($userId, $goalType) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM goals WHERE user_id = ? AND goal_type = ? ORDER BY created_at DESC");
        $stmt->execute([$userId, $goalType]);
        return $stmt->fetchAll();
    }
    
    /**
     * Calculate goal completion percentage
     */
    public static function getCompletionPercentage($goal) {
        if ($goal['target_minutes'] == 0) return 0;
        $percentage = ($goal['progress'] / $goal['target_minutes']) * 100;
        return min(100, max(0, round($percentage, 1)));
    }
}

