<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = [
            ['Jhon Lyod', 'Catalan'],
            ['Ricardo Jr', 'Rosco'],
            ['Sheryl', 'Enriquez'],
            ['Jhon Lyod', 'Catalan'],
            ['Jhon Lyod', 'Catalan'],
            ['Christine May', 'Jabal'],
            ['Jhon Lyod', 'Catalan'],
            ['Emeteria', 'Ighot'],
        ];

        foreach ($teachers as $index => [$firstName, $lastName]) {
            $teacher = Teacher::query()->orderBy('id')->skip($index)->first();

            if ($teacher) {
                $teacher->update([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                ]);

                continue;
            }

            Teacher::factory()->create([
                'employee_no' => sprintf('T-%04d', $index + 1),
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => sprintf('teacher%04d@school.test', $index + 1),
            ]);
        }
    }
}
