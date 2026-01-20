<!DOCTYPE html>
<html>
<head>
    <title>Discussion - LearnEase</title>

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
            max-width: 900px;
            margin: 30px auto;
            padding: 0 20px;
        }

        /* ================= DISCUSSION ================= */
        .discussion-box {
            background: white;
            padding: 22px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.05);
        }

        .discussion-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .discussion-meta {
            font-size: 14px;
            color: #777;
            margin-top: 6px;
        }

        .divider {
            border-top: 1px solid #eee;
            margin: 12px 0;
        }

        /* ================= COMMENTS ================= */
        .comment-box {
            background: white;
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 14px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        .reply-box {
            margin-left: 40px;
            border-left: 3px solid {{ $navColor }};
            padding-left: 15px;
            margin-top: 12px;
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .comment-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .comment-author {
            font-weight: bold;
            font-size: 14px;
        }

        .badge {
            font-size: 12px;
            padding: 2px 8px;
            border-radius: 12px;
            color: white;
        }

        .badge-teacher { background: #475569; }
        .badge-student { background: #059669; }

        .time {
            font-size: 12px;
            color: #999;
        }

        .comment-text {
            color: #444;
            margin-top: 10px;
            line-height: 1.6;
        }

        /* ================= COMMENT ACTIONS ================= */
        .comment-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 6px;
        }

        .reply-btn {
            font-size: 14px;
            color: {{ $navColor }};
            font-weight: bold;
            cursor: pointer;
        }

        .reply-btn:hover {
            text-decoration: underline;
        }

        /* ================= THREE DOT MENU ================= */
        .options-menu {
            position: relative;
        }

        .options-btn {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: #999;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background: white;
            min-width: 100px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            border-radius: 6px;
            overflow: hidden;
            z-index: 100;
        }

        .dropdown-content a,
        .dropdown-content button {
            display: block;
            width: 100%;
            padding: 8px 12px;
            text-align: left;
            font-size: 14px;
            color: #333;
            background: none;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .dropdown-content a:hover,
        .dropdown-content button:hover {
            background: #f0f0f0;
        }

        /* ================= FORMS ================= */
        .comment-form {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            margin-bottom: 20px;
        }

        .comment-form input {
            flex: 1;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .btn-send {
            background: {{ $navColor }};
            border: none;
            color: white;
            padding: 10px 16px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-send:hover {
            opacity: 0.9;
        }

        .reply-form {
            display: none;
            margin-top: 10px;
        }

        .btn-back {
            margin-top: 20px;
            display: inline-block;
            color: {{ $navColor }};
            font-weight: bold;
            text-decoration: none;
        }

        .btn-back:hover {
            text-decoration: underline;
        }
    </style>

    <script>
        function toggleReply(id) {
            const el = document.getElementById(id);
            el.style.display = el.style.display === 'block' ? 'none' : 'block';
        }

        function toggleDropdown(id) {
            const el = document.getElementById(id);
            el.style.display = el.style.display === 'block' ? 'none' : 'block';
        }

        function toggleUserMenu() {
            document.getElementById('userMenu').classList.toggle('show');
        }

        window.onclick = function(event) {
            if (!event.target.closest('.options-menu') &&
                !event.target.closest('.user-dropdown')) {
                document.querySelectorAll('.dropdown-content')
                    .forEach(el => el.style.display = 'none');
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

    <!-- Discussion -->
    <div class="discussion-box">
        <div class="discussion-header">
            <h2>{{ $discussion->title }}</h2>

            @if(auth()->id() === $discussion->user_id)
            <div class="options-menu">
                <button class="options-btn" onclick="toggleDropdown('discussion-menu')">⋮</button>
                <div class="dropdown-content" id="discussion-menu">
                    <a href="{{ route('discussions.edit', $discussion->id) }}">Edit</a>
                    <form method="POST" action="{{ route('discussions.destroy', $discussion->id) }}" onsubmit="return confirm('Delete this discussion?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <div class="discussion-meta">
            Posted by <b>{{ $discussion->user->name }}</b> ·
            {{ $discussion->created_at->diffForHumans() }}
        </div>

        <div class="divider"></div>

        <p>{{ $discussion->content }}</p>
    </div>

    <h3>Comments</h3>

    <!-- New comment form -->
    <form method="POST"
          action="{{ route('comments.store', $discussion->id) }}"
          class="comment-form">
        @csrf
        <input type="text" name="comment" placeholder="Write a comment..." required>
        <button class="btn-send">Send</button>
    </form>

    @foreach($discussion->comments->whereNull('parent_id') as $comment)
        <div class="comment-box">
            <div class="comment-header">
                <div class="comment-left">
                    <span class="comment-author">{{ $comment->user->name }}</span>
                    <span class="badge {{ $comment->user->role === 'teacher'
                        ? 'badge-teacher'
                        : 'badge-student' }}">
                        {{ ucfirst($comment->user->role) }}
                    </span>
                    <span class="time">{{ $comment->created_at->diffForHumans() }}</span>
                </div>

                @if(auth()->id() === $comment->user_id)
                <div class="options-menu">
                    <button class="options-btn" onclick="toggleDropdown('comment-{{ $comment->id }}')">⋮</button>
                    <div class="dropdown-content" id="comment-{{ $comment->id }}">
                        <a href="{{ route('comments.edit', $comment->id) }}">Edit</a>
                        <form method="POST" action="{{ route('comments.destroy', $comment->id) }}" onsubmit="return confirm('Delete this comment?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </div>
                </div>
                @endif
            </div>

            <div class="divider"></div>

            <div class="comment-text">{{ $comment->comment }}</div>

            <div class="comment-actions">
                <span class="reply-btn"
                      onclick="toggleReply('reply-{{ $comment->id }}')">
                    Reply
                </span>
            </div>

            <form method="POST"
                  action="{{ route('comments.store', $discussion->id) }}"
                  id="reply-{{ $comment->id }}"
                  class="comment-form reply-form">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                <input type="text" name="comment" placeholder="Write a reply..." required>
                <button class="btn-send">Send</button>
            </form>

            @foreach($comment->replies as $reply)
                <div class="comment-box reply-box">
                    <div class="comment-header">
                        <div class="comment-left">
                            <span class="comment-author">{{ $reply->user->name }}</span>
                            <span class="badge {{ $reply->user->role === 'teacher'
                                ? 'badge-teacher'
                                : 'badge-student' }}">
                                {{ ucfirst($reply->user->role) }}
                            </span>
                            <span class="time">{{ $reply->created_at->diffForHumans() }}</span>
                        </div>

                        @if(auth()->id() === $reply->user_id)
                        <div class="options-menu">
                            <button class="options-btn" onclick="toggleDropdown('reply-{{ $reply->id }}')">⋮</button>
                            <div class="dropdown-content" id="reply-{{ $reply->id }}">
                                <a href="{{ route('comments.edit', $reply->id) }}">Edit</a>
                                <form method="POST" action="{{ route('comments.destroy', $reply->id) }}" onsubmit="return confirm('Delete this reply?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Delete</button>
                                </form>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="divider"></div>
                    <div class="comment-text">{{ $reply->comment }}</div>
                </div>
            @endforeach
        </div>
    @endforeach

    <a href="{{ route('discussions.index') }}" class="btn-back">
        ← Back to Discussions
    </a>

</div>

</body>
</html>
