<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'todo_list');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE FROM todo_lists WHERE id='$id'");
    header("Location: dashboard.php");
}
?>
