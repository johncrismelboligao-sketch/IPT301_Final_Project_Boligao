<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceRecordFactory extends Factory
{
    public function definition(): array
    {
        $status = fake()->randomElement(['Present', 'Present', 'Present', 'Present', 'Present', 'Late', 'Absent', 'Excused']);

        return [
            'student_id' => Student::factory(),
            'subject_id' => Subject::factory(),
            'teacher_id' => Teacher::factory(),
            'date' => fake()->dateTimeBetween('-2 weeks', 'now')->format('Y-m-d'),
            'status' => $status,
            'remarks' => $status === 'Present' ? null : fake()->randomElement(['Sick', 'Family emergency', 'Traffic', 'Doctor appointment', null]),
        ];
    }
}
