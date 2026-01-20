<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnEase - Dashboard</title>
    <style>
        /* CSS Reset */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        body {
            font-family: system-ui, -apple-system, sans-serif;
            background-color: #f1f5f9; /* Light Slate Grey */
            display: flex;
            height: 100vh;
            overflow: hidden; 
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 260px;
            background-color: #1e293b; /* Dark Slate */
            color: white;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }
        
        .sidebar-header {
            height: 64px;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            font-size: 1.5rem;
            font-weight: 800;
            color: #3b82f6; /* LearnEase Blue */
            border-bottom: 1px solid #334155;
        }

        .nav-links {
            list-style: none;
            padding: 1rem 0;
            flex: 1;
        }

        .nav-links li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.85rem 1.5rem;
            color: #cbd5e1; /* Light Grey Text */
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
            border-left: 4px solid transparent;
        }

        .nav-links li a:hover, .nav-links li a.active {
            background-color: #334155;
            color: white;
            border-left-color: #3b82f6;
        }

        /* --- MAIN WRAPPER --- */
        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* --- TOP HEADER --- */
        .top-bar {
            height: 64px;
            background: white;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }

        .page-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #0f172a;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .user-name {
            font-weight: 500;
            color: #334155;
        }

        .avatar {
            width: 40px;
            height: 40px;
            background-color: #3b82f6;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* --- SCROLLABLE CONTENT AREA --- */
        .content-area {
            flex: 1;
            overflow-y: auto;
            padding: 2rem;
        }

        /* Announcement Board */
        .banner {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            padding: 2.5rem;
            border-radius: 16px;
            margin-bottom: 2.5rem;
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.2);
            position: relative;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }
        
        .stat-label { color: #64748b; font-size: 0.875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
        .stat-value { font-size: 2.5rem; font-weight: 700; color: #0f172a; margin-top: 0.5rem; }

        /* Course Grid */
        .section-header { margin-bottom: 1.5rem; }
        .section-title { font-size: 1.5rem; font-weight: 700; color: #0f172a; }
        
        .course-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .course-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }
        
        .course-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }

        .card-img {
            height: 140px;
            background-color: #cbd5e1;
            position: relative;
        }
        
        .badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(255,255,255,0.9);
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: bold;
            color: #0f172a;
        }

        .card-body { padding: 1.5rem; }
        .card-title { font-size: 1.125rem; font-weight: 700; margin-bottom: 0.5rem; color: #0f172a; }
        
        .progress-bar { height: 6px; background: #f1f5f9; border-radius: 3px; overflow: hidden; }
        .progress-fill { height: 100%; background: #3b82f6; border-radius: 3px; }

    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-header">LearnEase</div>
        
        <ul class="nav-links">
            <li><a href="{{ route('teacherView.dashboard') }}" class="active">Dashboard</a></li>
            <li><a href="{{ route('teacher.subjects') }}">Subjects</a></li>
            <li><a href="{{ route('module3.teacher.index') }}">Assignments</a></li>
            <li><a href="#">Schedule</a></li>
        </ul>
    </aside>

    <div class="main-wrapper">
        
        <header class="top-bar">
            <div class="page-title">Overview</div>
            
            <div class="user-menu">
                <span class="user-name">Teacher Name</span>
                <div class="avatar">S</div>
            </div>
        </header>

        <main class="content-area">
            
            <div class="banner">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                    <div>
                        <h1 style="margin:0; font-size: 2rem;">Announcements</h1>
                        <p style="opacity: 0.9;">Latest updates for students.</p>
                    </div>
                    
                    <button onclick="toggleForm()" style="background: white; color: #2563eb; border: none; padding: 10px 15px; border-radius: 6px; font-weight: bold; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        + Add New
                    </button>
                </div>

                <div id="addFormPanel" style="display: none; background: rgba(0,0,0,0.2); padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid rgba(255,255,255,0.3);">
                    <h4 style="margin-top: 0; margin-bottom: 10px; color: white;">New Announcement</h4>
                    
                    <form action="{{ route('announcement.store') }}" method="POST" onsubmit="return reviewAndSubmit(event)">
                        @csrf
                        
                        <input type="text" 
                               id="announcementInput"
                               name="content" 
                               placeholder="Type message (e.g., 'Exam tomorrow at 9 AM')..." 
                               required 
                               minlength="5" 
                               maxlength="200"
                               style="width: 100%; padding: 10px; border-radius: 4px; border: none; margin-bottom: 10px; color: #1e293b;">
                        
                        <div style="display: flex; gap: 10px;">
                            <button type="submit" style="background: #10b981; color: white; border: none; padding: 8px 15px; border-radius: 4px; font-weight: bold; cursor: pointer;">
                                Review & Post
                            </button>
                            
                            <button type="button" onclick="toggleForm()" style="background: transparent; color: white; border: 1px solid white; padding: 8px 15px; border-radius: 4px; cursor: pointer;">
                                Cancel
                            </button>
                        </div>
                        <small style="color: #e2e8f0; display: block; margin-top: 5px;">* Max 200 characters. No special symbols.</small>
                    </form>
                </div>

                <div class="announcement-list" style="display: flex; flex-direction: column; gap: 10px;">
                    @forelse($announcements as $announcement)
                        <div style="background: rgba(255,255,255,0.15); padding: 12px 15px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; border: 1px solid rgba(255,255,255,0.1);">
                            
                            <div>
                                <span style="font-weight: bold; font-size: 1.1rem;">📢</span>
                                <span style="margin-left: 8px; font-size: 1.05rem;">{{ $announcement->content }}</span>
                                <div style="font-size: 0.75rem; opacity: 0.7; margin-left: 32px; margin-top: 2px;">
                                    Posted: {{ $announcement->created_at->diffForHumans() }}
                                </div>
                            </div>

                            <form action="{{ route('announcement.delete', $announcement->id) }}" method="POST" onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: rgba(239, 68, 68, 0.8); color: white; border: none; padding: 6px 10px; border-radius: 4px; cursor: pointer; font-size: 0.8rem;" title="Delete Announcement">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @empty
                        <p style="opacity: 0.8; font-style: italic;">No announcements yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Current GPA</div>
                    <div class="stat-value">3.85</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Active Subjects</div>
                    <div class="stat-value">4</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Completed Credits</div>
                    <div class="stat-value">24</div>
                </div>
            </div>

            <div class="section-header">
                <div class="section-title">Current Subjects</div>
            </div>

            <div class="course-grid">
                <div class="course-card">
                    <div class="card-img" style="background: #3b82f6;">
                        <span class="badge">CS-101</span>
                    </div>
                    <div class="card-body">
                        <div class="card-title">Mathematic</div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 75%;"></div>
                        </div>
                    </div>
                </div>

                <div class="course-card">
                    <div class="card-img" style="background: #10b981;">
                        <span class="badge">MATH-200</span>
                    </div>
                    <div class="card-body">
                        <div class="card-title">English</div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 40%;"></div>
                        </div>
                    </div>
                </div>

                <div class="course-card">
                    <div class="card-img" style="background: #f59e0b;">
                        <span class="badge">ENG-105</span>
                    </div>
                    <div class="card-body">
                        <div class="card-title">Science</div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 90%;"></div>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <script>
        // Toggle the Add Form visibility
        function toggleForm() {
            var form = document.getElementById('addFormPanel');
            form.style.display = (form.style.display === 'none') ? 'block' : 'none';
        }

        // III. Notification Review Check
        function reviewAndSubmit(event) {
            var input = document.getElementById('announcementInput').value;
            
            // Basic Client-side Sanitation Check
            if (input.trim().length < 5) {
                alert("Message is too short.");
                return false;
            }

            // The Review Dialog
            var message = "⚠️ REVIEW BEFORE POSTING \n\n" +
                          "----------------------------\n" +
                          "CONTENT: \"" + input + "\"\n" +
                          "AUDIENCE: All Students\n" +
                          "----------------------------\n\n" +
                          "Is this information correct?";
            
            return confirm(message);
        }

        // I. Confirm before destructive design
        function confirmDelete() {
            var warning = "⚠️ CONFIRM DELETION \n\n" +
                          "Are you sure you want to remove this announcement?\n" +
                          "This action cannot be undone.";
            
            return confirm(warning);
        }
    </script>
</body>
</html>