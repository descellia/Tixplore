<?php
header("Location: reset_password.php?email=" . urlencode($email) . "&success=true");
exit();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $conn = new mysqli("localhost", "root", "", "todo_app");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashed_password, $email);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Password successfully updated!";
            header('Location: login.php?status=reset_success');
        } else {
            echo "Error updating password!";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Passwords do not match!";
    }
}
?>
