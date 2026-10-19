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
        $existingClasses = SchoolClass::query()->orderBy('id')->get();
        $index = 0;

        foreach ([1, 2, 3, 4] as $yearLevel) {
            $yearName = match ($yearLevel) {
                1 => '1st Year',
                2 => '2nd Year',
                3 => '3rd Year',
                default => '4th Year',
            };

            foreach (['A', 'B'] as $section) {
                $schoolClass = $existingClasses->get($index) ?? new SchoolClass();
                $schoolClass->fill([
                    'name' => "{$yearName} - {$section}",
                    'grade_level' => $yearLevel,
                    'section' => $section,
                    'school_year' => '2026-2027',
                    'teacher_id' => $teachers->random()->id,
                ])->save();
                $index++;
            }
        }
    }
}
