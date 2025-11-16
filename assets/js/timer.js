document.addEventListener('DOMContentLoaded', () => {
    const timerDisplay = document.getElementById('timerDisplay');
    const startBtn = document.getElementById('startBtn');
    const pauseBtn = document.getElementById('pauseBtn');
    const resetBtn = document.getElementById('resetBtn');
    const finishSessionBtn = document.getElementById('finish-session');
    const goalSelect = document.getElementById('goal-select');
    const customTimeInput = document.getElementById('custom-time');
    const sessionType = document.getElementById('sessionType');
    const timerStatus = document.getElementById('timerStatus');
    const timerSetup = document.getElementById('timer-setup');
    const currentGoalDisplay = document.getElementById('current-goal-display');

    let timerInterval;
    let timeLeft;
    let totalTime;
    let isRunning = false;
    let isPaused = false;
    let currentGoalId = null;
    let currentGoalTopic = '';

    function updateDisplay() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        timerDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    }

    function startTimer(duration) {
        if (isRunning) return;

        currentGoalId = goalSelect.value;
        if (!currentGoalId) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select a goal before starting!',
            });
            return;
        }

        currentGoalTopic = goalSelect.options[goalSelect.selectedIndex].text;
        isRunning = true;
        isPaused = false;
        timeLeft = duration * 60;
        totalTime = timeLeft;
        updateDisplay();

        startBtn.disabled = true;
        pauseBtn.disabled = false;
        timerSetup.style.display = 'none';
        currentGoalDisplay.querySelector('h4').textContent = `Studying: ${currentGoalTopic}`;
        currentGoalDisplay.style.display = 'block';

        timerStatus.textContent = 'Session in progress...';
        timerStatus.className = 'alert alert-info';

        timerInterval = setInterval(() => {
            if (!isPaused) {
                timeLeft--;
                updateDisplay();
                if (timeLeft <= 0) {
                    completeSession();
                }
            }
        }, 1000);
    }

    function pauseTimer() {
        if (!isRunning) return;
        isPaused = !isPaused;
        pauseBtn.innerHTML = isPaused ? '<i class="bi bi-play-fill"></i> Resume' : '<i class="bi bi-pause-fill"></i> Pause';
        timerStatus.textContent = isPaused ? 'Timer paused' : 'Session in progress...';
    }

    function resetTimer() {
        clearInterval(timerInterval);
        isRunning = false;
        isPaused = false;
        const customTime = parseInt(customTimeInput.value, 10);
        const duration = customTime > 0 ? customTime : 25;
        timeLeft = duration * 60;
        updateDisplay();

        startBtn.disabled = false;
        pauseBtn.disabled = true;
        pauseBtn.innerHTML = '<i class="bi bi-pause-fill"></i> Pause';
        timerSetup.style.display = 'block';
        currentGoalDisplay.style.display = 'none';
        timerStatus.textContent = 'Select a goal and press Start';
    }

    function completeSession() {
        const timeSpent = Math.floor((totalTime - timeLeft) / 60);
        finishSession(timeSpent);
    }

    function finishSession(timeSpent) {
        clearInterval(timerInterval);
        isRunning = false;

        if (currentGoalId && timeSpent > 0) {
            updateGoalProgress(currentGoalId, timeSpent);
        }

        resetTimer();
    }

    function updateGoalProgress(goalId, timeSpent) {
        const formData = new FormData();
        formData.append('action', 'update_progress');
        formData.append('goal_id', goalId);
        formData.append('time_spent', timeSpent);

        fetch('../controllers/goal_controller.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Session Complete!',
                    text: `You've studied for ${timeSpent} minutes.`,
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Failed to update goal progress: ' + data.message,
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'An error occurred while updating goal progress.',
            });
        });
    }

    startBtn.addEventListener('click', () => {
        const customTime = parseInt(customTimeInput.value, 10);
        const duration = customTime > 0 ? customTime : 25;
        startTimer(duration);
    });

    pauseBtn.addEventListener('click', pauseTimer);
    resetBtn.addEventListener('click', resetTimer);

    if(finishSessionBtn) {
        finishSessionBtn.addEventListener('click', () => {
            if (!isRunning) {
                Swal.fire({
                    icon: 'info',
                    title: 'Timer is not running.',
                });
                return;
            }
            const timeSpent = Math.floor((totalTime - timeLeft) / 60);
            finishSession(timeSpent);
        });
    }
});
