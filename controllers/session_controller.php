<?php
/**
 * Study Session Controller
 * Handles study session logging and retrieval
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../models/StudySession.php';

requireLogin();

header('Content-Type: application/json');

// Log study session
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'log_session') {
    $topic = sanitizeInput($_POST['topic'] ?? '');
    $durationMinutes = intval($_POST['duration_minutes'] ?? 0);
    $userId = getCurrentUserId();
    
    if (empty($topic) || $durationMinutes <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid session data']);
        exit();
    }
    
    if (StudySession::logSession($userId, $topic, $durationMinutes)) {
        echo json_encode(['success' => true, 'message' => 'Session logged successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to log session']);
    }
    exit();
}

// Get daily time data (AJAX)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'daily_time') {
    $userId = getCurrentUserId();
    $days = intval($_GET['days'] ?? 7);
    $endDate = date('Y-m-d');
    $startDate = date('Y-m-d', strtotime("-{$days} days"));
    
    $data = StudySession::getDailyTime($userId, $startDate, $endDate);
    echo json_encode(['success' => true, 'data' => $data]);
    exit();
}

// Get weekly goal data (AJAX)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'weekly_stats') {
    $userId = getCurrentUserId();
    require_once __DIR__ . '/../models/Goal.php';
    
    $weekStart = date('Y-m-d', strtotime('monday this week'));
    $weekTime = StudySession::getWeeklyTime($userId, $weekStart);
    $goals = Goal::getByType($userId, 'weekly');
    
    $goalData = [];
    foreach ($goals as $goal) {
        $goalData[] = [
            'topic' => $goal['topic'],
            'progress' => $goal['progress'],
            'target' => $goal['target_minutes'],
            'percentage' => Goal::getCompletionPercentage($goal)
        ];
    }
    
    echo json_encode(['success' => true, 'week_time' => $weekTime, 'goals' => $goalData]);
    exit();
}

// Get topic distribution (AJAX)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'topic_distribution') {
    $userId = getCurrentUserId();
    $data = StudySession::getSessionsByTopic($userId, 10);
    echo json_encode(['success' => true, 'data' => $data]);
    exit();
}

// Export CSV
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'export_csv') {
    $userId = getCurrentUserId();
    $sessions = StudySession::getAllSessions($userId);
    
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="studysprint_export_' . date('Y-m-d') . '.csv"');
    
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Topic', 'Duration (minutes)', 'Timestamp']);
    
    foreach ($sessions as $session) {
        fputcsv($output, [
            $session['topic'],
            $session['duration_minutes'],
            $session['timestamp']
        ]);
    }
    
    fclose($output);
    exit();
}


