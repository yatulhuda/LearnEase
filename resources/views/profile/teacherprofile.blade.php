<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Profile - LearnEase</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <!-- ================= HEADER ================= -->
    <!-- Top Navigation Bar -->
    <header class="text-white shadow-md" style="background-color: #1e293b;">
        <div class="container mx-auto flex justify-between items-center px-6 py-4">
        <div class="text-2xl font-bold">LearnEase</div>

        <div class="flex-1 flex justify-center space-x-6">
            <a href="{{ route('dashboards.hometeacher') }}" class="hover:text-blue-200 font-semibold">Dashboard</a>
            <a href="{{ route('teacher.subjects') }}" class="hover:text-blue-200 font-semibold">Assignments</a>
            <a href="{{ route('module3.teacher.index') }}" class="hover:text-blue-200 font-semibold">Quizzes</a>
            <a href="{{ route('teacherView.dashboard') }}" class="hover:text-blue-200 font-semibold">Subjects</a>
            <a href="{{ route('discussions.index') }}" class="hover:text-blue-200 font-semibold">Discussion</a>
        </div>

        {{-- Dropdown --}}
            <div class="relative">
                <button onclick="toggleDropdown('teacherDropdown')" class="flex items-center space-x-2 font-semibold hover:text-blue-200">
                    <span>{{ auth()->user()->name }}</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div id="teacherDropdown" class="hidden absolute right-0 mt-2 w-40 bg-white text-black rounded shadow-lg z-10">
                    <a href="{{ route('teacher.profile.show') }}" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
                    </form>
                </div>
            </div>    
    </header>

    <!-- ================= MAIN CONTENT ================= -->
    <main class="max-w-4xl mx-auto py-10 space-y-10">

        <!-- User Information Card -->
        <section class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">User Information</h2>
            <form action="{{ route('teacher.profile.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-semibold mb-1 text-gray-700">Name</label>
                    <input type="text" name="name" value="{{ auth()->user()->name }}" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
                </div>

                <div>
                    <label class="block font-semibold mb-1 text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ auth()->user()->email }}" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
                </div>

                <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-black font-bold px-5 py-2 rounded transition">Save</button>
            </form>
        </section>

        <!-- Password Update Card -->
        <section class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Update Password</h2>
            <form action="{{ route('teacher.profile.updatePassword') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-semibold mb-1 text-gray-700">Current Password</label>
                    <input type="password" name="current_password" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
                </div>

                <div>
                    <label class="block font-semibold mb-1 text-gray-700">New Password</label>
                    <input type="password" name="new_password" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
                </div>

                <div>
                    <label class="block font-semibold mb-1 text-gray-700">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
                </div>

                <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-black font-bold px-5 py-2 rounded transition">Save</button>
            </form>
        </section>

        <!-- Delete Account Card -->
        <section class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-4 text-red-600">Delete Account</h2>
            <form action="{{ route('teacher.profile.destroy') }}" method="POST" onsubmit="return confirm('Are you sure?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold px-5 py-2 rounded transition">Delete Account</button>
            </form>
        </section>

    </main>

    <script>
        // Dropdown toggle
        const dropdownButton = document.querySelector("header .group button");
        const dropdownMenu = document.querySelector("header .group div");
        dropdownButton.addEventListener('click', () => {
            dropdownMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
