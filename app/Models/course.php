<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'IDcourse',
        'start_time',
        'end_time',
        'date_of_week',
        'faculty_id',
        'teacher_id',
        'subject_id',
        'semester_id',
        'classroom_id',
        'week'
    ];
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(student::class, 'course_students', 'course_id','student_id' );
    }
    // Các quan hệ
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    // Accessor để lấy giá trị enum
    public function getDateOfWeekAttribute($value)
    {
        return $value;
    }
}
