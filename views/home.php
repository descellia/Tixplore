<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.5.0/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/main.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/main.min.js"></script>
    <title>Todora - Task Management</title>
</head>
<body class="bg-base-100 text-base-content">
    <div class="drawer lg:drawer-open">
        <input id="my-drawer" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col">
            <!-- Page content here -->
            <main class="p-4 lg:p-8">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold">Welcome, Dominica!</h2>
                    <div class="flex items-center space-x-4">
                        <div class="form-control">
                            <input type="text" placeholder="Search" class="input input-bordered w-24 md:w-auto" />
                        </div>
                        <div class="avatar">
                            <div class="w-10 rounded-full">
                                <img src="https://daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Calendar Section with FullCalendar Integration -->
                <div class="card bg-base-100 shadow-xl mb-8">
                    <div class="card-body">
                        <h3 class="card-title">Calendar</h3>
                        <div id="calendar" class="mt-4"></div>
                    </div>
                </div>
                <!-- Tasks and Quotes -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Today's Tasks</h3>
                            <ul class="space-y-4">
                                <li>
                                    <div class="form-control">
                                        <label class="label cursor-pointer">
                                            <input type="checkbox" class="checkbox checkbox-primary" onclick="updateProgress()" />
                                            <span class="label-text">Working on Asia Project</span>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-control">
                                        <label class="label cursor-pointer">
                                            <input type="checkbox" class="checkbox checkbox-primary" onclick="updateProgress()" />
                                            <span class="label-text">Team Meeting</span>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-control">
                                        <label class="label cursor-pointer">
                                            <input type="checkbox" class="checkbox checkbox-primary" onclick="updateProgress()" />
                                            <span class="label-text">Doing Research</span>
                                        </label>
                                    </div>
                                </li>
                            </ul>
                            <div class="mt-4">
                                <progress id="taskProgress" class="progress progress-primary w-full" value="0" max="100"></progress>
                                <p id="taskCount" class="text-sm text-right mt-1">0/3 tasks completed</p>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Daily Quote</h3>
                                <h2 class="font-bold" id="dailyQuote"></h2>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div class="drawer-side">
            <label for="my-drawer" class="drawer-overlay"></label>
            <ul class="menu p-4 w-80 h-full bg-base-200 text-base-content">
                <!-- Sidebar content here -->
                <li><a class="text-xl font-bold mb-4">Todora</a></li>
                <li><a> Home</a></li>
                <li><a> Project</a></li>
                <li><a> Calendar</a></li>
                <li><a> Team Chat</a></li>
                <li><a>⚙️ Settings</a></li>
            </ul>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');

        if (calendarEl) {
            // Initialize FullCalendar only if the element exists
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: [
                    {
                        title: 'Asia Project',
                        start: '2023-08-01',
                    },
                    {
                        title: 'Team Meeting',
                        start: '2023-08-03T10:30:00',
                        end: '2023-08-03T12:30:00'
                    },
                    {
                        title: 'Research',
                        start: '2023-08-05'
                    }
                ],
                editable: true,
                selectable: true,
                dateClick: function(info) {
                    alert('Date clicked: ' + info.dateStr);
                }
            });

            calendar.render();
        } else {
            console.error('Calendar element not found');
        }

        // Task Progress Update
        const checkboxes = document.querySelectorAll('.checkbox');
        const progress = document.getElementById('taskProgress');
        const taskCount = document.getElementById('taskCount');

        function updateProgress() {
            const totalTasks = checkboxes.length;
            const completedTasks = Array.from(checkboxes).filter(cb => cb.checked).length;

            progress.value = (completedTasks / totalTasks) * 100;
            taskCount.textContent = `${completedTasks}/${totalTasks} tasks completed`;
        }

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateProgress);
        });

        updateProgress(); // Initialize progress on page load

        // Daily Quotes
        const quotes = [
            "The only way to do great work is to love what you do. - Steve Jobs",
            "Believe you can and you're halfway there. - Theodore Roosevelt",
            "Your limitation—it's only your imagination.",
            "Push yourself, because no one else is going to do it for you.",
            "Great things never come from comfort zones.",
            "Dream it. Wish it. Do it.",
            "Success doesn’t just find you. You have to go out and get it.",
            "The harder you work for something, the greater you’ll feel when you achieve it.",
            "Dream bigger. Do bigger.",
            "Don’t stop when you’re tired. Stop when you’re done."
        ];

        const dailyQuote = quotes[Math.floor(Math.random() * quotes.length)];
        document.getElementById('dailyQuote').textContent = dailyQuote;
    });
    </script>
</body>
</html>
