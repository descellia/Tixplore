<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'todo_list');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM todo_lists WHERE user_id='$user_id'");
?>
<h1>Dashboard</h1>
<a href="create_list.php">Create New To-Do List</a>
<ul>
    <?php while ($row = $result->fetch_assoc()): ?>
        <li>
            <?= $row['title'] ?>
            <a href="delete_list.php?id=<?= $row['id'] ?>">Delete</a>
            <a href="view_tasks.php?id=<?= $row['id'] ?>">View Tasks</a>
        </li>
    <?php endwhile; ?>
</ul>
