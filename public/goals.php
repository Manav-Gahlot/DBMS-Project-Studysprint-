<?php
/**
 * Goals Management Page
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../models/Goal.php';

requireLogin();

$userId = getCurrentUserId();
$goals = Goal::getAll($userId);

$pageTitle = 'My Goals';
$extraScripts = ['goals.js'];
include __DIR__ . '/includes/header.php';
?>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2><i class="bi bi-bullseye"></i> My Goals</h2>
            <button class="btn btn-primary" id="newGoalBtn">
                <i class="bi bi-plus-circle"></i> New Goal
            </button>
        </div>
    </div>
</div>

<div class="row" id="goalsContainer">
    <?php if (empty($goals)): ?>
        <div class="col-12">
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> No goals set yet. Create your first goal to start tracking your progress!
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($goals as $goal): ?>
            <div class="col-md-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="badge bg-<?php echo $goal['goal_type'] === 'daily' ? 'primary' : 'success'; ?>">
                            <?php echo ucfirst($goal['goal_type']); ?>
                        </span>
                        <div>
                            <button class="btn btn-sm btn-outline-primary edit-goal-btn" 
                                    data-goal='<?php echo htmlspecialchars(json_encode($goal)); ?>'>
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger delete-goal-btn" 
                                    data-goal-id="<?php echo $goal['id']; ?>">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($goal['topic']); ?></h5>
                        <div class="mb-2">
                            <small class="text-muted">Target: <?php echo $goal['target_minutes']; ?> minutes</small>
                        </div>
                        <div class="progress mb-2" style="height: 30px;">
                            <div class="progress-bar <?php echo Goal::getCompletionPercentage($goal) >= 100 ? 'bg-success' : ''; ?>" 
                                 role="progressbar" 
                                 style="width: <?php echo Goal::getCompletionPercentage($goal); ?>%"
                                 aria-valuenow="<?php echo Goal::getCompletionPercentage($goal); ?>" 
                                 aria-valuemin="0" aria-valuemax="100">
                                <?php echo Goal::getCompletionPercentage($goal); ?>%
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Progress: <?php echo $goal['progress']; ?> / <?php echo $goal['target_minutes']; ?> min</span>
                            <small class="text-muted">Created: <?php echo date('M d, Y', strtotime($goal['created_at'])); ?></small>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Goal Modal -->
<div class="modal fade" id="goalModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="goalModalTitle">New Goal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="goalForm">
                    <input type="hidden" id="goalId" name="goal_id">
                    <input type="hidden" id="goalAction" name="action">
                    
                    <div class="mb-3">
                        <label for="goalType" class="form-label">Goal Type</label>
                        <select class="form-select" id="goalType" name="goal_type" required>
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="topic" class="form-label">Topic</label>
                        <input type="text" class="form-control" id="topic" name="topic" placeholder="e.g., Mathematics - Calculus" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="targetMinutes" class="form-label">Target Minutes</label>
                        <input type="number" class="form-control" id="targetMinutes" name="target_minutes" min="1" required>
                    </div>
                    
                    <div class="mb-3" id="progressGroup" style="display: none;">
                        <label for="progress" class="form-label">Current Progress (minutes)</label>
                        <input type="number" class="form-control" id="progress" name="progress" min="0" value="0">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveGoal()">Save Goal</button>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>

