<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/output.css" rel="stylesheet">
    <title>Reset Password</title>
    <style>
        body {
            background-color: #e9f5ff;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .card {
            background-color: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 450px;
            padding: 30px;
        }

        .card-title {
            color: #007BFF;
            margin-bottom: 25px;
            text-align: center;
            font-size: 1.8em;
            font-weight: bold;
        }

        .input {
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 12px;
            transition: border-color 0.3s, box-shadow 0.3s;
            font-size: 1em;
            width: 100%;
            box-sizing: border-box;
        }

        .input:focus {
            border-color: #007BFF;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            outline: none;
        }

        .btn {
            background-color: #007BFF;
            color: white;
            border-radius: 10px;
            padding: 12px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            width: 100%;
            margin-top: 15px;
            height: 45px;
            font-size: 1em;
        }

        .btn:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .alert {
            background-color: #ddffdd;
            color: #4f8a10;
            padding: 12px;
            border-radius: 5px;
            margin: 15px 0;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9em;
        }

        .alert svg {
            width: 24px;
            height: 24px;
        }

        .form-control {
            margin-bottom: 20px;
        }

        .back-btn {
            background-color: #6c757d;
            color: white;
            border-radius: 10px;
            padding: 12px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            width: 100%;
            height: 45px;
            margin-top: 10px;
            font-size: 1em;
        }

        .back-btn:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="card">
        <h2 class="card-title">Reset Password</h2>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12l5 5L20 7" />
                </svg>
                <span>Password has been successfully reset!</span>
            </div>
        <?php endif; ?>

        <p class="text-gray-500 mb-6 text-center">Enter your new password.</p>
        <form action="reset_password_process.php" method="post">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>" />

            <div class="form-control">
                <label class="label text-gray-700">New Password</label>
                <input type="password" name="new_password" placeholder="Enter your new password" class="input" required />
            </div>

            <div class="form-control">
                <label class="label text-gray-700">Confirm Password</label>
                <input type="password" name="confirm_password" placeholder="Confirm your new password" class="input" required />
            </div>

            <div class="card-actions justify-center mt-6">
                <button type="submit" class="btn">Reset Password</button>
                <button type="button" class="back-btn" onclick="window.location.href='login.php';">Back to Home</button>
            </div>
        </form>
    </div>
</body>
</html>
