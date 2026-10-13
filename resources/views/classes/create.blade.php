@extends('layouts.app')

@section('title', 'Add Class')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Add Class</h2>
        <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <form action="{{ route('classes.store') }}" method="POST" class="card shadow-sm border-0 p-4">
        @csrf
        <div class="row g-3">
            @include('partials.field', ['name' => 'name', 'label' => 'Class Name'])
            @include('partials.field', ['name' => 'grade_level', 'label' => 'Grade Level', 'type' => 'number', 'max' => 12])
            @include('partials.field', ['name' => 'section', 'label' => 'Section'])
            @include('partials.field', ['name' => 'school_year', 'label' => 'School Year', 'value' => '2026-2027'])
            @include('partials.select', ['name' => 'teacher_id', 'label' => 'Adviser', 'options' => $teachers->pluck('full_name', 'id')->toArray()])
        </div>

        <div class="mt-4 d-flex justify-content-end gap-2">
            <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Class</button>
        </div>
    </form>
@endsection
