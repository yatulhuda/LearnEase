<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EZGrade - Dashboard</title>
    <style>
        /* CSS Reset */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        body {
            font-family: system-ui, -apple-system, sans-serif;
            background-color: #f1f5f9; /* Light Slate Grey */
            display: flex;
            height: 100vh;
            overflow: hidden; /* Prevent double scrollbars */
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 260px;
            background-color: #1e293b; /* Dark Slate */
            color: white;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            transition: width 0.3s;
        }
        
        .sidebar-header {
            height: 64px; /* Matches top-bar height */
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            font-size: 1.5rem;
            font-weight: 800;
            color: #3b82f6; /* EZGrade Blue */
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
            gap: 10px;
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

        .logout-section {
            padding: 1.5rem;
            border-top: 1px solid #334155;
        }
        
        .logout-btn {
            background: none;
            border: none;
            color: #ef4444; /* Red */
            font-weight: bold;
            cursor: pointer;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
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
            overflow-y: auto; /* Only this part scrolls */
            padding: 2rem;
        }

        /* Welcome Banner */
        .banner {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            padding: 2.5rem;
            border-radius: 16px;
            margin-bottom: 2.5rem;
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.2);
        }
        .banner h1 { margin-bottom: 0.5rem; font-size: 2rem; }
        .banner p { opacity: 0.9; font-size: 1.1rem; }

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
        .section-header { margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: flex-end; }
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
        .card-prof { font-size: 0.9rem; color: #64748b; margin-bottom: 1rem; }
        
        .progress-bar { height: 6px; background: #f1f5f9; border-radius: 3px; overflow: hidden; }
        .progress-fill { height: 100%; background: #3b82f6; border-radius: 3px; }

    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-header">EZGrade</div>
        
        <ul class="nav-links">
            <li><a href="#" class="active">Dashboard</a></li>
            <li><a href="#">My Courses</a></li>
            <li><a href="#">Assignments</a></li>
            <li><a href="#">Gradebook</a></li>
            <li><a href="#">Schedule</a></li>
        </ul>

        <div class="logout-section">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <span>Log Out</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="main-wrapper">
        
        <header class="top-bar">
            <div class="page-title">Overview</div>
            
            <div class="user-menu">
                <span class="user-name">{{ Auth::user()->name ?? 'Guest User' }}</span>
                <div class="avatar">
                    {{ substr(Auth::user()->name ?? 'G', 0, 1) }}
                </div>
            </div>
        </header>

        <main class="content-area">
            
            <div class="banner">
                <h1>Welcome Back, {{ Auth::user()->name ?? 'Student' }}!</h1>
                <p>You have 3 assignments due this week and 1 new announcement.</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Current GPA</div>
                    <div class="stat-value">3.85</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Active Courses</div>
                    <div class="stat-value">4</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Completed Credits</div>
                    <div class="stat-value">24</div>
                </div>
            </div>

            <div class="section-header">
                <div class="section-title">Current Courses</div>
            </div>

            <div class="course-grid">
                <div class="course-card">
                    <div class="card-img" style="background: #3b82f6;">
                        <span class="badge">CS-101</span>
                    </div>
                    <div class="card-body">
                        <div class="card-title">Software Engineering</div>
                        <div class="card-prof">Dr. Alan Smith</div>
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
                        <div class="card-title">Linear Algebra</div>
                        <div class="card-prof">Prof. Sarah Johnson</div>
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
                        <div class="card-title">Technical Writing</div>
                        <div class="card-prof">Dr. Emily Davis</div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 90%;"></div>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>

</body>
</html>