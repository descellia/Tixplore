<?php
require 'db.php';

function addTask($conn, $task_name, $status, $category, $due_date, $user_id) {
    $stmt = $conn->prepare("INSERT INTO tasks (name, status, category, due_date, user_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $task_name, $status, $category, $due_date, $user_id);
    $stmt->execute();
    $stmt->close();
}

function getFilteredTasks($conn, $search = '', $filter_category = '', $user_id) {
    $query = "SELECT * FROM tasks WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);

    if ($search) {
        $query .= " AND name LIKE ?";
        $search_param = '%' . $conn->real_escape_string($search) . '%';
        $stmt->bind_param("ssi", $search_param, $user_id);
    }

    if ($filter_category) {
        $query .= " AND category = ?";
        $stmt->bind_param("ssi", $filter_category, $user_id);
    }

    $query .= " ORDER BY due_date ASC";
    $stmt->execute();

    return $stmt->get_result();
}

function getTaskById($db, $task_id) {
    $stmt = $db->prepare("SELECT * FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    return $stmt->get_result();
}

function updateTask($db, $task_id, $task_name, $status, $category, $due_date) {
    $stmt = $db->prepare("UPDATE tasks SET name = ?, status = ?, category = ?, due_date = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $task_name, $status, $category, $due_date, $task_id);
    return $stmt->execute();
}

function deleteTask($conn, $taskId) {
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $taskId);
    $stmt->execute();
}

?>
