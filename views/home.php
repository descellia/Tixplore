<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/output.css" rel="stylesheet">
    <link rel="stylesheet" href="/node_modules/aos/dist/aos.css">
    <title>Home</title>
</head>
<body>
    <div class="navbar bg-base-100">
    <div class="flex-1">
        <a class="btn btn-ghost text-xl">Tixplore</a>
    </div>
    <div class="flex-none gap-2">
        <div class="form-control">
        <input type="text" placeholder="Search" class="input input-bordered w-24 md:w-auto" />
        </div>
        <div class="dropdown dropdown-end">
        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
            <div class="w-10 rounded-full">
            <img
                alt="Tailwind CSS Navbar component"
                src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
            </div>
        </div>
        <ul
            tabindex="0"
            class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
            <li>
            <a class="justify-between">
                Profile
                <span class="badge">New</span>
            </a>
            </li>
            <li><a>Settings</a></li>
            <li><a>Logout</a></li>
        </ul>
        </div>
    </div>
    </div>

    <button class="btn btn-primary" action="/login">Button</button>

    <section class="text-center mt-12">
        <h1 class="text-4xl font-bold text-gray-900">Find and Book Your Next Event</h1>
        <p class="mt-4 text-gray-600">Discover events, buy tickets, and make the most of your experiences.</p>
        <div class="mt-6">
            <a href="/events" class="bg-blue-500 text-white px-8 py-3 rounded-md hover:bg-blue-600">Browse Events</a>
        </div>
    </section>

    <section class="container mx-auto mt-12">
        <h2 class="text-2xl font-bold text-gray-900 text-center mb-6">Upcoming Events</h2>

        <div class="chat chat-start">
  <div class="chat-image avatar">
    <div class="w-10 rounded-full">
      <img
        alt="Tailwind CSS chat bubble component"
        src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
    </div>
  </div>
  <div class="chat-bubble">It was said that you would, destroy the Sith, not join them.</div>
</div>
<div class="chat chat-start">
  <div class="chat-image avatar">
    <div class="w-10 rounded-full">
      <img
        alt="Tailwind CSS chat bubble component"
        src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
    </div>
  </div>
  <div class="chat-bubble">It was you who would bring balance to the Force</div>
</div>
<div class="chat chat-start">
  <div class="chat-image avatar">
    <div class="w-10 rounded-full">
      <img
        alt="Tailwind CSS chat bubble component"
        src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
    </div>
  </div>
  <div class="chat-bubble">Not leave it in Darkness</div>
</div>


            <!-- Repeat Event Card for more events -->
    </section>

    <footer class="bg-gray-800 text-white mt-12">
        <div class="container mx-auto py-6 text-center">
            <p>&copy; 2023 Event Ticketing. All rights reserved.</p>
        </div>
    </footer>

    <script src="/node_modules/aos/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>