@extends('layouts.app')

@section('title', 'Edit Attendance Record')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Edit Attendance Record</h2>
        <a href="{{ route('attendance.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <form action="{{ route('attendance.update', $record) }}" method="POST" class="card shadow-sm border-0 p-4">
        @csrf
        @method('PUT')
        <div class="row g-3">
            @include('partials.select', ['name' => 'student_id', 'label' => 'Student', 'value' => $record->student_id, 'options' => $students->mapWithKeys(fn ($student) => [$student->id => $student->full_name . ' (' . $student->student_no . ')'])->all()])
            @include('partials.select', ['name' => 'subject_id', 'label' => 'Subject', 'value' => $record->subject_id, 'options' => $subjects->pluck('name', 'id')->toArray()])
            @include('partials.select', ['name' => 'teacher_id', 'label' => 'Teacher', 'value' => $record->teacher_id, 'options' => $teachers->pluck('full_name', 'id')->toArray()])
            @include('partials.field', ['name' => 'date', 'label' => 'Date', 'type' => 'date', 'value' => $record->date->format('Y-m-d')])
            @include('partials.select', ['name' => 'status', 'label' => 'Status', 'value' => $record->status, 'options' => ['Present' => 'Present', 'Absent' => 'Absent', 'Late' => 'Late', 'Excused' => 'Excused']])
            @include('partials.field', ['name' => 'remarks', 'label' => 'Remarks', 'type' => 'textarea', 'value' => $record->remarks])
        </div>

        <div class="mt-4 d-flex justify-content-end gap-2">
            <a href="{{ route('attendance.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Record</button>
        </div>
    </form>
@endsection
