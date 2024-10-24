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
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.5.0/dist/full.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dycalendarjs@2.0.0/css/dycalendar.min.css">
    <script src="https://cdn.jsdelivr.net/npm/dycalendarjs@2.0.0/js/dycalendar.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Todora - Task Management</title>
    <style>
        .status-Done { background-color: #3EE917; color: white; }
        .status-Not { background-color: #0E0C0C; color: white; }
        .status-Stuck { background-color: #EF4444; color: white; }
        .status-Working { background-color: #FBBF24; color: white; }
    </style>
</head>

<body class="bg-gray-100 text-gray-800">
    <div class="drawer lg:drawer-open">
        <input id="my-drawer" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col">
            <!-- Page content here -->
            <main class="p-4 lg:p-8">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">Welcome, Dominica!</h2>
                    <div class="flex items-center space-x-4">
                        <div class="form-control">
                            <input type="text" placeholder="Search" name="search" class="input input-bordered input-accent w-24 md:w-auto" />
                        </div>
                        <div class="avatar">
                            <div class="w-10 rounded-full">
                                <img src="https://daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Calendar and Daily Quote Section -->
                <div class="flex gap-4 mb-8">
                    <div class="card bg-white border border-gray-200 rounded-lg flex-1">
                        <div class="p-4 flex-1">
                            <h3 class="text-xl font-semibold text-gray-700 mb-4">Calendar</h3>
                            <div id="dycalendar" class="border-2 border-gray-200 p-4 h-64 flex items-center justify-center bg-gray-50 rounded-lg">
                                <span>Loading Calendar...</span>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-white border border-gray-200 rounded-lg flex-1">
                        <div class="card-body">
                            <h3 class="text-xl font-semibold text-gray-700 mb-4">Daily Quote</h3>
                            <p id="dailyQuote" class="text-xl italic text-gray-600"></p>
                        </div>
                    </div>
                </div>

                <!-- Today's Tasks Section -->
                <div class="card bg-white border border-gray-200 rounded-lg mb-8">
                    <div class="card-body">
                        <h3 class="text-xl font-semibold text-gray-700 mb-4">Your Tasks</h3>

                        <!-- Search and Filter Form -->
                        <form method="get" class="mb-4 flex justify-end">
                            <input type="text" name="search" placeholder="Search task..." value="<?= htmlspecialchars($search) ?>" class="border rounded px-2 py-1">
                            <select name="filter_category" class="border rounded px-2 py-1 mx-2">
                                <option value="">All Categories</option>
                                <option value="Hobby" <?= $filter_category == 'Hobby' ? 'selected' : '' ?>>Hobby</option>
                                <option value="Work" <?= $filter_category == 'Work' ? 'selected' : '' ?>>Work</option>
                                <option value="Personal" <?= $filter_category == 'Personal' ? 'selected' : '' ?>>Personal</option>
                                <option value="Education" <?= $filter_category == 'Education' ? 'selected' : '' ?>>Education</option>
                                <option value="Finance" <?= $filter_category == 'Finance' ? 'selected' : '' ?>>Finance</option>
                                <option value="Health" <?= $filter_category == 'Health' ? 'selected' : '' ?>>Health</option>
                            </select>
                            <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded">Search</button>
                        </form>

                        <!-- Task Content -->
                        <div id="task-list">
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
                                                <?= htmlspecialchars(date('Y-m-d H:i', strtotime($task['due_date']))) ?>
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
                            <br>
                            <form method="post" class="mt-4">
            <button type="button" onclick="window.location.href='task_page.php'" class="bg-blue-600 text-white px-4 py-2 rounded">View Your Task</button>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div class="drawer-side">
            <label for="my-drawer" class="drawer-overlay"></label>
            <ul class="menu p-4 w-50 h-full bg-gray-50 text-gray-800">
                <li class="mb-4 flex flex-col items-center">
                    <a class="text-3xl font-bold mb-2 text-gray-800 text-center">Todora</a>
                    <div class="w-full border-b border-gray-300 mb-4 pointer-events-none"></div>
                </li>
                <li><a class="text-gray-600 hover:text-gray-900">Home</a></li>
                <li><a class="text-gray-600 hover:text-gray-900">Tasks</a></li>
                <li><a class="text-gray-600 hover:text-gray-900">Categories</a></li>
                <li><a class="text-gray-600 hover:text-gray-900">Settings</a></li>
                <li><a class="text-gray-600 hover:text-gray-900">Logout</a></li>
            </ul>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const taskRows = document.querySelectorAll('#task-list tbody tr');
            taskRows.forEach(row => {
                const dueDateCell = row.querySelector('.due-date');
                const countdownCell = row.querySelector('.countdown');
                const dueDate = new Date(dueDateCell.dataset.dueDate);

                const countdown = setInterval(() => {
                    const now = new Date();
                    const timeDiff = dueDate - now;

                    if (timeDiff < 0) {
                        countdownCell.textContent = 'EXPIRED';
                        clearInterval(countdown);
                    } else {
                        const hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
                        countdownCell.textContent = `${hours}h ${minutes}m left`;
                    }
                }, 1000);
            });

            // Initialize the calendar
            const calendar = new DyCalendar('#dycalendar', {
                theme: 'default',
                date: new Date(),
                onClick: function (date) {
                    alert('Clicked date: ' + date);
                }
            });
        });
    </script>
</body>
</html>
