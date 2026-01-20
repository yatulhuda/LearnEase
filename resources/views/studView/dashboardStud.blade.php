<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
        /* CSS Reset */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        body {
            font-family: system-ui, -apple-system, sans-serif;
            background-color: #f0fdf4; /* Very Light Green Tint Background */
            display: flex;
            height: 100vh;
            overflow: hidden; 
        }

        /* --- GREEN SIDEBAR (Student Theme) --- */
        .sidebar {
            width: 260px;
            background-color: #064e3b; /* Deep Emerald Green */
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
            color: #34d399; /* Light Green Text */
            border-bottom: 1px solid #065f46;
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
            color: #d1fae5; /* Light Green-White Text */
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
            border-left: 4px solid transparent;
        }

        /* Hover & Active States for Green Sidebar */
        .nav-links li a:hover, .nav-links li a.active {
            background-color: #065f46; /* Lighter Green Highlight */
            color: white;
            border-left-color: #34d399; /* Bright Green Border */
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
            background-color: #10b981; /* Green Avatar */
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* --- CONTENT AREA --- */
        .content-area {
            flex: 1;
            overflow-y: auto;
            padding: 2rem;
        }

        .banner {
            background: linear-gradient(135deg, #059669 0%, #047857 100%); /* Green Gradient Banner */
            color: white;
            padding: 2.5rem;
            border-radius: 16px;
            margin-bottom: 2.5rem;
            box-shadow: 0 10px 15px -3px rgba(5, 150, 105, 0.2);
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
        .progress-fill { height: 100%; background: #10b981; border-radius: 3px; } /* Green Progress */

    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-header">LearnEase</div>
        
        <ul class="nav-links">
            <li><a href="{{ route('dashboards.homestudent') }}" class="active">Dashboard</a></li>
            <li><a href="{{ route('student.subjects') }}">Subjects</a></li>
            <li><a href="{{ route('module3.student.index') }}">Assignments</a></li>
            <li><a href="{{ route('module3.student.allquiz') }}">Gradebook</a></li>
        </ul>
    </aside>

    <div class="main-wrapper">
        <header class="top-bar">
            <div class="page-title">Student Overview</div>
            <div class="user-menu">
                <span class="user-name">Student Name</span>
                <div class="avatar">S</div>
            </div>
        </header>

        <main class="content-area">
            
            <div class="banner">
                <h1 style="margin:0; font-size: 2rem;">Welcome Back!</h1>
                <p style="opacity: 0.9;">You have upcoming assignments this week.</p>
                
                <div style="margin-top: 20px; background: rgba(0,0,0,0.2); padding: 15px; border-radius: 8px;">
                    <h3 style="margin-top: 0; font-size: 1.1rem;">📢 Latest Announcement</h3>
                    @if(isset($announcements) && $announcements->count() > 0)
                        <p style="margin-bottom: 0;">{{ $announcements->first()->content }}</p>
                    @else
                        <p style="margin-bottom: 0; opacity: 0.8;">No new announcements.</p>
                    @endif
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Current GPA</div>
                    <div class="stat-value">3.85</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Assignments Due</div>
                    <div class="stat-value" style="color: #ef4444;">2</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Credits Earned</div>
                    <div class="stat-value">24</div>
                </div>
            </div>

            <div class="section-header">
                <div class="section-title">My Courses</div>
            </div>

            <div class="course-grid">
                <div class="course-card" onclick="window.location='{{ route('student.subjects') }}'">
                    <div class="card-img" style="background: #3b82f6;">
                        <span class="badge">MATH-101</span>
                    </div>
                    <div class="card-body">
                        <div class="card-title">Mathematics</div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 75%;"></div>
                        </div>
                    </div>
                </div>
                
                <div class="course-card">
                    <div class="card-img" style="background: #10b981;">
                        <span class="badge">SCI-202</span>
                    </div>
                    <div class="card-body">
                        <div class="card-title">Science</div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 40%;"></div>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>
</body>
</html>