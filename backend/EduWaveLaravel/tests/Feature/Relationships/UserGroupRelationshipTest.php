<?php

use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('student can be associated with multiple groups', function () {
    // Create user and groups
    $student = User::factory()->create(['role' => 'student']);
    $group1 = Group::factory()->create(['name' => 'Group A']);
    $group2 = Group::factory()->create(['name' => 'Group B']);

    // Associate student with groups
    $student->groups()->attach([$group1->id, $group2->id]);

    // Test relationship from student to groups
    expect($student->groups)->toHaveCount(2);
    expect($student->groups->contains($group1))->toBeTrue();
    expect($student->groups->contains($group2))->toBeTrue();
});

test('group can be associated with multiple students', function () {
    // Create group and users
    $group = Group::factory()->create(['name' => 'Test Group']);
    $student1 = User::factory()->create(['role' => 'student']);
    $student2 = User::factory()->create(['role' => 'student']);

    // Associate group with students
    $group->users()->attach([$student1->id, $student2->id]);

    // Test relationship from group to students
    expect($group->users)->toHaveCount(2);
    expect($group->users->contains($student1))->toBeTrue();
    expect($group->users->contains($student2))->toBeTrue();
});

test('bidirectional relationship between users and groups works', function () {
    // Create user and group
    $student = User::factory()->create(['role' => 'student']);
    $group = Group::factory()->create(['name' => 'Test Group']);

    // Associate student with group
    $student->groups()->attach($group->id);

    // Test both directions of the relationship
    expect($student->groups)->toHaveCount(1);
    expect($student->groups->first()->id)->toBe($group->id);

    expect($group->users)->toHaveCount(1);
    expect($group->users->first()->id)->toBe($student->id);
});
