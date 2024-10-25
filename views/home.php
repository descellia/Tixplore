<<<<<<< Updated upstream
=======
<?php
include('db.php');
require 'fungsi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: views/auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT profile_pic, username FROM users WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$default_profile_pic = 'uploads/hmif_umn_logo.jpeg';
$profile_pic = !empty($user['profile_pic']) ? $user['profile_pic'] : $default_profile_pic;

$username = !empty($user['username']) ? $user['username'] : 'Guest';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter_category = isset($_GET['filter_category']) ? $_GET['filter_category'] : '';

function getFilteredTasksForToday($db, $user_id, $search, $filter_category) {
    $today_start = date('Y-m-d 00:00:00');
    $today_end = date('Y-m-d 23:59:59');

    $query = "SELECT * FROM tasks WHERE user_id = ? AND due_date BETWEEN ? AND ?";
    
    if (!empty($search)) {
        $query .= " AND name LIKE ?";
    }

    if (!empty($filter_category)) {
        $query .= " AND category = ?";
    }

    $stmt = $db->prepare($query);
    if (!empty($search) && !empty($filter_category)) {
        $search = "%$search%";
        $stmt->bind_param('isss', $user_id, $today_start, $today_end, $search, $filter_category);
    } elseif (!empty($search)) {
        $search = "%$search%";
        $stmt->bind_param('iss', $user_id, $today_start, $today_end, $search);
    } elseif (!empty($filter_category)) {
        $stmt->bind_param('iss', $user_id, $today_start, $today_end, $filter_category);
    } else {
        $stmt->bind_param('iss', $user_id, $today_start, $today_end);
    }

    $stmt->execute();
    return $stmt->get_result();
}

$tasks = getFilteredTasksForToday($db, $user_id, $search, $filter_category);
?>

>>>>>>> Stashed changes
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/output.css" rel="stylesheet">
    <link rel="stylesheet" href="/node_modules/aos/dist/aos.css">
    <title>Home</title>
</head>
<<<<<<< Updated upstream
<body>
    <div class="navbar bg-base-100">
    <div class="flex-1">
        <a class="btn btn-ghost text-xl">Tixplore</a>
    </div>
    <div class="flex-none gap-2">
        <div class="form-control">
        <input type="text" placeholder="Search" class="input input-bordered w-24 md:w-auto" />
        </div>
        <div class="dropdown dropdown-end">
        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
            <div class="w-10 rounded-full">
            <img
                alt="Tailwind CSS Navbar component"
                src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
            </div>
        </div>
        <ul
            tabindex="0"
            class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
            <li>
            <a class="justify-between">
                Profile
                <span class="badge">New</span>
            </a>
            </li>
            <li><a>Settings</a></li>
            <li><a>Logout</a></li>
        </ul>
        </div>
=======

<body class="bg-gray-100 text-gray-800">
    <div class="drawer lg:drawer-open">
        <input id="my-drawer" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col">
            <!-- Page content here -->
            <main class="p-4 lg:p-8">
                <div class="flex justify-between items-center mb-8">
                    <!-- Personalized Welcome Message -->
                    <h2 class="text-3xl font-bold text-gray-900">Welcome, <?= htmlspecialchars($username) ?>!</h2>
                    <div class="flex items-center space-x-4">
                        <!-- Avatar with link to profile.php -->
                        <a href='/profile' class="avatar">
                            <div class="w-10 rounded-full">
                                <img src="<?= htmlspecialchars($profile_pic) ?>" alt="Profile Picture">
                            </div>
                        </a>
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
        <?php include('components/drawer.php'); ?>
>>>>>>> Stashed changes
    </div>
    </div>

    <button class="btn btn-primary" action="/login">Button</button>

    <section class="text-center mt-12">
        <h1 class="text-4xl font-bold text-gray-900">Find and Book Your Next Event</h1>
        <p class="mt-4 text-gray-600">Discover events, buy tickets, and make the most of your experiences.</p>
        <div class="mt-6">
            <a href="/events" class="bg-blue-500 text-white px-8 py-3 rounded-md hover:bg-blue-600">Browse Events</a>
        </div>
    </section>

    <section class="container mx-auto mt-12">
        <h2 class="text-2xl font-bold text-gray-900 text-center mb-6">Upcoming Events</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Event Card 1 -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <img src="/path/to/event-image1.jpg" alt="Event 1" class="w-full h-48 object-cover rounded-t-lg">
                <div class="mt-4" data-aos="fade-up">
                    <h3 class="text-xl font-semibold text-gray-900">Event Title 1</h3>
                    <p class="text-gray-600 mt-2">Brief description of the event.</p>
                    <div class="mt-4">
                        <a href="/eventdetails/event1" class="text-blue-500 hover:underline">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <img src="/path/to/event-image1.jpg" alt="Event 1" class="w-full h-48 object-cover rounded-t-lg">
                <div class="mt-4" data-aos="fade-up">
                    <h3 class="text-xl font-semibold text-gray-900">Event Title 1</h3>
                    <p class="text-gray-600 mt-2">Brief description of the event.</p>
                    <div class="mt-4">
                        <a href="/eventdetails/event1" class="text-blue-500 hover:underline">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <img src="/path/to/event-image1.jpg" alt="Event 1" class="w-full h-48 object-cover rounded-t-lg">
                <div class="mt-4" data-aos="fade-up">
                    <h3 class="text-xl font-semibold text-gray-900">Event Title 1</h3>
                    <p class="text-gray-600 mt-2">Brief description of the event.</p>
                    <div class="mt-4">
                        <a href="/eventdetails/event1" class="text-blue-500 hover:underline">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <img src="/path/to/event-image1.jpg" alt="Event 1" class="w-full h-48 object-cover rounded-t-lg">
                <div class="mt-4" data-aos="fade-up">
                    <h3 class="text-xl font-semibold text-gray-900">Event Title 1</h3>
                    <p class="text-gray-600 mt-2">Brief description of the event.</p>
                    <div class="mt-4">
                        <a href="/eventdetails/event1" class="text-blue-500 hover:underline">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6" data-aos="fade-up">
                <img src="/path/to/event-image1.jpg" alt="Event 1" class="w-full h-48 object-cover rounded-t-lg">
                <div class="mt-4" data-aos="fade-up">
                    <h3 class="text-xl font-semibold text-gray-900">Harusnya naik</h3>
                    <p class="text-gray-600 mt-2">Brief description of the event.</p>
                    <div class="mt-4">
                        <a href="/eventdetails/event1" class="text-blue-500 hover:underline">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <img src="/path/to/event-image1.jpg" alt="Event 1" class="w-full h-48 object-cover rounded-t-lg">
                <div class="mt-4" data-aos="fade-up">
                    <h3 class="text-xl font-semibold text-gray-900">Event Title 1</h3>
                    <p class="text-gray-600 mt-2">Brief description of the event.</p>
                    <div class="mt-4">
                        <a href="/eventdetails/event1" class="text-blue-500 hover:underline">Learn More</a>
                    </div>
                </div>
            </div>
            <!-- Repeat Event Card for more events -->
        </div>
    </section>

    <footer class="bg-gray-800 text-white mt-12">
        <div class="container mx-auto py-6 text-center">
            <p>&copy; 2023 Event Ticketing. All rights reserved.</p>
        </div>
    </footer>

    <script src="/node_modules/aos/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>