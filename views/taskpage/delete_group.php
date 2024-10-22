<?php
require 'fungsi.php';

if (isset($_POST['group_id'])) {
    deleteGroup($conn, $_POST['group_id']);
}

header('Location: task_page.php');
?>
