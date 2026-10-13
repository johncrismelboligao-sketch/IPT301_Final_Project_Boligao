@extends('layouts.app')

@section('title', 'Teachers')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Teachers</h2>
        <a href="{{ route('teachers.create') }}" class="btn btn-primary">Add Teacher</a>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-10">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search teacher or employee number">
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
                        <th>Employee #</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Classes</th>
                        <th>Records</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($teachers as $teacher)
                        <tr>
                            <td>{{ $teacher->employee_no }}</td>
                            <td>{{ $teacher->full_name }}</td>
                            <td>{{ $teacher->email }}</td>
                            <td>{{ $teacher->classes_count }}</td>
                            <td>{{ $teacher->attendance_records_count }}</td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="{{ route('teachers.show', $teacher) }}" class="btn btn-sm btn-outline-primary">View</a>
                                    <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    @include('partials.delete', ['action' => route('teachers.destroy', $teacher), 'message' => 'Delete this teacher?'])
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No teachers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $teachers->links() }}
    </div>
@endsection
