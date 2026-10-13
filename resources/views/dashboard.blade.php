@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h2 class="mb-4">School Attendance Management System</h2>

    <div class="row g-3 mb-4">
        @foreach([
            ['Students', $counts['students'], 'students.index', 'primary'],
            ['Classes', $counts['classes'], 'classes.index', 'success'],
            ['Subjects', $counts['subjects'], 'subjects.index', 'warning'],
            ['Teachers', $counts['teachers'], 'teachers.index', 'info'],
            ['Attendance Records', $counts['records'], 'attendance.index', 'secondary'],
        ] as [$label, $count, $route, $color])
            <div class="col-6 col-md">
                <a href="{{ route($route) }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="text-{{ $color }} fw-bold display-6">{{ $count }}</div>
                            <div class="text-muted">{{ $label }}</div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    @if ($latestDate)
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="card-title">Latest attendance summary ({{ $latestDate->format('F d, Y') }})</h5>
                <div class="row g-3 mt-1">
                    @php($statuses = ['Present', 'Absent', 'Late', 'Excused'])
                    @foreach ($statuses as $status)
                        <div class="col-md-3">
                            <div class="border rounded p-3 h-100">
                                <div class="fw-semibold text-uppercase small text-muted">{{ $status }}</div>
                                <div class="display-6 mb-0">{{ $stats[$status] ?? 0 }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="card-title mb-3">Recent attendance</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Subject</th>
                            <th>Teacher</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recent as $record)
                            <tr>
                                <td>{{ $record->student?->full_name }}</td>
                                <td>{{ $record->subject?->name }}</td>
                                <td>{{ $record->teacher?->full_name }}</td>
                                <td>{{ $record->date?->format('M d, Y') }}</td>
                                <td><span class="badge bg-{{ $record->badgeClass() }} text-uppercase">{{ $record->status }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No attendance records yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
