<?php

namespace Database\Seeders;

use App\Models\AttendanceRecord;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class AttendanceRecordSeeder extends Seeder
{
    public function run(): void
    {
        $dates = collect();
        $day = now();

        while ($dates->count() < 7) {
            if ($day->isWeekday()) {
                $dates->push($day->format('Y-m-d'));
            }
            $day = $day->copy()->subDay();
        }

        $subjects = Subject::all();
        $teachers = Teacher::all();

        foreach (SchoolClass::with('students')->get() as $class) {
            foreach ($class->students as $student) {
                foreach ($dates as $date) {
                    $existingSubjectIds = AttendanceRecord::query()
                        ->where('student_id', $student->id)
                        ->whereDate('date', $date)
                        ->pluck('subject_id');
                    $subjectsToAdd = $subjects
                        ->whereNotIn('id', $existingSubjectIds)
                        ->take(max(0, 2 - $existingSubjectIds->count()));

                    foreach ($subjectsToAdd as $subject) {
                        AttendanceRecord::create([
                            'student_id' => $student->id,
                            'subject_id' => $subject->id,
                            'teacher_id' => $teachers->random()->id,
                            'date' => $date,
                            'status' => fake()->randomElement(['Present', 'Present', 'Present', 'Present', 'Present', 'Late', 'Absent', 'Excused']),
                            'remarks' => fake()->randomElement(['Sick', 'Family emergency', 'Traffic', 'Doctor appointment', null]),
                        ]);
                    }
                }
            }
        }
    }
}
