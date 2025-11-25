<?php
require "../connection.php";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $name = $_POST['name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // FIX 1: Initialize counter variable
    $counter = 1;
    $baseUsername = strtolower($name) . '_' . strtolower(substr($last_name, 0, 4));
    $username = $baseUsername;
    
    while (true) {
        $checkSql = "SELECT id FROM users WHERE username = :username";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->bindParam(':username', $username);
        $checkStmt->execute();
        
        if ($checkStmt->rowCount() === 0) {
            break;
        }
        $username = $baseUsername . $counter;
        $counter++;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../register.php?error=" . urlencode("Please enter a valid email address"));
        exit;
    }
    if(empty(trim($name)) || empty(trim($email)) || empty(trim($password))){
        header("Location: ../register.php?error=" . urlencode("Please fill in all fields"));
        exit;
    }
    
    try { 
        $checkSql = "SELECT * FROM users WHERE email = :email";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->bindParam(':email', $email);
        $checkStmt->execute();
        
        if($checkStmt->rowCount() > 0){
            header("Location: ../register.php?error=" . urlencode("Email already exists"));
            exit;
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            // FIX 2: Added missing comma in SQL
            $sql = "INSERT INTO users (name, last_name, username, email, password) VALUES (:name, :last_name, :username, :email, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':last_name', $last_name);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->execute();
            
            header("Location: ../login.php?success=" . urlencode("Registration successful! Please login."));
            exit;
        }
    } catch(PDOException $exc) {
        header("Location: ../register.php?error=" . urlencode("Registration failed. Please try again."));
        exit;
    }
} else {
    header("Location: ../register.php");
    exit;
}
?>