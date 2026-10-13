<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    private function rules(?Student $student = null): array
    {
        return [
            'student_no' => ['required', 'string', 'max:20', Rule::unique('students')->ignore($student)],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', Rule::in(['Male', 'Female'])],
            'birthdate' => ['required', 'date', 'before_or_equal:today'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('students')->ignore($student)],
            'class_id' => ['required', 'exists:classes,id'],
        ];
    }

    public function index(Request $request)
    {
        $students = Student::with('schoolClass')
            ->when($request->q, function ($query, $search) {
                $query->where(function ($w) use ($search) {
                    $w->where('student_no', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                });
            })
            ->orderBy('last_name')
            ->paginate(10)
            ->withQueryString();

        return view('students.index', compact('students'));
    }

    public function create()
    {
        $classes = SchoolClass::orderBy('name')->get();

        return view('students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        Student::create($request->validate($this->rules()));

        return redirect()->route('students.index')->with('success', 'Student added successfully.');
    }

    public function show(Student $student)
    {
        $student->load('schoolClass.teacher');

        $records = $student->attendanceRecords()
            ->with(['subject', 'teacher'])
            ->latest('date')
            ->get();

        return view('students.show', compact('student', 'records'));
    }

    public function edit(Student $student)
    {
        $classes = SchoolClass::orderBy('name')->get();

        return view('students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        $student->update($request->validate($this->rules($student)));

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
