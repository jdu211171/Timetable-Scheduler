<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First ensure we have the role column in the users table
        if (!$this->columnExists('users', 'role')) {
            DB::statement('ALTER TABLE users ADD COLUMN role VARCHAR(50) NULL');
        }

        // Create an admin user
        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'unique_id' => 'AD00001',
            'role' => 'admin',
        ]);

        // Create teachers
        User::factory()->count(5)->teacher()->create();

        // Create students
        User::factory()->count(20)->student()->create();

        // Create some random users with mixed roles
        User::factory()->count(10)->create();
    }

    /**
     * Check if a column exists in a table
     */
    private function columnExists($table, $column)
    {
        return DB::connection()->getSchemaBuilder()->hasColumn($table, $column);
    }
}
