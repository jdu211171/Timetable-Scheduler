<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create predefined groups
        $groups = [
            'CS-101',
            'Math-202',
            'Physics-101',
            'Biology-303',
            'Chemistry-101',
            'Engineering-404',
            'AI-505',
            'Data Science-606',
        ];

        foreach ($groups as $group) {
            Group::factory()->create([
                'name' => $group . ' Group',
            ]);
        }

        // Create some random groups
        Group::factory()->count(5)->create();
    }
}
