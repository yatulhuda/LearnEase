<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    {{-- Top Navigation Bar --}}
    <header class="text-white shadow-md" style="background-color: #1e293b;">
        <div class="container mx-auto flex justify-between items-center px-6 py-4">
            <div class="text-2xl font-bold">LearnEase</div>
            
            <!-- Centered Navigation Links -->
            <div class="flex-1 flex justify-center space-x-6">
                <a href="{{ route('dashboards.hometeacher') }}" class="hover:text-blue-200 font-semibold">Dashboard</a>
                <a href="{{ route('teacher.subjects') }}" class="hover:text-blue-200 font-semibold">Assignments</a>
                <a href="{{ route('module3.teacher.index') }}" class="hover:text-blue-200 font-semibold">Quizzes</a>
                <a href="{{ route('teacherView.dashboard') }}" class="hover:text-blue-200 font-semibold">Subjects</a>
                <a href="{{ route('discussions.index') }}" class="hover:text-blue-200 font-semibold">Discussion</a>
            </div>

                {{-- Dropdown --}}
                <div class="relative">
                    <button onclick="toggleDropdown('studentDropdown')" class="flex items-center space-x-2 font-semibold hover:text-blue-200">
                        <span>{{ auth()->user()->name }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div id="studentDropdown" class="hidden absolute right-0 mt-2 w-40 bg-white text-black rounded shadow-lg z-10">
                        <a href="{{ route('teacher.profile.show') }}" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold mb-4 text-gray-800">Welcome, {{ auth()->user()->name }}!</h1>
        <p class="text-gray-700 mb-6"></p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
                <h3 class="font-bold text-lg mb-2">Assignments</h3>
                <p class="text-gray-600">Manage your assignments.</p>
                <a href="{{ route('teacher.subjects') }}" class="text-green-600 font-semibold mt-2 inline-block">Go</a>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
                <h3 class="font-bold text-lg mb-2">Quizzes</h3>
                <p class="text-gray-600">Manage upcoming quizzes and results.</p>
                <a href="{{ route('module3.teacher.index') }}" class="text-green-600 font-semibold mt-2 inline-block">Go</a>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
                <h3 class="font-bold text-lg mb-2">Subjects</h3>
                <p class="text-gray-600">Manage all your subjects and materials.</p>
                <a href="{{ route('teacherView.dashboard') }}" class="text-green-600 font-semibold mt-2 inline-block">Go</a>
            </div>
        </div>
    </main>

    <script>
        function toggleDropdown(id) {
            const menu = document.getElementById(id);
            menu.classList.toggle('hidden');
        }

        window.onclick = function(event) {
            if (!event.target.closest('.relative')) {
                document.getElementById('teacherDropdown').classList.add('hidden');
            }
        }
    </script>

</body>
</html>
