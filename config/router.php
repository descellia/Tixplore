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

    } else if($path === '/profile') {
        include 'views/profile.php';

    } elseif (preg_match('/^\/eventdetails\/([a-zA-Z0-9_-]+)$/', $path, $matches)) {
        $event_name = $matches[1]; 
        include 'views/event_details.php';

    } else if ($path === '/eventdetails') {
        include 'views/event_details.php';
    }else if ($path === '/tes') {
        include 'views/tes.php';
    }else {
        include 'views/404.php';
    }
}
?>