@extends('layouts.app')

@section('title', $teacher->full_name)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>{{ $teacher->full_name }}</h2>
        <div class="btn-group">
            <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-outline-secondary">Edit</a>
            <a href="{{ route('teachers.index') }}" class="btn btn-outline-primary">Back</a>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body row g-3">
            <div class="col-md-3"><strong>Employee #</strong><div>{{ $teacher->employee_no }}</div></div>
            <div class="col-md-3"><strong>Email</strong><div>{{ $teacher->email }}</div></div>
            <div class="col-md-3"><strong>Phone</strong><div>{{ $teacher->phone ?? '—' }}</div></div>
            <div class="col-md-3"><strong>Classes Handled</strong><div>{{ $teacher->classes()->count() }}</div></div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5 class="mb-3">Classes assigned</h5>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Class</th>
                            <th>Year</th>
                            <th>Students</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($teacher->classes as $class)
                            <tr>
                                <td>{{ $class->name }}</td>
                                <td>{{ $class->school_year }}</td>
                                <td>{{ $class->students()->count() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">No assigned classes.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="mb-3">Recent attendance records</h5>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Subject</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $record)
                            <tr>
                                <td>{{ $record->student?->full_name }}</td>
                                <td>{{ $record->subject?->name }}</td>
                                <td>{{ $record->date->format('M d, Y') }}</td>
                                <td><span class="badge bg-{{ $record->badgeClass() }}">{{ $record->status }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No records yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
