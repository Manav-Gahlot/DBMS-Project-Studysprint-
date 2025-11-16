<?php
/**
 * Goal Controller
 * Handles goal CRUD operations
 */

require_once __DIR__ . '/../models/Goal.php';
require_once __DIR__ . '/../models/StudySession.php';

requireLogin();

header('Content-Type: application/json');

$userId = getCurrentUserId();

// Create goal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $goalType = sanitizeInput($_POST['goal_type'] ?? '');
    $topic = sanitizeInput($_POST['topic'] ?? '');
    $targetMinutes = intval($_POST['target_minutes'] ?? 0);
    
    if (empty($goalType) || empty($topic) || $targetMinutes <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid goal data']);
        exit();
    }
    
    if (!in_array($goalType, ['daily', 'weekly'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid goal type']);
        exit();
    }
    
    if (Goal::create($userId, $goalType, $topic, $targetMinutes)) {
        echo json_encode(['success' => true, 'message' => 'Goal created successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create goal']);
    }
    exit();
}

// Update goal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $goalId = intval($_POST['goal_id'] ?? 0);
    $goalType = sanitizeInput($_POST['goal_type'] ?? '');
    $topic = sanitizeInput($_POST['topic'] ?? '');
    $targetMinutes = intval($_POST['target_minutes'] ?? 0);
    $progress = intval($_POST['progress'] ?? 0);
    
    if ($goalId <= 0 || empty($goalType) || empty($topic) || $targetMinutes <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid goal data']);
        exit();
    }
    
    if (Goal::update($goalId, $userId, $goalType, $topic, $targetMinutes, $progress)) {
        echo json_encode(['success' => true, 'message' => 'Goal updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update goal']);
    }
    exit();
}

// Delete goal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $goalId = intval($_POST['goal_id'] ?? 0);
    
    if ($goalId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid goal ID']);
        exit();
    }
    
    if (Goal::delete($goalId, $userId)) {
        echo json_encode(['success' => true, 'message' => 'Goal deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete goal']);
    }
    exit();
}

// Get all goals
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_all') {
    $goals = Goal::getAll($userId);
    $formattedGoals = [];
    foreach ($goals as $goal) {
        $formattedGoals[] = [
            'id' => $goal['id'],
            'goal_type' => $goal['goal_type'],
            'topic' => $goal['topic'],
            'target_minutes' => $goal['target_minutes'],
            'progress' => $goal['progress'],
            'percentage' => Goal::getCompletionPercentage($goal),
            'created_at' => $goal['created_at']
        ];
    }
    echo json_encode(['success' => true, 'goals' => $formattedGoals]);
    exit();
}

// Update progress
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_progress') {
    $goalId = intval($_POST['goal_id'] ?? 0);
    $timeSpent = intval($_POST['time_spent'] ?? 0);

    if ($goalId <= 0 || $timeSpent <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid data']);
        exit();
    }

    $goal = Goal::getById($goalId, $userId);

    if (!$goal) {
        echo json_encode(['success' => false, 'message' => 'Goal not found']);
        exit();
    }

    $newProgress = $goal['progress'] + $timeSpent;

    if (Goal::updateProgress($goalId, $userId, $newProgress)) {
        StudySession::logSession($userId, $goal['topic'], $timeSpent);
        echo json_encode(['success' => true, 'message' => 'Progress updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update progress']);
    }
    exit();
}

