<!DOCTYPE html>
<html>
<head>
    <title>Discussion Forum - LearnEase</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        /* Header / Top Nav */
        .header {
            display: flex;
            justify-content: space-between; /* left, center, right */
            align-items: center;
            padding: 15px 40px;
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

        /* Triple-dot options */
        .options-menu {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 50;
        }

        .options-menu button {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #333;
            padding: 4px 6px;
            border-radius: 4px;
            transition: background 0.2s;
        }

        .options-menu button:hover {
            background: rgba(0,0,0,0.05);
        }

        /* Dropdown content */
        .dropdown-content {
            display: none;
            position: absolute;
            top: 28px; /* below button */
            right: 0;
            background: white;
            min-width: 120px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            border-radius: 6px;
            overflow: hidden;
            z-index: 100;
        }

        .dropdown-content a,
        .dropdown-content button {
            display: block;
            width: 100%;
            padding: 10px 12px;
            font-size: 14px;
            text-decoration: none;
            color: #333;
            background: none;
            border: none;
            text-align: left;
            cursor: pointer;
        }

        .dropdown-content a:hover,
        .dropdown-content button:hover {
            background: #f0f0f0;
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

        .dropdown-menu a, .dropdown-menu button {
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

        .dropdown-menu a:hover, .dropdown-menu button:hover {
            background: #f0f0f0;
        }

        /* Container & discussions */
        .container {
            max-width: 900px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .add-box {
            background: white;
            padding: 18px 22px;
            border-radius: 14px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 6px solid currentColor;
        }

        .btn-add { font-weight: 700; text-decoration: none; color: inherit; }

        .discussion-box {
            background: white;
            padding: 22px;
            border-radius: 16px;
            margin-bottom: 18px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.06);
            position: relative;
        }

        .discussion-title { font-size: 19px; font-weight: 700; color: #222; margin-bottom: 8px; }
        .discussion-separator { border-top: 1px solid #eee; margin: 12px 0; }
        .discussion-content { color: #444; margin-bottom: 12px; line-height: 1.6; }
        .discussion-meta { font-size: 14px; color: #555; margin-bottom: 12px; }
        .discussion-meta span { margin-right: 10px; }
        .btn-comment { font-weight: 600; text-decoration: underline; font-size: 14px; cursor: pointer; float: right; }
        .success-message { color: green; font-weight: bold; margin-bottom: 15px; }
        .error-message { color: red; font-weight: bold; margin-bottom: 15px; }
        .clearfix::after { content: ""; clear: both; display: table; }
    </style>
    <script>
        function toggleDropdown(id) {
            const menu = document.getElementById(id);
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }

        window.onclick = function(event) {
            if (!event.target.matches('.options-menu button')) {
                const dropdowns = document.getElementsByClassName('dropdown-content');
                for (let i = 0; i < dropdowns.length; i++) dropdowns[i].style.display = 'none';
            }
        }
    </script>
</head>
<body>

{{-- Header / Top Nav --}}
<div class="header" style="background: {{ auth()->user()->role === 'teacher' ? '#1e293b' : '#064e3b' }};">
    <!-- Left: LearnEase -->
    <div class="title">LearnEase</div>

    <!-- Center: Navigation links -->
    <div class="nav-links">
        <a href="{{ auth()->user()->role === 'teacher' ? route('dashboards.hometeacher') : route('dashboards.homestudent') }}">Dashboard</a>
        <a href="{{ auth()->user()->role === 'teacher' ? route('teacher.subjects') : route('student.subjects') }}">Assignments</a>
        <a href="{{ auth()->user()->role === 'teacher' ? route('module3.teacher.index') : route('module3.student.index') }}">Quizzes</a>
        <a href="{{ auth()->user()->role === 'teacher' ? route('teacherView.dashboard') : route('studView.dashboardStud') }}">Subjects</a>
        <a href="#">Discussion</a>
    </div>

    <!-- Right: User Dropdown -->
    <div class="user-dropdown">
        <button class="user-btn" onclick="toggleDropdown('user-menu')">
            {{ auth()->user()->name }} &#9662; <!-- Down arrow icon -->
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

{{-- Container --}}
<div class="container">
    {{-- Messages --}}
    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="error-message">{{ session('error') }}</div>
    @endif

    {{-- Add Discussion --}}
    <div class="add-box" style="color: {{ auth()->user()->role === 'teacher' ? '#1e293b' : '#064e3b' }};">
        <h3>Start a Discussion</h3>
        <a href="{{ route('discussions.create') }}" class="btn-add">+ New Discussion</a>
    </div>

    {{-- Discussion List --}}
    @foreach ($discussions as $discussion)
        <div class="discussion-box clearfix">
            @if(auth()->id() === $discussion->user_id)
            <div class="options-menu">
                <button onclick="toggleDropdown('dropdown-{{ $discussion->id }}')">⋮</button>
                <div class="dropdown-content" id="dropdown-{{ $discussion->id }}">
                    <a href="{{ route('discussions.edit', $discussion->id) }}">Edit</a>
                    <form action="{{ route('discussions.destroy', $discussion->id) }}" method="POST" onsubmit="return confirm('Delete this discussion?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </div>
            </div>
            @endif

            <div class="discussion-title">{{ $discussion->title }}</div>
            <div class="discussion-separator"></div>
            <div class="discussion-content">{{ $discussion->content }}</div>
            <div class="discussion-meta">
                <span>Posted by {{ $discussion->user->name ?? 'Unknown' }}</span>
                <span>{{ $discussion->created_at->diffForHumans() }}</span>
                <span>💬 {{ $discussion->comments_count }}</span>
            </div>
            <a href="{{ route('discussions.show', $discussion->id) }}" class="btn-comment">💬 Comment</a>
        </div>
    @endforeach

    {{-- Pagination --}}
    {{ $discussions->links() }}
</div>

</body>
</html>
