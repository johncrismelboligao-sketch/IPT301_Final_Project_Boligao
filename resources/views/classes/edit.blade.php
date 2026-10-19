@extends('layouts.app')

@section('title', 'Edit Class')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Edit Class</h2>
        <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <form action="{{ route('classes.update', $schoolClass) }}" method="POST" class="card shadow-sm border-0 p-4">
        @csrf
        @method('PUT')
        <div class="row g-3">
            @include('partials.field', ['name' => 'name', 'label' => 'Class Name', 'value' => $schoolClass->name])
            @include('partials.field', ['name' => 'grade_level', 'label' => 'Year Level (1–4)', 'type' => 'number', 'min' => 1, 'max' => 4, 'value' => $schoolClass->grade_level])
            @include('partials.field', ['name' => 'section', 'label' => 'Section', 'value' => $schoolClass->section])
            @include('partials.field', ['name' => 'school_year', 'label' => 'School Year', 'value' => $schoolClass->school_year])
            @include('partials.select', ['name' => 'teacher_id', 'label' => 'Adviser', 'value' => $schoolClass->teacher_id, 'options' => $teachers->pluck('full_name', 'id')->toArray()])
        </div>

        <div class="mt-4 d-flex justify-content-end gap-2">
            <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Class</button>
        </div>
    </form>
@endsection
