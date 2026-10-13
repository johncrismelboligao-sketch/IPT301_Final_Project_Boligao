@extends('layouts.app')

@section('title', 'Edit Subject')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Edit Subject</h2>
        <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <form action="{{ route('subjects.update', $subject) }}" method="POST" class="card shadow-sm border-0 p-4">
        @csrf
        @method('PUT')
        <div class="row g-3">
            @include('partials.field', ['name' => 'code', 'label' => 'Subject Code', 'value' => $subject->code])
            @include('partials.field', ['name' => 'name', 'label' => 'Subject Name', 'value' => $subject->name])
            @include('partials.field', ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'value' => $subject->description])
        </div>

        <div class="mt-4 d-flex justify-content-end gap-2">
            <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Subject</button>
        </div>
    </form>
@endsection
