// Profile Page JavaScript
class ProfileManager {
    constructor() {
        this.init();
    }

    init() {
        this.setupPasswordStrength();
        this.setupFormValidation();
        this.setupQuickActions();
    }

    setupPasswordStrength() {
        const newPasswordInput = document.getElementById('newPassword');
        const strengthBar = document.getElementById('passwordStrength');
        const strengthText = document.getElementById('passwordStrengthText');
        const requirements = document.querySelectorAll('.requirement');

        if (newPasswordInput) {
            newPasswordInput.addEventListener('input', (e) => {
                const password = e.target.value;
                this.updatePasswordStrength(password, strengthBar, strengthText, requirements);
            });
        }
    }

    updatePasswordStrength(password, strengthBar, strengthText, requirements) {
        let strength = 0;
        const checks = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /[0-9]/.test(password),
            special: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)
        };

        // Update requirement indicators
        requirements.forEach(req => {
            const type = req.getAttribute('data-requirement');
            const icon = req.querySelector('i');
            
            if (checks[type]) {
                req.classList.add('valid');
                req.classList.remove('invalid');
                icon.className = 'fas fa-check';
                strength += 20;
            } else {
                req.classList.add('invalid');
                req.classList.remove('valid');
                icon.className = 'fas fa-times';
            }
        });

        // Update strength meter
        strengthBar.style.width = `${strength}%`;
        
        if (strength <= 20) {
            strengthBar.style.backgroundColor = '#e74c3c';
            strengthText.textContent = 'Very Weak';
            strengthText.style.color = '#e74c3c';
        } else if (strength <= 40) {
            strengthBar.style.backgroundColor = '#f39c12';
            strengthText.textContent = 'Weak';
            strengthText.style.color = '#f39c12';
        } else if (strength <= 60) {
            strengthBar.style.backgroundColor = '#f1c40f';
            strengthText.textContent = 'Fair';
            strengthText.style.color = '#f1c40f';
        } else if (strength <= 80) {
            strengthBar.style.backgroundColor = '#2ecc71';
            strengthText.textContent = 'Good';
            strengthText.style.color = '#2ecc71';
        } else {
            strengthBar.style.backgroundColor = '#27ae60';
            strengthText.textContent = 'Strong';
            strengthText.style.color = '#27ae60';
        }
    }

   setupFormValidation() {
    const passwordForm = document.getElementById('passwordForm');
    
    if (passwordForm) {
        passwordForm.addEventListener('submit', (e) => {
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            // Do client-side validation but DON'T prevent default
            if (newPassword !== confirmPassword) {
                e.preventDefault(); // Only prevent if validation fails
                this.showNotification('New passwords do not match!', 'error');
                return;
            }

            if (newPassword.length < 8) {
                e.preventDefault(); // Only prevent if validation fails
                this.showNotification('Password must be at least 8 characters long!', 'error');
                return;
            }

            // If validation passes, allow the form to submit normally to your PHP file
            // Show loading state but don't prevent the form submission
            const submitBtn = document.querySelector('#passwordForm button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
            submitBtn.disabled = true;
        });
    }
}

// Remove the submitPasswordChange method entirely
    setupQuickActions() {
        const actionCards = document.querySelectorAll('.action-card');
        
        actionCards.forEach(card => {
            card.addEventListener('click', () => {
                const action = card.getAttribute('data-action');
                
                switch(action) {
                    case 'update-password':
                        window.location.href = 'update-password.php';
                        break;
                    case 'edit-profile':
                        this.showNotification('Profile editing coming soon!', 'info');
                        break;
                    case 'privacy-settings':
                        this.showNotification('Privacy settings coming soon!', 'info');
                        break;
                    case 'delete-account':
                        if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
                            this.showNotification('Account deletion coming soon!', 'warning');
                        }
                        break;
                }
            });
        });
    }

    

    showNotification(message, type = 'info') {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notification => notification.remove());

        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
        };

        notification.innerHTML = `
            <i class="fas ${icons[type]}"></i>
            <span>${message}</span>
        `;

        document.body.appendChild(notification);

        // Show notification
        setTimeout(() => {
            notification.style.display = 'flex';
        }, 100);

        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.style.display = 'none';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 5000);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.profileManager = new ProfileManager();
});