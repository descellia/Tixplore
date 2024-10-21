<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.5.0/dist/full.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dycalendarjs@2.0.0/css/dycalendar.min.css">
    <script src="https://cdn.jsdelivr.net/npm/dycalendarjs@2.0.0/js/dycalendar.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
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

                <!-- Calendar and Daily Quote Section -->
                <div class="flex gap-4 mb-8">
                    <!-- Calendar Card -->
                    <div class="card bg-base-100 shadow-xl flex-1">
                    <div class="bg-base-100 shadow-lg p-4 flex-1">
                        <h3 class="text-xl font-bold mb-4">Calendar</h3>
                        <div id="dycalendar" class="border-2 border-gray-300 p-4 h-64 flex items-center justify-center">
                            <!-- Placeholder or calendar will be loaded here -->
                            <span>Loading Calendar...</span>
                        </div>
                    </div>
                    </div>

                    <!-- Daily Quote Card -->
                    <div class="card bg-base-100 shadow-xl flex-1">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Daily Quote</h3>
                            <p id="dailyQuote" class="text-xl italic"></p>
                        </div>
                    </div>
                </div>

                <!-- Today's Tasks Section -->
                <div class="card bg-base-100 shadow-xl mb-8">
                    <div class="card-body">
                        <h3 class="card-title mb-4">Today's Tasks</h3>

                        <!-- Tabs for Task Sorting -->
                        <div role="tablist" class="flex mb-4 border-b">
                            <input type="radio" name="my_tabs" role="tab" class="tab tab-bordered hidden" aria-label="Not Worked" id="tab1" checked />
                            <label for="tab1" class="tab cursor-pointer pb-2 border-b-2 border-transparent hover:border-base-500 active:border-base-500">Not Worked</label>

                            <input type="radio" name="my_tabs" role="tab" class="tab tab-bordered hidden" aria-label="Ongoing" id="tab2" />
                            <label for="tab2" class="tab cursor-pointer pb-2 border-b-2 border-transparent hover:border-base-500 active:border-base-500">Ongoing</label>

                            <input type="radio" name="my_tabs" role="tab" class="tab tab-bordered hidden" aria-label="Completed" id="tab3" />
                            <label for="tab3" class="tab cursor-pointer pb-2 border-b-2 border-transparent hover:border-base-500 active:border-base-500">Completed</label>
                        </div>

                        <!-- Task Content -->
                        <div id="content1" role="tabpanel" class="tab-content p-4">
                            <div class="grid grid-cols-1 gap-4">
                                <div class="card bg-base-200">
                                    <div class="card-body">
                                        <label class="label cursor-pointer">
                                            <input type="checkbox" class="checkbox checkbox-primary" />
                                            <span class="label-text">Task 1 - Not Started</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="card bg-base-200">
                                    <div class="card-body">
                                        <label class="label cursor-pointer">
                                            <input type="checkbox" class="checkbox checkbox-primary" />
                                            <span class="label-text">Task 2 - Not Started</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="content2" role="tabpanel" class="tab-content p-4 hidden">
                            <div class="grid grid-cols-1 gap-4">
                                <div class="card bg-base-200">
                                    <div class="card-body">
                                        <label class="label cursor-pointer">
                                            <input type="checkbox" class="checkbox checkbox-primary" />
                                            <span class="label-text">Working on Asia Project</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="card bg-base-200">
                                    <div class="card-body">
                                        <label class="label cursor-pointer">
                                            <input type="checkbox" class="checkbox checkbox-primary" />
                                            <span class="label-text">Team Meeting</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="content3" role="tabpanel" class="tab-content p-4 hidden">
                            <div class="grid grid-cols-1 gap-4">
                                <div class="card bg-base-200">
                                    <div class="card-body">
                                        <label class="label cursor-pointer">
                                            <input type="checkbox" class="checkbox checkbox-primary" />
                                            <span class="label-text">Final Report Submission</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
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

    <script src="https://cdn.jsdelivr.net/npm/daisyui@3.5.0/dist/full.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize dyCalendar
        dycalendar.draw({
            target: '#dycalendar',
            type: 'month',
            highlighttoday: true
        });

        // Task Progress Update
        const checkboxes = document.querySelectorAll('.checkbox');

        function updateProgress() {
            const totalTasks = checkboxes.length;
            const completedTasks = Array.from(checkboxes).filter(cb => cb.checked).length;
        }

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateProgress);
        });

        updateProgress(); // Initialize progress on page load

        // Fetch daily quote from quotable.io API
        fetch('https://api.quotable.io/random')
            .then(response => response.json())
            .then(data => {
                document.getElementById('dailyQuote').textContent = `"${data.content}" - ${data.author}`;
            })
            .catch(error => {
                console.error('Error fetching quote:', error);
                document.getElementById('dailyQuote').textContent = 'Unable to fetch quote at this time.';
            });

        // Tab Functionality
        const tabs = document.querySelectorAll('input[name="my_tabs"]');
        const contents = document.querySelectorAll('.tab-content');
        const tabLabels = document.querySelectorAll('label[for^="tab"]'); // Select tab labels

        tabs.forEach((tab, index) => {
            tab.addEventListener('change', () => {
                // Hide all tab contents
                contents.forEach((content) => {
                    content.classList.add('hidden');
                });
                // Show the selected tab content
                contents[index].classList.remove('hidden');

                // Adjust active class for tabs
                tabLabels.forEach((label) => {
                    label.classList.remove('border-b-primary');
                });
                tabLabels[index].classList.add('border-b-primary');
            });
        });
    });
    </script>
</body>

</html>
