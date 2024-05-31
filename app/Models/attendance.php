<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendance extends Model
{
    use HasFactory;
    protected $fillable = ['course_id', 'student_id', 'date', 'day_of_week', 'status'];

    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
