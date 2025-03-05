<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an admin user
        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'unique_id' => 'AD00001',
        ]);

        // Create teachers
        User::factory()->count(5)->teacher()->create();

        // Create students
        User::factory()->count(20)->student()->create();

        // Create some random users with mixed roles
        User::factory()->count(10)->create();
    }
}
