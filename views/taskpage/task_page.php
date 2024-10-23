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
    <title>To do List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .status-Done { background-color: #3EE917; color: white; }
        .status-Not { background-color: #0e0c0c; color: white; }
        .status-Stuck { background-color: #EF4444; color: white; }
        .status-Working { background-color: #FBBF24; color: white; }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        <!-- Main Content -->
        <div class="flex-1 p-6">

            <!-- Search and Filter Form -->
            <form method="get" class="mb-4 flex justify-end">
                <input type="text" name="search" placeholder="Search task..." value="<?= htmlspecialchars($search) ?>" class="border rounded px-2 py-1">
                <select name="filter_category" class="border rounded px-2 py-1 mx-2">
                    <option value="">All Categories</option>
                    <option value="Hobby" <?= $filter_category == 'Hobby' ? 'selected' : '' ?>>Hobby</option>
                    <option value="Work" <?= $filter_category == 'Work' ? 'selected' : '' ?>>Work</option>
                    <option value="Finance" <?= $filter_category == 'Finance' ? 'selected' : '' ?>>Finance</option>
                    <option value="Health" <?= $filter_category == 'Health' ? 'selected' : '' ?>>Health</option>
                </select>
                <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded">Search</button>
            </form>

            <div class="mt-4" id="task-list">
                <!-- Display tasks -->
                <table class="w-full mt-4">
                    <thead>
                        <tr class="text-left text-gray-600">
                            <th class="py-2">Task</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Category</th>
                            <th class="py-2">Due date</th>
                            <th class="py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($task = $tasks->fetch_assoc()): ?>
                        <tr>
                            <td class="py-2"><?= htmlspecialchars($task['name']) ?></td>
                            <td class="py-2"><span class="status-<?= htmlspecialchars($task['status']) ?> px-2 py-1 rounded"><?= htmlspecialchars($task['status']) ?></span></td>
                            <td class="py-2"><span class="category-<?= htmlspecialchars($task['category']) ?> px-2 py-1 rounded"><?= htmlspecialchars($task['category']) ?></span></td>
                            <td class="py-2">
                                <span class="due-date" data-due-date="<?= htmlspecialchars($task['due_date']) ?>">
                                    <?= htmlspecialchars(date('Y-m-d H:i', strtotime($task['due_date']))) ?> <!-- Format dengan waktu -->
                                </span>
                                <span class="countdown" id="countdown-<?= htmlspecialchars($task['id']) ?>"></span>
                            </td>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const dueDates = document.querySelectorAll('.due-date');

                                    dueDates.forEach(dueDateElement => {
                                        const dueDate = new Date(dueDateElement.dataset.dueDate).getTime();
                                        const countdownElement = document.getElementById('countdown-' + dueDateElement.closest('tr').querySelector('td:last-child').querySelector('form input[name="task_id"]').value);

                                        const updateCountdown = () => {
                                            const now = new Date().getTime();
                                            const distance = dueDate - now;
                                            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                            if (distance < 0) {
                                                countdownElement.innerHTML = "EXPIRED";
                                            } else {
                                                countdownElement.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
                                            }
                                        };

                                        setInterval(updateCountdown, 1000);
                                        updateCountdown();
                                    });
                                });
                            </script>

                            <td class="py-2">
                                <a href="edit_task.php?id=<?= htmlspecialchars($task['id']) ?>" class="text-blue-600">Edit</a>
                                <form method="post" action="delete_task.php" style="display:inline">
                                    <input type="hidden" name="task_id" value="<?= htmlspecialchars($task['id']) ?>">
                                    <button class="text-red-600">Delete</button>
                                </form>
                            </td>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <!-- Add new task form -->
                <br>
                <br>
                <form method="post" class="mt-4">
                    <input type="text" name="task_name" placeholder="Task name" required class="border rounded px-2 py-1">
                    <select name="status" class="border rounded px-2 py-1">
                        <option value="Done">Done</option>
                        <option value="Not Started Yet">Not started yet</option>
                        <option value="Stuck">Stuck</option>
                        <option value="Working on it">Working on it</option>
                    </select>
                    <select name="category" class="border rounded px-2 py-1">
                        <option value="Hobby">Hobby</option>
                        <option value="Work">Work</option>
                        <option value="Finance">Finance</option>
                        <option value="Health">Health</option>
                    </select>
                    <input type="datetime-local" name="due_date" required class="border rounded px-2 py-1">
                    <button type="submit" name="add_task" class="bg-blue-600 text-white px-4 py-2 rounded">Add Task</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
