<!DOCTYPE html>
<html>
<head>
    <title>Edit Discussion - LearnEase</title>

    @php
        $role = auth()->user()->role; // 'student' or 'teacher'
        $navColor = $role === 'teacher' ? '#1e293b' : '#064e3b';
    @endphp

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            margin: 0;
        }

        /* Top Navigation */
        .navbar {
            background: {{ $navColor }};
            color: white;
            height: 64px;
            display: flex;
            align-items: center;
            position: relative;
            padding: 0 40px;
        }

        /* Left */
        .brand {
            position: absolute;
            left: 40px;
            font-size: 22px;
            font-weight: bold;
        }

        /* Center */
        .nav-links {
            margin: 0 auto;
            display: flex;
            gap: 25px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
        }

        .nav-links a:hover {
            text-decoration: underline;
        }

        /* Container */
        .container {
            max-width: 800px;
            margin: 35px auto;
            padding: 0 20px;
        }

        /* Card */
        .card {
            background: white;
            padding: 30px 45px 30px 30px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.05);
            border-left: 6px solid {{ $navColor }};
        }

        h3 {
            margin-top: 0;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: {{ $navColor }};
        }

        .btn-group {
            margin-top: 25px;
            display: flex;
            gap: 10px;
        }

        .btn-save {
            background: {{ $navColor }};
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            border: none;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-save:hover {
            opacity: 0.9;
        }

        .btn-cancel {
            background: #eee;
            color: #333;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            border: 1px solid #ccc;
            font-weight: bold;
        }

        .error {
            color: #dc3545;
            font-weight: bold;
            margin-bottom: 15px;
        }

        /* Right */
        .user-dropdown {
            position: absolute;
            right: 40px;
        }

        .user-btn {
            background: none;
            border: none;
            color: white;
            font-weight: 600;
            cursor: pointer;
            font-size: 15px;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            margin-top: 10px;
            background: white;
            color: black;
            border-radius: 6px;
            min-width: 140px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            overflow: hidden;
            z-index: 100;
        }

        .dropdown-menu a,
        .dropdown-menu button {
            display: block;
            width: 100%;
            padding: 10px 14px;
            background: none;
            border: none;
            text-align: left;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            color: #333;
        }

        .dropdown-menu a:hover,
        .dropdown-menu button:hover {
            background: #f0f0f0;
        }

        .dropdown-menu.show {
            display: block;
        }
    </style>
</head>
<body>

<!-- Top Navigation -->
<div class="navbar">

    <!-- LEFT -->
    <div class="brand">LearnEase</div>

    <!-- CENTER -->
    <div class="nav-links">
        <a href="{{ auth()->user()->role === 'teacher'
            ? route('dashboards.hometeacher')
            : route('dashboards.homestudent') }}">Dashboard</a>
        <a href="#">Assignments</a>
        <a href="#">Quizzes</a>
        <a href="{{ auth()->user()->role === 'teacher'
            ? route('teacherView.dashboard')
            : route('studView.dashboardStud') }}">Subjects</a>
        <a href="#">Discussion</a>
    </div>

    <!-- RIGHT -->
    <div class="user-dropdown">
        <button class="user-btn" onclick="toggleUserMenu()">
            {{ auth()->user()->name }} ▾
        </button>

        <div class="dropdown-menu" id="userMenu">
            <a href="{{ auth()->user()->role === 'teacher'
                ? route('teacher.profile.show')
                : route('student.profile.show') }}">
                Profile
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>

</div>

<!-- Main Content -->
<div class="container">
    <div class="card">
        <h3>Edit Discussion</h3>

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('discussions.update', $discussion->id) }}">
            @csrf
            @method('PUT')

            <label>Title</label>
            <input type="text" name="title"
                   value="{{ old('title', $discussion->title) }}" required>

            <label>Description / Question</label>
            <textarea name="content" rows="5" required>{{ old('content', $discussion->content) }}</textarea>

            <div class="btn-group">
                <button type="submit" class="btn-save">Save Changes</button>
                <a href="{{ route('discussions.index') }}" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleUserMenu() {
        document.getElementById('userMenu').classList.toggle('show');
    }

    window.addEventListener('click', function (e) {
        if (!e.target.closest('.user-dropdown')) {
            document.getElementById('userMenu').classList.remove('show');
        }
    });
</script>

</body>
</html>
