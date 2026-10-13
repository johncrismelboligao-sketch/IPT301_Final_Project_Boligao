@extends('layouts.app')

@section('title', 'Attendance')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Attendance Records</h2>
        <a href="{{ route('attendance.create') }}" class="btn btn-primary">Add Record</a>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <input type="date" name="date" value="{{ request('date') }}" class="form-control">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All statuses</option>
                @foreach (App\Models\AttendanceRecord::STATUSES as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="subject_id" class="form-select">
                <option value="">All subjects</option>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}" @selected((string) request('subject_id') === (string) $subject->id)>{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="class_id" class="form-select">
                <option value="">All classes</option>
                @foreach ($classes as $class)
                    <option value="{{ $class->id }}" @selected((string) request('class_id') === (string) $class->id)>{{ $class->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 d-flex gap-2">
            <button type="submit" class="btn btn-outline-secondary">Filter</button>
            <a href="{{ route('attendance.index') }}" class="btn btn-outline-light border">Reset</a>
        </div>
    </form>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Subject</th>
                        <th>Teacher</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Remarks</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($records as $record)
                        <tr>
                            <td>{{ $record->student?->full_name }}</td>
                            <td>{{ $record->subject?->name }}</td>
                            <td>{{ $record->teacher?->full_name }}</td>
                            <td>{{ $record->date->format('M d, Y') }}</td>
                            <td><span class="badge bg-{{ $record->badgeClass() }}">{{ $record->status }}</span></td>
                            <td>{{ $record->remarks ?? '—' }}</td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="{{ route('attendance.edit', $record) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    @include('partials.delete', ['action' => route('attendance.destroy', $record), 'message' => 'Delete this attendance record?'])
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No attendance records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $records->links() }}
    </div>
@endsection
