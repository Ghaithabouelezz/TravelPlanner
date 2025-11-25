<?php
session_start();
require "connection.php";

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password - TravelPlanner</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/password_update.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'nav.php'; ?>

    <div class="password-container">
        <div class="profile-header">
            <h1>Update Password</h1>
            <p>Secure your account with a new password</p>
        </div>

        <form class="password-form" id="passwordForm" method="POST" action="actions/update_password_action.php">
            <div class="password-container">
    <div class="profile-header">
        <h1>Update Password</h1>
        <p>Secure your account with a new password</p>
    </div>

  
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <?php echo htmlspecialchars($_GET['success']); ?>
        </div>
    <?php endif; ?>

    <form class="password-form" id="passwordForm" method="POST" action="actions/update_password_action.php">
            <div class="form-group">
                <label for="currentPassword">
                    <i class="fas fa-lock"></i>
                    Current Password
                </label>
                <input type="password" id="currentPassword" name="current_password" placeholder="Enter your current password" required>
            </div>

            <div class="form-group">
                <label for="newPassword">
                    <i class="fas fa-key"></i>
                    New Password
                </label>
                <input type="password" id="newPassword" name="new_password" placeholder="Create a new password" required>
                
                <div class="password-strength">
                    <div class="strength-bar">
                        <div class="strength-fill" id="passwordStrength"></div>
                    </div>
                    <span class="strength-text" id="passwordStrengthText">Weak</span>
                </div>

                <div class="password-requirements">
                    <div class="requirement invalid" data-requirement="length">
                        <i class="fas fa-times"></i>
                        <span>At least 8 characters</span>
                    </div>
                    <div class="requirement invalid" data-requirement="uppercase">
                        <i class="fas fa-times"></i>
                        <span>One uppercase letter</span>
                    </div>
                    <div class="requirement invalid" data-requirement="lowercase">
                        <i class="fas fa-times"></i>
                        <span>One lowercase letter</span>
                    </div>
                    <div class="requirement invalid" data-requirement="number">
                        <i class="fas fa-times"></i>
                        <span>One number</span>
                    </div>
                    <div class="requirement invalid" data-requirement="special">
                        <i class="fas fa-times"></i>
                        <span>One special character</span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="confirmPassword">
                    <i class="fas fa-check-double"></i>
                    Confirm New Password
                </label>
                <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm your new password" required>
            </div>

            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save"></i>
                Update Password
            </button>

            <a href="profile.php" class="btn btn-outline" style="margin-left: 15px;">
                <i class="fas fa-arrow-left"></i>
                Back to Profile
            </a>
        </form>
    </div>

    <script src="js/password_update.js"></script>
</body>
</html>