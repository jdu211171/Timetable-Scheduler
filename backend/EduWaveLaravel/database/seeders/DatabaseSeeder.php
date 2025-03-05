<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            GroupSeeder::class,
            RoomSeeder::class,
            SubjectSeeder::class,
            ScheduleSeeder::class,
            RelationshipSeeder::class,
        ]);
    }
}
