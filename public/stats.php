<?php
/**
 * Statistics Page
 * Progress visualization with charts
 */

require_once __DIR__ . '/../includes/auth.php';

requireLogin();

$pageTitle = 'My Stats';
$extraScripts = ['stats.js'];
include __DIR__ . '/includes/header.php';
?>

<div class="row mb-4">
    <div class="col-md-12">
        <h2><i class="bi bi-bar-chart"></i> My Statistics</h2>
        <p class="text-muted">Track your study progress and performance</p>
    </div>
</div>

<!-- Export Button -->
<div class="row mb-4">
    <div class="col-12">
        <a href="<?php echo CONTROLLERS_URL; ?>session_controller.php?action=export_csv" class="btn btn-outline-primary">
            <i class="bi bi-download"></i> Export Data as CSV
        </a>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <!-- Daily Time Bar Chart -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-bar-chart-fill"></i> Daily Study Time (Last 7 Days)</h5>
            </div>
            <div class="card-body">
                <canvas id="dailyTimeChart" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Weekly Goal Completion Pie Chart -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-pie-chart-fill"></i> Weekly Goal Completion</h5>
            </div>
            <div class="card-body">
                <canvas id="weeklyGoalChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Cumulative Time Line Chart -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-graph-up"></i> Cumulative Study Time Trend</h5>
            </div>
            <div class="card-body">
                <canvas id="cumulativeTimeChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Topic Distribution -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-tags"></i> Study Time by Topic</h5>
            </div>
            <div class="card-body">
                <canvas id="topicDistributionChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>

