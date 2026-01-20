@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

@php
    use Illuminate\Support\Collection;

    $studentId = auth()->id();

    // Group submissions by quiz and take highest percentage for this student
    $bestSubmissions = $submissions->where('user_id', $studentId)
        ->groupBy('quiz_id')
        ->map(function ($attempts) {
            return $attempts->sortByDesc('percentage')->first();
        });
@endphp

<style>
body {
    background:#f0f8ff !important;
    font-family:'Comic Sans MS', Arial, sans-serif;
}

/* Card container */
.report-card {
    background:#fff7e0;
    border-radius:12px;
    padding:20px;
    box-shadow:0 6px 20px rgba(0,0,0,0.1);
}

/* Table */
table {
    width:100%;
    background:white;
    border-radius:12px;
    overflow:hidden;
}

th {
    background:#ffe3a3;
    text-align:center;
    vertical-align:middle;
}

td {
    text-align:center;
    vertical-align:middle;
}

.review-btn {
    background:#17a2b8;
    color:white !important;
    padding:8px 14px;
    border-radius:10px;
    font-weight:bold;
    text-decoration:none;
}

.review-btn:hover {
    background:#138496;
}

.back-btn {
    background:#17a2b8;
    color:white !important;
    padding:8px 14px;
    border-radius:10px;
    font-weight:bold;
    text-decoration:none;
}

.back-btn:hover {
    background:#138496;
}
.back-btn-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}
</style>

<div class="container">
    <h2 class="fw-bold mb-4">
        My Quiz Scores
    </h2>

    <div class="report-card">
        <table class="table table-bordered mb-0">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Quiz Title</th>
                    <th>Score</th>
                    <th>Percentage</th>
                    <th>Status</th>
                    <th>Attempt Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bestSubmissions as $submission)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $submission->quiz->title }}</td>
                        <td>{{ $submission->score }}</td>
                        <td>{{ $submission->percentage }}%</td>
                        <td>
                            @if($submission->is_pass)
                                <span class="text-success fw-bold">Pass</span>
                            @else
                                <span class="text-danger fw-bold">Fail</span>
                            @endif
                        </td>
                        <td>{{ $submission->created_at->format('d M Y, h:i A') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No quizzes attempted yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="back-btn-wrapper">
        <a href="{{ route('module3.student.index') }}" class="back-btn">Back</a>
    </div>
</div>

@endsection
