@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

@php
    // Group submissions by student & take highest score only
    $bestSubmissions = $quiz->submissions
        ->groupBy('user_id')
        ->map(function ($attempts) {
            return $attempts->sortByDesc('percentage')->first();
        });

    $passCount = $bestSubmissions->where('is_pass', true)->count();
    $failCount = $bestSubmissions->where('is_pass', false)->count();
@endphp

<style>
body {
    background:#f0f8ff !important;
    font-family:'Comic Sans MS', Arial, sans-serif;
}

/* Report card with same background as index page quiz cards */
.report-card {
    background:#fff7e0;
    border-radius:12px;
    padding:20px;
    box-shadow:0 6px 20px rgba(0,0,0,0.1);
}

/* FLEX LAYOUT */
.report-layout {
    display:flex;
    gap:20px;
    align-items:flex-start;
    flex-wrap:nowrap;
}

/* TABLE */
.report-table {
    flex:1;
}

table {
    width:900px;
    background:white;
    border-radius:12px;
    overflow:hidden;
}

th {
    background:#ffe3a3;
}

th, td {
    text-align:center;
    vertical-align:middle;
}

/* CHART */
.chart-box {
    width:200px;
    height:200px;
    background:white;
    border-radius:12px;
    padding:8px;
    display:flex;
    align-items:center;
    justify-content:center;
    box-shadow:0 4px 10px rgba(0,0,0,0.15);
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
    <h1 class="mb-4 fw-bold text-center" style="margin-left: 30px;color: black;">
        Quiz Report: {{ $quiz->title }}
    </h1>

    <div class="report-card">

        <div class="report-layout">

            {{-- TABLE --}}
            <div class="report-table">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Student Name</th>
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
                                <td>{{ $submission->user->name }}</td>
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
                                <td colspan="6" class="text-center text-muted">
                                    No submissions yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <h3 class="fw-bold mb-4">
                Overall Analysis:
            </h3>
            {{-- ANALYSIS CHART --}}
            <div class="chart-box">
                <canvas id="passFailChart" width="200" height="200"></canvas>
            </div>

        </div>
    </div>
    <div class="back-btn-wrapper">
        <a href="{{ route('module3.teacher.index') }}" class="back-btn">Back</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('passFailChart');

new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Pass', 'Fail'],
        datasets: [{
            data: [{{ $passCount }}, {{ $failCount }}],
            backgroundColor: ['#28a745', '#dc3545']
        }]
    },
    options: {
        responsive: false,
        plugins: {
            legend: { display: false }
        },
        cutout: '65%'
    }
});
</script>

@endsection
