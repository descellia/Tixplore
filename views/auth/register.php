<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/output.css" rel="stylesheet">
    <title>Register</title>
</head>
<<<<<<< Updated upstream
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-3xl font-bold mb-6 text-center text-blue-600">Create an Account</h1>
        <form action="register_process.php" method="post">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username" required class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
=======
<body>
    <div class="card">
        <form action="../../config/register_process.php" method="POST"> <!-- Corrected form action -->

            <?php if (isset($_GET['error'])): ?>
                <div class="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <?php if ($_GET['error'] === 'empty'): ?>
                        <span>Please fill all the fields.</span>
                    <?php elseif ($_GET['error'] === 'failed'): ?>
                        <span>Registration failed, please try again.</span>
                    <?php endif; ?>
                </div>
            <?php elseif (isset($_GET['message']) && $_GET['message'] === 'registered'): ?>
                <div class="text-green-500 mb-4 text-center">
                    <span>Registration successful! You can now <a href="login.php" class="text-blue-500 underline">login</a>.</span>
                </div>
            <?php endif; ?>

            <h2 class="card-title">Registration</h2>

            <div class="flex">
                <div class="flex-col flex-grow mr-2">
                    <label>First Name</label>
                    <input type="text" name="firstname" required />
                </div>

                <div class="flex-col flex-grow">
                    <label>Last Name</label>
                    <input type="text" name="lastname" />
                </div>
>>>>>>> Stashed changes
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" required class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" required class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex justify-center mt-6">
                <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-600 transition duration-300 ease-in-out">Register</button>
            </div>
        </form>
        <div class="mt-6 text-center">
            <p class="text-gray-600">Already have an account? <a href="/login" class="text-blue-500 hover:underline">Login</a></p>
        </div>
    </div>
</body>
</html>
