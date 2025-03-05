<?php

use App\Models\Subject;
use App\Models\User;

test('authenticated user can get all subjects', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $token = $user->createToken('API Token')->plainTextToken;

    Subject::factory()->count(3)->create();

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->getJson('/api/subjects');

    $response->assertStatus(200)
        ->assertJsonCount(3, 'data');
});

test('unauthorized user cannot access subjects list', function () {
    $response = $this->getJson('/api/subjects');

    $response->assertStatus(401);
});
