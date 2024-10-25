<?php
function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function router($path) {
    $path = filter_var($path, FILTER_SANITIZE_URL);

    if($path === '/' || $path === '/home') {
        include 'views/home.php';

    } else if ($path === '/login') {
        include 'views/auth/login.php';

    } else if ($path === '/register') {
        include 'views/auth/register.php';

    } else if ($path === '/reset_password') {
        include 'views/auth/reset_password.php';

    } else if($path === '/profile') {
        include 'views/profile.php';

    } else if($path === '/logout') {
        include 'views/auth/logout.php';

    } else if($path === '/task_page') {
        include 'views/task_page.php';
    
    } else if($path === '/edit_task') {
        include 'views/edit_task.php';
    
    } else if($path === '/delete_task') {
        include 'views/delete_task';

    }else {
        include 'views/404.php';
    }
}
?>