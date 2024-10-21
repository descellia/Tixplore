<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'todo_list');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $user_id = $_SESSION['user_id'];
    $conn->query("INSERT INTO todo_lists (user_id, title) VALUES ('$user_id', '$title')");
    header("Location: dashboard.php");
}
?>
<form method="POST">
    <input type="text" name="title" placeholder="List Title" required>
    <button type="submit">Create</button>
</form>
