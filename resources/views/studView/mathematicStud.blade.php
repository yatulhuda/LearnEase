<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mathematics - Student View</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: system-ui, -apple-system, sans-serif; background-color: #f0fdf4; display: flex; height: 100vh; }
        
        /* --- GREEN SIDEBAR --- */
        .sidebar { width: 260px; background-color: #064e3b; color: white; display: flex; flex-direction: column; flex-shrink: 0; }
        .sidebar-header { height: 64px; display: flex; align-items: center; padding: 0 1.5rem; font-size: 1.5rem; font-weight: 800; color: #34d399; border-bottom: 1px solid #065f46; }
        .nav-links { list-style: none; padding: 1rem 0; flex: 1; }
        .nav-links li a { display: flex; align-items: center; gap: 12px; padding: 0.85rem 1.5rem; color: #d1fae5; text-decoration: none; font-weight: 500; border-left: 4px solid transparent; }
        .nav-links li a:hover, .nav-links li a.active { background-color: #065f46; color: white; border-left-color: #34d399; }
        
        .main-wrapper { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
        .top-bar { height: 64px; background: white; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; padding: 0 2rem; }
        .content-area { flex: 1; overflow-y: auto; padding: 2rem; }

        .course-header-card {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white; padding: 2rem; border-radius: 12px; margin-bottom: 2rem;
            display: flex; justify-content: space-between; align-items: center;
        }

        .week-section { margin-bottom: 2.5rem; }
        .week-title { 
            font-size: 1.25rem; font-weight: 700; color: #064e3b; 
            margin-bottom: 1rem; border-bottom: 2px solid #bbf7d0; padding-bottom: 0.5rem;
        }

        .material-card {
            background: white; border: 1px solid #e2e8f0; border-radius: 8px;
            padding: 1.5rem; margin-bottom: 1rem; 
            display: flex; align-items: flex-start; gap: 1rem;
            transition: all 0.2s;
        }
        .material-card:hover { box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); transform: translateY(-2px); }
        
        .file-icon {
            width: 48px; height: 48px; background: #ecfdf5; color: #059669;
            border-radius: 8px; display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; flex-shrink: 0;
        }
        
        .material-info h4 { margin: 0 0 0.5rem 0; font-size: 1.1rem; color: #059669; }
        .btn-download {
            text-decoration: none; font-size: 0.85rem; font-weight: bold;
            color: #059669; border: 1px solid #059669; padding: 5px 12px;
            border-radius: 4px; transition: 0.2s;
        }
        .btn-download:hover { background: #059669; color: white; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-header">LearnEase</div>
        <ul class="nav-links">
            <li><a href="{{ route('studView.dashboardStud') }}">Dashboard</a></li>
            <li><a href="{{ route('student.subjects') }}" class="active">Subjects</a></li>
        </ul>
    </aside>

    <div class="main-wrapper">
        <header class="top-bar">
            <h2 style="font-size: 1.25rem; font-weight: bold; color: #064e3b;">Mathematics (MATH-101)</h2>
            <div style="font-weight: bold; color: #059669;">Student View</div>
        </header>

        <main class="content-area">
            
            <div class="course-header-card">
                <div>
                    <h1 style="margin: 0; font-size: 1.8rem;">General Mathematics</h1>
                    <p style="margin-top: 0.5rem; opacity: 0.9;">Dr. Alan Smith • Fall Semester 2025</p>
                </div>
            </div>

            @forelse($materials as $week => $items)
                <div class="week-section">
                    <div class="week-title">📅 {{ $week }}</div>

                    @foreach($items as $item)
                    <div class="material-card">
                        <div class="file-icon">📄</div>
                        <div class="material-info" style="flex: 1;">
                            <h4>{{ $item->title }}</h4>
                            <p style="color: #64748b; font-size: 0.9rem;">
                                {{ $item->description }} <br>
                                <span style="font-size: 0.8rem; opacity: 0.7;">Posted: {{ $item->created_at->diffForHumans() }}</span>
                            </p>
                        </div>
                        
                        @if($item->file_path)
                            <div>
                                <a href="{{ route('material.download', $item->id) }}" class="btn-download">
                                    ⬇️ Download
                                </a>
                            </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            @empty
                <div style="text-align: center; padding: 4rem; color: #94a3b8;">
                    <h3>No materials found.</h3>
                </div>
            @endforelse

        </main>
    </div>
</body>
</html>