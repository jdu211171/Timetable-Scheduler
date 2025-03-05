<?php

use App\Models\Group;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('schedule has correct relationships to other models', function () {
    // Create necessary models
    $teacher = User::factory()->create(['role' => 'teacher']);
    $group = Group::factory()->create();
    $subject = Subject::factory()->create();
    $room = Room::factory()->create();

    // Create a schedule
    $schedule = Schedule::factory()->create([
        'subject_id' => $subject->id,
        'user_id' => $teacher->id,
        'group_id' => $group->id,
        'room_id' => $room->id,
        'pair' => 3,
        'week_day' => 'Mon',
        'date' => now()->format('Y-m-d'),
    ]);

    // Test schedule relationships
    expect($schedule->subject->id)->toBe($subject->id);
    expect($schedule->teacher->id)->toBe($teacher->id);
    expect($schedule->group->id)->toBe($group->id);
    expect($schedule->room->id)->toBe($room->id);
});

test('related models have correct inverse relationships to schedule', function () {
    // Create necessary models
    $teacher = User::factory()->create(['role' => 'teacher']);
    $group = Group::factory()->create();
    $subject = Subject::factory()->create();
    $room = Room::factory()->create();

    // Create a schedule
    $schedule = Schedule::factory()->create([
        'subject_id' => $subject->id,
        'user_id' => $teacher->id,
        'group_id' => $group->id,
        'room_id' => $room->id,
        'pair' => 3,
        'week_day' => 'Mon',
        'date' => now()->format('Y-m-d'),
    ]);

    // Test inverse relationships
    expect($subject->schedules->contains($schedule))->toBeTrue();
    expect($teacher->schedulesTaught->contains($schedule))->toBeTrue();
    expect($group->schedules->contains($schedule))->toBeTrue();
    expect($room->schedules->contains($schedule))->toBeTrue();
});

test('schedule can be retrieved with related models', function () {
    // Create necessary models
    $teacher = User::factory()->create(['role' => 'teacher', 'first_name' => 'John', 'last_name' => 'Doe']);
    $group = Group::factory()->create(['name' => 'Test Group']);
    $subject = Subject::factory()->create(['name' => 'Test Subject']);
    $room = Room::factory()->create(['name' => 'A101']);

    // Create a schedule
    $schedule = Schedule::factory()->create([
        'subject_id' => $subject->id,
        'user_id' => $teacher->id,
        'group_id' => $group->id,
        'room_id' => $room->id,
        'pair' => 3,
        'week_day' => 'Mon',
        'date' => now()->format('Y-m-d'),
    ]);

    // Retrieve schedule with related models
    $retrievedSchedule = Schedule::with(['subject', 'teacher', 'group', 'room'])->find($schedule->id);

    // Test eager loaded relationships
    expect($retrievedSchedule->subject->name)->toBe('Test Subject');
    expect($retrievedSchedule->teacher->first_name)->toBe('John');
    expect($retrievedSchedule->teacher->last_name)->toBe('Doe');
    expect($retrievedSchedule->group->name)->toBe('Test Group');
    expect($retrievedSchedule->room->name)->toBe('A101');
});
