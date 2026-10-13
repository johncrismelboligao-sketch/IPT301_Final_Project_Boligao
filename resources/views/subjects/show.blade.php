@extends('layouts.app')

@section('title', $subject->name)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>{{ $subject->name }}</h2>
        <div class="btn-group">
            <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-outline-secondary">Edit</a>
            <a href="{{ route('subjects.index') }}" class="btn btn-outline-primary">Back</a>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body row g-3">
            <div class="col-md-3"><strong>Code</strong><div>{{ $subject->code }}</div></div>
            <div class="col-md-9"><strong>Description</strong><div>{{ $subject->description ?? '—' }}</div></div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="mb-3">Attendance records</h5>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Teacher</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $record)
                            <tr>
                                <td>{{ $record->student?->full_name }}</td>
                                <td>{{ $record->teacher?->full_name }}</td>
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
