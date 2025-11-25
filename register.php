<?php 
session_start();
require "connection.php";
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
    header("Location: home.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - TravelPlanner</title>
    <link rel="stylesheet" href="css/auth.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="auth-page">
    
    <div class="background-elements">
        <div class="sun"></div>
        <div class="cloud cloud-1"></div>
        <div class="cloud cloud-2"></div>
        <div class="cloud cloud-3"></div>
    </div>

   
    <div class="floating-icon airplane">
        <i class="fas fa-plane"></i>
    </div>
    <div class="floating-icon suitcase">
        <i class="fas fa-suitcase"></i>
    </div>
    <div class="floating-icon passport">
        <i class="fas fa-passport"></i>
    </div>
    <div class="floating-icon globe">
        <i class="fas fa-globe-americas"></i>
    </div>
    <div class="floating-icon compass">
        <i class="fas fa-compass"></i>
    </div>
    <div class="floating-icon camera">
        <i class="fas fa-camera"></i>
    </div>

    <div class="auth-container">
        <div class="auth-card">
            
            <div class="auth-branding">
                <div class="brand-content">
                    <div class="brand-logo">
                        <i class="fas fa-compass"></i>
                        <span>TravelPlanner</span>
                    </div>
                    <h1>Start Your Adventure!</h1>
                    <p>Join thousands of travelers planning their perfect trips. Create memories that last a lifetime.</p>
                    
                    <div class="auth-features">
                        <div class="feature">
                            <i class="fas fa-rocket"></i>
                            <span>Plan trips in minutes</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-gem"></i>
                            <span>Exclusive travel deals</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-users"></i>
                            <span>Join travel community</span>
                        </div>
                    </div>

                    <div class="welcome-stats">
                        <div class="stat">
                            <div class="stat-number">50K+</div>
                            <div class="stat-label">Happy Travelers</div>
                        </div>
                        <div class="stat">
                            <div class="stat-number">120+</div>
                            <div class="stat-label">Countries</div>
                        </div>
                        <div class="stat">
                            <div class="stat-number">1M+</div>
                            <div class="stat-label">Trips Planned</div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="auth-form">
                <div class="form-header">
                    <h2>Create Your Account</h2>
                    <p>Join our community of global explorers</p>
                </div>

                <form class="auth-form-content" id="registerForm" method="POST" action="actions/register_action.php">
                    <div class="form-row">
                        <div class="input-group">
                            <label for="firstName">
                                <i class="fas fa-user"></i>
                                First Name
                            </label>
                            <input name="name" type="text" id="firstName" placeholder="John" required>
                            <div class="input-feedback"></div>
                        </div>
                        <div class="input-group">
                            <label for="lastName">
                                <i class="fas fa-user"></i>
                                Last Name
                            </label>
                            <input name="last_name" type="text" id="lastName"  placeholder="Doe" required>
                            <div class="input-feedback"></div>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="registerEmail">
                            <i class="fas fa-envelope"></i>
                            Email Address
                        </label>
                        <input type="email" name="email" id="registerEmail" placeholder="explorer@example.com" required>
                        <div class="input-feedback"></div>
                    </div>

                    <div class="input-group">
                        <label for="registerPassword">
                            <i class="fas fa-lock"></i>
                            Password
                        </label>
                        <div class="password-input">
                            <input type="password" name="password" id="registerPassword" placeholder="Create a strong password" required>
                            <button type="button" class="toggle-password" id="toggleRegisterPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="password-strength">
                            <div class="strength-bar">
                                <div class="strength-fill" id="passwordStrength"></div>
                            </div>
                            <span class="strength-text" id="passwordStrengthText">Weak</span>
                        </div>
                        <div class="password-requirements">
                            <div class="requirement" data-requirement="length">
                                <i class="fas fa-times"></i>
                                <span>At least 8 characters</span>
                            </div>
                            <div class="requirement" data-requirement="uppercase">
                                <i class="fas fa-times"></i>
                                <span>One uppercase letter</span>
                            </div>
                            <div class="requirement" data-requirement="number">
                                <i class="fas fa-times"></i>
                                <span>One number</span>
                            </div>
                            <div class="requirement" data-requirement="special">
                                <i class="fas fa-times"></i>
                                <span>One special character</span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="confirmPassword">
                            <i class="fas fa-lock"></i>
                            Confirm Password
                        </label>
                        <div class="password-input">
                            <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm your password" required>
                            <button type="button" class="toggle-password" id="toggleConfirmPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="input-feedback"></div>
                    </div>

                    <div class="form-options">
                        <label class="checkbox-container">
                            <input type="checkbox" id="agreeTerms" required>
                            <span class="checkmark"></span>
                            I agree to the <a href="terms.html">Terms of Service</a> and <a href="privacy.html">Privacy Policy</a>
                        </label>
                        <label class="checkbox-container">
                            <input type="checkbox" id="newsletter">
                            <span class="checkmark"></span>
                            Send me travel tips and exclusive deals
                        </label>
                    </div>

                    <input type="submit" class="btn btn-primary btn-auth btn-text" id="registerBtn" value="Create account">
                        
                    <div class="btn-loading">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>

                    <div class="social-login">
                        <div class="divider">
                            <span>Or sign up with</span>
                        </div>
                        
                        <div class="social-buttons">
                            <button type="button" class="btn btn-social btn-google">
                                <i class="fab fa-google"></i>
                                Google
                            </button>
                            <button type="button" class="btn btn-social btn-facebook">
                                <i class="fab fa-facebook-f"></i>
                                Facebook
                            </button>
                            <button type="button" class="btn btn-social btn-apple">
                                <i class="fab fa-apple"></i>
                                Apple
                            </button>
                        </div>
                    </div>

                    <div class="auth-switch">
                        <p>Already have an account? <a href="login.php" class="switch-link">Sign in here</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="notification success" id="successNotification" style="display: none;">
        <i class="fas fa-check-circle"></i>
        <span>Account created! Welcome to TravelPlanner!</span>
    </div>

   
    <?php if(isset($_GET['error'])): ?>
    <div class="notification error" id="errorNotification">
        <i class="fas fa-exclamation-circle"></i>
        <span><?php echo htmlspecialchars($_GET['error']); ?></span>
    </div>
    <?php endif; ?>

    <script src="js/auth.js"></script>
    <script>
        
        document.addEventListener('DOMContentLoaded', function() {
            const errorNotification = document.getElementById('errorNotification');
            if (errorNotification) {
                setTimeout(() => {
                    errorNotification.style.display = 'none';
                }, 5000);
            }
        });
    </script>
</body>
</html>