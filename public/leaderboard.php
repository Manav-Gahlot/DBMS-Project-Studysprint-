<?php
/**
 * Leaderboard Page
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../models/Leaderboard.php';

requireLogin();

$userId = getCurrentUserId();
$topUsers = Leaderboard::getTopUsers(10);
$userPosition = Leaderboard::getUserPosition($userId);

$pageTitle = 'Leaderboard';
include __DIR__ . '/includes/header.php';
?>

<div class="row mb-4">
    <div class="col-md-12">
        <h2><i class="bi bi-trophy"></i> Leaderboard</h2>
        <p class="text-muted">Top study performers ranked by total study time</p>
    </div>
</div>

<!-- User's Position -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow border-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">Your Position</h5>
                        <p class="mb-0 text-muted">Total Study Time: <strong><?php echo $userPosition['total']; ?> minutes</strong></p>
                    </div>
                    <div class="text-end">
                        <div class="display-4 text-primary">#<?php echo $userPosition['rank']; ?></div>
                        <small class="text-muted">Rank</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Top Users -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="bi bi-trophy-fill"></i> Top 10 Users</h5>
            </div>
            <div class="card-body">
                <?php if (empty($topUsers)): ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> No users found. Start studying to appear on the leaderboard!
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="10%">Rank</th>
                                    <th width="15%">Avatar</th>
                                    <th>Username</th>
                                    <th class="text-end">Total Minutes</th>
                                    <th class="text-end">Total Hours</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $rank = 1;
                                foreach ($topUsers as $user): 
                                    $isCurrentUser = $user['id'] == $userId;
                                    $totalHours = round($user['total_minutes'] / 60, 1);
                                ?>
                                    <tr class="<?php echo $isCurrentUser ? 'table-primary' : ''; ?>">
                                        <td>
                                            <?php if ($rank <= 3): ?>
                                                <span class="badge bg-<?php echo $rank === 1 ? 'warning' : ($rank === 2 ? 'secondary' : 'danger'); ?> text-dark">
                                                    <?php echo $rank === 1 ? '🥇' : ($rank === 2 ? '🥈' : '🥉'); ?>
                                                </span>
                                            <?php else: ?>
                                                <strong>#<?php echo $rank; ?></strong>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="avatar-circle bg-primary text-white d-inline-flex align-items-center justify-content-center rounded-circle" 
                                                 style="width: 40px; height: 40px; font-weight: bold;">
                                                <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($user['username']); ?></strong>
                                            <?php if ($isCurrentUser): ?>
                                                <span class="badge bg-primary">You</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end"><strong><?php echo number_format($user['total_minutes']); ?></strong> min</td>
                                        <td class="text-end"><?php echo $totalHours; ?> hrs</td>
                                    </tr>
                                <?php 
                                    $rank++;
                                endforeach; 
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>

