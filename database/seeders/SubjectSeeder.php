<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            ['MATH-101', 'Mathematics'],
            ['ENG-101', 'English'],
            ['SCI-101', 'Science'],
            ['FIL-101', 'Filipino'],
            ['AP-101', 'Araling Panlipunan'],
            ['MAPEH-101', 'MAPEH'],
            ['TLE-101', 'Technology and Livelihood Education'],
            ['ESP-101', 'Values Education'],
        ];

        foreach ($subjects as [$code, $name]) {
            Subject::factory()->create([
                'code' => $code,
                'name' => $name,
            ]);
        }
    }
}
