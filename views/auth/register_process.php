<?php
session_start();
require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $username = trim($_POST['username']);
    $birthdate = $_POST['birthdate'];
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $persetujuan = isset($_POST['persetujuan']);

    if (empty($firstname) || empty($username) || empty($birthdate) || empty($email) || empty($password) || !$persetujuan) {
        header("Location: register.php?error=empty");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $db->prepare("INSERT INTO users (firstname, lastname, username, birthdate, email, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $firstname, $lastname, $username, $birthdate, $email, $hashedPassword);

    if ($stmt->execute()) {
        header("Location: register.php?message=registered");
    } else {
        header("Location: register.php?error=failed");
    }

    $stmt->close();
}

$db->close();
?>
