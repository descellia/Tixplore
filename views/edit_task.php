<?php
require 'fungsi.php';

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];
    $task_result = getTaskById($db, $task_id);
    $task = $task_result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_name = $_POST['task_name'];
    $status = $_POST['status'];
    $category = $_POST['category'];
    $due_date = $_POST['due_date'];

    if (updateTask($db, $task_id, $task_name, $status, $category, $due_date)) {
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
    <style>
        body {
            background-color: #f3f4f6;
            font-family: 'Arial', sans-serif;
        }
        .container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 50px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        h2 {
            color: #1d4ed8;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
        input, select {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 12px;
            width: 100%;
            margin-bottom: 20px;
            transition: border-color 0.3s;
        }
        input:focus, select:focus {
            border-color: #1d4ed8;
            outline: none;
            box-shadow: 0 0 5px rgba(29, 78, 216, 0.5);
        }
        button {
            background-color: #1d4ed8;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            font-size: 16px;
            display: block;
            width: 100%;
            margin-top: 10px;
        }
        button:hover {
            background-color: #2563eb;
            transform: translateY(-2px);
        }
        .countdown {
            font-weight: bold;
            color: #e53e3e;
            margin-top: 10px;
            text-align: center;
        }
        .due-date {
            font-style: italic;
            color: #6b7280;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Task</h2>
        <form method="post">
            <input type="text" name="task_name" value="<?= htmlspecialchars($task['name']) ?>" required placeholder="Task Name">
            <select name="status">
                <option value="Done" <?= $task['status'] == 'Done' ? 'selected' : '' ?>>Done</option>
                <option value="Not Started Yet" <?= $task['status'] == 'Not Started Yet' ? 'selected' : '' ?>>Not Started Yet</option>
                <option value="Stuck" <?= $task['status'] == 'Stuck' ? 'selected' : '' ?>>Stuck</option>
                <option value="Working on it" <?= $task['status'] == 'Working on it' ? 'selected' : '' ?>>Working on it</option>
            </select>
            <select name="category">
                <option value="Hobby" <?= $task['category'] == 'Hobby' ? 'selected' : '' ?>>Hobby</option>
                <option value="Work" <?= $task['category'] == 'Work' ? 'selected' : '' ?>>Work</option>
                <option value="Finance" <?= $task['category'] == 'Finance' ? 'selected' : '' ?>>Finance</option>
                <option value="Health" <?= $task['category'] == 'Health' ? 'selected' : '' ?>>Health</option>
            </select>
            <input type="datetime-local" name="due_date" required>
            <span class="due-date" data-due-date="<?= htmlspecialchars($task['due_date']) ?>">
                <?= htmlspecialchars(date('Y-m-d H:i', strtotime($task['due_date']))) ?>
            </span>
            <span class="countdown" id="countdown-<?= htmlspecialchars($task['id']) ?>"></span>
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

                            countdownElement.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
                        };

                        setInterval(updateCountdown, 1000);
                        updateCountdown();
                    });
                });
            </script>
            <button type="submit">Update Task</button>
            <button type="button" onclick="window.location.href='task_page.php'" style="background-color: #e2e8f0; color: #4a5568;">Cancel</button>
        </form>
    </div>
</body>
</html>
