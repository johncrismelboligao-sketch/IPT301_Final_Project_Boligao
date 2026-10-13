<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    private function rules(?Teacher $teacher = null): array
    {
        return [
            'employee_no' => ['required', 'string', 'max:20', Rule::unique('teachers')->ignore($teacher)],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('teachers')->ignore($teacher)],
            'phone' => ['nullable', 'string', 'max:30'],
        ];
    }

    public function index(Request $request)
    {
        $teachers = Teacher::withCount(['classes', 'attendanceRecords'])
            ->when($request->q, function ($query, $search) {
                $query->where(function ($w) use ($search) {
                    $w->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('employee_no', 'like', "%{$search}%");
                });
            })
            ->orderBy('last_name')
            ->paginate(10)
            ->withQueryString();

        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(Request $request)
    {
        Teacher::create($request->validate($this->rules()));

        return redirect()->route('teachers.index')->with('success', 'Teacher added successfully.');
    }

    public function show(Teacher $teacher)
    {
        $teacher->load('classes.students');

        $records = $teacher->attendanceRecords()
            ->with(['student', 'subject'])
            ->latest('date')
            ->take(10)
            ->get();

        return view('teachers.show', compact('teacher', 'records'));
    }

    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $teacher->update($request->validate($this->rules($teacher)));

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        if ($teacher->classes()->exists() || $teacher->attendanceRecords()->exists()) {
            return back()->with('error', 'Cannot delete this teacher: they are an adviser or have attendance records.');
        }

        $teacher->delete();

        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }
}
