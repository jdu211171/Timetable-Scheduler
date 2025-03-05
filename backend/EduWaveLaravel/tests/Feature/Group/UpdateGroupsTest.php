<?php

use App\Models\Group;
use App\Models\User;

test('authenticated user can update group', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $token = $user->createToken('API Token')->plainTextToken;

    $group = Group::factory()->create();

    $updateData = [
        'name' => 'Updated Group Name'
    ];

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->putJson('/api/groups/' . $group->id, $updateData);

    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $group->id,
                'name' => 'Updated Group Name'
            ]
        ]);

    $this->assertDatabaseHas('groups', [
        'id' => $group->id,
        'name' => 'Updated Group Name'
    ]);
});
