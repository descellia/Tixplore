<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/output.css" rel="stylesheet">
    <title>Login</title>
</head>
<body class="bg-LightGray">
<div class="min-h-screen flex flex-col justify-center items-center p-5">
    <a href="/" class="mb-5 text-6xl font-bold text-gray-700"> <h1>Tixplore</h1> </a>

    <?php if (isset($_GET['error'])): ?>
        <div role="alert" class="alert alert-error">
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

    <div class="card lg:card-side bg-white shadow-lg lg:max-w-4xl">
        <div class="card-body lg:w-1/2">
            <h2 class="card-title text-2xl text-Blue">Welcome Back!</h2>
            <p class="text-gray-500 mb-6">Please input your account details</p>
            <form action="../../config/login_process.php" method="post">
                <div class="form-control">
                    <label class="label text-gray-700">Email</label>
                    <input type="email" name="email" placeholder="Enter your email" class="input border-Gray" required />
                </div>

                <div class="form-control mt-4">
                    <label class="label text-gray-700">Password</label>
                        <input type="password" name="password" placeholder="Enter your password" class="input border-Gray" required />
                </div>

                <div class="flex justify-between mt-4 text-sm text-gray-500">
                    <a href="/changepass" class="link link-hover">Forgot password?</a>
                    <a href="/register" class="link link-hover">Don't have an account? Register</a>
                </div>
                <div class="card-actions justify-center mt-6">
                    <button type="submit" class="btn btn-secondary hover:bg-LightGray hover:text-Blue w-full">Login</button>
                </div>
            </form>
        </div>
        <figure class="hidden lg:block lg:w-1/2">
            <img
            src="https://img.daisyui.com/images/stock/photo-1494232410401-ad00d5433cfa.webp"
            alt="Album" 
            class="h-full w-full object-cover rounded-r-lg">
        </figure>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            const alert = document.querySelector(".alert");
            if (alert) {
                alert.setAttribute('data-aos', 'fade-out');
                setTimeout(() => alert.style.display = 'none', 500); // Waktu sesuai durasi AOS
            }
        }, 5000); 
    });

    function visible(id) {
        const field = document.getElementById(id);
        field.type = field.type === 'password' ? 'text' : 'password';
    }
</script>
</body>
</html>