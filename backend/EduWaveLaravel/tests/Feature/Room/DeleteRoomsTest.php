<?php

use App\Models\Room;
use App\Models\User;

test('authenticated user can delete room', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $token = $user->createToken('API Token')->plainTextToken;

    $room = Room::factory()->create();

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->deleteJson('/api/rooms/' . $room->id);

    $response->assertStatus(204);

    $this->assertDatabaseMissing('rooms', [
        'id' => $room->id
    ]);
});
