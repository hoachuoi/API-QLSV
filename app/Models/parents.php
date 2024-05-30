<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class parents extends Model
{
    use HasFactory;
    public function student()
    {
        return $this->belongsTo(Student::class, 'studentID'); // studentID là khóa ngoại trong bảng parents
    }

    protected $fillable =[
        'fullName',
        'professtion',
        'gender',
        'phoneNumber',
        'studentID'

    ];
}
