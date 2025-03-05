<?php

use App\Models\Group;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\User;

test('authenticated user can get single schedule', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $token = $admin->createToken('API Token')->plainTextToken;

    $teacher = User::factory()->create(['role' => 'teacher']);
    $group = Group::factory()->create();
    $subject = Subject::factory()->create();
    $room = Room::factory()->create();

    $schedule = Schedule::factory()->create([
        'subject_id' => $subject->id,
        'user_id' => $teacher->id,
        'group_id' => $group->id,
        'room_id' => $room->id,
        'pair' => 3,
        'week_day' => 'Mon',
        'date' => now()->format('Y-m-d'),
    ]);

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->getJson('/api/schedules/' . $schedule->id);

    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $schedule->id,
                'subject_id' => $subject->id,
                'user_id' => $teacher->id,
                'group_id' => $group->id,
                'room_id' => $room->id,
                'pair' => 3,
                'week_day' => 'Mon',
            ]
        ]);
});
