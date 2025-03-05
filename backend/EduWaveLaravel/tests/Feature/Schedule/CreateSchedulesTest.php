<?php

use App\Models\Group;
use App\Models\Room;
use App\Models\Subject;
use App\Models\User;

test('authenticated user can create schedule', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $token = $admin->createToken('API Token')->plainTextToken;

    $teacher = User::factory()->create(['role' => 'teacher']);
    $group = Group::factory()->create();
    $subject = Subject::factory()->create();
    $room = Room::factory()->create();

    $scheduleData = [
        'subject_id' => $subject->id,
        'user_id' => $teacher->id,
        'group_id' => $group->id,
        'room_id' => $room->id,
        'pair' => 2,
        'week_day' => 'Tue',
        'date' => now()->format('Y-m-d'),
    ];

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->postJson('/api/schedules', $scheduleData);

    $response->assertStatus(201)
        ->assertJson([
            'data' => [
                'subject_id' => $subject->id,
                'user_id' => $teacher->id,
                'group_id' => $group->id,
                'room_id' => $room->id,
                'pair' => 2,
                'week_day' => 'Tue',
            ]
        ]);

    $this->assertDatabaseHas('schedules', [
        'subject_id' => $subject->id,
        'user_id' => $teacher->id,
        'group_id' => $group->id,
        'room_id' => $room->id,
        'pair' => 2,
        'week_day' => 'Tue',
    ]);
});

test('authenticated user cannot create schedule with student as teacher', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $token = $admin->createToken('API Token')->plainTextToken;

    $student = User::factory()->create(['role' => 'student']);
    $group = Group::factory()->create();
    $subject = Subject::factory()->create();
    $room = Room::factory()->create();

    $scheduleData = [
        'subject_id' => $subject->id,
        'user_id' => $student->id, // Student, not a teacher
        'group_id' => $group->id,
        'room_id' => $room->id,
        'pair' => 2,
        'week_day' => 'Tue',
        'date' => now()->format('Y-m-d'),
    ];

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->postJson('/api/schedules', $scheduleData);

    $response->assertStatus(422)
        ->assertJsonValidationErrors('user_id');
});

test('authenticated user cannot create schedule with invalid pair', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $token = $admin->createToken('API Token')->plainTextToken;

    $teacher = User::factory()->create(['role' => 'teacher']);
    $group = Group::factory()->create();
    $subject = Subject::factory()->create();
    $room = Room::factory()->create();

    $scheduleData = [
        'subject_id' => $subject->id,
        'user_id' => $teacher->id,
        'group_id' => $group->id,
        'room_id' => $room->id,
        'pair' => 12, // Invalid pair (out of range 1-9)
        'week_day' => 'Tue',
        'date' => now()->format('Y-m-d'),
    ];

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->postJson('/api/schedules', $scheduleData);

    $response->assertStatus(422)
        ->assertJsonValidationErrors('pair');
});
