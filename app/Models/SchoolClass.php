<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = ['name', 'grade_level', 'section', 'school_year', 'teacher_id'];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function getYearLevelLabelAttribute(): string
    {
        return match ((int) $this->grade_level) {
            1 => '1st Year',
            2 => '2nd Year',
            3 => '3rd Year',
            4 => '4th Year',
            default => "Year {$this->grade_level}",
        };
    }
}
