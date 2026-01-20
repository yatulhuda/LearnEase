<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Choice;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    // Display all quizzes
    public function index()
    {
        $quizzes = Quiz::all();
        return view('module3.teacher.index', compact('quizzes'));
    }

    // Show create page
    public function create()
    {
        return view('module3.teacher.create');
    }

    // Store quiz + questions + choices
    public function store(Request $request)
    {
        $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'time_limit'      => 'nullable|integer|min:0',
            'pass_mark'       => 'required|integer|min:0|max:100',
            'attempt_allowed' => 'required|integer|min:1',
            'start_time'      => 'required|date',
            'end_time'        => 'nullable|date|after_or_equal:start_time',
            'questions'       => 'required|array|min:1',
        ]);

        // Create quiz
        $quiz = Quiz::create([
            'title'            => $request->title,
            'description'      => $request->description,
            'time_limit'       => $request->time_limit,
            'pass_mark'        => $request->pass_mark,
            'attempts_allowed' => $request->attempt_allowed,
            'start_time'       => $request->start_time,
            'end_time'         => $request->end_time, // ✅ new field
        ]);

        // Store questions and choices
        foreach ($request->questions as $qIndex => $qData) {

            $question = Question::create([
                'quiz_id'       => $quiz->id,
                'question_text' => $qData['text'],
                'type'          => $qData['type'],
                'points'        => $qData['points'],
            ]);

            foreach ($qData['choices'] as $index => $cData) {
                $isCorrect = 0;

                if ($qData['type'] === 'single') {
                    if (isset($qData['correct_choice']) && $qData['correct_choice'] == $index) {
                        $isCorrect = 1;
                    }
                } else {
                    $isCorrect = isset($cData['correct']) ? 1 : 0;
                }

                Choice::create([
                    'question_id' => $question->id,
                    'choice_text' => $cData['text'],
                    'is_correct'  => $isCorrect,
                ]);
            }
        }

        return redirect()
            ->route('module3.teacher.index')
            ->with('success', 'Quiz created successfully!');
    }

    // Edit quiz page
    public function edit($id)
    {
        $quiz = Quiz::with('questions.choices')->findOrFail($id);
        return view('module3.teacher.edit', compact('quiz'));
    }

    // Update quiz + questions + choices
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'nullable|string',
            'time_limit'       => 'nullable|integer|min:0',
            'pass_mark'        => 'required|integer|min:0|max:100',
            'attempt_allowed'  => 'required|integer|min:1',
            'start_time'       => 'required|date',
            'end_time'         => 'nullable|date|after_or_equal:start_time',
            'questions'        => 'required|array|min:1',
        ]);

        $quiz = Quiz::findOrFail($id);

        $quiz->update([
            'title'            => $request->title,
            'description'      => $request->description,
            'time_limit'       => $request->time_limit,
            'pass_mark'        => $request->pass_mark,
            'attempts_allowed' => $request->attempt_allowed,
            'start_time'       => $request->start_time,
            'end_time'         => $request->end_time, // ✅ update end_time
        ]);

        foreach ($request->questions as $qData) {

            $question = isset($qData['id'])
                ? Question::findOrFail($qData['id'])
                : Question::create([
                    'quiz_id'       => $quiz->id,
                    'question_text' => $qData['text'],
                    'type'          => $qData['type'],
                    'points'        => $qData['points'],
                ]);

            $question->update([
                'question_text' => $qData['text'],
                'type'          => $qData['type'],
                'points'        => $qData['points'],
            ]);

            // Reset correct answers
            $question->choices()->update(['is_correct' => 0]);

            foreach ($qData['choices'] as $cData) {

                $choice = isset($cData['id'])
                    ? Choice::findOrFail($cData['id'])
                    : new Choice(['question_id' => $question->id]);

                $isCorrect = 0;
                if ($qData['type'] === 'single') {
                    if (isset($qData['correct_choice']) && $qData['correct_choice'] == ($cData['id'] ?? null)) {
                        $isCorrect = 1;
                    }
                } else {
                    $isCorrect = isset($cData['correct']) ? 1 : 0;
                }

                $choice->fill([
                    'choice_text' => $cData['text'],
                    'is_correct'  => $isCorrect,
                ])->save();
            }
        }

        return redirect()
            ->route('module3.teacher.index')
            ->with('success', 'Quiz updated successfully!');
    }

    // Delete quiz
    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);

        foreach ($quiz->questions as $question) {
            $question->choices()->delete();
        }

        $quiz->questions()->delete();
        $quiz->delete();

        return redirect()
            ->route('module3.teacher.index')
            ->with('success', 'Quiz deleted successfully!');
    }

    public function report($id)
    {
        $quiz = Quiz::with(['submissions.user'])
            ->findOrFail($id);

        return view('module3.teacher.report', compact('quiz'));
    }
}
