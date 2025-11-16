<?php
/**
 * Leaderboard Controller
 * Handles leaderboard data retrieval
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../models/Leaderboard.php';

requireLogin();

header('Content-Type: application/json');

// Get top users
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_top') {
    $limit = intval($_GET['limit'] ?? 10);
    $topUsers = Leaderboard::getTopUsers($limit);
    $userPosition = Leaderboard::getUserPosition(getCurrentUserId());
    
    echo json_encode([
        'success' => true,
        'users' => $topUsers,
        'user_position' => $userPosition
    ]);
    exit();
}

