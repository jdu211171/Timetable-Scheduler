<?php

use App\Models\Group;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\User;

test('authenticated user can update schedule', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $token = $admin->createToken('API Token')->plainTextToken;

    $teacher = User::factory()->create(['role' => 'teacher']);
    $group = Group::factory()->create();
    $subject = Subject::factory()->create();
    $room = Room::factory()->create();
    $newRoom = Room::factory()->create();

    $schedule = Schedule::factory()->create([
        'subject_id' => $subject->id,
        'user_id' => $teacher->id,
        'group_id' => $group->id,
        'room_id' => $room->id,
        'pair' => 3,
        'week_day' => 'Mon',
        'date' => now()->format('Y-m-d'),
    ]);

    $updateData = [
        'subject_id' => $subject->id,
        'user_id' => $teacher->id,
        'group_id' => $group->id,
        'room_id' => $newRoom->id, // Change room
        'pair' => 4, // Change pair
        'week_day' => 'Wed', // Change day
        'date' => now()->addDays(1)->format('Y-m-d'), // Change date
    ];

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->putJson('/api/schedules/' . $schedule->id, $updateData);

    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $schedule->id,
                'subject_id' => $subject->id,
                'room_id' => $newRoom->id,
                'pair' => 4,
                'week_day' => 'Wed',
            ]
        ]);

    $this->assertDatabaseHas('schedules', [
        'id' => $schedule->id,
        'room_id' => $newRoom->id,
        'pair' => 4,
        'week_day' => 'Wed',
    ]);
});
