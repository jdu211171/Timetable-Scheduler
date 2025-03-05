<?php

use App\Models\Group;
use App\Models\Subject;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('group can be associated with multiple subjects', function () {
    // Create group and subjects
    $group = Group::factory()->create();
    $subject1 = Subject::factory()->create(['name' => 'Chemistry']);
    $subject2 = Subject::factory()->create(['name' => 'Biology']);

    // Associate group with subjects
    $group->subjects()->attach([$subject1->id, $subject2->id]);

    // Test relationship from group to subjects
    expect($group->subjects)->toHaveCount(2);
    expect($group->subjects->contains($subject1))->toBeTrue();
    expect($group->subjects->contains($subject2))->toBeTrue();
});

test('subject can be associated with multiple groups', function () {
    // Create subject and groups
    $subject = Subject::factory()->create(['name' => 'Physics']);
    $group1 = Group::factory()->create(['name' => 'Group X']);
    $group2 = Group::factory()->create(['name' => 'Group Y']);

    // Associate subject with groups
    $subject->groups()->attach([$group1->id, $group2->id]);

    // Test relationship from subject to groups
    expect($subject->groups)->toHaveCount(2);
    expect($subject->groups->contains($group1))->toBeTrue();
    expect($subject->groups->contains($group2))->toBeTrue();
});

test('bidirectional relationship between groups and subjects works', function () {
    // Create group and subject
    $group = Group::factory()->create(['name' => 'Test Group']);
    $subject = Subject::factory()->create(['name' => 'Test Subject']);

    // Associate group with subject
    $group->subjects()->attach($subject->id);

    // Test both directions of the relationship
    expect($group->subjects)->toHaveCount(1);
    expect($group->subjects->first()->id)->toBe($subject->id);

    expect($subject->groups)->toHaveCount(1);
    expect($subject->groups->first()->id)->toBe($group->id);
});
