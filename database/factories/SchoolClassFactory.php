<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class SchoolClassFactory extends Factory
{
    public function definition(): array
    {
        $grade = fake()->numberBetween(7, 12);
        $section = fake()->bothify('A#');

        return [
            'name' => "Grade {$grade} - {$section}",
            'grade_level' => $grade,
            'section' => $section,
            'school_year' => '2026-2027',
            'teacher_id' => Teacher::factory(),
        ];
    }
}
