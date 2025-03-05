<?php

use App\Models\Group;
use App\Models\User;

test('authenticated user can create group', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $token = $user->createToken('API Token')->plainTextToken;

    $groupData = [
        'name' => 'Test Group'
    ];

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->postJson('/api/groups', $groupData);

    $response->assertStatus(201)
        ->assertJson([
            'data' => [
                'name' => 'Test Group'
            ]
        ]);

    $this->assertDatabaseHas('groups', [
        'name' => 'Test Group'
    ]);
});

test('authenticated user cannot create group with duplicate name', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $token = $user->createToken('API Token')->plainTextToken;

    Group::factory()->create(['name' => 'Existing Group']);

    $groupData = [
        'name' => 'Existing Group'
    ];

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->postJson('/api/groups', $groupData);

    $response->assertStatus(422)
        ->assertJsonValidationErrors('name');
});
