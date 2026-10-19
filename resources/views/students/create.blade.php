@extends('layouts.app')

@section('title', 'Add Student')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Add Student</h2>
        <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <form action="{{ route('students.store') }}" method="POST" class="card shadow-sm border-0 p-4">
        @csrf
        <div class="row g-3">
            @include('partials.field', ['name' => 'student_no', 'label' => 'Student Number (5 digits)', 'maxlength' => 5, 'pattern' => '[0-9]{5}'])
            @include('partials.field', ['name' => 'first_name', 'label' => 'First Name'])
            @include('partials.field', ['name' => 'last_name', 'label' => 'Last Name'])
            @include('partials.select', ['name' => 'gender', 'label' => 'Gender', 'options' => ['Male' => 'Male', 'Female' => 'Female']])
            @include('partials.field', ['name' => 'birthdate', 'label' => 'Birthdate', 'type' => 'date'])
            @include('partials.field', ['name' => 'email', 'label' => 'Email', 'type' => 'email'])
            @include('partials.select', ['name' => 'class_id', 'label' => 'Class', 'options' => $classes->pluck('name', 'id')->toArray()])
        </div>

        <div class="mt-4 d-flex justify-content-end gap-2">
            <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Student</button>
        </div>
    </form>
@endsection
