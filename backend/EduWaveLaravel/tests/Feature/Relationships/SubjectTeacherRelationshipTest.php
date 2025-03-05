<?php

use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('teacher can be associated with multiple subjects', function () {
    // Create teacher and subjects
    $teacher = User::factory()->create(['role' => 'teacher']);
    $subject1 = Subject::factory()->create(['name' => 'Math']);
    $subject2 = Subject::factory()->create(['name' => 'Physics']);

    // Associate teacher with subjects
    $teacher->subjectsTaught()->attach([$subject1->id, $subject2->id]);

    // Test relationship from teacher to subjects
    expect($teacher->subjectsTaught)->toHaveCount(2);
    expect($teacher->subjectsTaught->contains($subject1))->toBeTrue();
    expect($teacher->subjectsTaught->contains($subject2))->toBeTrue();
});

test('subject can be associated with multiple teachers', function () {
    // Create subject and teachers
    $subject = Subject::factory()->create(['name' => 'Chemistry']);
    $teacher1 = User::factory()->create(['role' => 'teacher']);
    $teacher2 = User::factory()->create(['role' => 'teacher']);

    // Associate subject with teachers
    $subject->teachers()->attach([$teacher1->id, $teacher2->id]);

    // Test relationship from subject to teachers
    expect($subject->teachers)->toHaveCount(2);
    expect($subject->teachers->contains($teacher1))->toBeTrue();
    expect($subject->teachers->contains($teacher2))->toBeTrue();
});

test('multiple teachers can teach the same subject', function () {
    // Create teachers and subject
    $teacher1 = User::factory()->create(['role' => 'teacher']);
    $teacher2 = User::factory()->create(['role' => 'teacher']);
    $subject = Subject::factory()->create(['name' => 'Biology']);

    // Associate teachers with subject
    $teacher1->subjectsTaught()->attach($subject->id);
    $teacher2->subjectsTaught()->attach($subject->id);

    // Test relationships
    expect($subject->teachers)->toHaveCount(2);
    expect($subject->teachers->contains($teacher1))->toBeTrue();
    expect($subject->teachers->contains($teacher2))->toBeTrue();
});
