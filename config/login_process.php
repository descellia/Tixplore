<?php
session_start();
require_once 'db.php';

<<<<<<< Updated upstream
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id, name, password, role FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
       
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
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
=======
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        header("Location: ../views/auth/login.php?error=user_not_found");
        exit();
    }

    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id']; // Assign session variable after fetching user data
        header("Location: ../views/home.php");
        exit();
    } else {
        header("Location: ../views/auth/login.php?error=invalid_credentials");
        exit();
    }
}
?>
>>>>>>> Stashed changes
