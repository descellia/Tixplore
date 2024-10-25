<?php
require 'fungsi.php';

if (isset($_POST['task_id'])) {
    deleteTask($db, $_POST['task_id']);
}

header('Location: /task_page');
?>
