<?php
require 'db.php';

function addTask($conn, $task_name, $status, $category, $due_date, $user_id) {
    $stmt = $conn->prepare("INSERT INTO tasks (name, status, category, due_date, user_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $task_name, $status, $category, $due_date, $user_id); 
    $stmt->execute();
    $stmt->close();
}

function getTasks($conn) {
    $sql = "SELECT * FROM tasks";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getTaskById($conn, $task_id) {
    $stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function updateTask($conn, $task_id, $task_name, $status, $category, $due_date) {
    $stmt = $conn->prepare("UPDATE tasks SET name = ?, status = ?, category = ?, due_date = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $task_name, $status, $category, $due_date, $task_id);
    return $stmt->execute();
}

function deleteTask($conn, $taskId) {
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $taskId);
    return $stmt->execute();
}

function getFilteredTasks($conn, $search = '', $filter_category = '') {
    $query = "SELECT * FROM tasks WHERE 1=1";
    $types = "";
    $params = [];
    
    if ($search) {
        $query .= " AND name LIKE ?";
        $types .= "s";
        $search = "%" . $search . "%";
        $params[] = $search;
    }

    if ($filter_category) {
        $query .= " AND category = ?";
        $types .= "s";
        $params[] = $filter_category;
    }

    $query .= " ORDER BY due_date ASC";
    
    // Prepare statement
    $stmt = $conn->prepare($query);
    
    // Bind the parameters dynamically
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    return $stmt->get_result();
}

?>
