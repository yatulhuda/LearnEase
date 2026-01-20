@extends('layouts.app')

@section('content')

<style>
.back-btn {
    align-items: center;
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
        Create New Quiz
    </h1>

    @if($errors->any())
        <div class="alert alert-danger rounded shadow-sm border-0">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('module3.teacher.store') }}" method="POST">
        @csrf

        <!-- Quiz Info -->
        <div class="card mb-5 shadow-lg rounded-3 border-0">
            <div class="card-header bg-warning text-white fw-bold shadow-sm rounded-top">
                Quiz Information
            </div>

            <div class="card-body">

                <!-- PERFECT SINGLE HORIZONTAL ROW -->
                <div class="quiz-row">

                    <div class="quiz-field small-field">
                        <label class="form-label fw-bold">Title</label>
                        <input type="text" name="title" class="form-control rounded shadow-sm border-0"
                            placeholder="Enter quiz title" required>
                    </div>

                    <div class="quiz-field small-field">
                        <label class="form-label fw-bold">Description</label>
                        <input type="text" name="description" class="form-control rounded shadow-sm border-0"
                            placeholder="Enter quiz description (optional)">
                    </div>

                    <div class="quiz-field small-field">
                        <label class="form-label fw-bold">Time Limit (minutes)</label>
                        <input type="number" name="time_limit" class="form-control rounded shadow-sm border-0"
                            placeholder="30">
                    </div>

                    <div class="quiz-field small-field">
                        <label class="form-label fw-bold">Pass Mark (%)</label>
                        <input type="number" name="pass_mark" class="form-control rounded shadow-sm border-0"
                            placeholder="60" required>
                    </div>

                    <div class="quiz-field small-field">
                        <label class="form-label fw-bold">Attempt Allowed</label>
                        <input type="number" name="attempt_allowed" class="form-control rounded shadow-sm border-0"
                            value="1" min="1" required>
                    </div>

                    <div class="quiz-field small-field">
                        <label class="form-label fw-bold">Start Time</label>
                        <input type="datetime-local" name="start_time"
                            class="form-control rounded shadow-sm border-0" required>
                    </div>

                    <!-- ✅ NEW END TIME -->
                    <div class="quiz-field small-field">
                        <label class="form-label fw-bold">End Time</label>
                        <input type="datetime-local" name="end_time"
                            class="form-control rounded shadow-sm border-0" required>
                    </div>

                </div>
                <!-- END PERFECT ROW -->

            </div>
        </div>

        <!-- Questions Section -->
        <div class="card shadow-lg rounded-3 mb-5 border-0">
            <div class="card-header d-flex justify-content-between align-items-center bg-warning text-white fw-bold shadow-sm rounded-top">
                <span>Questions</span>
                <button type="button" class="btn btn-light btn-sm fw-bold shadow-sm" onclick="addQuestion()">
                    <i class="fa-solid fa-plus"></i> Add Question
                </button>
            </div>
            <div class="card-body" id="questionsContainer">
                <p class="text-muted mb-3">Add questions below. Each question can have multiple choices.</p>
            </div>
        </div>

        <div class="text-end mb-5">
            <button type="submit" class="btn btn-success rounded-pill fw-bold shadow-sm px-5 py-2" style="font-size: 1rem;">
                <i class="fa-solid fa-check"></i> Create Quiz
            </button>
        </div>
    </form>
    <div class="back-btn-wrapper">
        <a href="{{ route('module3.teacher.index') }}" class="back-btn">Back</a>
    </div>
</div>

<style>
body {
    background: #f0f8ff !important;
    font-family: 'Comic Sans MS', Arial, sans-serif;
}

.card { border-radius: 15px !important; }
.card-header { border-radius: 15px 15px 0 0 !important; }

/* ---------------------- */
/* PERFECT HORIZONTAL ROW */
/* ---------------------- */
.quiz-row {
    display: flex;
    gap: 20px;
    padding: 10px 5px;
    margin-left: 5px;
    align-items: flex-start;
    flex-wrap: nowrap;
    overflow-x: auto;
}

.quiz-field { width: 250px; }
.quiz-field input[type="datetime-local"] {
    width: 170px;
}

.small-field {
    width: 170px;
}

.medium-field {
    width: 220px;
}

.quiz-field label {
    margin-bottom: 6px;
}

