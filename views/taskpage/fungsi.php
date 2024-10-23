<?php
require 'db.php';

function addTask($conn, $task_name, $status, $category, $due_date) {
    $stmt = $conn->prepare("INSERT INTO tasks (name, status, category, due_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $task_name, $status, $category, $due_date);
    $stmt->execute();
    $stmt->close();
}

function getTasks($conn) {
    $sql = "SELECT * FROM tasks";
    return $conn->query($sql);
}

function getTaskById($conn, $task_id) {
    $stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    return $stmt->get_result();
}

function updateTask($conn, $task_id, $task_name, $status, $category, $due_date) {
    $stmt = $conn->prepare("UPDATE tasks SET name = ?, status = ?, category = ?, due_date = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $task_name, $status, $category, $due_date, $task_id);
    return $stmt->execute();
}

function deleteTask($conn, $taskId) {
    $sql = "DELETE FROM tasks WHERE id = $taskId";
    $conn->query($sql);
}

function getFilteredTasks($conn, $search, $filter_category) {
    $sql = "SELECT * FROM tasks WHERE 1=1";

    if (!empty($search)) {
        $sql .= " AND name LIKE '%" . $conn->real_escape_string($search) . "%'";
    }

    if (!empty($filter_category)) {
        $sql .= " AND category = '" . $conn->real_escape_string($filter_category) . "'";
    }

    return $conn->query($sql);
}

?>