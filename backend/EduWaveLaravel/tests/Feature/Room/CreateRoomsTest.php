<?php

use App\Models\Room;
use App\Models\User;

test('authenticated user can create room', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $token = $user->createToken('API Token')->plainTextToken;

    $roomData = [
        'name' => 'Test Room'
    ];

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->postJson('/api/rooms', $roomData);

    $response->assertStatus(201)
        ->assertJson([
            'data' => [
                'name' => 'Test Room'
            ]
        ]);

    $this->assertDatabaseHas('rooms', [
        'name' => 'Test Room'
    ]);
});

test('authenticated user cannot create room with duplicate name', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $token = $user->createToken('API Token')->plainTextToken;

    Room::factory()->create(['name' => 'Existing Room']);

    $roomData = [
        'name' => 'Existing Room'
    ];

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->postJson('/api/rooms', $roomData);

    $response->assertStatus(422)
        ->assertJsonValidationErrors('name');
});
