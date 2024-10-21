<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'todo_list');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $list_id = $conn->query("SELECT list_id FROM tasks WHERE id='$id'")->fetch_assoc()['list_id'];
    $conn->query("DELETE FROM tasks WHERE id='$id'");
    header("Location: view_tasks.php?id=$list_id");
}
?>
