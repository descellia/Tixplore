<?php
require 'fungsi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_task'])) {
        addTask($conn, $_POST['task_name'], $_POST['status'], $_POST['category'], $_POST['due_date']);
    }
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter_category = isset($_GET['filter_category']) ? $_GET['filter_category'] : '';
$tasks = getFilteredTasks($conn, $search, $filter_category);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f9fafb; /* Light gray background */
            font-family: 'Inter', sans-serif; /* Modern font */
        }
        .status-Done { background-color: #3EE917; color: white; }
        .status-Not { background-color: #0E0C0C; color: white; }
        .status-Stuck { background-color:  #EF4444; color: white; }
        .status-Working { background-color: #FBBF24; color: white; }
        .table-header {
            background-color: #edf2f7; /* Light background for header */
            font-weight: bold;
        }
        .task-row:hover {
            background-color: #f7fafc; /* Light hover effect for rows */
        }
        .add-task-form {
            background-color: #ffffff; /* White background for form */
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .button {
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #2b6cb0; /* Darker shade on hover */
        }
    </style>
</head>
<body>
    <div class="flex h-screen">
        <!-- Main Content -->
        <div class="flex-1 p-6">

            <!-- Search and Filter Form -->
            <form method="get" class="mb-4 flex justify-end">
                <input type="text" name="search" placeholder="Search task..." value="<?= htmlspecialchars($search) ?>" class="border rounded px-2 py-1 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                <select name="filter_category" class="border rounded px-2 py-1 mx-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">All Categories</option>
                    <option value="Hobby" <?= $filter_category == 'Hobby' ? 'selected' : '' ?>>Hobby</option>
                    <option value="Work" <?= $filter_category == 'Work' ? 'selected' : '' ?>>Work</option>
                    <option value="Personal" <?= $filter_category == 'Personal' ? 'selected' : '' ?>>Personal</option>
                    <option value="Education" <?= $filter_category == 'Education' ? 'selected' : '' ?>>Education</option>
                    <option value="Finance" <?= $filter_category == 'Finance' ? 'selected' : '' ?>>Finance</option>
                    <option value="Health" <?= $filter_category == 'Health' ? 'selected' : '' ?>>Health</option>
                </select>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded button">Search</button>
            </form>

            <div class="mt-4" id="task-list">
                <!-- Display tasks -->
                <table class="w-full mt-4">
                    <thead>
                        <tr class="table-header">
                            <th class="py-2">Task</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Category</th>
                            <th class="py-2">Due Date</th>
                            <th class="py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($task = $tasks->fetch_assoc()): ?>
                        <tr class="task-row">
                            <td class="py-2"><?= htmlspecialchars($task['name']) ?></td>
                            <td class="py-2"><span class="status-<?= htmlspecialchars($task['status']) ?> px-2 py-1 rounded"><?= htmlspecialchars($task['status']) ?></span></td>
                            <td class="py-2"><span class="category-<?= htmlspecialchars($task['category']) ?> px-2 py-1 rounded"><?= htmlspecialchars($task['category']) ?></span></td>
                            <td class="py-2">
                                <span class="due-date" data-due-date="<?= htmlspecialchars($task['due_date']) ?>">
                                    <?= htmlspecialchars(date('Y-m-d H:i', strtotime($task['due_date']))) ?> <!-- Format dengan waktu -->
                                </span>
                                <span class="countdown" id="countdown-<?= htmlspecialchars($task['id']) ?>"></span>
                            </td>

                            <td class="py-2">
                                <a href="edit_task.php?id=<?= htmlspecialchars($task['id']) ?>" class="text-blue-600">Edit</a>
                                <form method="post" action="delete_task.php" style="display:inline">
                                    <input type="hidden" name="task_id" value="<?= htmlspecialchars($task['id']) ?>">
                                    <button class="text-red-600">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <!-- Add new task form -->
                <div class="add-task-form mt-6">
                    <h2 class="text-lg font-semibold mb-4">Add New Task</h2>
                    <form method="post">
                        <input type="text" name="task_name" placeholder="Task name" required class="border rounded px-2 py-1 mb-2 w-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <select name="status" class="border rounded px-2 py-1 mb-2 w-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="Done">Done</option>
                            <option value="Not Started Yet">Not started yet</option>
                            <option value="Stuck">Stuck</option>
                            <option value="Working on it">Working on it</option>
                        </select>
                        <select name="category" class="border rounded px-2 py-1 mb-2 w-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="Hobby">Hobby</option>
                            <option value="Personal">Personal</option>
                            <option value="Education">Education</option>
                            <option value="Work">Work</option>
                            <option value="Finance">Finance</option>
                            <option value="Health">Health</option>
                        </select>
                        <input type="datetime-local" name="due_date" required class="border rounded px-2 py-1 mb-2 w-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <button type="submit" name="add_task" class="bg-blue-600 text-white px-4 py-2 rounded button">Add Task</button>
                        <button type="button" onclick="window.location.href='home.php'" class="bg-red-600 text-white px-4 py-2 rounded button">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
