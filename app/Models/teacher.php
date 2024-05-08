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
        'avatar'
    ];
    public function user()
    {
        return $this->belongsTo(user1::class, 'userID');
    }
}