.btn-primary, .btn-success, .btn-light, .btn-secondary {
    border-radius: 10px;
    font-weight: bold;
    transition: all 0.3s ease;
}

.btn-primary:hover, .btn-success:hover, .btn-light:hover, .btn-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.input-group-text {
    background: #ffe3a3;
}

/* ------------------------------------------- */
/* IMPROVED QUESTION CARD DESIGN – SAME THEME  */
/* ------------------------------------------- */
.question-card {
    background: #fff8e6;
    border: 2px solid #ffd77a;
    padding: 18px;
    border-radius: 15px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    margin-bottom: 25px;
}

.question-header {
    background: #ffe9b3;
    border-radius: 12px;
    padding: 10px 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.question-header h5 {
    margin: 0;
    font-weight: bold;
    color: #9a6600;
}

.choice-group .input-group {
    margin-bottom: 10px;
}

.choice-group .input-group-text {
    border-radius: 10px 0 0 10px !important;
    background: #ffefc7 !important;
    border: 1px solid #f7c96d;
}

.choice-group input[type="text"] {
    border-radius: 0 10px 10px 0 !important;
    border: 1px solid #f7c96d;
}

.btn-secondary {
    border-radius: 10px;
}

.btn-outline-danger {
    border-radius: 10px !important;
}
</style>

<script>
let questionIndex = 0;

function addQuestion() {
    const container = document.getElementById('questionsContainer');

    const qHTML = `
        <div class="question-card" id="question-${questionIndex}">
            
            <div class="question-header">
                <h5>Question ${questionIndex + 1}</h5>
                <button type="button" class="btn btn-danger btn-sm fw-bold" onclick="removeQuestion(${questionIndex})">
                    Remove
                </button>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Question Text</label>
                <input type="text" name="questions[${questionIndex}][text]" 
                    class="form-control rounded shadow-sm border-0" required>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Type</label>
                    <select class="form-control rounded shadow-sm border-0"
                        name="questions[${questionIndex}][type]"
                        onchange="updateChoiceInputs(${questionIndex})">
                        <option value="single">Single Choice</option>
                        <option value="multiple">Multiple Choice</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Points</label>
                    <input type="number" name="questions[${questionIndex}][points]" 
                        class="form-control rounded shadow-sm border-0" required value="5">
                </div>
            </div>

            <div class="mt-3">
                <h6 class="fw-bold mb-2">Choices</h6>
                <div id="choices-${questionIndex}" class="choice-group"></div>
                <button type="button" class="btn btn-secondary btn-sm mt-2 fw-bold shadow-sm" 
                    onclick="addChoice(${questionIndex})">+ Add Choice</button>
            </div>

        </div>
    `;

    container.insertAdjacentHTML('beforeend', qHTML);

    for (let i = 0; i < 4; i++) addChoice(questionIndex);

    questionIndex++;
}

function addChoice(qIndex) {
    const choiceContainer = document.getElementById(`choices-${qIndex}`);
    const choiceCount = choiceContainer.children.length;

    const choiceHTML = `
        <div class="input-group mt-2">
            <span class="input-group-text">
                <input type="checkbox" class="correct-${qIndex}" 
                       name="questions[${qIndex}][choices][${choiceCount}][correct]" value="1">
            </span>
            <input type="text" class="form-control rounded shadow-sm border-0"
                name="questions[${qIndex}][choices][${choiceCount}][text]" placeholder="Choice text" required>
            <button type="button" class="btn btn-outline-danger fw-bold" onclick="removeChoice(this)">X</button>
        </div>
    `;

    choiceContainer.insertAdjacentHTML('beforeend', choiceHTML);
}

function removeChoice(btn) {
    btn.parentElement.remove();
}

function removeQuestion(index) {
    document.getElementById(`question-${index}`).remove();
}

function updateChoiceInputs(qIndex) {
    const typeSelect = document.querySelector(`select[name="questions[${qIndex}][type]"]`);
    const checkboxes = document.querySelectorAll(`.correct-${qIndex}`);

    if (typeSelect.value === 'single') {
        checkboxes.forEach(cb => cb.type = 'radio');
        checkboxes.forEach(cb => cb.name = `questions[${qIndex}][correct_choice]`);
    } else {
        checkboxes.forEach(cb => cb.type = 'checkbox');
    }
}
</script>
@endsection
