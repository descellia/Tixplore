<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.5.0/dist/full.css" rel="stylesheet" type="text/css" />
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
                        <div class="card-body">
                            <h3 class="card-title mb-4">Calendar</h3>
                            <div class="grid grid-cols-7 gap-1 text-center">
                                <div class="font-bold">Sun</div>
                                <div class="font-bold">Mon</div>
                                <div class="font-bold">Tue</div>
                                <div class="font-bold">Wed</div>
                                <div class="font-bold">Thu</div>
                                <div class="font-bold">Fri</div>
                                <div class="font-bold">Sat</div>
                                <!-- Example dates -->
                                <div class="p-2 hover:bg-base-200 cursor-pointer">1</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">2</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">3</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">4</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">5</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">6</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">7</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">8</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">9</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">10</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">11</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">12</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">13</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">14</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">15</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">16</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">17</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">18</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">19</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">20</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">21</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">22</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">23</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">24</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">25</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">26</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">27</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">28</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">29</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">30</div>
                                <div class="p-2 hover:bg-base-200 cursor-pointer">31</div>
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

                // Update active tab style
                tabLabels.forEach(label => {
                    label.classList.remove('border-base-500'); // Remove active border
                });
                tabLabels[index].classList.add('border-base-500'); // Add active border to selected tab
            });
        });
    });
    </script>
</body>
</html>
