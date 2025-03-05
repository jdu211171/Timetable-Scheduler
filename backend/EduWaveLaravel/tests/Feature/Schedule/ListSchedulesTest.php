<?php

use App\Models\Group;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\User;

test('authenticated user can get all schedules', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $token = $admin->createToken('API Token')->plainTextToken;

    $teacher = User::factory()->create(['role' => 'teacher']);
    $group = Group::factory()->create();
    $subject = Subject::factory()->create();
    $room = Room::factory()->create();

    Schedule::factory()->count(3)->create([
        'subject_id' => $subject->id,
        'user_id' => $teacher->id,
        'group_id' => $group->id,
        'room_id' => $room->id,
    ]);

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->getJson('/api/schedules');

    $response->assertStatus(200)
        ->assertJsonCount(3, 'data');
});

test('unauthorized user cannot access schedules list', function () {
    $response = $this->getJson('/api/schedules');

    $response->assertStatus(401);
});
