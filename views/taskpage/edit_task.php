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
    <style>
        body {
            background-color: #f3f4f6; /* Light gray background */
            font-family: 'Arial', sans-serif; /* Custom font */
        }
        .container {
            background-color: #ffffff; /* White background for the form */
            border-radius: 12px; /* More pronounced rounded corners */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); /* Enhanced shadow for depth */
            padding: 30px; /* Increased padding for a spacious layout */
            margin-top: 50px; /* Margin to separate from top */
            max-width: 600px; /* Limit the width of the container */
            margin-left: auto; /* Center the container */
            margin-right: auto; /* Center the container */
        }
        h2 {
            color: #1d4ed8; /* Bright blue color for heading */
            text-align: center; /* Center the heading */
            margin-bottom: 20px; /* Space below the heading */
            font-weight: bold; /* Bold heading */
        }
        input, select {
            border: 1px solid #d1d5db; /* Light border */
            border-radius: 8px; /* Rounded corners */
            padding: 12px; /* Padding for input fields */
            width: 100%; /* Full width */
            margin-bottom: 20px; /* Space below each input */
            transition: border-color 0.3s; /* Smooth border color transition */
        }
        input:focus, select:focus {
            border-color: #1d4ed8; /* Blue border on focus */
            outline: none; /* Remove default outline */
            box-shadow: 0 0 5px rgba(29, 78, 216, 0.5); /* Subtle shadow on focus */
        }
        button {
            background-color: #1d4ed8; /* Blue background for button */
            color: white; /* White text for button */
            padding: 12px 20px; /* Padding for button */
            border: none; /* No border */
            border-radius: 8px; /* Rounded corners for button */
            cursor: pointer; /* Pointer cursor on hover */
            transition: background-color 0.3s, transform 0.2s; /* Smooth transitions */
            font-size: 16px; /* Slightly larger text for button */
            display: block; /* Center button */
            width: 100%; /* Full width */
            margin-top: 10px; /* Space above button */
        }
        button:hover {
            background-color: #2563eb; /* Darker blue on hover */
            transform: translateY(-2px); /* Lift effect on hover */
        }
        .countdown {
            font-weight: bold; /* Bold countdown text */
            color: #e53e3e; /* Red color for countdown */
            margin-top: 10px; /* Space above countdown */
            text-align: center; /* Center countdown text */
        }
        .due-date {
            font-style: italic; /* Italic for due date */
            color: #6b7280; /* Gray color for due date */
            text-align: center; /* Center due date text */
            margin-bottom: 10px; /* Space below due date */
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
