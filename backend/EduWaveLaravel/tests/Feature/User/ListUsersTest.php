<?php

use App\Models\User;

test('admin can get all users', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $token = $admin->createToken('API Token')->plainTextToken;

    User::factory()->count(3)->create();

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->getJson('/api/users');

    $response->assertStatus(200)
        ->assertJsonCount(4, 'data'); // 3 + admin
});

test('unauthorized user cannot access users list', function () {
    $response = $this->getJson('/api/users');

    $response->assertStatus(401);
});
