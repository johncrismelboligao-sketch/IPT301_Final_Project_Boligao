@extends('layouts.app')

@section('title', 'Edit Teacher')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Edit Teacher</h2>
        <a href="{{ route('teachers.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <form action="{{ route('teachers.update', $teacher) }}" method="POST" class="card shadow-sm border-0 p-4">
        @csrf
        @method('PUT')
        <div class="row g-3">
            @include('partials.field', ['name' => 'employee_no', 'label' => 'Employee Number', 'value' => $teacher->employee_no])
            @include('partials.field', ['name' => 'first_name', 'label' => 'First Name', 'value' => $teacher->first_name])
            @include('partials.field', ['name' => 'last_name', 'label' => 'Last Name', 'value' => $teacher->last_name])
            @include('partials.field', ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'value' => $teacher->email])
            @include('partials.field', ['name' => 'phone', 'label' => 'Phone', 'value' => $teacher->phone])
        </div>

        <div class="mt-4 d-flex justify-content-end gap-2">
            <a href="{{ route('teachers.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Teacher</button>
        </div>
    </form>
@endsection
