@extends('layouts.app')

@section('content')
@php
$totalPoints = $submission->quiz->questions->sum('points');
@endphp

<div class="container quiz-container">

    <div class="quiz-header">
        <h1>{{ $submission->quiz->title }} - Result</h1>
        <p class="text-muted">Here’s your performance for this quiz.</p>
    </div>

    <div class="quiz-card mb-3">
        <p><strong>Score:</strong> {{ $submission->score }} / {{ $totalPoints }}</p>
        <p><strong>Percentage:</strong> {{ $submission->percentage }}%</p>
        <p><strong>Status:</strong> 
            @if($submission->is_pass) Passed ✅ @else Failed ❌ @endif
        </p>
    </div>

    <h3 class="mb-2">Detailed Answers</h3>

    @foreach($submission->quiz->questions as $question)
        @php
            $answer = $submission->answers->firstWhere('question_id', $question->id);
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
                            <strong>(Your Answer)</strong>
                        @endif
                        @if($choice->is_correct)
                            ✅
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach

</div>

<style>
body {
    background: #f0f8ff !important;
    font-family: 'Comic Sans MS', Arial, sans-serif;
}

.quiz-container {
    max-width: 800px;
    margin: 20px auto;
}

.quiz-header {
    background: #ffb100;
    color: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.quiz-header h1 {
    margin: 0;
    font-weight: bold;
}

.quiz-header p {
    margin: 5px 0 0;
}

.quiz-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
}

.question-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.question-title {
    font-weight: bold;
    font-size: 16px;
}

.question-points {
    font-weight: bold;
    color: #6c757d;
}

ul li {
    margin-bottom: 5px;
    font-size: 16px;
}
</style>
@endsection
