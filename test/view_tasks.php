<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'todo_list');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['task'])) {
        $task = $_POST['task'];
        $list_id = $_POST['list_id'];
        $conn->query("INSERT INTO tasks (list_id, task) VALUES ('$list_id', '$task')");
        header("Location: view_tasks.php?id=$list_id");
    } elseif (isset($_POST['task_id'])) {
        $task_id = $_POST['task_id'];
        $conn->query("UPDATE tasks SET completed = NOT completed WHERE id='$task_id'");
        header("Location: view_tasks.php?id=$list_id");
    }
}

$list_id = $_GET['id'];
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
$query = "SELECT * FROM tasks WHERE list_id='$list_id'";
if ($filter == 'completed') {
    $query .= " AND completed=1";
} elseif ($filter == 'incomplete') {
    $query .= " AND completed=0";
}
$result = $conn->query($query);
?>
<h1>Tasks</h1>
<form method="GET">
    <input type="hidden" name="id" value="<?= $list_id ?>">
    <select name="filter" onchange="this.form.submit()">
        <option value="">All Tasks</option>
        <option value="completed" <?= $filter == 'completed' ? 'selected' : '' ?>>Completed Tasks</option>
        <option value="incomplete" <?= $filter == 'incomplete' ? 'selected' : '' ?>>Incomplete Tasks</option>
    </select>
</form>
<ul>
    <?php while ($row = $result->fetch_assoc()): ?>
        <li>
            <?= $row['task'] ?> 
            <form method="POST" style="display:inline;">
                <input type="hidden" name="task_id" value="<?= $row['id'] ?>">
                <button type="submit" name="toggle">Toggle Completion</button>
            </form>
            <a href="delete_task.php?id=<?= $row['id'] ?>">Delete</a>
        </li>
    <?php endwhile; ?>
</ul>
<form method="POST">
    <input type="hidden" name="list_id" value="<?= $list_id ?>">
    <input type="text" name="task" placeholder="New Task" required>
    <button type="submit">Add Task</button>
</form>
