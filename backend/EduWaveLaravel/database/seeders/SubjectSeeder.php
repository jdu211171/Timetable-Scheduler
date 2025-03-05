<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create predefined subjects
        $subjects = [
            'Mathematics 101',
            'Computer Science Fundamentals',
            'Physics 101',
            'Biology 101',
            'Chemistry 101',
            'Software Engineering 202',
            'Network Security 303',
            'Database Systems 202',
            'Artificial Intelligence 303',
            'Machine Learning Fundamentals',
        ];

        foreach ($subjects as $subject) {
            Subject::factory()->create([
                'name' => $subject,
            ]);
        }

        // Create some random subjects
        Subject::factory()->count(5)->create();
    }
}
