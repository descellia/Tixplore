<?php
require '../config/db.php';

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

function getFilteredTasks($conn, $search = '', $filter_category = '') {
    $query = "SELECT * FROM tasks WHERE 1=1";
    
    if ($search) {
        $query .= " AND name LIKE '%" . $conn->real_escape_string($search) . "%'";
    }

    if ($filter_category) {
        $query .= " AND category = '" . $conn->real_escape_string($filter_category) . "'";
    }

    $query .= " ORDER BY due_date ASC";

    return $conn->query($query);
}

?>