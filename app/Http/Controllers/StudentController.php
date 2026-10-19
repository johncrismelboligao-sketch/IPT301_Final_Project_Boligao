<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    private function rules(?Student $student = null): array
    {
        return [
            'student_no' => ['required', 'regex:/^\d{5}$/', Rule::unique('students')->ignore($student)],
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

    private function ensureUniqueFullName(Request $request, ?Student $student = null): void
    {
        $firstName = trim((string) $request->input('first_name', ''));
        $lastName = trim((string) $request->input('last_name', ''));

        if ($firstName === '' || $lastName === '') {
            return;
        }

        $duplicateExists = Student::query()
            ->whereRaw('LOWER(first_name) = ?', [mb_strtolower($firstName)])
            ->whereRaw('LOWER(last_name) = ?', [mb_strtolower($lastName)])
            ->when($student, fn ($query) => $query->whereKeyNot($student->getKey()))
            ->exists();

        if ($duplicateExists) {
            throw ValidationException::withMessages([
                'first_name' => ['A student with this full name already exists.'],
                'last_name' => ['A student with this full name already exists.'],
            ]);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $this->ensureUniqueFullName($request, null);

        Student::create($validated);

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
        $validated = $request->validate($this->rules($student));
        $this->ensureUniqueFullName($request, $student);

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
