<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $birth_date = $_POST['birth_date'];

    $conn = new mysqli("localhost", "root", "", "todo_app");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND birthdate = ?");
    $stmt->bind_param("ss", $email, $birth_date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header('Location: /reset_password?email=' . urlencode($email));
    } else {
        header('Location: /forget_password?error=invalid_verification');
    }

    $stmt->close();
    $conn->close();
}
?>
