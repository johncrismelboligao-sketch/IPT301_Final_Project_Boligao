<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AttendanceRecordController extends Controller
{
    private function rules(Request $request, ?AttendanceRecord $attendanceRecord = null): array
    {
        return [
            'student_id' => ['required', 'exists:students,id'],
            'subject_id' => [
                'required',
                'exists:subjects,id',
                Rule::unique('attendance_records')
                    ->where(fn ($query) => $query
                        ->where('student_id', $request->input('student_id'))
                        ->whereDate('date', $request->input('date')))
                    ->ignore($attendanceRecord),
            ],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'date' => ['required', 'date', 'before_or_equal:today'],
            'status' => ['required', Rule::in(AttendanceRecord::STATUSES)],
            'remarks' => ['nullable', 'string', 'max:255'],
        ];
    }

    private function messages(): array
    {
        return [
            'subject_id.unique' => 'This student already has an attendance record for this subject on that date.',
        ];
    }

    private function formData(): array
    {
        return [
            'students' => Student::with('schoolClass')->orderBy('last_name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
            'teachers' => Teacher::orderBy('last_name')->get(),
        ];
    }

    public function index(Request $request)
    {
        $records = AttendanceRecord::with(['student.schoolClass', 'subject', 'teacher'])
            ->when($request->date, fn ($query, $value) => $query->whereDate('date', $value))
            ->when($request->status, fn ($query, $value) => $query->where('status', $value))
            ->when($request->subject_id, fn ($query, $value) => $query->where('subject_id', $value))
            ->when($request->class_id, function ($query, $value) {
                $query->whereHas('student', fn ($studentQuery) => $studentQuery->where('class_id', $value));
            })
            ->latest('date')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('attendance.index', [
            'records' => $records,
            'classes' => SchoolClass::orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('attendance.create', $this->formData());
    }

    public function store(Request $request)
    {
        AttendanceRecord::create($request->validate($this->rules($request), $this->messages()));

        return redirect()->route('attendance.index')->with('success', 'Attendance record added successfully.');
    }

    public function edit(AttendanceRecord $attendanceRecord)
    {
        return view('attendance.edit', ['record' => $attendanceRecord] + $this->formData());
    }

    public function update(Request $request, AttendanceRecord $attendanceRecord)
    {
        $attendanceRecord->update($request->validate($this->rules($request, $attendanceRecord), $this->messages()));

        return redirect()->route('attendance.index')->with('success', 'Attendance record updated successfully.');
    }

    public function destroy(AttendanceRecord $attendanceRecord)
    {
        $attendanceRecord->delete();

        return redirect()->route('attendance.index')->with('success', 'Attendance record deleted.');
    }
}
