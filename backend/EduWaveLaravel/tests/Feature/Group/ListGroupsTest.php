<?php

use App\Models\Group;
use App\Models\User;

test('authenticated user can get all groups', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $token = $user->createToken('API Token')->plainTextToken;

    Group::factory()->count(3)->create();

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->getJson('/api/groups');

    $response->assertStatus(200)
        ->assertJsonCount(3, 'data');
});

test('unauthorized user cannot access groups list', function () {
    $response = $this->getJson('/api/groups');

    $response->assertStatus(401);
});
