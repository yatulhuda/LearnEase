@extends('layouts.app')

@section('content')

@php
use Carbon\Carbon;

// Sort quizzes by start_time
$sorted = $quizzes->sortBy('start_time');

// Build custom week grouping manually
$grouped = [];

if ($sorted->count() > 0) {
    $firstDate = Carbon::parse($sorted->first()->start_time)->startOfDay();

    foreach ($sorted as $quiz) {
        $quizDate = Carbon::parse($quiz->start_time)->startOfDay();

        $weekIndex = floor($firstDate->diffInDays($quizDate) / 7) + 1;

        $weekStart = $firstDate->copy()->addDays(($weekIndex - 1) * 7);
        $weekEnd   = $weekStart->copy()->addDays(4);

        $key = $weekStart->toDateString();

        $grouped[$key]['weekIndex'] = $weekIndex;
        $grouped[$key]['start'] = $weekStart;
        $grouped[$key]['end'] = $weekEnd;
        $grouped[$key]['items'][] = $quiz;
    }
}
@endphp

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<style>
/* --- BODY --- */
body { background: #f0f8ff !important; font-family: 'Comic Sans MS', Arial, sans-serif; }

/* --- HEADER --- */
.navbar {
    height: 70px;
    background: #064e3b;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 2rem;
    color: white;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
.nav-brand { font-size: 1.5rem; font-weight: 800; color: #fff7e0; text-decoration: none; }
.nav-links { display: flex; gap: 30px; list-style: none; }
.nav-links a { color: #cbd5e1; text-decoration: none; font-weight: 500; transition: color 0.2s; }
.nav-links a:hover, .nav-links a.active { color: white; }
.user-profile { display: flex; align-items: center; gap: 12px; cursor: pointer; }
.avatar { width: 38px; height: 38px; background: #3b82f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; }

/* --- WEEK CARDS --- */
.week-card { background: white; border-radius: 12px; padding: 20px; margin-bottom: 20px; box-shadow: 0 6px 20px rgba(0,0,0,0.1); }
.week-header { background: #064e3b; padding: 15px 20px; color: white; font-size: 20px; cursor: pointer; border-radius: 10px; font-weight: bold; display: flex; justify-content: space-between; align-items: center; user-select: none; box-shadow: 0 3px 6px rgba(0,0,0,0.15); }
.chevron { color: white; font-size: 22px; margin-left: 10px; transition: transform 0.25s ease; }
.week-content { text-align:center; padding: 20px; background: #fff7e0; border-radius: 12px; margin-top: 10px; }
table { width:100%; background: white; border-radius: 12px; overflow: hidden; }
th { background: #ffe3a3; }

/* --- BUTTONS --- */
.take-btn, .review-btn, .report-btn { color: white !important; padding: 6-8px; border-radius: 10px; text-decoration: none; font-weight: bold; transition: 0.3s ease; display:inline-block; margin-right:5px; font-size:14px; text-align:center; }
.take-btn { background: #ffb100; }
.take-btn:hover { background: #e59e00; }
.review-btn { background: #17a2b8; }
.review-btn:hover { background: #138496; }
.report-btn { background:#6f42c1; }
.report-btn:hover { background:#59339d; }
</style>

<!-- --- HEADER --- -->
<nav class="navbar">
    <a href="/" class="nav-brand">LearnEase</a>

    <ul class="nav-links">
        <li><a href="{{ route('dashboards.homestudent') }}" class="hover:text-green-200 font-semibold">Dashboard</a></li>
        <li><a href="{{ route('student.subjects') }}" class="hover:text-green-200 font-semibold">Assignments</a></li>
        <li><a href="{{ route('module3.student.index') }}" class="hover:text-green-200 font-semibold">Quizzes</a></li>
        <li><a href="{{ route('studView.dashboardStud') }}" class="hover:text-green-200 font-semibold">Subjects</a></li>
        <li><a href="{{ route('discussions.index') }}" class="hover:text-green-200 font-semibold">Discussion</a></li>
    </ul>

    <div class="user-profile">
        <span>{{ Auth::user()->name ?? 'Student' }}</span>
        <div class="avatar">{{ substr(Auth::user()->name ?? 'S', 0, 1) }}</div>
    </div>
</nav>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold mb-0">
            Available Quizzes
            <a href="{{ route('module3.student.allquiz') }}" class="report-btn">View Scores</a>
        </h1>
    </div>

    @foreach($grouped as $key => $data)
        @php
            $weekNumber = $data['weekIndex'];
            $start = $data['start'];
            $end = $data['end'];
            $items = $data['items'];
            $expanded = count($items) > 0;
        @endphp

        <div class="week-card">
            <div class="week-header" onclick="toggleWeek('{{ $key }}')">
                <span>WEEK {{ $weekNumber }} ({{ $start->format('d M') }} - {{ $end->format('d M') }})</span>
                <i class="fa-solid fa-chevron-down chevron" id="chevron-{{ $key }}" style="transform: rotate({{ $expanded ? 180 : 0 }}deg);"></i>
            </div>

            <div class="week-content" id="content-{{ $key }}" style="display: {{ $expanded ? 'block' : 'none' }};">
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Quiz Title</th>
                            <th>Description</th>
                            <th>Time Limit</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $quiz)
                            @php
                                $now = \Carbon\Carbon::now();
                                $quizStarted = $now->gte(\Carbon\Carbon::parse($quiz->start_time));
                                $quizEnded = $quiz->end_time ? $now->gt(\Carbon\Carbon::parse($quiz->end_time)) : false;
                                $attempts = $quiz->submissions()->where('user_id', auth()->id())->count();
                                $maxAttempts = $quiz->attempts_allowed ?? 1;
                            @endphp
                            <tr>
                                <td>{{ $quiz->title }}</td>
                                <td>{{ $quiz->description }}</td>
                                <td>{{ $quiz->time_limit ?? '-' }} mins</td>
                                <td>{{ \Carbon\Carbon::parse($quiz->start_time)->format('d M Y, h:i A') }}</td>
                                <td>{{ $quiz->end_time ? \Carbon\Carbon::parse($quiz->end_time)->format('d M Y, h:i A') : '-' }}</td>
                                <td>
                                    @if($attempts == 0 && $quizStarted && !$quizEnded)
                                        <a href="{{ route('module3.student.show', $quiz->id) }}" class="take-btn">Take Quiz</a>
                                    @elseif($attempts < $maxAttempts && $quizStarted && !$quizEnded)
                                        <a href="{{ route('module3.student.show', $quiz->id) }}" class="take-btn">Take Quiz</a>
                                        <a href="{{ route('module3.student.score', $quiz->id) }}" class="review-btn">Review Quiz</a>
                                    @else
                                        <a href="{{ route('module3.student.score', $quiz->id) }}" class="review-btn">Review Quiz</a>
                                    @endif
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
function toggleWeek(id) {
    let content = document.getElementById("content-" + id);
    let icon = document.getElementById("chevron-" + id);

    if (content.style.display === "block") {
        content.style.display = "none";
        icon.style.transform = "rotate(0deg)";
    } else {
        content.style.display = "block";
        icon.style.transform = "rotate(180deg)";
    }
}
</script>

@endsection
