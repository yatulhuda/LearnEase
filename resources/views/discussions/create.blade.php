<!DOCTYPE html>
<html>
<head>
    <title>Add Discussion - LearnEase</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        /* ===== Header / Top Nav (Same as previous page) ===== */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 40px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            position: relative;
            color: white;
        }

        .header .title {
            font-size: 22px;
            font-weight: 700;
        }

        .nav-links {
            display: flex;
            gap: 25px;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .nav-links a {
            color: white;
            font-weight: 600;
            text-decoration: none;
        }

        .user-dropdown {
            position: relative;
        }

        .user-btn {
            background: none;
            border: none;
            color: white;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            margin-top: 10px;
            background: white;
            color: black;
            border-radius: 6px;
            overflow: hidden;
            min-width: 140px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            z-index: 100;
        }

        .dropdown-menu a,
        .dropdown-menu button {
            display: block;
            width: 100%;
            padding: 10px 15px;
            color: #333;
            text-decoration: none;
            background: none;
            border: none;
            text-align: left;
            cursor: pointer;
        }

        .dropdown-menu a:hover,
        .dropdown-menu button:hover {
            background: #f0f0f0;
        }

        /* ===== Container ===== */
        .container {
            max-width: 900px;
            margin: 35px auto;
            padding: 0 20px;
        }

        /* ===== Card ===== */
        .card {
            background: white;
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.06);
            border-left: 6px solid
                {{ auth()->user()->role === 'teacher' ? '#1e293b' : '#064e3b' }};
        }

        .card h3 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #222;
        }

        label {
            font-weight: 600;
            display: block;
            margin-top: 15px;
            margin-bottom: 6px;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color:
                {{ auth()->user()->role === 'teacher' ? '#1e293b' : '#064e3b' }};
        }

        /* ===== Buttons ===== */
        .btn-group {
            margin-top: 25px;
            display: flex;
            gap: 12px;
        }

        .btn-save {
            background:
                {{ auth()->user()->role === 'teacher' ? '#1e293b' : '#064e3b' }};
            color: white;
            padding: 10px 22px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 600;
        }

        .btn-save:hover {
            opacity: 0.9;
        }

        .btn-cancel {
            background: #eee;
            color: #333;
            padding: 10px 22px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            border: 1px solid #ccc;
        }

        .btn-cancel:hover {
            background: #ddd;
        }

        /* Errors */
        .error {
            color: #d9534f;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .error-list {
            color: #d9534f;
            margin-bottom: 15px;
        }
    </style>

    <script>
        function toggleDropdown(id) {
            const menu = document.getElementById(id);
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }

        window.onclick = function(event) {
            if (!event.target.matches('.user-btn')) {
                const dropdowns = document.getElementsByClassName('dropdown-menu');
                for (let i = 0; i < dropdowns.length; i++) {
                    dropdowns[i].style.display = 'none';
                }
            }
        }
    </script>
</head>
<body>

{{-- ===== Header ===== --}}
<div class="header"
     style="background: {{ auth()->user()->role === 'teacher' ? '#1e293b' : '#064e3b' }};">
    <div class="title">LearnEase</div>

    <div class="nav-links">
        <a href="{{ auth()->user()->role === 'teacher' ? route('dashboards.hometeacher') : route('dashboards.homestudent') }}">Dashboard</a>
        <a href="#">Assignments</a>
        <a href="#">Quizzes</a>
        <a href="{{ auth()->user()->role === 'teacher' ? route('teacherView.dashboard') : route('studView.dashboardStud') }}">Subjects</a>
        <a href="{{ route('discussions.index') }}">Discussion</a>
    </div>

    <div class="user-dropdown">
        <button class="user-btn" onclick="toggleDropdown('user-menu')">
            {{ auth()->user()->name }} &#9662;
        </button>
        <div class="dropdown-menu" id="user-menu">
            <a href="{{ auth()->user()->role === 'teacher' ? route('teacher.profile.show') : route('student.profile.show') }}">Profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
</div>

{{-- ===== Content ===== --}}
<div class="container">
    <div class="card">
        <h3>Start a New Discussion</h3>

        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <ul class="error-list">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('discussions.store') }}">
            @csrf

            <label>Title</label>
            <input type="text" name="title" value="{{ old('title') }}" required>

            <label>Description / Question</label>
            <textarea name="content" rows="5" required>{{ old('content') }}</textarea>

            <div class="btn-group">
                <button type="submit" class="btn-save">Add Discussion</button>
                <a href="{{ route('discussions.index') }}" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
