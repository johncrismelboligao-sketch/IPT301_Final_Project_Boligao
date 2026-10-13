@extends('layouts.app')

@section('title', 'Add Teacher')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Add Teacher</h2>
        <a href="{{ route('teachers.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <form action="{{ route('teachers.store') }}" method="POST" class="card shadow-sm border-0 p-4">
        @csrf
        <div class="row g-3">
            @include('partials.field', ['name' => 'employee_no', 'label' => 'Employee Number'])
            @include('partials.field', ['name' => 'first_name', 'label' => 'First Name'])
            @include('partials.field', ['name' => 'last_name', 'label' => 'Last Name'])
            @include('partials.field', ['name' => 'email', 'label' => 'Email', 'type' => 'email'])
            @include('partials.field', ['name' => 'phone', 'label' => 'Phone'])
        </div>

        <div class="mt-4 d-flex justify-content-end gap-2">
            <a href="{{ route('teachers.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Teacher</button>
        </div>
    </form>
@endsection
