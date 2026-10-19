<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Database\Seeder;
use RuntimeException;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            ['John Crismel', 'Boligao', 'john.boligao@student.test'],
            ['Axl', 'Montuya', 'axl.montuya@student.test'],
            ['Klint', 'Taylaran', 'klint.taylaran@student.test'],
            ['Matt', 'Omus', 'matt.omus@student.test'],
            ['Jasmin', 'Omus', 'jasmin.omus@student.test'],
            ['John Sarge', 'Andamon', 'johnsarge.andamon@student.test'],
            ['Paya', 'Corsiga', 'paya.corsiga@student.test'],
            ['Jhon Mark', 'Orongan', 'jhonmark.orongan@student.test'],
        ];

        $classes = SchoolClass::query()->orderBy('id')->take(count($students))->get();

        if ($classes->count() < count($students)) {
            throw new RuntimeException('Create at least four classes before seeding the student roster.');
        }

        foreach ($students as $index => [$firstName, $lastName, $email]) {
            $studentNo = sprintf('2026-%05d', $index + 1);
            $student = Student::query()->firstOrNew(['student_no' => $studentNo]);

            if (! $student->exists) {
                $student = Student::factory()->make([
                    'student_no' => $studentNo,
                    'class_id' => $classes[$index]->id,
                ]);
            }

            $student->fill([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'class_id' => $classes[$index]->id,
            ])->save();
        }
    }
}
