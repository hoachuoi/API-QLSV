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
    ];
    public function user()
    {
        return $this->belongsTo(user1::class, 'userID');
    }
    public function parents()
    {
        return $this->hasOne(parents::class, 'studentID'); // userID là khóa ngoại trong bảng students
    }
}
