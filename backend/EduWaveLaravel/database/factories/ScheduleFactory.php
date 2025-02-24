<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject_id' => \App\Models\Subject::factory(),
            'user_id' => \App\Models\User::factory(),
            'group_id' => \App\Models\Group::factory(),
            'room_id' => \App\Models\Room::factory(),
            'pairs' => $this->faker->randomDigit,
            'week_day' => $this->faker->randomDigit,
            'date' => $this->faker->date(),
        ];
    }
}
