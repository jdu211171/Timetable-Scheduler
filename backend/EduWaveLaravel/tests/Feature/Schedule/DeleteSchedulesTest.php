<?php

use App\Models\Group;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\User;

test('authenticated user can delete schedule', function () {
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
    ]);

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->deleteJson('/api/schedules/' . $schedule->id);

    $response->assertStatus(204);

    $this->assertDatabaseMissing('schedules', [
        'id' => $schedule->id
    ]);
});
