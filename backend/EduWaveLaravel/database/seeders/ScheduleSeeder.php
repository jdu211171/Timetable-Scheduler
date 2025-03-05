<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing models
        $teachers = User::where('role', 'teacher')->get();
        $groups = Group::all();
        $subjects = Subject::all();
        $rooms = Room::all();

        // Days of the week
        $weekDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'];

        // Create schedules for each group
        foreach ($groups as $group) {
            // Each group has 3-5 subjects
            $groupSubjects = $subjects->random(rand(3, 5));

            foreach ($groupSubjects as $subject) {
                // Assign a random teacher to each subject
                $teacher = $teachers->random();

                // Create 1-3 schedules for each subject for different days
                $scheduleDays = collect($weekDays)->random(rand(1, 3))->unique()->toArray();

                foreach ($scheduleDays as $day) {
                    $data = [
                        'subject_id' => $subject->id,
                        'user_id' => $teacher->id,
                        'group_id' => $group->id,
                        'room_id' => $rooms->random()->id,
                        'pair' => rand(1, 5),
                        'week_day' => $day,
                        'date' => now()->addDays(rand(0, 30))->format('Y-m-d'),
                    ];

                    Schedule::firstOrCreate(
                        [
                            'subject_id' => $data['subject_id'],
                            'user_id' => $data['user_id'],
                            'group_id' => $data['group_id'],
                            'room_id' => $data['room_id'],
                            'pair' => $data['pair'],
                        ],
                        $data
                    );
                }
            }
        }

        // Create some additional random schedules
        Schedule::factory()->count(10)->create();
    }
}
