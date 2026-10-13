<?php

namespace Tests\Feature;

use App\Models\AttendanceRecord;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_attendance_can_be_created_updated_and_deleted(): void
    {
        $teacher = Teacher::factory()->create();
        $schoolClass = SchoolClass::factory()->create(['teacher_id' => $teacher->id]);
        $student = Student::factory()->create(['class_id' => $schoolClass->id]);
        $subject = Subject::factory()->create();
        $date = now()->toDateString();

        $this->post(route('attendance.store'), [
            'student_id' => $student->id,
            'subject_id' => $subject->id,
            'teacher_id' => $teacher->id,
            'date' => $date,
            'status' => 'Present',
            'remarks' => null,
        ])->assertRedirect(route('attendance.index'));

        $record = AttendanceRecord::firstOrFail();
        $this->assertDatabaseHas('attendance_records', [
            'id' => $record->id,
            'student_id' => $student->id,
            'subject_id' => $subject->id,
            'status' => 'Present',
        ]);

        $this->put(route('attendance.update', $record), [
            'student_id' => $student->id,
            'subject_id' => $subject->id,
            'teacher_id' => $teacher->id,
            'date' => $date,
            'status' => 'Late',
            'remarks' => 'Arrived late',
        ])->assertRedirect(route('attendance.index'));

        $this->assertDatabaseHas('attendance_records', [
            'id' => $record->id,
            'status' => 'Late',
            'remarks' => 'Arrived late',
        ]);

        $this->delete(route('attendance.destroy', $record))
            ->assertRedirect(route('attendance.index'));

        $this->assertDatabaseMissing('attendance_records', ['id' => $record->id]);
    }

    public function test_a_student_cannot_have_two_records_for_the_same_subject_and_date(): void
    {
        $teacher = Teacher::factory()->create();
        $schoolClass = SchoolClass::factory()->create(['teacher_id' => $teacher->id]);
        $student = Student::factory()->create(['class_id' => $schoolClass->id]);
        $subject = Subject::factory()->create();
        $date = now()->toDateString();

        AttendanceRecord::factory()->create([
            'student_id' => $student->id,
            'subject_id' => $subject->id,
            'teacher_id' => $teacher->id,
            'date' => $date,
        ]);

        $this->from(route('attendance.create'))
            ->post(route('attendance.store'), [
                'student_id' => $student->id,
                'subject_id' => $subject->id,
                'teacher_id' => $teacher->id,
                'date' => $date,
                'status' => 'Absent',
            ])
            ->assertRedirect(route('attendance.create'))
            ->assertSessionHasErrors('subject_id');

        $this->assertDatabaseCount('attendance_records', 1);
    }
}
