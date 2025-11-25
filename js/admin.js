// Admin Dashboard JavaScript
class AdminDashboard {
    constructor() {
        this.init();
    }

    init() {
        this.setupModals();
        this.setupForms();
        this.loadDashboardData();
    }

    setupModals() {
        // Close modals when clicking outside
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal')) {
                this.closeAllModals();
            }
        });

        // Close modals with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeAllModals();
            }
        });
    }

    setupForms() {
        const userForm = document.getElementById('userForm');
        if (userForm) {
            userForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.saveUser();
            });
        }
    }

    openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
    }

    closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }

    closeAllModals() {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.style.display = 'none';
        });
        document.body.style.overflow = 'auto';
    }

    editUser(userId) {
        // Fetch user data and populate form
        fetch(`actions/get_user.php?id=${userId}`)
            .then(response => response.json())
            .then(user => {
                document.getElementById('userId').value = user.id;
                document.getElementById('userName').value = user.name;
                document.getElementById('userEmail').value = user.email;
                document.getElementById('userUsername').value = user.username;
                document.getElementById('userRole').value = user.role;
                
                this.openModal('userManagement');
            })
            .catch(error => {
                console.error('Error fetching user:', error);
                this.showNotification('Error loading user data', 'error');
            });
    }

    saveUser() {
        const formData = new FormData(document.getElementById('userForm'));
        
        fetch('actions/save_user.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                this.showNotification('User saved successfully', 'success');
                this.closeModal('userManagement');
                this.loadDashboardData(); // Refresh data
            } else {
                this.showNotification(result.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error saving user:', error);
            this.showNotification('Error saving user', 'error');
        });
    }

    deleteUser(userId) {
        if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
            fetch(`actions/delete_user.php?id=${userId}`)
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        this.showNotification('User deleted successfully', 'success');
                        this.loadDashboardData(); // Refresh data
                    } else {
                        this.showNotification(result.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error deleting user:', error);
                    this.showNotification('Error deleting user', 'error');
                });
        }
    }

    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <i class="fas fa-${this.getNotificationIcon(type)}"></i>
            <span>${message}</span>
        `;

        document.body.appendChild(notification);

        // Show and auto-remove
        setTimeout(() => notification.classList.add('show'), 100);
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }

    getNotificationIcon(type) {
        const icons = {
            success: 'check-circle',
            error: 'exclamation-circle',
            warning: 'exclamation-triangle',
            info: 'info-circle'
        };
        return icons[type] || 'info-circle';
    }

    loadDashboardData() {
        // Refresh dashboard data
        // This would typically make AJAX calls to update statistics
        console.log('Refreshing dashboard data...');
    }
}

// Global functions for modal handling
function openModal(modalId) {
    if (window.adminDashboard) {
        window.adminDashboard.openModal(modalId);
    }
}

function closeModal(modalId) {
    if (window.adminDashboard) {
        window.adminDashboard.closeModal(modalId);
    }
}

function editUser(userId) {
    if (window.adminDashboard) {
        window.adminDashboard.editUser(userId);
    }
}

function deleteUser(userId) {
    if (window.adminDashboard) {
        window.adminDashboard.deleteUser(userId);
    }
}

// Initialize admin dashboard
document.addEventListener('DOMContentLoaded', () => {
    window.adminDashboard = new AdminDashboard();
});