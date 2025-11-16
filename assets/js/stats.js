/**
 * Statistics JavaScript
 * Handles Chart.js visualizations
 */

let dailyTimeChart, weeklyGoalChart, cumulativeTimeChart, topicDistributionChart;

// Initialize charts when page loads
document.addEventListener('DOMContentLoaded', function() {
    loadDailyTimeChart();
    loadWeeklyGoalChart();
    loadCumulativeTimeChart();
    loadTopicDistributionChart();
});

/**
 * Load daily time bar chart
 */
function loadDailyTimeChart() {
    fetch(CONTROLLERS_URL + 'session_controller.php?action=daily_time&days=7')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const dates = [];
                const minutes = [];
                
                // Create array for last 7 days
                const last7Days = [];
                for (let i = 6; i >= 0; i--) {
                    const date = new Date();
                    date.setDate(date.getDate() - i);
                    last7Days.push(date.toISOString().split('T')[0]);
                }
                
                // Map data to dates
                const dataMap = {};
                data.data.forEach(item => {
                    dataMap[item.date] = item.total_minutes;
                });
                
                // Fill in data for all 7 days
                last7Days.forEach(date => {
                    dates.push(new Date(date).toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric' }));
                    minutes.push(dataMap[date] || 0);
                });
                
                const ctx = document.getElementById('dailyTimeChart').getContext('2d');
                dailyTimeChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: dates,
                        datasets: [{
                            label: 'Study Time (minutes)',
                            data: minutes,
                            backgroundColor: 'rgba(13, 110, 253, 0.7)',
                            borderColor: 'rgba(13, 110, 253, 1)',
                            borderWidth: 2,
                            borderRadius: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const hours = Math.floor(context.parsed.y / 60);
                                        const mins = context.parsed.y % 60;
                                        if (hours > 0) {
                                            return `${hours}h ${mins}m`;
                                        }
                                        return `${mins} minutes`;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return value + ' min';
                                    }
                                }
                            }
                        }
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error loading daily time chart:', error);
        });
}

/**
 * Load weekly goal completion pie chart
 */
function loadWeeklyGoalChart() {
    fetch(CONTROLLERS_URL + 'session_controller.php?action=weekly_stats')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.goals.length > 0) {
                const topics = data.goals.map(goal => goal.topic);
                const percentages = data.goals.map(goal => goal.percentage);
                const colors = generateColors(data.goals.length);
                
                const ctx = document.getElementById('weeklyGoalChart').getContext('2d');
                weeklyGoalChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: topics,
                        datasets: [{
                            data: percentages,
                            backgroundColor: colors,
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const goal = data.goals[context.dataIndex];
                                        return `${context.label}: ${goal.progress}/${goal.target} min (${context.parsed}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            } else {
                // Show message if no goals
                document.getElementById('weeklyGoalChart').parentElement.innerHTML = 
                    '<p class="text-muted text-center">No weekly goals set yet.</p>';
            }
        })
        .catch(error => {
            console.error('Error loading weekly goal chart:', error);
        });
}

/**
 * Load cumulative time line chart
 */
function loadCumulativeTimeChart() {
    fetch(CONTROLLERS_URL + 'session_controller.php?action=daily_time&days=30')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Calculate cumulative time
                let cumulative = 0;
                const dates = [];
                const cumulativeMinutes = [];
                
                data.data.forEach(item => {
                    cumulative += item.total_minutes;
                    dates.push(new Date(item.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }));
                    cumulativeMinutes.push(cumulative);
                });
                
                const ctx = document.getElementById('cumulativeTimeChart').getContext('2d');
                cumulativeTimeChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dates,
                        datasets: [{
                            label: 'Cumulative Study Time (minutes)',
                            data: cumulativeMinutes,
                            borderColor: 'rgba(13, 202, 240, 1)',
                            backgroundColor: 'rgba(13, 202, 240, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const hours = Math.floor(context.parsed.y / 60);
                                        const mins = context.parsed.y % 60;
                                        return `Total: ${hours}h ${mins}m`;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        const hours = Math.floor(value / 60);
                                        return hours > 0 ? `${hours}h` : `${value} min`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error loading cumulative time chart:', error);
        });
}

/**
 * Load topic distribution chart
 */
function loadTopicDistributionChart() {
    fetch(CONTROLLERS_URL + 'session_controller.php?action=topic_distribution')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data.length > 0) {
                const topics = data.data.map(item => item.topic);
                const minutes = data.data.map(item => item.total);
                const colors = generateColors(data.data.length);
                
                const ctx = document.getElementById('topicDistributionChart').getContext('2d');
                topicDistributionChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: topics,
                        datasets: [{
                            data: minutes,
                            backgroundColor: colors,
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'right'
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const hours = Math.floor(context.parsed / 60);
                                        const mins = context.parsed % 60;
                                        if (hours > 0) {
                                            return `${context.label}: ${hours}h ${mins}m`;
                                        }
                                        return `${context.label}: ${context.parsed} minutes`;
                                    }
                                }
                            }
                        }
                    }
                });
            } else {
                document.getElementById('topicDistributionChart').parentElement.innerHTML = 
                    '<p class="text-muted text-center">No study sessions recorded yet.</p>';
            }
        })
        .catch(error => {
            console.error('Error loading topic distribution chart:', error);
        });
}

/**
 * Generate color array for charts
 */
function generateColors(count) {
    const colors = [
        'rgba(13, 110, 253, 0.7)',   // Blue
        'rgba(25, 135, 84, 0.7)',    // Green
        'rgba(220, 53, 69, 0.7)',    // Red
        'rgba(255, 193, 7, 0.7)',    // Yellow
        'rgba(13, 202, 240, 0.7)',   // Cyan
        'rgba(111, 66, 193, 0.7)',   // Purple
        'rgba(253, 126, 20, 0.7)',   // Orange
        'rgba(32, 201, 151, 0.7)',   // Teal
        'rgba(214, 51, 132, 0.7)',   // Pink
        'rgba(102, 16, 242, 0.7)'    // Indigo
    ];
    
    const result = [];
    for (let i = 0; i < count; i++) {
        result.push(colors[i % colors.length]);
    }
    return result;
}

