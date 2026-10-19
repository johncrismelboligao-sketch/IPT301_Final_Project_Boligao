<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            ['IPT 301', 'Integrative Programming & Technologies 1'],
            ['NET 301', 'Networking 2'],
            ['IM 301', 'Information Management 2'],
            ['WS 301', 'Web Systems & Technologies'],
            ['DC 301', 'Domain Course 3'],
            ['DC 302', 'Domain Course 4'],
            ['CC 302', 'Applications Development & Emerging Technologies'],
            ['GE ELEC 02', 'Philippine Indigenous Community'],
        ];

        // Update existing rows by their stable order so attendance records keep
        // pointing to the same subjects when the catalog is renamed.
        $existingSubjects = Subject::query()->orderBy('id')->get();

        foreach ($subjects as $index => [$code, $name]) {
            $subject = $existingSubjects->get($index) ?? new Subject();
            $subject->fill([
                'code' => $code,
                'name' => $name,
            ]);
            $subject->save();
        }
    }
}
