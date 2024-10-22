<?php
require 'fungsi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_group'])) {
        addGroup($conn, $_POST['group_name']);
    }
    if (isset($_POST['add_task'])) {
        addTask($conn, $_POST['task_name'], $_POST['status'], $_POST['due_date'], $_POST['group_id']);
    }
}

$groups = getGroups($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .status-Done { background-color: #3EE917; color: white; }
        .status-Not-started { background-color: #D1D5DB; color: black; }
        .status-Stuck { background-color: #EF4444; color: white; }
        .status-Working { background-color: #FBBF24; color: white; }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="mt-4" id="group-list">
                <?php while ($group = $groups->fetch_assoc()): ?>
                <div class="bg-white rounded shadow p-4 mb-4" id="group-<?= $group['id'] ?>">
                    <div class="flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-gray-700"><?= $group['name'] ?></h2>
                        <form method="post" action="delete_group.php">
                            <input type="hidden" name="group_id" value="<?= $group['id'] ?>">
                            <button class="text-red-600">Delete</button>
                        </form>
                    </div>

                    <!-- Display tasks -->
                    <table class="w-full mt-4">
                        <thead>
                            <tr class="text-left text-gray-600">
                                <th class="py-2">Task</th>
                                <th class="py-2">Status</th>
                                <th class="py-2">Due date</th>
                                <th class="py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="task-list-<?= $group['id'] ?>">
                            <?php
                            $tasks = getTasks($conn, $group['id']);
                            while ($task = $tasks->fetch_assoc()): ?>
                            <tr>
                                <td class="py-2"><?= $task['name'] ?></td>
                                <td class="py-2"><span class="status-<?= $task['status'] ?> px-2 py-1 rounded"><?= $task['status'] ?></span></td>
                                <td class="py-2"><?= $task['due_date'] ?></td>
                                <td class="py-2">
                                    <button class="text-blue-600">Edit</button>
                                    <form method="post" action="delete_task.php" style="display:inline">
                                        <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                        <button class="text-red-600">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>

                    <!-- Add new task form -->
                    <form method="post" class="mt-4">
                        <input type="text" name="task_name" placeholder="Task name" required class="border rounded px-2 py-1">
                        <select name="status" class="border rounded px-2 py-1">
                            <option value="Done">Done</option>
                            <option value="Not Started Yet">Not started yet</option>
                            <option value="Stuck">Stuck</option>
                            <option value="Working on it">Working on it</option>
                        </select>
                        <input type="date" name="due_date" required class="border rounded px-2 py-1">
                        <input type="hidden" name="group_id" value="<?= $group['id'] ?>">
                        <button type="submit" name="add_task" class="bg-blue-600 text-white px-4 py-2 rounded">Add Task</button>
                    </form>
                </div>
                <?php endwhile; ?>
            </div>

            <!-- Add new group form -->
            <form method="post" class="mt-4">
                <input type="text" name="group_name" placeholder="Group name" required class="border rounded px-2 py-1">
                <button type="submit" name="add_group" class="bg-white border rounded px-4 py-2">+ Add new group</button>
            </form>
        </div>
    </div>
</body>
</html>
