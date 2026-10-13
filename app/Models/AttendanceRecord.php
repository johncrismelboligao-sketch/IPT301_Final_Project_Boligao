<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceRecord extends Model
{
    use HasFactory;

    public const STATUSES = ['Present', 'Absent', 'Late', 'Excused'];

    protected $fillable = ['student_id', 'subject_id', 'teacher_id', 'date', 'status', 'remarks'];

    protected $casts = ['date' => 'date'];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function badgeClass(): string
    {
        return match ($this->status) {
            'Present' => 'success',
            'Absent' => 'danger',
            'Late' => 'warning',
            default => 'info',
        };
    }
}
