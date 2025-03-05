<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create predefined rooms
        $rooms = [
            'A101',
            'A102',
            'B201',
            'B202',
            'C301',
            'C302',
            'D401',
            'D402',
            'LAB101',
            'LAB102',
        ];

        foreach ($rooms as $room) {
            Room::factory()->create([
                'name' => $room,
            ]);
        }

        // Create some random rooms
        Room::factory()->count(5)->create();
    }
}
