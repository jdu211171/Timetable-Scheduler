<?php

use App\Models\Subject;
use App\Models\User;

test('authenticated user can create subject', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $token = $user->createToken('API Token')->plainTextToken;

    $subjectData = [
        'name' => 'Mathematics'
    ];

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->postJson('/api/subjects', $subjectData);

    $response->assertStatus(201)
        ->assertJson([
            'data' => [
                'name' => 'Mathematics'
            ]
        ]);

    $this->assertDatabaseHas('subjects', [
        'name' => 'Mathematics'
    ]);
});

test('authenticated user cannot create subject with duplicate name', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $token = $user->createToken('API Token')->plainTextToken;

    Subject::factory()->create(['name' => 'Physics']);

    $subjectData = [
        'name' => 'Physics'
    ];

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->postJson('/api/subjects', $subjectData);

    $response->assertStatus(422)
        ->assertJsonValidationErrors('name');
});
