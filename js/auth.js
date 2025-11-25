// auth.js - TravelPlanner Authentication Script

document.addEventListener('DOMContentLoaded', function() {
    // Add these lines to your existing auth.js - find the password visibility section and add login toggles

// Password visibility toggling - ADD LOGIN TOGGLES
const toggleLoginPassword = document.getElementById('toggleLoginPassword');
const loginPassword = document.getElementById('loginPassword');

if (toggleLoginPassword && loginPassword) {
    toggleLoginPassword.addEventListener('click', function() {
        togglePasswordVisibility(loginPassword, this);
    });
}
    // DOM Elements
    const registerForm = document.getElementById('registerForm');
    const registerPassword = document.getElementById('registerPassword');
    const confirmPassword = document.getElementById('confirmPassword');
    const toggleRegisterPassword = document.getElementById('toggleRegisterPassword');
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const passwordStrength = document.getElementById('passwordStrength');
    const passwordStrengthText = document.getElementById('passwordStrengthText');
    const passwordRequirements = document.querySelectorAll('.requirement');
    const registerBtn = document.getElementById('registerBtn');

    // Password requirements configuration
    const requirements = {
        length: { regex: /^.{8,}$/, element: document.querySelector('[data-requirement="length"]') },
        uppercase: { regex: /[A-Z]/, element: document.querySelector('[data-requirement="uppercase"]') },
        number: { regex: /[0-9]/, element: document.querySelector('[data-requirement="number"]') },
        special: { regex: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/, element: document.querySelector('[data-requirement="special"]') }
    };

    // Password visibility toggling
    toggleRegisterPassword.addEventListener('click', function() {
        togglePasswordVisibility(registerPassword, this);
    });

    toggleConfirmPassword.addEventListener('click', function() {
        togglePasswordVisibility(confirmPassword, this);
    });

    // Real-time password validation
    registerPassword.addEventListener('input', function() {
        validatePassword(this.value);
        validatePasswordMatch();
    });

    confirmPassword.addEventListener('input', validatePasswordMatch);

    // Form submission handling - ALLOW normal form submission
    registerForm.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault(); // Only prevent if validation fails
        }
        // If validation passes, allow the form to submit normally to register_action.php
    });

    // Functions
    function togglePasswordVisibility(passwordField, toggleButton) {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        
        const icon = toggleButton.querySelector('i');
        icon.className = type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
    }

    function validatePassword(password) {
        let strength = 0;
        let fulfilledRequirements = 0;
        const totalRequirements = Object.keys(requirements).length;

        // Check each requirement
        Object.keys(requirements).forEach(key => {
            const requirement = requirements[key];
            const isFulfilled = requirement.regex.test(password);
            const icon = requirement.element.querySelector('i');
            
            if (isFulfilled) {
                icon.className = 'fas fa-check';
                icon.style.color = '#10b981';
                requirement.element.style.color = '#10b981';
                strength += 25;
                fulfilledRequirements++;
            } else {
                icon.className = 'fas fa-times';
                icon.style.color = '#ef4444';
                requirement.element.style.color = '#6b7280';
            }
        });

        // Update password strength meter
        updateStrengthMeter(strength, fulfilledRequirements, totalRequirements);
        
        return fulfilledRequirements === totalRequirements;
    }

    function updateStrengthMeter(strength, fulfilled, total) {
        passwordStrength.style.width = `${strength}%`;
        
        if (strength <= 25) {
            passwordStrength.style.backgroundColor = '#ef4444';
            passwordStrengthText.textContent = 'Weak';
            passwordStrengthText.style.color = '#ef4444';
        } else if (strength <= 50) {
            passwordStrength.style.backgroundColor = '#f59e0b';
            passwordStrengthText.textContent = 'Fair';
            passwordStrengthText.style.color = '#f59e0b';
        } else if (strength <= 75) {
            passwordStrength.style.backgroundColor = '#3b82f6';
            passwordStrengthText.textContent = 'Good';
            passwordStrengthText.style.color = '#3b82f6';
        } else {
            passwordStrength.style.backgroundColor = '#10b981';
            passwordStrengthText.textContent = 'Strong';
            passwordStrengthText.style.color = '#10b981';
        }
    }

    function validatePasswordMatch() {
        const password = registerPassword.value;
        const confirm = confirmPassword.value;
        const confirmGroup = confirmPassword.closest('.input-group');
        const feedback = confirmGroup.querySelector('.input-feedback');

        if (confirm === '') {
            feedback.textContent = '';
            feedback.className = 'input-feedback';
            return false;
        }

        if (password !== confirm) {
            feedback.textContent = 'Passwords do not match';
            feedback.className = 'input-feedback error';
            return false;
        } else {
            feedback.textContent = 'Passwords match!';
            feedback.className = 'input-feedback success';
            return true;
        }
    }

    function validateForm() {
        const password = registerPassword.value;
        const confirm = confirmPassword.value;
        const agreeTerms = document.getElementById('agreeTerms').checked;
        
        // Check if all password requirements are met
        const isPasswordValid = validatePassword(password);
        
        // Check if passwords match
        const doPasswordsMatch = validatePasswordMatch();
        
        // Check terms agreement
        if (!agreeTerms) {
            alert('Please agree to the Terms of Service and Privacy Policy');
            return false;
        }

        if (!isPasswordValid) {
            alert('Please fulfill all password requirements');
            return false;
        }

        if (!doPasswordsMatch) {
            alert('Passwords do not match');
            return false;
        }

        return true;
    }

    // Social login button handlers (placeholder functions)
    document.querySelector('.btn-google')?.addEventListener('click', function() {
        alert('Google sign up would be implemented here');
    });

    document.querySelector('.btn-facebook')?.addEventListener('click', function() {
        alert('Facebook sign up would be implemented here');
    });

    document.querySelector('.btn-apple')?.addEventListener('click', function() {
        alert('Apple sign up would be implemented here');
    });
});
