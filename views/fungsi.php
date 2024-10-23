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

function getGroups($conn) {
    $sql = "SELECT * FROM groups";
    $result = $conn->query($sql);
    return $result;
}

function updateTask($conn, $taskId, $taskName, $status, $category, $dueDate) {
    $sql = "UPDATE tasks SET name = '$taskName', status = '$status', category = '$category', due_date = '$dueDate' WHERE id = $taskId";
    $conn->query($sql);
}

function deleteTask($conn, $taskId) {
    $sql = "DELETE FROM tasks WHERE id = $taskId";
    $conn->query($sql);
}

function getFilteredTasks($conn, $search = '', $filter_category = '', $filter_status = '') {
    $sql = "SELECT * FROM tasks WHERE 1=1";
    
    if (!empty($search)) {
        $sql .= " AND name LIKE ?";
        $search = "%$search%";
    }
    
    if (!empty($filter_category)) {
        $sql .= " AND category = ?";
    }

    if (!empty($filter_status)) {
        $sql .= " AND status = ?";
    }

    $stmt = $conn->prepare($sql);
    
    if (!empty($search) && !empty($filter_category) && !empty($filter_status)) {
        $stmt->bind_param("sss", $search, $filter_category, $filter_status);
    } elseif (!empty($search) && !empty($filter_category)) {
        $stmt->bind_param("ss", $search, $filter_category);
    } elseif (!empty($search) && !empty($filter_status)) {
        $stmt->bind_param("ss", $search, $filter_status);
    } elseif (!empty($filter_category) && !empty($filter_status)) {
        $stmt->bind_param("ss", $filter_category, $filter_status);
    } elseif (!empty($search)) {
        $stmt->bind_param("s", $search);
    } elseif (!empty($filter_category)) {
        $stmt->bind_param("s", $filter_category);
    } elseif (!empty($filter_status)) {
        $stmt->bind_param("s", $filter_status);
    }

    $stmt->execute();
    return $stmt->get_result();
}

?>