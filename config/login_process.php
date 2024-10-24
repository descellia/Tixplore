<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
 
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['first_name'] . $user['last_name'];
            $_SESSION['profile'] = $user['profile_picture'];
            
            if ($user['user_id'] === '4DM1N') {
                header("Location: /admin/dashboard");
            } else {
                header("Location: /home");
            }
            exit;
        } else {
            header("Location: /login?error=invalid_credentials");
            exit;
        }
    } else {
        header("Location: /login?error=user_not_found");
        exit;
    }
}
?>