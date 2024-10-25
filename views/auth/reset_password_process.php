<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Redirect to reset_password.php with email if the request is not POST
    if (empty($email)) {
        header("Location: reset_password.php?email=" . urlencode($email) . "&success=true");
        exit();
    }

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
            // Password update successful
            header('Location: login.php?status=reset_success');
            exit(); // Important to prevent further execution
        } else {
            echo "Error updating password!";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Passwords do not match!";
    }
} else {
    // If the request is not POST, you may want to handle it appropriately
    // For example, redirecting to the reset_password page with an error message
    header("Location: reset_password.php?error=invalid_request");
    exit();
}
?>
