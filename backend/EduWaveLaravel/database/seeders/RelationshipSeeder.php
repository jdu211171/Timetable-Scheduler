<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;

class RelationshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * This seeder sets up the many-to-many relationships between entities.
     */
    public function run(): void
    {
        // Get all models
        $students = User::where('role', 'student')->get();
        $teachers = User::where('role', 'teacher')->get();
        $groups = Group::all();
        $subjects = Subject::all();

        // Assign students to groups (each student belongs to 1-2 groups)
        foreach ($students as $student) {
            $studentGroups = $groups->random(rand(1, 2));
            $student->groups()->attach($studentGroups->pluck('id')->toArray());
        }

        // Assign teachers to subjects (each teacher can teach 1-3 subjects)
        foreach ($teachers as $teacher) {
            $teacherSubjects = $subjects->random(rand(1, 3));
            $teacher->subjectsTaught()->attach($teacherSubjects->pluck('id')->toArray());
        }

        // Assign subjects to groups (each group studies 3-7 subjects)
        foreach ($groups as $group) {
            $groupSubjects = $subjects->random(rand(3, 7));
            $group->subjects()->attach($groupSubjects->pluck('id')->toArray());
        }
    }
}
