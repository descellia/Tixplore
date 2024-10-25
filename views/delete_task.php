<?php
require 'fungsi.php';

if (isset($_POST['task_id'])) {
    deleteTask($conn, $_POST['task_id']);
}

header('Location: /task_page');
?>
