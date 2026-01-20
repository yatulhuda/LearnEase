<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Quiz;
use App\Models\QuizSubmission;
use App\Models\QuizAnswer;
use Carbon\Carbon;

class SubmissionSeeder extends Seeder
{
    public function run(): void
    {
        $students = User::where('role', 'student')->get(); // students
        $quizzes = Quiz::all(); // quizzes

        foreach ($quizzes as $quiz) {
            $submissionCount = 0;

            // Shuffle students for randomness
            $shuffledStudents = $students->shuffle();

            foreach ($shuffledStudents as $student) {

                // Ensure at least 5 submissions per quiz
                if ($submissionCount >= 5) {
                    break;
                }

                // Prevent duplicate submissions
                if (
                    QuizSubmission::where('user_id', $student->id)
                        ->where('quiz_id', $quiz->id)
                        ->exists()
                ) {
                    continue;
                }

                // Generate random submission time BETWEEN quiz start & end
                $startTime = Carbon::parse($quiz->start_time);
                $endTime   = Carbon::parse($quiz->end_time);

                $submissionTime = Carbon::createFromTimestamp(
                    rand($startTime->timestamp, $endTime->timestamp)
                );

                $score = rand(30, 100);
                $percentage = $score;
                $isPass = $percentage >= $quiz->pass_mark;

                $submission = QuizSubmission::create([
                    'quiz_id'     => $quiz->id,
                    'user_id'     => $student->id,
                    'score'       => $score,
                    'percentage'  => $percentage,
                    'is_pass'     => $isPass,
                    'created_at'  => $submissionTime,
                    'updated_at'  => $submissionTime,
                ]);

                // Create answers for each question
                foreach ($quiz->questions as $question) {

                    $selected = [];

                    foreach ($question->choices as $choice) {
                        if ($choice->is_correct && rand(0, 1)) {
                            $selected[] = $choice->id;
                        }
                    }

                    QuizAnswer::create([
                        'submission_id'   => $submission->id,
                        'question_id'     => $question->id,
                        'selected_choices'=> $selected,
                        'created_at'      => $submissionTime,
                        'updated_at'      => $submissionTime,
                    ]);
                }

                $submissionCount++;
            }
        }
    }
}
