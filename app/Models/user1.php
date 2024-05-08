<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user1 extends Model
{
    use HasFactory;
    protected $fillable = [
        'username',
        'email',
        'phoneNumber',
        'email',
        'password',
        'roleID'
    ];
    public function role()
    {
        return $this->belongsTo(role::class, 'roleID');
    }
    public function student()
    {
        return $this->hasOne(Student::class, 'userID'); // userID là khóa ngoại trong bảng students
    }
}
