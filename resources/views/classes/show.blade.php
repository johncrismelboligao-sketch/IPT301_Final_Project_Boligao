@extends('layouts.app')

@section('title', $schoolClass->name)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>{{ $schoolClass->name }}</h2>
        <div class="btn-group">
            <a href="{{ route('classes.edit', $schoolClass) }}" class="btn btn-outline-secondary">Edit</a>
            <a href="{{ route('classes.index') }}" class="btn btn-outline-primary">Back</a>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body row g-3">
            <div class="col-md-3"><strong>Grade Level</strong><div>{{ $schoolClass->grade_level }}</div></div>
            <div class="col-md-3"><strong>Section</strong><div>{{ $schoolClass->section }}</div></div>
            <div class="col-md-3"><strong>School Year</strong><div>{{ $schoolClass->school_year }}</div></div>
            <div class="col-md-3"><strong>Adviser</strong><div>{{ $schoolClass->teacher?->full_name ?? '—' }}</div></div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="mb-3">Students</h5>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Student No.</th>
                            <th>Name</th>
                            <th>Gender</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($schoolClass->students as $student)
                            <tr>
                                <td>{{ $student->student_no }}</td>
                                <td>{{ $student->full_name }}</td>
                                <td>{{ $student->gender }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">No students assigned.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mt-4">
        <div class="card-body">
            <h5 class="mb-3">Recent attendance</h5>
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
                                <td colspan="4" class="text-center text-muted">No attendance records yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
