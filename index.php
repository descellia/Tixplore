<?php
session_start();

require_once 'config/router.php';

$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';

router($path);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./assets/css/output.css" rel="stylesheet">
    <link rel="stylesheet" href="/node_modules/aos/dist/aos.css">
    <title></title>
</head>
<body>
    <script src="/node_modules/aos/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>