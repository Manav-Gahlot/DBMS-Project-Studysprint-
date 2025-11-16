/**
 * Goals Management JavaScript
 * Handles CRUD operations for study goals
 */

// DOM Elements
let goalModal, goalForm, goalModalTitle, progressGroup;

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    const modalElement = document.getElementById('goalModal');
    if (modalElement) {
        goalModal = new bootstrap.Modal(modalElement);
        goalForm = document.getElementById('goalForm');
        goalModalTitle = document.getElementById('goalModalTitle');
        progressGroup = document.getElementById('progressGroup');
        
        // Set up new goal button
        const newGoalBtn = document.getElementById('newGoalBtn');
        if (newGoalBtn) {
            newGoalBtn.addEventListener('click', function(e) {
                e.preventDefault();
                openGoalModal();
            });
        }
        
        // Set up edit goal buttons
        const editButtons = document.querySelectorAll('.edit-goal-btn');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const goalData = this.getAttribute('data-goal');
                if (goalData) {
                    try {
                        const goal = JSON.parse(goalData);
                        editGoal(goal);
                    } catch (error) {
                        console.error('Error parsing goal data:', error);
                        showAlert('error', 'Failed to load goal data');
                    }
                }
            });
        });
        
        // Set up delete goal buttons
        const deleteButtons = document.querySelectorAll('.delete-goal-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const goalId = this.getAttribute('data-goal-id');
                if (goalId) {
                    deleteGoal(parseInt(goalId));
                }
            });
        });
        
        // Set up modal event listeners
        modalElement.addEventListener('hidden.bs.modal', function() {
            // Reset form when modal is hidden
            if (goalForm) {
                goalForm.reset();
                const goalAction = document.getElementById('goalAction');
                if (goalAction) goalAction.value = 'create';
                const goalId = document.getElementById('goalId');
                if (goalId) goalId.value = '';
                if (progressGroup) progressGroup.style.display = 'none';
            }
        });
    }
});

/**
 * Open goal modal for creating a new goal
 */
function openGoalModal() {
    if (!goalModal) {
        console.error('Goal modal not initialized');
        // Try to initialize it
        const modalElement = document.getElementById('goalModal');
        if (modalElement) {
            goalModal = new bootstrap.Modal(modalElement);
        } else {
            alert('Modal not found. Please refresh the page.');
            return;
        }
    }
    
    if (!goalModalTitle || !goalForm || !progressGroup) {
        // Re-initialize elements
        goalModalTitle = document.getElementById('goalModalTitle');
        goalForm = document.getElementById('goalForm');
        progressGroup = document.getElementById('progressGroup');
    }
    
    if (!goalModalTitle || !goalForm || !progressGroup) {
        console.error('Goal modal elements not found');
        return;
    }
    
    goalModalTitle.textContent = 'New Goal';
    goalForm.reset();
    const goalId = document.getElementById('goalId');
    const goalAction = document.getElementById('goalAction');
    const progress = document.getElementById('progress');
    
    if (goalId) goalId.value = '';
    if (goalAction) goalAction.value = 'create';
    if (progressGroup) progressGroup.style.display = 'none';
    if (progress) progress.value = '0';
    
    goalModal.show();
}

/**
 * Edit goal
 */
