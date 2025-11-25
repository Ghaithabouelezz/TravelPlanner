<?php
session_start();


//if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
    //header("Location: home.php");
    //exit;
//}


header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TravelPlanner</title>
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

    <div class="auth-container">
        <div class="auth-card">
           
            <div class="auth-branding">
                <div class="brand-content">
                    <div class="brand-logo">
                        <i class="fas fa-compass"></i>
                        <span>TravelPlanner</span>
                    </div>
                    <h1>Welcome Back, Explorer!</h1>
                    <p>Continue your journey and access your travel plans, saved destinations, and upcoming adventures.</p>
                    
                    <div class="auth-features">
                        <div class="feature">
                            <i class="fas fa-map-marked-alt"></i>
                            <span>Access your saved trips</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-heart"></i>
                            <span>Manage favorite destinations</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-bolt"></i>
                            <span>Quick trip planning</span>
                        </div>
                    </div>

                    <div class="welcome-visuals">
                        <div class="destination-scene">
                            <div class="scene-item">
                                <i class="fas fa-mountain mountain"></i>
                                <span>Mountains</span>
                            </div>
                            <div class="scene-item">
                                <i class="fas fa-umbrella-beach beach"></i>
                                <span>Beaches</span>
                            </div>
                            <div class="scene-item">
                                <i class="fas fa-city city"></i>
                                <span>Cities</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    
            <div class="auth-form">
                <div class="form-header">
                    <h2>Sign In to Your Account</h2>
                    <p>Enter your credentials to continue your adventure</p>
                </div>

                <form class="auth-form-content" id="loginForm" method="POST" action="actions/login_action.php">
                    <div class="input-group">
                        <label for="loginEmail">
                            <i class="fas fa-envelope"></i>
                            Email Address
                        </label>
                        <input type="email" id="loginEmail" name="email" placeholder="explorer@example.com" required>
                        <div class="input-feedback"></div>
                    </div>

                    <div class="input-group">
                        <label for="loginPassword">
                            <i class="fas fa-lock"></i>
                            Password
                        </label>
                        <div class="password-input">
                            <input type="password" name="password" id="loginPassword" placeholder="Enter your password" required>
                            <button type="button" class="toggle-password" id="toggleLoginPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="input-feedback"></div>
                    </div>

                    <div class="form-options">
                        <label class="checkbox-container">
                            <input type="checkbox" id="rememberMe">
                            <span class="checkmark"></span>
                            Remember me
                        </label>
                        <a href="forgot-password.html" class="forgot-link">Forgot password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary btn-auth" id="loginBtn">
                        <span class="btn-text">Sign In</span>
                        <div class="btn-loading">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </button>

                    <div class="social-login">
                        <div class="divider">
                            <span>Or continue with</span>
                        </div>
                        
                        <div class="social-buttons">
                           <button type="button" class="btn btn-social btn-google" id="googleSignIn">
    <i class="fab fa-google"></i>
    Google
</button>
                            <button type="button" class="btn btn-social btn-facebook">
                                <i class="fab fa-facebook-f"></i>
                                Facebook
                            </button>
                           
                        </div>
                    </div>

                    <div class="auth-switch">
                        <p>New to TravelPlanner? <a href="register.php" class="switch-link">Create an account</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="notification success" id="successNotification" style="display: none;">
        <i class="fas fa-check-circle"></i>
        <span>Welcome back! Redirecting to your dashboard...</span>
    </div>

    <script src="js/auth.js"></script>
    <script src="js/google_auth.js"></script>
      <?php
  if(isset($_SESSION['login_error1'])){
    echo "<p style='color:red'>".$_SESSION['login_error1']."</p>";
    unset($_SESSION['login_error1']);
  } ?>
</body>
</html>