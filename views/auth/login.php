<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/output.css" rel="stylesheet">
    <title>Login</title>
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
            background-color: #ffdddd;
            color: #d8000c;
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

        .flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .link {
            color: #007BFF;
            text-decoration: none;
            transition: color 0.3s;
        }

        .link:hover {
            color: #0056b3;
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
        <?php if (isset($_GET['error'])): ?>
            <div role="alert" class="alert">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <?php if ($_GET['error'] == 'invalid_credentials'): ?>
                    <span>Error! Invalid email or password.</span>
                <?php elseif ($_GET['error'] == 'user_not_found'): ?>
                    <span>Error! User not found.</span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <h2 class="card-title">Welcome Back!</h2>
        <p class="text-gray-500 mb-6 text-center">Please input your account details</p>
        <form action="login_process.php" method="post">
            <div class="form-control">
                <label class="label text-gray-700">Email</label>
                <input type="email" name="email" placeholder="Enter your email" class="input" required />
            </div>

            <div class="form-control">
                <label class="label text-gray-700">Password</label>
                <input type="password" name="password" placeholder="Enter your password" class="input" required />
            </div>

            <div class="flex justify-between mt-4 text-sm text-gray-500">
                <a href='/forget_password' class="link">Forgot password?</a>
                <a href='/register' class="link">Don't have an account? Register</a>
            </div>

            <div class="card-actions justify-center mt-6">
                <button type="submit" class="btn">Login</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                const alert = document.querySelector(".alert");
                if (alert) {
                    alert.setAttribute('data-aos', 'fade-out');
                    setTimeout(() => alert.style.display = 'none', 500);
                }
            }, 5000); 
        });
    </script>
</body>
</html>
