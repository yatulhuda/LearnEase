@extends('layouts.app')

@section('content')

@if(session('success')) 
    <div class="alert alert-success rounded shadow-sm border-0">{{ session('success') }}</div>
@endif

<form action="{{ route('module3.teacher.update', $quiz->id) }}" method="POST">
    <h1 class="mb-4 fw-bold text-center" style="margin-left: 30px;color: black;">
        Edit Quiz
    </h1>
    @csrf
    @method('PATCH')

    <!-- Quiz Info -->
    <div class="card mb-5 shadow-lg rounded-3 border-0">
        <div class="card-header bg-warning text-white fw-bold shadow-sm rounded-top">
            Quiz Information
        </div>
        <div class="card-body">

            <div class="quiz-row">

                <div class="quiz-field small-field">
                    <label class="form-label fw-bold">Title</label>
                    <input type="text" name="title"
                        class="form-control rounded shadow-sm border-0"
                        value="{{ $quiz->title }}" required>
                </div>

                <div class="quiz-field small-field">
                    <label class="form-label fw-bold">Description</label>
                    <input type="text" name="description"
                        class="form-control rounded shadow-sm border-0"
                        value="{{ $quiz->description }}">
                </div>

                <div class="quiz-field small-field">
                    <label class="form-label fw-bold">Time Limit (minutes)</label>
                    <input type="number" name="time_limit"
                        class="form-control rounded shadow-sm border-0"
                        value="{{ $quiz->time_limit }}">
                </div>

                <div class="quiz-field small-field">
                    <label class="form-label fw-bold">Pass Mark (%)</label>
                    <input type="number" name="pass_mark"
                        class="form-control rounded shadow-sm border-0"
                        value="{{ $quiz->pass_mark }}" required>
                </div>

                <div class="quiz-field small-field">
                    <label class="form-label fw-bold">Attempt Allowed</label>
                    <input type="number" name="attempt_allowed"
                        class="form-control rounded shadow-sm border-0"
                        value="{{ $quiz->attempts_allowed }}" required>
                </div>

                <div class="quiz-field small-field">
                    <label class="form-label fw-bold">Start Time</label>
                    <input type="datetime-local" name="start_time"
                        class="form-control rounded shadow-sm border-0"
                        value="{{ $quiz->start_time ? date('Y-m-d\TH:i', strtotime($quiz->start_time)) : '' }}"
                        required>
                </div>

                <div class="quiz-field small-field">
                    <label class="form-label fw-bold">End Time</label>
                    <input type="datetime-local" name="end_time"
                        class="form-control rounded shadow-sm border-0"
                        value="{{ $quiz->end_time ? date('Y-m-d\TH:i', strtotime($quiz->end_time)) : '' }}"
                        required>
                </div>

            </div>

        </div>
    </div>

    <!-- Questions Section -->
    <div class="card shadow-lg rounded-3 mb-5 border-0">
        <div class="card-header d-flex justify-content-between align-items-center bg-warning text-white fw-bold shadow-sm rounded-top">
            <span>Questions</span>
            <button type="button" class="btn btn-light btn-sm fw-bold shadow-sm rounded-pill" onclick="addQuestion()">
                <i class="fa-solid fa-plus"></i> Add Question
            </button>
        </div>

        <div class="card-body" id="questionsContainer">
            <p class="text-muted mb-3">You can change your questions below. Each question can have multiple choices, and you can add or remove choices as needed.</p>

            @foreach($quiz->questions as $qIndex => $question)
                <div class="question-card" id="question-{{ $qIndex }}">
                    <input type="hidden" name="questions[{{ $qIndex }}][id]" value="{{ $question->id }}">
                    <div class="question-header">
                        <h5>Question {{ $qIndex + 1 }}</h5>
                        <button type="button" class="btn btn-danger btn-sm fw-bold" onclick="removeQuestion({{ $qIndex }})">Remove</button>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Question Text</label>
                        <input type="text" name="questions[{{ $qIndex }}][text]" class="form-control rounded shadow-sm border-0" value="{{ $question->question_text }}" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Type</label>
                            <select class="form-control rounded shadow-sm border-0" name="questions[{{ $qIndex }}][type]" onchange="updateChoiceInputs({{ $qIndex }})">
                                <option value="single" {{ $question->type === 'single' ? 'selected' : '' }}>Single Choice</option>
                                <option value="multiple" {{ $question->type === 'multiple' ? 'selected' : '' }}>Multiple Choice</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Points</label>
                            <input type="number" name="questions[{{ $qIndex }}][points]" class="form-control rounded shadow-sm border-0" value="{{ $question->points }}" required>
                        </div>
                    </div>

                    <div class="mt-3">
                        <h6 class="fw-bold mb-2">Choices</h6>
                        <div id="choices-{{ $qIndex }}" class="choice-group">
                            @foreach($question->choices as $cIndex => $choice)
                                <div class="input-group mt-2">
                                    <input type="hidden" name="questions[{{ $qIndex }}][choices][{{ $cIndex }}][id]" value="{{ $choice->id }}">
                                    <span class="input-group-text">
                                        @if($question->type === 'single')
                                            <input type="radio" class="correct-{{ $qIndex }}" name="questions[{{ $qIndex }}][correct_choice]" value="{{ $choice->id }}" {{ $choice->is_correct ? 'checked' : '' }}>
                                        @else
                                            <input type="checkbox" class="correct-{{ $qIndex }}" name="questions[{{ $qIndex }}][choices][{{ $cIndex }}][correct]" value="1" {{ $choice->is_correct ? 'checked' : '' }}>
                                        @endif
                                    </span>
                                    <input type="text" class="form-control rounded shadow-sm border-0" name="questions[{{ $qIndex }}][choices][{{ $cIndex }}][text]" value="{{ $choice->choice_text }}" placeholder="Choice text" required>
                                    <button type="button" class="btn btn-outline-danger fw-bold" onclick="removeChoice(this)">X</button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm mt-2 fw-bold shadow-sm rounded-pill" onclick="addChoice({{ $qIndex }})">+ Add Choice</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-4 text-end">
        <button type="submit" class="btn btn-success rounded-pill fw-bold shadow-sm px-5 py-2">
            <i class="fa-solid fa-check"></i> Update Quiz
        </button>
    </div>
