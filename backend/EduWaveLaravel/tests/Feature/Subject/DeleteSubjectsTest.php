<?php

use App\Models\Subject;
use App\Models\User;

test('authenticated user can delete subject', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $token = $user->createToken('API Token')->plainTextToken;

    $subject = Subject::factory()->create();

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->deleteJson('/api/subjects/' . $subject->id);

    $response->assertStatus(204);

    $this->assertDatabaseMissing('subjects', [
        'id' => $subject->id
    ]);
});
