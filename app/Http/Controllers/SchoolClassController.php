<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SchoolClassController extends Controller
{
    private function rules(Request $request, ?SchoolClass $schoolClass = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'grade_level' => ['required', 'integer', 'between:1,4'],
            'section' => [
                'required', 'string', 'max:50',
                Rule::unique('classes')
                    ->where(fn ($query) => $query
                        ->where('grade_level', $request->grade_level)
                        ->where('school_year', $request->school_year))
                    ->ignore($schoolClass),
            ],
            'school_year' => ['required', 'regex:/^\d{4}-\d{4}$/'],
            'teacher_id' => ['required', 'exists:teachers,id'],
        ];
    }

    public function index(Request $request)
    {
        $classes = SchoolClass::with('teacher')
            ->when($request->q, function ($query, $search) {
                $query->where(function ($w) use ($search) {
                    $w->where('name', 'like', "%{$search}%")
                        ->orWhere('section', 'like', "%{$search}%")
                        ->orWhere('school_year', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(5)
            ->withQueryString();

        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        $teachers = Teacher::orderBy('last_name')->get();

        return view('classes.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        SchoolClass::create($request->validate($this->rules($request)));

        return redirect()->route('classes.index')->with('success', 'Class added successfully.');
    }

    public function show(SchoolClass $schoolClass)
    {
        $schoolClass->load('teacher', 'students.attendanceRecords.subject');

        $records = $schoolClass->students()->with('attendanceRecords.subject')->get()
            ->flatMap(fn ($student) => $student->attendanceRecords)
            ->sortByDesc('date')
            ->take(15)
            ->values();

        return view('classes.show', compact('schoolClass', 'records'));
    }

    public function edit(SchoolClass $schoolClass)
    {
        $teachers = Teacher::orderBy('last_name')->get();

        return view('classes.edit', compact('schoolClass', 'teachers'));
    }

    public function update(Request $request, SchoolClass $schoolClass)
    {
        $schoolClass->update($request->validate($this->rules($request, $schoolClass)));

        return redirect()->route('classes.index')->with('success', 'Class updated successfully.');
    }

    public function destroy(SchoolClass $schoolClass)
    {
        if ($schoolClass->students()->exists()) {
            return back()->with('error', 'Cannot delete this class: it still has students assigned to it.');
        }

        $schoolClass->delete();

        return redirect()->route('classes.index')->with('success', 'Class deleted successfully.');
    }
}
