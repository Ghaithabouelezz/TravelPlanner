<?php
session_start();
require "../connection.php";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    try { 
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if($stmt->rowCount() > 0){
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
          if(password_verify($password, $user['password'])){
    // Set session variables
    $_SESSION['loggedIn'] = true;
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_username'] = $user['username'];
    $_SESSION['user_role'] = $user['role'];
    if($_SESSION['user_email']=="abouelezz_ghaith@travelplanner.com"){
     header("Location:../admin.php");
    exit();}
    header("Location: ../home.php");
    exit;
}else {
                $_SESSION['login_error1'] = "Invalid email or password";
                header("Location: ../login.php");
                exit;
            }
        } else {
            $_SESSION['login_error1'] = "Invalid email or password";
            header("Location: ../login.php");
            exit;
        }
    } catch(PDOException $exc) {
        $_SESSION['login_error1'] = "Login failed. Please try again.";
        header("Location: ../login.php");
        exit;
    }
} else {
    header("Location: ../login.php");
   

    exit;
}
?>