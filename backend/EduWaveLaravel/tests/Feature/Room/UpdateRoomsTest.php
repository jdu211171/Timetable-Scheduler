<?php

use App\Models\Room;
use App\Models\User;

test('authenticated user can update room', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $token = $user->createToken('API Token')->plainTextToken;

    $room = Room::factory()->create();

    $updateData = [
        'name' => 'Updated Room Name'
    ];

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->putJson('/api/rooms/' . $room->id, $updateData);

    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $room->id,
                'name' => 'Updated Room Name'
            ]
        ]);

    $this->assertDatabaseHas('rooms', [
        'id' => $room->id,
        'name' => 'Updated Room Name'
    ]);
});
