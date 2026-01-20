<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Choice;
use Carbon\Carbon;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        $quizzes = [

            // QUIZ 1
            [
                'title' => 'Algebra Basics',
                'description' => 'Introduction to simple algebraic expressions.',
                'questions' => [
                    [
                        'text' => 'Solve: 2x + 4 = 10',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => 'x = 3', 'correct' => true],
                            ['text' => 'x = 2', 'correct' => false],
                            ['text' => 'x = 6', 'correct' => false],
                            ['text' => 'x = 4', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Which are linear equations?',
                        'type' => 'multiple',
                        'points' => 10,
                        'choices' => [
                            ['text' => 'y = 2x + 1', 'correct' => true],
                            ['text' => 'x² = 4', 'correct' => false],
                            ['text' => '3x - 5 = 0', 'correct' => true],
                            ['text' => 'y = x³', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Find x: x - 7 = 5',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '12', 'correct' => true],
                            ['text' => '2', 'correct' => false],
                            ['text' => '-2', 'correct' => false],
                            ['text' => '7', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Solve: 3x = 15',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '5', 'correct' => true],
                            ['text' => '3', 'correct' => false],
                            ['text' => '15', 'correct' => false],
                            ['text' => '10', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Which values satisfy x + 2 = 6?',
                        'type' => 'multiple',
                        'points' => 10,
                        'choices' => [
                            ['text' => 'x = 4', 'correct' => true],
                            ['text' => 'x = 6', 'correct' => false],
                            ['text' => 'x = -4', 'correct' => false],
                            ['text' => 'x = 5', 'correct' => false],
                        ],
                    ],
                ],
            ],

            // QUIZ 2
            [
                'title' => 'Fractions & Decimals',
                'description' => 'Operations with fractions and decimals.',
                'questions' => [
                    [
                        'text' => 'Simplify 6/9',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '2/3', 'correct' => true],
                            ['text' => '3/6', 'correct' => false],
                            ['text' => '1/3', 'correct' => false],
                            ['text' => '4/6', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Which equal 0.75?',
                        'type' => 'multiple',
                        'points' => 10,
                        'choices' => [
                            ['text' => '3/4', 'correct' => true],
                            ['text' => '75%', 'correct' => true],
                            ['text' => '1/2', 'correct' => false],
                            ['text' => '6/8', 'correct' => true],
                        ],
                    ],
                    [
                        'text' => '0.5 + 0.25 = ?',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '0.75', 'correct' => true],
                            ['text' => '0.5', 'correct' => false],
                            ['text' => '0.25', 'correct' => false],
                            ['text' => '1.0', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Convert 1/4 to decimal',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '0.25', 'correct' => true],
                            ['text' => '0.4', 'correct' => false],
                            ['text' => '0.5', 'correct' => false],
                            ['text' => '0.75', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Which are proper fractions?',
                        'type' => 'multiple',
                        'points' => 10,
                        'choices' => [
                            ['text' => '3/5', 'correct' => true],
                            ['text' => '7/4', 'correct' => false],
                            ['text' => '1/2', 'correct' => true],
                            ['text' => '9/3', 'correct' => false],
                        ],
                    ],
                ],
            ],

            // QUIZ 3
            [
                'title' => 'Geometry Basics',
                'description' => 'Shapes, angles and polygons.',
                'questions' => [
                    [
                        'text' => 'Sum of angles in a triangle?',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '180°', 'correct' => true],
                            ['text' => '360°', 'correct' => false],
                            ['text' => '90°', 'correct' => false],
                            ['text' => '270°', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Which are quadrilaterals?',
                        'type' => 'multiple',
                        'points' => 10,
                        'choices' => [
                            ['text' => 'Square', 'correct' => true],
                            ['text' => 'Triangle', 'correct' => false],
                            ['text' => 'Rectangle', 'correct' => true],
                            ['text' => 'Circle', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Right angle equals?',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '90°', 'correct' => true],
                            ['text' => '45°', 'correct' => false],
                            ['text' => '180°', 'correct' => false],
                            ['text' => '60°', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'How many sides does a hexagon have?',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '6', 'correct' => true],
                            ['text' => '5', 'correct' => false],
                            ['text' => '7', 'correct' => false],
                            ['text' => '8', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Select all triangles',
                        'type' => 'multiple',
                        'points' => 10,
                        'choices' => [
                            ['text' => 'Equilateral', 'correct' => true],
                            ['text' => 'Isosceles', 'correct' => true],
                            ['text' => 'Square', 'correct' => false],
                            ['text' => 'Scalene', 'correct' => true],
                        ],
                    ],
                ],
            ],
            
            //QUIZ 4
            [
                'title' => 'Percentage',
                'description' => 'Understanding percentage calculations and applications.',
                'questions' => [
                    [
                        'text' => 'What is 20% of 150?',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '30', 'correct' => true],
                            ['text' => '25', 'correct' => false],
                            ['text' => '35', 'correct' => false],
                            ['text' => '40', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Which of the following are equal to 75%?',
                        'type' => 'multiple',
                        'points' => 10,
                        'choices' => [
                            ['text' => '3/4', 'correct' => true],
                            ['text' => '0.75', 'correct' => true],
                            ['text' => '75/10', 'correct' => false],
                            ['text' => '150%', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'If a shirt costs RM80 and is discounted by 25%, what is the new price?',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => 'RM60', 'correct' => true],
                            ['text' => 'RM55', 'correct' => false],
                            ['text' => 'RM65', 'correct' => false],
                            ['text' => 'RM70', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Which situations involve percentage increase?',
                        'type' => 'multiple',
                        'points' => 10,
                        'choices' => [
                            ['text' => 'Price increases from RM50 to RM60', 'correct' => true],
                            ['text' => 'Score improves from 70 to 85', 'correct' => true],
                            ['text' => 'Weight drops from 60kg to 55kg', 'correct' => false],
                            ['text' => 'Discount applied on original price', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'If a shirt costs RM80 after a 20% discount, what was the original price?',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => 'RM100', 'correct' => true],
                            ['text' => 'RM96', 'correct' => false],
                            ['text' => 'RM90', 'correct' => false],
                            ['text' => 'RM120', 'correct' => false],
                        ],
                    ],
                ],
            ],

            //QUIZ 5
            [
                'title' => 'Simple Equations',
                'description' => 'Solve basic linear equations involving one variable.',
                'questions' => [
                    [
                        'text' => 'Solve: x + 7 = 12',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => 'x = 5', 'correct' => true],
                            ['text' => 'x = 7', 'correct' => false],
                            ['text' => 'x = 12', 'correct' => false],
                            ['text' => 'x = 19', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Solve: 2x = 10',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => 'x = 5', 'correct' => true],
                            ['text' => 'x = 10', 'correct' => false],
                            ['text' => 'x = 2', 'correct' => false],
                            ['text' => 'x = 20', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Solve: 3x - 6 = 0',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => 'x = 2', 'correct' => true],
                            ['text' => 'x = 6', 'correct' => false],
                            ['text' => 'x = -2', 'correct' => false],
                            ['text' => 'x = 3', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Solve: x/4 = 3',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => 'x = 12', 'correct' => true],
                            ['text' => 'x = 7', 'correct' => false],
                            ['text' => 'x = 4', 'correct' => false],
                            ['text' => 'x = 3', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Solve: 5 + x = 9',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => 'x = 4', 'correct' => true],
                            ['text' => 'x = 14', 'correct' => false],
                            ['text' => 'x = 5', 'correct' => false],
                            ['text' => 'x = 9', 'correct' => false],
                        ],
                    ],
                ],
            ],

            //QUIZ 6
            [
                'title' => 'Integers',
                'description' => 'Operations involving positive and negative integers.',
                'questions' => [
                    [
                        'text' => 'Calculate: -4 + 9',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '5', 'correct' => true],
                            ['text' => '-5', 'correct' => false],
                            ['text' => '13', 'correct' => false],
                            ['text' => '-13', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Calculate: 6 - 11',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '-5', 'correct' => true],
                            ['text' => '5', 'correct' => false],
                            ['text' => '-17', 'correct' => false],
                            ['text' => '17', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Calculate: -3 × 4',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '-12', 'correct' => true],
                            ['text' => '12', 'correct' => false],
                            ['text' => '-7', 'correct' => false],
                            ['text' => '7', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Calculate: -20 ÷ 5',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '-4', 'correct' => true],
                            ['text' => '4', 'correct' => false],
                            ['text' => '-15', 'correct' => false],
                            ['text' => '15', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Calculate: 7 + (-2)',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '5', 'correct' => true],
                            ['text' => '-5', 'correct' => false],
                            ['text' => '9', 'correct' => false],
                            ['text' => '-9', 'correct' => false],
                        ],
                    ],
                ],
            ],

            //QUIZ 7
            [
                'title' => 'Geometry',
                'description' => 'Basic geometry concepts involving angles and shapes.',
                'questions' => [
                    [
                        'text' => 'Sum of angles in a triangle is?',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '180°', 'correct' => true],
                            ['text' => '360°', 'correct' => false],
                            ['text' => '90°', 'correct' => false],
                            ['text' => '270°', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'A square has how many equal sides?',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '4', 'correct' => true],
                            ['text' => '2', 'correct' => false],
                            ['text' => '3', 'correct' => false],
                            ['text' => '5', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'A right angle equals?',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '90°', 'correct' => true],
                            ['text' => '45°', 'correct' => false],
                            ['text' => '180°', 'correct' => false],
                            ['text' => '60°', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Which shape has no sides?',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => 'Circle', 'correct' => true],
                            ['text' => 'Triangle', 'correct' => false],
                            ['text' => 'Square', 'correct' => false],
                            ['text' => 'Rectangle', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'A rectangle has how many right angles?',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '4', 'correct' => true],
                            ['text' => '2', 'correct' => false],
                            ['text' => '3', 'correct' => false],
                            ['text' => '1', 'correct' => false],
                        ],
                    ],
                ],
            ],

            //QUIZ 8
            [
                'title' => 'Probability',
                'description' => 'Basic probability concepts.',
                'questions' => [
                    [
                        'text' => 'Probability value range is?',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '0 to 1', 'correct' => true],
                            ['text' => '1 to 10', 'correct' => false],
                            ['text' => '-1 to 1', 'correct' => false],
                            ['text' => '0 to 100', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Probability of getting tails in a fair coin?',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '1/2', 'correct' => true],
                            ['text' => '1', 'correct' => false],
                            ['text' => '1/6', 'correct' => false],
                            ['text' => '0', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Total outcomes when rolling a die?',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '6', 'correct' => true],
                            ['text' => '4', 'correct' => false],
                            ['text' => '8', 'correct' => false],
                            ['text' => '10', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Probability of impossible event?',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '0', 'correct' => true],
                            ['text' => '1', 'correct' => false],
                            ['text' => '1/2', 'correct' => false],
                            ['text' => 'Undefined', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Probability of certain event?',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '1', 'correct' => true],
                            ['text' => '0', 'correct' => false],
                            ['text' => '1/2', 'correct' => false],
                            ['text' => '2', 'correct' => false],
                        ],
                    ],
                ],
            ],

            //QUIZ 9
            [
                'title' => 'Statistics',
                'description' => 'Mean, median, and mode basics.',
                'questions' => [
                    [
                        'text' => 'Mean of 2, 4, 6?',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '4', 'correct' => true],
                            ['text' => '6', 'correct' => false],
                            ['text' => '2', 'correct' => false],
                            ['text' => '3', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Median of 1, 3, 5?',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '3', 'correct' => true],
                            ['text' => '1', 'correct' => false],
                            ['text' => '5', 'correct' => false],
                            ['text' => '4', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Mode of 2, 2, 3?',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '2', 'correct' => true],
                            ['text' => '3', 'correct' => false],
                            ['text' => '5', 'correct' => false],
                            ['text' => '0', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Range is?',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => 'Highest minus lowest', 'correct' => true],
                            ['text' => 'Average', 'correct' => false],
                            ['text' => 'Middle value', 'correct' => false],
                            ['text' => 'Most frequent', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Mean is also called?',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => 'Average', 'correct' => true],
                            ['text' => 'Middle', 'correct' => false],
                            ['text' => 'Mode', 'correct' => false],
                            ['text' => 'Range', 'correct' => false],
                        ],
                    ],
                ],
            ],

            //QUIZ 10
            [
                'title' => 'Mixed Revision',
                'description' => 'Mixed questions from various topics.',
                'questions' => [
                    [
                        'text' => 'What is 20% of 50?',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '10', 'correct' => true],
                            ['text' => '20', 'correct' => false],
                            ['text' => '5', 'correct' => false],
                            ['text' => '15', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Solve: x - 3 = 7',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => 'x = 10', 'correct' => true],
                            ['text' => 'x = 4', 'correct' => false],
                            ['text' => 'x = 7', 'correct' => false],
                            ['text' => 'x = 3', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'A square has area 16. Side length?',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '4', 'correct' => true],
                            ['text' => '8', 'correct' => false],
                            ['text' => '2', 'correct' => false],
                            ['text' => '16', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Probability of rain tomorrow is example of?',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => 'Probability', 'correct' => true],
                            ['text' => 'Ratio', 'correct' => false],
                            ['text' => 'Equation', 'correct' => false],
                            ['text' => 'Geometry', 'correct' => false],
                        ],
                    ],
                    [
                        'text' => 'Mean of 5, 5, 5?',
                        'type' => 'single',
                        'points' => 5,
                        'choices' => [
                            ['text' => '5', 'correct' => true],
                            ['text' => '15', 'correct' => false],
                            ['text' => '0', 'correct' => false],
                            ['text' => '10', 'correct' => false],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($quizzes as $index => $quizData) {

            // Week-based schedule (1 quiz per week)
            $startTime = Carbon::create(2025, 12, 1, 10, 0, 0)->addWeeks($index);
            $endTime   = (clone $startTime)->addDay(); // +24 hours

            $quiz = Quiz::create([
                'title' => $quizData['title'],
                'description' => $quizData['description'],
                'time_limit' => 10,
                'pass_mark' => 50,
                'attempts_allowed' => 3,
                'start_time' => $startTime,
                'end_time' => $endTime,
            ]);

            foreach ($quizData['questions'] as $q) {
                $question = Question::create([
                    'quiz_id' => $quiz->id,
                    'question_text' => $q['text'],
                    'type' => $q['type'],
                    'points' => $q['points'],
                ]);

                foreach ($q['choices'] as $c) {
                    Choice::create([
                        'question_id' => $question->id,
                        'choice_text' => $c['text'],
                        'is_correct' => $c['correct'],
                    ]);
                }
            }
        }
    }
}
