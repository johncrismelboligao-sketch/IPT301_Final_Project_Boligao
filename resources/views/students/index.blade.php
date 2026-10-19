@extends('layouts.app')

@section('title', 'Students')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Students</h2>
        <a href="{{ route('students.create') }}" class="btn btn-primary">Add Student</a>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-10">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search by student number or name">
        </div>
        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-outline-secondary">Search</button>
        </div>
    </form>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Student No.</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Class</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td>{{ $student->student_no }}</td>
                            <td>{{ $student->full_name }}</td>
                            <td>{{ $student->gender }}</td>
                            <td>{{ $student->schoolClass?->name ?? '—' }}</td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-outline-primary">View</a>
                                    <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    @include('partials.delete', ['action' => route('students.destroy', $student), 'message' => 'Delete this student?'])
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No students found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $students->links('pagination::bootstrap-5') }}
    </div>
@endsection
