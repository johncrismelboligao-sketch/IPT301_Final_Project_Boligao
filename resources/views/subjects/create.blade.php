@extends('layouts.app')

@section('title', 'Add Subject')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Add Subject</h2>
        <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <form action="{{ route('subjects.store') }}" method="POST" class="card shadow-sm border-0 p-4">
        @csrf
        <div class="row g-3">
            @include('partials.field', ['name' => 'code', 'label' => 'Subject Code'])
            @include('partials.field', ['name' => 'name', 'label' => 'Subject Name'])
            @include('partials.field', ['name' => 'description', 'label' => 'Description', 'type' => 'textarea'])
        </div>

        <div class="mt-4 d-flex justify-content-end gap-2">
            <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Subject</button>
        </div>
    </form>
@endsection
