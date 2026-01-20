<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Subjects</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: system-ui, -apple-system, sans-serif;
            background-color: #f0fdf4; 
            display: flex;
            height: 100vh;
        }

        /* --- GREEN SIDEBAR --- */
        .sidebar {
            width: 260px;
            background-color: #064e3b; 
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
            color: #34d399;
            border-bottom: 1px solid #065f46;
        }
        .nav-links { list-style: none; padding: 1rem 0; flex: 1; }
        .nav-links li a {
            display: flex; align-items: center; gap: 12px;
            padding: 0.85rem 1.5rem; color: #d1fae5;
            text-decoration: none; font-weight: 500;
            border-left: 4px solid transparent;
        }
        .nav-links li a:hover, .nav-links li a.active {
            background-color: #065f46; 
            color: white; 
            border-left-color: #34d399;
        }

        /* MAIN CONTENT */
        .main-wrapper { flex: 1; display: flex; flex-direction: column; }
        .top-bar {
            height: 64px; background: white; border-bottom: 1px solid #e2e8f0;
            display: flex; justify-content: space-between; align-items: center; padding: 0 2rem;
        }
        .content-area { padding: 2rem; overflow-y: auto; }
        .page-title { font-size: 1.25rem; font-weight: 600; color: #0f172a; }

        /* SUBJECTS GRID */
        .subject-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        .subject-card {
            background: white; border-radius: 12px; overflow: hidden;
            border: 1px solid #e2e8f0; transition: transform 0.2s;
        }
        .subject-card:hover { transform: translateY(-4px); }
        .card-header { height: 100px; position: relative; }
        .badge {
            position: absolute; top: 1rem; right: 1rem;
            background: rgba(255,255,255,0.95); padding: 4px 8px;
            border-radius: 6px; font-size: 0.75rem; font-weight: bold; color: #0f172a;
        }
        .card-body { padding: 1.5rem; }
        .card-title { font-size: 1.25rem; font-weight: 700; color: #0f172a; margin-bottom: 0.5rem; }
        .btn-view {
            display: block; width: 100%; text-align: center;
            background-color: #f0fdf4; color: #059669;
            padding: 0.75rem; border-radius: 8px; text-decoration: none;
            font-weight: 600; margin-top: 1rem; border: 1px solid #bbf7d0;
        }
        .btn-view:hover { background-color: #10b981; color: white; }

    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-header">LearnEase</div>
        <ul class="nav-links">
            <li><a href="{{ route('studView.dashboardStud') }}">Dashboard</a></li>
            <li><a href="{{ route('student.subjects') }}" class="active">Subjects</a></li>
            <li><a href="{{ route('module3.student.index') }}">Assignments</a></li>
            <li><a href="{{ route('module3.student.allquiz') }}">Gradebook</a></li>
            <li><a href="#">Schedule</a></li>
        </ul>
    </aside>

    <div class="main-wrapper">
        <header class="top-bar">
            <div class="page-title">Enrolled Subjects</div>
            <div style="font-weight: bold; color: #059669;">Student Portal</div>
        </header>

        <main class="content-area">
            <h2>My Courses</h2>
            
            <div class="subject-grid">
                @foreach($subjects as $subject)
                <div class="subject-card">
                    <div class="card-header" style="background-color: {{ $subject['color'] }};">
                        <span class="badge">{{ $subject['id'] }}</span>
                    </div>
                    <div class="card-body">
                        <div class="card-title">{{ $subject['name'] }}</div>
                        <p style="color: #64748b;">Fall Semester 2025</p>
                        
                        @if($subject['id'] == 'MATH-101')
                            <a href="{{ route('student.mathematics') }}" class="btn-view">Enter Class</a>
                        @else
                            <a href="#" class="btn-view">Enter Class</a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </main>
    </div>
</body>
</html>