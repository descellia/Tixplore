<?php
require 'fungsi.php';

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];
    $task_result = getTaskById($conn, $task_id);
    $task = $task_result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_name = $_POST['task_name'];
    $status = $_POST['status'];
    $category = $_POST['category'];
    $due_date = $_POST['due_date'];

    if (updateTask($conn, $task_id, $task_name, $status, $category, $due_date)) {
        header("Location: task_page.php");
        exit;
    } else {
        echo "Error updating task.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="https://cdn.tailwindcss.com">
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-6">
        <h2 class="text-2xl mb-4">Edit Task</h2>
        <form method="post">
            <input type="text" name="task_name" value="<?= htmlspecialchars($task['name']) ?>" required class="border rounded px-2 py-1 mb-4">
            <select name="status" class="border rounded px-2 py-1 mb-4">
                <option value="Done" <?= $task['status'] == 'Done' ? 'selected' : '' ?>>Done</option>
                <option value="Not Started Yet" <?= $task['status'] == 'Not Started Yet' ? 'selected' : '' ?>>Not started yet</option>
                <option value="Stuck" <?= $task['status'] == 'Stuck' ? 'selected' : '' ?>>Stuck</option>
                <option value="Working on it" <?= $task['status'] == 'Working on it' ? 'selected' : '' ?>>Working on it</option>
            </select>
            <select name="category" class="border rounded px-2 py-1 mb-4">
                <option value="Hobby" <?= $task['category'] == 'Hobby' ? 'selected' : '' ?>>Hobby</option>
                <option value="Work" <?= $task['category'] == 'Work' ? 'selected' : '' ?>>Work</option>
                <option value="Finance" <?= $task['category'] == 'Finance' ? 'selected' : '' ?>>Finance</option>
                <option value="Health" <?= $task['category'] == 'Health' ? 'selected' : '' ?>>Health</option>
            </select>
                    <input type="datetime-local" name="due_date" required class="border rounded px-2 py-1">
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

                                            {
                                            if countdownElement.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
                                            }
                                        };

                                        setInterval(updateCountdown, 1000);
                                        updateCountdown();
                                    });
                                });
                            </script>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Task</button>
        </form>
    </div>
</body>
</html>
