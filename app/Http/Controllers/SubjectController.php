<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubjectController extends Controller
{
    private function rules(?Subject $subject = null): array
    {
        return [
            'code' => ['required', 'string', 'max:20', Rule::unique('subjects')->ignore($subject)],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function index(Request $request)
    {
        $subjects = Subject::withCount('attendanceRecords')
            ->when($request->q, function ($query, $search) {
                $query->where(function ($w) use ($search) {
                    $w->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('subjects.create');
    }

    public function store(Request $request)
    {
        Subject::create($request->validate($this->rules()));

        return redirect()->route('subjects.index')->with('success', 'Subject added successfully.');
    }

    public function show(Subject $subject)
    {
        $records = $subject->attendanceRecords()
            ->with(['student', 'teacher'])
            ->latest('date')
            ->take(15)
            ->get();

        return view('subjects.show', compact('subject', 'records'));
    }

    public function edit(Subject $subject)
    {
        return view('subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $subject->update($request->validate($this->rules($subject)));

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        if ($subject->attendanceRecords()->exists()) {
            return back()->with('error', 'Cannot delete this subject: it has attendance records.');
        }

        $subject->delete();

        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully.');
    }
}
