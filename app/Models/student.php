<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    use HasFactory;
    protected $fillable = [
        'fullName',
        'userID',
        'gender',
        'dateOfBirth',
        'nickName',
        'placeOfBirth',
        'permanenAddress',
        'avatar',
        'nationalIdentityCard',
        'ethnicity',
        'religion',
        'educationalLevel',
        'DateOffAdmissionToDTNCS',
        'policyBeneficiary',
        'contactAddress',
        'hometown',
        'studentID',
        'faculty_id',
    ];
    public function user()
    {
        return $this->belongsTo(user1::class, 'userID');
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }
    public function parents()
    {
        return $this->hasOne(parents::class, 'studentID'); // userID là khóa ngoại trong bảng students
    }
    public function courses(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(course::class);
    }
}
