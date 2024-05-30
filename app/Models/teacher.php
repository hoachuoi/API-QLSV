<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class teacher extends Model
{
    use HasFactory;
    protected $fillable =[
        'userID',
        'fullName',
        'educationalLevel',
        'nationality',
        'avatar',
        'faculty_id',
        'teacherID',
        'hometown',
        'date_of_birth',
        'gender',
    ];
    public function user()
    {
        return $this->belongsTo(user1::class, 'userID');
    }
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }
}
