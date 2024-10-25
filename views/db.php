<?php
// db.php

// Database configuration
$host = 'localhost'; // or your database host
$user = 'root';
$password = '';
$database = 'todo_app';

// Create a connection
$db = new mysqli($host, $user, $password, $database);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>
