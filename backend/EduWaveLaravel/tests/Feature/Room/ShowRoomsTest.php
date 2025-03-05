<?php

use App\Models\Room;
use App\Models\User;

test('authenticated user can get single room', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $token = $user->createToken('API Token')->plainTextToken;

    $room = Room::factory()->create();

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->getJson('/api/rooms/' . $room->id);

    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $room->id,
                'name' => $room->name,
            ]
        ]);
});
