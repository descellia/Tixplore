<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/output.css" rel="stylesheet">
    <title>Login</title>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="flex flex-col justify-center items-center w-full p-6">
        <h1 class="text-3xl font-bold mb-6 text-center">Login</h1>
        <form action="../../config/login_process.php" method="post" class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username" required class="mt-1 p-2 w-full border rounded-md">
            </div>
<<<<<<< Updated upstream
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" required class="mt-1 p-2 w-full border rounded-md">
=======
        <?php endif; ?>

        <h2 class="card-title">Welcome Back!</h2>
        <p class="text-gray-500 mb-6 text-center">Please input your account details</p>
        <form action="../../config/login_process.php" method="post">
            <div class="form-control">
                <label class="label text-gray-700">Email</label>
                <input type="email" name="email" placeholder="Enter your email" class="input" required />
>>>>>>> Stashed changes
            </div>
            <div class="flex justify-center">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Login</button>
            </div>
        </form>
    </div>
</body>

</html>
