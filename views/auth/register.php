<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Register</title>
    <style>
        body {
            background-color: #e9f5ff;
            font-family: 'Arial', sans-serif; 
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
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

        input {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 12px;
            transition: border-color 0.3s, box-shadow 0.3s;
            font-size: 1em;
        }

        input:focus {
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

        .flex {
            display: flex;
        }

        .flex-col {
            flex-direction: column;
            margin-bottom: 20px;
        }

        label {
            margin-bottom: 5px;
            color: #333;
            font-weight: 600;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .checkbox-label input {
            margin-right: 8px;
        }

        .error-message {
            color: #d8000c;
            text-align: center;
            font-size: 0.9em;
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
        <form action="register_process.php" method="POST"> <!-- Corrected form action -->

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
            </div>

            <div class="flex-col">
                <label>Username</label>
                <input type="text" name="username" required />
            </div>

            <div class="flex-col">
                <label>Birth Date</label>
                <input type="date" name="birthdate" required />
            </div>

            <div class="flex-col">
                <label>Email</label>
                <input type="email" name="email" required />
            </div>

            <div class="flex-col relative">
                <label>Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required />
                    <i class="fa-regular fa-eye absolute right-2 top-1/2 transform -translate-y-1/2 cursor-pointer" onclick="visible('password')"></i>
                </div>
            </div>

            <div class="checkbox-label">
                <input type="checkbox" name="persetujuan" required />
                <label for="persetujuan" class="whitespace-normal break-words">
                    Dengan mencentang box ini, anda menyetujui persyaratan-persyaratan dari Todora
                </label>
            </div>

            <button type="submit" class="btn">Register</button>
            <button type="button" class="back-btn" onclick="window.location.href='login.php';">Back to Home</button> <!-- Back to Home Button -->

        </form>

        <script>
            function visible(id) {
                const field = document.getElementById(id);
                field.type = field.type === 'password' ? 'text' : 'password';
            }
        </script>

    </div>
</body>
</html>