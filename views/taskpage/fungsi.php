<?php
require 'db.php';

function getGroups($conn) {
    $sql = "SELECT * FROM groups";
    $result = $conn->query($sql);
    return $result;
}

function getTasks($conn, $groupId) {
    $sql = "SELECT * FROM tasks WHERE group_id = $groupId";
    $result = $conn->query($sql);
    return $result;
}

function addGroup($conn, $groupName) {
    $sql = "INSERT INTO groups (name) VALUES ('$groupName')";
    $conn->query($sql);
}

function addTask($conn, $taskName, $status, $dueDate, $groupId) {
    $sql = "INSERT INTO tasks (name, status, due_date, group_id) VALUES ('$taskName', '$status', '$dueDate', $groupId)";
    $conn->query($sql);
}

function updateTask($conn, $taskId, $taskName, $status, $dueDate) {
    $sql = "UPDATE tasks SET name = '$taskName', status = '$status', due_date = '$dueDate' WHERE id = $taskId";
    $conn->query($sql);
}

function deleteTask($conn, $taskId) {
    $sql = "DELETE FROM tasks WHERE id = $taskId";
    $conn->query($sql);
}

function deleteGroup($conn, $groupId) {
    $sql = "DELETE FROM groups WHERE id = $groupId";
    $conn->query($sql);
    $sql = "DELETE FROM tasks WHERE group_id = $groupId";
    $conn->query($sql);
}
?>
