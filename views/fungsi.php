<?php
require 'db.php';

function addTask($db, $task_name, $status, $category, $due_date) {
    $stmt = $db->prepare("INSERT INTO tasks (name, status, category, due_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $task_name, $status, $category, $due_date);
    $stmt->execute();
    $stmt->close();
}

function getTasks($db) {
    $sql = "SELECT * FROM tasks";
    return $db->query($sql);
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

function deleteTask($db, $taskId) {
    $sql = "DELETE FROM tasks WHERE id = $taskId";
    $db->query($sql);
}

function getFilteredTasks($db, $search = '', $filter_category = '') {
    $query = "SELECT * FROM tasks WHERE 1=1";
    
    if ($search) {
        $query .= " AND name LIKE '%" . $db->real_escape_string($search) . "%'";
    }

    if ($filter_category) {
        $query .= " AND category = '" . $db->real_escape_string($filter_category) . "'";
    }

    $query .= " ORDER BY due_date ASC";

    return $db->query($query);
}

?>