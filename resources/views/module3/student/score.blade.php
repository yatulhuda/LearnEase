@extends('layouts.app')

@section('content')
@php
$highestSubmission = $submissions->sortByDesc('score')->first();
$totalPoints = $quiz->questions->sum('points');
@endphp

<style>
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

<div class="container quiz-container">

    <div class="quiz-header">
        <h1>{{ $quiz->title }} - Highest Score</h1>
        <p class="text-muted">This shows the highest score achieved by any student for this quiz.</p>
    </div>

    @if($highestSubmission)
        <div class="quiz-card mb-3">
            <p><strong>Student:</strong> {{ $highestSubmission->user->name }}</p>
            <p><strong>Score:</strong> {{ $highestSubmission->score }} / {{ $totalPoints }}</p>
            <p><strong>Percentage:</strong> {{ $highestSubmission->percentage }}%</p>
            <p><strong>Status:</strong> 
                @if($highestSubmission->is_pass) Passed ✅ @else Failed ❌ @endif
            </p>
        </div>

        <h3 class="mb-2">Detailed Answers</h3>

        @foreach($quiz->questions as $question)
            @php
                $answer = $highestSubmission->answers->firstWhere('question_id', $question->id);
                $selected = $answer ? $answer->selected_choices : [];
            @endphp

            <div class="quiz-card mb-3">
                <div class="question-top">
                    <div class="question-title">{{ $loop->iteration }}. {{ $question->question_text }}</div>
                    <div class="question-points">{{ $question->points }} pts</div>
                </div>

                <ul>
                    @foreach($question->choices as $choice)
                        <li>
                            {{ $choice->choice_text }}
                            @if(in_array($choice->id, $selected))
                                <strong>(Selected)</strong>
                            @endif
                            @if($choice->is_correct) ✅ @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
            <div class="back-btn-wrapper">
                <a href="{{ route('module3.student.index') }}" class="back-btn">Back</a>
            </div>

    @else
        <div class="alert alert-info">
            No submissions yet for this quiz.
        </div>
    @endif
</div>

<style>
body { background: #f0f8ff !important; font-family: 'Comic Sans MS', Arial, sans-serif; }
.quiz-container { max-width: 800px; margin: 20px auto; }
.quiz-header { background: #ffb100; color: white; padding: 20px; border-radius: 12px; box-shadow: 0 6px 20px rgba(0,0,0,0.1); margin-bottom: 20px; }
.quiz-card { background: white; border-radius: 12px; padding: 20px; margin-bottom: 20px; box-shadow: 0 6px 20px rgba(0,0,0,0.1); }
.question-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
.question-title { font-weight: bold; font-size: 16px; }
.question-points { font-weight: bold; color: #6c757d; }
ul li { margin-bottom: 5px; font-size: 16px; }
</style>
@endsection
