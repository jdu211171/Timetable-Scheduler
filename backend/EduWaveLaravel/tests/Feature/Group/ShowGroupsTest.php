<?php

use App\Models\Group;
use App\Models\User;

test('authenticated user can get single group', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $token = $user->createToken('API Token')->plainTextToken;

    $group = Group::factory()->create();

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->getJson('/api/groups/' . $group->id);

    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $group->id,
                'name' => $group->name,
            ]
        ]);
});
