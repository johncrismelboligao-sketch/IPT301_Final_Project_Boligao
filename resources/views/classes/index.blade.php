@extends('layouts.app')

@section('title', 'Classes')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Classes</h2>
        <a href="{{ route('classes.create') }}" class="btn btn-primary">Add Class</a>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-10">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search classes">
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
                        <th>Name</th>
                        <th>Year Level</th>
                        <th>Section</th>
                        <th>School Year</th>
                        <th>Adviser</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($classes as $class)
                        <tr>
                            <td>{{ $class->name }}</td>
                            <td>{{ $class->year_level_label }}</td>
                            <td>{{ $class->section }}</td>
                            <td>{{ $class->school_year }}</td>
                            <td>{{ $class->teacher?->full_name ?? '—' }}</td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="{{ route('classes.show', $class) }}" class="btn btn-sm btn-outline-primary">View</a>
                                    <a href="{{ route('classes.edit', $class) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    @include('partials.delete', ['action' => route('classes.destroy', $class), 'message' => 'Delete this class?'])
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No classes found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $classes->links('pagination::bootstrap-5') }}
    </div>
@endsection
