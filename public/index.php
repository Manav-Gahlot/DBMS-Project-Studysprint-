<?php
/**
 * Dashboard Home Page
 * Pomodoro Timer and Welcome
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../models/StudySession.php';
require_once __DIR__ . '/../models/Goal.php';
require_once __DIR__ . '/../controllers/auth_controller.php';

// Handle logout if needed
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    require_once __DIR__ . '/../controllers/auth_controller.php';
}

requireLogin();

$userId = getCurrentUserId();
$totalTime = StudySession::getTotalTime($userId);
$recentSessions = StudySession::getRecentSessions($userId, 5);
$dailyGoals = Goal::getByType($userId, 'daily');
$allGoals = Goal::getAll($userId);

$pageTitle = 'Dashboard';
$extraScripts = ['timer.js'];
include __DIR__ . '/includes/header.php';
?>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card bg-primary text-white shadow">
            <div class="card-body">
                <h1 class="card-title">Welcome back, <?php echo htmlspecialchars(getCurrentUsername()); ?>! 👋</h1>
                <p class="card-text">Ready to focus? Start a study session with the Pomodoro timer below.</p>
                <p class="mb-0"><strong>Total Study Time:</strong> <?php echo $totalTime; ?> minutes</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Pomodoro Timer -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-stopwatch"></i> Pomodoro Timer</h5>
            </div>
            <div class="card-body text-center">
                <div id="current-goal-display" class="mb-3" style="display: none;">
                    <h4></h4>
                </div>
                <div class="timer-display mb-4">
                    <div class="display-1 fw-bold text-primary" id="timerDisplay">25:00</div>
                    <div class="mb-3">
                        <span class="badge bg-secondary" id="sessionType">Work Session</span>
                    </div>
                </div>
                
                <div id="timer-setup">
                    <div class="mb-3">
                        <label for="goal-select" class="form-label">Select Goal</label>
                        <select class="form-select" id="goal-select">
                            <option value="">Select a goal</option>
                            <?php foreach ($allGoals as $goal): ?>
                                <option value="<?php echo $goal['id']; ?>"><?php echo htmlspecialchars($goal['topic']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="custom-time" class="form-label">Custom Time (minutes)</label>
                        <input type="number" class="form-control" id="custom-time" placeholder="e.g., 30">
                    </div>
                </div>
                
                <div class="btn-group mb-3" role="group">
                    <button type="button" class="btn btn-outline-primary" id="startBtn">
                        <i class="bi bi-play-fill"></i> Start
                    </button>
                    <button type="button" class="btn btn-outline-warning" id="pauseBtn" disabled>
                        <i class="bi bi-pause-fill"></i> Pause
                    </button>
                    <button type="button" class="btn btn-outline-danger" id="resetBtn">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </button>
                    <button type="button" class="btn btn-outline-info" id="finish-session">
                        <i class="bi bi-check-circle-fill"></i> Finish
                    </button>
                </div>
                
                <div class="alert alert-info" id="timerStatus">
                    Ready to start your study session
                </div>
            </div>
        </div>
    </div>
    
    <!-- Daily Goals -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-bullseye"></i> Daily Goals</h5>
            </div>
            <div class="card-body">
                <?php if (empty($dailyGoals)): ?>
                    <p class="text-muted">No daily goals set. <a href="goals.php">Create one!</a></p>
                <?php else: ?>
                    <?php foreach ($dailyGoals as $goal): ?>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span><strong><?php echo htmlspecialchars($goal['topic']); ?></strong></span>
                                <span><?php echo $goal['progress']; ?> / <?php echo $goal['target_minutes']; ?> min</span>
                            </div>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar" role="progressbar" 
                                     style="width: <?php echo Goal::getCompletionPercentage($goal); ?>%"
                                     aria-valuenow="<?php echo Goal::getCompletionPercentage($goal); ?>" 
                                     aria-valuemin="0" aria-valuemax="100">
                                    <?php echo Goal::getCompletionPercentage($goal); ?>%
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Recent Sessions -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Recent Study Sessions</h5>
            </div>
            <div class="card-body">
                <?php if (empty($recentSessions)): ?>
                    <p class="text-muted">No study sessions yet. Start your first session with the timer above!</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Topic</th>
                                    <th>Duration</th>
                                    <th>Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentSessions as $session): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($session['topic']); ?></td>
                                        <td><?php echo $session['duration_minutes']; ?> minutes</td>
                                        <td><?php echo date('M d, Y H:i', strtotime($session['timestamp'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>

