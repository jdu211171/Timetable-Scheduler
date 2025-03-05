<?php

use App\Models\Room;
use App\Models\User;

test('authenticated user can get all rooms', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $token = $user->createToken('API Token')->plainTextToken;

    Room::factory()->count(3)->create();

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->getJson('/api/rooms');

    $response->assertStatus(200)
        ->assertJsonCount(3, 'data');
});

test('unauthorized user cannot access rooms list', function () {
    $response = $this->getJson('/api/rooms');

    $response->assertStatus(401);
});
