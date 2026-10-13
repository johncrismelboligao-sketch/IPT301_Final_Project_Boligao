@extends('layouts.app')

@section('title', $student->full_name)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>{{ $student->full_name }}</h2>
        <div class="btn-group">
            <a href="{{ route('students.edit', $student) }}" class="btn btn-outline-secondary">Edit</a>
            <a href="{{ route('students.index') }}" class="btn btn-outline-primary">Back</a>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body row g-3">
            <div class="col-md-3"><strong>Student No.</strong><div>{{ $student->student_no }}</div></div>
            <div class="col-md-3"><strong>Gender</strong><div>{{ $student->gender }}</div></div>
            <div class="col-md-3"><strong>Birthdate</strong><div>{{ $student->birthdate?->format('F d, Y') }}</div></div>
            <div class="col-md-3"><strong>Email</strong><div>{{ $student->email ?? '—' }}</div></div>
            <div class="col-md-6"><strong>Class</strong><div>{{ $student->schoolClass?->name ?? '—' }}</div></div>
            <div class="col-md-6"><strong>Adviser</strong><div>{{ $student->schoolClass?->teacher?->full_name ?? '—' }}</div></div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="mb-3">Attendance records</h5>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Subject</th>
                            <th>Teacher</th>
                            <th>Status</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $record)
                            <tr>
                                <td>{{ $record->date->format('M d, Y') }}</td>
                                <td>{{ $record->subject?->name }}</td>
                                <td>{{ $record->teacher?->full_name }}</td>
                                <td><span class="badge bg-{{ $record->badgeClass() }}">{{ $record->status }}</span></td>
                                <td>{{ $record->remarks ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No attendance records available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
