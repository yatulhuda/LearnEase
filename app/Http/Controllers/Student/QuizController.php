<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\QuizSubmission;
use App\Models\QuizAnswer;

class QuizController extends Controller
{
    // Display all available quizzes for the student
    public function index()
    {
        $quizzes = Quiz::all();
        return view('module3.student.index', compact('quizzes'));
    }

    // Show a single quiz for taking
    public function show($id)
    {
        $quiz = Quiz::with('questions.choices')->findOrFail($id);
        return view('module3.student.show', compact('quiz'));
    }

    // Submit quiz answers and auto-grade
    public function submit(Request $request, $id)
    {
        $quiz = Quiz::with('questions.choices')->findOrFail($id);

        $score = 0;
        $totalPoints = $quiz->questions->sum('points');

        // Create submission
        $submission = QuizSubmission::create([
            'quiz_id' => $quiz->id,
            'user_id' => auth()->id(),
            'score' => 0,
            'percentage' => 0,
            'is_pass' => false
        ]);

        foreach ($quiz->questions as $question) {
            // Get submitted answer(s), default empty array
            $selected = $request->input('question_'.$question->id, []);
            if (!is_array($selected)) {
                $selected = [$selected];
            }

            // Save student answer
            QuizAnswer::create([
                'submission_id' => $submission->id,
                'question_id' => $question->id,
                'selected_choices' => $selected
            ]);

            // Auto-grade
            $correctChoices = $question->choices()
                ->where('is_correct', true)
                ->pluck('id')
                ->sort()
                ->values()
                ->toArray();

            $selectedSorted = collect($selected)
                ->map(fn ($v) => (int) $v)
                ->sort()
                ->values()
                ->toArray();

            if ($correctChoices === $selectedSorted) {
                $score += $question->points;
            }
        }

        $percentage = $totalPoints > 0
            ? round(($score / $totalPoints) * 100)
            : 0;

        $submission->update([
            'score' => $score,
            'percentage' => $percentage,
            'is_pass' => $percentage >= $quiz->pass_mark
        ]);

        // Redirect to result page (latest submission)
        return redirect()->route('module3.student.result', $quiz->id);
    }

    // Show quiz result (LATEST attempt for this student & quiz)
    public function result($quizId)
    {
        $submission = QuizSubmission::with('quiz.questions.choices', 'answers')
            ->where('quiz_id', $quizId)
            ->where('user_id', auth()->id())
            ->latest()
            ->firstOrFail();

        return view('module3.student.result', compact('submission'));
    }

    public function score($id)
    {
        $quiz = Quiz::with('questions.choices')->findOrFail($id);

        // Get all submissions for this quiz by the current student
        $submissions = QuizSubmission::where('quiz_id', $id)
            ->where('user_id', auth()->id())
            ->orderByDesc('score') // highest score first
            ->get();

        return view('module3.student.score', compact('quiz', 'submissions'));
    }

    public function allQuiz()
    {
        $studentId = auth()->id();

        // Get all submissions by the logged-in student
        $submissions = QuizSubmission::with('quiz')
            ->where('user_id', $studentId)
            ->get();

        return view('module3.student.allquiz', compact('submissions'));
    }
}