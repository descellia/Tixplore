<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'todo_list');

// Handle user registration
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $conn->query("INSERT INTO users (username, password) VALUES ('$username', '$password')");
}

// Handle user login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE username='$username'");
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
}

// Handle to-do list creation
if (isset($_POST['create_list'])) {
    $title = $_POST['title'];
    $user_id = $_SESSION['user_id'];
    $conn->query("INSERT INTO todo_lists (user_id, title) VALUES ('$user_id', '$title')");
}

// Handle to-do list deletion
if (isset($_GET['delete_list'])) {
    $id = $_GET['delete_list'];
    $conn->query("DELETE FROM todo_lists WHERE id='$id'");
}

// Handle task creation
if (isset($_POST['add_task'])) {
    $task = $_POST['task'];
    $list_id = $_POST['list_id'];
    $conn->query("INSERT INTO tasks (list_id, task) VALUES ('$list_id', '$task')");
}

// Handle task deletion
if (isset($_GET['delete_task'])) {
    $id = $_GET['delete_task'];
    $list_id = $conn->query("SELECT list_id FROM tasks WHERE id='$id'")->fetch_assoc()['list_id'];
    $conn->query("DELETE FROM tasks WHERE id='$id'");
    header("Location: index.php?list_id=$list_id");
}

// Handle task completion toggle
if (isset($_POST['toggle_completion'])) {
    $task_id = $_POST['task_id'];
    $list_id = $_POST['list_id'];
    $conn->query("UPDATE tasks SET completed = NOT completed WHERE id='$task_id'");
}

// Get to-do lists for the logged-in user
$lists = [];
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $lists = $conn->query("SELECT * FROM todo_lists WHERE user_id='$user_id'")->fetch_all(MYSQLI_ASSOC);
}

// Get tasks for a specific list
$tasks = [];
if (isset($_GET['list_id'])) {
    $list_id = $_GET['list_id'];
    $filter = isset($_GET['filter']) ? $_GET['filter'] : '';
    
    $query = "SELECT * FROM tasks WHERE list_id='$list_id'";
    if ($filter == 'completed') {
        $query .= " AND completed=1";
    } elseif ($filter == 'incomplete') {
        $query .= " AND completed=0";
    }
    $tasks = $conn->query($query)->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php if (!isset($_SESSION['user_id'])): ?>
    <h1>Register</h1>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="register">Register</button>
    </form>

    <h1>Login</h1>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>
<?php else: ?>
    <h1>Welcome!</h1>
    <a href="?logout=true">Logout</a>

    <h2>Your To-Do Lists</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="List Title" required>
        <button type="submit" name="create_list">Create New To-Do List</button>
    </form>
    <ul>
        <?php foreach ($lists as $list): ?>
            <li>
                <?= htmlspecialchars($list['title']) ?>
                <div>
                    <a href="?delete_list=<?= $list['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    <a href="?list_id=<?= $list['id'] ?>">View Tasks</a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

    <?php if (isset($_GET['list_id'])): ?>
        <h2>Tasks</h2>
        <form method="POST">
            <input type="text" name="task" placeholder="Add a new task" required>
            <input type="hidden" name="list_id" value="<?= $_GET['list_id'] ?>">
            <button type="submit" name="add_task">Add Task</button>
        </form>

        <select onchange="window.location.href=this.value;">
            <option value="">Filter Tasks</option>
            <option value="?list_id=<?= $_GET['list_id'] ?>&filter=all">All</option>
            <option value="?list_id=<?= $_GET['list_id'] ?>&filter=completed">Completed</option>
            <option value="?list_id=<?= $_GET['list_id'] ?>&filter=incomplete">Incomplete</option>
        </select>

        <ul>
            <?php foreach ($tasks as $task): ?>
                <li>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                        <input type="hidden" name="list_id" value="<?= $_GET['list_id'] ?>">
                        <button type="submit" name="toggle_completion" style="background: none; border: none; color: inherit; cursor: pointer;">
                            <?= $task['completed'] ? '✔️' : '❌' ?>
                        </button>
                    </form>
                    <?= htmlspecialchars($task['task']) ?>
                    <a href="?delete_task=<?= $task['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>
