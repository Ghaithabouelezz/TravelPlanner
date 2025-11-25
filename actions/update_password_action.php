<?php
session_start();
require "../connection.php";

// Check if user is logged in
if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true) {
    header("Location: ../login.php");
    exit;
}

// Check request method
if ($_SERVER['REQUEST_METHOD'] != "POST") {
    header("Location: ../password_update.php?error=" . urlencode("Wrong method"));
    exit;
}

// Get and validate input data
$oldPassword = $_POST['current_password'] ?? '';
$newPassword = $_POST['new_password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

// Check for empty fields
if (empty(trim($oldPassword)) || empty(trim($newPassword)) || empty(trim($confirmPassword))) {
    header("Location: ../password_update.php?error=" . urlencode("All fields are required"));
    exit;
}

// Check if new passwords match
if ($newPassword !== $confirmPassword) {
    header("Location: ../password_update.php?error=" . urlencode("New passwords do not match"));
    exit;
}

// Check if new password is different from old password
if ($oldPassword === $newPassword) {
    header("Location: ../password_update.php?error=" . urlencode("New password must be different from current password"));
    exit;
}

try {
    // Get user's current password from database
    $sql = "SELECT id, password FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $_SESSION['user_id']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        header("Location: ../password_update.php?error=" . urlencode("User not found"));
        exit;
    }

    // Verify current password
    if (!password_verify($oldPassword, $user['password'])) {
        header("Location: ../password_update.php?error=" . urlencode("Current password is incorrect"));
        exit;
    }

    // Hash new password and update
    $hashed_password = password_hash($newPassword, PASSWORD_BCRYPT);
    $updateSql = "UPDATE users SET password = :password WHERE id = :id";
    $updateStmt = $pdo->prepare($updateSql);
    $updateStmt->bindParam(':id', $_SESSION['user_id']);
    $updateStmt->bindParam(':password', $hashed_password);
    
    if ($updateStmt->execute()) {
        // Destroy session and redirect to login
        session_destroy();
        header("Location: ../login.php?success=" . urlencode("Password changed successfully! Please login again."));
        exit;
    } else {
        header("Location: ../password_update.php?error=" . urlencode("Failed to update password"));
        exit;
    }
} catch(PDOException $e) {
    header("Location: ../password_update.php?error=" . urlencode("Database error occurred"));
    exit;
}
?>