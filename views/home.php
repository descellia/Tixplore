<?php
require 'fungsi.php';

// Search and filter logic
$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter_category = isset($_GET['category']) ? $_GET['category'] : '';
$filter_status = isset($_GET['status']) ? $_GET['status'] : '';

$tasks = getFilteredTasks($conn, $search, $filter_category, $filter_status); // Fetch filtered tasks
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.5.0/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/main.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/main.min.js"></script>
    <title>Todora - Task Management</title>
    <style>
        .status-Done { background-color: #3EE917; color: white; }
        .status-Not { background-color: #0e0c0c; color: white; }
        .status-Stuck { background-color: #EF4444; color: white; }
        .status-Working { background-color: #FBBF24; color: white; }
    </style>
</head>
<body class="bg-base-100 text-base-content">
    <div class="drawer lg:drawer-open">
        <input id="my-drawer" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col">
            <main class="p-4 lg:p-8">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold">Welcome, Dominica!</h2>
                    <div class="flex items-center space-x-4">
                        <div class="form-control">
                            <input type="text" name="search" placeholder="Search" value="<?= htmlspecialchars($search) ?>" class="input input-bordered w-24 md:w-auto" />
                        </div>
                        <div class="avatar">
                            <div class="w-10 rounded-full">
                                <img src="https://daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Calendar Section with FullCalendar Integration -->
                <div class="card bg-base-100 shadow-xl mb-8">
                    <div class="card-body">
                        <h3 class="card-title">Calendar</h3>
                        <div id="calendar" class="mt-4"></div>
                    </div>
                </div>

                <!-- Tasks Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Today's Tasks</h3>
                            <!-- Search and Filter -->
                            <form method="get" class="mb-4 flex justify-between">
                                <input type="text" name="search" placeholder="Search tasks..." value="<?= htmlspecialchars($search) ?>" class="border rounded px-2 py-1 mx-2">
                                
                                <select name="category" class="border rounded px-2 py-1 mx-2">
                                    <option value="">All Categories</option>
                                    <option value="Hobby" <?= $filter_category == 'Hobby' ? 'selected' : '' ?>>Hobby</option>
                                    <option value="Work" <?= $filter_category == 'Work' ? 'selected' : '' ?>>Work</option>
                                    <option value="Finance" <?= $filter_category == 'Finance' ? 'selected' : '' ?>>Finance</option>
                                    <option value="Health" <?= $filter_category == 'Health' ? 'selected' : '' ?>>Health</option>
                                </select>
                                
                                <select name="status" class="border rounded px-2 py-1 mx-2">
                                    <option value="">All Status</option>
                                    <option value="Done" <?= $filter_status == 'Done' ? 'selected' : '' ?>>Done</option>
                                    <option value="Not Started Yet" <?= $filter_status == 'Not Started Yet' ? 'selected' : '' ?>>Not started yet</option>
                                    <option value="Stuck" <?= $filter_status == 'Stuck' ? 'selected' : '' ?>>Stuck</option>
                                    <option value="Working on it" <?= $filter_status == 'Working on it' ? 'selected' : '' ?>>Working on it</option>
                                </select>

                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded mx-2">Filter</button>
                            </form>

                            <!-- Display tasks -->
                            <div class="mt-4" id="task-list">
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
                                            <td class="py-2"><?= htmlspecialchars($task['due_date']) ?></td>
                                            <td class="py-2">
                                                <button class="text-blue-600">Edit</button>
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
                                <br><br>
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
                                    <input type="date" name="due_date" required class="border rounded px-2 py-1">
                                    <button type="submit" name="add_task" class="bg-blue-600 text-white px-4 py-2 rounded">Add Task</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Daily Quote</h3>
                            <h2 class="font-bold" id="dailyQuote"></h2>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div class="drawer-side">
            <label for="my-drawer" class="drawer-overlay"></label>
            <ul class="menu p-4 w-80 h-full bg-base-200 text-base-content">
                <li><a class="text-xl font-bold mb-4">Todora</a></li>
                <li><a> Home</a></li>
                <li><a> Project</a></li>
                <li><a> Calendar</a></li>
                <li><a> Team Chat</a></li>
                <li><a>⚙️ Settings</a></li>
            </ul>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');

        if (calendarEl) {
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: [], // Populate with your event data
            });

            calendar.render();
        }

        // Fetch daily quote from the API
        async function fetchDailyQuote() {
            try {
                const response = await fetch('https://api.quotable.io/random');
                const data = await response.json();
                document.getElementById('dailyQuote').innerText = `"${data.content}" - ${data.author}`;
            } catch (error) {
                console.error('Error fetching daily quote:', error);
            }
        }

        fetchDailyQuote();
    });
    </script>
</body>
</html>
