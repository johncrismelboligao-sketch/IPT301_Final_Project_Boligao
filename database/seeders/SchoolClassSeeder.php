<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class SchoolClassSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = Teacher::all();

        for ($i = 0; $i < 6; $i++) {
            $grade = 7 + $i;

            SchoolClass::factory()->create([
                'name' => "Grade {$grade} - A",
                'grade_level' => $grade,
                'section' => 'A',
                'school_year' => '2026-2027',
                'teacher_id' => $teachers->random()->id,
            ]);
        }
    }
}
