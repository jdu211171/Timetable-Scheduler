<?php

use App\Models\Subject;
use App\Models\User;

test('authenticated user can update subject', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $token = $user->createToken('API Token')->plainTextToken;

    $subject = Subject::factory()->create(['name' => 'Biology']);

    $updateData = [
        'name' => 'Advanced Biology'
    ];

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->putJson('/api/subjects/' . $subject->id, $updateData);

    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $subject->id,
                'name' => 'Advanced Biology'
            ]
        ]);

    $this->assertDatabaseHas('subjects', [
        'id' => $subject->id,
        'name' => 'Advanced Biology'
    ]);
});
