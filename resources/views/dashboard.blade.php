@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    @php
        $latestTotal = collect($stats)->sum();
        $presentCount = $stats['Present'] ?? 0;
        $presentRate = $latestTotal > 0 ? (int) round(($presentCount / $latestTotal) * 100) : 0;
        $statusColors = ['Present' => 'present', 'Late' => 'late', 'Excused' => 'excused', 'Absent' => 'absent'];
    @endphp

    <header class="page-heading dashboard-heading">
        <div>
            <h1>Dashboard</h1>
            <p>Attendance overview for {{ now()->format('F j, Y') }}</p>
        </div>
        <div class="attendance-rate">
            <strong>{{ $presentRate }}%</strong>
            <span>Present rate{{ $latestDate ? ' on ' . $latestDate->format('M j') : '' }}</span>
        </div>
    </header>

    <section class="dashboard-stats" aria-label="System totals">
        @foreach([
            ['Students', $counts['students'], 'students.index'],
            ['Classes', $counts['classes'], 'classes.index'],
            ['Subjects', $counts['subjects'], 'subjects.index'],
            ['Teachers', $counts['teachers'], 'teachers.index'],
            ['Attendance records', $counts['records'], 'attendance.index'],
        ] as [$label, $count, $route])
            <a href="{{ route($route) }}" class="stat-card">
                <strong>{{ $count }}</strong>
                <span>{{ $label }}</span>
            </a>
        @endforeach
    </section>

    <section class="panel-card summary-panel">
        <div class="panel-heading">
            <h2>Latest attendance summary</h2>
            <span>{{ $latestDate?->format('F j, Y') ?? 'No attendance recorded' }}</span>
        </div>
        <div class="status-bar" role="img" aria-label="Attendance status distribution">
            @foreach($statusColors as $status => $color)
                @php($amount = $stats[$status] ?? 0)
                @if($latestTotal > 0 && $amount > 0)
                    <span class="status-bar-{{ $color }}" style="width: {{ ($amount / $latestTotal) * 100 }}%"></span>
                @endif
            @endforeach
        </div>
        <div class="status-summary">
            @foreach($statusColors as $status => $color)
                <div class="status-count status-count-{{ $color }}">
                    <strong>{{ $stats[$status] ?? 0 }}</strong>
                    <span>{{ $status }}</span>
                </div>
            @endforeach
        </div>
    </section>

    <section class="panel-card recent-panel">
        <div class="panel-heading">
            <h2>Recent attendance</h2>
            <a class="text-link" href="{{ route('attendance.index') }}">View all</a>
        </div>
        <div class="recent-filters">
            <input id="recentSearch" type="search" class="form-control" placeholder="Search student, subject or teacher" aria-label="Search recent attendance">
            <select id="recentStatus" class="form-select" aria-label="Filter by status">
                <option value="">All statuses</option>
                @foreach (App\Models\AttendanceRecord::STATUSES as $status)
                    <option value="{{ strtolower($status) }}">{{ $status }}</option>
                @endforeach
            </select>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 dashboard-table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Subject</th>
                        <th>Teacher</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="recentRows">
                    @forelse ($recent as $record)
                        <tr data-status="{{ strtolower($record->status) }}">
                            <td>{{ $record->student?->full_name }}</td>
                            <td>{{ $record->subject?->name }}</td>
                            <td>{{ $record->teacher?->full_name }}</td>
                            <td>{{ $record->date?->format('M d, Y') }}</td>
                            <td><span class="badge status-badge status-{{ strtolower($record->status) }}">{{ $record->status }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="empty-state">No attendance records yet.</td></tr>
                    @endforelse
                    <tr id="recentNoMatches" hidden><td colspan="5" class="empty-state">No matching attendance records.</td></tr>
                </tbody>
            </table>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const recentSearch = document.getElementById('recentSearch');
        const recentStatus = document.getElementById('recentStatus');
        const recentRows = [...document.querySelectorAll('#recentRows tr[data-status]')];
        const recentNoMatches = document.getElementById('recentNoMatches');

        function filterRecentAttendance() {
            const query = recentSearch.value.trim().toLowerCase();
            const status = recentStatus.value;
            let visible = 0;

            recentRows.forEach((row) => {
                const matches = row.textContent.toLowerCase().includes(query)
                    && (!status || row.dataset.status === status);
                row.hidden = !matches;
                if (matches) visible++;
            });

            recentNoMatches.hidden = visible > 0 || recentRows.length === 0;
        }

        recentSearch.addEventListener('input', filterRecentAttendance);
        recentStatus.addEventListener('change', filterRecentAttendance);
    </script>
@endpush
