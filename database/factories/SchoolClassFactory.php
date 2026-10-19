<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class SchoolClassFactory extends Factory
{
    public function definition(): array
    {
        $yearLevel = fake()->numberBetween(1, 4);
        $section = fake()->bothify('A#');
        $yearName = match ($yearLevel) {
            1 => '1st Year',
            2 => '2nd Year',
            3 => '3rd Year',
            default => '4th Year',
        };

        return [
            'name' => "{$yearName} - {$section}",
            'grade_level' => $yearLevel,
            'section' => $section,
            'school_year' => '2026-2027',
            'teacher_id' => Teacher::factory(),
        ];
    }
}