function editGoal(goal) {
    // Initialize modal if not already done
    if (!goalModal) {
        const modalElement = document.getElementById('goalModal');
        if (modalElement) {
            goalModal = new bootstrap.Modal(modalElement);
        } else {
            console.error('Goal modal not found');
            showAlert('error', 'Modal not found. Please refresh the page.');
            return;
        }
    }
    
    // Initialize elements if not already done
    if (!goalModalTitle || !goalForm || !progressGroup) {
        goalModalTitle = document.getElementById('goalModalTitle');
        goalForm = document.getElementById('goalForm');
        progressGroup = document.getElementById('progressGroup');
    }
    
    if (!goalModalTitle || !goalForm || !progressGroup) {
        console.error('Goal modal elements not found');
        showAlert('error', 'Form elements not found. Please refresh the page.');
        return;
    }
    
    try {
        // Parse goal if it's a string
        if (typeof goal === 'string') {
            goal = JSON.parse(goal);
        }
        
        goalModalTitle.textContent = 'Edit Goal';
        const goalId = document.getElementById('goalId');
        const goalAction = document.getElementById('goalAction');
        const goalType = document.getElementById('goalType');
        const topic = document.getElementById('topic');
        const targetMinutes = document.getElementById('targetMinutes');
        const progress = document.getElementById('progress');
        
        if (goalId) goalId.value = goal.id || '';
        if (goalAction) goalAction.value = 'update';
        if (goalType) goalType.value = goal.goal_type || 'daily';
        if (topic) topic.value = goal.topic || '';
        if (targetMinutes) targetMinutes.value = goal.target_minutes || 0;
        if (progress) progress.value = goal.progress || 0;
        if (progressGroup) progressGroup.style.display = 'block';
        
        goalModal.show();
    } catch (error) {
        console.error('Error editing goal:', error);
        showAlert('error', 'Failed to load goal for editing: ' + error.message);
    }
}

/**
 * Save goal (create or update)
 */
function saveGoal() {
    if (!goalForm) {
        console.error('Goal form not found');
        showAlert('error', 'Form not found');
        return;
    }
    
    // Check if CONTROLLERS_URL is defined
    if (typeof CONTROLLERS_URL === 'undefined') {
        console.error('CONTROLLERS_URL is not defined');
        showAlert('error', 'Configuration error. Please refresh the page.');
        return;
    }
    
    const formData = new FormData(goalForm);
    const action = formData.get('action');
    const url = CONTROLLERS_URL + 'goal_controller.php';
    
    // Validate form
    const topic = formData.get('topic');
    const targetMinutes = parseInt(formData.get('target_minutes'));
    
    if (!topic || !targetMinutes || targetMinutes <= 0) {
        showAlert('error', 'Please fill in all fields correctly');
        return;
    }
    
    // Show loading
    const saveBtn = document.querySelector('#goalModal .btn-primary');
    if (!saveBtn) {
        showAlert('error', 'Save button not found');
        return;
    }
    
    const originalText = saveBtn.innerHTML;
    saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Saving...';
    saveBtn.disabled = true;
    
    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
            if (goalModal) {
                goalModal.hide();
            }
            // Reload page to show updated goals
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showAlert('error', data.message || 'Failed to save goal');
            saveBtn.innerHTML = originalText;
            saveBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'An error occurred. Please check your connection and try again.');
        saveBtn.innerHTML = originalText;
        saveBtn.disabled = false;
    });
}

/**
 * Delete goal
 */
function deleteGoal(goalId) {
    if (!goalId) {
        showAlert('error', 'Invalid goal ID');
        return;
    }
    
    if (typeof Swal === 'undefined') {
        if (confirm('Are you sure you want to delete this goal?')) {
            performDelete(goalId);
        }
        return;
    }
    
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            performDelete(goalId);
        }
    });
}

/**
 * Perform the actual delete operation
 */
function performDelete(goalId) {
    // Check if CONTROLLERS_URL is defined
    if (typeof CONTROLLERS_URL === 'undefined') {
        console.error('CONTROLLERS_URL is not defined');
        showAlert('error', 'Configuration error. Please refresh the page.');
        return;
    }
    
    const formData = new FormData();
    formData.append('action', 'delete');
    formData.append('goal_id', goalId);
    
    fetch(CONTROLLERS_URL + 'goal_controller.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
            // Reload page to show updated goals
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showAlert('error', data.message || 'Failed to delete goal');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'An error occurred. Please check your connection and try again.');
    });
}

/**
 * Show alert using SweetAlert2 or fallback to alert
 */
function showAlert(type, message) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: type === 'error' ? 'error' : type,
            title: type === 'error' ? 'Error!' : 'Success!',
            text: message,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    } else {
        // Fallback to standard alert
        alert(message);
    }
}

