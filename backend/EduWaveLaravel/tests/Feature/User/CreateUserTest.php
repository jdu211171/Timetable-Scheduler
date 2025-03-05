<?php

use App\Models\User;

test('admin can create user', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $token = $admin->createToken('API Token')->plainTextToken;

    $userData = [
        'first_name' => 'Jane',
        'last_name' => 'Smith',
        'email' => 'jane.smith@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => 'teacher',
    ];

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->postJson('/api/users', $userData);

    $response->assertStatus(201)
        ->assertJson([
            'data' => [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane.smith@example.com',
                'role' => 'teacher'
            ]
        ]);

    $this->assertDatabaseHas('users', [
        'first_name' => 'Jane',
        'last_name' => 'Smith',
        'email' => 'jane.smith@example.com',
        'role' => 'teacher'
    ]);
});

test('admin cannot create user with duplicate email', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $token = $admin->createToken('API Token')->plainTextToken;

    User::factory()->create([
        'email' => 'existing@example.com'
    ]);

    $userData = [
        'first_name' => 'Duplicate',
        'last_name' => 'User',
        'email' => 'existing@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => 'student',
    ];

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->postJson('/api/users', $userData);

    $response->assertStatus(422)
        ->assertJsonValidationErrors('email');
});

test('admin can create student with unique id', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $token = $admin->createToken('API Token')->plainTextToken;

    $userData = [
        'first_name' => 'Student',
        'last_name' => 'One',
        'email' => 'student.one@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => 'student',
        'unique_id' => 'ST12345'
    ];

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->postJson('/api/users', $userData);

    $response->assertStatus(201);

    $this->assertDatabaseHas('users', [
        'email' => 'student.one@example.com',
        'unique_id' => 'ST12345'
    ]);
});
