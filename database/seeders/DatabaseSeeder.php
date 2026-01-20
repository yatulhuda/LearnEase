<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create 2 teachers
        User::factory()->count(2)->create(['role' => 'teacher']);

        // Create 10 students
        User::factory()->count(10)->create(['role' => 'student']);

        // Seed quizzes and submissions
        $this->call([
            QuizSeeder::class,
            SubmissionSeeder::class,
        ]);
    }
}
