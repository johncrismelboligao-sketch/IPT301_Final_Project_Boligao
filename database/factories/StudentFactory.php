<?php

namespace Database\Factories;

use App\Models\SchoolClass;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'student_no' => '2026-' . fake()->unique()->numerify('#####'),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'gender' => fake()->randomElement(['Male', 'Female']),
            'birthdate' => fake()->dateTimeBetween('-18 years', '-12 years')->format('Y-m-d'),
            'email' => fake()->unique()->safeEmail(),
            'class_id' => SchoolClass::factory(),
        ];
    }
}
