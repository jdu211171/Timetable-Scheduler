<?php

use App\Models\User;

test('admin can update user', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $token = $admin->createToken('API Token')->plainTextToken;

    $user = User::factory()->create([
        'first_name' => 'Old',
        'last_name' => 'Name',
        'email' => 'old.name@example.com',
        'role' => 'student'
    ]);

    $updateData = [
        'first_name' => 'New',
        'last_name' => 'Name',
        'email' => 'new.name@example.com',
        'role' => 'student'
    ];

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->putJson('/api/users/' . $user->id, $updateData);

    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $user->id,
                'first_name' => 'New',
                'last_name' => 'Name',
                'email' => 'new.name@example.com'
            ]
        ]);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'first_name' => 'New',
        'last_name' => 'Name',
        'email' => 'new.name@example.com'
    ]);
});
