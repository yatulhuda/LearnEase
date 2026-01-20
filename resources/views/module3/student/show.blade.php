@extends('layouts.app')

@section('content')
@php
$timeLimitMinutes = $quiz->time_limit ?? 0;
$timeLimitSeconds = $timeLimitMinutes * 60;
$quizId = $quiz->id;
@endphp

<style>
body { background: #f0f8ff !important; font-family: 'Comic Sans MS', Arial, sans-serif; }
.quiz-container { max-width: 800px; margin: 20px auto; }
.quiz-header { background: #ffb100; color: white; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
.quiz-card { background: white; border-radius: 12px; padding: 20px; margin-bottom: 20px; box-shadow: 0 6px 20px rgba(0,0,0,0.1); }
.question-top { display: flex; justify-content: space-between; margin-bottom: 10px; }
.question-text { font-size: 18px; margin-bottom: 15px; }
.timer { font-size: 18px; font-weight: bold; text-align: right; }
.progress { height: 20px; border-radius: 10px; margin-bottom: 15px; background: #ffe3a3; }
.progress-bar { background: #ffb100; }
.btn-prev { background:#ffc107; color:white; }
.btn-next { background:#17a2b8; color:white; }
.btn-finish { background:#dc3545; color:white; }
</style>

<div class="container quiz-container">

    <div class="quiz-header">
        <h1>{{ $quiz->title }}</h1>
        <p>{{ $quiz->description }}</p>
        <div class="timer">Time Remaining: <span id="timer"></span></div>
    </div>

    <form id="quizForm" action="{{ route('module3.student.submit', $quiz->id) }}" method="POST">
        @csrf

        <div class="progress">
            <div id="progressBar" class="progress-bar" style="width:0%"></div>
        </div>

        @foreach($quiz->questions as $question)
            <div class="quiz-card question" data-index="{{ $loop->index }}" style="{{ $loop->first ? '' : 'display:none;' }}">
                <div class="question-top">
                    <strong>Question {{ $loop->iteration }}</strong>
                    <span>{{ $question->points }} pts</span>
                </div>
                <div class="question-text">{{ $question->question_text }}</div>

                @if($question->type === 'single')
                    @foreach($question->choices as $choice)
                        <div class="form-check">
                            <input type="radio"
                                   class="form-check-input answer-input"
                                   name="question_{{ $question->id }}"
                                   value="{{ $choice->id }}"
                                   required>
                            <label class="form-check-label">{{ $choice->choice_text }}</label>
                        </div>
                    @endforeach
                @else
                    @foreach($question->choices as $choice)
                        <div class="form-check">
                            <input type="checkbox"
                                   class="form-check-input answer-input"
                                   name="question_{{ $question->id }}[]"
                                   value="{{ $choice->id }}">
                            <label class="form-check-label">{{ $choice->choice_text }}</label>
                        </div>
                    @endforeach
                @endif
            </div>
        @endforeach

        <div class="mt-3">
            <button type="button" id="prevBtn" class="btn btn-prev" onclick="changeQuestion(-1)">Previous</button>
            <button type="button" id="nextBtn" class="btn btn-next" onclick="changeQuestion(1)">Next</button>
            <button type="submit" id="finishBtn" class="btn btn-finish" style="display:none;">Finish Attempt</button>
        </div>

    </form>
</div>

<script>
let currentIndex = 0;
let submitting = false;

const questions = document.querySelectorAll('.question');
const totalQuestions = questions.length;
const timerEl = document.getElementById('timer');
const progressBar = document.getElementById('progressBar');

const quizId = {{ $quizId }};
const answerKey = `quiz_answers_${quizId}`;
const timeKey   = `quiz_remaining_${quizId}`;

const totalSeconds = {{ $timeLimitSeconds }};
let remainingSeconds = localStorage.getItem(timeKey)
    ? parseInt(localStorage.getItem(timeKey))
    : totalSeconds;

// ---------------- SHOW QUESTION ----------------
function showQuestion(index){
    questions.forEach((q,i)=>q.style.display=i===index?'':'none');
    document.getElementById('prevBtn').style.display=index===0?'none':'';
    document.getElementById('nextBtn').style.display=index===totalQuestions-1?'none':'';
    document.getElementById('finishBtn').style.display=index===totalQuestions-1?'':'none';
    progressBar.style.width=((index+1)/totalQuestions)*100+'%';
}

// ---------------- NAVIGATION ----------------
function changeQuestion(step){
    currentIndex += step;
    showQuestion(currentIndex);
}

// ---------------- SAVE ANSWERS ----------------
function saveAnswers(){
    let data = {};
    document.querySelectorAll('.answer-input').forEach(input=>{
        if(input.type === 'radio' && input.checked){
            data[input.name] = input.value;
        }
        if(input.type === 'checkbox'){
            if(!data[input.name]) data[input.name] = [];
            if(input.checked) data[input.name].push(input.value);
        }
    });
    localStorage.setItem(answerKey, JSON.stringify(data));
}

// ---------------- RESTORE ANSWERS ----------------
function restoreAnswers(){
    let saved = localStorage.getItem(answerKey);
    if(!saved) return;

    let data = JSON.parse(saved);
    document.querySelectorAll('.answer-input').forEach(input=>{
        if(input.type === 'radio' && data[input.name] == input.value){
            input.checked = true;
        }
        if(input.type === 'checkbox' && Array.isArray(data[input.name]) && data[input.name].includes(input.value)){
            input.checked = true;
        }
    });
}

document.querySelectorAll('.answer-input').forEach(input=>{
    input.addEventListener('change', saveAnswers);
});

// ---------------- TIMER (PAUSABLE) ----------------
function updateTimer(){
    if(submitting) return;

    if (document.hidden) return; // ⛔ PAUSE when not on page

    remainingSeconds--;
    localStorage.setItem(timeKey, remainingSeconds);

    if(remainingSeconds <= 0){
        timerEl.textContent = "00:00";
        alert('Time is up! Submitting your quiz...');
        submitQuiz(true);
        return;
    }

    let min = Math.floor(remainingSeconds / 60);
    let sec = remainingSeconds % 60;
    timerEl.textContent = `${min.toString().padStart(2,'0')}:${sec.toString().padStart(2,'0')}`;
}

let timerInterval = setInterval(updateTimer, 1000);
updateTimer();

// ---------------- SUBMIT QUIZ ----------------
function submitQuiz(isTimeout=false){
    if(submitting) return;
    submitting = true;
    clearInterval(timerInterval);

    localStorage.removeItem(answerKey);
    localStorage.removeItem(timeKey);

    if(isTimeout){
        questions.forEach(q=>{
            q.querySelectorAll('input').forEach(i=>i.removeAttribute('required'));
        });
    }

    document.getElementById('quizForm').submit();
}

// ---------------- MANUAL SUBMIT ----------------
document.getElementById('quizForm').addEventListener('submit', function(){
    if(submitting) return;
    submitting = true;
    clearInterval(timerInterval);
    localStorage.removeItem(answerKey);
    localStorage.removeItem(timeKey);
});

// ---------------- INIT ----------------
restoreAnswers();
showQuestion(0);
</script>

@endsection
