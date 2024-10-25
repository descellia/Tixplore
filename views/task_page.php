<?php
require 'fungsi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_task'])) {
        addTask($conn, $_POST['task_name'], $_POST['status'], $_POST['category'], $_POST['due_date']);

        header('Location: task_page.php'); 
        exit(); 
    }
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter_category = isset($_GET['filter_category']) ? $_GET['filter_category'] : '';

$tasks = getFilteredTasks($conn, $search, $filter_category);
?>


<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.5.0/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Task Management</title>
    <style>
        .status-Done { background-color: #3EE917; color: white; }
        .status-Not { background-color: #0e0c0c; color: white; }
        .status-Stuck { background-color: #EF4444; color: white; }
        .status-Working { background-color: #FBBF24; color: white; }
    </style>
</head>

<body class="bg-gray-100 text-gray-800">
    <div class="drawer lg:drawer-open">
        <input id="my-drawer" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col">
            <!-- Main content here -->
            <main class="p-4 lg:p-8">

                <!-- Button for adding a new task -->
                <div class="flex justify-between mb-4">
                    <div>
                        <label for="new-task-modal" class="bg-gray-600 text-white px-4 py-2 rounded cursor-pointer inline-block">New Task</label>
                    </div>

                    <!-- Search and Filter Form -->
                    <form method="get" class="flex justify-end">
                        <input type="text" name="search" placeholder="Search task..." value="<?= htmlspecialchars($search) ?>" class="input input-bordered input-accent w-full md:w-auto" />
                        <select name="filter_category" class="select select-bordered select-accent w-full md:w-auto mx-2">
                            <option value="">All Categories</option>
                            <option value="Hobby" <?= $filter_category == 'Hobby' ? 'selected' : '' ?>>Hobby</option>
                            <option value="Work" <?= $filter_category == 'Work' ? 'selected' : '' ?>>Work</option>
                            <option value="Finance" <?= $filter_category == 'Finance' ? 'selected' : '' ?>>Finance</option>
                            <option value="Health" <?= $filter_category == 'Health' ? 'selected' : '' ?>>Health</option>
                        </select>
                        <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded">Search</button>
                    </form>
                </div>

                <!-- Task Management Table -->
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr class="text-left bg-gray-200">
                                <th>Task</th>
                                <th>Status</th>
                                <th>Category</th>
                                <th>Due date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($task = $tasks->fetch_assoc()): ?>
                                <tr class="bg-gray-100 hover:bg-gray-200">
                                    <td><?= htmlspecialchars($task['name']) ?></td>
                                    <td><span class="status-<?= htmlspecialchars($task['status']) ?> px-2 py-1 rounded"><?= htmlspecialchars($task['status']) ?></span></td>
                                    <td><?= htmlspecialchars($task['category']) ?></td>
                                    <td><?= htmlspecialchars(date('Y-m-d H:i', strtotime($task['due_date']))) ?></td>
                                    <td>
                                        <a href="edit_task.php?id=<?= htmlspecialchars($task['id']) ?>" class="text-blue-600">Edit</a>
                                        <form method="post" action="delete_task.php" style="display:inline">
                                            <input type="hidden" name="task_id" value="<?= htmlspecialchars($task['id']) ?>">
                                            <button class="text-red-600">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr class="bg-gray-50 hover:bg-gray-200">
                                    <!-- Repeat the row content for each task, alternating classes -->
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- New Task Modal -->
                <input type="checkbox" id="new-task-modal" class="modal-toggle" />
                <div class="modal">
                    <div class="modal-box">
                        <h3 class="font-bold text-lg mb-4">Add New Task</h3>
                        <!-- Form submits to the same page -->
                        <form method="post" action="task_page.php">
                            <div class="mb-4">
                                <input type="text" name="task_name" placeholder="Task name" required class="input input-bordered w-full" />
                            </div>
                            <div class="mb-4">
                                <select name="status" class="select select-bordered w-full">
                                    <option value="Not Started Yet">Not Started Yet</option>
                                    <option value="Working on it">Working on it</option>
                                    <option value="Stuck">Stuck</option>
                                    <option value="Done">Done</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <select name="category" class="select select-bordered w-full">
                                    <option value="Hobby">Hobby</option>
                                    <option value="Work">Work</option>
                                    <option value="Finance">Finance</option>
                                    <option value="Health">Health</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <input type="datetime-local" name="due_date" required class="input input-bordered w-full" />
                            </div>
                            <div class="modal-action">
                                <button type="submit" name="add_task" class="btn btn-accent">Add Task</button>
                                <label for="new-task-modal" class="btn">Cancel</label>
                            </div>
                        </form>
                    </div>
                </div>

            </main>
        </div>

        <!-- Sidebar -->
        <div class="drawer-side">
            <label for="my-drawer" class="drawer-overlay"></label>
            <ul class="menu p-4 w-50 h-full bg-gray-50 text-gray-800">
                <!-- Sidebar content here -->
                <li class="mb-4 flex flex-col items-center">
                    <!-- Centered and larger Todora text -->
                    <a class="text-3xl font-bold mb-2 text-gray-800 text-center">Todora</a>
                    <!-- Non-clickable border -->
                    <div class="w-full border-b border-gray-300 mb-4 pointer-events-none"></div>
                </li>
                <li><a href="/UTS-WEBPROG-LAB/views/home.php" class="text-gray-600 hover:text-gray-900">Home</a></li>
                <li><a href="/UTS-WEBPROG-LAB/views/task_page.php" class="text-gray-600 hover:text-gray-900">Task Management</a></li>
            </ul>
        </div>
    </div>
</body>
</html>

<?php
// Include your database connection
include('db.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_task'])) {
    // Get the form data
    $task_name = $_POST['task_name'];
    $status = $_POST['status'];
    $category = $_POST['category'];
    $due_date = $_POST['due_date'];

    // Insert the new task into the database
    $sql = "INSERT INTO tasks (name, status, category, due_date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $task_name, $status, $category, $due_date);
    
    if ($stmt->execute()) {
        // If the insertion is successful, redirect back to the same page
        header("Location: task_page.php");
        exit();
    } else {
        // If there's an error, you can handle it here (optional)
        echo "Error: " . $stmt->error;
    }
}

// Fetch tasks from the database to display in the table
$sql = "SELECT * FROM tasks ORDER BY due_date ASC";
$tasks = $conn->query($sql);

?>
