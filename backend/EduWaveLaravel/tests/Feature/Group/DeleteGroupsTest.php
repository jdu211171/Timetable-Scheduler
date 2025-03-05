<?php

use App\Models\Group;
use App\Models\User;

test('authenticated user can delete group', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $token = $user->createToken('API Token')->plainTextToken;

    $group = Group::factory()->create();

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->deleteJson('/api/groups/' . $group->id);

    $response->assertStatus(204);

    $this->assertDatabaseMissing('groups', [
        'id' => $group->id
    ]);
});
