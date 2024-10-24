<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Register</title>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center">
    <a href="/" class="mb-5 text-6xl font-bold text-gray-700"> <h1>Tixplore</h1> </a>
    <div class="card lg:card-side bg-base-100 shadow-xl">
        <figure>
            <img src="https://img.daisyui.com/images/stock/photo-1494232410401-ad00d5433cfa.webp" alt="Album" class="h-full w-full object-cover rounder-r-lg"/>
        </figure>

        <form action="../../config/register_process.php" method="POST">

            <?php if (isset($_GET['error'])): ?>
                <div class="flex justify-center">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative m-4 w-full max-w-sm" role="alert">
                        <?php if ($_GET['error'] === 'empty'): ?>
                            <span class="block sm:inline">Please fill all the fields.</span>
                        <?php elseif ($_GET['error'] === 'failed'): ?>
                            <span class="block sm:inline">Registration failed, please try again.</span>
                        <?php endif; ?>
                    </div>
                </div>
                
            <?php elseif (isset($_GET['message']) && $_GET['message'] === 'registered'): ?>
                <div class="text-green-500 mb-4">
                    <span class="block sm:inline">Registration successful! You can now <a href="login.php" class="text-blue-500 underline">login</a>.</span>
                </div>
            <?php endif; ?>

            <div class="card-body w-min">
                <div class="my-auto">
                    <h2 class="card-title text-2xl text-Blue flex justify-center mb-4">Registration</h2>

                    <div class="flex">
                        
                        <div class="flex flex-col mr-2">
                            <label>First Name</label>

                            <input type="text" name="firstname" class="border border-black rounded h-8 p-1" required/>
                        </div>

                        <div class="flex flex-col">
                            <label>Last Name</label>

                            <input type="text" name="lastname" class="border border-black rounded h-8 p-1"/>
                        </div>
                    </div>

                    <div class="flex flex-col">
                        <label>Username</label>

                        <input type="text" name="username" class="border border-black rounded h-8 p-1" required/>
                    </div>
                    
                    <div class="flex flex-col">
                        <label>Birth Date</label>

                        <input type="date" name="birthdate" class="border border-black rounded h-8 p-1" required/>
                    </div>

                    <div class="flex flex-col">
                        <label>Email</label>
                        <input type="text" name="email" class="border border-black rounded h-8 p-1" required/>
                    </div>

                    <div class="flex flex-col relative">
                        <label>Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" class="border border-black rounded h-8 p-1 pr-10 w-full"/>

                            <i class="fa-regular fa-eye absolute right-2 top-1/2 transform -translate-y-1/2 cursor-pointer" onclick="visible('password')"></i>
                        </div>
                    </div>

                    <div class="mt-2">
                        <input type="checkbox" name="persetujuan" required />
                        <label for="persetujuan" class="whitespace-normal break-words">
                            Dengan mencentang box ini, saya menyetujui persyaratan-persyaratan dari Tixplore
                        </label>
                    </div>

                    <div class="mt-2 btn btn-secondary hover:bg-LightGray hover:text-Blue w-full">
                        <button type="submit">Register</button>
                    </div>

                </div>
            </div>
        </form>

        <script>
            function visible(id)
            {
                const field = document.getElementById(id);
                field.type = field.type === 'password' ? 'text' : 'password';
            }
        </script>

    </div>
</body>
</html>
