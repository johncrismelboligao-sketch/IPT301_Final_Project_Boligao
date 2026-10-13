@extends('layouts.app')

@section('title', 'Subjects')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Subjects</h2>
        <a href="{{ route('subjects.create') }}" class="btn btn-primary">Add Subject</a>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-10">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search by subject code or name">
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
                        <th>Code</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($subjects as $subject)
                        <tr>
                            <td>{{ $subject->code }}</td>
                            <td>{{ $subject->name }}</td>
                            <td>{{ Str::limit($subject->description ?? '', 50) }}</td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="{{ route('subjects.show', $subject) }}" class="btn btn-sm btn-outline-primary">View</a>
                                    <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    @include('partials.delete', ['action' => route('subjects.destroy', $subject), 'message' => 'Delete this subject?'])
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No subjects found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $subjects->links() }}
    </div>
@endsection
