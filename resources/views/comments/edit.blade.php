<!DOCTYPE html>
<html>
<head>
    <title>Edit Comment - LearnEase</title>

    @php
        $role = auth()->user()->role;
        $navColor = $role === 'teacher' ? '#1e293b' : '#064e3b';
    @endphp

    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: #f5f7fa; 
            margin: 0; 
        }

        /* ================= NAVBAR ================= */
        .navbar {
            background: {{ $navColor }};
            height: 64px;
            display: flex;
            align-items: center;
            padding: 0 40px;
            position: relative;
            color: white;
            box-shadow: 0 3px 10px rgba(0,0,0,0.15);
        }

        .brand {
            position: absolute;
            left: 40px;
            font-size: 22px;
            font-weight: bold;
        }

        .nav-links {
            margin: 0 auto;
            display: flex;
            gap: 28px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
        }

        .nav-links a:hover {
            text-decoration: underline;
        }

        /* ================= USER DROPDOWN ================= */
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

        /* ================= CONTAINER ================= */
        .container { 
            max-width: 700px; 
            margin: 40px auto; 
            padding: 25px 40px 25px 30px; 
            background: white; 
            border-radius: 12px; 
            box-shadow: 0 3px 12px rgba(0,0,0,0.05);
        }

        label {
            font-weight: bold;
            margin-bottom: 6px;
            display: block;
        }

        textarea { 
            width: 100%; 
            padding: 12px; 
            margin-top: 6px; 
            border-radius: 8px; 
            border: 1px solid #ccc; 
            font-size: 14px;
        }

        .form-actions {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        .btn-save { 
            background: {{ $navColor }}; 
            color: white; 
            padding: 10px 20px; 
            border-radius: 6px; 
            border: none; 
            cursor: pointer; 
            font-weight: bold;
            transition: 0.2s;
        }
        .btn-save:hover { opacity: 0.9; }

        .btn-cancel { 
            background: #dc3545; 
            color: white; 
            padding: 10px 20px; 
            border-radius: 6px; 
            text-decoration: none; 
            font-weight: bold;
            transition: 0.2s;
        }
        .btn-cancel:hover { background: #c82333; }

        /* Messages */
        .error-message { color: #dc3545; font-weight: bold; margin-bottom: 15px; }
        .success-message { color: green; font-weight: bold; margin-bottom: 15px; }
    </style>

    <script>
        function toggleUserMenu() {
            document.getElementById('userMenu').classList.toggle('show');
        }

        window.onclick = function(event) {
            if (!event.target.closest('.user-dropdown')) {
                document.getElementById('userMenu')?.classList.remove('show');
            }
        }
    </script>
</head>
<body>

<!-- ================= NAVBAR ================= -->
<div class="navbar">
    <div class="brand">LearnEase</div>

    <div class="nav-links">
        <a href="{{ $role === 'teacher'
            ? route('dashboards.hometeacher')
            : route('dashboards.homestudent') }}">Dashboard</a>
        <a href="#">Assignments</a>
        <a href="#">Quizzes</a>
        <a href="#">Subjects</a>
        <a href="{{ route('discussions.index') }}">Discussion</a>
    </div>

    <div class="user-dropdown">
        <button class="user-btn" onclick="toggleUserMenu()">
            {{ auth()->user()->name }} ▾
        </button>

        <div class="dropdown-menu" id="userMenu">
            <a href="{{ $role === 'teacher'
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

<!-- ================= CONTENT ================= -->
<div class="container">

    {{-- Display validation errors --}}
    @if ($errors->any())
        <div class="error-message">
            <ul style="margin:0; padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Display success message --}}
    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('comments.update', $comment->id) }}">
        @csrf
        @method('PUT')

        <label>Comment</label>
        <textarea name="comment" rows="5" required>{{ old('comment', $comment->comment) }}</textarea>

        <div class="form-actions">
            <button type="submit" class="btn-save">Save Changes</button>
            <a href="{{ route('discussions.show', $comment->discussion_id) }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>

</body>
</html>
