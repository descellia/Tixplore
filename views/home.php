<?php
require 'fungsi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_task'])) {
        addTask($conn, $_POST['task_name'], $_POST['status'], $_POST['category'], $_POST['due_date']);
    }
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter_category = isset($_GET['filter_category']) ? $_GET['filter_category'] : '';

function getFilteredTasksForToday($conn, $search, $filter_category) {
    $today_start = date('Y-m-d 00:00:00');  // Start of today (00:00)
    $today_end = date('Y-m-d 23:59:59');    // End of today (23:59)

    // Base query to fetch tasks between today 00:00 and 23:59
    $query = "SELECT * FROM tasks WHERE due_date BETWEEN ? AND ?";

    if (!empty($search)) {
        $query .= " AND name LIKE ?";
    }

    if (!empty($filter_category)) {
        $query .= " AND category = ?";
    }

    $stmt = $conn->prepare($query);

    // Binding parameters based on search and category filters
    if (!empty($search) && !empty($filter_category)) {
        $search = "%$search%";
        $stmt->bind_param('ssss', $today_start, $today_end, $search, $filter_category);
    } elseif (!empty($search)) {
        $search = "%$search%";
        $stmt->bind_param('sss', $today_start, $today_end, $search);
    } elseif (!empty($filter_category)) {
        $stmt->bind_param('sss', $today_start, $today_end, $filter_category);
    } else {
        $stmt->bind_param('ss', $today_start, $today_end);
    }

    $stmt->execute();
    return $stmt->get_result();
}

// Fetch tasks that are due today only
$tasks = getFilteredTasksForToday($conn, $search, $filter_category);
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
                    <div class="avatar">
                        <div class="w-10 rounded-full">
                            <img src="https://daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg" />
                        </div>
                    </div>
                </div>
            </div>

                <!-- Today's Tasks Section -->
                <div class="card bg-white border border-gray-200 rounded-lg mb-8">
                    <div class="card-body">
                        <h3 class="text-xl font-semibold text-gray-700 mb-4">Your Tasks for Today</h3>

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
                            <div class="overflow-x-auto">
                                <table class="table w-full">
                                    <thead>
                                        <tr class="text-left bg-gray-200">
                                            <th>Task</th>
                                            <th>Status</th>
                                            <th>Category</th>
                                            <th>Countdown</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($task = $tasks->fetch_assoc()): ?>
                                            <tr class="bg-gray-100 hover:bg-gray-200">
                                                <td><?= htmlspecialchars($task['name']) ?></td>
                                                <td><span class="status-<?= htmlspecialchars($task['status']) ?> px-2 py-1 rounded"><?= htmlspecialchars($task['status']) ?></span></td>
                                                <td><?= htmlspecialchars($task['category']) ?></td>
                                                <td class="countdown" data-due-date="<?= htmlspecialchars($task['due_date']) ?>"></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
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
                <li><a href="/UTS-WEBPROG-LAB/views/home.php" class="text-gray-600 hover:text-gray-900">Home</a></li>
                <li><a href="/UTS-WEBPROG-LAB/views/task_page.php" class="text-gray-600 hover:text-gray-900">Task Management</a></li>
            </ul>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const taskRows = document.querySelectorAll('#task-list tbody tr');
            taskRows.forEach(row => {
                const countdownCell = row.querySelector('.countdown');
                const dueDateAttr = countdownCell.dataset.dueDate;
                const status = row.querySelector('span').textContent.trim(); // Get task status
                const dueDate = new Date(dueDateAttr); // Convert due date to Date object

                // Check if the dueDateAttr is valid, else skip
                if (!dueDateAttr || isNaN(dueDate.getTime())) {
                    countdownCell.textContent = 'No due date';
                    return; // Skip this row if no valid due date
                }

                // If the task status is "Done", mark it as finished and skip countdown
                if (status === 'Done') {
                    countdownCell.textContent = 'Finished';
                    return; // Exit early if the task is done
                }

                // Proceed with countdown for non-Done tasks
                const countdown = setInterval(() => {
                    const now = new Date();
                    const timeDiff = dueDate - now;

                    if (timeDiff < 0) {
                        // If the task is overdue and not marked as done, show "Overdue"
                        countdownCell.textContent = 'Overdue';
                        clearInterval(countdown); // Stop the countdown
                    } else {
                        // Calculate hours and minutes remaining
                        const hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
                        countdownCell.textContent = `${hours}h ${minutes}m left`;
                    }
                }, 1000); 
            });

        });
    </script>
</body>
</html>
