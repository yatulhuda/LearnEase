@extends('layouts.app')

@section('content')
@php
    use Carbon\Carbon;
    $sorted = $quizzes->sortBy('start_time');
    $grouped = [];
    if ($sorted->count() > 0) {
        $firstDate = Carbon::parse($sorted->first()->start_time)->startOfDay();
        foreach ($sorted as $quiz) {
            $quizDate = Carbon::parse($quiz->start_time)->startOfDay();
            $weekIndex = floor($firstDate->diffInDays($quizDate) / 7) + 1;
            $weekStart = $firstDate->copy()->addDays(($weekIndex - 1) * 7);
            $weekEnd = $weekStart->copy()->addDays(6);
            $key = 'week-' . $weekIndex;
            $grouped[$key]['weekIndex'] = $weekIndex;
            $grouped[$key]['start'] = $weekStart;
            $grouped[$key]['end'] = $weekEnd;
            $grouped[$key]['items'][] = $quiz;
        }
    }
@endphp

<style>
    body { background-color: #f8fafc; margin: 0; font-family: system-ui, -apple-system, sans-serif; }

    /* --- TOP NAVIGATION BAR --- */
    .navbar {
        height: 70px;
        background: #1e293b;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 4rem;
        color: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .nav-brand { font-size: 1.5rem; font-weight: 800; color: #3b82f6; text-decoration: none; }
    .nav-links { display: flex; gap: 30px; list-style: none; }
    .nav-links a { color: #cbd5e1; text-decoration: none; font-weight: 500; transition: color 0.2s; }
    .nav-links a:hover, .nav-links a.active { color: white; }

    .user-profile { display: flex; align-items: center; gap: 12px; cursor: pointer; position: relative; }
    .avatar { 
        width: 38px; height: 38px; background: #3b82f6; border-radius: 50%; 
        display: flex; align-items: center; justify-content: center; font-weight: bold; 
    }

    /* --- CONTENT AREA --- */
    .main-container { max-width: 1100px; margin: 40px auto; padding: 0 20px; }
    
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .page-title { font-size: 1.85rem; font-weight: 800; color: #0f172a; }

    .week-card {
        background: white; border-radius: 12px; margin-bottom: 1.5rem;
        border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }
    .week-header {
        background: white; padding: 1.25rem 1.5rem; color: #1e293b; font-size: 1.1rem;
        cursor: pointer; font-weight: 700; display: flex; justify-content: space-between; align-items: center;
    }
    .week-header:hover { background: #f1f5f9; }
    .chevron { transition: transform 0.3s ease; color: #94a3b8; }
    .week-content { padding: 0 1.5rem 1.5rem 1.5rem; border-top: 1px solid #f1f5f9; }

    /* --- TABLE & BUTTONS --- */
    .quiz-table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
    .quiz-table th { text-align: left; padding: 12px; color: #64748b; font-size: 0.8rem; text-transform: uppercase; border-bottom: 2px solid #f1f5f9; }
    .quiz-table td { padding: 16px 12px; border-bottom: 1px solid #f1f5f9; }

    .btn { padding: 8px 16px; border-radius: 8px; font-weight: 600; text-decoration: none; font-size: 14px; border: none; cursor: pointer; }
    .btn-primary { background: #3b82f6; color: white; }
    .btn-outline { border: 1px solid #e2e8f0; color: #475569; margin-right: 5px; }
    .btn-danger { color: #ef4444; background: #fef2f2; }
    .btn:hover { opacity: 0.9; }

</style>

<nav class="navbar">
    <a href="/" class="nav-brand">LearnEase</a>
    
    <ul class="nav-links">
        <li><a href="{{ route('dashboards.hometeacher') }}" class="hover:text-blue-200 font-semibold">Dashboard</a></li>
        <li><a href="{{ route('teacher.subjects') }}" class="hover:text-blue-200 font-semibold">Assignments</a></li>
        <li><a href="{{ route('module3.teacher.index') }}" class="hover:text-blue-200 font-semibold">Quizzes</a></li>
        <li><a href="{{ route('teacherView.dashboard') }}" class="hover:text-blue-200 font-semibold">Subjects</a></li>
        <li><a href="{{ route('discussions.index') }}" class="hover:text-blue-200 font-semibold">Discussion</a></li>
    </ul>

    <div class="user-profile">
        <span style="font-size: 0.9rem;">{{ Auth::user()->name ?? 'Teacher' }}</span>
        <div class="avatar">{{ substr(Auth::user()->name ?? 'T', 0, 1) }}</div>
    </div>
</nav>

<div class="main-container">
    <div class="page-header">
        <h1 class="page-title">Quiz Management</h1>
        <a href="{{ route('module3.teacher.create') }}" class="btn btn-primary">
            + Create New Quiz
        </a>
    </div>

    @foreach($grouped as $key => $data)
        <div class="week-card">
            <div class="week-header" onclick="toggleWeek('{{ $key }}')">
                <div>
                    Week {{ $data['weekIndex'] }}
                    <span style="font-weight: 400; color: #64748b; font-size: 0.9rem; margin-left: 10px;">
                        {{ $data['start']->format('M d') }} — {{ $data['end']->format('M d, Y') }}
                    </span>
                </div>
                <i class="fa-solid fa-chevron-down chevron" id="chevron-{{ $key }}"></i>
            </div>

            <div class="week-content" id="content-{{ $key }}" style="display: block;">
                <table class="quiz-table">
                    <thead>
                        <tr>
                            <th style="width: 40%;">Quiz Details</th>
                            <th>Schedule</th>
                            <th>Status</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['items'] as $quiz)
                        <tr>
                            <td>
                                <div style="font-weight: 700; color: #0f172a;">{{ $quiz->title }}</div>
                                <div style="font-size: 0.85rem; color: #64748b;">{{ Str::limit($quiz->description, 60) }}</div>
                            </td>
                            <td>
                                <div style="font-size: 0.85rem; font-weight: 500;">{{ Carbon::parse($quiz->start_time)->format('M d, g:i A') }}</div>
                            </td>
                            <td>
                                <span style="background: #dcfce7; color: #15803d; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase;">
                                    {{ $quiz->pass_mark }}% Pass
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <a href="{{ route('module3.teacher.edit',$quiz->id) }}" class="btn btn-outline">Edit</a>
                                <a href="{{ route('module3.teacher.report',$quiz->id) }}" class="btn btn-outline">Report</a>
                                <form action="{{ route('module3.teacher.delete',$quiz->id) }}" method="POST" style="display: inline;">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger" onclick="return confirm('Delete?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>

<script>
function toggleWeek(key) {
    const content = document.getElementById('content-' + key);
    const icon = document.getElementById('chevron-' + key);
    if (content.style.display === 'none') {
        content.style.display = 'block';
        icon.style.transform = 'rotate(180deg)';
    } else {
        content.style.display = 'none';
        icon.style.transform = 'rotate(0deg)';
    }
}
</script>
@endsection