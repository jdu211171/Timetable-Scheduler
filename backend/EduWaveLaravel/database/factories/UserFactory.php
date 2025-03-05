<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Determine if this is a student or teacher based on a random choice
        $isTeacher = $this->faker->boolean(30); // 30% chance of being a teacher
        $prefix = $isTeacher ? 'TE' : 'ST';

        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'unique_id' => $prefix . $this->faker->unique()->regexify('[0-9]{5}'),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => $isTeacher ? 'teacher' : 'student', // Add custom role attribute
        ];
    }

    /**
     * Indicate that the user is a student.
     */
    public function student(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'student',
                'unique_id' => 'ST' . $this->faker->unique()->regexify('[0-9]{5}'),
            ];
        });
    }

    /**
     * Indicate that the user is a teacher.
     */
    public function teacher(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'teacher',
                'unique_id' => 'TE' . $this->faker->unique()->regexify('[0-9]{5}'),
            ];
        });
    }

    /**
     * Indicate that the user is an admin.
     */
    public function admin(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'admin',
                'unique_id' => 'AD' . $this->faker->unique()->regexify('[0-9]{5}'),
            ];
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