</form>

    <div class="back-btn-wrapper">
        <a href="{{ route('module3.teacher.index') }}" class="back-btn">Back</a>
    </div>

<style>
body { background: #f0f8ff !important; font-family: 'Comic Sans MS', Arial, sans-serif; }

.card { border-radius: 15px !important; }
.card-header { border-radius: 15px 15px 0 0 !important; }

/* Quiz Info Row */
.quiz-row {
    display: flex;
    gap: 20px;
    padding: 10px 5px;
    margin-left: 5px;
    align-items: flex-start;
    flex-wrap: wrap;
    overflow-x: auto;
}

.quiz-field { width: 250px; }
.quiz-field input[type="datetime-local"] {
    width: 170px;
}
.small-field { width:170px; }
.medium-field { width:220px; }
.quiz-field label { margin-bottom: 6px; }

/* Question Card */
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

.question-header h5 { margin:0; font-weight:bold; color:#9a6600; }

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

.btn-secondary, .btn-outline-danger, .btn-success, .btn-light {
    border-radius: 10px !important;
    font-weight: bold;
    transition: all 0.3s ease;
}

.btn-secondary:hover, .btn-outline-danger:hover, .btn-success:hover, .btn-light:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}
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

<script>
let questionIndex = {{ $quiz->questions->count() }};

function addQuestion() {
    const container = document.getElementById('questionsContainer');

    const qHTML = `
        <div class="question-card" id="question-${questionIndex}">
            <div class="question-header">
                <h5>Question ${questionIndex + 1}</h5>
                <button type="button" class="btn btn-danger btn-sm fw-bold" onclick="removeQuestion(${questionIndex})">Remove</button>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Question Text</label>
                <input type="text" name="questions[${questionIndex}][text]" class="form-control rounded shadow-sm border-0" required>
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
                    <input type="number"
                           name="questions[${questionIndex}][points]"
                           class="form-control rounded shadow-sm border-0"
                           value="5" required>
                </div>
            </div>

            <div class="mt-3">
                <h6 class="fw-bold mb-2">Choices</h6>
                <div id="choices-${questionIndex}" class="choice-group"></div>
                <button type="button"
                        class="btn btn-secondary btn-sm mt-2 fw-bold shadow-sm rounded-pill"
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

    const type = document.querySelector(
        `select[name="questions[${qIndex}][type]"]`
    ).value;

    let inputHTML = '';

    if (type === 'single') {
        inputHTML = `
            <input type="radio"
                   class="correct-${qIndex}"
                   name="questions[${qIndex}][correct_choice]">
        `;
    } else {
        inputHTML = `
            <input type="checkbox"
                   class="correct-${qIndex}"
                   name="questions[${qIndex}][choices][${choiceCount}][correct]"
                   value="1">
        `;
    }

    const html = `
        <div class="input-group mt-2">
            <span class="input-group-text">${inputHTML}</span>
            <input type="text"
                   class="form-control rounded shadow-sm border-0"
                   name="questions[${qIndex}][choices][${choiceCount}][text]"
                   placeholder="Choice text" required>
            <button type="button"
                    class="btn btn-outline-danger fw-bold"
                    onclick="removeChoice(this)">X</button>
        </div>
    `;

    choiceContainer.insertAdjacentHTML('beforeend', html);
}

function updateChoiceInputs(qIndex) {
    const type = document.querySelector(
        `select[name="questions[${qIndex}][type]"]`
    ).value;

    const inputs = document.querySelectorAll(`.correct-${qIndex}`);

    inputs.forEach((input, index) => {
        const checked = input.checked; // ⭐ preserve state

        if (type === 'single') {
            input.type = 'radio';
            input.name = `questions[${qIndex}][correct_choice]`;
        } else {
            input.type = 'checkbox';
            input.name = `questions[${qIndex}][choices][${index}][correct]`;
            input.value = '1';
        }

        input.checked = checked; // ⭐ restore state
    });
}

function removeChoice(btn) {
    btn.parentElement.remove();
}

function removeQuestion(index) {
    document.getElementById(`question-${index}`).remove();
}
</script>
@endsection
